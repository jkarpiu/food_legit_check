import 'package:barcode_food_scaner/drawer.dart';
import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/services.dart';
import 'package:flutter_barcode_scanner/flutter_barcode_scanner.dart';
import 'package:barcode_food_scaner/compositorsWidget.dart';
import 'package:barcode_food_scaner/defaultAppBar.dart';
import 'package:flutter_spinkit/flutter_spinkit.dart';
import 'package:image_picker/image_picker.dart';
import 'dart:io';
import 'dart:convert' as convert;
import 'package:barcode_food_scaner/userLibrary.dart' as user;
import 'package:barcode_food_scaner/apiController.dart';
import 'package:flushbar/flushbar.dart';

class Add extends StatefulWidget {
  @override
  _AddState createState() => _AddState();
}

class _AddState extends State<Add> {
  Map product = {
    "brand": "",
    "name": "",
    "price": 0,
    "image": null,
    'imageExt': 'png',
    "barcode": 0,
    "category": "Dania i konserwy",
    "components": [],
  };

  File image;

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
            textInputAction: TextInputAction.next,
            validator: (String value) {
              if (value.isEmpty) return "To pole nie może być puste";
            },
            onSaved: (String value) {
              product["barcode"] = value;
            }));
  }

  Widget buildCategories() {
    return ListTile(
        title: DropdownButton<String>(
      isExpanded: true,
      value: product['category'],
      icon: Icon(Icons.arrow_downward),
      iconSize: 24,
      elevation: 16,
      underline: Container(
        padding: EdgeInsets.fromLTRB(0, 10, 0, 0),
        color: Colors.grey,
        height: 1,
      ),
      onChanged: (String newValue) {
        setState(() {
          product['category'] = newValue;
        });
      },
      items: <String>[
        'Alkohol',
        'Dania i konserwy',
        'Desery i wypieki',
        'Gotowe obiady',
        'Inne',
        'Mrożonki',
        'Napoje',
        'Owoce i warzywa',
        'Pieczywo',
        'Produkty świeże',
        'Produkty sypkie i makaron',
        'Przekąski',
        'Przetwory',
        'Przyprawy',
        'Płatki śniadaniowe',
        'Sosy, oleje, ocet',
        'Słodycze',
        'Wędliny',
        'Zdrowa żywność',
        'Żywność dla dzieci',
      ].map<DropdownMenuItem<String>>((String value) {
        return DropdownMenuItem<String>(
          value: value,
          child: Text(value),
        );
      }).toList(),
    ));
  }

  bool _isloading = false;

  void _choose(bool camera) async {
    var picker = new ImagePicker();
    var imageFile;
    if (camera)
      imageFile = await picker.getImage(source: ImageSource.camera);
    else
      imageFile = await picker.getImage(source: ImageSource.gallery);
    setState(() {
      image = File(imageFile.path);
    });
// file = await ImagePicker.pickImage(source: ImageSource.gallery);
  }

  @override
  Widget build(BuildContext context) {
    var localCompositors = new Compositors();
    if (user.userData != null)
      return Scaffold(
          drawer: AppDrawer(),
          appBar: flcAppBar("Dodaj produkt"),
          body: Form(
              key: _formKey,
              child: Container(
                  padding: EdgeInsets.all(15),
                  child: Column(
                    children: [
                      Expanded(
                          child: ListView(children: [
                        Card(
                            elevation: 4,
                            child: Column(
                              mainAxisAlignment: MainAxisAlignment.center,
                              children: [
                                buildBrand(),
                                buildName(),
                                buildPrice(),
                                buildBarcode(),
                                buildCategories(),
                                Row(
                                  mainAxisAlignment: MainAxisAlignment.center,
                                  children: <Widget>[
                                    Card(
                                      elevation: 2,
                                      child: Flex(
                                        direction: Axis.horizontal,
                                        children: [
                                          FlatButton.icon(
                                            onPressed: () {
                                              _choose(false);
                                            },
                                            icon: Icon(Icons.insert_drive_file),
                                            label: Text('Wybierz fotke'),
                                          ),
                                          Container(
                                            decoration: BoxDecoration(
                                                border: Border(
                                                    left: BorderSide(
                                                        color: Colors.grey,
                                                        width: 1))),
                                            child: SizedBox(
                                              height: 20,
                                            ),
                                          ),
                                          FlatButton.icon(
                                              onPressed: () {
                                                _choose(true);
                                              },
                                              icon: Icon(Icons.camera),
                                              label: Text("Zrób fotke"))
                                        ],
                                      ),
                                    ),
                                    SizedBox(width: 10.0),
                                  ],
                                ),
                                image == null ? Text('') : Image.file(image),
                                SizedBox(
                                  height: 10,
                                )
                              ],
                            )),
                        localCompositors,
                      ])),
                      RaisedButton.icon(
                        color: Colors.green[800],
                        onPressed: () async {
                          setState(() {
                            _isloading = true;
                          });
                          if (!_formKey.currentState.validate()) {
                            setState(() {
                              _isloading = false;
                            });
                            return;
                          }
                          if (image == null) {
                            setState(() {
                              _isloading = false;
                            });
                            Flushbar(
                              duration: Duration(seconds: 3),
                              message: "Musisz dodać zdjęcie!",
                            )..show(context);
                            return;
                          }

                          _formKey.currentState.save();
                          product["components"] =
                              convert.jsonEncode(localCompositors.Composition);

                          product['imageExt'] = image.path.split(".").last;

                          product['image'] =
                              convert.base64Encode(image.readAsBytesSync());

                          var _data = await Api().addProduct(product);
                          if (_data != 200) {
                            setState(() {
                              _isloading = false;
                            });

                            Flushbar(
                                message: "Ups, coś poszło nie tak",
                                duration: Duration(seconds: 3))
                              ..show(context);
                          } else {
                            Navigator.pushNamed(context, "/");
                            setState(() {
                              _isloading = false;
                            });
                          }
                        },
                        icon: Icon(
                          Icons.send,
                          color: Colors.white,
                        ),
                        label: _isloading
                            ? SpinKitWanderingCubes(
                                color: Colors.white, size: 15)
                            : Text(
                                "Wyślij do zatwierdzenia",
                                style: TextStyle(color: Colors.white),
                              ),
                      )
                    ],
                  ))));
    else {
      return Scaffold(
          appBar: flcAppBar("Dodaj produkt"),
          drawer: AppDrawer(),
          body: Center(
            child: FlatButton(
                onPressed: () {
                  Navigator.pushNamed(context, "/login");
                },
                child: Text("Zaloguj się, aby dodać produkt")),
          ));
    }
  }
}
