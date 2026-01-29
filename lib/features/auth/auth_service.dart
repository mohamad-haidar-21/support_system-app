import '../../core/api/api_client.dart';

class AuthService {
  Future<void> login(String email, String password) async {
    final res = await ApiClient.dio.post(
      "/login",
      data: {"email": email.trim(), "password": password},
    );

    final token = res.data["token"] as String?;
    final role = res.data["user"]?["role"];

    if (token == null) throw Exception("Token not returned");
    if (role != "customer") throw Exception("This account is not a customer");

    await ApiClient.saveToken(token);
  }

  Future<void> logout() async {
    try {
      await ApiClient.dio.post("/logout");
    } catch (_) {}
    await ApiClient.clearToken();
  }
}
