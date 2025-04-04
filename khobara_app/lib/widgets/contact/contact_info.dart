import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import '../../utils/constants.dart';

class ContactInfo extends StatelessWidget {
  const ContactInfo({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 60, horizontal: 16),
      child: Column(
        children: [
          Text(
            'اتصل بنا',
            style: TextStyle(
              fontSize: 32,
              fontWeight: FontWeight.bold,
              color: AppColors.primary,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 20),
          const Text(
            'يمكنك التواصل معنا من خلال إحدى الطرق التالية',
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
        Expanded(child: _buildContactCards()),
        const SizedBox(width: 40),
        Expanded(child: _buildMap()),
      ],
    );
  }

  Widget _buildMobileLayout() {
    return Column(
      children: [_buildContactCards(), const SizedBox(height: 40), _buildMap()],
    );
  }

  Widget _buildContactCards() {
    return Column(
      children: [
        _buildContactCard(
          icon: Icons.location_on,
          title: 'العنوان',
          content:
              'الرياض، المملكة العربية السعودية\nشارع الملك فهد، برج المملكة، الطابق 20',
          color: Colors.blue.shade700,
        ),
        const SizedBox(height: 20),
        _buildContactCard(
          icon: Icons.phone,
          title: 'رقم الهاتف',
          content: '+966 12 345 6789\n+966 12 345 6780',
          color: Colors.green.shade600,
        ),
        const SizedBox(height: 20),
        _buildContactCard(
          icon: Icons.email,
          title: 'البريد الإلكتروني',
          content: 'info@khobara.com\nsupport@khobara.com',
          color: Colors.red.shade600,
        ),
        const SizedBox(height: 20),
        _buildContactCard(
          icon: Icons.access_time,
          title: 'ساعات العمل',
          content:
              'الأحد - الخميس: 9:00 صباحًا - 5:00 مساءً\nالجمعة والسبت: مغلق',
          color: Colors.purple.shade600,
        ),
        const SizedBox(height: 30),
        _buildSocialMedia(),
      ],
    );
  }

  Widget _buildContactCard({
    required IconData icon,
    required String title,
    required String content,
    required Color color,
  }) {
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
      child: Row(
        children: [
          Container(
            width: 60,
            height: 60,
            decoration: BoxDecoration(
              color: color.withOpacity(0.1),
              borderRadius: BorderRadius.circular(8),
            ),
            child: Icon(icon, size: 30, color: color),
          ),
          const SizedBox(width: 20),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.end,
              children: [
                Text(
                  title,
                  style: const TextStyle(
                    fontSize: 18,
                    fontWeight: FontWeight.bold,
                  ),
                ),
                const SizedBox(height: 8),
                Text(
                  content,
                  style: TextStyle(
                    fontSize: 14,
                    color: Colors.grey[600],
                    height: 1.5,
                  ),
                  textAlign: TextAlign.right,
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildSocialMedia() {
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
            'تابعنا على مواقع التواصل الاجتماعي',
            style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 20),
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              _buildSocialIcon(FontAwesomeIcons.facebook, Colors.blue.shade800),
              const SizedBox(width: 20),
              _buildSocialIcon(FontAwesomeIcons.twitter, Colors.blue.shade400),
              const SizedBox(width: 20),
              _buildSocialIcon(
                FontAwesomeIcons.instagram,
                Colors.pink.shade500,
              ),
              const SizedBox(width: 20),
              _buildSocialIcon(FontAwesomeIcons.linkedin, Colors.blue.shade700),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildSocialIcon(IconData icon, Color color) {
    return Container(
      width: 50,
      height: 50,
      decoration: BoxDecoration(
        color: color.withOpacity(0.1),
        borderRadius: BorderRadius.circular(25),
      ),
      child: Icon(icon, color: color, size: 25),
    );
  }

  Widget _buildMap() {
    return Container(
      height: 500,
      decoration: BoxDecoration(
        color: Colors.grey[300],
        borderRadius: BorderRadius.circular(8),
        boxShadow: [
          BoxShadow(
            color: Colors.grey.withOpacity(0.2),
            spreadRadius: 1,
            blurRadius: 5,
            offset: const Offset(0, 3),
          ),
        ],
      ),
      child: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Icon(Icons.map, size: 80, color: Colors.grey[600]),
            const SizedBox(height: 20),
            const Text(
              'خريطة الموقع',
              style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
            ),
            const SizedBox(height: 10),
            Text(
              'يتم تحميل الخريطة هنا...',
              style: TextStyle(fontSize: 14, color: Colors.grey[600]),
            ),
          ],
        ),
      ),
    );
  }
}
