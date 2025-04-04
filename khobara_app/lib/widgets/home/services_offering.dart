import 'package:flutter/material.dart';
import '../../utils/constants.dart';

class ServicesOfferingSection extends StatelessWidget {
  const ServicesOfferingSection({super.key});

  @override
  Widget build(BuildContext context) {
    final services = [
      {'icon': AppAssets.icon2, 'title': 'خطوط انتاج'},
      {'icon': AppAssets.icon1, 'title': 'إنشاء وتنفيذ المشروعات الصناعية'},
      {'icon': AppAssets.icon6, 'title': 'دراسات جدوى اقتصادية'},
      {'icon': AppAssets.icon5, 'title': 'الرسم الهندسي'},
    ];

    return Container(
      padding: const EdgeInsets.symmetric(vertical: 60, horizontal: 20),
      color: Colors.white,
      child: Column(
        children: [
          const Text(
            'خدمات خبراء',
            style: TextStyle(
              color: AppColors.secondary,
              fontSize: 32,
              fontWeight: FontWeight.w600,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 20),
          const Padding(
            padding: EdgeInsets.symmetric(horizontal: 20.0),
            child: Text(
              'نحن نقدم عدد متنوع من الخدمات والاستشارات الاقتصادية يقوم عليها خبراء بسوق التجارة والصناعة خبرتهم تزيد عن عشرون عاما',
              style: TextStyle(
                color: AppColors.textColor,
                fontSize: 15,
                height: 1.6,
              ),
              textAlign: TextAlign.center,
            ),
          ),
          const SizedBox(height: 40),
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
        final crossAxisCount =
            constraints.maxWidth > 768
                ? 4
                : (constraints.maxWidth > 576 ? 2 : 1);

        return GridView.builder(
          shrinkWrap: true,
          physics: const NeverScrollableScrollPhysics(),
          gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
            crossAxisCount: crossAxisCount,
            crossAxisSpacing: 20,
            mainAxisSpacing: 20,
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
      padding: const EdgeInsets.all(15),
      decoration: BoxDecoration(
        color: AppColors.lightGray.withOpacity(0.5),
        borderRadius: BorderRadius.circular(8),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.03),
            blurRadius: 10,
            spreadRadius: 0,
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
            padding: const EdgeInsets.all(15),
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(8),
            ),
            child: Image.asset(
              icon,
              errorBuilder:
                  (context, error, stackTrace) => Container(
                    color: Colors.grey[300],
                    child: const Icon(Icons.image, color: Colors.grey),
                  ),
            ),
          ),
          const SizedBox(height: 20),
          Text(
            title,
            style: const TextStyle(
              color: AppColors.secondary,
              fontSize: 16,
              fontWeight: FontWeight.w500,
            ),
            textAlign: TextAlign.center,
          ),
        ],
      ),
    );
  }
}
