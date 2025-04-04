import 'package:flutter/material.dart';
import 'package:flutter_localizations/flutter_localizations.dart';
import 'package:go_router/go_router.dart';
import 'screens/home_screen.dart';
import 'screens/about_us_screen.dart';
import 'screens/services_screen.dart';
import 'screens/portfolio_screen.dart';
import 'screens/portfolio/portfolio_details_screen.dart';
import 'screens/blog/blog_screen.dart';
import 'screens/blog/blog_details_screen.dart';
import 'screens/blog/opportunities_screen.dart';
import 'screens/start_project_screen.dart';
import 'screens/contact_screen.dart';
import 'services/api_service.dart';
import 'utils/constants.dart';
import 'utils/routes.dart';

void main() {
  runApp(const MyApp());
}

final ApiService _apiService = ApiService();

// Create router configuration
final GoRouter _router = GoRouter(
  initialLocation: '/',
  routes: [
    GoRoute(
      path: '/',
      name: 'home',
      builder: (context, state) => const HomeScreen(),
    ),
    GoRoute(
      path: '/about-us',
      name: 'about',
      builder: (context, state) => const AboutUsScreen(),
    ),
    GoRoute(
      path: '/services',
      name: 'services',
      builder: (context, state) => const ServicesScreen(),
    ),
    GoRoute(
      path: '/portfolio',
      name: 'portfolio',
      builder: (context, state) => const PortfolioScreen(),
    ),
    GoRoute(
      path: '/portfolio/:id',
      name: 'portfolio-details',
      builder: (context, state) {
        final String idParam = state.pathParameters['id'] ?? '';
        if (idParam.isEmpty) {
          return const Scaffold(
            body: Center(child: Text('Invalid portfolio ID')),
          );
        }

        try {
          final int id = int.parse(idParam);
          return FutureBuilder(
            future: _apiService.getPortfolioById(id),
            builder: (context, snapshot) {
              if (snapshot.connectionState == ConnectionState.waiting) {
                return const Scaffold(
                  body: Center(child: CircularProgressIndicator()),
                );
              } else if (snapshot.hasError) {
                return Scaffold(
                  body: Center(child: Text('Error: ${snapshot.error}')),
                );
              } else if (snapshot.hasData) {
                return PortfolioDetailsScreen(portfolio: snapshot.data!);
              } else {
                return const Scaffold(
                  body: Center(child: Text('Portfolio not found')),
                );
              }
            },
          );
        } catch (e) {
          return Scaffold(
            body: Center(child: Text('Error parsing ID: $e')),
          );
        }
      },
    ),
    GoRoute(
      path: '/blog',
      name: 'blog',
      builder: (context, state) => const BlogScreen(),
    ),
    GoRoute(
      path: '/blog/:id',
      name: 'blog-details',
      builder: (context, state) {
        final String idParam = state.pathParameters['id'] ?? '';
        if (idParam.isEmpty) {
          return const Scaffold(
            body: Center(child: Text('Invalid blog ID')),
          );
        }

        try {
          final int id = int.parse(idParam);
          return FutureBuilder(
            future: _apiService.getPostById(id),
            builder: (context, snapshot) {
              if (snapshot.connectionState == ConnectionState.waiting) {
                return const Scaffold(
                  body: Center(child: CircularProgressIndicator()),
                );
              } else if (snapshot.hasError) {
                return Scaffold(
                  body: Center(child: Text('Error: ${snapshot.error}')),
                );
              } else if (snapshot.hasData) {
                return BlogDetailsScreen(post: snapshot.data!);
              } else {
                return const Scaffold(
                  body: Center(child: Text('Blog post not found')),
                );
              }
            },
          );
        } catch (e) {
          return Scaffold(
            body: Center(child: Text('Error parsing ID: $e')),
          );
        }
      },
    ),
    GoRoute(
      path: '/opportunities',
      name: 'opportunities',
      builder: (context, state) => const OpportunitiesScreen(),
    ),
    GoRoute(
      path: '/opportunities/:id',
      name: 'opportunity-details',
      builder: (context, state) {
        final String idParam = state.pathParameters['id'] ?? '';
        if (idParam.isEmpty) {
          return const Scaffold(
            body: Center(child: Text('Invalid opportunity ID')),
          );
        }

        try {
          final int id = int.parse(idParam);
          return FutureBuilder(
            future: _apiService.getInvestmentOpportunityById(id),
            builder: (context, snapshot) {
              if (snapshot.connectionState == ConnectionState.waiting) {
                return const Scaffold(
                  body: Center(child: CircularProgressIndicator()),
                );
              } else if (snapshot.hasError) {
                return Scaffold(
                  body: Center(child: Text('Error: ${snapshot.error}')),
                );
              } else if (snapshot.hasData) {
                return BlogDetailsScreen(post: snapshot.data!);
              } else {
                return const Scaffold(
                  body: Center(child: Text('Opportunity not found')),
                );
              }
            },
          );
        } catch (e) {
          return Scaffold(
            body: Center(child: Text('Error parsing ID: $e')),
          );
        }
      },
    ),
    GoRoute(
      path: '/start-project',
      name: 'start-project',
      builder: (context, state) => const StartProjectScreen(),
    ),
    GoRoute(
      path: '/contact',
      name: 'contact',
      builder: (context, state) => const ContactScreen(),
    ),
  ],
  errorBuilder: (context, state) => Scaffold(
    appBar: AppBar(title: const Text('Page Not Found')),
    body: Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          const Text(
            'الصفحة غير موجودة',
            style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold),
          ),
          const SizedBox(height: 20),
          ElevatedButton(
            onPressed: () => context.go('/'),
            child: const Text('العودة للصفحة الرئيسية'),
          ),
        ],
      ),
    ),
  ),
);

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp.router(
      title: AppStrings.appName,
      debugShowCheckedModeBanner: false,
      routerConfig: _router,
      theme: ThemeData(
        primaryColor: AppColors.primary,
        colorScheme: ColorScheme.fromSeed(seedColor: AppColors.primary),
        fontFamily: 'Cairo',
        scaffoldBackgroundColor: AppColors.lightGray,
        appBarTheme: const AppBarTheme(
          backgroundColor: AppColors.primary,
          elevation: 0,
        ),
        elevatedButtonTheme: ElevatedButtonThemeData(
          style: ElevatedButton.styleFrom(
            backgroundColor: AppColors.primary,
            foregroundColor: Colors.white,
            textStyle: const TextStyle(
              fontFamily: 'Cairo',
              fontWeight: FontWeight.bold,
            ),
          ),
        ),
        outlinedButtonTheme: OutlinedButtonThemeData(
          style: OutlinedButton.styleFrom(
            foregroundColor: AppColors.primary,
            textStyle: const TextStyle(
              fontFamily: 'Cairo',
              fontWeight: FontWeight.bold,
            ),
          ),
        ),
        inputDecorationTheme: InputDecorationTheme(
          border: OutlineInputBorder(borderRadius: BorderRadius.circular(8.0)),
          focusedBorder: OutlineInputBorder(
            borderRadius: BorderRadius.circular(8.0),
            borderSide: const BorderSide(color: AppColors.primary),
          ),
        ),
      ),
      localizationsDelegates: const [
        GlobalMaterialLocalizations.delegate,
        GlobalWidgetsLocalizations.delegate,
        GlobalCupertinoLocalizations.delegate,
      ],
      supportedLocales: const [
        Locale('ar', 'SA'), // Arabic
      ],
      locale: const Locale('ar', 'SA'),
    );
  }
}
