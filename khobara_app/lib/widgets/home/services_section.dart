import 'package:flutter/material.dart';
import '../../utils/constants.dart';

class ServicesSection extends StatelessWidget {
  const ServicesSection({super.key});

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: EdgeInsets.symmetric(
        vertical: MediaQuery.of(context).size.width > 600 ? 60 : 30,
        horizontal: MediaQuery.of(context).size.width > 600 ? 20 : 16,
      ),
      color: Colors.white,
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          Text(
            'نبذة عن الخدمات التي نقدمها وما نتميز به',
            style: TextStyle(
              color: AppColors.secondary,
              fontSize: MediaQuery.of(context).size.width > 600 ? 36 : 28,
              fontWeight: FontWeight.bold,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 30),
          _buildServicesDescription(context),
          const SizedBox(height: 40),
          _buildServicesGrid(context),
          const SizedBox(height: 40),
          _buildServicesChecklist(context),
        ],
      ),
    );
  }

  Widget _buildServicesDescription(BuildContext context) {
    final List<String> descriptions = [
      'نحن نتولى مشروعك حتى تنفيذه على أرض الواقع',
      'وهذا مرورا بدراسة الجدوى الاقتصادية المفصلة والمعتمدة',
      'وتمويل المشروع من الجهة المناسبة لما بناء على الملائة المالية لديك',
      'كذلك استيراد المكائن وخطوط الإنتاج والمواد الخام، وضمان جودة المواصفات',
      'مع متابعة بدء العمل حتى حصول المشروع على شهادة الجودة والإعتماد التشغيلية للمنتجات',
      'اطلب الآن دراسة جدوى اقتصادية مفصلة لمشروعك',
    ];

    return Container(
      width: MediaQuery.of(context).size.width > 800 ? 800 : double.infinity,
      margin: EdgeInsets.symmetric(
        horizontal: MediaQuery.of(context).size.width > 600 ? 20 : 16,
      ),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: descriptions
            .map((desc) => Padding(
                  padding: const EdgeInsets.only(bottom: 8),
                  child: Text(
                    desc,
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      color: AppColors.textLight,
                      fontSize:
                          MediaQuery.of(context).size.width > 600 ? 16 : 14,
                      height: 1.5,
                    ),
                  ),
                ))
            .toList(),
      ),
    );
  }

  Widget _buildServicesGrid(BuildContext context) {
    final services = [
      {'icon': 'assets/images/home/1184773-1.png', 'title': 'تنفيذ المشروعات'},
      {
        'icon': 'assets/images/home/1184773-2.png',
        'title': 'خطوط انتاج صناعية'
      },
      {
        'icon': 'assets/images/home/1184773-3.png',
        'title': 'دراسات جدوى اقتصادية'
      },
      {
        'icon': 'assets/images/home/1184773-4.png',
        'title': 'دراسات مالية ومراجعات محاسبية'
      },
      {
        'icon': 'assets/images/home/1184773-5.png',
        'title': 'رسومات هندسية للمشروع'
      },
      {
        'icon': 'assets/images/home/1184773-6.png',
        'title': 'الحصول على التمويل'
      },
    ];

    return LayoutBuilder(
      builder: (context, constraints) {
        final crossAxisCount = constraints.maxWidth > 768 ? 3 : 2;
        return GridView.builder(
          shrinkWrap: true,
          physics: const NeverScrollableScrollPhysics(),
          gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
            crossAxisCount: crossAxisCount,
            crossAxisSpacing: MediaQuery.of(context).size.width > 600 ? 20 : 12,
            mainAxisSpacing: MediaQuery.of(context).size.width > 600 ? 20 : 12,
            childAspectRatio: 1.2,
          ),
          itemCount: services.length,
          itemBuilder: (context, index) {
            return _buildServiceItem(
              context,
              icon: services[index]['icon']!,
              title: services[index]['title']!,
            );
          },
        );
      },
    );
  }

  Widget _buildServiceItem(BuildContext context,
      {required String icon, required String title}) {
    return Container(
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: AppColors.primary.withOpacity(0.5)),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.1),
            blurRadius: 15,
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
            height: MediaQuery.of(context).size.width > 600 ? 60 : 40,
            width: MediaQuery.of(context).size.width > 600 ? 60 : 40,
            errorBuilder: (context, error, stackTrace) => Container(
              height: MediaQuery.of(context).size.width > 600 ? 60 : 40,
              width: MediaQuery.of(context).size.width > 600 ? 60 : 40,
              color: Colors.grey[300],
              child: const Icon(Icons.image, color: Colors.grey),
            ),
          ),
          const SizedBox(height: 12),
          Text(
            title,
            style: TextStyle(
              color: AppColors.secondary,
              fontSize: MediaQuery.of(context).size.width > 600 ? 18 : 16,
              fontWeight: FontWeight.w600,
            ),
            textAlign: TextAlign.center,
          ),
        ],
      ),
    );
  }

  Widget _buildServicesChecklist(BuildContext context) {
    final checklistItems = [
      'عمل دراسة جدوى اقتصادية واقعية مفصلة',
      'ترتيب الأوراق والمساعدة في الحصول على تمويل',
      'عمل رسوم هندسية للمشروع، واستيراد المكائن وخطوط الإنتاج والمواد الخام',
      'ضمان متابعة مواصفات جودة المكائن والحصول على شهادات الجودة',
    ];

    return Container(
      width: MediaQuery.of(context).size.width > 800 ? 800 : double.infinity,
      margin: EdgeInsets.symmetric(
        horizontal: MediaQuery.of(context).size.width > 600 ? 20 : 16,
      ),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: checklistItems
            .map((item) => _buildChecklistItem(context, item))
            .toList(),
      ),
    );
  }

  Widget _buildChecklistItem(BuildContext context, String text) {
    return Container(
      margin: const EdgeInsets.only(bottom: 12),
      padding:
          EdgeInsets.all(MediaQuery.of(context).size.width > 600 ? 16 : 12),
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
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Icon(Icons.check_circle, color: AppColors.primary, size: 20),
          const SizedBox(width: 12),
          Expanded(
            child: Text(
              text,
              style: TextStyle(
                color: AppColors.textColor,
                fontSize: MediaQuery.of(context).size.width > 600 ? 16 : 14,
                fontWeight: FontWeight.w500,
                height: 1.5,
              ),
            ),
          ),
        ],
      ),
    );
  }
}
