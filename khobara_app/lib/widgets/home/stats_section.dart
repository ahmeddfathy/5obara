import 'package:flutter/material.dart';
import '../../utils/constants.dart';
import 'dart:async';

class StatsSection extends StatefulWidget {
  const StatsSection({super.key});

  @override
  State<StatsSection> createState() => _StatsSectionState();
}

class _StatsSectionState extends State<StatsSection>
    with AutomaticKeepAliveClientMixin {
  final List<Map<String, dynamic>> stats = [
    {'number': 1250, 'label': 'استشارة', 'current': 0},
    {'number': 6663, 'label': 'عميل راضي', 'current': 0},
    {'number': 3450, 'label': 'فرصة استثمارية', 'current': 0},
    {'number': 5430, 'label': 'دراسة جدوى', 'current': 0},
  ];

  bool _isVisible = false;
  bool _hasAnimated = false;
  Timer? _timer;
  final GlobalKey _sectionKey = GlobalKey();

  @override
  void initState() {
    super.initState();
    // Add post-frame callback to check visibility after first build
    WidgetsBinding.instance.addPostFrameCallback((_) {
      _checkVisibility();

      // Set up a periodic timer to check visibility during scrolling
      Timer.periodic(const Duration(milliseconds: 200), (timer) {
        if (_hasAnimated) {
          timer.cancel();
        } else {
          _checkVisibility();
        }
      });
    });
  }

  @override
  void dispose() {
    _timer?.cancel();
    super.dispose();
  }

  void _checkVisibility() {
    if (_hasAnimated) return;

    final RenderObject? renderObject =
        _sectionKey.currentContext?.findRenderObject();
    if (renderObject == null) return;

    final RenderBox box = renderObject as RenderBox;
    final position = box.localToGlobal(Offset.zero);

    // Calculate if the widget is visible in viewport
    final Size screenSize = MediaQuery.of(_sectionKey.currentContext!).size;
    final double screenHeight = screenSize.height;

    // Consider visible if at least 30% of the widget is in viewport
    if (position.dy < screenHeight && position.dy > -box.size.height * 0.7) {
      if (!_isVisible) {
        setState(() {
          _isVisible = true;
        });
        _startCounters();
        _hasAnimated = true;
      }
    }
  }

  void _startCounters() {
    const animationDuration = Duration(milliseconds: 2000);
    const updateInterval = Duration(milliseconds: 16); // ~60 FPS

    // Calculate how many steps we need
    final steps =
        animationDuration.inMilliseconds ~/ updateInterval.inMilliseconds;

    int currentStep = 0;

    _timer = Timer.periodic(updateInterval, (timer) {
      currentStep++;

      if (currentStep >= steps) {
        // Animation completed
        setState(() {
          for (var stat in stats) {
            stat['current'] = stat['number'];
          }
        });
        timer.cancel();
      } else {
        // Update counters
        setState(() {
          for (var stat in stats) {
            stat['current'] = (stat['number'] * (currentStep / steps)).round();
          }
        });
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    super.build(context);
    return Container(
      key: _sectionKey,
      margin: EdgeInsets.symmetric(
        horizontal: MediaQuery.of(context).size.width > 600 ? 16 : 12,
        vertical: MediaQuery.of(context).size.width > 600 ? 32 : 16,
      ),
      padding: EdgeInsets.symmetric(
        vertical: MediaQuery.of(context).size.width > 600 ? 40 : 24,
        horizontal: MediaQuery.of(context).size.width > 600 ? 16 : 12,
      ),
      decoration: BoxDecoration(
        color: AppColors.primary,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.1),
            blurRadius: 20,
            offset: const Offset(0, 10),
          ),
        ],
      ),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          Text(
            'حقائق بالأرقام',
            style: TextStyle(
              color: Colors.white,
              fontSize: MediaQuery.of(context).size.width > 600 ? 32 : 24,
              fontWeight: FontWeight.bold,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 12),
          Text(
            'نبذة عن أرقام من داخل مؤسستنا ... أطلب الآن دراسة جدوى اقتصادية مفصلة لمشروعك',
            style: TextStyle(
              color: Colors.white,
              fontSize: MediaQuery.of(context).size.width > 600 ? 14 : 12,
              fontWeight: FontWeight.w400,
              height: 1.4,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 24),
          AnimatedOpacity(
            opacity: _isVisible ? 1.0 : 0.0,
            duration: const Duration(milliseconds: 500),
            child: LayoutBuilder(
              builder: (context, constraints) {
                if (constraints.maxWidth > 768) {
                  return _buildDesktopLayout(stats);
                } else {
                  return _buildMobileLayout(stats);
                }
              },
            ),
          ),
        ],
      ),
    );
  }

  @override
  bool get wantKeepAlive => true;

  Widget _buildDesktopLayout(List<Map<String, dynamic>> stats) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceEvenly,
      children: stats.map((stat) => _buildStatItem(stat)).toList(),
    );
  }

  Widget _buildMobileLayout(List<Map<String, dynamic>> stats) {
    return GridView.builder(
      shrinkWrap: true,
      physics: const NeverScrollableScrollPhysics(),
      gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
        crossAxisCount: 2,
        crossAxisSpacing: 8,
        mainAxisSpacing: 8,
        childAspectRatio: 1.1,
      ),
      itemCount: stats.length,
      itemBuilder: (context, index) {
        return _buildStatItem(stats[index]);
      },
    );
  }

  Widget _buildStatItem(Map<String, dynamic> stat) {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 16, horizontal: 12),
      decoration: BoxDecoration(
        color: Colors.white.withOpacity(0.1),
        borderRadius: BorderRadius.circular(12),
        border: Border.all(
          color: Colors.white.withOpacity(0.2),
          width: 1,
        ),
      ),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Text(
            '${stat['current']}',
            style: const TextStyle(
              color: Colors.white,
              fontSize: 36,
              fontWeight: FontWeight.w800,
              shadows: [
                Shadow(
                  offset: Offset(0, 2),
                  blurRadius: 4,
                  color: Color.fromARGB(100, 0, 0, 0),
                ),
              ],
            ),
          ),
          const SizedBox(height: 4),
          Text(
            stat['label'],
            style: const TextStyle(
              color: Colors.white,
              fontSize: 14,
              fontWeight: FontWeight.w500,
            ),
          ),
        ],
      ),
    );
  }
}
