import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';

class Add extends StatefulWidget {
  @override
  _AddState createState() => _AddState();
}

class _AddState extends State<Add> {
  Map product = {
    "brand": "",
    "producent": "",
    "price": 0,
    "barcode": 0,
    "composition": []
  };
  final GlobalKey<FormState> _formKey = GlobalKey<FormState>();

  Widget buildBrand() {
    return ListTile(
      title: TextFormField(
        validator: (String value) {
          if (value.isEmpty) return "To pole nie może być puste";
        },
        onSaved: (String value) {
          product["brand"] = value;
        },
      ),
    );
  }

  Widget buildProducer() {
    return null;
  }

  Widget buildPrice() {
    return null;
  }

  Widget buildBarcode() {
    return null;
  }

  Widget buildCompositor() {
    return null;
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
