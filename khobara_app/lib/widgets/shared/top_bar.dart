import 'package:flutter/material.dart';
import '../../utils/constants.dart';

class TopBar extends StatelessWidget {
  const TopBar({super.key});

  @override
  Widget build(BuildContext context) {
    final screenWidth = MediaQuery.of(context).size.width;
    final isDesktop = screenWidth > 600;

    return Container(
      width: double.infinity,
      padding: EdgeInsets.symmetric(
        vertical: 8,
        horizontal: isDesktop ? 16 : 12,
      ),
      color: const Color(0xFF00B5AD),
      child: Center(
        child: ConstrainedBox(
          constraints: const BoxConstraints(maxWidth: 1200),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              if (isDesktop)
                Row(
                  children: [
                    _buildInfoItem(Icons.email, 'info@5obara.com'),
                    const SizedBox(width: 20),
                    _buildInfoItem(Icons.phone, '+966569617288'),
                  ],
                )
              else
                _buildInfoItem(Icons.phone, '+966569617288'),
              Row(
                children: [
                  _buildSocialIcon(Icons.facebook),
                  _buildSocialIcon(Icons.telegram),
                  _buildSocialIcon(Icons.phone),
                  _buildSocialIcon(Icons.email),
                ],
              ),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildInfoItem(IconData icon, String text) {
    return Row(
      mainAxisSize: MainAxisSize.min,
      children: [
        Icon(icon, color: Colors.white, size: 14),
        const SizedBox(width: 5),
        Text(
          text,
          style: const TextStyle(
            color: Colors.white,
            fontSize: 14,
            overflow: TextOverflow.ellipsis,
          ),
        ),
      ],
    );
  }

  Widget _buildSocialIcon(IconData icon) {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 8.0),
      child: Icon(icon, color: Colors.white, size: 14),
    );
  }
}
