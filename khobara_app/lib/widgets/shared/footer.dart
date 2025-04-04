import 'package:flutter/material.dart';
import '../../utils/constants.dart';

class Footer extends StatelessWidget {
  const Footer({super.key});

  @override
  Widget build(BuildContext context) {
    return Stack(
      children: [
        Container(
          padding: const EdgeInsets.symmetric(vertical: 60, horizontal: 20),
          color: const Color(0xFFF8F9FA),
          child: Column(
            children: [
              LayoutBuilder(
                builder: (context, constraints) {
                  if (constraints.maxWidth > 768) {
                    return _buildDesktopLayout();
                  } else {
                    return _buildMobileLayout();
                  }
                },
              ),
              const SizedBox(height: 50),
              _buildVisionCopyright(),
            ],
          ),
        ),
        Positioned(
          left: 20,
          bottom: 20,
          child: Column(
            children: [
              _buildChatButton(
                icon: Icons.message,
                color: const Color(0xFF25D366),
                onTap: () {},
              ),
              const SizedBox(height: 10),
              _buildChatButton(
                icon: Icons.chat_bubble,
                color: const Color(0xFF0084FF),
                onTap: () {},
              ),
            ],
          ),
        ),
      ],
    );
  }

  Widget _buildDesktopLayout() {
    return Row(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Expanded(child: _buildContactMethodsSection()),
        const SizedBox(width: 30),
        Expanded(child: _buildContactFormSection()),
      ],
    );
  }

  Widget _buildMobileLayout() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        _buildContactMethodsSection(),
        const SizedBox(height: 30),
        _buildContactFormSection(),
      ],
    );
  }

  Widget _buildContactMethodsSection() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const Text(
          'طرق التواصل معنا',
          style: TextStyle(
            color: Color(0xFF00B5AD),
            fontSize: 22,
            fontWeight: FontWeight.w600,
          ),
        ),
        const SizedBox(height: 25),
        Row(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Expanded(
              child: Column(
                children: [
                  _buildContactMethod('Facebook', Icons.facebook, () {}),
                  _buildContactMethod('Twitter', Icons.alternate_email, () {}),
                  _buildContactMethod('Instagram', Icons.camera_alt, () {}),
                  _buildContactMethod('LinkedIn', Icons.work, () {}),
                ],
              ),
            ),
            const SizedBox(width: 30),
            Expanded(
              child: Column(
                children: [
                  _buildContactMethod('info@5obara.com', Icons.email, () {}),
                  _buildContactMethod('+966569617288', Icons.phone, () {}),
                  _buildContactMethod(
                    '+966569617288',
                    Icons.phone_android,
                    () {},
                  ),
                  _buildContactMethod('+966569617288', Icons.message, () {}),
                ],
              ),
            ),
          ],
        ),
      ],
    );
  }

  Widget _buildContactMethod(String label, IconData icon, VoidCallback onTap) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 15),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Text(
            label,
            style: const TextStyle(
              color: Color(0xFF555555),
              fontSize: 14,
              fontWeight: FontWeight.w500,
            ),
          ),
          GestureDetector(
            onTap: onTap,
            child: Container(
              width: 40,
              height: 40,
              decoration: BoxDecoration(
                color: const Color(0xFF00B5AD),
                borderRadius: BorderRadius.circular(20),
                boxShadow: const [
                  BoxShadow(
                    color: Color(0x3300B5AD),
                    blurRadius: 5,
                    offset: Offset(0, 3),
                  ),
                ],
              ),
              child: Icon(icon, color: Colors.white, size: 16),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildContactFormSection() {
    return Container(
      padding: const EdgeInsets.all(30),
      decoration: BoxDecoration(
        color: const Color(0xFF00B5AD),
        borderRadius: BorderRadius.circular(8),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Text(
            'أرسل لنا رسالة',
            style: TextStyle(
              color: Colors.white,
              fontSize: 22,
              fontWeight: FontWeight.w600,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 25),
          TextField(
            decoration: InputDecoration(
              hintText: 'الاسم',
              filled: true,
              fillColor: Colors.white,
              border: OutlineInputBorder(
                borderRadius: BorderRadius.circular(4),
                borderSide: BorderSide.none,
              ),
              contentPadding: const EdgeInsets.symmetric(
                horizontal: 15,
                vertical: 10,
              ),
            ),
          ),
          const SizedBox(height: 15),
          Row(
            children: [
              Expanded(
                child: TextField(
                  decoration: InputDecoration(
                    hintText: 'مثال: 544902462',
                    filled: true,
                    fillColor: Colors.white,
                    border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(4),
                      borderSide: BorderSide.none,
                    ),
                    prefixText: '966+ ',
                    prefixStyle: const TextStyle(
                      color: Color(0xFF555555),
                      backgroundColor: Color(0xFFEEEEEE),
                    ),
                    contentPadding: const EdgeInsets.symmetric(
                      horizontal: 15,
                      vertical: 10,
                    ),
                  ),
                ),
              ),
              const SizedBox(width: 10),
              Expanded(
                child: DropdownButtonFormField<String>(
                  value: 'استشارة',
                  decoration: InputDecoration(
                    filled: true,
                    fillColor: Colors.white,
                    border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(4),
                      borderSide: BorderSide.none,
                    ),
                    contentPadding: const EdgeInsets.symmetric(
                      horizontal: 15,
                      vertical: 10,
                    ),
                  ),
                  items: const [
                    DropdownMenuItem(value: 'استشارة', child: Text('استشارة')),
                    DropdownMenuItem(value: 'استفسار', child: Text('استفسار')),
                    DropdownMenuItem(value: 'أخرى', child: Text('أخرى')),
                  ],
                  onChanged: (value) {},
                ),
              ),
            ],
          ),
          const SizedBox(height: 15),
          TextField(
            decoration: InputDecoration(
              hintText: 'بأي مدينة مشروعك؟',
              filled: true,
              fillColor: Colors.white,
              border: OutlineInputBorder(
                borderRadius: BorderRadius.circular(4),
                borderSide: BorderSide.none,
              ),
              contentPadding: const EdgeInsets.symmetric(
                horizontal: 15,
                vertical: 10,
              ),
            ),
          ),
          const SizedBox(height: 15),
          TextField(
            maxLines: 4,
            decoration: InputDecoration(
              hintText: 'الرسالة',
              filled: true,
              fillColor: Colors.white,
              border: OutlineInputBorder(
                borderRadius: BorderRadius.circular(4),
                borderSide: BorderSide.none,
              ),
              contentPadding: const EdgeInsets.symmetric(
                horizontal: 15,
                vertical: 10,
              ),
            ),
          ),
          const SizedBox(height: 15),
          SizedBox(
            width: double.infinity,
            child: ElevatedButton(
              onPressed: () {},
              style: ElevatedButton.styleFrom(
                backgroundColor: const Color(0xFF333333),
                padding: const EdgeInsets.symmetric(vertical: 10),
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(4),
                ),
              ),
              child: const Text(
                'إرسال',
                style: TextStyle(
                  color: Colors.white,
                  fontSize: 16,
                  fontWeight: FontWeight.w500,
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildVisionCopyright() {
    return Column(
      children: [
        Image.asset(
          'assets/img/footer-logo.png',
          height: 80,
          errorBuilder:
              (context, error, stackTrace) => Container(
                height: 80,
                width: 80,
                color: const Color(0xFF00B5AD),
                child: const Center(
                  child: Text('LOGO', style: TextStyle(color: Colors.white)),
                ),
              ),
        ),
        const SizedBox(height: 20),
        const Text(
          'جميع الحقوق محفوظة © 2024',
          style: TextStyle(color: Color(0xFF666666), fontSize: 14),
        ),
      ],
    );
  }

  Widget _buildChatButton({
    required IconData icon,
    required Color color,
    required VoidCallback onTap,
  }) {
    return GestureDetector(
      onTap: onTap,
      child: Container(
        width: 45,
        height: 45,
        decoration: BoxDecoration(
          color: color,
          borderRadius: BorderRadius.circular(25),
          boxShadow: [
            BoxShadow(
              color: color.withOpacity(0.3),
              blurRadius: 5,
              offset: const Offset(0, 3),
            ),
          ],
        ),
        child: Icon(icon, color: Colors.white, size: 20),
      ),
    );
  }
}
