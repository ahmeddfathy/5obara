import 'package:flutter/material.dart';
import '../../utils/constants.dart';

class ProjectsGrid extends StatelessWidget {
  const ProjectsGrid({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 60, horizontal: 16),
      child: Column(
        children: [
          Text(
            'مشاريعنا',
            style: TextStyle(
              fontSize: 32,
              fontWeight: FontWeight.bold,
              color: AppColors.primary,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 20),
          const Text(
            'نماذج من المشاريع التي قمنا بتنفيذها',
            style: TextStyle(fontSize: 18, color: Colors.grey),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 40),
          _buildFilterButtons(),
          const SizedBox(height: 40),
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

  Widget _buildFilterButtons() {
    final categories = [
      'الكل',
      'دراسات الجدوى',
      'خطط الأعمال',
      'استشارات مالية',
      'تطوير المشاريع',
    ];

    return Wrap(
      spacing: 10,
      runSpacing: 10,
      alignment: WrapAlignment.center,
      children:
          categories.map((category) {
            return FilterChip(
              label: Text(category),
              selected: category == 'الكل',
              selectedColor: AppColors.primary.withOpacity(0.2),
              checkmarkColor: AppColors.primary,
              labelStyle: TextStyle(
                color: category == 'الكل' ? AppColors.primary : Colors.black87,
                fontWeight:
                    category == 'الكل' ? FontWeight.bold : FontWeight.normal,
              ),
              onSelected: (bool selected) {
                // Filter functionality would be implemented here
              },
            );
          }).toList(),
    );
  }

  Widget _buildDesktopGrid() {
    return GridView.count(
      crossAxisCount: 3,
      shrinkWrap: true,
      physics: const NeverScrollableScrollPhysics(),
      crossAxisSpacing: 20,
      mainAxisSpacing: 20,
      children: _buildProjectItems(),
    );
  }

  Widget _buildTabletGrid() {
    return GridView.count(
      crossAxisCount: 2,
      shrinkWrap: true,
      physics: const NeverScrollableScrollPhysics(),
      crossAxisSpacing: 20,
      mainAxisSpacing: 20,
      children: _buildProjectItems(),
    );
  }

  Widget _buildMobileGrid() {
    return GridView.count(
      crossAxisCount: 1,
      shrinkWrap: true,
      physics: const NeverScrollableScrollPhysics(),
      mainAxisSpacing: 20,
      childAspectRatio: 1.1,
      children: _buildProjectItems(),
    );
  }

  List<Widget> _buildProjectItems() {
    final projects = [
      {
        'title': 'مشروع مصنع منتجات غذائية',
        'category': 'دراسات الجدوى',
        'image': AppAssets.mainImage,
      },
      {
        'title': 'مشروع مطعم وكافيه',
        'category': 'خطط الأعمال',
        'image': AppAssets.mainImage,
      },
      {
        'title': 'مشروع متجر إلكتروني',
        'category': 'تطوير المشاريع',
        'image': AppAssets.mainImage,
      },
      {
        'title': 'مشروع شركة خدمات لوجستية',
        'category': 'استشارات مالية',
        'image': AppAssets.mainImage,
      },
      {
        'title': 'مشروع مركز تدريب',
        'category': 'دراسات الجدوى',
        'image': AppAssets.mainImage,
      },
      {
        'title': 'مشروع عيادة طبية',
        'category': 'خطط الأعمال',
        'image': AppAssets.mainImage,
      },
    ];

    return projects
        .map(
          (project) => _buildProjectCard(
            title: project['title'] as String,
            category: project['category'] as String,
            imageUrl: project['image'] as String,
          ),
        )
        .toList();
  }

  Widget _buildProjectCard({
    required String title,
    required String category,
    required String imageUrl,
  }) {
    return Container(
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(8),
        boxShadow: [
          BoxShadow(
            color: Colors.grey.withOpacity(0.2),
            spreadRadius: 1,
            blurRadius: 7,
            offset: const Offset(0, 3),
          ),
        ],
      ),
      child: ClipRRect(
        borderRadius: BorderRadius.circular(8),
        child: Stack(
          children: [
            // Project image
            Image.asset(
              imageUrl,
              width: double.infinity,
              height: double.infinity,
              fit: BoxFit.cover,
            ),
            // Overlay
            Container(
              width: double.infinity,
              height: double.infinity,
              decoration: BoxDecoration(
                gradient: LinearGradient(
                  begin: Alignment.topCenter,
                  end: Alignment.bottomCenter,
                  colors: [Colors.transparent, Colors.black.withOpacity(0.7)],
                ),
              ),
            ),
            // Content
            Positioned(
              bottom: 0,
              left: 0,
              right: 0,
              child: Padding(
                padding: const EdgeInsets.all(16),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.end,
                  children: [
                    Text(
                      title,
                      style: const TextStyle(
                        color: Colors.white,
                        fontSize: 18,
                        fontWeight: FontWeight.bold,
                      ),
                      textAlign: TextAlign.right,
                    ),
                    const SizedBox(height: 8),
                    Container(
                      padding: const EdgeInsets.symmetric(
                        horizontal: 12,
                        vertical: 4,
                      ),
                      decoration: BoxDecoration(
                        color: AppColors.primary,
                        borderRadius: BorderRadius.circular(20),
                      ),
                      child: Text(
                        category,
                        style: const TextStyle(
                          color: Colors.white,
                          fontSize: 12,
                        ),
                      ),
                    ),
                  ],
                ),
              ),
            ),
            // Hover overlay
            Material(
              color: Colors.transparent,
              child: InkWell(
                onTap: () {
                  // Navigate to project details
                },
                splashColor: AppColors.primary.withOpacity(0.2),
                highlightColor: AppColors.primary.withOpacity(0.1),
                child: Container(),
              ),
            ),
          ],
        ),
      ),
    );
  }
}
