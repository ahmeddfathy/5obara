importScripts("https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js");
importScripts(
    "https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js"
);

// Firebase configuration will be passed from the main application
self.addEventListener("message", function (event) {
    if (event.data && event.data.type === "FIREBASE_CONFIG") {
        // تحقق مما إذا كان التطبيق موجود بالفعل
        try {
            firebase.app();
        } catch (e) {
            // إذا لم يكن موجودًا، قم بتهيئته
            firebase.initializeApp(event.data.config);
        }

        const messaging = firebase.messaging();

        messaging.setBackgroundMessageHandler(function (payload) {
            const notificationTitle = payload.notification.title;
            const notificationOptions = {
                body: payload.notification.body,
                vibrate: [100, 50, 100],
                data: payload.data,
                actions: [
                    {
                        action: "open_url",
                        title: "عرض التفاصيل",
                    },
                ],
                requireInteraction: true,
                dir: "rtl",
                lang: "ar",
                tag: Date.now().toString(),
            };

            return self.registration.showNotification(
                notificationTitle,
                notificationOptions
            );
        });
    }
});

self.addEventListener("notificationclick", function (event) {
    event.notification.close();

    // Handle either specific action click or general notification click
    if (event.action === "open_url" || !event.action) {
        const targetUrl = event.notification.data.link || "/admin/dashboard";
        clients.openWindow(targetUrl);
    }
});

self.addEventListener("push", function (event) {
    if (event.data) {
        const payload = event.data.json();

        event.waitUntil(
            self.registration.showNotification(payload.notification.title, {
                body: payload.notification.body,
                vibrate: [100, 50, 100],
                data: payload.data,
                actions: [
                    {
                        action: "open_url",
                        title: "عرض التفاصيل",
                    },
                ],
                requireInteraction: true,
                dir: "rtl",
                lang: "ar",
                tag: Date.now().toString(),
            })
        );
    }
});

self.addEventListener("install", function (event) {
    event.waitUntil(self.skipWaiting());
});

self.addEventListener("activate", function (event) {
    event.waitUntil(self.clients.claim());
});
