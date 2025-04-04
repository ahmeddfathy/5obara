import 'package:flutter/material.dart';
import '../../utils/constants.dart';

class AboutContent extends StatelessWidget {
  const AboutContent({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 60, horizontal: 16),
      child: Column(
        children: [
          Text(
            'من نحن',
            style: TextStyle(
              fontSize: 32,
              fontWeight: FontWeight.bold,
              color: AppColors.primary,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 20),
          const Text(
            'نبذة عن مكتب خبراء للاستشارات الاقتصادية',
            style: TextStyle(fontSize: 18, color: Colors.grey),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 50),
          LayoutBuilder(
            builder: (context, constraints) {
              if (constraints.maxWidth > 800) {
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
        Expanded(flex: 1, child: _buildImage()),
        const SizedBox(width: 40),
        Expanded(flex: 1, child: _buildContent()),
      ],
    );
  }

  Widget _buildMobileLayout() {
    return Column(
      children: [_buildImage(), const SizedBox(height: 30), _buildContent()],
    );
  }

  Widget _buildImage() {
    return Container(
      height: 400,
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(8),
        image: const DecorationImage(
          image: AssetImage(AppAssets.mainImage),
          fit: BoxFit.cover,
        ),
        boxShadow: [
          BoxShadow(
            color: Colors.grey.withOpacity(0.3),
            spreadRadius: 2,
            blurRadius: 10,
            offset: const Offset(0, 5),
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
          'مكتب خبراء للاستشارات الاقتصادية',
          style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold),
          textAlign: TextAlign.right,
        ),
        const SizedBox(height: 20),
        Text(
          'مكتب خبراء هو مكتب استشاري متخصص في تقديم الخدمات الاستشارية للمشاريع الاقتصادية والتجارية. تأسس المكتب في عام 2010 على يد مجموعة من الخبراء والمستشارين المتخصصين في مجال الاقتصاد والأعمال.',
          style: TextStyle(fontSize: 16, color: Colors.grey[700], height: 1.6),
          textAlign: TextAlign.right,
        ),
        const SizedBox(height: 20),
        Text(
          'نهدف في مكتب خبراء إلى مساعدة أصحاب المشاريع على تحقيق النجاح في مشاريعهم من خلال تقديم الاستشارات المتخصصة ودراسات الجدوى الاقتصادية التي تساعدهم على اتخاذ القرارات الصحيحة وتجنب المخاطر.',
          style: TextStyle(fontSize: 16, color: Colors.grey[700], height: 1.6),
          textAlign: TextAlign.right,
        ),
        const SizedBox(height: 30),
        _buildStatsSection(),
      ],
    );
  }

  Widget _buildStatsSection() {
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(8),
        boxShadow: [
          BoxShadow(
            color: Colors.grey.withOpacity(0.1),
            spreadRadius: 1,
            blurRadius: 5,
            offset: const Offset(0, 3),
          ),
        ],
      ),
      child: Column(
        children: [
          const Text(
            'إنجازاتنا بالأرقام',
            style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 20),
          LayoutBuilder(
            builder: (context, constraints) {
              if (constraints.maxWidth > 500) {
                return Row(
                  mainAxisAlignment: MainAxisAlignment.spaceAround,
                  children: _buildStatItems(),
                );
              } else {
                return Column(
                  children:
                      _buildStatItems()
                          .map(
                            (item) => Padding(
                              padding: const EdgeInsets.only(bottom: 20),
                              child: item,
                            ),
                          )
                          .toList(),
                );
              }
            },
          ),
        ],
      ),
    );
  }

  List<Widget> _buildStatItems() {
    final stats = [
      {'value': '+500', 'label': 'مشروع ناجح'},
      {'value': '+50', 'label': 'خبير متخصص'},
      {'value': '+10', 'label': 'سنوات خبرة'},
    ];

    return stats
        .map(
          (stat) => _buildStatItem(
            value: stat['value'] as String,
            label: stat['label'] as String,
          ),
        )
        .toList();
  }

  Widget _buildStatItem({required String value, required String label}) {
    return Column(
      children: [
        Text(
          value,
          style: TextStyle(
            fontSize: 32,
            fontWeight: FontWeight.bold,
            color: AppColors.primary,
          ),
        ),
        const SizedBox(height: 8),
        Text(label, style: TextStyle(fontSize: 16, color: Colors.grey[700])),
      ],
    );
  }
}
