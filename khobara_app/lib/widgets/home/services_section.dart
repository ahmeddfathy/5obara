import 'package:flutter/material.dart';
import '../../utils/constants.dart';

class ServicesSection extends StatelessWidget {
  const ServicesSection({super.key});

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 70, horizontal: 20),
      color: Colors.white,
      child: Column(
        children: [
          const Text(
            'نبذة عن الخدمات التي نقدمها وما نتميز به',
            style: TextStyle(
              color: AppColors.secondary,
              fontSize: 32,
              fontWeight: FontWeight.w600,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 40),
          _buildServicesDescription(),
          const SizedBox(height: 50),
          _buildServicesGrid(context),
          const SizedBox(height: 40),
          _buildServicesChecklist(),
        ],
      ),
    );
  }

  Widget _buildServicesDescription() {
    final List<String> descriptions = [
      'نحن نتولى مشروعك حتى تنفيذه على أرض الواقع',
      'وهذا مرورا بدراسة الجدوى الاقتصادية المفصلة والمعتمدة',
      'وتمويل المشروع من الجهة المناسبة لما بناء على الملائة المالية لديك',
      'كذلك استيراد المكائن وخطوط الإنتاج والمواد الخام، وضمان جودة المواصفات',
      'مع متابعة بدء العمل حتى حصول المشروع على شهادة الجودة والإعتماد التشغيلية للمنتجات',
      'اطلب الآن دراسة جدوى اقتصادية مفصلة لمشروعك',
    ];

    return Column(
      children:
          descriptions
              .map(
                (desc) => Padding(
                  padding: const EdgeInsets.only(bottom: 10),
                  child: Text(
                    desc,
                    textAlign: TextAlign.center,
                    style: const TextStyle(
                      color: AppColors.textColor,
                      fontSize: 15,
                      height: 1.6,
                    ),
                  ),
                ),
              )
              .toList(),
    );
  }

  Widget _buildServicesGrid(BuildContext context) {
    final services = [
      {'icon': AppAssets.icon1, 'title': 'تنفيذ المشروعات'},
      {'icon': AppAssets.icon2, 'title': 'خطوط انتاج صناعية'},
      {'icon': AppAssets.icon3, 'title': 'دراسات جدوى اقتصادية'},
      {'icon': AppAssets.icon4, 'title': 'دراسات مالية ومراجعات محاسبية'},
      {'icon': AppAssets.icon5, 'title': 'رسومات هندسية للمشروع'},
      {'icon': AppAssets.icon6, 'title': 'الحصول على التمويل'},
    ];

    return LayoutBuilder(
      builder: (context, constraints) {
        final crossAxisCount = constraints.maxWidth > 768 ? 3 : 2;
        return GridView.builder(
          shrinkWrap: true,
          physics: const NeverScrollableScrollPhysics(),
          gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
            crossAxisCount: crossAxisCount,
            crossAxisSpacing: 20,
            mainAxisSpacing: 20,
            childAspectRatio: 1.5,
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
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(8),
        border: Border.all(color: AppColors.primary.withOpacity(0.5)),
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
          Image.asset(
            icon,
            height: 60,
            width: 60,
            errorBuilder:
                (context, error, stackTrace) => Container(
                  height: 60,
                  width: 60,
                  color: Colors.grey[300],
                  child: const Icon(Icons.image, color: Colors.grey),
                ),
          ),
          const SizedBox(height: 15),
          Text(
            title,
            style: const TextStyle(
              color: AppColors.secondary,
              fontSize: 15,
              fontWeight: FontWeight.w500,
            ),
            textAlign: TextAlign.center,
          ),
        ],
      ),
    );
  }

  Widget _buildServicesChecklist() {
    final checklistItems = [
      'عمل دراسة جدوى اقتصادية واقعية مفصلة',
      'ترتيب الأوراق والمساعدة في الحصول على تمويل',
      'عمل رسوم هندسية للمشروع، واستيراد المكائن وخطوط الإنتاج والمواد الخام',
      'ضمان متابعة مواصفات جودة المكائن والحصول على شهادات الجودة',
    ];

    return Container(
      decoration: BoxDecoration(
        color: AppColors.lightGray.withOpacity(0.5),
        borderRadius: BorderRadius.circular(10),
      ),
      padding: const EdgeInsets.all(20),
      child: Column(
        children:
            checklistItems.map((item) => _buildChecklistItem(item)).toList(),
      ),
    );
  }

  Widget _buildChecklistItem(String text) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 12),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Icon(Icons.check_circle, color: AppColors.primary, size: 18),
          const SizedBox(width: 10),
          Expanded(
            child: Text(
              text,
              style: const TextStyle(
                color: AppColors.textColor,
                fontSize: 14,
                height: 1.4,
              ),
            ),
          ),
        ],
      ),
    );
  }
}
