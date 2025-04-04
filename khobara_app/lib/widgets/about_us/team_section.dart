import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import '../../utils/constants.dart';

class TeamSection extends StatelessWidget {
  const TeamSection({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 60, horizontal: 16),
      color: Colors.grey[100],
      child: Column(
        children: [
          Text(
            'فريقنا',
            style: TextStyle(
              fontSize: 32,
              fontWeight: FontWeight.bold,
              color: AppColors.primary,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 20),
          const Text(
            'خبراؤنا المتخصصون',
            style: TextStyle(fontSize: 18, color: Colors.grey),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 50),
          LayoutBuilder(
            builder: (context, constraints) {
              if (constraints.maxWidth > 900) {
                return _buildDesktopGrid();
              } else if (constraints.maxWidth > 600) {
                return _buildTabletGrid();
              } else {
                return _buildMobileGrid();
              }
            },
          ),
        ],
      ),
    );
  }

  Widget _buildDesktopGrid() {
    return GridView.count(
      crossAxisCount: 4,
      shrinkWrap: true,
      physics: const NeverScrollableScrollPhysics(),
      crossAxisSpacing: 30,
      mainAxisSpacing: 30,
      children: _buildTeamMembers(),
    );
  }

  Widget _buildTabletGrid() {
    return GridView.count(
      crossAxisCount: 2,
      shrinkWrap: true,
      physics: const NeverScrollableScrollPhysics(),
      crossAxisSpacing: 30,
      mainAxisSpacing: 30,
      children: _buildTeamMembers(),
    );
  }

  Widget _buildMobileGrid() {
    return GridView.count(
      crossAxisCount: 1,
      shrinkWrap: true,
      physics: const NeverScrollableScrollPhysics(),
      mainAxisSpacing: 30,
      childAspectRatio: 0.8,
      children: _buildTeamMembers(),
    );
  }

  List<Widget> _buildTeamMembers() {
    final members = [
      {
        'name': 'أحمد محمد',
        'position': 'المدير التنفيذي',
        'image': 'assets/images/team1.jpg',
      },
      {
        'name': 'سارة خالد',
        'position': 'مستشار اقتصادي',
        'image': 'assets/images/team2.jpg',
      },
      {
        'name': 'محمد عبدالله',
        'position': 'محلل مالي',
        'image': 'assets/images/team3.jpg',
      },
      {
        'name': 'نورة سعد',
        'position': 'مستشار تسويق',
        'image': 'assets/images/team4.jpg',
      },
    ];

    return members
        .map(
          (member) => _buildTeamMemberCard(
            name: member['name'] as String,
            position: member['position'] as String,
            imageUrl: member['image'] as String,
          ),
        )
        .toList();
  }

  Widget _buildTeamMemberCard({
    required String name,
    required String position,
    required String imageUrl,
  }) {
    return Container(
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(8),
        boxShadow: [
          BoxShadow(
            color: Colors.grey.withOpacity(0.1),
            spreadRadius: 1,
            blurRadius: 5,
            offset: const Offset(0, 3),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.center,
        children: [
          Expanded(
            flex: 3,
            child: ClipRRect(
              borderRadius: const BorderRadius.only(
                topLeft: Radius.circular(8),
                topRight: Radius.circular(8),
              ),
              child: Image.asset(
                AppAssets
                    .mainImage, // Using a placeholder since actual image might not exist
                fit: BoxFit.cover,
                width: double.infinity,
              ),
            ),
          ),
          Expanded(
            flex: 2,
            child: Padding(
              padding: const EdgeInsets.all(16),
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  Text(
                    name,
                    style: const TextStyle(
                      fontSize: 18,
                      fontWeight: FontWeight.bold,
                    ),
                    textAlign: TextAlign.center,
                  ),
                  const SizedBox(height: 8),
                  Text(
                    position,
                    style: TextStyle(fontSize: 14, color: Colors.grey[600]),
                    textAlign: TextAlign.center,
                  ),
                  const SizedBox(height: 16),
                  Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      _buildSocialIcon(FontAwesomeIcons.linkedin),
                      const SizedBox(width: 12),
                      _buildSocialIcon(FontAwesomeIcons.twitter),
                      const SizedBox(width: 12),
                      _buildSocialIcon(FontAwesomeIcons.facebook),
                    ],
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildSocialIcon(IconData icon) {
    return Container(
      width: 32,
      height: 32,
      decoration: BoxDecoration(
        color: AppColors.primary,
        borderRadius: BorderRadius.circular(16),
      ),
      child: Icon(icon, color: Colors.white, size: 16),
    );
  }
}
