import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';

class HistoryScreen extends StatefulWidget {
  @override
  _HistoryScreenState createState() => _HistoryScreenState();
}

class _HistoryScreenState extends State<HistoryScreen> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("Historia"),
        backgroundColor: Colors.white,
        iconTheme: IconThemeData(color: Colors.green[800]),
      ),
    );
  }
}
