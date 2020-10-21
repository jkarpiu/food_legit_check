import 'package:barcode_food_scaner/product.dart';
import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';
import 'package:barcode_food_scaner/apiController.dart';
import 'package:flutter_spinkit/flutter_spinkit.dart';

class SearchScreen extends StatefulWidget {
  List foundItem = [];
  @override
  _SearchSceenState createState() => _SearchSceenState();
}

class _SearchSceenState extends State<SearchScreen> {
  bool isLoading = false;
  TextEditingController _controller = new TextEditingController();
  @override
  Widget build(BuildContext context) {
    return Scaffold(
        appBar: new AppBar(
          title: Form(
              child: TextFormField(
            controller: _controller,
            autofocus: true,
            decoration: InputDecoration(
                prefixIcon: Icon(Icons.search),
                suffixIcon: IconButton(
                  icon: Icon(Icons.cancel),
                  onPressed: () {
                    _controller.text = "";
                    setState(() {
                      widget.foundItem = [];
                    });
                  },
                )),
            onChanged: (String value) async {
              isLoading = true;
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
              setState(() {
                isLoading = false;
              });
            },
          )),
          backgroundColor: Colors.white,
          iconTheme: IconThemeData(color: Colors.green[800]),
        ),
        body: isLoading
            ? Align(
                alignment: Alignment.center,
                child: SpinKitWanderingCubes(
                  size: 50.0,
                  color: Colors.green[800],
                ))
            : productsList());
  }

  productsList() {
    return ListView.builder(
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
                  child:
                      ListTile(title: Text(widget.foundItem[index]['name']))));
        });
  }
}
