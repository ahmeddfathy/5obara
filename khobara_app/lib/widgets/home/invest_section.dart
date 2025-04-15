import 'package:flutter/material.dart';
import '../../utils/constants.dart';
import '../../services/api_service.dart';

class InvestSection extends StatefulWidget {
  const InvestSection({super.key});

  @override
  State<InvestSection> createState() => _InvestSectionState();
}

class _InvestSectionState extends State<InvestSection> {
  final _formKey = GlobalKey<FormState>();
  final _nameController = TextEditingController();
  final _phoneController = TextEditingController();
  final _emailController = TextEditingController();
  final _amountController = TextEditingController();
  String _selectedInvestmentType = 'استثمار';
  bool _isLoading = false;
  String? _errorMessage;
  String? _successMessage;

  final ApiService _apiService = ApiService();

  @override
  void dispose() {
    _nameController.dispose();
    _phoneController.dispose();
    _emailController.dispose();
    _amountController.dispose();
    super.dispose();
  }

  Future<void> _submitInvestment() async {
    if (_formKey.currentState!.validate()) {
      setState(() {
        _isLoading = true;
        _errorMessage = null;
        _successMessage = null;
      });

      try {
        final response = await _apiService.submitInvestment(
          name: _nameController.text,
          email: _emailController.text,
          phone: _phoneController.text,
          investmentAmount: _amountController.text,
          formType: _selectedInvestmentType,
        );

        setState(() {
          _isLoading = false;

          if (response['success']) {
            _successMessage = response['message'];
            // Clear form on success
            _nameController.clear();
            _phoneController.clear();
            _emailController.clear();
            _amountController.clear();
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
                child: Form(
                  key: _formKey,
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.stretch,
                    children: [
                      if (_errorMessage != null)
                        Container(
                          margin: const EdgeInsets.only(bottom: 16),
                          padding: const EdgeInsets.all(12),
                          decoration: BoxDecoration(
                            color: Colors.red.shade50,
                            borderRadius: BorderRadius.circular(8),
                            border: Border.all(color: Colors.red.shade200),
                          ),
                          child: Text(
                            _errorMessage!,
                            textAlign: TextAlign.center,
                            style: TextStyle(
                              color: Colors.red.shade700,
                              fontWeight: FontWeight.bold,
                            ),
                          ),
                        ),
                      if (_successMessage != null)
                        Container(
                          margin: const EdgeInsets.only(bottom: 16),
                          padding: const EdgeInsets.all(12),
                          decoration: BoxDecoration(
                            color: Colors.green.shade50,
                            borderRadius: BorderRadius.circular(8),
                            border: Border.all(color: Colors.green.shade200),
                          ),
                          child: Text(
                            _successMessage!,
                            textAlign: TextAlign.center,
                            style: TextStyle(
                              color: Colors.green.shade700,
                              fontWeight: FontWeight.bold,
                            ),
                          ),
                        ),
                      LayoutBuilder(
                        builder: (context, constraints) {
                          if (constraints.maxWidth > 600) {
                            return Column(
                              children: [
                                Row(
                                  children: [
                                    Expanded(
                                      child: _buildNameField(),
                                    ),
                                    const SizedBox(width: 24),
                                    Expanded(
                                      child: _buildPhoneField(),
                                    ),
                                  ],
                                ),
                                const SizedBox(height: 24),
                                Row(
                                  children: [
                                    Expanded(
                                      child: _buildEmailField(),
                                    ),
                                    const SizedBox(width: 24),
                                    Expanded(
                                      child: _buildAmountField(),
                                    ),
                                  ],
                                ),
                                const SizedBox(height: 24),
                                _buildInvestmentTypeDropdown(),
                                const SizedBox(height: 40),
                                _buildSubmitButton(),
                              ],
                            );
                          } else {
                            return Column(
                              children: [
                                _buildNameField(),
                                const SizedBox(height: 24),
                                _buildPhoneField(),
                                const SizedBox(height: 24),
                                _buildEmailField(),
                                const SizedBox(height: 24),
                                _buildAmountField(),
                                const SizedBox(height: 24),
                                _buildInvestmentTypeDropdown(),
                                const SizedBox(height: 40),
                                _buildSubmitButton(),
                              ],
                            );
                          }
                        },
                      ),
                    ],
                  ),
                ),
              ),
            ],
          ),
        ),
      ],
    );
  }

  Widget _buildNameField() {
    return TextFormField(
      controller: _nameController,
      textAlign: TextAlign.right,
      decoration: InputDecoration(
        filled: true,
        fillColor: const Color(0xFFF8FAFC),
        contentPadding: const EdgeInsets.symmetric(
          horizontal: 20,
          vertical: 20,
        ),
        hintText: "الاسم",
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
        errorBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(12),
          borderSide: BorderSide(color: Colors.red.shade300, width: 1),
        ),
      ),
      style: const TextStyle(
        fontSize: 16,
        color: Color(0xFF334155),
      ),
      validator: (value) {
        if (value == null || value.trim().isEmpty) {
          return 'يرجى إدخال الاسم';
        }
        return null;
      },
    );
  }

  Widget _buildPhoneField() {
    return TextFormField(
      controller: _phoneController,
      textAlign: TextAlign.right,
      keyboardType: TextInputType.phone,
      decoration: InputDecoration(
        filled: true,
        fillColor: const Color(0xFFF8FAFC),
        contentPadding: const EdgeInsets.symmetric(
          horizontal: 20,
          vertical: 20,
        ),
        hintText: "رقم الهاتف",
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
        errorBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(12),
          borderSide: BorderSide(color: Colors.red.shade300, width: 1),
        ),
      ),
      style: const TextStyle(
        fontSize: 16,
        color: Color(0xFF334155),
      ),
      validator: (value) {
        if (value == null || value.trim().isEmpty) {
          return 'يرجى إدخال رقم الهاتف';
        }
        if (!RegExp(r'^[0-9\+\-\(\)\s]+$').hasMatch(value)) {
          return 'يرجى إدخال رقم هاتف صحيح';
        }
        return null;
      },
    );
  }

  Widget _buildEmailField() {
    return TextFormField(
      controller: _emailController,
      textAlign: TextAlign.right,
      keyboardType: TextInputType.emailAddress,
      decoration: InputDecoration(
        filled: true,
        fillColor: const Color(0xFFF8FAFC),
        contentPadding: const EdgeInsets.symmetric(
          horizontal: 20,
          vertical: 20,
        ),
        hintText: "البريد الإلكتروني",
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
        errorBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(12),
          borderSide: BorderSide(color: Colors.red.shade300, width: 1),
        ),
      ),
      style: const TextStyle(
        fontSize: 16,
        color: Color(0xFF334155),
      ),
      validator: (value) {
        if (value == null || value.trim().isEmpty) {
          return 'يرجى إدخال البريد الإلكتروني';
        }
        if (!RegExp(r'^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$').hasMatch(value)) {
          return 'يرجى إدخال بريد إلكتروني صحيح';
        }
        return null;
      },
    );
  }

  Widget _buildAmountField() {
    return TextFormField(
      controller: _amountController,
      textAlign: TextAlign.right,
      decoration: InputDecoration(
        filled: true,
        fillColor: const Color(0xFFF8FAFC),
        contentPadding: const EdgeInsets.symmetric(
          horizontal: 20,
          vertical: 20,
        ),
        hintText: "المبلغ المراد استثماره",
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
        errorBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(12),
          borderSide: BorderSide(color: Colors.red.shade300, width: 1),
        ),
      ),
      style: const TextStyle(
        fontSize: 16,
        color: Color(0xFF334155),
      ),
      validator: (value) {
        if (value == null || value.trim().isEmpty) {
          return 'يرجى إدخال المبلغ المراد استثماره';
        }
        return null;
      },
    );
  }

  Widget _buildInvestmentTypeDropdown() {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 5),
      decoration: BoxDecoration(
        color: const Color(0xFFF8FAFC),
        borderRadius: BorderRadius.circular(12),
      ),
      child: DropdownButtonHideUnderline(
        child: DropdownButton<String>(
          value: _selectedInvestmentType,
          isExpanded: true,
          style: const TextStyle(
            fontSize: 16,
            color: Color(0xFF334155),
          ),
          dropdownColor: Colors.white,
          items: const [
            DropdownMenuItem(value: 'استثمار', child: Text('استثمار')),
            DropdownMenuItem(value: 'شراكة', child: Text('شراكة')),
            DropdownMenuItem(value: 'تمويل', child: Text('تمويل')),
          ],
          onChanged: (value) {
            if (value != null) {
              setState(() {
                _selectedInvestmentType = value;
              });
            }
          },
        ),
      ),
    );
  }

  Widget _buildSubmitButton() {
    return SizedBox(
      width: double.infinity,
      child: ElevatedButton(
        onPressed: _isLoading ? null : _submitInvestment,
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
          disabledBackgroundColor: AppColors.primary.withOpacity(0.7),
        ),
        child: _isLoading
            ? const SizedBox(
                height: 24,
                width: 24,
                child: CircularProgressIndicator(
                  valueColor: AlwaysStoppedAnimation<Color>(Colors.white),
                  strokeWidth: 2,
                ),
              )
            : const Text('طلب استثمار'),
      ),
    );
  }
}
