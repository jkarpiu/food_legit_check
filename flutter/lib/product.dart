import 'package:barcode_food_scaner/apiController.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter_spinkit/flutter_spinkit.dart';
import 'package:flutter/material.dart';

class Product extends StatefulWidget {
  final String content;
  final bool byId;
  const Product(this.content, this.byId);

  @override
  _ProductState createState() => _ProductState();
}

class _ProductState extends State<Product> {
  bool _isLoading = true;
  var _product;

  loadData() async {
    _product = await Api().getProduct(widget.content, widget.byId);
    setState(() {
      _isLoading = false;
    });
    _product = _product[0];
    print(_product);
  }

  @override
  Widget build(BuildContext context) {
    if (_isLoading) loadData();
    return Scaffold(
      appBar: new AppBar(
        leading: IconButton(
            icon: Icon(Icons.arrow_back),
            onPressed: () {
              Navigator.pop(context, false);
            }),
        title: Text("Produkt"),
      ),
      body: _isLoading ? loading() : loaded(_product),
    );
  }

  loaded(product) {
    return ListView(
      padding: EdgeInsets.fromLTRB(10, 10, 10, 10),
      children: <Widget>[
        Card(
          elevation: 2,
          child: Row(
            children: [
              SizedBox(width: 120, child: Image.network(product["image"])),
              Column(children: <Widget>[
                Text(product["name"]),
                Align(
                  alignment: Alignment.bottomRight,
                  child: Text("Orientacyjna cena: " + product["price"]),
                )
              ])
            ],
          ),
        ),
        Card(
          elevation: 2,
          child: Text(product['components']),
        )
      ],
    );
  }

  loading() {
    return Align(
      alignment: Alignment.center,
      child: SpinKitWanderingCubes(
        color: Colors.green[800],
        size: 50.0,
      ),
    );
  }
}
