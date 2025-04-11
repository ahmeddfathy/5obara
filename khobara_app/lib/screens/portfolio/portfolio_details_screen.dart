import 'package:flutter/material.dart';
import 'package:cached_network_image/cached_network_image.dart';
import 'package:url_launcher/url_launcher.dart';
import '../../models/portfolio_model.dart';
import '../../utils/constants.dart';
import '../../widgets/shared/top_bar.dart';
import '../../widgets/shared/header.dart';
import '../../widgets/shared/footer.dart';
import '../../widgets/shared/app_drawer.dart';

class PortfolioDetailsScreen extends StatelessWidget {
  final Portfolio portfolio;

  const PortfolioDetailsScreen({Key? key, required this.portfolio})
    : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.lightGray,
      drawer: const AppDrawer(),
      body: SingleChildScrollView(
        child: Column(
          children: [
            const TopBar(),
            const Header(),
            _buildHeroSection(context),
            _buildPortfolioDetails(context),
            const Footer(),
          ],
        ),
      ),
    );
  }

  Widget _buildHeroSection(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 60, horizontal: 20),
      color: AppColors.primary,
      width: double.infinity,
      child: Column(
        children: [
          Text(
            portfolio.title,
            style: const TextStyle(
              color: Colors.white,
              fontSize: 28,
              fontWeight: FontWeight.bold,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 16),
          if (portfolio.type != null)
            Text(
              portfolio.type!,
              style: TextStyle(
                color: Colors.white.withOpacity(0.9),
                fontSize: 18,
              ),
              textAlign: TextAlign.center,
            ),
        ],
      ),
    );
  }

  Widget _buildPortfolioDetails(BuildContext context) {
    return Container(
      margin: const EdgeInsets.all(24),
      padding: const EdgeInsets.all(24),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.05),
            blurRadius: 10,
            spreadRadius: 0,
            offset: const Offset(0, 5),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Featured Image
          if (portfolio.imageUrl != null)
            ClipRRect(
              borderRadius: BorderRadius.circular(8),
              child: CachedNetworkImage(
                imageUrl: portfolio.imageUrl!,
                width: double.infinity,
                height: 300,
                fit: BoxFit.cover,
                placeholder:
                    (context, url) => Container(
                      height: 300,
                      color: Colors.grey[200],
                      child: const Center(child: CircularProgressIndicator()),
                    ),
                errorWidget:
                    (context, url, error) => Container(
                      height: 300,
                      color: Colors.grey[200],
                      child: const Center(
                        child: Icon(Icons.error, size: 50, color: Colors.grey),
                      ),
                    ),
              ),
            ),
          const SizedBox(height: 24),

          // Project Metadata
          _buildMetadataSection(context),
          const SizedBox(height: 24),

          // Project Description
          Text(
            'تفاصيل المشروع',
            style: Theme.of(
              context,
            ).textTheme.titleLarge!.copyWith(fontWeight: FontWeight.bold),
          ),
          const SizedBox(height: 16),
          Text(
            portfolio.description,
            style: Theme.of(context).textTheme.bodyLarge,
          ),
          const SizedBox(height: 24),

          // Technologies Used
          if (portfolio.technologies.isNotEmpty)
            _buildTechnologiesSection(context),

          // Project URL
          if (portfolio.projectUrl != null) _buildProjectUrlButton(context),
        ],
      ),
    );
  }

  Widget _buildMetadataSection(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.grey[50],
        borderRadius: BorderRadius.circular(8),
        border: Border.all(color: Colors.grey[200]!),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            'معلومات المشروع',
            style: Theme.of(
              context,
            ).textTheme.titleMedium!.copyWith(fontWeight: FontWeight.bold),
          ),
          const SizedBox(height: 16),
          // Client
          if (portfolio.clientName != null)
            _buildMetadataItem(
              context,
              'العميل:',
              portfolio.clientName!,
              Icons.person,
            ),
          // Type
          if (portfolio.type != null)
            _buildMetadataItem(
              context,
              'نوع المشروع:',
              portfolio.type!,
              Icons.category,
            ),
          // Completion Date
          if (portfolio.completionDate != null)
            _buildMetadataItem(
              context,
              'تاريخ الإتمام:',
              portfolio.completionDate!,
              Icons.calendar_today,
            ),
        ],
      ),
    );
  }

  Widget _buildMetadataItem(
    BuildContext context,
    String label,
    String value,
    IconData icon,
  ) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 12),
      child: Row(
        children: [
          Icon(icon, size: 20, color: AppColors.primary),
          const SizedBox(width: 8),
          Text(
            label,
            style: Theme.of(
              context,
            ).textTheme.titleSmall!.copyWith(fontWeight: FontWeight.bold),
          ),
          const SizedBox(width: 8),
          Expanded(
            child: Text(value, style: Theme.of(context).textTheme.bodyMedium),
          ),
        ],
      ),
    );
  }

  Widget _buildTechnologiesSection(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          'التقنيات المستخدمة',
          style: Theme.of(
            context,
          ).textTheme.titleLarge!.copyWith(fontWeight: FontWeight.bold),
        ),
        const SizedBox(height: 16),
        Wrap(
          spacing: 8,
          runSpacing: 8,
          children:
              portfolio.technologies
                  .map(
                    (tech) => Chip(
                      label: Text(tech),
                      backgroundColor: AppColors.primary.withOpacity(0.1),
                      labelStyle: TextStyle(color: AppColors.primary),
                    ),
                  )
                  .toList(),
        ),
        const SizedBox(height: 24),
      ],
    );
  }

  Widget _buildProjectUrlButton(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const SizedBox(height: 8),
        ElevatedButton.icon(
          onPressed: () async {
            if (portfolio.projectUrl != null) {
              final Uri url = Uri.parse(portfolio.projectUrl!);
              if (await canLaunchUrl(url)) {
                await launchUrl(url, mode: LaunchMode.externalApplication);
              }
            }
          },
          icon: const Icon(Icons.launch),
          label: const Text('زيارة المشروع'),
          style: ElevatedButton.styleFrom(
            padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 12),
          ),
        ),
        const SizedBox(height: 16),
      ],
    );
  }
}
