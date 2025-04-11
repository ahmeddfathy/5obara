import 'package:flutter/material.dart';
import '../utils/constants.dart';
import '../widgets/shared/top_bar.dart';
import '../widgets/shared/header.dart';
import '../widgets/shared/footer.dart';
import '../widgets/shared/app_drawer.dart';
import '../widgets/start_project/project_content.dart';
import '../widgets/start_project/process_steps.dart';

class StartProjectScreen extends StatelessWidget {
  const StartProjectScreen({super.key});

  @override
  Widget build(BuildContext context) {
    final screenWidth = MediaQuery.of(context).size.width;
    final isDesktop = screenWidth > 600;

    return Scaffold(
      backgroundColor: AppColors.lightGray,
      drawer: const AppDrawer(),
      body: SafeArea(
        child: SingleChildScrollView(
          child: ConstrainedBox(
            constraints: BoxConstraints(
              minHeight: MediaQuery.of(context).size.height -
                  MediaQuery.of(context).padding.top,
            ),
            child: Column(
              mainAxisAlignment: MainAxisAlignment.start,
              children: [
                const TopBar(),
                const Header(),
                _buildHeroSection(context),
                const ProjectContent(),
                const ProcessSteps(),
                const Footer(),
              ],
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildHeroSection(BuildContext context) {
    final screenWidth = MediaQuery.of(context).size.width;
    final isDesktop = screenWidth > 600;

    return Container(
      padding: EdgeInsets.symmetric(
        vertical: isDesktop ? 80 : 60,
        horizontal: isDesktop ? 20 : 16,
      ),
      decoration: BoxDecoration(
        color: AppColors.primary,
        image: DecorationImage(
          image: const AssetImage('assets/images/start-your-project/hero.jfif'),
          fit: BoxFit.cover,
          colorFilter: ColorFilter.mode(
            Colors.black.withOpacity(0.5),
            BlendMode.darken,
          ),
        ),
      ),
      width: double.infinity,
      child: Column(
        children: [
          Text(
            'ابدء مشروعك معنا',
            style: TextStyle(
              color: Colors.white,
              fontSize: isDesktop ? 36 : 32,
              fontWeight: FontWeight.bold,
              shadows: [
                Shadow(
                  color: Colors.black.withOpacity(0.2),
                  offset: const Offset(0, 2),
                  blurRadius: 3,
                ),
              ],
            ),
          ),
          const SizedBox(height: 30),
          if (isDesktop)
            Row(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                _buildPrimaryButton(),
                const SizedBox(width: 20),
                _buildSecondaryButton(),
              ],
            )
          else
            Column(
              children: [
                _buildPrimaryButton(),
                const SizedBox(height: 16),
                _buildSecondaryButton(),
              ],
            ),
        ],
      ),
    );
  }

  Widget _buildPrimaryButton() {
    return ElevatedButton(
      onPressed: () {},
      style: ElevatedButton.styleFrom(
        backgroundColor: Colors.white,
        foregroundColor: AppColors.primary,
        padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 15),
        elevation: 3,
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(8),
        ),
        textStyle: const TextStyle(
          fontSize: 16,
          fontWeight: FontWeight.bold,
        ),
      ),
      child: const Text('اطلب دراسة جدوى الآن'),
    );
  }

  Widget _buildSecondaryButton() {
    return OutlinedButton(
      onPressed: () {},
      style: OutlinedButton.styleFrom(
        foregroundColor: Colors.white,
        side: const BorderSide(color: Colors.white, width: 2),
        padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 15),
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(8),
        ),
        textStyle: const TextStyle(
          fontSize: 16,
          fontWeight: FontWeight.bold,
        ),
      ),
      child: const Text('تواصل مع مستشار'),
    );
  }
}
