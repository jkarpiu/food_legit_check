import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:barcode_food_scaner/statsHomeWidget.dart';

class Stats extends StatefulWidget {
  _StatsState createState() => _StatsState();
}

class _StatsState extends State<Stats> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(body: SimpleBarChart.withSampleData());
  }
}
