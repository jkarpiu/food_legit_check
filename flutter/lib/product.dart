import 'package:flutter/cupertino.dart';

import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';

class Product extends StatefulWidget {
  final Map displayedProuduct;

  const Product(this.displayedProuduct);
  @override
  _ProductState createState() => _ProductState();
}

class _ProductState extends State<Product> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: new AppBar(
        leading: IconButton(
            icon: Icon(Icons.arrow_back),
            onPressed: () {
              Navigator.pop(context, false);
            }),
        title: Text(widget.displayedProuduct["name"]),
      ),
      body:   ,
    );
  }
}
