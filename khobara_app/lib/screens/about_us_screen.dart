import 'package:flutter/material.dart';
import '../utils/constants.dart';
import '../widgets/shared/top_bar.dart';
import '../widgets/shared/header.dart';
import '../widgets/shared/footer.dart';
import '../widgets/shared/app_drawer.dart';
import '../widgets/about_us/about_content.dart';

class AboutUsScreen extends StatelessWidget {
  const AboutUsScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.lightGray,
      drawer: const AppDrawer(),
      body: SafeArea(
        child: SingleChildScrollView(
          child: Column(
            children: [
              const TopBar(),
              const Header(),
              _buildHeroSection(context),
              const AboutContent(),
              const Footer(),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildHeroSection(BuildContext context) {
    return Container(
      height: MediaQuery.of(context).size.width > 600 ? 500 : 400,
      padding: EdgeInsets.symmetric(
        vertical: MediaQuery.of(context).size.width > 600 ? 60 : 40,
        horizontal: MediaQuery.of(context).size.width > 600 ? 20 : 16,
      ),
      decoration: BoxDecoration(
        image: DecorationImage(
          image: const AssetImage('assets/images/about/hero.jpg'),
          fit: BoxFit.cover,
          colorFilter: ColorFilter.mode(
            Colors.black.withOpacity(0.35),
            BlendMode.darken,
          ),
        ),
      ),
      child: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Text(
              AppStrings.aboutUs,
              style: TextStyle(
                color: Colors.white,
                fontSize: MediaQuery.of(context).size.width > 600 ? 56 : 42,
                fontWeight: FontWeight.w800,
                shadows: [
                  Shadow(
                    color: Colors.black,
                    offset: const Offset(0, 2),
                    blurRadius: 4,
                  ),
                ],
              ),
            ),
            const SizedBox(height: 16),
            Text(
              'نحن نقدم خدمات استشارية متكاملة ودراسات جدوى احترافية',
              style: TextStyle(
                color: Colors.white.withOpacity(0.95),
                fontSize: MediaQuery.of(context).size.width > 600 ? 20 : 16,
                shadows: [
                  Shadow(
                    color: Colors.black,
                    offset: const Offset(0, 1),
                    blurRadius: 2,
                  ),
                ],
              ),
              textAlign: TextAlign.center,
            ),
          ],
        ),
      ),
    );
  }
}
