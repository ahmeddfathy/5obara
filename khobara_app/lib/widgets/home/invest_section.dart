import 'package:flutter/material.dart';
import '../../utils/constants.dart';

class InvestSection extends StatelessWidget {
  const InvestSection({super.key});

  @override
  Widget build(BuildContext context) {
    return Stack(
      children: [
        // Background shapes
        Positioned(
          left: -100,
          bottom: -50,
          child: Container(
            width: 300,
            height: 300,
            decoration: BoxDecoration(
              color: AppColors.primary.withOpacity(0.1),
              borderRadius: BorderRadius.circular(150),
            ),
          ),
        ),
        Positioned(
          right: -80,
          top: -30,
          child: Container(
            width: 200,
            height: 200,
            decoration: BoxDecoration(
              color: AppColors.primary.withOpacity(0.1),
              borderRadius: BorderRadius.circular(100),
            ),
          ),
        ),
        // Main content
        Container(
          width: double.infinity,
          color: Colors.transparent,
          padding: const EdgeInsets.symmetric(vertical: 100, horizontal: 20),
          child: Column(
            children: [
              Column(
                children: [
                  const Text(
                    'استثمر معنا',
                    style: TextStyle(
                      color: AppColors.secondary,
                      fontSize: 48,
                      fontWeight: FontWeight.w800,
                    ),
                  ),
                  Container(
                    width: 64,
                    height: 4,
                    margin: const EdgeInsets.only(top: 16),
                    decoration: BoxDecoration(
                      color: AppColors.primary,
                      borderRadius: BorderRadius.circular(2),
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 24),
              Container(
                constraints: const BoxConstraints(maxWidth: 700),
                child: const Text(
                  'يمكنك إدخال رأس المال وسنتواصل معك بأفضل المشاريع - أطلب الان دراسة جدوى إقتصادية مفصلة لمشروعك',
                  textAlign: TextAlign.center,
                  style: TextStyle(
                    color: Color(0xFF64748B),
                    fontSize: 20,
                    height: 1.6,
                    fontWeight: FontWeight.w500,
                  ),
                ),
              ),
              const SizedBox(height: 60),
              Container(
                constraints: const BoxConstraints(maxWidth: 800),
                padding: const EdgeInsets.all(48),
                decoration: BoxDecoration(
                  color: Colors.white,
                  borderRadius: BorderRadius.circular(16),
                  border: Border.all(
                    color: const Color(0xFFE2E8F0),
                    width: 1,
                  ),
                  boxShadow: [
                    BoxShadow(
                      color: Colors.black.withOpacity(0.08),
                      blurRadius: 24,
                      offset: const Offset(0, 12),
                    ),
                  ],
                ),
                child: LayoutBuilder(
                  builder: (context, constraints) {
                    if (constraints.maxWidth > 600) {
                      return Column(
                        children: [
                          Row(
                            children: [
                              Expanded(
                                child: _buildTextField('الاسم'),
                              ),
                              const SizedBox(width: 24),
                              Expanded(
                                child: _buildTextField('رقم الهاتف'),
                              ),
                            ],
                          ),
                          const SizedBox(height: 24),
                          Row(
                            children: [
                              Expanded(
                                child: _buildTextField('البريد الإلكتروني'),
                              ),
                              const SizedBox(width: 24),
                              Expanded(
                                child:
                                    _buildTextField('المبلغ المراد استثماره'),
                              ),
                            ],
                          ),
                          const SizedBox(height: 40),
                          _buildSubmitButton(),
                        ],
                      );
                    } else {
                      return Column(
                        children: [
                          _buildTextField('الاسم'),
                          const SizedBox(height: 24),
                          _buildTextField('رقم الهاتف'),
                          const SizedBox(height: 24),
                          _buildTextField('البريد الإلكتروني'),
                          const SizedBox(height: 24),
                          _buildTextField('المبلغ المراد استثماره'),
                          const SizedBox(height: 40),
                          _buildSubmitButton(),
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
    );
  }

  Widget _buildTextField(String placeholder) {
    return TextFormField(
      textAlign: TextAlign.right,
      decoration: InputDecoration(
        filled: true,
        fillColor: const Color(0xFFF8FAFC),
        contentPadding: const EdgeInsets.symmetric(
          horizontal: 20,
          vertical: 20,
        ),
        hintText: placeholder,
        hintStyle: const TextStyle(
          color: Color(0xFF94A3B8),
          fontSize: 16,
        ),
        border: OutlineInputBorder(
          borderRadius: BorderRadius.circular(12),
          borderSide: BorderSide.none,
        ),
        enabledBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(12),
          borderSide: BorderSide.none,
        ),
        focusedBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(12),
          borderSide: const BorderSide(color: AppColors.primary, width: 2),
        ),
      ),
      style: const TextStyle(
        fontSize: 16,
        color: Color(0xFF334155),
      ),
    );
  }

  Widget _buildSubmitButton() {
    return SizedBox(
      width: double.infinity,
      child: ElevatedButton(
        onPressed: () {},
        style: ElevatedButton.styleFrom(
          backgroundColor: AppColors.primary,
          foregroundColor: Colors.white,
          padding: const EdgeInsets.symmetric(
            horizontal: 48,
            vertical: 20,
          ),
          textStyle: const TextStyle(
            fontSize: 18,
            fontWeight: FontWeight.w600,
          ),
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(12),
          ),
          elevation: 0,
        ),
        child: const Text('طلب استثمار'),
      ),
    );
  }
}
