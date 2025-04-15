import 'package:flutter/material.dart';
import 'package:flutter/foundation.dart';
import 'dart:io' show Platform;

class AppConstants {
  // API URLs - Using appropriate local development server based on platform
  static String get baseUrl {
    // For development mode - use appropriate local address
    if (kDebugMode) {
      if (Platform.isAndroid) {
        return 'http://192.168.98.79:8000/api'; // Android emulator special IP for localhost
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

  static const String assetsPath = '';
  static const String imagesPath = 'images/';

  // API endpoints
  static const String portfoliosEndpoint = '/portfolios';
  static const String postsEndpoint = '/posts';
  static const String opportunitiesEndpoint = '/investment-opportunities';
  static const String contactEndpoint = '/contact';
  static const String investmentEndpoint = '/investments';

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
  // Main colors from documentation
  static const Color primary = Color(0xFF00b5ad);
  static const Color primaryDark = Color(0xFF009d96);
  static const Color secondary = Color(0xFF2c3e50);
  static const Color textColor = Color(0xFF333333);
  static const Color textLight = Color(0xFF666666);
  static const Color white = Colors.white;
  static const Color lightGray = Color(0xFFF8F9FA);

  // Additional colors
  static const Color textPrimary = Color(0xFF212121);
  static const Color textSecondary = Color(0xFF757575);
  static const Color background = Color(0xFFF5F5F5);
  static const Color surface = Color(0xFFFFFFFF);
  static const Color divider = Color(0xFFEEEEEE);

  // Social media colors
  static const Color whatsapp = Color(0xFF25D366);
  static const Color facebook = Color(0xFF1877f2);
  static const Color twitter = Color(0xFF1da1f2);
  static const Color instagram = Color(0xFFe4405f);
  static const Color linkedin = Color(0xFF0077b5);

  // Additional UI colors
  static const Color accent = Color(0xFFFF5722);
  static const Color error = Color(0xFFE53935);
  static const Color success = Color(0xFF43A047);
  static const Color warning = Color(0xFFFFA000);
  static const Color info = Color(0xFF039BE5);
}

class AppTextStyles {
  // Updated text styles based on documentation
  static TextStyle heading1 = const TextStyle(
    fontSize: 36,
    fontWeight: FontWeight.bold,
    color: AppColors.textPrimary,
    height: 1.2,
  );

  static TextStyle heading2 = const TextStyle(
    fontSize: 28,
    fontWeight: FontWeight.bold,
    color: AppColors.textPrimary,
    height: 1.3,
  );

  static TextStyle heading3 = const TextStyle(
    fontSize: 24,
    fontWeight: FontWeight.bold,
    color: AppColors.textPrimary,
    height: 1.4,
  );

  static TextStyle heading4 = const TextStyle(
    fontSize: 20,
    fontWeight: FontWeight.bold,
    color: AppColors.textPrimary,
    height: 1.4,
  );

  static TextStyle body1 = const TextStyle(
    fontSize: 18,
    color: AppColors.textColor,
    height: 1.6,
  );

  static TextStyle body2 = const TextStyle(
    fontSize: 16,
    color: AppColors.textColor,
    height: 1.6,
  );

  static TextStyle caption = const TextStyle(
    fontSize: 14,
    color: AppColors.textSecondary,
    height: 1.5,
  );

  static TextStyle button = const TextStyle(
    fontSize: 16,
    fontWeight: FontWeight.w600,
    color: Colors.white,
    height: 1.4,
  );
}

class AppDecorations {
  static BoxDecoration cardDecoration = BoxDecoration(
    color: AppColors.surface,
    borderRadius: BorderRadius.circular(8),
    boxShadow: [
      BoxShadow(
        color: Colors.black.withOpacity(0.1),
        blurRadius: 15,
        spreadRadius: 0,
        offset: const Offset(0, 5),
      ),
    ],
  );

  static BoxDecoration elevatedCardDecoration = BoxDecoration(
    color: AppColors.surface,
    borderRadius: BorderRadius.circular(8),
    boxShadow: [
      BoxShadow(
        color: Colors.black.withOpacity(0.1),
        blurRadius: 30,
        spreadRadius: 0,
        offset: const Offset(0, 10),
      ),
    ],
  );

  static BoxDecoration roundedDecoration = BoxDecoration(
    color: AppColors.surface,
    borderRadius: BorderRadius.circular(12),
  );

  static InputDecoration inputDecoration = InputDecoration(
    filled: true,
    fillColor: AppColors.white,
    contentPadding: const EdgeInsets.symmetric(horizontal: 15, vertical: 12),
    border: OutlineInputBorder(
      borderRadius: BorderRadius.circular(8),
      borderSide: const BorderSide(color: Color(0xFFDDDDDD)),
    ),
    focusedBorder: OutlineInputBorder(
      borderRadius: BorderRadius.circular(8),
      borderSide: const BorderSide(color: AppColors.primary, width: 2),
    ),
    enabledBorder: OutlineInputBorder(
      borderRadius: BorderRadius.circular(8),
      borderSide: const BorderSide(color: Color(0xFFDDDDDD)),
    ),
  );

  static ButtonStyle primaryButtonStyle = ElevatedButton.styleFrom(
    backgroundColor: AppColors.primary,
    foregroundColor: Colors.white,
    padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 12),
    shape: RoundedRectangleBorder(
      borderRadius: BorderRadius.circular(8),
    ),
    elevation: 2,
    textStyle: const TextStyle(
      fontSize: 16,
      fontWeight: FontWeight.w600,
    ),
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

  // Contact information
  static const String contactEmail = 'info@5obara.com';
  static const String contactPhone = '+966569617288';
  static const String contactLocation = 'جدة، المملكة العربية السعودية';

  // Common section headings
  static const String aboutUs = 'من نحن';
  static const String ourServices = 'خدماتنا المتكاملة';
  static const String startYourProject = 'ابدأ مشروعك';
  static const String contactUs = 'تواصل معنا';
}

class AppAssets {
  static const String mainImage = 'assets/images/home/hero.jpg';
  static const String logo = 'assets/images/logo.jpg';
  static const String footerLogo = 'assets/images/footer-logo.png';
  static const String icon1 = 'assets/images/home/1184773-1.png';
  static const String icon2 = 'assets/images/home/1grey.png';
  static const String icon3 = 'assets/images/home/1184773-2.png';
  static const String icon4 = 'assets/images/home/1184773-3.png';
  static const String icon5 = 'assets/images/home/4grey.png';
  static const String icon6 = 'assets/images/home/3grey.png';
  static const String serviceImage1 = 'assets/images/home/1184773-4.png';
  static const String serviceImage2 = 'assets/images/home/1184773-5.png';
  static const String serviceImage3 = 'assets/images/home/1184773-6.png';

  // About section images
  static const String aboutMainImage = 'assets/images/about/about-main.jpg';
  static const String aboutHeroBg = 'assets/images/about/hero-bg.jpg';
  static const String afniahLogo =
      'assets/images/about/Afniah_Logo-1-1024x809.png';
  static const String bashoryLogo = 'assets/images/about/bashory-logo.jpeg';
}
