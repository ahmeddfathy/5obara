import 'package:flutter/material.dart';
import 'package:flutter/foundation.dart';
import 'dart:io' show Platform;

class AppConstants {
  // API URLs - Using appropriate local development server based on platform
  static String get baseUrl {
    // For development mode - use appropriate local address
    if (kDebugMode) {
      if (Platform.isAndroid) {
        return 'http://192.168.171.67:8000/api'; // Android emulator special IP for localhost
      } else if (Platform.isIOS) {
        return 'http://192.168.171.67:8000/api'; // iOS simulator can use localhost directly
      } else {
        return 'http://192.168.171.67:8000/api'; // Web or desktop use standard localhost
      }
    }
    // For production mode
    return 'https://5obara.com/api';
  }

  // Uncomment and use this for testing with a physical device:
  // static const String baseUrl = 'http://192.168.1.X:8000/api'; // Replace X with your computer's IP

  static const String assetsPath = 'assets/';
  static const String imagesPath = 'assets/images/';

  // API endpoints
  static const String portfoliosEndpoint = '/portfolios';
  static const String postsEndpoint = '/posts';
  static const String opportunitiesEndpoint = '/investment-opportunities';

  // Screen routes
  static const String homeRoute = '/';
  static const String aboutRoute = '/about';
  static const String servicesRoute = '/services';
  static const String portfolioRoute = '/portfolio';
  static const String portfolioDetailsRoute = '/portfolio/:id';
  static const String blogRoute = '/blog';
  static const String blogDetailsRoute = '/blog/:id';
  static const String opportunitiesRoute = '/opportunities';
  static const String opportunityDetailsRoute = '/opportunities/:id';
  static const String contactRoute = '/contact';
  static const String startProjectRoute = '/start-project';
}

class AppColors {
  static const Color primary = Color(0xFF00b5ad);
  static const Color secondary = Color(0xFF333333);
  static const Color accent = Color(0xFFFF5722);
  static const Color error = Color(0xFFE53935);
  static const Color success = Color(0xFF43A047);
  static const Color warning = Color(0xFFFFA000);
  static const Color info = Color(0xFF039BE5);

  static const Color textColor = Color(0xFF666666);
  static const Color textPrimary = Color(0xFF212121);
  static const Color textSecondary = Color(0xFF757575);
  static const Color textLight = Color(0xFFBDBDBD);

  static const Color background = Color(0xFFF5F5F5);
  static const Color surface = Color(0xFFFFFFFF);
  static const Color white = Colors.white;
  static const Color lightGray = Color(0xFFF8F9FA);
  static const Color divider = Color(0xFFEEEEEE);
  static const Color whatsapp = Color(0xFF25D366);
}

class AppTextStyles {
  static const TextStyle heading1 = TextStyle(
    fontSize: 28,
    fontWeight: FontWeight.bold,
    color: AppColors.textPrimary,
  );

  static const TextStyle heading2 = TextStyle(
    fontSize: 24,
    fontWeight: FontWeight.bold,
    color: AppColors.textPrimary,
  );

  static const TextStyle heading3 = TextStyle(
    fontSize: 20,
    fontWeight: FontWeight.bold,
    color: AppColors.textPrimary,
  );

  static const TextStyle heading4 = TextStyle(
    fontSize: 18,
    fontWeight: FontWeight.bold,
    color: AppColors.textPrimary,
  );

  static const TextStyle body1 = TextStyle(
    fontSize: 16,
    color: AppColors.textPrimary,
  );

  static const TextStyle body2 = TextStyle(
    fontSize: 14,
    color: AppColors.textPrimary,
  );

  static const TextStyle caption = TextStyle(
    fontSize: 12,
    color: AppColors.textSecondary,
  );

  static const TextStyle button = TextStyle(
    fontSize: 16,
    fontWeight: FontWeight.w500,
    color: Colors.white,
  );
}

class AppDecorations {
  static BoxDecoration cardDecoration = BoxDecoration(
    color: AppColors.surface,
    borderRadius: BorderRadius.circular(8),
    boxShadow: [
      BoxShadow(
        color: Colors.black.withOpacity(0.05),
        blurRadius: 10,
        spreadRadius: 0,
        offset: const Offset(0, 5),
      ),
    ],
  );

  static BoxDecoration roundedDecoration = BoxDecoration(
    color: AppColors.surface,
    borderRadius: BorderRadius.circular(12),
  );
}

class AppStrings {
  static const String appName = 'خبراء | الموقع الرسمي';
  static const String requestNow = 'اطلب الآن';
  static const String mainTitle = 'دراسة جدوى اقتصادية مفصلة لمشروعك';
  static const String requestFeasibilityStudy = 'اطلب دراسة جدوى الان';
  static const String contactViaWhatsapp = 'تواصل معنا عبر الواتساب';
  static const String whyChooseUs =
      'لماذا تختار مكتب خبراء لدراسة مشروعك الاقتصادي؟';
}

class AppAssets {
  static const String mainImage =
      'assets/images/home/shutterstock_778123057.jpg';
  static const String logo = 'assets/images/home/logo.jpg';
  static const String icon1 = 'assets/images/home/1184773-1.png';
  static const String icon2 = 'assets/images/home/1grey.png';
  static const String icon3 = 'assets/images/home/1184773-2.png';
  static const String icon4 = 'assets/images/home/1184773-3.png';
  static const String icon5 = 'assets/images/home/4grey.png';
  static const String icon6 = 'assets/images/home/3grey.png';
  static const String serviceImage1 = 'assets/images/home/1184773-4.png';
  static const String serviceImage2 = 'assets/images/home/1184773-5.png';
  static const String serviceImage3 = 'assets/images/home/1184773-6.png';
}
