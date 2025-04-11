import 'package:flutter/material.dart';
import '../../utils/constants.dart';
import '../../widgets/shared/top_bar.dart';
import '../../widgets/shared/header.dart';
import '../../widgets/shared/footer.dart';
import '../../widgets/shared/app_drawer.dart';
import '../../widgets/blog/blog_grid.dart';

class BlogScreen extends StatelessWidget {
  const BlogScreen({Key? key}) : super(key: key);

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
              const BlogGrid(),
              const Footer(),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildHeroSection(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 60, horizontal: 20),
      color: AppColors.primary,
      width: double.infinity,
      child: Column(
        children: [
          const Text(
            'المدونة',
            style: TextStyle(
              color: Colors.white,
              fontSize: 28,
              fontWeight: FontWeight.bold,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 16),
          Text(
            'آخر المقالات والأخبار عن الخبراء للتطوير والاستشارات',
            style: TextStyle(
              color: Colors.white.withOpacity(0.9),
              fontSize: 18,
            ),
            textAlign: TextAlign.center,
          ),
        ],
      ),
    );
  }
}
