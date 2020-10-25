import 'package:barcode_food_scaner/apiController.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter_spinkit/flutter_spinkit.dart';
import 'package:flutter/material.dart';
import 'package:flushbar/flushbar.dart';
import 'package:barcode_food_scaner/report.dart';

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
  var _ill;
  loadData() async {
    _product = await Api().getProduct(widget.content, widget.byId);
    if (_product.isEmpty) {
      Navigator.pop(context);
      Flushbar(
        title: "Nie znaleziono produktu ://",
        message: "Może zechciałbyś go dodać do naszej bazy?",
        duration: Duration(seconds: 3),
        mainButton: FlatButton(
            onPressed: () {
              Navigator.pop(context);
              Navigator.pushNamed(context, '/add');
            },
            child: Text(
              "Dodaj produkt",
              style: TextStyle(color: Colors.green[800]),
            )),
      )..show(context);
      return;
    } else {
      _ill = await Api().get_ill(_product[0]['id'].toString());
      print(_ill);
      setState(() {
        _isLoading = false;
      });
      _product = _product[0];
    }
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
                PopupMenuButton<String>(
                  onSelected: handleClick,
                  itemBuilder: (BuildContext context) {
                    return {'Zgłoś produkt'}.map((String choice) {
                      return PopupMenuItem<String>(
                        value: choice,
                        child: FlatButton(
                          child: Text("Zgłoś produkt"),
                          onPressed: () {
                            Navigator.push(
                                context,
                                MaterialPageRoute(
                                    builder: (context) =>
                                        ReportPage(_product['id'].toString())));
                          },
                        ),
                      );
                    }).toList();
                  },
                ),
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
                itemExtent: 500.0)
          ],
        ),
      ),
      // body: _isLoading ? loading() : loaded(_product),
    );
  }

  void handleClick(String value) {
    switch (value) {
      case 'Zgłoś produkt':
        break;
    }
  }

  loaded(product) {
    return ListView(
      padding: EdgeInsets.fromLTRB(10, 10, 10, 10),
      children: <Widget>[
        Card(
          elevation: 2,
          child: Container(
              padding: EdgeInsets.fromLTRB(20, 20, 20, 20),
              child: Column(children: <Widget>[
                RichText(
                  text: TextSpan(
                      style: TextStyle(
                        color: Colors.grey[800],
                      ),
                      children: [
                        TextSpan(
                            text: product['name'] + "\n",
                            style: TextStyle(fontSize: 22)),
                        TextSpan(
                            text: product['category'] + "\n",
                            style: TextStyle(color: Colors.grey, fontSize: 16)),
                      ]),
                ),
                Align(
                  alignment: Alignment.bottomRight,
                  child: Text(product['price'] + " zł",
                      style: TextStyle(fontSize: 20)),
                )
              ])),
        ),
        Card(
            elevation: 2,
            child: Container(
                padding: EdgeInsets.fromLTRB(20, 20, 20, 20),
                child: Column(children: [
                  Align(
                      alignment: Alignment.topLeft,
                      child: Text("Składniki: ",
                          style: TextStyle(fontSize: 14, color: Colors.grey))),
                  SizedBox(
                    height: 10,
                  ),
                  Text(product['components'] != null
                      ? product['components']
                      : "Niestety, jeszcze nie znamy składu tego produktu :-("),
                ]))),
        Card(
            child: !_ill.isEmpty
                ? ListView.builder(
                    physics: NeverScrollableScrollPhysics(),
                    shrinkWrap: true,
                    itemCount: _ill.length,
                    itemBuilder: (context, index) {
                      return Container(
                          padding: EdgeInsets.all(10),
                          child: Column(
                            children: [
                              RichText(
                                  text: TextSpan(
                                      style: TextStyle(
                                          color: Colors.black, fontSize: 15),
                                      children: [
                                    TextSpan(
                                        text: (_ill[index][0]['titles0'] + " "),
                                        style: TextStyle(
                                            fontWeight: FontWeight.bold)),
                                    _ill[index][0]['titles1'] != null
                                        ? TextSpan(
                                            text: "(" +
                                                _ill[index][0]['titles1'] +
                                                ") ")
                                        : TextSpan(),
                                    TextSpan(
                                        text: "- " + _ill[index][0]['content'])
                                  ]))
                            ],
                          ));
                    })
                : Container(
                    padding: EdgeInsets.all(10),
                    child: Center(
                      child: Text(
                          "Nie znamy lub nie ma żanych skutków zdrowotnych związanych z tym produktem "),
                    )))
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
