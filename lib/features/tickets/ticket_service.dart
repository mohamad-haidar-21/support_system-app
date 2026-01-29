import 'package:dio/dio.dart';
import '../../core/api/api_client.dart';

class TicketService {
  /// Create ticket and return the raw response map.
  /// Expected backend response shape (example):
  /// {
  ///   "ticket": {...},
  ///   "conversation": {"id": 12, ...}
  /// }
  Future<Map<String, dynamic>> createTicket({
    required String title,
    String? description,
    String priority = "medium",
  }) async {
    final res = await ApiClient.dio.post(
      "/tickets",
      data: {
        "title": title,
        "description": description,
        "priority": priority,
      },
    );

    return (res.data as Map<String, dynamic>);
  }

  /// Get current user's tickets
  /// Expected:
  /// { "tickets": { "data": [...] } }
  Future<List<Map<String, dynamic>>> myTickets() async {
    final res = await ApiClient.dio.get("/tickets/my");
    final data = (res.data["tickets"]["data"] as List).cast<Map<String, dynamic>>();
    return data;
  }

  /// Get ticket details
  /// Expected:
  /// { "ticket": {..., "attachments": [], "conversation": {"id": ...}} }
  Future<Map<String, dynamic>> ticketDetails(int ticketId) async {
    final res = await ApiClient.dio.get("/tickets/$ticketId");
    return (res.data["ticket"] as Map<String, dynamic>);
  }

  /// Upload attachment (we will use later)
  Future<void> uploadAttachment({
    required int ticketId,
    required String type, // image | video | audio
    required String filePath,
    String? fileName,
  }) async {
    final form = FormData.fromMap({
      "type": type,
      "file": await MultipartFile.fromFile(
        filePath,
        filename: fileName,
      ),
    });

    await ApiClient.dio.post(
      "/tickets/$ticketId/attachments",
      data: form,
      options: Options(contentType: "multipart/form-data"),
    );
  }
}
