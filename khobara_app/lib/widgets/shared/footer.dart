import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import '../../utils/constants.dart';
import '../../services/api_service.dart';

class Footer extends StatefulWidget {
  const Footer({super.key});

  @override
  State<Footer> createState() => _FooterState();
}

class _FooterState extends State<Footer> {
  final _formKey = GlobalKey<FormState>();
  final _nameController = TextEditingController();
  final _phoneController = TextEditingController();
  final _cityController = TextEditingController();
  final _messageController = TextEditingController();
  String _inquiryType = 'استفسار';
  bool _isLoading = false;
  String? _errorMessage;
  String? _successMessage;

  final ApiService _apiService = ApiService();

  @override
  void dispose() {
    _nameController.dispose();
    _phoneController.dispose();
    _cityController.dispose();
    _messageController.dispose();
    super.dispose();
  }

  Future<void> _submitForm() async {
    if (_formKey.currentState!.validate()) {
      setState(() {
        _isLoading = true;
        _errorMessage = null;
        _successMessage = null;
      });

      try {
        final response = await _apiService.submitContactForm(
          name: _nameController.text,
          phone: _phoneController.text,
          inquiryType: _inquiryType,
          city: _cityController.text,
          message: _messageController.text,
        );

        setState(() {
          _isLoading = false;

          if (response['success']) {
            _successMessage = response['message'];
            // Clear form on success
            _nameController.clear();
            _phoneController.clear();
            _cityController.clear();
            _messageController.clear();
            _inquiryType = 'استفسار';
          } else {
            _errorMessage = response['message'];

            // إذا كان هناك retry_after، نعرض عداد تنازلي
            if (response.containsKey('retry_after')) {
              _showRateLimitDialog(response['retry_after'] as int);
            }
          }
        });
      } catch (e) {
        setState(() {
          _isLoading = false;
          _errorMessage = 'حدث خطأ غير متوقع. الرجاء المحاولة مرة أخرى لاحقاً.';
        });
      }
    }
  }

  // عرض مربع حوار مع عداد تنازلي عند تجاوز حد الطلبات
  void _showRateLimitDialog(int seconds) {
    showDialog(
      context: context,
      barrierDismissible: false,
      builder: (context) {
        int remainingSeconds = seconds;

        return StatefulBuilder(
          builder: (context, setState) {
            // بدء العداد التنازلي
            Future.delayed(const Duration(seconds: 1), () {
              if (remainingSeconds > 0 && Navigator.canPop(context)) {
                setState(() {
                  remainingSeconds--;
                });

                // إغلاق مربع الحوار عند انتهاء الوقت
                if (remainingSeconds <= 0) {
                  Navigator.pop(context);
                }
              }
            });

            return AlertDialog(
              title: const Text('تم تجاوز عدد المحاولات المسموح به'),
              content: Column(
                mainAxisSize: MainAxisSize.min,
                children: [
                  const Text(
                    'لقد تجاوزت الحد المسموح من المحاولات. يرجى الانتظار قبل إعادة المحاولة.',
                    textAlign: TextAlign.center,
                  ),
                  const SizedBox(height: 16),
                  Text(
                    'يمكنك المحاولة مرة أخرى بعد: $remainingSeconds ثانية',
                    style: const TextStyle(
                      fontWeight: FontWeight.bold,
                      color: AppColors.primary,
                    ),
                    textAlign: TextAlign.center,
                  ),
                ],
              ),
              actions: [
                TextButton(
                  onPressed: () {
                    Navigator.pop(context);
                  },
                  child: const Text('إغلاق'),
                ),
              ],
            );
          },
        );
      },
    );
  }

  @override
  Widget build(BuildContext context) {
    return Container(
      color: AppColors.lightGray,
      child: Column(
        children: [
          Padding(
            padding: const EdgeInsets.fromLTRB(16, 40, 16, 20),
            child: LayoutBuilder(
              builder: (context, constraints) {
                if (constraints.maxWidth > 768) {
                  return _buildDesktopLayout();
                } else {
                  return _buildMobileLayout();
                }
              },
            ),
          ),
          _buildFooterBottom(),
        ],
      ),
    );
  }

  Widget _buildDesktopLayout() {
    return Row(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Expanded(
          flex: 1,
          child: _buildContactMethods(),
        ),
        const SizedBox(width: 20),
        Expanded(
          flex: 1,
          child: _buildContactForm(),
        ),
      ],
    );
  }

  Widget _buildMobileLayout() {
    return Column(
      children: [
        _buildContactMethods(),
        const SizedBox(height: 20),
        _buildContactForm(),
      ],
    );
  }

  Widget _buildContactMethods() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          'طرق التواصل معنا',
          style: TextStyle(
            color: AppColors.primary,
            fontSize: 24,
            fontWeight: FontWeight.w600,
          ),
        ),
        const SizedBox(height: 20),
        Row(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Expanded(
              child: Column(
                children: [
                  _buildContactMethod('Facebook', FontAwesomeIcons.facebookF),
                  _buildContactMethod('Twitter', FontAwesomeIcons.twitter),
                  _buildContactMethod('Instagram', FontAwesomeIcons.instagram),
                  _buildContactMethod('LinkedIn', FontAwesomeIcons.linkedinIn),
                ],
              ),
            ),
            const SizedBox(width: 16),
            Expanded(
              child: Column(
                children: [
                  _buildContactMethod('info@5obara.com', Icons.email),
                  _buildContactMethod('+966569617288', Icons.phone),
                  _buildContactMethod('+966569617288', Icons.phone_android),
                  _buildContactMethod(
                      '+966569617288', FontAwesomeIcons.whatsapp),
                ],
              ),
            ),
          ],
        ),
      ],
    );
  }

  Widget _buildContactMethod(String label, IconData icon) {
    return Container(
      margin: const EdgeInsets.only(bottom: 12),
      padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 10),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(6),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.05),
            blurRadius: 10,
            offset: const Offset(0, 3),
          ),
        ],
      ),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Flexible(
            child: Text(
              label,
              style: const TextStyle(
                color: Color(0xFF555555),
                fontSize: 14,
                fontWeight: FontWeight.w500,
              ),
              overflow: TextOverflow.ellipsis,
            ),
          ),
          Container(
            width: 36,
            height: 36,
            decoration: BoxDecoration(
              color: AppColors.primary,
              shape: BoxShape.circle,
              boxShadow: [
                BoxShadow(
                  color: AppColors.primary.withOpacity(0.2),
                  blurRadius: 8,
                  offset: const Offset(0, 3),
                ),
              ],
            ),
            child: Icon(icon, color: Colors.white, size: 16),
          ),
        ],
      ),
    );
  }

  Widget _buildContactForm() {
    return Container(
      padding: const EdgeInsets.all(24),
      decoration: BoxDecoration(
        color: AppColors.primary,
        borderRadius: BorderRadius.circular(6),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.08),
            blurRadius: 30,
            offset: const Offset(0, 10),
          ),
        ],
      ),
      child: Form(
        key: _formKey,
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'أرسل لنا رسالة',
              style: TextStyle(
                color: Colors.white,
                fontSize: 24,
                fontWeight: FontWeight.w600,
              ),
              textAlign: TextAlign.center,
            ),
            const SizedBox(height: 20),
            if (_errorMessage != null)
              Container(
                padding: const EdgeInsets.all(8),
                decoration: BoxDecoration(
                  color: Colors.red.shade100,
                  borderRadius: BorderRadius.circular(4),
                ),
                child: Text(
                  _errorMessage!,
                  style: const TextStyle(
                      color: Colors.red, fontWeight: FontWeight.bold),
                ),
              ),
            if (_successMessage != null)
              Container(
                padding: const EdgeInsets.all(8),
                decoration: BoxDecoration(
                  color: Colors.green.shade100,
                  borderRadius: BorderRadius.circular(4),
                ),
                child: Text(
                  _successMessage!,
                  style: const TextStyle(
                      color: Colors.green, fontWeight: FontWeight.bold),
                ),
              ),
            if (_errorMessage != null || _successMessage != null)
              const SizedBox(height: 16),
            _buildNameField(),
            const SizedBox(height: 12),
            Row(
              children: [
                Expanded(
                  child: _buildPhoneField(),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: _buildInquiryTypeDropdown(),
                ),
              ],
            ),
            const SizedBox(height: 12),
            _buildCityField(),
            const SizedBox(height: 12),
            _buildMessageField(),
            const SizedBox(height: 16),
            SizedBox(
              width: double.infinity,
              child: ElevatedButton(
                onPressed: _isLoading ? null : _submitForm,
                style: ElevatedButton.styleFrom(
                  backgroundColor: Colors.white,
                  foregroundColor: AppColors.primary,
                  padding: const EdgeInsets.symmetric(vertical: 12),
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(6),
                  ),
                  elevation: 4,
                ),
                child: _isLoading
                    ? const SizedBox(
                        height: 20,
                        width: 20,
                        child: CircularProgressIndicator(
                          valueColor:
                              AlwaysStoppedAnimation<Color>(AppColors.primary),
                          strokeWidth: 2,
                        ),
                      )
                    : const Text(
                        'إرسال',
                        style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.w600,
                        ),
                      ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildNameField() {
    return TextFormField(
      controller: _nameController,
      decoration: InputDecoration(
        hintText: 'الاسم',
        filled: true,
        fillColor: Colors.white,
        border: OutlineInputBorder(
          borderRadius: BorderRadius.circular(4),
          borderSide: BorderSide.none,
        ),
        contentPadding: const EdgeInsets.symmetric(
          horizontal: 12,
          vertical: 8,
        ),
      ),
      validator: (value) {
        if (value == null || value.isEmpty) {
          return 'الرجاء إدخال الاسم';
        }
        return null;
      },
    );
  }

  Widget _buildPhoneField() {
    return Stack(
      children: [
        TextFormField(
          controller: _phoneController,
          keyboardType: TextInputType.phone,
          decoration: InputDecoration(
            hintText: 'مثال: 544902462',
            filled: true,
            fillColor: Colors.white,
            border: OutlineInputBorder(
              borderRadius: BorderRadius.circular(4),
              borderSide: BorderSide.none,
            ),
            contentPadding: const EdgeInsets.symmetric(
              horizontal: 60, // Space for the prefix
              vertical: 8,
            ),
          ),
          validator: (value) {
            if (value == null || value.isEmpty) {
              return 'الرجاء إدخال رقم الهاتف';
            }
            if (!RegExp(r'^[0-9\+\-\(\)\s]+$').hasMatch(value)) {
              return 'رقم هاتف غير صالح';
            }
            return null;
          },
        ),
        Positioned(
          left: 10,
          top: 12,
          child: Container(
            padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
            decoration: BoxDecoration(
              color: const Color(0xFFEEEEEE),
              borderRadius: BorderRadius.circular(3),
            ),
            child: const Text(
              '+966',
              style: TextStyle(
                color: Color(0xFF555555),
                fontSize: 13,
                fontWeight: FontWeight.w600,
              ),
            ),
          ),
        ),
      ],
    );
  }

  Widget _buildInquiryTypeDropdown() {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 8),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(4),
      ),
      child: DropdownButtonHideUnderline(
        child: DropdownButton<String>(
          value: _inquiryType,
          isExpanded: true,
          items: const [
            DropdownMenuItem(value: 'استفسار', child: Text('استفسار')),
            DropdownMenuItem(value: 'شكوى', child: Text('شكوى')),
            DropdownMenuItem(value: 'اقتراح', child: Text('اقتراح')),
            DropdownMenuItem(value: 'أخرى', child: Text('أخرى')),
          ],
          onChanged: (value) {
            if (value != null) {
              setState(() {
                _inquiryType = value;
              });
            }
          },
        ),
      ),
    );
  }

  Widget _buildCityField() {
    return TextFormField(
      controller: _cityController,
      decoration: InputDecoration(
        hintText: 'بأي مدينة مشروعك؟',
        filled: true,
        fillColor: Colors.white,
        border: OutlineInputBorder(
          borderRadius: BorderRadius.circular(4),
          borderSide: BorderSide.none,
        ),
        contentPadding: const EdgeInsets.symmetric(
          horizontal: 12,
          vertical: 8,
        ),
      ),
      validator: (value) {
        if (value == null || value.isEmpty) {
          return 'الرجاء إدخال المدينة';
        }
        return null;
      },
    );
  }

  Widget _buildMessageField() {
    return TextFormField(
      controller: _messageController,
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
          horizontal: 12,
          vertical: 8,
        ),
      ),
      validator: (value) {
        if (value == null || value.isEmpty) {
          return 'الرجاء إدخال الرسالة';
        }
        return null;
      },
    );
  }

  Widget _buildFooterBottom() {
    return Container(
      width: double.infinity,
      color: Colors.white,
      padding: const EdgeInsets.symmetric(vertical: 30),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Image.asset(
            AppAssets.footerLogo,
            height: 100,
            fit: BoxFit.contain,
          ),
          const SizedBox(height: 12),
          const Text(
            'جميع الحقوق محفوظة © 2024',
            style: TextStyle(
              color: Color(0xFF666666),
              fontSize: 14,
              fontWeight: FontWeight.w500,
            ),
          ),
        ],
      ),
    );
  }
}
