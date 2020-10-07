import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter_barcode_scanner/flutter_barcode_scanner.dart';

class Add extends StatefulWidget {
  @override
  _AddState createState() => _AddState();
}

class _AddState extends State<Add> {
  Map _compositionElement = {
    "id": 0,
    "name": "",
    "diffrentName": "",
    "amount": 0
  };

  Map product = {
    "brand": "",
    "name": "",
    "price": 0,
    "barcode": 0,
    "composition": []
  };

  int _compositorCounter = 1;

  final GlobalKey<FormState> _formKey = GlobalKey<FormState>();
  final _barcodeController = TextEditingController();

  Widget buildBrand() {
    return ListTile(
        title: TextFormField(
      decoration: InputDecoration(hintText: "Marka"),
      validator: (String value) {
        if (value.isEmpty) return "To pole nie może być puste";
      },
      onSaved: (String value) {
        product["brand"] = value;
      },
      textInputAction: TextInputAction.next,
    ));
  }

  Widget buildName() {
    return ListTile(
        title: TextFormField(
      decoration: InputDecoration(hintText: "Nazwa"),
      validator: (String value) {
        if (value.isEmpty) return "To pole nie może być puste";
      },
      onSaved: (String value) {
        product["name"] = value;
      },
      textInputAction: TextInputAction.next,
    ));
  }

  Widget buildPrice() {
    return ListTile(
        title: TextFormField(
            decoration: InputDecoration(hintText: "Orientacyjna cena"),
            keyboardType: TextInputType.number,
            validator: (String value) {
              if (value.isEmpty) return "To pole nie może być puste";
            },
            onSaved: (String value) {
              product["price"] = value;
            }));
  }

  Widget buildBarcode() {
    return ListTile(
        title: TextFormField(
            controller: _barcodeController,
            decoration: InputDecoration(
                hintText: "Kod kreskowy",
                suffixIcon: IconButton(
                  icon: Icon(Icons.scanner),
                  onPressed: () async {
                    await FlutterBarcodeScanner.scanBarcode(
                            "#4caf50", "Anuluj", true, ScanMode.BARCODE)
                        .then((value) => _barcodeController.text = value);
                  },
                )),
            keyboardType: TextInputType.number,
            validator: (String value) {
              if (value.isEmpty) return "To pole nie może być puste";
            },
            onSaved: (String value) {
              product["barcode"] = value;
            }));
  }

  Widget buildComposition() {
    return Column(children: [
      ListView.builder(
        physics: NeverScrollableScrollPhysics(),
        shrinkWrap: true,
        itemCount: _compositorCounter,
        itemBuilder: (BuildContext ctxt, int index) {
          product["composition"].addAll(_compositionElement);
          return ListTile(
            title: Column(
              children: [
                TextFormField(
                  decoration: InputDecoration(hintText: "Nazwa składnika"),
                  validator: (String value) {
                    if (value.isEmpty) return "To pole nie może być puste";
                  },
                  onSaved: (String value) {
                    product["composition"][index]["name"] = value;
                  },
                  textInputAction: TextInputAction.next,
                )
              ],
            ),
          );
        },
      )
    ]);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: ListView(
        children: [
          Card(
              child: Form(
            key: _formKey,
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                buildBrand(),
                buildBrand(),
                buildName(),
                buildPrice(),
                buildBarcode(),
                buildComposition(),
                SizedBox(
                  height: 100,
                ),
                RaisedButton(
                  onPressed: () {
                    if (!_formKey.currentState.validate()) {
                      return;
                    }
                    _formKey.currentState.save();
                    print(product);
                  },
                  child: Text("Wyślij do zatwierdzenia"),
                )
              ],
            ),
          ))
        ],
      ),
    );
  }
}
