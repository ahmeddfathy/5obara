import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:url_launcher/url_launcher.dart';
import '../../utils/constants.dart';

class HeroSection extends StatelessWidget {
  const HeroSection({super.key});

  @override
  Widget build(BuildContext context) {
    return Container(
      height: MediaQuery.of(context).size.height * 0.8,
      width: double.infinity,
      decoration: BoxDecoration(
        image: DecorationImage(
          image: const AssetImage(AppAssets.mainImage),
          fit: BoxFit.cover,
          colorFilter: ColorFilter.mode(
            Colors.black.withOpacity(0.6),
            BlendMode.darken,
          ),
        ),
      ),
      child: Stack(
        children: [
          // Background overlay gradient
          Container(
            decoration: BoxDecoration(
              gradient: LinearGradient(
                begin: Alignment.topCenter,
                end: Alignment.bottomCenter,
                colors: [
                  Colors.black.withOpacity(0.4),
                  Colors.black.withOpacity(0.2),
                ],
              ),
            ),
          ),
          // Content
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 16),
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              crossAxisAlignment: CrossAxisAlignment.end,
              children: [
                Container(
                  constraints: BoxConstraints(
                    maxWidth: MediaQuery.of(context).size.width * 0.8,
                  ),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.end,
                    children: [
                      Text(
                        AppStrings.requestNow,
                        style: TextStyle(
                          fontSize:
                              MediaQuery.of(context).size.width > 600 ? 32 : 24,
                          fontWeight: FontWeight.w700,
                          color: AppColors.primary,
                          height: 1.4,
                          shadows: [
                            Shadow(
                              offset: Offset(0, 2),
                              blurRadius: 4.0,
                              color: Color.fromARGB(100, 0, 0, 0),
                            ),
                          ],
                        ),
                      ),
                      const SizedBox(height: 16),
                      Text(
                        AppStrings.mainTitle,
                        style: TextStyle(
                          fontSize:
                              MediaQuery.of(context).size.width > 600 ? 48 : 32,
                          fontWeight: FontWeight.w800,
                          color: Colors.white,
                          height: 1.2,
                          shadows: [
                            Shadow(
                              offset: Offset(0, 2),
                              blurRadius: 4.0,
                              color: Color.fromARGB(100, 0, 0, 0),
                            ),
                          ],
                        ),
                        textAlign: TextAlign.right,
                      ),
                      const SizedBox(height: 32),
                      Wrap(
                        alignment: WrapAlignment.end,
                        spacing: 16,
                        runSpacing: 16,
                        children: [
                          _buildButton(
                            text: AppStrings.requestFeasibilityStudy,
                            icon: Icons.file_copy_outlined,
                            backgroundColor: AppColors.primary,
                            onPressed: () =>
                                _launchURL('https://5obara.com/start-project'),
                          ),
                          _buildButton(
                            text: AppStrings.contactViaWhatsapp,
                            icon: FontAwesomeIcons.whatsapp,
                            backgroundColor: AppColors.whatsapp,
                            onPressed: () => _launchURL(
                                'https://wa.me/${AppStrings.contactPhone}'),
                          ),
                        ],
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Future<void> _launchURL(String url) async {
    final Uri uri = Uri.parse(url);
    if (!await launchUrl(uri, mode: LaunchMode.externalApplication)) {
      debugPrint('Could not launch $url');
    }
  }

  Widget _buildButton({
    required String text,
    required IconData icon,
    required Color backgroundColor,
    required VoidCallback onPressed,
  }) {
    return ElevatedButton.icon(
      onPressed: onPressed,
      style: ElevatedButton.styleFrom(
        backgroundColor: backgroundColor,
        foregroundColor: Colors.white,
        padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 16),
        textStyle: const TextStyle(
          fontSize: 16,
          fontWeight: FontWeight.w600,
        ),
        elevation: 0,
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(12),
        ),
      ),
      icon: Icon(icon, size: 20),
      label: Text(text),
    );
  }
}
