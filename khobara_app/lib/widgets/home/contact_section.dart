import 'package:flutter/material.dart';
import '../../utils/constants.dart';

class ContactSection extends StatelessWidget {
  const ContactSection({super.key});

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 60, horizontal: 20),
      color: Colors.white,
      child: LayoutBuilder(
        builder: (context, constraints) {
          if (constraints.maxWidth > 768) {
            return _buildDesktopLayout();
          } else {
            return _buildMobileLayout();
          }
        },
      ),
    );
  }

  Widget _buildDesktopLayout() {
    return Row(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Expanded(child: _buildContactInfo()),
        const SizedBox(width: 30),
        Expanded(child: _buildContactForm()),
      ],
    );
  }

  Widget _buildMobileLayout() {
    return Column(
      children: [
        _buildContactInfo(),
        const SizedBox(height: 40),
        _buildContactForm(),
      ],
    );
  }

  Widget _buildContactInfo() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const Text(
          'طرق التواصل معنا',
          style: TextStyle(
            color: AppColors.secondary,
            fontSize: 24,
            fontWeight: FontWeight.w600,
          ),
        ),
        const SizedBox(height: 30),
        _buildContactMethod(Icons.email, 'info@5obara.com'),
        _buildContactMethod(Icons.phone, '+966569617288'),
        _buildContactMethod(Icons.phone, '+966569617288'),
        _buildContactMethod(Icons.phone, '+966569617288'),
        const SizedBox(height: 30),
        const Text(
          'تابعنا على:',
          style: TextStyle(
            color: AppColors.secondary,
            fontSize: 18,
            fontWeight: FontWeight.w500,
          ),
        ),
        const SizedBox(height: 15),
        Row(
          children: [
            _buildSocialLink(Icons.facebook),
            _buildSocialLink(Icons.telegram),
            _buildSocialLink(Icons.camera_alt),
            _buildSocialLink(Icons.work),
          ],
        ),
      ],
    );
  }

  Widget _buildContactMethod(IconData icon, String text) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 15),
      child: Row(
        children: [
          Icon(icon, color: AppColors.primary, size: 18),
          const SizedBox(width: 10),
          Text(
            text,
            style: const TextStyle(color: AppColors.textColor, fontSize: 15),
          ),
        ],
      ),
    );
  }

  Widget _buildSocialLink(IconData icon) {
    return Container(
      width: 35,
      height: 35,
      margin: const EdgeInsets.only(left: 15),
      decoration: const BoxDecoration(
        color: AppColors.primary,
        shape: BoxShape.circle,
      ),
      child: Icon(icon, color: Colors.white, size: 18),
    );
  }

  Widget _buildContactForm() {
    return Container(
      padding: const EdgeInsets.all(30),
      decoration: BoxDecoration(
        color: AppColors.lightGray,
        borderRadius: BorderRadius.circular(8),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Text(
            'أرسل لنا رسالة',
            style: TextStyle(
              color: AppColors.secondary,
              fontSize: 24,
              fontWeight: FontWeight.w600,
            ),
          ),
          const SizedBox(height: 25),
          _buildFormField('الاسم'),
          const SizedBox(height: 15),
          _buildFormField('البريد الإلكتروني'),
          const SizedBox(height: 15),
          _buildFormField('رقم الهاتف'),
          const SizedBox(height: 15),
          _buildFormField('الرسالة', isTextArea: true),
          const SizedBox(height: 20),
          ElevatedButton(
            onPressed: () {},
            style: ElevatedButton.styleFrom(
              backgroundColor: AppColors.primary,
              foregroundColor: Colors.white,
              padding: const EdgeInsets.symmetric(horizontal: 40, vertical: 12),
              textStyle: const TextStyle(
                fontSize: 15,
                fontWeight: FontWeight.w500,
              ),
            ),
            child: const Text('إرسال'),
          ),
        ],
      ),
    );
  }

  Widget _buildFormField(String placeholder, {bool isTextArea = false}) {
    return TextFormField(
      maxLines: isTextArea ? 5 : 1,
      decoration: InputDecoration(
        filled: true,
        fillColor: Colors.white,
        contentPadding: const EdgeInsets.symmetric(
          horizontal: 15,
          vertical: 12,
        ),
        hintText: placeholder,
        border: OutlineInputBorder(
          borderRadius: BorderRadius.circular(5),
          borderSide: const BorderSide(color: Colors.grey, width: 1),
        ),
        enabledBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(5),
          borderSide: const BorderSide(color: Colors.grey, width: 1),
        ),
        focusedBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(5),
          borderSide: const BorderSide(color: AppColors.primary, width: 1),
        ),
      ),
      style: const TextStyle(fontSize: 14),
    );
  }
}
