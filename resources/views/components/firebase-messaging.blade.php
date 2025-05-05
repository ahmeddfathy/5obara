
<script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js"></script>

<script>
    (function() {
        if (window.fcmInitialized) return;
        window.fcmInitialized = true;

        const firebaseConfig = {
            apiKey: "AIzaSyDogvkqx7SBVGiQVSbHwzggMWVQ35RtID4",
            authDomain: "obara-6a959.firebaseapp.com",
            projectId: "obara-6a959",
            storageBucket: "obara-6a959.firebasestorage.app",
            messagingSenderId: "1037969361",
            appId: "1:1037969361:web:4a114005466f296ba6e2f0",
            measurementId: "G-MLQZPGVXP7"
        };

        let firebaseApp;
        try {
            firebaseApp = firebase.app();
            console.log('Firebase app already exists, reusing it');
        } catch (e) {
            console.log('Initializing new Firebase app');
            firebaseApp = firebase.initializeApp(firebaseConfig);
        }

        const messaging = firebase.messaging();

        const forceTokenRefresh = true;

        async function resetStoredToken() {
            const oldToken = localStorage.getItem('fcm_token');
            console.log('Checking stored token:', oldToken);

            if (oldToken) {
                try {
                    console.log('Deleting old token from Firebase');
                    await messaging.deleteToken();
                    console.log('Token deleted successfully');
                } catch (e) {
                    console.error('Error deleting token:', e);
                }
            }

            localStorage.removeItem('fcm_token');
            localStorage.removeItem('fcm_token_last_sent');
            console.log('Local token storage cleared');
        }

        let currentFcmToken = localStorage.getItem('fcm_token');
        let isInvalidToken = !currentFcmToken ||
            currentFcmToken === 'null' ||
            currentFcmToken === 'undefined' ||
            currentFcmToken.length < 10;

        if (forceTokenRefresh || isInvalidToken) {
            console.log('Token refresh forced or invalid token detected');
            resetStoredToken();
            currentFcmToken = '';
        }

        let tokenLastSent = parseInt(localStorage.getItem('fcm_token_last_sent') || '0');
        const isNewSession = false;

        const TOKEN_UPDATE_INTERVAL = 24 * 60 * 60 * 1000;
        const isEdgeBrowser = navigator.userAgent.indexOf("Edg") !== -1;

        async function initializeFirebaseMessaging() {
            try {
                const permission = await Notification.requestPermission();
                if (permission !== 'granted') {
                    console.log('Notification permission not granted');
                    return;
                }

                const swOptions = {
                    updateViaCache: 'none'
                };

                const registration = await navigator.serviceWorker.register('/admin/firebase-messaging-sw.js', swOptions);
                console.log('Service Worker registered successfully');

                if (isEdgeBrowser) {
                    console.log('Edge browser detected, adding delay');
                    await new Promise(resolve => setTimeout(resolve, 1000));
                }

                messaging.useServiceWorker(registration);

                if (registration.active) {
                    console.log('Sending config to Service Worker');
                    registration.active.postMessage({
                        type: 'FIREBASE_CONFIG',
                        config: firebaseConfig
                    });
                } else {
                    console.warn('Service Worker not active yet');
                }

                const now = Date.now();
                let shouldUpdateServer = false;

                try {
                    console.log('Getting new FCM token');

                    const tokenFromFirebase = await messaging.getToken();

                    if (tokenFromFirebase) {
                        console.log('New token received from Firebase:', tokenFromFirebase);

                        currentFcmToken = tokenFromFirebase;
                        shouldUpdateServer = true;
                        localStorage.setItem('fcm_token', currentFcmToken);
                    } else {
                        console.warn('Firebase returned empty token');
                        currentFcmToken = null;
                        localStorage.removeItem('fcm_token');
                    }
                } catch (error) {
                    console.error('Error getting token:', error);
                    shouldUpdateServer = false;
                    currentFcmToken = null;
                    localStorage.removeItem('fcm_token');
                }

                const isValidFinalToken = currentFcmToken &&
                    currentFcmToken !== 'null' &&
                    currentFcmToken !== 'undefined' &&
                    currentFcmToken.length > 10;

                if (shouldUpdateServer && isValidFinalToken) {
                    console.log('Updating new token on server:', currentFcmToken);
                    const updateResult = await updateTokenOnServer(currentFcmToken);
                    if (updateResult.success) {
                        console.log('Token update successful');
                        localStorage.setItem('fcm_token_last_sent', now.toString());
                    } else {
                        console.error('Failed to update token on server:', updateResult.error);
                        if (updateResult.error === 'No authenticated user found') {
                            console.log('User not authenticated, clearing token');
                            localStorage.removeItem('fcm_token');
                        }
                    }
                } else if (shouldUpdateServer) {
                    console.warn('Skipping server update - invalid token');
                    localStorage.removeItem('fcm_token');
                }

                messaging.onTokenRefresh(async () => {
                    try {
                        console.log('Token refresh event triggered');

                        await resetStoredToken();

                        const refreshedToken = await messaging.getToken();

                        if (refreshedToken && refreshedToken !== 'null' && refreshedToken !== 'undefined') {
                            console.log('New refreshed token received:', refreshedToken);
                            currentFcmToken = refreshedToken;
                            localStorage.setItem('fcm_token', refreshedToken);
                            localStorage.setItem('fcm_token_last_sent', Date.now().toString());

                            const updateResult = await updateTokenOnServer(refreshedToken);
                            if (!updateResult.success) {
                                console.error('Failed to update refreshed token:', updateResult.error);
                                localStorage.removeItem('fcm_token');
                            }
                        } else {
                            console.warn('Refresh event produced invalid token');
                            localStorage.removeItem('fcm_token');
                        }
                    } catch (error) {
                        console.error('Error refreshing token:', error);
                        localStorage.removeItem('fcm_token');
                    }
                });
            } catch (error) {
                console.error('Firebase initialization error:', error);
                localStorage.removeItem('fcm_token');
            }
        }

        async function updateTokenOnServer(token) {
            if (!token || token === 'null' || token === 'undefined' || token.length < 10) {
                console.error('Attempted to send invalid token to server');
                return {
                    success: false,
                    error: 'Invalid token'
                };
            }

            try {
                console.log('Sending token to server');
                const response = await fetch('{{ route("fcm.token.update") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        token
                    })
                });

                const data = await response.json();
                return data;
            } catch (error) {
                console.error('Server update error:', error);
                return {
                    success: false,
                    error: error.message
                };
            }
        }

        messaging.onMessage((payload) => {
            console.log('Received foreground message:', payload);
        });

        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            console.log('Document already ready, initializing messaging');
            initializeFirebaseMessaging();
        } else {
            console.log('Waiting for document to be ready');
            document.addEventListener('DOMContentLoaded', initializeFirebaseMessaging, {
                once: true
            });
        }
    })();
</script>