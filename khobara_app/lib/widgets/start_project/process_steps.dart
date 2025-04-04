import 'package:flutter/material.dart';
import '../../utils/constants.dart';

class ProcessSteps extends StatelessWidget {
  const ProcessSteps({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 60, horizontal: 16),
      color: Colors.grey[100],
      child: Column(
        children: [
          Text(
            'خطوات العمل',
            style: TextStyle(
              fontSize: 32,
              fontWeight: FontWeight.bold,
              color: AppColors.primary,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 20),
          const Text(
            'منهجيتنا في تطوير المشاريع',
            style: TextStyle(fontSize: 18, color: Colors.grey),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 50),
          LayoutBuilder(
            builder: (context, constraints) {
              if (constraints.maxWidth > 800) {
                return _buildDesktopSteps();
              } else {
                return _buildMobileSteps();
              }
            },
          ),
        ],
      ),
    );
  }

  Widget _buildDesktopSteps() {
    return Row(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: _buildStepItems().map((step) => Expanded(child: step)).toList(),
    );
  }

  Widget _buildMobileSteps() {
    return Column(
      children:
          _buildStepItems()
              .map(
                (step) => Padding(
                  padding: const EdgeInsets.only(bottom: 30),
                  child: step,
                ),
              )
              .toList(),
    );
  }

  List<Widget> _buildStepItems() {
    final steps = [
      {
        'number': '01',
        'title': 'الاستشارة الأولية',
        'description':
            'نقوم بعقد جلسة استشارية أولية لفهم فكرة مشروعك وتحديد احتياجاتك واهدافك.',
        'icon': Icons.chat_outlined,
      },
      {
        'number': '02',
        'title': 'جمع البيانات',
        'description':
            'نجمع كافة المعلومات والبيانات اللازمة عن السوق والمنافسين والفئة المستهدفة.',
        'icon': Icons.assignment_outlined,
      },
      {
        'number': '03',
        'title': 'التحليل والدراسة',
        'description':
            'نقوم بتحليل البيانات ودراسة الجوانب الفنية والمالية والتسويقية للمشروع.',
        'icon': Icons.analytics_outlined,
      },
      {
        'number': '04',
        'title': 'إعداد الخطة',
        'description':
            'نقوم بإعداد خطة عمل تفصيلية تشمل كافة جوانب المشروع والتوصيات اللازمة.',
        'icon': Icons.description_outlined,
      },
      {
        'number': '05',
        'title': 'التنفيذ والمتابعة',
        'description':
            'نقدم الدعم اللازم أثناء تنفيذ المشروع ونتابع تقدمه لضمان تحقيق النتائج المرجوة.',
        'icon': Icons.trending_up_outlined,
      },
    ];

    return steps
        .map(
          (step) => _buildStepCard(
            number: step['number'] as String,
            title: step['title'] as String,
            description: step['description'] as String,
            icon: step['icon'] as IconData,
          ),
        )
        .toList();
  }

  Widget _buildStepCard({
    required String number,
    required String title,
    required String description,
    required IconData icon,
  }) {
    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 10),
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
        crossAxisAlignment: CrossAxisAlignment.center,
        children: [
          Container(
            width: 80,
            height: 80,
            decoration: BoxDecoration(
              color: AppColors.primary.withOpacity(0.1),
              borderRadius: BorderRadius.circular(40),
            ),
            child: Center(
              child: Icon(icon, size: 40, color: AppColors.primary),
            ),
          ),
          const SizedBox(height: 16),
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
            decoration: BoxDecoration(
              color: AppColors.primary,
              borderRadius: BorderRadius.circular(20),
            ),
            child: Text(
              number,
              style: const TextStyle(
                fontSize: 16,
                fontWeight: FontWeight.bold,
                color: Colors.white,
              ),
            ),
          ),
          const SizedBox(height: 16),
          Text(
            title,
            style: const TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 12),
          Text(
            description,
            style: TextStyle(
              fontSize: 14,
              color: Colors.grey[600],
              height: 1.5,
            ),
            textAlign: TextAlign.center,
          ),
        ],
      ),
    );
  }
}
