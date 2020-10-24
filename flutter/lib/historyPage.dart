import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';
import 'package:lazy_load_scrollview/lazy_load_scrollview.dart';
import 'package:barcode_food_scaner/apiController.dart';
import 'package:barcode_food_scaner/product.dart';
import 'package:barcode_food_scaner/userLibrary.dart' as user;
import 'package:barcode_food_scaner/defaultAppBar.dart';
import 'drawer.dart';

class HistoryScreen extends StatefulWidget {
  @override
  _HistoryScreenState createState() => _HistoryScreenState();
}

class _HistoryScreenState extends State<HistoryScreen> {
  int _elements = 0;
  int _amountOfItems = 15;
  List _data = [];
  bool _initLoad = true;
  @override
  Widget build(BuildContext context) {
    if (user.userData != null) {
      _loadData(false);
      return Scaffold(
        appBar: flcAppBar("Historia"),
        drawer: AppDrawer(),
        body: LazyLoadScrollView(
            child: ListView.builder(
                itemCount: _data.length,
                itemBuilder: (context, index) {
                  return FlatButton(
                      onPressed: () {
                        Navigator.push(
                            context,
                            MaterialPageRoute(
                                builder: (context) => Product(
                                    _data[index]['product_id'].toString(),
                                    true)));
                      },
                      child: Card(
                          child: Container(
                        padding: EdgeInsets.fromLTRB(2, 2, 2, 2),
                        child: ListTile(
                          trailing:
                              Text(_data[index]['created_at'].substring(0, 10)),
                          title: Text(_data[index]['product']['name']),
                          subtitle: Text(_data[index]['product']['category']),
                        ),
                      )));
                }),
            onEndOfPage: () async => _loadData(true)),
      );
    } else {
      return Scaffold(
        appBar: flcAppBar("Historia"),
        drawer: AppDrawer(),
        body: Center(
          child: FlatButton(
              onPressed: () {
                Navigator.pushNamed(context, "/login");
              },
              child: Text("Zaloguj się, aby wyświetlić historie")),
        ),
      );
    }
  }

  _loadData(execute) async {
    if (execute || _initLoad) {
      var newElements = await Api().getHistory(_elements, _amountOfItems);
      setState(() {
        _data.addAll(newElements);
        _elements += _amountOfItems;
      });
      _initLoad = false;
    }
  }
}
