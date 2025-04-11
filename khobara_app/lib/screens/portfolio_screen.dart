import 'package:flutter/material.dart';
import '../utils/constants.dart';
import '../widgets/shared/top_bar.dart';
import '../widgets/shared/header.dart';
import '../widgets/shared/footer.dart';
import '../widgets/shared/app_drawer.dart';
import '../widgets/portfolio/projects_grid.dart';

class PortfolioScreen extends StatelessWidget {
  const PortfolioScreen({super.key});

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
              _buildHeroSection(),
              const ProjectsGrid(),
              const Footer(),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildHeroSection() {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 80, horizontal: 20),
      decoration: BoxDecoration(
        color: AppColors.primary,
        image: DecorationImage(
          image: const NetworkImage(
            'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-4.0.3',
          ),
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
            'معرض الأعمال',
            style: TextStyle(
              color: Colors.white,
              fontSize: 36,
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
          const SizedBox(height: 20),
          Text(
            'نماذج من المشاريع التي قمنا بتنفيذها والتي حققت نجاحاً كبيراً',
            style: TextStyle(
              color: Colors.white.withOpacity(0.95),
              fontSize: 18,
              shadows: [
                Shadow(
                  color: Colors.black.withOpacity(0.2),
                  offset: const Offset(0, 1),
                  blurRadius: 2,
                ),
              ],
            ),
            textAlign: TextAlign.center,
          ),
        ],
      ),
    );
  }
}
