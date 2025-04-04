import 'package:flutter/material.dart';
import 'package:cached_network_image/cached_network_image.dart';
import '../../models/post_model.dart';
import '../../services/api_service.dart';
import '../../utils/constants.dart';
import '../shared/empty_state.dart';
import '../shared/error_state.dart';
import '../shared/loading_indicator.dart';
import '../../screens/blog/blog_details_screen.dart';

class BlogGrid extends StatefulWidget {
  const BlogGrid({Key? key}) : super(key: key);

  @override
  State<BlogGrid> createState() => _BlogGridState();
}

class _BlogGridState extends State<BlogGrid> {
  final ApiService _apiService = ApiService();
  List<Post> _posts = [];
  List<String> _categories = [];
  String? _selectedCategory;
  bool _isLoading = true;
  bool _isLoadingMore = false;
  String? _error;
  int _currentPage = 1;
  int _lastPage = 1;
  int _retryCount = 0;
  static const int _maxRetries = 3;

  @override
  void initState() {
    super.initState();
    _loadPosts();
    _loadCategories();
  }

  Future<void> _loadPosts({bool refresh = false}) async {
    if (refresh) {
      setState(() {
        _currentPage = 1;
        _isLoading = true;
        _error = null;
        _retryCount = 0;
      });
    }

    try {
      debugPrint(
          'Attempting to load posts, page: $_currentPage, category: $_selectedCategory');
      final response = await _apiService.getPosts(
        page: _currentPage,
        category: _selectedCategory,
      );

      setState(() {
        if (_currentPage == 1) {
          _posts = response.data;
        } else {
          _posts.addAll(response.data);
        }
        _lastPage = response.meta.lastPage;
        _isLoading = false;
        _isLoadingMore = false;
        _error = null;
        _retryCount = 0;
      });
      debugPrint('Successfully loaded ${response.data.length} posts');
    } catch (e) {
      debugPrint('Error loading posts: $e');

      if (_retryCount < _maxRetries) {
        _retryCount++;
        debugPrint('Retrying... attempt $_retryCount of $_maxRetries');
        await Future.delayed(const Duration(seconds: 2));
        return _loadPosts(refresh: refresh);
      }

      setState(() {
        _error = 'حدث خطأ أثناء تحميل المقالات: $e';
        _isLoading = false;
        _isLoadingMore = false;
      });
    }
  }

  Future<void> _loadCategories() async {
    try {
      debugPrint('Loading blog categories');
      final categories = await _apiService.getPostCategories();
      setState(() {
        _categories = categories;
      });
      debugPrint('Successfully loaded ${categories.length} categories');
    } catch (e) {
      debugPrint('Error loading categories: $e');
      // Silently fail, categories aren't critical
    }
  }

  Future<void> _loadMorePosts() async {
    if (_isLoadingMore || _currentPage >= _lastPage) return;

    setState(() {
      _isLoadingMore = true;
    });

    _currentPage++;
    await _loadPosts();
  }

  void _onCategorySelected(String? category) {
    if (category == _selectedCategory) return;

    setState(() {
      _selectedCategory = category;
      _currentPage = 1;
      _isLoading = true;
      _error = null;
      _retryCount = 0;
    });

    _loadPosts();
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
          else if (_error != null && _posts.isEmpty)
            ErrorState(
              message: _error!,
              onRetry: () => _loadPosts(refresh: true),
            )
          else if (_posts.isEmpty)
            const EmptyState(
              message: 'لا توجد مقالات متاحة حالياً',
              icon: Icons.article_outlined,
            )
          else
            _buildPostsGrid(),
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
            color: _selectedCategory == null
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
              color: _selectedCategory == category
                  ? AppColors.primary
                  : AppColors.textColor,
            ),
          ),
        ),
      ],
    );
  }

  Widget _buildPostsGrid() {
    return NotificationListener<ScrollNotification>(
      onNotification: (ScrollNotification scrollInfo) {
        if (scrollInfo.metrics.pixels == scrollInfo.metrics.maxScrollExtent &&
            !_isLoadingMore &&
            _currentPage < _lastPage) {
          _loadMorePosts();
          return true;
        }
        return false;
      },
      child: GridView.builder(
        shrinkWrap: true,
        physics: const NeverScrollableScrollPhysics(),
        gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
          crossAxisCount: MediaQuery.of(context).size.width > 900
              ? 3
              : MediaQuery.of(context).size.width > 600
                  ? 2
                  : 1,
          childAspectRatio: 0.8,
          crossAxisSpacing: 16,
          mainAxisSpacing: 16,
        ),
        itemCount: _posts.length,
        itemBuilder: (context, index) {
          final post = _posts[index];
          return _buildPostCard(post);
        },
      ),
    );
  }

  Widget _buildPostCard(Post post) {
    return GestureDetector(
      onTap: () {
        Navigator.push(
          context,
          MaterialPageRoute(
            builder: (context) => BlogDetailsScreen(post: post),
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
                imageUrl: post.featuredImage ?? '',
                height: 180,
                width: double.infinity,
                fit: BoxFit.cover,
                placeholder: (context, url) => Container(
                  height: 180,
                  color: Colors.grey[200],
                  child: const Center(child: CircularProgressIndicator()),
                ),
                errorWidget: (context, url, error) => Container(
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
                    post.title,
                    style: const TextStyle(
                      fontSize: 16,
                      fontWeight: FontWeight.bold,
                    ),
                    maxLines: 2,
                    overflow: TextOverflow.ellipsis,
                  ),
                  const SizedBox(height: 8),
                  if (post.publishedAt != null)
                    Text(
                      post.publishedAt!,
                      style: TextStyle(fontSize: 12, color: Colors.grey[600]),
                    ),
                  const SizedBox(height: 8),
                  Text(
                    post.metaDescription ?? '',
                    style: TextStyle(fontSize: 14, color: Colors.grey[700]),
                    maxLines: 2,
                    overflow: TextOverflow.ellipsis,
                  ),
                  const SizedBox(height: 16),
                  if (post.investmentAmount != null)
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
                        'الاستثمار: ${post.investmentAmount}',
                        style: TextStyle(
                          color: AppColors.primary,
                          fontWeight: FontWeight.bold,
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
