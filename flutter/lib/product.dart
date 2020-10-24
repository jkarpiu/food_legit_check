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
    print("test");
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
      body: Center(
        child: CustomScrollView(
          slivers: [
            SliverAppBar(
              actions: [
                IconButton(icon: Icon(Icons.more_vert), onPressed: () {})
              ],
              backgroundColor: Colors.white,
              expandedHeight: 350,
              iconTheme: IconThemeData(color: Colors.green[800]),
              flexibleSpace: FlexibleSpaceBar(
                background: _isLoading
                    ? SpinKitWanderingCubes(
                        size: 50.0,
                        color: Colors.green[800],
                      )
                    : Image.network(
                        _product['image'],
                        fit: BoxFit.cover,
                      ),
              ),
            ),
            SliverFixedExtentList(
                delegate: SliverChildListDelegate(
                    [_isLoading ? loading() : loaded(_product)]),
                itemExtent: 1000.0)
          ],
        ),
      ),
      // body: _isLoading ? loading() : loaded(_product),
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
              Container(
                  padding: EdgeInsets.fromLTRB(20, 20, 20, 20),
                  child: Column(children: <Widget>[
                    Text(
                      product["name"],
                      softWrap: true,
                    ),
                    Text(product['category']),
                    Align(
                      alignment: Alignment.bottomRight,
                      child: Text("Orientacyjna cena: " + product["price"]),
                    )
                  ]))
            ],
          ),
        ),
        Card(
            elevation: 2,
            child: Container(
              padding: EdgeInsets.fromLTRB(20, 20, 20, 20),
              child: Text(product['components'] != null
                  ? product['components']
                  : "Niestety, jeszcze nie znamy składu tego produktu :-("),
            )),
        Card(
          child: Container(
            padding: EdgeInsets.fromLTRB(20, 20, 20, 20),
            child: Text("Choróbska"),
          ),
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
