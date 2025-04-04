import 'dart:convert';

class Portfolio {
  final int id;
  final String title;
  final String description;
  final String? clientName;
  final String? projectUrl;
  final String? imageUrl;
  final String? type;
  final String? completionDate;
  final List<String> technologies;

  Portfolio({
    required this.id,
    required this.title,
    required this.description,
    this.clientName,
    this.projectUrl,
    this.imageUrl,
    this.type,
    this.completionDate,
    this.technologies = const [],
  });

  factory Portfolio.fromJson(Map<String, dynamic> json) {
    List<String> parseTechnologies(dynamic techData) {
      if (techData == null) return [];
      if (techData is String) {
        try {
          final decoded = jsonDecode(techData);
          if (decoded is List) {
            return decoded.map((item) => item.toString()).toList();
          }
        } catch (_) {
          // If it can't be parsed as JSON, treat it as a comma-separated string
          return techData.split(',').map((item) => item.trim()).toList();
        }
      } else if (techData is List) {
        return techData.map((item) => item.toString()).toList();
      }
      return [];
    }

    return Portfolio(
      id: json['id'],
      title: json['title'] ?? 'Untitled Project',
      description: json['description'] ?? '',
      clientName: json['client_name'],
      projectUrl: json['project_url'],
      imageUrl: json['image_url'],
      type: json['type'],
      completionDate: json['completion_date'],
      technologies: parseTechnologies(json['technologies']),
    );
  }
}

class PortfolioResponse {
  final List<Portfolio> data;
  final Meta meta;

  PortfolioResponse({required this.data, required this.meta});

  factory PortfolioResponse.fromJson(Map<String, dynamic> json) {
    List<Portfolio> parsePortfolios(List<dynamic> portfoliosJson) {
      return portfoliosJson
          .map((portfolioJson) => Portfolio.fromJson(portfolioJson))
          .toList();
    }

    return PortfolioResponse(
      data: parsePortfolios(json['data'] ?? []),
      meta: Meta.fromJson(json['meta'] ?? {}),
    );
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
