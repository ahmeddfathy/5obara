import 'package:flutter/material.dart';
import 'package:cached_network_image/cached_network_image.dart';
import '../../models/portfolio_model.dart';
import '../../services/api_service.dart';
import '../../utils/constants.dart';
import '../shared/empty_state.dart';
import '../shared/error_state.dart';
import '../shared/loading_indicator.dart';
import '../../screens/portfolio/portfolio_details_screen.dart';

class PortfolioGrid extends StatefulWidget {
  const PortfolioGrid({Key? key}) : super(key: key);

  @override
  State<PortfolioGrid> createState() => _PortfolioGridState();
}

class _PortfolioGridState extends State<PortfolioGrid> {
  final ApiService _apiService = ApiService();
  List<Portfolio> _portfolios = [];
  List<String> _categories = [];
  String? _selectedCategory;
  bool _isLoading = true;
  bool _isLoadingMore = false;
  String? _error;
  int _currentPage = 1;
  int _lastPage = 1;

  @override
  void initState() {
    super.initState();
    _loadPortfolios();
    _loadCategories();
  }

  Future<void> _loadPortfolios({bool refresh = false}) async {
    if (refresh) {
      setState(() {
        _currentPage = 1;
        _isLoading = true;
        _error = null;
      });
    }

    try {
      final response = await _apiService.getPortfolios(
        page: _currentPage,
        type: _selectedCategory,
      );

      setState(() {
        if (_currentPage == 1) {
          _portfolios = response.data;
        } else {
          _portfolios.addAll(response.data);
        }
        _lastPage = response.meta.lastPage;
        _isLoading = false;
        _isLoadingMore = false;
      });
    } catch (e) {
      setState(() {
        _error = 'حدث خطأ أثناء تحميل المشاريع';
        _isLoading = false;
        _isLoadingMore = false;
      });
    }
  }

  Future<void> _loadCategories() async {
    try {
      final categories = await _apiService.getPortfolioCategories();
      setState(() {
        _categories = categories;
      });
    } catch (e) {
      // Silently fail, categories aren't critical
    }
  }

  Future<void> _loadMorePortfolios() async {
    if (_isLoadingMore || _currentPage >= _lastPage) return;

    setState(() {
      _isLoadingMore = true;
    });

    _currentPage++;
    await _loadPortfolios();
  }

  void _onCategorySelected(String? category) {
    if (category == _selectedCategory) return;

    setState(() {
      _selectedCategory = category;
      _currentPage = 1;
      _isLoading = true;
    });

    _loadPortfolios();
  }

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(24),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          if (_categories.isNotEmpty) _buildCategoryFilter(),
          const SizedBox(height: 24),
          if (_isLoading && _currentPage == 1)
            const LoadingIndicator()
          else if (_error != null && _portfolios.isEmpty)
            ErrorState(
              message: _error!,
              onRetry: () => _loadPortfolios(refresh: true),
            )
          else if (_portfolios.isEmpty)
            const EmptyState(
              message: 'لا توجد مشاريع متاحة حالياً',
              icon: Icons.work_outline,
            )
          else
            _buildPortfoliosGrid(),
          if (_isLoadingMore)
            const Padding(
              padding: EdgeInsets.symmetric(vertical: 16),
              child: Center(child: CircularProgressIndicator()),
            ),
        ],
      ),
    );
  }

  Widget _buildCategoryFilter() {
    return Wrap(
      spacing: 8,
      runSpacing: 8,
      children: [
        FilterChip(
          label: const Text('الكل'),
          selected: _selectedCategory == null,
          onSelected: (_) => _onCategorySelected(null),
          backgroundColor: Colors.grey[200],
          selectedColor: AppColors.primary.withOpacity(0.2),
          checkmarkColor: AppColors.primary,
          labelStyle: TextStyle(
            color:
                _selectedCategory == null
                    ? AppColors.primary
                    : AppColors.textColor,
          ),
        ),
        ..._categories.map(
          (category) => FilterChip(
            label: Text(category),
            selected: _selectedCategory == category,
            onSelected: (_) => _onCategorySelected(category),
            backgroundColor: Colors.grey[200],
            selectedColor: AppColors.primary.withOpacity(0.2),
            checkmarkColor: AppColors.primary,
            labelStyle: TextStyle(
              color:
                  _selectedCategory == category
                      ? AppColors.primary
                      : AppColors.textColor,
            ),
          ),
        ),
      ],
    );
  }

  Widget _buildPortfoliosGrid() {
    return NotificationListener<ScrollNotification>(
      onNotification: (ScrollNotification scrollInfo) {
        if (scrollInfo.metrics.pixels == scrollInfo.metrics.maxScrollExtent &&
            !_isLoadingMore &&
            _currentPage < _lastPage) {
          _loadMorePortfolios();
          return true;
        }
        return false;
      },
      child: GridView.builder(
        shrinkWrap: true,
        physics: const NeverScrollableScrollPhysics(),
        gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
          crossAxisCount:
              MediaQuery.of(context).size.width > 900
                  ? 3
                  : MediaQuery.of(context).size.width > 600
                  ? 2
                  : 1,
          childAspectRatio: 0.8,
          crossAxisSpacing: 16,
          mainAxisSpacing: 16,
        ),
        itemCount: _portfolios.length,
        itemBuilder: (context, index) {
          final portfolio = _portfolios[index];
          return _buildPortfolioCard(portfolio);
        },
      ),
    );
  }

  Widget _buildPortfolioCard(Portfolio portfolio) {
    return GestureDetector(
      onTap: () {
        Navigator.push(
          context,
          MaterialPageRoute(
            builder: (context) => PortfolioDetailsScreen(portfolio: portfolio),
          ),
        );
      },
      child: Container(
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(8),
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
            ClipRRect(
              borderRadius: const BorderRadius.only(
                topLeft: Radius.circular(8),
                topRight: Radius.circular(8),
              ),
              child: CachedNetworkImage(
                imageUrl: portfolio.imageUrl ?? '',
                height: 180,
                width: double.infinity,
                fit: BoxFit.cover,
                placeholder:
                    (context, url) => Container(
                      height: 180,
                      color: Colors.grey[200],
                      child: const Center(child: CircularProgressIndicator()),
                    ),
                errorWidget:
                    (context, url, error) => Container(
                      height: 180,
                      color: Colors.grey[200],
                      child: const Center(
                        child: Icon(Icons.error, size: 50, color: Colors.grey),
                      ),
                    ),
              ),
            ),
            Padding(
              padding: const EdgeInsets.all(16),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    portfolio.title,
                    style: const TextStyle(
                      fontSize: 16,
                      fontWeight: FontWeight.bold,
                    ),
                    maxLines: 2,
                    overflow: TextOverflow.ellipsis,
                  ),
                  const SizedBox(height: 8),
                  if (portfolio.clientName != null)
                    Text(
                      portfolio.clientName!,
                      style: TextStyle(
                        fontSize: 14,
                        color: Colors.grey[600],
                        fontWeight: FontWeight.w500,
                      ),
                    ),
                  const SizedBox(height: 8),
                  Text(
                    portfolio.description,
                    style: TextStyle(fontSize: 14, color: Colors.grey[700]),
                    maxLines: 2,
                    overflow: TextOverflow.ellipsis,
                  ),
                  const SizedBox(height: 16),
                  if (portfolio.type != null)
                    Container(
                      padding: const EdgeInsets.symmetric(
                        horizontal: 8,
                        vertical: 4,
                      ),
                      decoration: BoxDecoration(
                        color: AppColors.primary.withOpacity(0.1),
                        borderRadius: BorderRadius.circular(4),
                      ),
                      child: Text(
                        portfolio.type!,
                        style: TextStyle(
                          color: AppColors.primary,
                          fontWeight: FontWeight.bold,
                          fontSize: 12,
                        ),
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
}
