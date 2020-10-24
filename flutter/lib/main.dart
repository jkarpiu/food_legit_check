import 'package:barcode_food_scaner/home.dart';
import 'package:barcode_food_scaner/stats.dart';
import 'package:barcode_food_scaner/addProduct.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:barcode_food_scaner/settings.dart';
import 'profile.dart';
import 'loginPage.dart';
import 'package:barcode_food_scaner/registerPage.dart';
import 'package:barcode_food_scaner/historyPage.dart';
import 'package:barcode_food_scaner/catalogPage.dart';

void main() => runApp(MaterialApp(
      theme: ThemeData(
          primaryColor: Colors.green[800], backgroundColor: Colors.white),
      initialRoute: '/',
      routes: {
        '/': (context) => Home(),
        "/add": (context) => Add(),
        "/stats": (context) => Stats(),
        "/history": (context) => HistoryScreen(),
        "/settings": (context) => Settings(),
        "/settings/profile": (context) => ProfileSettings(),
        "/login": (context) => LoginPage(),
        "/register": (context) => RegisterPage(),
        "/catalog": (context) => Catalog()
      },
    ));
