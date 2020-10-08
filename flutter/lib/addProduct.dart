import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter_barcode_scanner/flutter_barcode_scanner.dart';
import 'package:barcode_food_scaner/compositorsWidget.dart';

class Add extends StatefulWidget {
  @override
  _AddState createState() => _AddState();
}

class _AddState extends State<Add> {
  Map product = {
    "brand": "",
    "image": "",
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

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        body: Form(
            key: _formKey,
            child: Column(
              children: [
                Expanded(
                    child: ListView(children: [
                  Card(
                    child: Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        buildBrand(),
                        buildName(),
                        buildPrice(),
                        buildBarcode(),
                        Compositors(),
                        SizedBox(
                          height: 100,
                        ),
                      ],
                    ),
                  )
                ])),
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
            )));
  }
}
