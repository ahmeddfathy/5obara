import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:url_launcher/url_launcher.dart';
import '../utils/constants.dart';
import '../widgets/shared/top_bar.dart';
import '../widgets/shared/header.dart';
import '../widgets/shared/footer.dart';
import '../widgets/shared/app_drawer.dart';
import '../widgets/contact/contact_info.dart';

class ContactScreen extends StatefulWidget {
  const ContactScreen({super.key});

  @override
  State<ContactScreen> createState() => _ContactScreenState();
}

class _ContactScreenState extends State<ContactScreen> {
  final _formKey = GlobalKey<FormState>();
  final TextEditingController _nameController = TextEditingController();
  final TextEditingController _emailController = TextEditingController();
  final TextEditingController _phoneController = TextEditingController();
  final TextEditingController _cityController = TextEditingController();
  final TextEditingController _messageController = TextEditingController();
  String? _selectedService;

  final List<String> _services = [
    'استشارة',
    'دراسة جدوى',
    'خطة عمل',
    'دراسة سوق',
    'أخرى',
  ];

  @override
  void dispose() {
    _nameController.dispose();
    _emailController.dispose();
    _phoneController.dispose();
    _cityController.dispose();
    _messageController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final screenWidth = MediaQuery.of(context).size.width;
    final isDesktop = screenWidth > 600;

    return Scaffold(
      backgroundColor: AppColors.lightGray,
      drawer: const AppDrawer(),
      body: SafeArea(
        child: SingleChildScrollView(
          child: Column(
            children: [
              const TopBar(),
              const Header(),
              _buildHeroSection(context),
              _buildContactFormSection(context),
              _buildBranchSection(context),
              _buildFloatingChatButtons(),
              const Footer(),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildHeroSection(BuildContext context) {
    final screenWidth = MediaQuery.of(context).size.width;
    final isDesktop = screenWidth > 600;

    return Container(
      height: isDesktop ? 500 : 400,
      width: double.infinity,
      decoration: const BoxDecoration(
        image: DecorationImage(
          image: AssetImage('assets/images/contact/contact-us.jpg'),
          fit: BoxFit.cover,
          colorFilter: ColorFilter.mode(
            Color.fromRGBO(0, 0, 0, 0.4),
            BlendMode.darken,
          ),
        ),
      ),
      child: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Text(
              AppStrings.contactUs,
              style: TextStyle(
                color: Colors.white,
                fontSize: isDesktop ? 54 : 42,
                fontWeight: FontWeight.bold,
                shadows: [
                  const Shadow(
                    offset: Offset(1, 1),
                    blurRadius: 3.0,
                    color: Color.fromARGB(150, 0, 0, 0),
                  ),
                ],
              ),
            ),
            const SizedBox(height: 20),
            SizedBox(
              width: isDesktop ? 800 : screenWidth * 0.9,
              child: Text(
                'نحن هنا لمساعدتك في تحقيق أهداف مشروعك. تواصل معنا الآن ودعنا نبدأ رحلة نجاحك',
                style: TextStyle(
                  color: Colors.white,
                  fontSize: isDesktop ? 22 : 18,
                  height: 1.6,
                  shadows: [
                    const Shadow(
                      offset: Offset(1, 1),
                      blurRadius: 3.0,
                      color: Color.fromARGB(150, 0, 0, 0),
                    ),
                  ],
                ),
                textAlign: TextAlign.center,
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildContactFormSection(BuildContext context) {
    final screenWidth = MediaQuery.of(context).size.width;
    final isDesktop = screenWidth > 600;

    return Container(
      padding: EdgeInsets.symmetric(
        vertical: isDesktop ? 60 : 40,
        horizontal: isDesktop ? 20 : 12,
      ),
      child: Center(
        child: ConstrainedBox(
          constraints:
              BoxConstraints(maxWidth: isDesktop ? 800 : screenWidth * 0.95),
          child: Container(
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(12),
              boxShadow: [
                BoxShadow(
                  color: Colors.black.withOpacity(0.1),
                  blurRadius: 20,
                  offset: const Offset(0, 5),
                ),
              ],
            ),
            padding: EdgeInsets.all(isDesktop ? 30 : 16),
            child: Form(
              key: _formKey,
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    'نموذج التواصل',
                    style: TextStyle(
                      fontSize: isDesktop ? 28 : 24,
                      fontWeight: FontWeight.bold,
                      color: AppColors.secondary,
                    ),
                  ),
                  const SizedBox(height: 30),
                  if (isDesktop)
                    Row(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Expanded(
                          child: _buildTextField(
                            controller: _nameController,
                            label: 'الاسم الكامل',
                            validator: (value) {
                              if (value == null || value.isEmpty) {
                                return 'الرجاء إدخال الاسم';
                              }
                              return null;
                            },
                          ),
                        ),
                        const SizedBox(width: 16),
                        Expanded(
                          child: _buildPhoneField(),
                        ),
                      ],
                    )
                  else
                    Column(
                      children: [
                        _buildTextField(
                          controller: _nameController,
                          label: 'الاسم الكامل',
                          validator: (value) {
                            if (value == null || value.isEmpty) {
                              return 'الرجاء إدخال الاسم';
                            }
                            return null;
                          },
                        ),
                        const SizedBox(height: 16),
                        _buildPhoneField(),
                      ],
                    ),
                  const SizedBox(height: 16),
                  if (isDesktop)
                    Row(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Expanded(
                          child: _buildTextField(
                            controller: _emailController,
                            label: 'البريد الإلكتروني',
                            keyboardType: TextInputType.emailAddress,
                            validator: (value) {
                              if (value == null || value.isEmpty) {
                                return 'الرجاء إدخال البريد الإلكتروني';
                              }
                              if (!value.contains('@') ||
                                  !value.contains('.')) {
                                return 'الرجاء إدخال بريد إلكتروني صحيح';
                              }
                              return null;
                            },
                          ),
                        ),
                        const SizedBox(width: 16),
                        Expanded(
                          child: _buildTextField(
                            controller: _cityController,
                            label: 'المدينة',
                            validator: (value) {
                              if (value == null || value.isEmpty) {
                                return 'الرجاء إدخال المدينة';
                              }
                              return null;
                            },
                          ),
                        ),
                      ],
                    )
                  else
                    Column(
                      children: [
                        _buildTextField(
                          controller: _emailController,
                          label: 'البريد الإلكتروني',
                          keyboardType: TextInputType.emailAddress,
                          validator: (value) {
                            if (value == null || value.isEmpty) {
                              return 'الرجاء إدخال البريد الإلكتروني';
                            }
                            if (!value.contains('@') || !value.contains('.')) {
                              return 'الرجاء إدخال بريد إلكتروني صحيح';
                            }
                            return null;
                          },
                        ),
                        const SizedBox(height: 16),
                        _buildTextField(
                          controller: _cityController,
                          label: 'المدينة',
                          validator: (value) {
                            if (value == null || value.isEmpty) {
                              return 'الرجاء إدخال المدينة';
                            }
                            return null;
                          },
                        ),
                      ],
                    ),
                  const SizedBox(height: 16),
                  _buildDropdownField(),
                  const SizedBox(height: 16),
                  _buildTextField(
                    controller: _messageController,
                    label: 'تفاصيل المشروع',
                    maxLines: 5,
                    validator: (value) {
                      if (value == null || value.isEmpty) {
                        return 'الرجاء إدخال تفاصيل المشروع';
                      }
                      return null;
                    },
                  ),
                  const SizedBox(height: 24),
                  SizedBox(
                    width: double.infinity,
                    height: 50,
                    child: ElevatedButton.icon(
                      onPressed: _submitForm,
                      style: ElevatedButton.styleFrom(
                        backgroundColor: AppColors.primary,
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(8),
                        ),
                      ),
                      icon: const Icon(Icons.send, size: 18),
                      label: Text(
                        'إرسال الطلب',
                        style: TextStyle(
                          fontSize: isDesktop ? 18 : 16,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildBranchSection(BuildContext context) {
    final screenWidth = MediaQuery.of(context).size.width;
    final isDesktop = screenWidth > 600;

    return Container(
      padding: EdgeInsets.symmetric(
        vertical: isDesktop ? 60 : 40,
        horizontal: isDesktop ? 20 : 12,
      ),
      color: AppColors.lightGray,
      child: Column(
        children: [
          Text(
            'معلومات التواصل',
            style: TextStyle(
              fontSize: isDesktop ? 32 : 28,
              fontWeight: FontWeight.bold,
              color: AppColors.secondary,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 40),
          Wrap(
            spacing: isDesktop ? 30 : 16,
            runSpacing: isDesktop ? 30 : 16,
            alignment: WrapAlignment.center,
            children: [
              _buildContactItem(
                icon: Icons.location_on,
                text: 'جدة - طريق الكورنيش - مبنى كورنيز الدور الرابع',
              ),
              _buildContactItem(
                icon: Icons.phone,
                text: AppStrings.contactPhone,
                onTap: () => _makePhoneCall(AppStrings.contactPhone),
              ),
              _buildContactItem(
                icon: Icons.email,
                text: AppStrings.contactEmail,
                onTap: () => _launchEmail(AppStrings.contactEmail),
              ),
            ],
          ),
          const SizedBox(height: 32),
          Wrap(
            spacing: 12,
            children: [
              _buildSocialIcon(FontAwesomeIcons.facebookF, AppColors.facebook,
                  'https://facebook.com/5obara'),
              _buildSocialIcon(FontAwesomeIcons.twitter, AppColors.twitter,
                  'https://twitter.com/5obara'),
              _buildSocialIcon(FontAwesomeIcons.instagram, AppColors.instagram,
                  'https://instagram.com/5obara'),
              _buildSocialIcon(FontAwesomeIcons.linkedinIn, AppColors.linkedin,
                  'https://linkedin.com/company/5obara'),
            ],
          ),
          const SizedBox(height: 32),
          ElevatedButton.icon(
            onPressed: () =>
                _launchUrl('https://wa.me/${AppStrings.contactPhone}'),
            style: ElevatedButton.styleFrom(
              backgroundColor: AppColors.whatsapp,
              padding: EdgeInsets.symmetric(
                horizontal: isDesktop ? 25 : 16,
                vertical: 12,
              ),
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(8),
              ),
            ),
            icon: const Icon(FontAwesomeIcons.whatsapp),
            label: Text(
              'تواصل معنا عبر الواتساب',
              style: TextStyle(
                fontSize: isDesktop ? 16 : 14,
                fontWeight: FontWeight.w600,
              ),
            ),
          ),
          const SizedBox(height: 32),
          Center(
            child: Image.asset(
              'assets/images/footer-logo.png',
              width: isDesktop ? 120 : 100,
              fit: BoxFit.contain,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildFloatingChatButtons() {
    return Positioned(
      bottom: 20,
      left: 20,
      child: Column(
        children: [
          FloatingActionButton(
            heroTag: 'whatsapp',
            backgroundColor: AppColors.whatsapp,
            onPressed: () =>
                _launchUrl('https://wa.me/${AppStrings.contactPhone}'),
            child: const Icon(
              FontAwesomeIcons.whatsapp,
              color: Colors.white,
            ),
          ),
          const SizedBox(height: 15),
          FloatingActionButton(
            heroTag: 'messenger',
            backgroundColor: AppColors.facebook,
            onPressed: () => _launchUrl('https://m.me/5obara'),
            child: const Icon(
              FontAwesomeIcons.facebookMessenger,
              color: Colors.white,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildContactItem({
    required IconData icon,
    required String text,
    VoidCallback? onTap,
  }) {
    return GestureDetector(
      onTap: onTap,
      child: Container(
        padding: const EdgeInsets.symmetric(vertical: 12, horizontal: 16),
        color: Colors.transparent,
        child: Row(
          mainAxisSize: MainAxisSize.min,
          children: [
            Icon(
              icon,
              color: AppColors.primary,
              size: 20,
            ),
            const SizedBox(width: 8),
            Flexible(
              child: Text(
                text,
                style: const TextStyle(
                  fontSize: 14,
                  color: AppColors.textColor,
                ),
                overflow: TextOverflow.ellipsis,
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildSocialIcon(IconData icon, Color color, String url) {
    return GestureDetector(
      onTap: () => _launchUrl(url),
      child: Container(
        width: 40,
        height: 40,
        decoration: BoxDecoration(
          color: color,
          shape: BoxShape.circle,
        ),
        child: Center(
          child: FaIcon(
            icon,
            color: Colors.white,
            size: 18,
          ),
        ),
      ),
    );
  }

  Widget _buildTextField({
    required TextEditingController controller,
    required String label,
    TextInputType keyboardType = TextInputType.text,
    int maxLines = 1,
    String? Function(String?)? validator,
  }) {
    return TextFormField(
      controller: controller,
      keyboardType: keyboardType,
      maxLines: maxLines,
      decoration: InputDecoration(
        labelText: label,
        filled: true,
        fillColor: Colors.white,
        border: OutlineInputBorder(
          borderRadius: BorderRadius.circular(8),
          borderSide: const BorderSide(color: Colors.grey),
        ),
        focusedBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(8),
          borderSide: const BorderSide(color: AppColors.primary, width: 2),
        ),
      ),
      validator: validator,
    );
  }

  Widget _buildPhoneField() {
    return TextFormField(
      controller: _phoneController,
      keyboardType: TextInputType.phone,
      decoration: InputDecoration(
        labelText: 'رقم الهاتف',
        filled: true,
        fillColor: Colors.white,
        prefixIcon: Container(
          margin: const EdgeInsets.symmetric(horizontal: 8),
          padding: const EdgeInsets.symmetric(horizontal: 8),
          child: const Text(
            '966+',
            style: TextStyle(fontSize: 16, color: AppColors.textLight),
          ),
        ),
        prefixIconConstraints: const BoxConstraints(minWidth: 0, minHeight: 0),
        border: OutlineInputBorder(
          borderRadius: BorderRadius.circular(8),
          borderSide: const BorderSide(color: Colors.grey),
        ),
        focusedBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(8),
          borderSide: const BorderSide(color: AppColors.primary, width: 2),
        ),
      ),
      validator: (value) {
        if (value == null || value.isEmpty) {
          return 'الرجاء إدخال رقم الهاتف';
        }
        return null;
      },
    );
  }

  Widget _buildDropdownField() {
    return DropdownButtonFormField<String>(
      value: _selectedService,
      decoration: InputDecoration(
        labelText: 'نوع الخدمة المطلوبة',
        filled: true,
        fillColor: Colors.white,
        border: OutlineInputBorder(
          borderRadius: BorderRadius.circular(8),
          borderSide: const BorderSide(color: Colors.grey),
        ),
        focusedBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(8),
          borderSide: const BorderSide(color: AppColors.primary, width: 2),
        ),
      ),
      items: _services.map((String service) {
        return DropdownMenuItem<String>(
          value: service,
          child: Text(service),
        );
      }).toList(),
      onChanged: (String? newValue) {
        setState(() {
          _selectedService = newValue;
        });
      },
      validator: (value) {
        if (value == null || value.isEmpty) {
          return 'الرجاء اختيار نوع الخدمة';
        }
        return null;
      },
    );
  }

  void _submitForm() {
    if (_formKey.currentState!.validate()) {
      // Form submission logic here
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('تم إرسال طلبك بنجاح، سنتواصل معك قريباً'),
          backgroundColor: AppColors.primary,
        ),
      );

      // Reset form
      _nameController.clear();
      _emailController.clear();
      _phoneController.clear();
      _cityController.clear();
      _messageController.clear();
      setState(() {
        _selectedService = null;
      });
    }
  }

  Future<void> _launchUrl(String url) async {
    final Uri uri = Uri.parse(url);
    if (!await launchUrl(uri, mode: LaunchMode.externalApplication)) {
      debugPrint('Could not launch $url');
    }
  }

  Future<void> _makePhoneCall(String phoneNumber) async {
    final Uri launchUri = Uri(scheme: 'tel', path: phoneNumber);
    await launchUrl(launchUri);
  }

  Future<void> _launchEmail(String email) async {
    final Uri launchUri = Uri(scheme: 'mailto', path: email);
    await launchUrl(launchUri);
  }
}
