import 'package:flutter/material.dart';

class ServicesGrid extends StatelessWidget {
  const ServicesGrid({super.key});

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 80),
      color: Colors.white,
      child: Column(
        children: [
          Wrap(
            spacing: 30,
            runSpacing: 30,
            children: [
              _buildServiceCard(
                icon: Icons.trending_up,
                title: 'دراسة الجدوى الاقتصادية',
                description:
                    'هي احدى أهم خدماتنا على الاطلاق نعمل بسوق التجارة والصناعة منذ حوالي خمس أعوام نفذنا عدد ضخم من الدراسات في مختلف القطاعات لدينا خبراء سوق واستشاريين فنيين ومهندسين ومحلليين ماليين على أعلى مستوى يشرفون على فرق من المعدين للدراسات وجامعوا البيانات بشكل دقيق ونعمل في إطار علمي مدروس ومخطط لتكون دراسة الجدوى واقعية وصادقة ومفصلة للمشروع وتم مراجعة الدراسة على أيدي خبراء أكثر من مرة وذلك لأخذ أفضل رأي استشاري حول المشروعات، كما نعتمد على المزيد من الافكار المبتكرة.',
              ),
              _buildServiceCard(
                icon: Icons.factory,
                title: 'خطوط الانتاج',
                description:
                    'نقدم خدمة إعداد خطوط إنتاج كاملة للمصانع وذلك من خلال علاقاتنا بأكبر المصانع في الصين وماليزيا والهند وتركيا وألمانيا والعديد من الشركات المصنعة لخطوط الانتاج وقدمنا نحو 3400 خط إنتاج لمصانع مختلفة داخل وخارج المملكة العربية السعودية.',
              ),
              _buildServiceCard(
                icon: Icons.local_shipping,
                title: 'خطة تصدير',
                description:
                    'نعمل على تقديم خطة وافية لتصدير منتجاتك وندرس لك جدوى تصديرها والفوائد المتوقعة والفرص المحتملة وأفضل البلاد التي يمكنك التعامل معها والتصدير لها بكل التفاصيل الفنية واللوجستية لذلك، وهذا من خلال اطلاع الخبراء لدينا على تحديثات سوق التجارة والصناعة في مختلف الانحاء والاطلاع على احدث الدراسات العلمية في المجال الاقتصادي عالميا ومحليا.',
              ),
              _buildServiceCard(
                icon: Icons.architecture,
                title: 'الرسم الهندسي',
                description:
                    'لدينا فريق استشاري هندسي يمكنه عمل كافة الرسومات الهندسية الخاصة بالمصنع ولدينا خبرة بعمل أكثر من 500 رسم هندسي لمصانع بمختلف التخصصات.',
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildServiceCard({
    required IconData icon,
    required String title,
    required String description,
  }) {
    return Container(
      width: 300,
      padding: const EdgeInsets.all(30),
      decoration: BoxDecoration(
        color: const Color(0xFFF8F9FA),
        borderRadius: BorderRadius.circular(8),
        boxShadow: const [
          BoxShadow(
            color: Color(0x0D000000),
            blurRadius: 15,
            offset: Offset(0, 3),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Container(
            width: 70,
            height: 70,
            decoration: BoxDecoration(
              color: const Color(0xFF00B5AD),
              borderRadius: BorderRadius.circular(35),
            ),
            child: Icon(icon, color: Colors.white, size: 30),
          ),
          const SizedBox(height: 20),
          Text(
            title,
            style: const TextStyle(
              color: Color(0xFF00B5AD),
              fontSize: 24,
              fontWeight: FontWeight.w600,
            ),
          ),
          const SizedBox(height: 15),
          Text(
            description,
            style: const TextStyle(
              color: Color(0xFF666666),
              fontSize: 15,
              height: 1.8,
            ),
          ),
        ],
      ),
    );
  }
}
