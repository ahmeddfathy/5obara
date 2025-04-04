import 'package:flutter/material.dart';
import '../utils/constants.dart';
import '../widgets/shared/top_bar.dart';
import '../widgets/shared/header.dart';
import '../widgets/shared/footer.dart';
import '../widgets/shared/app_drawer.dart';
import '../widgets/about_us/about_content.dart';
import '../widgets/about_us/team_section.dart';
import '../widgets/shared/contact_form_section.dart';

class AboutUsScreen extends StatelessWidget {
  const AboutUsScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.lightGray,
      drawer: const AppDrawer(),
      body: SingleChildScrollView(
        child: Column(
          children: [
            // أقسام الصفحة
            const TopBar(),
            const Header(),
            _buildHeroSection(),
            const AboutContent(),
            const TeamSection(),
            const ContactFormSection(),
            const Footer(),
          ],
        ),
      ),
    );
  }

  Widget _buildHeroSection() {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 60, horizontal: 20),
      color: AppColors.primary,
      width: double.infinity,
      child: Column(
        children: [
          Text(
            'من نحن',
            style: TextStyle(
              color: Colors.white,
              fontSize: 32,
              fontWeight: FontWeight.bold,
            ),
          ),
          SizedBox(height: 20),
          Text(
            'تعرف على فريق خبراء والخدمات التي نقدمها',
            style: TextStyle(
              color: Colors.white.withOpacity(0.9),
              fontSize: 18,
            ),
          ),
        ],
      ),
    );
  }
}
