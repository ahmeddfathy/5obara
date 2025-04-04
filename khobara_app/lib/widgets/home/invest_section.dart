import 'package:flutter/material.dart';
import '../../utils/constants.dart';

class InvestSection extends StatelessWidget {
  const InvestSection({super.key});

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 60, horizontal: 20),
      color: AppColors.primary,
      child: Column(
        children: [
          const Text(
            'استثمر معنا',
            style: TextStyle(
              color: Colors.white,
              fontSize: 28,
              fontWeight: FontWeight.w600,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 20),
          const Text(
            'يمكنك إدخال رأس المال وسنتواصل معك بأفضل المشاريع - أطلب الان دراسة جدوى اقتصادية مفصلة لمشروعك',
            style: TextStyle(color: Colors.white, fontSize: 15, height: 1.5),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 30),
          _buildInvestForm(context),
        ],
      ),
    );
  }

  Widget _buildInvestForm(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(30),
      decoration: BoxDecoration(
        color: Colors.white.withOpacity(0.1),
        borderRadius: BorderRadius.circular(10),
      ),
      child: Column(
        children: [
          LayoutBuilder(
            builder: (context, constraints) {
              if (constraints.maxWidth > 768) {
                return _buildDesktopForm();
              } else {
                return _buildMobileForm();
              }
            },
          ),
          const SizedBox(height: 20),
          ElevatedButton(
            onPressed: () {},
            style: ElevatedButton.styleFrom(
              backgroundColor: AppColors.secondary,
              foregroundColor: Colors.white,
              padding: const EdgeInsets.symmetric(horizontal: 40, vertical: 12),
              textStyle: const TextStyle(
                fontSize: 15,
                fontWeight: FontWeight.w500,
              ),
            ),
            child: const Text('طلب استثمار'),
          ),
        ],
      ),
    );
  }

  Widget _buildDesktopForm() {
    return Column(
      children: [
        Row(
          children: [
            Expanded(child: _buildTextField('الاسم')),
            const SizedBox(width: 20),
            Expanded(child: _buildTextField('البريد الإلكتروني')),
          ],
        ),
        const SizedBox(height: 20),
        Row(
          children: [
            Expanded(child: _buildTextField('رقم الهاتف')),
            const SizedBox(width: 20),
            Expanded(child: _buildTextField('المبلغ المراد استثماره')),
          ],
        ),
      ],
    );
  }

  Widget _buildMobileForm() {
    return Column(
      children: [
        _buildTextField('الاسم'),
        const SizedBox(height: 15),
        _buildTextField('البريد الإلكتروني'),
        const SizedBox(height: 15),
        _buildTextField('رقم الهاتف'),
        const SizedBox(height: 15),
        _buildTextField('المبلغ المراد استثماره'),
      ],
    );
  }

  Widget _buildTextField(String placeholder) {
    return TextFormField(
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
          borderSide: BorderSide.none,
        ),
        enabledBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(5),
          borderSide: BorderSide.none,
        ),
        focusedBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(5),
          borderSide: const BorderSide(color: AppColors.secondary, width: 1),
        ),
      ),
      style: const TextStyle(fontSize: 14),
    );
  }
}
