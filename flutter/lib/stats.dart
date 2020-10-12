import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:barcode_food_scaner/statsHomeWidget.dart';
import 'package:barcode_food_scaner/drawer.dart';

class Stats extends StatefulWidget {
  _StatsState createState() => _StatsState();
}

class _StatsState extends State<Stats> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
        appBar: new AppBar(
          title: Text("Statystyki"),
        ),
        drawer: AppDrawer(),
        body: SimpleBarChart.withSampleData());
  }
}
