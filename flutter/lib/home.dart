import 'package:barcode_food_scaner/product.dart';
import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter_barcode_scanner/flutter_barcode_scanner.dart';
import 'package:barcode_food_scaner/statsHomeWidget.dart';
import 'package:barcode_food_scaner/drawer.dart';
import 'package:barcode_food_scaner/apiController.dart';
import 'package:barcode_food_scaner/userLibrary.dart' as user;
import 'package:shared_preferences/shared_preferences.dart';

class Home extends StatefulWidget {
  @override
  _HomeState createState() => _HomeState();
}

class _HomeState extends State<Home> {
  String _data = "";
  userdata() async {
    SharedPreferences localStorage = await SharedPreferences.getInstance();
    if (!await Api().getUser() &&
        localStorage.getBool("disableLogOnStartup") == null)
      Navigator.pushNamedAndRemoveUntil(context, "/login", (r) => false);
  }

  final searchFieldController = TextEditingController();
  @override
  Widget build(BuildContext context) {
    userdata();
    return Scaffold(
        appBar: new AppBar(
          title: Text(
            "Food Legit Check",
          ),
        ),
        drawer: AppDrawer(),
        body: ListView(
          children: [
            Container(
                padding: EdgeInsets.fromLTRB(10, 10, 10, 0),
                width: double.maxFinite,
                child: Column(children: <Widget>[
                  Card(
                    elevation: 4,
                    child: Flex(
                      direction: Axis.vertical,
                      crossAxisAlignment: CrossAxisAlignment.baseline,
                      mainAxisAlignment: MainAxisAlignment.spaceAround,
                      children: [
                        Form(
                          child: ListTile(
                              leading: Icon(Icons.search),
                              title: TextFormField(
                                controller: searchFieldController,
                                keyboardType: TextInputType.text,
                                decoration: InputDecoration(
                                    border: InputBorder.none,
                                    hintText: "Wyszukaj produkt..."),
                              )),
                        ),
                        Divider(
                          thickness: 1,
                          indent: 30,
                          endIndent: 30,
                          height: 1,
                        ),
                        FlatButton(
                            padding: EdgeInsets.zero,
                            onPressed: () async => _scan(),
                            child: ListTile(
                              leading: Icon(Icons.qr_code),
                              title: Text("Zeskanuj kod kreskowy"),
                            )),
                      ],
                    ),
                  ),
                  Card(
                      elevation: 4,
                      child: Flex(direction: Axis.vertical, children: [
                        ListTile(
                            title: SizedBox(
                                height: 250,
                                child: (SimpleBarChart.withSampleData()))),
                        Divider(
                          height: 3,
                          thickness: 1,
                          indent: 30,
                          endIndent: 30,
                        ),
                        FlatButton(
                          padding: EdgeInsets.zero,
                          child: ListTile(
                            contentPadding: EdgeInsets.zero,
                            trailing: SizedBox(
                                width: 125,
                                child: Flex(
                                    direction: Axis.horizontal,
                                    children: [
                                      Text("Pokaż więcej"),
                                      Icon(Icons.arrow_forward)
                                    ])),
                          ),
                          onPressed: () => {print("test")},
                        )
                      ])),
                  Card(
                      elevation: 4,
                      child: Flex(direction: Axis.vertical, children: [
                        SizedBox(
                            height: 225,
                            child: ListView.builder(
                                physics: NeverScrollableScrollPhysics(),
                                itemCount: 4,
                                itemBuilder: (BuildContext ctxt, int index) {
                                  return ListTile(
                                    title: Text(
                                        "produkt " + (index + 1).toString()),
                                    trailing: Text("2012-21-12"),
                                  );
                                })),
                        Divider(
                          height: 1,
                          thickness: 1,
                          indent: 30,
                          endIndent: 30,
                        ),
                        FlatButton(
                          padding: EdgeInsets.zero,
                          child: ListTile(
                            contentPadding: EdgeInsets.zero,
                            trailing: SizedBox(
                                width: 125,
                                child: Flex(
                                    direction: Axis.horizontal,
                                    children: [
                                      Text("Pokaż więcej"),
                                      Icon(Icons.arrow_forward)
                                    ])),
                          ),
                          onPressed: () => {print("test")},
                        )
                      ])),
                  Card(
                    elevation: 4,
                    child: ListTile(
                        title: Text(
                            "na podstawie twoich ostatnich zdrowe jedzeinie")),
                  )
                ])),
            Text(_data)
          ],
        ));
  }

  _scan() async {
    await FlutterBarcodeScanner.scanBarcode(
            "#4caf50", "Anuluj", true, ScanMode.BARCODE)
        .then((value) => setState(() => {_data = value}));
    var product = await Api().getProduct(_data);
    Navigator.push(
        context, MaterialPageRoute(builder: (context) => Product(product[0])));
  }
}
