import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:barcode_food_scaner/statsHomeWidget.dart';
import 'package:barcode_food_scaner/drawer.dart';
import 'package:barcode_food_scaner/defaultAppBar.dart';

class Stats extends StatefulWidget {
  _StatsState createState() => _StatsState();
}

class _StatsState extends State<Stats> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
        appBar: flcAppBar("Statystyki"),
        drawer: AppDrawer(),
        body: SimpleBarChart.withSampleData());
  }
}
