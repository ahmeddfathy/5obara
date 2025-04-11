import 'package:flutter/material.dart';
import '../../utils/constants.dart';

class AboutContent extends StatelessWidget {
  const AboutContent({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 100),
      color: Colors.white,
      child: Column(
        children: [
          Container(
            constraints: const BoxConstraints(maxWidth: 900),
            margin: const EdgeInsets.symmetric(horizontal: 20, vertical: 0),
            padding: const EdgeInsets.all(60),
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(12),
              boxShadow: [
                BoxShadow(
                  color: Colors.black.withOpacity(0.1),
                  blurRadius: 30,
                  offset: const Offset(0, 10),
                ),
              ],
            ),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Container(
                  padding: const EdgeInsets.only(right: 20),
                  decoration: BoxDecoration(
                    border: Border(
                      right: BorderSide(
                        color: AppColors.primary,
                        width: 3,
                      ),
                    ),
                  ),
                  child: Text(
                    'نحن مكتب معتمد في تنفيذ دراسات جدوى اقتصادية مفصلة للمشروعات نعمل داخل المملكة العربية السعودية بمدينة جده ولدينا فرق استشارية لجميع القطاعات الاقتصادية لسوق المملكة العربية السعودية.',
                    style: TextStyle(
                      fontSize: 20,
                      height: 1.8,
                      fontWeight: FontWeight.w500,
                      color: AppColors.primaryDark,
                    ),
                  ),
                ),
                const SizedBox(height: 28),
                const Text(
                  'نحن نتولى دراسة جدوى مشروعكم والبدء بالتقديم للجهات الممولة والبدء بتنفيذ المشروع بالرسومات الهندسية واستيراد المكائن والمواد الخام وخطوط الانتاج بضمان أعلى جودة وأفضل سعر.',
                  style: TextStyle(
                    fontSize: 18,
                    height: 1.9,
                    color: Color(0xFF2c3e50),
                  ),
                ),
                const SizedBox(height: 28),
                const Text(
                  'يقوم بجمع البيانات فريق مدرب بالتعاون مع مراكز احصائية ويقوم بتحليل البيانات فريق استشاري متخصص بالقطاع محل الدراسة نحن نسعى لإنجاح مشروعكم وتحقيق مكاسب وعوائد اقتصادية مطلوبة كما نبحث عن أفضل الطرق التسويقية التي يجب على المشروع استخدامها بالسوق لديكم.',
                  style: TextStyle(
                    fontSize: 18,
                    height: 1.9,
                    color: Color(0xFF2c3e50),
                  ),
                ),
              ],
            ),
          ),
          const SizedBox(height: 80),
          _buildPartnersSection(),
        ],
      ),
    );
  }

  Widget _buildPartnersSection() {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 100),
      decoration: const BoxDecoration(
        gradient: LinearGradient(
          begin: Alignment.topCenter,
          end: Alignment.bottomCenter,
          colors: [Colors.white, Color(0xFFF8F9FA)],
        ),
      ),
      child: Column(
        children: [
          Stack(
            alignment: Alignment.center,
            children: [
              Text(
                'شركاء النجاح',
                style: TextStyle(
                  fontSize: 42,
                  fontWeight: FontWeight.w700,
                  color: AppColors.secondary,
                ),
              ),
              Positioned(
                bottom: -15,
                child: Container(
                  width: 200,
                  height: 4,
                  decoration: BoxDecoration(
                    gradient: LinearGradient(
                      colors: [
                        Colors.transparent,
                        AppColors.primary,
                        Colors.transparent,
                      ],
                    ),
                  ),
                ),
              ),
            ],
          ),
          const SizedBox(height: 60),
          ConstrainedBox(
            constraints: const BoxConstraints(maxWidth: 1200),
            child: Padding(
              padding: const EdgeInsets.symmetric(horizontal: 20),
              child: Wrap(
                spacing: 40,
                runSpacing: 40,
                alignment: WrapAlignment.center,
                children: [
                  _buildPartnerCard(AppAssets.afniahLogo, 'شركة أفنية'),
                  _buildPartnerCard(AppAssets.bashoryLogo, 'شركة باشوري'),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildPartnerCard(String imagePath, String name) {
    return Container(
      width: 280,
      padding: const EdgeInsets.all(40),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(20),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.05),
            blurRadius: 20,
            offset: const Offset(0, 10),
          ),
        ],
        border: Border.all(
          color: Colors.black.withOpacity(0.05),
        ),
      ),
      child: Column(
        children: [
          Image.asset(
            imagePath,
            height: 100,
            fit: BoxFit.contain,
          ),
          const SizedBox(height: 15),
          Text(
            name,
            style: const TextStyle(
              fontSize: 16,
              color: Colors.grey,
              fontWeight: FontWeight.bold,
            ),
          ),
        ],
      ),
    );
  }
}
