import 'package:flutter/material.dart';
import '../utils/constants.dart';
import '../widgets/shared/top_bar.dart';
import '../widgets/shared/header.dart';
import '../widgets/shared/footer.dart';
import '../widgets/shared/app_drawer.dart';
import '../widgets/start_project/project_content.dart';
import '../widgets/start_project/process_steps.dart';
import '../widgets/shared/contact_form_section.dart';

class StartProjectScreen extends StatelessWidget {
  const StartProjectScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.lightGray,
      drawer: const AppDrawer(),
      body: SingleChildScrollView(
        child: Column(
          children: [
            // أقسام الصفحة
            const TopBar(),
            const Header(),
            _buildHeroSection(),
            const ProjectContent(),
            const ProcessSteps(),
            const ContactFormSection(),
            const Footer(),
          ],
        ),
      ),
    );
  }

  Widget _buildHeroSection() {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 60, horizontal: 20),
      color: AppColors.primary,
      width: double.infinity,
      child: Column(
        children: [
          Text(
            'ابدء مشروعك معنا',
            style: TextStyle(
              color: Colors.white,
              fontSize: 32,
              fontWeight: FontWeight.bold,
            ),
          ),
          SizedBox(height: 20),
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              ElevatedButton(
                onPressed: () {},
                style: ElevatedButton.styleFrom(
                  backgroundColor: Colors.white,
                  foregroundColor: AppColors.primary,
                  padding: EdgeInsets.symmetric(horizontal: 20, vertical: 12),
                ),
                child: Text('اطلب دراسة جدوى الآن'),
              ),
              SizedBox(width: 15),
              OutlinedButton(
                onPressed: () {},
                style: OutlinedButton.styleFrom(
                  foregroundColor: Colors.white,
                  side: BorderSide(color: Colors.white),
                  padding: EdgeInsets.symmetric(horizontal: 20, vertical: 12),
                ),
                child: Text('تواصل مع مستشار'),
              ),
            ],
          ),
        ],
      ),
    );
  }
}
