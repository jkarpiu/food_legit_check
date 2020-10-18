import 'package:flutter/cupertino.dart';

import 'package:flutter/material.dart';

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
        title: Text("Produkt"),
      ),
      body: ListView(
        padding: EdgeInsets.fromLTRB(10, 10, 10, 10),
        children: <Widget>[
          Card(
            elevation: 2,
            child: Row(
              children: [
                SizedBox(
                    width: 120,
                    child: Image.network(widget.displayedProuduct["image"])),
                Column(children: <Widget>[
                  Text(widget.displayedProuduct["name"]),
                  Align(
                    alignment: Alignment.bottomRight,
                    child: Text("Orientacyjna cena: " +
                        widget.displayedProuduct["price"]),
                  )
                ])
              ],
            ),
          ),
          Card(
            elevation: 2,
            child: Text(widget.displayedProuduct['components']),
          )
        ],
      ),
    );
  }
}
