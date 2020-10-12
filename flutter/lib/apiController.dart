import 'package:http/http.dart' as http;
import 'dart:convert';

class Api {
  String adress = "192.168.8.149:8000";
  getProduct(String barcode) async {
    print("test123123123123123123");
    final params = {"barcode": barcode};
    var data = await http.get(
      Uri.http(adress, "/api/get_product", params),
      headers: _setHeaders(),
    );
    return jsonDecode(data.body);
  }

  test() async {
    print("testuje");
    String fullUrl = adress + "test";
    var data = await http.get(fullUrl, headers: _setHeaders());
    print("kawa123");
    return jsonDecode(data.body);
  }

  _setHeaders() => {
        'Content-type': 'application/json',
        'Accept': 'application/json',
      };
}
