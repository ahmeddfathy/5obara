import 'package:flutter/material.dart';
import '../screens/home_screen.dart';
import '../screens/about_us_screen.dart';
import '../screens/services_screen.dart';
import '../screens/portfolio_screen.dart';
import '../screens/start_project_screen.dart';
import '../screens/contact_screen.dart';

class AppRoutes {
  static const String home = '/';
  static const String aboutUs = '/about-us';
  static const String services = '/services';
  static const String portfolio = '/portfolio';
  static const String startProject = '/start-project';
  static const String contact = '/contact';

  static Route<dynamic> generateRoute(RouteSettings settings) {
    switch (settings.name) {
      case home:
        return MaterialPageRoute(builder: (_) => const HomeScreen());
      case aboutUs:
        return MaterialPageRoute(builder: (_) => const AboutUsScreen());
      case services:
        return MaterialPageRoute(builder: (_) => const ServicesScreen());
      case portfolio:
        return MaterialPageRoute(builder: (_) => const PortfolioScreen());
      case startProject:
        return MaterialPageRoute(builder: (_) => const StartProjectScreen());
      case contact:
        return MaterialPageRoute(builder: (_) => const ContactScreen());
      default:
        return MaterialPageRoute(
          builder:
              (_) => Scaffold(
                body: Center(
                  child: Text('No route defined for ${settings.name}'),
                ),
              ),
        );
    }
  }

  static Map<String, WidgetBuilder> routes = {
    home: (context) => const HomeScreen(),
    aboutUs: (context) => const AboutUsScreen(),
    services: (context) => const ServicesScreen(),
    portfolio: (context) => const PortfolioScreen(),
    startProject: (context) => const StartProjectScreen(),
    contact: (context) => const ContactScreen(),
  };
}
