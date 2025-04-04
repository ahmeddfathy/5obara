import 'package:flutter/material.dart';
import '../../utils/constants.dart';

class TopBar extends StatelessWidget {
  const TopBar({super.key});

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 8, horizontal: 16),
      color: const Color(0xFF00B5AD), // Same as website's #00b5ad
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Row(
            children: [
              _buildInfoItem(Icons.email, 'info@5obara.com'),
              const SizedBox(width: 20),
              _buildInfoItem(Icons.phone, '+966569617288'),
            ],
          ),
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
    );
  }

  Widget _buildInfoItem(IconData icon, String text) {
    return Row(
      children: [
        Icon(icon, color: Colors.white, size: 14),
        const SizedBox(width: 5),
        Text(text, style: const TextStyle(color: Colors.white, fontSize: 14)),
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
