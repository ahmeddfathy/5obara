import 'package:flutter/material.dart';
import '../../utils/constants.dart';

class ServicesOfferingSection extends StatelessWidget {
  const ServicesOfferingSection({super.key});

  @override
  Widget build(BuildContext context) {
    final services = [
      {'icon': 'assets/images/home/1grey.png', 'title': 'خطوط انتاج'},
      {
        'icon': 'assets/images/home/1184773-1.png',
        'title': 'إنشاء وتنفيذ المشروعات الصناعية'
      },
      {
        'icon': 'assets/images/home/1184773-3.png',
        'title': 'دراسات جدوى اقتصادية'
      },
      {'icon': 'assets/images/home/4grey.png', 'title': 'الرسم الهندسي'},
    ];

    return Container(
      padding: const EdgeInsets.symmetric(vertical: 80, horizontal: 20),
      color: Colors.white,
      child: Column(
        children: [
          const Text(
            'خدمات خبراء',
            style: TextStyle(
              color: AppColors.secondary,
              fontSize: 42,
              fontWeight: FontWeight.bold,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 30),
          Container(
            width: 800,
            margin: const EdgeInsets.symmetric(horizontal: 20),
            child: const Text(
              'نحن نقدم عدد متنوع من الخدمات والاستشارات الاقتصادية يقوم عليها خبراء بسوق التجارة والصناعة خبرتهم تزيد عن عشرون عاما',
              style: TextStyle(
                color: AppColors.textLight,
                fontSize: 18,
                height: 1.7,
              ),
              textAlign: TextAlign.center,
            ),
          ),
          const SizedBox(height: 50),
          _buildServicesGrid(context, services),
        ],
      ),
    );
  }

  Widget _buildServicesGrid(
    BuildContext context,
    List<Map<String, String>> services,
  ) {
    return LayoutBuilder(
      builder: (context, constraints) {
        final crossAxisCount = constraints.maxWidth > 768
            ? 4
            : (constraints.maxWidth > 576 ? 2 : 1);

        return GridView.builder(
          shrinkWrap: true,
          physics: const NeverScrollableScrollPhysics(),
          gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
            crossAxisCount: crossAxisCount,
            crossAxisSpacing: 30,
            mainAxisSpacing: 30,
            childAspectRatio: 0.8,
          ),
          itemCount: services.length,
          itemBuilder: (context, index) {
            return _buildServiceItem(
              icon: services[index]['icon']!,
              title: services[index]['title']!,
            );
          },
        );
      },
    );
  }

  Widget _buildServiceItem({required String icon, required String title}) {
    return Container(
      padding: const EdgeInsets.all(30),
      decoration: BoxDecoration(
        color: AppColors.lightGray,
        borderRadius: BorderRadius.circular(12),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.1),
            blurRadius: 15,
            offset: const Offset(0, 5),
          ),
        ],
      ),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Container(
            width: 80,
            height: 80,
            decoration: BoxDecoration(
              color: AppColors.primary,
              borderRadius: BorderRadius.circular(50),
            ),
            child: Center(
              child: Image.asset(
                icon,
                width: 45,
                height: 45,
                color: Colors.white,
                errorBuilder: (context, error, stackTrace) => Container(
                  color: Colors.grey[300],
                  child: const Icon(Icons.image, color: Colors.grey),
                ),
              ),
            ),
          ),
          const SizedBox(height: 20),
          Text(
            title,
            style: const TextStyle(
              color: AppColors.textColor,
              fontSize: 22,
              fontWeight: FontWeight.w600,
              height: 1.4,
            ),
            textAlign: TextAlign.center,
          ),
        ],
      ),
    );
  }
}
