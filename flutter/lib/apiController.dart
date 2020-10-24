import 'package:flutter/cupertino.dart';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:convert';
import 'package:barcode_food_scaner/userLibrary.dart' as user;

class Api {
  String adress = "192.168.100.18:8000";
  getProduct(String content, bool byId) async {
    _setParams() {
      if (byId) {
        return {'id': content};
      } else {
        return {'barcode': content};
      }
    }

    final _params = _setParams();
    String fullUrl = Uri.http(adress, "/api/get_product", _params).toString();
    var data = await http.get(
      fullUrl,
      headers: await _setHeaders(true),
    );
    print(data.body);
    return jsonDecode(data.body);
  }

  test() async {
    String fullUrl = adress + "test";
    var data = await http.get(fullUrl, headers: _setHeaders(false));
    return jsonDecode(data.body);
  }

  search(String text) async {
    final params = {"query": text};
    var data = await http.get(Uri.http(adress, '/api/search', params),
        headers: await _setHeaders(false));

    return jsonDecode(data.body);
  }

  login(email, password) async {
    SharedPreferences localStorage = await SharedPreferences.getInstance();
    String fullUrl = "http://" + adress + "/api/auth/login";
    var data = await http.post(
      fullUrl,
      body: jsonEncode({"email": email, "password": password}),
      headers: await _setHeaders(false),
    );
    Map response = jsonDecode(data.body);
    if (data.statusCode == 200) {
      localStorage.setString('token', jsonEncode(response['access_token']));
    }
    return {"statusCode": data.statusCode, "body": response};
  }

  register(user) async {
    String fullUrl = "http://" + adress + "/api/auth/signup";
    var data = await http.post(fullUrl,
        body: jsonEncode(user), headers: await _setHeaders(false));
    var response = jsonDecode(data.body);
    return {"statusCode": data.statusCode, "body": response};
  }

  getUser() async {
    String fullUrl = "http://" + adress + "/api/auth/user";
    var data = await http.get(fullUrl, headers: await _setHeaders(true));
    if (data.statusCode == 200) {
      user.userData = jsonDecode(data.body);
      return true;
    } else {
      user.userData = null;
      return false;
    }
  }

  getHistory(int offset, int limit) async {
    _params() {
      return {"offset": offset.toString(), "limit": limit.toString()};
    }

    String fullUrl = Uri.http(adress, "/api/get_history", _params()).toString();
    var data = await http.get(fullUrl, headers: await _setHeaders(true));
    print(data.body);
    return jsonDecode(data.body);
  }

  getCatalog(int offset, int limit, [String category]) async {
    _params() {
      if (category == "Wszystkie kategorie")
        return {"offset": offset.toString(), "limit": limit.toString()};
      else
        return {
          "offset": offset.toString(),
          "limit": limit.toString(),
          'category': category
        };
    }

    String fullUrl = Uri.http(adress, "/api/get_catalog", _params()).toString();
    var data = await http.get(fullUrl, headers: await _setHeaders(false));
    print(data.statusCode);
    return jsonDecode(data.body);
  }

  logout() async {
    String fullUrl = "http://" + adress + "/api/auth/logout";
    SharedPreferences localStorage = await SharedPreferences.getInstance();
    await http.get(fullUrl, headers: await _setHeaders(true));
    localStorage.setString('token', null);
    user.userData = null;
  }

  _setHeaders(bool auth) async {
    SharedPreferences localStorage = await SharedPreferences.getInstance();
    var headers = {
      'Content-type': 'application/json',
      'Accept': 'application/json',
      if (auth && localStorage.getString('token') != null)
        'Authorization': 'Bearer ' + jsonDecode(localStorage.getString('token'))
    };
    return headers;
  }
}
