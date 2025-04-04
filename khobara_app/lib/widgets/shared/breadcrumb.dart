import 'package:flutter/material.dart';
import '../../utils/constants.dart';

class Breadcrumb extends StatelessWidget {
  final String currentPage;
  final List<BreadcrumbItem> items;

  const Breadcrumb({Key? key, required this.currentPage, this.items = const []})
    : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 16, horizontal: 16),
      decoration: BoxDecoration(
        color: Colors.white,
        boxShadow: [
          BoxShadow(
            color: Colors.grey.withOpacity(0.1),
            spreadRadius: 1,
            blurRadius: 5,
            offset: const Offset(0, 3),
          ),
        ],
      ),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.end,
        children: [
          Text(
            currentPage,
            style: TextStyle(
              color: AppColors.primary,
              fontWeight: FontWeight.bold,
            ),
          ),
          if (items.isNotEmpty) ...[
            const SizedBox(width: 8),
            const Icon(Icons.arrow_back_ios, size: 12, color: Colors.grey),
            const SizedBox(width: 8),
          ],
          ...List.generate(items.length * 2 - 1, (index) {
            // Alternate between items and separators
            if (index.isEven) {
              return InkWell(
                onTap: items[index ~/ 2].onTap,
                child: Text(
                  items[index ~/ 2].title,
                  style: const TextStyle(color: Colors.grey),
                ),
              );
            } else {
              return const Padding(
                padding: EdgeInsets.symmetric(horizontal: 8),
                child: Icon(Icons.arrow_back_ios, size: 12, color: Colors.grey),
              );
            }
          }),
          if (items.isNotEmpty) ...[
            const SizedBox(width: 8),
            InkWell(
              onTap: () {
                Navigator.pushNamed(context, '/');
              },
              child: const Text(
                'الرئيسية',
                style: TextStyle(color: Colors.grey),
              ),
            ),
          ],
        ],
      ),
    );
  }
}

class BreadcrumbItem {
  final String title;
  final VoidCallback onTap;

  BreadcrumbItem({required this.title, required this.onTap});
}
