import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';
import '../../utils/constants.dart';

class AppDrawer extends StatelessWidget {
  const AppDrawer({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    // Get the current route path manually
    final String location = GoRouterState.of(context).matchedLocation;
    print(
        'Current location: $location'); // Debug print to help identify the current route

    return Drawer(
      child: ListView(
        padding: EdgeInsets.zero,
        children: [
          DrawerHeader(
            decoration: BoxDecoration(color: AppColors.primary),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                const Text(
                  'الخبراء للاستشارات',
                  style: TextStyle(color: Colors.white, fontSize: 24),
                ),
                const SizedBox(height: 16),
                Text(
                  'الخبراء للتطوير والاستشارات',
                  style: TextStyle(
                    color: Colors.white.withOpacity(0.8),
                    fontSize: 16,
                  ),
                ),
              ],
            ),
          ),
          _buildDrawerItem(
            context,
            title: 'الرئيسية',
            icon: Icons.home,
            path: '/',
            currentLocation: location,
          ),
          _buildDrawerItem(
            context,
            title: 'من نحن',
            icon: Icons.info,
            path: '/about-us',
            currentLocation: location,
          ),
          _buildDrawerItem(
            context,
            title: 'خدماتنا',
            icon: Icons.miscellaneous_services,
            path: '/services',
            currentLocation: location,
          ),
          _buildDrawerItem(
            context,
            title: 'أعمالنا',
            icon: Icons.work,
            path: '/portfolio',
            currentLocation: location,
          ),
          _buildDrawerItem(
            context,
            title: 'المدونة',
            icon: Icons.article,
            path: '/blog',
            currentLocation: location,
          ),
          _buildDrawerItem(
            context,
            title: 'فرص الاستثمار',
            icon: Icons.attach_money,
            path: '/opportunities',
            currentLocation: location,
          ),
          _buildDrawerItem(
            context,
            title: 'اتصل بنا',
            icon: Icons.contact_phone,
            path: '/contact',
            currentLocation: location,
          ),
          const Divider(),
          _buildDrawerItem(
            context,
            title: 'ابدأ مشروعك',
            icon: Icons.rocket_launch,
            path: '/start-project',
            currentLocation: location,
            isHighlighted: true,
          ),
        ],
      ),
    );
  }

  Widget _buildDrawerItem(
    BuildContext context, {
    required String title,
    required IconData icon,
    required String path,
    required String currentLocation,
    bool isHighlighted = false,
  }) {
    final bool isSelected = currentLocation == path;

    return ListTile(
      leading: Icon(
        icon,
        color: isHighlighted
            ? AppColors.accent
            : isSelected
                ? AppColors.primary
                : Colors.grey[600],
      ),
      title: Text(
        title,
        style: TextStyle(
          color: isHighlighted
              ? AppColors.accent
              : isSelected
                  ? AppColors.primary
                  : AppColors.textPrimary,
          fontWeight:
              isSelected || isHighlighted ? FontWeight.bold : FontWeight.normal,
        ),
      ),
      selected: isSelected,
      onTap: () {
        Navigator.pop(context); // Close the drawer
        if (currentLocation != path) {
          context.go(
              path); // Use go instead of goNamed for more reliable navigation
        }
      },
    );
  }
}
