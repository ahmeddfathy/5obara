import 'package:flutter/material.dart';
import 'package:cached_network_image/cached_network_image.dart';
import 'package:url_launcher/url_launcher.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import '../../models/post_model.dart';
import '../../utils/constants.dart';
import '../../widgets/shared/top_bar.dart';
import '../../widgets/shared/header.dart';
import '../../widgets/shared/footer.dart';
import '../../widgets/shared/app_drawer.dart';
import '../../widgets/shared/contact_form_section.dart';

class BlogDetailsScreen extends StatelessWidget {
  final Post post;

  const BlogDetailsScreen({Key? key, required this.post}) : super(key: key);

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
            _buildBlogContent(context),
            if (post.investmentAmount != null) _buildInvestmentDetails(context),
            const ContactFormSection(),
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
            post.title,
            style: const TextStyle(
              color: Colors.white,
              fontSize: 28,
              fontWeight: FontWeight.bold,
            ),
            textAlign: TextAlign.center,
          ),
          if (post.publishedAt != null) ...[
            const SizedBox(height: 16),
            Text(
              post.publishedAt!,
              style: TextStyle(
                color: Colors.white.withOpacity(0.9),
                fontSize: 16,
              ),
              textAlign: TextAlign.center,
            ),
          ],
        ],
      ),
    );
  }

  Widget _buildBlogContent(BuildContext context) {
    return Container(
      margin: const EdgeInsets.all(24),
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
          if (post.featuredImage != null)
            ClipRRect(
              borderRadius: const BorderRadius.only(
                topLeft: Radius.circular(12),
                topRight: Radius.circular(12),
              ),
              child: CachedNetworkImage(
                imageUrl: post.featuredImage!,
                width: double.infinity,
                height: 300,
                fit: BoxFit.cover,
                placeholder: (context, url) => Container(
                  height: 300,
                  color: Colors.grey[200],
                  child: const Center(child: CircularProgressIndicator()),
                ),
                errorWidget: (context, url, error) => Container(
                  height: 300,
                  color: Colors.grey[200],
                  child: const Center(
                    child: Icon(Icons.error, size: 50, color: Colors.grey),
                  ),
                ),
              ),
            ),

          // Content
          Padding(
            padding: const EdgeInsets.all(24),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                // Metadata
                _buildMetadata(context),
                const SizedBox(height: 24),

                // Content
                // Using simple Text for now, as HtmlWidget requires additional setup
                Text(
                  post.content
                      .replaceAll(RegExp(r'<[^>]*>'), ''), // Remove HTML tags
                  style: Theme.of(context).textTheme.bodyLarge,
                ),
                const SizedBox(height: 24),

                // Tags
                if (post.tags.isNotEmpty) ...[
                  const Divider(),
                  const SizedBox(height: 16),
                  Wrap(
                    spacing: 8,
                    runSpacing: 8,
                    children: post.tags
                        .map(
                          (tag) => Chip(
                            label: Text(tag),
                            backgroundColor: AppColors.primary.withOpacity(0.1),
                            labelStyle: TextStyle(color: AppColors.primary),
                          ),
                        )
                        .toList(),
                  ),
                ],

                // Share buttons
                const SizedBox(height: 24),
                _buildShareButtons(context),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildMetadata(BuildContext context) {
    return Row(
      children: [
        const Icon(Icons.calendar_today, size: 16, color: Colors.grey),
        const SizedBox(width: 8),
        if (post.publishedAt != null)
          Text(
            post.publishedAt!,
            style: TextStyle(
              color: Colors.grey[600],
              fontSize: 14,
            ),
          ),
        const Spacer(),
        if (post.investmentAmount != null) ...[
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
            decoration: BoxDecoration(
              color: AppColors.primary.withOpacity(0.1),
              borderRadius: BorderRadius.circular(20),
            ),
            child: Text(
              'الاستثمار: ${post.investmentAmount}',
              style: TextStyle(
                color: AppColors.primary,
                fontWeight: FontWeight.bold,
                fontSize: 13,
              ),
            ),
          ),
        ],
      ],
    );
  }

  Widget _buildInvestmentDetails(BuildContext context) {
    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 24, vertical: 8),
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
        border: Border.all(
          color: AppColors.primary.withOpacity(0.3),
          width: 2,
        ),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Text(
            'تفاصيل فرصة الاستثمار',
            style: TextStyle(
              fontSize: 20,
              fontWeight: FontWeight.bold,
            ),
          ),
          const SizedBox(height: 24),
          _buildInvestmentItem(
            context,
            'المبلغ المطلوب:',
            post.investmentAmount ?? '',
            Icons.monetization_on,
          ),
          if (post.investmentType != null)
            _buildInvestmentItem(
              context,
              'نوع الاستثمار:',
              post.investmentType!,
              Icons.category,
            ),
          if (post.location != null)
            _buildInvestmentItem(
              context,
              'الموقع:',
              post.location!,
              Icons.location_on,
            ),

          // Investment Highlights
          if (post.investmentHighlights != null &&
              post.investmentHighlights!.isNotEmpty) ...[
            const SizedBox(height: 16),
            const Text(
              'مميزات الاستثمار:',
              style: TextStyle(
                fontSize: 16,
                fontWeight: FontWeight.bold,
              ),
            ),
            const SizedBox(height: 8),
            ...post.investmentHighlights!.map(
              (highlight) => Padding(
                padding: const EdgeInsets.only(bottom: 8),
                child: Row(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Icon(
                      Icons.check_circle,
                      color: AppColors.success,
                      size: 20,
                    ),
                    const SizedBox(width: 8),
                    Expanded(
                      child: Text(
                        highlight,
                        style: const TextStyle(fontSize: 14),
                      ),
                    ),
                  ],
                ),
              ),
            ),
          ],

          // Gallery
          if (post.galleryImages.isNotEmpty) ...[
            const SizedBox(height: 24),
            const Text(
              'صور المشروع:',
              style: TextStyle(
                fontSize: 16,
                fontWeight: FontWeight.bold,
              ),
            ),
            const SizedBox(height: 16),
            SizedBox(
              height: 120,
              child: ListView.builder(
                scrollDirection: Axis.horizontal,
                itemCount: post.galleryImages.length,
                itemBuilder: (context, index) {
                  final image = post.galleryImages[index];
                  return Padding(
                    padding: const EdgeInsets.only(right: 12),
                    child: ClipRRect(
                      borderRadius: BorderRadius.circular(8),
                      child: CachedNetworkImage(
                        imageUrl: image.url,
                        width: 180,
                        height: 120,
                        fit: BoxFit.cover,
                        placeholder: (context, url) => Container(
                          color: Colors.grey[200],
                          child:
                              const Center(child: CircularProgressIndicator()),
                        ),
                        errorWidget: (context, url, error) => Container(
                          color: Colors.grey[200],
                          child: const Center(
                            child: Icon(Icons.error, color: Colors.grey),
                          ),
                        ),
                      ),
                    ),
                  );
                },
              ),
            ),
          ],

          // Virtual Gallery button
          if (post.hasVirtualGallery == true) ...[
            const SizedBox(height: 24),
            ElevatedButton.icon(
              onPressed: () {
                // TODO: Implement virtual gallery navigation
              },
              icon: const Icon(Icons.view_in_ar),
              label: const Text('عرض المعرض الافتراضي'),
              style: ElevatedButton.styleFrom(
                backgroundColor: AppColors.primary,
                foregroundColor: Colors.white,
                padding: const EdgeInsets.symmetric(
                  horizontal: 16,
                  vertical: 12,
                ),
              ),
            ),
          ],

          // Contact for investment button
          const SizedBox(height: 16),
          SizedBox(
            width: double.infinity,
            child: ElevatedButton.icon(
              onPressed: () {
                // TODO: Implement contact form navigation
              },
              icon: const Icon(Icons.handshake),
              label: const Text('تواصل معنا للاستثمار'),
              style: ElevatedButton.styleFrom(
                backgroundColor: AppColors.secondary,
                foregroundColor: Colors.white,
                padding: const EdgeInsets.symmetric(
                  horizontal: 16,
                  vertical: 12,
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildInvestmentItem(
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
            style: const TextStyle(
              fontWeight: FontWeight.bold,
              fontSize: 14,
            ),
          ),
          const SizedBox(width: 8),
          Text(
            value,
            style: const TextStyle(fontSize: 14),
          ),
        ],
      ),
    );
  }

  Widget _buildShareButtons(BuildContext context) {
    return Row(
      children: [
        const Text(
          'مشاركة:',
          style: TextStyle(
            fontWeight: FontWeight.bold,
          ),
        ),
        const SizedBox(width: 16),
        IconButton(
          onPressed: () {
            _shareContent(context);
          },
          icon: const Icon(Icons.share),
          color: AppColors.primary,
        ),
        IconButton(
          onPressed: () async {
            _shareOnWhatsApp();
          },
          icon: const Icon(
            FontAwesomeIcons.whatsapp,
            size: 22,
          ),
          color: const Color(0xFF25D366), // WhatsApp color
        ),
      ],
    );
  }

  void _shareContent(BuildContext context) {
    // Implementation of share functionality without share_plus package
    final String text =
        'تابع هذا المقال الرائع: ${post.title}\n\nاقرأ المزيد على موقعنا';

    final Uri emailUri = Uri(
      scheme: 'mailto',
      query:
          'subject=${Uri.encodeComponent(post.title)}&body=${Uri.encodeComponent(text)}',
    );

    launchUrl(emailUri);
  }

  void _shareOnWhatsApp() async {
    final String text = '${post.title}\n\nاقرأ المزيد على موقعنا';
    final url = Uri.parse('https://wa.me/?text=${Uri.encodeComponent(text)}');
    if (await canLaunchUrl(url)) {
      await launchUrl(url, mode: LaunchMode.externalApplication);
    }
  }
}
