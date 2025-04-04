import 'dart:convert';

class Post {
  final int id;
  final String title;
  final String content;
  final String? slug;
  final String? metaDescription;
  final String? featuredImage;
  final String? publishedAt;
  final String? investmentAmount;
  final String? investmentType;
  final String? location;
  final List<String> tags;
  final List<String>? investmentHighlights;
  final List<PostImage> galleryImages;
  final bool? hasVirtualGallery;

  Post({
    required this.id,
    required this.title,
    required this.content,
    this.slug,
    this.metaDescription,
    this.featuredImage,
    this.publishedAt,
    this.investmentAmount,
    this.investmentType,
    this.location,
    this.tags = const [],
    this.investmentHighlights,
    this.galleryImages = const [],
    this.hasVirtualGallery,
  });

  factory Post.fromJson(Map<String, dynamic> json) {
    List<String> parseTags(dynamic tagsData) {
      if (tagsData == null) return [];
      if (tagsData is String) {
        try {
          final decoded = jsonDecode(tagsData);
          if (decoded is List) {
            return decoded.map((item) => item.toString()).toList();
          }
        } catch (_) {
          // If it can't be parsed as JSON, treat it as a comma-separated string
          return tagsData
              .split(',')
              .map((item) => item.trim())
              .where((item) => item.isNotEmpty)
              .toList();
        }
      } else if (tagsData is List) {
        return tagsData.map((item) => item.toString()).toList();
      }
      return [];
    }

    List<String> parseHighlights(dynamic highlightsData) {
      if (highlightsData == null) return [];
      if (highlightsData is String) {
        try {
          final decoded = jsonDecode(highlightsData);
          if (decoded is List) {
            return decoded.map((item) => item.toString()).toList();
          }
        } catch (_) {
          // If it can't be parsed as JSON, treat it as a comma-separated string
          return highlightsData
              .split(',')
              .map((item) => item.trim())
              .where((item) => item.isNotEmpty)
              .toList();
        }
      } else if (highlightsData is List) {
        return highlightsData.map((item) => item.toString()).toList();
      }
      return [];
    }

    List<PostImage> parseGalleryImages(dynamic imagesData) {
      if (imagesData == null) return [];
      if (imagesData is String) {
        try {
          final decoded = jsonDecode(imagesData);
          if (decoded is List) {
            return decoded.map((item) => PostImage.fromJson(item)).toList();
          }
        } catch (_) {
          return [];
        }
      } else if (imagesData is List) {
        return imagesData.map((item) => PostImage.fromJson(item)).toList();
      }
      return [];
    }

    String? formatPublishedAt(dynamic dateData) {
      if (dateData == null) return null;
      if (dateData is String) {
        try {
          final date = DateTime.parse(dateData);
          return '${date.year}-${date.month.toString().padLeft(2, '0')}-${date.day.toString().padLeft(2, '0')}';
        } catch (_) {
          return dateData;
        }
      }
      return dateData.toString();
    }

    String? formatInvestmentAmount(dynamic amount) {
      if (amount == null) return null;
      return amount.toString();
    }

    return Post(
      id: json['id'],
      title: json['title'] ?? 'Untitled Post',
      content: json['content'] ?? '',
      slug: json['slug'],
      metaDescription: json['meta_description'],
      featuredImage: json['featured_image'],
      publishedAt: formatPublishedAt(json['published_at']),
      investmentAmount: formatInvestmentAmount(json['investment_amount']),
      investmentType: json['investment_type'],
      location: json['location'],
      tags: parseTags(json['tags']),
      investmentHighlights: parseHighlights(json['investment_highlights']),
      galleryImages: parseGalleryImages(json['gallery_images']),
      hasVirtualGallery: json['has_virtual_gallery'],
    );
  }

  bool get isInvestmentOpportunity => investmentAmount != null;

  String get formattedInvestmentAmount {
    if (investmentAmount == null) return '';
    return investmentAmount!;
  }

  String getShortContent(int length) {
    if (content.isEmpty) return '';
    String plainText = content.replaceAll(RegExp(r'<[^>]*>'), '');
    if (plainText.length <= length) return plainText;
    return '${plainText.substring(0, length - 3)}...';
  }
}

class PostImage {
  final String url;
  final String? caption;

  PostImage({required this.url, this.caption});

  factory PostImage.fromJson(Map<String, dynamic> json) {
    return PostImage(url: json['url'] ?? '', caption: json['caption']);
  }
}

class PostResponse {
  final List<Post> data;
  final Meta meta;

  PostResponse({required this.data, required this.meta});

  factory PostResponse.fromJson(Map<String, dynamic> json) {
    // Check if we have a Laravel pagination format with nested data
    if (json.containsKey('data') &&
        json['data'] is Map &&
        json['data'].containsKey('data')) {
      // Laravel pagination format where data is nested inside another data object
      final paginationData = json['data'] as Map<String, dynamic>;

      List<Post> parsePosts(List<dynamic> postsJson) {
        return postsJson.map((postJson) => Post.fromJson(postJson)).toList();
      }

      return PostResponse(
        data: parsePosts(paginationData['data'] ?? []),
        meta: Meta.fromJson({
          'current_page': paginationData['current_page'] ?? 1,
          'last_page': paginationData['last_page'] ?? 1,
          'per_page': paginationData['per_page'] ?? 10,
          'total': paginationData['total'] ?? 0,
        }),
      );
    } else {
      // Standard API format (direct data array)
      List<Post> parsePosts(List<dynamic> postsJson) {
        return postsJson.map((postJson) => Post.fromJson(postJson)).toList();
      }

      return PostResponse(
        data: parsePosts(json['data'] ?? []),
        meta: Meta.fromJson(json['meta'] ?? {}),
      );
    }
  }
}

class Meta {
  final int currentPage;
  final int lastPage;
  final int perPage;
  final int total;

  Meta({
    required this.currentPage,
    required this.lastPage,
    required this.perPage,
    required this.total,
  });

  factory Meta.fromJson(Map<String, dynamic> json) {
    return Meta(
      currentPage: json['current_page'] ?? 1,
      lastPage: json['last_page'] ?? 1,
      perPage: json['per_page'] ?? 10,
      total: json['total'] ?? 0,
    );
  }
}
