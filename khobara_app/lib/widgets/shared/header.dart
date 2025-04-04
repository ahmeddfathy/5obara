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
                builder:
                    (ctx) => IconButton(
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
                  AppAssets.logo,
                  height: 50,
                  errorBuilder:
                      (context, error, stackTrace) => Container(
                        height: 50,
                        width: 50,
                        color: AppColors.primary,
                        child: const Center(child: Text('LOGO')),
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
