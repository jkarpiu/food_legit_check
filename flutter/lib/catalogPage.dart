import 'package:barcode_food_scaner/settings.dart';
import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';
import 'package:barcode_food_scaner/defaultAppBar.dart';
import 'package:barcode_food_scaner/drawer.dart';
import 'package:lazy_load_scrollview/lazy_load_scrollview.dart';
import 'package:barcode_food_scaner/apiController.dart';
import 'package:barcode_food_scaner/product.dart';

class Catalog extends StatefulWidget {
  @override
  _CatalogState createState() => _CatalogState();
  String category = 'Wszystkie kategorie';
}

class _CatalogState extends State<Catalog> {
  List _data = [];
  bool _initLoad = true;
  int _elements = 0;
  int _amountOfItems = 15;
  String category;
  @override
  Widget build(BuildContext context) {
    _loadData(false);
    return Scaffold(
      appBar: AppBar(
        backgroundColor: Colors.white,
        title: Container(
            padding: EdgeInsets.fromLTRB(10, 10, 10, 10),
            child: Center(
                child: DropdownButton<String>(
              isExpanded: true,
              value: widget.category,
              icon: Icon(Icons.arrow_downward),
              iconSize: 24,
              elevation: 16,
              underline: Container(
                padding: EdgeInsets.fromLTRB(0, 2, 0, 0),
                color: Colors.green[800],
                height: 2,
              ),
              onChanged: (String newValue) {
                setState(() {
                  widget.category = newValue;
                });
                setState(() {
                  category = newValue;
                  _elements = 0;
                  _data = [];
                  _loadData(true);
                });
              },
              items: <String>[
                'Wszystkie kategorie',
                'Pieczywo',
                'Przetwory',
                'Przyprawy',
              ].map<DropdownMenuItem<String>>((String value) {
                return DropdownMenuItem<String>(
                  value: value,
                  child: Text(value),
                );
              }).toList(),
            ))),
        iconTheme: IconThemeData(color: Colors.green[800]),
      ),
      drawer: AppDrawer(),
      body: LazyLoadScrollView(
        child: ListView.builder(
            itemCount: _data.length,
            itemBuilder: (context, index) {
              return FlatButton(
                child: Card(
                    child: ListTile(
                  title: Text(_data[index]['name']),
                  subtitle: Text(_data[index]['category']),
                )),
                onPressed: () {
                  Navigator.push(
                      context,
                      MaterialPageRoute(
                          builder: (context) =>
                              Product(_data[index]['id'].toString(), true)));
                },
              );
            }),
        onEndOfPage: () async {
          await _loadData(true);
        },
      ),
    );
  }

  _loadData(execute) async {
    if (execute || _initLoad) {
      var newElements =
          await Api().getCatalog(_elements, _amountOfItems, category);
      setState(() {
        _data.addAll(newElements);
        _elements += _amountOfItems;
      });
      _initLoad = false;
    }
  }
}
