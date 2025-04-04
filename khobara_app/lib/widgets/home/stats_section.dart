import 'package:flutter/material.dart';
import '../../utils/constants.dart';

class StatsSection extends StatelessWidget {
  const StatsSection({super.key});

  @override
  Widget build(BuildContext context) {
    final stats = [
      {'number': '1250', 'label': 'استشارة'},
      {'number': '6663', 'label': 'عميل راضي'},
      {'number': '3450', 'label': 'فرصة استثمارية'},
      {'number': '5430', 'label': 'دراسة جدوى'},
    ];

    return Container(
      padding: const EdgeInsets.symmetric(vertical: 40, horizontal: 20),
      color: AppColors.primary,
      child: Column(
        children: [
          const Text(
            'حقائق بالأرقام',
            style: TextStyle(
              color: Colors.white,
              fontSize: 28,
              fontWeight: FontWeight.w600,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 30),
          const Text(
            'نبذة عن أرقام من داخل مؤسستنا ... أطلب الآن دراسة جدوى اقتصادية مفصلة لمشروعك',
            style: TextStyle(
              color: Colors.white,
              fontSize: 15,
              fontWeight: FontWeight.w400,
              height: 1.5,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 30),
          LayoutBuilder(
            builder: (context, constraints) {
              if (constraints.maxWidth > 768) {
                return _buildDesktopLayout(stats);
              } else {
                return _buildMobileLayout(stats);
              }
            },
          ),
        ],
      ),
    );
  }

  Widget _buildDesktopLayout(List<Map<String, String>> stats) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceEvenly,
      children: stats.map((stat) => _buildStatItem(stat)).toList(),
    );
  }

  Widget _buildMobileLayout(List<Map<String, String>> stats) {
    return GridView.builder(
      shrinkWrap: true,
      physics: const NeverScrollableScrollPhysics(),
      gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
        crossAxisCount: 2,
        crossAxisSpacing: 15,
        mainAxisSpacing: 15,
        childAspectRatio: 1.5,
      ),
      itemCount: stats.length,
      itemBuilder: (context, index) {
        return _buildStatItem(stats[index]);
      },
    );
  }

  Widget _buildStatItem(Map<String, String> stat) {
    return Column(
      mainAxisAlignment: MainAxisAlignment.center,
      children: [
        Text(
          stat['number']!,
          style: const TextStyle(
            color: Colors.white,
            fontSize: 36,
            fontWeight: FontWeight.w600,
          ),
        ),
        const SizedBox(height: 5),
        Text(
          stat['label']!,
          style: const TextStyle(
            color: Colors.white,
            fontSize: 15,
            fontWeight: FontWeight.w400,
          ),
        ),
      ],
    );
  }
}
