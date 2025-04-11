import 'package:flutter/material.dart';
import '../../utils/constants.dart';

class WhyChooseUsSection extends StatelessWidget {
  const WhyChooseUsSection({super.key});

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 80, horizontal: 16),
      color: Colors.white,
      child: Column(
        children: [
          Text(
            AppStrings.whyChooseUs,
            style: const TextStyle(
              fontSize: 42,
              fontWeight: FontWeight.bold,
              color: AppColors.secondary,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 50),
          LayoutBuilder(
            builder: (context, constraints) {
              if (constraints.maxWidth > 800) {
                // Desktop layout
                return Row(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Expanded(
                      flex: 3,
                      child: _buildContent(),
                    ),
                    const SizedBox(width: 60),
                    Expanded(
                      flex: 2,
                      child: _buildImage(),
                    ),
                  ],
                );
              } else {
                // Mobile layout
                return Column(
                  children: [
                    _buildImage(),
                    const SizedBox(height: 40),
                    _buildContent(),
                  ],
                );
              }
            },
          ),
        ],
      ),
    );
  }

  Widget _buildContent() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const Text(
          'خبراء | الموقع الرسمي',
          style: TextStyle(
            color: AppColors.primary,
            fontSize: 32,
            fontWeight: FontWeight.bold,
          ),
        ),
        const SizedBox(height: 25),
        const Text(
          'نعتمد على خمس ركائز تجعلنا من أفضل الشركات لتتعاون معها في تنفيذ مشروعك:',
          style: TextStyle(
            fontSize: 18,
            color: AppColors.textColor,
            height: 1.8,
          ),
        ),
        const SizedBox(height: 30),
        _buildPillar(
          title: 'أولاً: الخبرة الواسعة',
          description:
              'نقدم لك دراسة جدوى اقتصادية مفصلة لمشروعك، معتمدة لدى جميع الجهات التمويلية والحكومية.',
        ),
        _buildPillar(
          title: 'ثانياً: بيانات واقعية',
          description:
              'نقدم لك دراسة جدوى مفصلة من أرض الواقع بعد تجميع بيانات واقعية وتحليلها، على يد أكبر المستشاريين بالسوق.',
        ),
        _buildPillar(
          title: 'ثالثاً: فريق متكامل',
          description:
              'لدينا فرق عمل تتمتع بقدر كبير من اللياقة الذهنية للحصول على أكثر الافكار المبتكرة، التي تميز مشروعك عن منافسيه تسويقياً وفنياً.',
        ),
        _buildPillar(
          title: 'رابعاً: خدمات متكاملة',
          description:
              'لدينا مكتب خاص بتنفيذ المشروعات، والمساعدة في الحصول على التمويل، واستيراد المكائن، وخطوط الانتاج، بالمواصفات القياسية الدقيقة للمشروعات.',
        ),
        _buildPillar(
          title: 'خامساً: أسعار تنافسية',
          description:
              'نبادر بدعم رواد الاعمال والمشروعات المتوسطة والصغيرة من خلال أسعار مبسطة، وهذا حرصا منا على خلق المزيد من الفرص، وتشجيعا لعملية التنمية الاقتصادية بالمملكة والتي تتماشى مع رؤية 2030.',
        ),
        const SizedBox(height: 25),
        ElevatedButton(
          onPressed: () {},
          style: ElevatedButton.styleFrom(
            backgroundColor: AppColors.primary,
            padding: const EdgeInsets.symmetric(
              horizontal: 30,
              vertical: 12,
            ),
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(12),
            ),
            elevation: 5,
          ),
          child: const Text(
            'المزيد',
            style: TextStyle(
              fontSize: 16,
              fontWeight: FontWeight.w600,
            ),
          ),
        ),
      ],
    );
  }

  Widget _buildPillar({required String title, required String description}) {
    return Container(
      margin: const EdgeInsets.only(bottom: 30),
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
        border: const Border(
          right: BorderSide(
            color: AppColors.primary,
            width: 4,
          ),
        ),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            title,
            style: const TextStyle(
              fontSize: 24,
              fontWeight: FontWeight.bold,
              color: AppColors.primary,
            ),
          ),
          const SizedBox(height: 10),
          Text(
            description,
            style: const TextStyle(
              fontSize: 18,
              color: AppColors.textLight,
              height: 1.8,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildImage() {
    return Container(
      height: 400,
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(12),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.1),
            blurRadius: 30,
            offset: const Offset(0, 10),
          ),
        ],
        image: const DecorationImage(
          image: AssetImage('assets/images/home/shutterstock_778123057.jpg'),
          fit: BoxFit.cover,
        ),
      ),
    );
  }
}
