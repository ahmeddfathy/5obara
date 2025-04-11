import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:go_router/go_router.dart';
import 'package:url_launcher/url_launcher.dart';
import '../utils/constants.dart';
import '../widgets/shared/top_bar.dart';
import '../widgets/shared/header.dart';
import '../widgets/home/hero_section.dart';
import '../widgets/home/stats_section.dart';
import '../widgets/home/services_section.dart';
import '../widgets/home/services_offering.dart';
import '../widgets/home/why_choose_us.dart';
import '../widgets/home/invest_section.dart';
import '../widgets/shared/footer.dart';
import '../utils/routes.dart';
import '../widgets/shared/app_drawer.dart';

class HomeScreen extends StatefulWidget {
  const HomeScreen({super.key});

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  final ScrollController _scrollController = ScrollController();
  bool _showBackToTopButton = false;

  @override
  void initState() {
    super.initState();
    _scrollController.addListener(() {
      setState(() {
        if (_scrollController.offset >= 400) {
          _showBackToTopButton = true;
        } else {
          _showBackToTopButton = false;
        }
      });
    });
  }

  @override
  void dispose() {
    _scrollController.dispose();
    super.dispose();
  }

  void _scrollToTop() {
    _scrollController.animateTo(
      0,
      duration: const Duration(milliseconds: 500),
      curve: Curves.easeInOut,
    );
  }

  void _scrollToSection(double offset) {
    _scrollController.animateTo(
      offset,
      duration: const Duration(milliseconds: 500),
      curve: Curves.easeInOut,
    );
  }

  Future<void> _makePhoneCall(String phoneNumber) async {
    final Uri launchUri = Uri(scheme: 'tel', path: phoneNumber);
    await launchUrl(launchUri);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.lightGray,
      drawer: const AppDrawer(),
      body: SafeArea(
        child: Stack(
          children: [
            SingleChildScrollView(
              controller: _scrollController,
              child: Column(
                children: [
                  const TopBar(),
                  const Header(),
                  const HeroSection(),
                  const ServicesSection(),
                  const ServicesOfferingSection(),
                  const WhyChooseUsSection(),
                  const StatsSection(),
                  const InvestSection(),
                  const Footer(),
                ],
              ),
            ),
            Positioned(
              bottom: 20,
              left: 20,
              child: Column(
                children: [
                  if (_showBackToTopButton)
                    FloatingActionButton(
                      heroTag: 'backToTop',
                      backgroundColor: Colors.white,
                      elevation: 4,
                      onPressed: _scrollToTop,
                      mini: true,
                      child: const Icon(
                        Icons.arrow_upward,
                        color: AppColors.primary,
                      ),
                    ),
                  const SizedBox(height: 10),
                  FloatingActionButton(
                    heroTag: 'whatsapp',
                    backgroundColor: AppColors.whatsapp,
                    elevation: 4,
                    onPressed: () =>
                        _launchUrl('https://wa.me/${AppStrings.contactPhone}'),
                    child: const Icon(
                      FontAwesomeIcons.whatsapp,
                      color: Colors.white,
                      size: 24,
                    ),
                  ),
                  const SizedBox(height: 10),
                  FloatingActionButton(
                    heroTag: 'messenger',
                    backgroundColor: AppColors.facebook,
                    elevation: 4,
                    onPressed: () => _launchUrl('https://m.me/5obara'),
                    child: const Icon(
                      FontAwesomeIcons.facebookMessenger,
                      color: Colors.white,
                      size: 24,
                    ),
                  ),
                  const SizedBox(height: 10),
                  FloatingActionButton(
                    heroTag: 'chat',
                    backgroundColor: AppColors.primary,
                    elevation: 4,
                    onPressed: () {},
                    child: const Icon(
                      Icons.chat,
                      color: Colors.white,
                      size: 24,
                    ),
                  ),
                  const SizedBox(height: 10),
                  FloatingActionButton(
                    heroTag: 'phone',
                    backgroundColor: Colors.blue,
                    elevation: 4,
                    onPressed: () => _makePhoneCall('+966569617288'),
                    child: const Icon(
                      Icons.phone,
                      color: Colors.white,
                      size: 24,
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  Future<void> _launchUrl(String url) async {
    final Uri uri = Uri.parse(url);
    if (!await launchUrl(uri, mode: LaunchMode.externalApplication)) {
      throw Exception('Could not launch $url');
    }
  }
}
