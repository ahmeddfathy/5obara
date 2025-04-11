import 'package:flutter/material.dart';
import '../utils/constants.dart';
import '../widgets/shared/top_bar.dart';
import '../widgets/shared/header.dart';
import '../widgets/shared/footer.dart';
import '../widgets/services/services_grid.dart';
import '../widgets/services/cta_section.dart';

import '../widgets/shared/app_drawer.dart';

class ServicesScreen extends StatelessWidget {
  const ServicesScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
      drawer: const AppDrawer(),
      body: SafeArea(
        child: SingleChildScrollView(
          child: Column(
            children: [
              const TopBar(),
              const Header(),
              _buildHeroSection(),
              Container(
                width: double.infinity,
                constraints: const BoxConstraints(maxWidth: 1200),
                child: Column(
                  children: [
                    const ServicesGrid(),
                    _buildProcessSection(),
                    const CtaSection(),
                  ],
                ),
              ),
              const Footer(),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildHeroSection() {
    return Container(
      height: 600,
      width: double.infinity,
      decoration: BoxDecoration(
        image: DecorationImage(
          image: const NetworkImage(
            'https://images.unsplash.com/photo-1573164574472-797cdf4a583a?q=80&w=1920&auto=format&fit=crop',
          ),
          fit: BoxFit.cover,
          colorFilter: ColorFilter.mode(
            Colors.black.withOpacity(0.6),
            BlendMode.darken,
          ),
        ),
      ),
      child: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            const Text(
              'خدماتنا المتكاملة',
              style: TextStyle(
                color: Colors.white,
                fontSize: 56,
                fontWeight: FontWeight.w700,
                shadows: [
                  Shadow(
                    offset: Offset(0, 2),
                    blurRadius: 4,
                    color: Color(0x4D000000),
                  ),
                ],
              ),
            ),
            const SizedBox(height: 20),
            Text(
              'نقدم حلولاً استشارية متكاملة لتحقيق نجاح مشاريعك',
              style: TextStyle(
                color: Colors.white.withOpacity(0.9),
                fontSize: 20,
                height: 1.6,
                shadows: [
                  Shadow(
                    offset: const Offset(0, 1),
                    blurRadius: 2,
                    color: Colors.black.withOpacity(0.2),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildProcessSection() {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 80),
      color: const Color(0xFFF8F9FA),
      child: Column(
        children: [
          const Text(
            'كيف نعمل',
            style: TextStyle(
              color: AppColors.secondary,
              fontSize: 36,
              fontWeight: FontWeight.w700,
            ),
          ),
          Container(
            width: 80,
            height: 4,
            margin: const EdgeInsets.only(top: 20, bottom: 60),
            decoration: BoxDecoration(
              color: AppColors.primary,
              borderRadius: BorderRadius.circular(2),
            ),
          ),
          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 24),
            child: LayoutBuilder(
              builder: (context, constraints) {
                if (constraints.maxWidth > 900) {
                  return Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Expanded(child: _buildProcessStep(1, 'التشاور الأولي')),
                      const SizedBox(width: 30),
                      Expanded(child: _buildProcessStep(2, 'تحليل وتخطيط')),
                      const SizedBox(width: 30),
                      Expanded(child: _buildProcessStep(3, 'تنفيذ وتسليم')),
                    ],
                  );
                } else {
                  return Column(
                    children: [
                      _buildProcessStep(1, 'التشاور الأولي'),
                      const SizedBox(height: 30),
                      _buildProcessStep(2, 'تحليل وتخطيط'),
                      const SizedBox(height: 30),
                      _buildProcessStep(3, 'تنفيذ وتسليم'),
                    ],
                  );
                }
              },
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildProcessStep(int number, String title) {
    final descriptions = {
      1: 'نستمع إلى متطلباتك وأهداف مشروعك بعناية، ونقوم بتحليل احتياجاتك بدقة',
      2: 'نقوم بتحليل البيانات وتطوير خطة عمل استراتيجية مخصصة لمشروعك',
      3: 'نقدم تقريراً شاملاً مع توصيات عملية قابلة للتنفيذ، ونضمن متابعة النتائج',
    };

    return Container(
      padding: const EdgeInsets.all(40),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.08),
            blurRadius: 30,
            offset: const Offset(0, 10),
          ),
        ],
      ),
      child: Column(
        children: [
          Container(
            width: 60,
            height: 60,
            decoration: BoxDecoration(
              color: AppColors.primary,
              shape: BoxShape.circle,
            ),
            child: Center(
              child: Text(
                number.toString(),
                style: const TextStyle(
                  color: Colors.white,
                  fontSize: 24,
                  fontWeight: FontWeight.w700,
                ),
              ),
            ),
          ),
          const SizedBox(height: 25),
          Text(
            title,
            style: const TextStyle(
              color: AppColors.secondary,
              fontSize: 24,
              fontWeight: FontWeight.w600,
            ),
          ),
          const SizedBox(height: 15),
          Text(
            descriptions[number]!,
            textAlign: TextAlign.center,
            style: const TextStyle(
              color: Color(0xFF666666),
              fontSize: 16,
              height: 1.8,
            ),
          ),
        ],
      ),
    );
  }
}
