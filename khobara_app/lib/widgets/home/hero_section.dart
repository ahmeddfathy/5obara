import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';

import '../../utils/constants.dart';

class HeroSection extends StatelessWidget {
  const HeroSection({super.key});

  @override
  Widget build(BuildContext context) {
    return Container(
      height: 500,
      width: double.infinity,
      decoration: BoxDecoration(
        color: AppColors.primary.withOpacity(0.8), // Fallback background color
        image: DecorationImage(
          image: _getBackgroundImage(),
          fit: BoxFit.cover,
          colorFilter: ColorFilter.mode(
            Colors.black.withOpacity(0.65),
            BlendMode.darken,
          ),
          onError: (exception, stackTrace) {
            debugPrint('Error loading background image: $exception');
          },
        ),
      ),
      child: Container(
        padding: const EdgeInsets.symmetric(horizontal: 20),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              AppStrings.requestNow,
              style: const TextStyle(
                fontSize: 22,
                fontWeight: FontWeight.w500,
                color: AppColors.primary,
              ),
            ),
            const SizedBox(height: 15),
            Text(
              AppStrings.mainTitle,
              style: const TextStyle(
                fontSize: 42,
                fontWeight: FontWeight.w600,
                color: Colors.white,
                height: 1.3,
              ),
            ),
            const SizedBox(height: 25),
            Wrap(
              spacing: 15, // Space between buttons
              runSpacing: 15, // Space between rows when buttons wrap
              children: [
                _buildButton(
                  text: AppStrings.requestFeasibilityStudy,
                  icon: Icons.file_copy_outlined,
                  backgroundColor: AppColors.primary,
                  onPressed: () {},
                ),
                _buildButton(
                  text: AppStrings.contactViaWhatsapp,
                  icon: FontAwesomeIcons.whatsapp,
                  backgroundColor: AppColors.whatsapp,
                  onPressed: () {},
                ),
              ],
            ),
          ],
        ),
      ),
    );
  }

  ImageProvider _getBackgroundImage() {
    try {
      // Try to load the image with the path from constants
      return AssetImage(AppAssets.mainImage);
    } catch (e) {
      debugPrint('Error loading image: $e');
      try {
        // Try a fallback path
        return const AssetImage('assets/images/placeholder.png');
      } catch (e) {
        debugPrint('Error loading placeholder: $e');
        // Return a simple empty asset if all else fails
        return const AssetImage('');
      }
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
        padding: const EdgeInsets.symmetric(horizontal: 25, vertical: 12),
        textStyle: const TextStyle(fontSize: 14, fontWeight: FontWeight.w500),
      ),
      icon: Icon(icon),
      label: Text(text),
    );
  }
}
