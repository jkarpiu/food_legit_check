import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:convert';

class Api {
  String adress = "192.168.8.149:8000";
  getProduct(String barcode) async {
    final params = {"barcode": barcode};
    var data = await http.get(
      Uri.http(adress, "/api/get_product", params),
      headers: _setHeaders(),
    );
    return jsonDecode(data.body);
  }

  test() async {
    String fullUrl = adress + "test";
    var data = await http.get(fullUrl, headers: _setHeaders());
    return jsonDecode(data.body);
  }

  login(email, password) async {
    String fullUrl = "http://" + adress + "/api/auth/login";
    SharedPreferences localStorage = await SharedPreferences.getInstance();
    var data = await http.post(
      fullUrl,
      body: jsonEncode({"email": email, "password": password}),
      headers: _setHeaders(),
    );
    Map response = jsonDecode(data.body);
    if (data.statusCode == 200) {
      localStorage.setString('token', jsonEncode(response['access_token']));
    }
    return {"statusCode": data.statusCode, "body": response};
  }

  _setHeaders() => {
        'Content-type': 'application/json',
        'Accept': 'application/json',
      };
}
