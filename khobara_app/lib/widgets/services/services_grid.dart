import 'package:flutter/material.dart';
import '../../utils/constants.dart';

class ServicesGrid extends StatelessWidget {
  const ServicesGrid({super.key});

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 100),
      color: Colors.white,
      child: Stack(
        children: [
          // Background pattern
          Positioned.fill(
            child: Container(
              decoration: BoxDecoration(
                image: DecorationImage(
                  image: NetworkImage(
                    'data:image/svg+xml;utf8,<svg width="30" height="30" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg"><rect width="2" height="2" fill="%23f1f1f1" /></svg>',
                  ),
                  repeat: ImageRepeat.repeat,
                ),
              ),
            ),
          ),
          // Content
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 24),
            child: Column(
              children: [
                Container(
                  constraints: const BoxConstraints(maxWidth: 1200),
                  child: LayoutBuilder(
                    builder: (context, constraints) {
                      if (constraints.maxWidth > 900) {
                        return Row(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Expanded(child: _buildServiceCard(0)),
                            const SizedBox(width: 40),
                            Expanded(child: _buildServiceCard(1)),
                            const SizedBox(width: 40),
                            Expanded(child: _buildServiceCard(2)),
                          ],
                        );
                      } else {
                        return Column(
                          children: [
                            _buildServiceCard(0),
                            const SizedBox(height: 40),
                            _buildServiceCard(1),
                            const SizedBox(height: 40),
                            _buildServiceCard(2),
                          ],
                        );
                      }
                    },
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildServiceCard(int index) {
    final services = [
      {
        'icon': 'https://img.icons8.com/color/96/000000/statistics.png',
        'title': 'دراسة الجدوى',
        'description':
            'نقدم دراسات جدوى شاملة لمشاريعك باستخدام أحدث المنهجيات وأدوات التحليل، مع التركيز على الجوانب المالية والتسويقية والفنية',
      },
      {
        'icon': 'https://cdn-icons-png.flaticon.com/512/3373/3373087.png',
        'title': 'دراسة السوق',
        'description':
            'تحليل شامل للسوق المستهدف وتحديد الفرص والتحديات، مع تقديم رؤى استراتيجية لتحقيق النجاح في السوق التنافسي',
      },
      {
        'icon': 'https://img.icons8.com/color/96/000000/accounting.png',
        'title': 'التخطيط المالي',
        'description':
            'تطوير خطط مالية متكاملة وتقدير التكاليف والإيرادات، مع وضع استراتيجيات فعالة لتحقيق الاستدامة المالية',
      },
    ];

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
        border: Border.all(
          color: Colors.black.withOpacity(0.05),
        ),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Container(
            width: 80,
            height: 80,
            decoration: BoxDecoration(
              color: AppColors.primary,
              borderRadius: BorderRadius.circular(40),
            ),
            child: Center(
              child: Image.network(
                services[index]['icon']!,
                width: 45,
                height: 45,
                color: Colors.white,
              ),
            ),
          ),
          const SizedBox(height: 30),
          Text(
            services[index]['title']!,
            style: const TextStyle(
              color: AppColors.secondary,
              fontSize: 28,
              fontWeight: FontWeight.w700,
            ),
          ),
          const SizedBox(height: 20),
          Text(
            services[index]['description']!,
            style: const TextStyle(
              color: Color(0xFF666666),
              fontSize: 18,
              height: 1.8,
            ),
          ),
        ],
      ),
    );
  }
}
