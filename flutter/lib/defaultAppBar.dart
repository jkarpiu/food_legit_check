import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';

flcAppBar(String title) {
  return AppBar(
      title: Text(
        title,
        style: TextStyle(color: Colors.green[800], fontFamily: "Monospace"),
      ),
      backgroundColor: Colors.white,
      iconTheme: IconThemeData(color: Colors.green[800]));
}
