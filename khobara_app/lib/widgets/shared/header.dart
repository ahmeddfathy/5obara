import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';
import '../../utils/constants.dart';
import '../../utils/routes.dart';

class Header extends StatelessWidget {
  const Header({super.key});

  @override
  Widget build(BuildContext context) {
    final String currentRoute = GoRouterState.of(context).uri.toString();

    return Container(
      padding: const EdgeInsets.symmetric(vertical: 15, horizontal: 16),
      color: Colors.white,
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Row(
            children: [
              Builder(
                builder: (ctx) => IconButton(
                  icon: const Icon(Icons.menu),
                  onPressed: () {
                    Scaffold.of(ctx).openDrawer();
                  },
                ),
              ),
              GestureDetector(
                onTap: () {
                  if (currentRoute != '/') {
                    context.go('/');
                  }
                },
                child: Image.asset(
                  'assets/images/logo.jpg',
                  height: 50,
                  width: 120,
                  fit: BoxFit.contain,
                  errorBuilder: (context, error, stackTrace) => Container(
                    height: 50,
                    width: 120,
                    color: AppColors.primary,
                    child: const Center(
                      child: Text(
                        'خبراء',
                        style: TextStyle(
                          color: Colors.white,
                          fontSize: 20,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                    ),
                  ),
                ),
              ),
            ],
          ),
          Expanded(
            child: LayoutBuilder(
              builder: (context, constraints) {
                // تظهر الناف بار للشاشات الكبيرة فقط
                if (constraints.maxWidth > 600) {
                  return Row(
                    mainAxisAlignment: MainAxisAlignment.end,
                    children: [
                      _buildNavItem(
                        context,
                        'الرئيسية',
                        '/',
                        isActive: currentRoute == '/',
                      ),
                      _buildNavItem(
                        context,
                        'خدماتنا',
                        '/services',
                        isActive: currentRoute == '/services',
                      ),
                      _buildNavItem(
                        context,
                        'مشاريعنا',
                        '/portfolio',
                        isActive: currentRoute == '/portfolio',
                      ),
                      _buildNavItem(
                        context,
                        'من نحن',
                        '/about-us',
                        isActive: currentRoute == '/about-us',
                      ),
                      _buildNavItem(
                        context,
                        'اتصل بنا',
                        '/contact',
                        isActive: currentRoute == '/contact',
                      ),
                      const SizedBox(width: 16),
                      ElevatedButton(
                        onPressed: () {
                          if (currentRoute != '/start-project') {
                            context.go('/start-project');
                          }
                        },
                        style: ElevatedButton.styleFrom(
                          backgroundColor: AppColors.primary,
                          foregroundColor: Colors.white,
                          padding: const EdgeInsets.symmetric(
                              horizontal: 20, vertical: 12),
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(8),
                          ),
                        ),
                        child: const Text(
                          'ابدأ مشروعك',
                          style: TextStyle(
                            fontSize: 14,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                      ),
                    ],
                  );
                } else {
                  return const SizedBox.shrink();
                }
              },
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildNavItem(
    BuildContext context,
    String title,
    String route, {
    bool isActive = false,
  }) {
    return Material(
      color: Colors.transparent,
      child: InkWell(
        onTap: () {
          final String currentRoute = GoRouterState.of(context).uri.toString();
          if (currentRoute != route) {
            context.go(route);
          }
        },
        borderRadius: BorderRadius.circular(4),
        child: Padding(
          padding: const EdgeInsets.symmetric(horizontal: 16.0, vertical: 8.0),
          child: Text(
            title,
            style: TextStyle(
              color: isActive ? AppColors.primary : AppColors.secondary,
              fontWeight: isActive ? FontWeight.bold : FontWeight.normal,
              fontSize: 16,
            ),
          ),
        ),
      ),
    );
  }
}
