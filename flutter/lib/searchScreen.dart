import 'package:barcode_food_scaner/product.dart';
import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';
import 'package:barcode_food_scaner/apiController.dart';

class SearchScreen extends StatefulWidget {
  List foundItem = [];
  @override
  _SearchSceenState createState() => _SearchSceenState();
}

class _SearchSceenState extends State<SearchScreen> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: new AppBar(
        title: Form(
            child: TextFormField(
          autofocus: true,
          decoration: InputDecoration(prefixIcon: Icon(Icons.search)),
          onChanged: (String value) async {
            List data = await Api().search(value);
            if (value.isNotEmpty) {
              setState(() {
                widget.foundItem = data;
              });
            } else {
              setState(() {
                widget.foundItem = [];
              });
            }
          },
        )),
        backgroundColor: Colors.white,
        iconTheme: IconThemeData(color: Colors.green[800]),
      ),
      body: ListView.builder(
          itemCount: widget.foundItem.length,
          itemBuilder: (BuildContext ctxt, int index) {
            return FlatButton(
                onPressed: () {
                  Navigator.push(
                      context,
                      MaterialPageRoute(
                          builder: (context) => Product(
                              widget.foundItem[index]['id'].toString(), true)));
                },
                child: Card(
                    child: ListTile(
                        title: Text(widget.foundItem[index]['name']))));
          }),
    );
  }
}
