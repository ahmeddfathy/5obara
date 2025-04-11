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
      margin: EdgeInsets.symmetric(
        horizontal: MediaQuery.of(context).size.width > 600 ? 16 : 12,
        vertical: MediaQuery.of(context).size.width > 600 ? 32 : 16,
      ),
      padding: EdgeInsets.symmetric(
        vertical: MediaQuery.of(context).size.width > 600 ? 40 : 24,
        horizontal: MediaQuery.of(context).size.width > 600 ? 16 : 12,
      ),
      decoration: BoxDecoration(
        color: AppColors.primary,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.1),
            blurRadius: 20,
            offset: const Offset(0, 10),
          ),
        ],
      ),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          Text(
            'حقائق بالأرقام',
            style: TextStyle(
              color: Colors.white,
              fontSize: MediaQuery.of(context).size.width > 600 ? 32 : 24,
              fontWeight: FontWeight.bold,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 12),
          Text(
            'نبذة عن أرقام من داخل مؤسستنا ... أطلب الآن دراسة جدوى اقتصادية مفصلة لمشروعك',
            style: TextStyle(
              color: Colors.white,
              fontSize: MediaQuery.of(context).size.width > 600 ? 14 : 12,
              fontWeight: FontWeight.w400,
              height: 1.4,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 24),
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
        crossAxisSpacing: 8,
        mainAxisSpacing: 8,
        childAspectRatio: 1.1,
      ),
      itemCount: stats.length,
      itemBuilder: (context, index) {
        return _buildStatItem(stats[index]);
      },
    );
  }

  Widget _buildStatItem(Map<String, String> stat) {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 16, horizontal: 12),
      decoration: BoxDecoration(
        color: Colors.white.withOpacity(0.1),
        borderRadius: BorderRadius.circular(12),
        border: Border.all(
          color: Colors.white.withOpacity(0.2),
          width: 1,
        ),
      ),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Text(
            stat['number']!,
            style: const TextStyle(
              color: Colors.white,
              fontSize: 36,
              fontWeight: FontWeight.w800,
              shadows: [
                Shadow(
                  offset: Offset(0, 2),
                  blurRadius: 4,
                  color: Color.fromARGB(100, 0, 0, 0),
                ),
              ],
            ),
          ),
          const SizedBox(height: 4),
          Text(
            stat['label']!,
            style: const TextStyle(
              color: Colors.white,
              fontSize: 14,
              fontWeight: FontWeight.w500,
            ),
          ),
        ],
      ),
    );
  }
}
