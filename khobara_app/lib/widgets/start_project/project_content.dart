import 'package:flutter/material.dart';
import '../../utils/constants.dart';

class ProjectContent extends StatelessWidget {
  const ProjectContent({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 60, horizontal: 16),
      child: Column(
        children: [
          Text(
            'كيف نساعدك في بدء مشروعك',
            style: TextStyle(
              fontSize: 32,
              fontWeight: FontWeight.bold,
              color: AppColors.primary,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 20),
          const Text(
            'نقدم لك خدمات متكاملة لمساعدتك في كل مراحل تأسيس وتطوير مشروعك',
            style: TextStyle(fontSize: 18, color: Colors.grey),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 50),
          LayoutBuilder(
            builder: (context, constraints) {
              if (constraints.maxWidth > 800) {
                return _buildDesktopLayout();
              } else {
                return _buildMobileLayout();
              }
            },
          ),
        ],
      ),
    );
  }

  Widget _buildDesktopLayout() {
    return Row(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Expanded(child: _buildImage()),
        const SizedBox(width: 40),
        Expanded(child: _buildContentSection()),
      ],
    );
  }

  Widget _buildMobileLayout() {
    return Column(
      children: [
        _buildImage(),
        const SizedBox(height: 30),
        _buildContentSection(),
      ],
    );
  }

  Widget _buildImage() {
    return Container(
      height: 400,
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(8),
        image: const DecorationImage(
          image: AssetImage(AppAssets.mainImage),
          fit: BoxFit.cover,
        ),
        boxShadow: [
          BoxShadow(
            color: Colors.grey.withOpacity(0.3),
            spreadRadius: 2,
            blurRadius: 10,
            offset: const Offset(0, 5),
          ),
        ],
      ),
    );
  }

  Widget _buildContentSection() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        _buildContentItem(
          title: 'تحليل فكرة المشروع',
          description:
              'نساعدك في تقييم فكرة مشروعك ودراسة جدواها الأولية والتأكد من إمكانية تنفيذها.',
          icon: Icons.lightbulb_outline,
        ),
        const SizedBox(height: 20),
        _buildContentItem(
          title: 'دراسة السوق',
          description:
              'نقوم بتحليل السوق والمنافسين لتحديد الفرص والتحديات التي قد تواجه مشروعك.',
          icon: Icons.bar_chart,
        ),
        const SizedBox(height: 20),
        _buildContentItem(
          title: 'إعداد خطة العمل',
          description:
              'نساعدك في وضع خطة عمل متكاملة تشمل جميع جوانب المشروع الفنية والإدارية والمالية.',
          icon: Icons.assignment,
        ),
        const SizedBox(height: 20),
        _buildContentItem(
          title: 'دراسة الجدوى المفصلة',
          description:
              'نقدم دراسة جدوى تفصيلية تشمل الجوانب المالية والفنية والتسويقية للمشروع.',
          icon: Icons.trending_up,
        ),
        const SizedBox(height: 30),
        SizedBox(
          width: double.infinity,
          height: 50,
          child: ElevatedButton(
            onPressed: () {},
            style: ElevatedButton.styleFrom(backgroundColor: AppColors.primary),
            child: const Text(
              'اطلب دراسة جدوى الآن',
              style: TextStyle(fontSize: 16, color: Colors.white),
            ),
          ),
        ),
      ],
    );
  }

  Widget _buildContentItem({
    required String title,
    required String description,
    required IconData icon,
  }) {
    return Row(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Container(
          padding: const EdgeInsets.all(10),
          decoration: BoxDecoration(
            color: AppColors.primary.withOpacity(0.1),
            borderRadius: BorderRadius.circular(8),
          ),
          child: Icon(icon, color: AppColors.primary, size: 24),
        ),
        const SizedBox(width: 16),
        Expanded(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                title,
                style: const TextStyle(
                  fontSize: 18,
                  fontWeight: FontWeight.bold,
                ),
              ),
              const SizedBox(height: 8),
              Text(
                description,
                style: TextStyle(
                  fontSize: 14,
                  color: Colors.grey[600],
                  height: 1.5,
                ),
              ),
            ],
          ),
        ),
      ],
    );
  }
}
