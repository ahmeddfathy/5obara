import 'package:flutter/material.dart';
import '../../utils/constants.dart';

class WhyChooseUsSection extends StatelessWidget {
  const WhyChooseUsSection({super.key});

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 70, horizontal: 20),
      color: Colors.white,
      child: Column(
        children: [
          Text(
            AppStrings.whyChooseUs,
            style: const TextStyle(
              color: AppColors.secondary,
              fontSize: 32,
              fontWeight: FontWeight.w600,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 40),
          LayoutBuilder(
            builder: (context, constraints) {
              if (constraints.maxWidth > 768) {
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
        Expanded(child: _buildTextContent()),
        const SizedBox(width: 40),
        Expanded(child: _buildImage()),
      ],
    );
  }

  Widget _buildMobileLayout() {
    return Column(
      children: [
        _buildImage(),
        const SizedBox(height: 30),
        _buildTextContent(),
      ],
    );
  }

  Widget _buildTextContent() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const Text(
          'خبراء | الموقع الرسمي',
          style: TextStyle(
            color: AppColors.primary,
            fontSize: 24,
            fontWeight: FontWeight.w600,
          ),
        ),
        const SizedBox(height: 20),
        const Text(
          'نعتمد على خمس ركائز تجعلنا من أفضل الشركات لتتعاون معها في تنفيذ مشروعك:',
          style: TextStyle(color: AppColors.textColor, fontSize: 16),
        ),
        const SizedBox(height: 25),
        _buildPillarItem(
          title: 'أولاً: الخبرة الواسعة',
          description:
              'نقدم لك دراسة جدوى اقتصادية مفصلة لمشروعك، معتمدة لدى جميع الجهات التمويلية والحكومية.',
        ),
        _buildPillarItem(
          title: 'ثانياً: بيانات واقعية',
          description:
              'نقدم لك دراسة جدوى مفصلة من أرض الواقع بعد تجميع بيانات واقعية وتحليلها، على يد أكبر المستشاريين بالسوق.',
        ),
        _buildPillarItem(
          title: 'ثالثاً: فريق متكامل',
          description:
              'لدينا فرق عمل تتمتع بقدر كبير من اللياقة الذهنية للحصول على أكثر الافكار المبتكرة، التي تميز مشروعك عن منافسيه تسويقياً وفنياً.',
        ),
        _buildPillarItem(
          title: 'رابعاً: خدمات متكاملة',
          description:
              'لدينا مكتب خاص بتنفيذ المشروعات، والمساعدة في الحصول على التمويل، واستيراد المكائن، وخطوط الانتاج، بالمواصفات القياسية الدقيقة للمشروعات.',
        ),
        _buildPillarItem(
          title: 'خامساً: أسعار تنافسية',
          description:
              'نبادر بدعم رواد الاعمال والمشروعات المتوسطة والصغيرة من خلال أسعار مبسطة، وهذا حرصا منا على خلق المزيد من الفرص، وتشجيعا لعملية التنمية الاقتصادية بالمملكة والتي تتماشى مع رؤية 2030.',
        ),
        const SizedBox(height: 20),
        ElevatedButton(
          onPressed: () {},
          style: ElevatedButton.styleFrom(
            backgroundColor: AppColors.primary,
            foregroundColor: Colors.white,
            padding: const EdgeInsets.symmetric(horizontal: 25, vertical: 12),
          ),
          child: const Text('المزيد'),
        ),
      ],
    );
  }

  Widget _buildPillarItem({
    required String title,
    required String description,
  }) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 25, right: 25),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            title,
            style: const TextStyle(
              color: AppColors.primary,
              fontSize: 18,
              fontWeight: FontWeight.w600,
            ),
          ),
          const SizedBox(height: 8),
          Text(
            description,
            style: const TextStyle(
              color: AppColors.textColor,
              fontSize: 14,
              height: 1.6,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildImage() {
    return Container(
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(8),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.1),
            spreadRadius: 0,
            blurRadius: 20,
            offset: const Offset(0, 5),
          ),
        ],
      ),
      child: ClipRRect(
        borderRadius: BorderRadius.circular(8),
        child: Image.asset(
          AppAssets.mainImage,
          fit: BoxFit.cover,
          errorBuilder:
              (context, error, stackTrace) => Container(
                height: 300,
                color: Colors.grey[300],
                child: const Center(
                  child: Icon(
                    Icons.image_not_supported,
                    size: 50,
                    color: Colors.grey,
                  ),
                ),
              ),
        ),
      ),
    );
  }
}
