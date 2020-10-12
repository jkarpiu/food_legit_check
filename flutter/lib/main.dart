import 'package:barcode_food_scaner/home.dart';
import 'package:barcode_food_scaner/stats.dart';
import 'package:barcode_food_scaner/addProduct.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:barcode_food_scaner/settings.dart';

void main() => runApp(MaterialApp(
      theme: ThemeData(primaryColor: Colors.green),
      initialRoute: '/',
      routes: {
        '/': (context) => Home(),
        "/add": (context) => Add(),
        "/stats": (context) => Stats(),
        "/settings": (context) => Settings()
      },
    ));
