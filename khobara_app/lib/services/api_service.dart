import 'dart:convert';
import 'package:flutter/foundation.dart';
import 'package:http/http.dart' as http;
import '../models/portfolio_model.dart';
import '../models/post_model.dart';
import '../utils/constants.dart';

class ApiService {
  // Using the getter from AppConstants to ensure we get the correct value each time
  String get baseUrl => AppConstants.baseUrl;
  final http.Client _client = http.Client();

  // Helper method for debugging API calls
  void _logApiCall(Uri url, http.Response response) {
    debugPrint('⚡️ API CALL: $url');
    debugPrint('📊 STATUS CODE: ${response.statusCode}');

    // Only print a snippet of the response body to avoid log overflow
    String bodyPreview = response.body.length > 200
        ? '${response.body.substring(0, 200)}...'
        : response.body;
    debugPrint('📝 BODY PREVIEW: $bodyPreview');

    // Try to detect if we got HTML instead of JSON (common error with 404/500 responses)
    if (response.body.trim().startsWith('<!DOCTYPE html>') ||
        response.body.trim().startsWith('<html>')) {
      debugPrint(
          '⚠️ WARNING: Received HTML response instead of JSON - likely a server error page');
    }
  }

  // Portfolio methods
  Future<PortfolioResponse> getPortfolios({int page = 1, String? type}) async {
    final Map<String, String> queryParams = {'page': page.toString()};

    if (type != null) {
      queryParams['type'] = type;
    }

    final Uri url = Uri.parse(
      '$baseUrl${AppConstants.portfoliosEndpoint}',
    ).replace(queryParameters: queryParams);

    try {
      debugPrint('Calling API: $url');
      final response = await _client.get(url);
      _logApiCall(url, response);

      if (response.statusCode == 200) {
        final jsonData = json.decode(response.body);
        return PortfolioResponse.fromJson(jsonData);
      } else {
        final error = 'Failed to load portfolios: ${response.statusCode}';
        debugPrint(error);
        throw Exception(error);
      }
    } catch (e) {
      debugPrint('Error in getPortfolios: $e');
      throw Exception('Failed to load portfolios: $e');
    }
  }

  Future<Portfolio> getPortfolioById(int id) async {
    final Uri url = Uri.parse('$baseUrl${AppConstants.portfoliosEndpoint}/$id');

    try {
      debugPrint('Calling API: $url');
      final response = await _client.get(url);
      _logApiCall(url, response);

      if (response.statusCode == 200) {
        final jsonData = json.decode(response.body);
        return Portfolio.fromJson(jsonData['data']);
      } else {
        throw Exception('Failed to load portfolio: ${response.statusCode}');
      }
    } catch (e) {
      debugPrint('Error in getPortfolioById: $e');
      throw Exception('Failed to load portfolio: $e');
    }
  }

  Future<List<String>> getPortfolioCategories() async {
    final Uri url = Uri.parse(
      '$baseUrl${AppConstants.portfoliosEndpoint}/categories',
    );

    try {
      debugPrint('Calling API: $url');
      final response = await _client.get(url);
      _logApiCall(url, response);

      if (response.statusCode == 200) {
        final jsonData = json.decode(response.body);
        final List<dynamic> categories = jsonData['data'];
        return categories.map((category) => category.toString()).toList();
      } else {
        throw Exception(
          'Failed to load portfolio categories: ${response.statusCode}',
        );
      }
    } catch (e) {
      debugPrint('Error in getPortfolioCategories: $e');
      throw Exception('Failed to load portfolio categories: $e');
    }
  }

  // Blog post methods
  Future<PostResponse> getPosts({int page = 1, String? category}) async {
    final Map<String, String> queryParams = {'page': page.toString()};

    if (category != null) {
      queryParams['category'] = category;
    }

    // Log the actual baseUrl we're using
    debugPrint('🌐 Using API base URL: $baseUrl');

    final Uri url = Uri.parse(
      '$baseUrl${AppConstants.postsEndpoint}',
    ).replace(queryParameters: queryParams);

    try {
      debugPrint('📞 Calling API: $url');
      final response = await _client.get(url);
      _logApiCall(url, response);

      if (response.statusCode == 200) {
        try {
          final jsonData = json.decode(response.body);

          // Log the structure of the response to better understand it
          debugPrint('📊 API Response Structure:');
          debugPrint('- Response is a ${jsonData.runtimeType}');

          if (jsonData is Map) {
            jsonData.forEach((key, value) {
              debugPrint('- Key: $key (${value.runtimeType})');
              if (key == 'data' && value is Map) {
                value.forEach((subKey, subValue) {
                  debugPrint('  - SubKey: $subKey (${subValue.runtimeType})');
                });
              }
            });
          }

          return PostResponse.fromJson(jsonData);
        } catch (parseError) {
          debugPrint('🔴 JSON parse error: $parseError');
          debugPrint('Response body: ${response.body}');
          throw Exception('Error parsing posts data: $parseError');
        }
      } else {
        final error = 'Failed to load posts: ${response.statusCode}';
        debugPrint('🔴 $error');
        throw Exception(error);
      }
    } catch (e) {
      debugPrint('🔴 Error in getPosts: $e');
      throw Exception('Failed to load posts: $e');
    }
  }

  Future<Post> getPostById(int id) async {
    final Uri url = Uri.parse('$baseUrl${AppConstants.postsEndpoint}/$id');

    try {
      debugPrint('Calling API: $url');
      final response = await _client.get(url);
      _logApiCall(url, response);

      if (response.statusCode == 200) {
        final jsonData = json.decode(response.body);
        return Post.fromJson(jsonData['data']);
      } else {
        throw Exception('Failed to load post: ${response.statusCode}');
      }
    } catch (e) {
      debugPrint('Error in getPostById: $e');
      throw Exception('Failed to load post: $e');
    }
  }

  Future<List<String>> getPostCategories() async {
    final Uri url = Uri.parse(
      '$baseUrl${AppConstants.postsEndpoint}/categories',
    );

    try {
      debugPrint('Calling API: $url');
      final response = await _client.get(url);
      _logApiCall(url, response);

      if (response.statusCode == 200) {
        final jsonData = json.decode(response.body);
        final List<dynamic> categories = jsonData['data'];
        return categories.map((category) => category.toString()).toList();
      } else {
        throw Exception(
          'Failed to load post categories: ${response.statusCode}',
        );
      }
    } catch (e) {
      debugPrint('Error in getPostCategories: $e');
      throw Exception('Failed to load post categories: $e');
    }
  }

  // Investment opportunities methods
  Future<PostResponse> getInvestmentOpportunities({int page = 1}) async {
    final Map<String, String> queryParams = {'page': page.toString()};

    final Uri url = Uri.parse(
      '$baseUrl${AppConstants.opportunitiesEndpoint}',
    ).replace(queryParameters: queryParams);

    try {
      debugPrint('Calling API: $url');
      final response = await _client.get(url);
      _logApiCall(url, response);

      if (response.statusCode == 200) {
        final jsonData = json.decode(response.body);
        return PostResponse.fromJson(jsonData);
      } else {
        throw Exception(
          'Failed to load investment opportunities: ${response.statusCode}',
        );
      }
    } catch (e) {
      debugPrint('Error in getInvestmentOpportunities: $e');
      throw Exception('Failed to load investment opportunities: $e');
    }
  }

  Future<Post> getInvestmentOpportunityById(int id) async {
    final Uri url = Uri.parse(
      '$baseUrl${AppConstants.opportunitiesEndpoint}/$id',
    );

    try {
      debugPrint('Calling API: $url');
      final response = await _client.get(url);
      _logApiCall(url, response);

      if (response.statusCode == 200) {
        final jsonData = json.decode(response.body);
        return Post.fromJson(jsonData['data']);
      } else {
        throw Exception(
          'Failed to load investment opportunity: ${response.statusCode}',
        );
      }
    } catch (e) {
      debugPrint('Error in getInvestmentOpportunityById: $e');
      throw Exception('Failed to load investment opportunity: $e');
    }
  }

  // Contact form submission
  Future<bool> submitContactForm(Map<String, dynamic> formData) async {
    final Uri url = Uri.parse('$baseUrl/contact');

    try {
      debugPrint('Submitting contact form to: $url');
      debugPrint('Contact form data: $formData');
      final response = await _client.post(
        url,
        headers: {'Content-Type': 'application/json'},
        body: json.encode(formData),
      );
      _logApiCall(url, response);

      return response.statusCode == 200 || response.statusCode == 201;
    } catch (e) {
      debugPrint('Error in submitContactForm: $e');
      throw Exception('Failed to submit contact form: $e');
    }
  }

  // Project request submission
  Future<bool> submitProjectRequest(Map<String, dynamic> formData) async {
    final Uri url = Uri.parse('$baseUrl/project-requests');

    try {
      debugPrint('Submitting project request to: $url');
      debugPrint('Project request data: $formData');
      final response = await _client.post(
        url,
        headers: {'Content-Type': 'application/json'},
        body: json.encode(formData),
      );
      _logApiCall(url, response);

      return response.statusCode == 200 || response.statusCode == 201;
    } catch (e) {
      debugPrint('Error in submitProjectRequest: $e');
      throw Exception('Failed to submit project request: $e');
    }
  }

  void dispose() {
    _client.close();
  }
}
