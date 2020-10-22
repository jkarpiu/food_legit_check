import 'package:barcode_food_scaner/product.dart';
import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter_barcode_scanner/flutter_barcode_scanner.dart';
import 'package:barcode_food_scaner/statsHomeWidget.dart';
import 'package:barcode_food_scaner/drawer.dart';
import 'package:barcode_food_scaner/apiController.dart';
import 'package:barcode_food_scaner/userLibrary.dart' as user;
import 'package:shared_preferences/shared_preferences.dart';
import 'package:barcode_food_scaner/searchScreen.dart';
import 'historyWidget.dart';

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
          title: Align(
              alignment: Alignment.center,
              child: RichText(
                text: TextSpan(
                    style: TextStyle(
                        color: Colors.grey[800],
                        fontSize: 22,
                        fontFamily: 'Monospace'),
                    children: [
                      TextSpan(
                          text: "F",
                          style: TextStyle(color: Colors.green[800])),
                      TextSpan(text: "ood"),
                      TextSpan(
                          text: " L",
                          style: TextStyle(color: Colors.green[800])),
                      TextSpan(text: "egit"),
                      TextSpan(
                          text: " C",
                          style: TextStyle(color: Colors.green[800])),
                      TextSpan(text: "heck"),
                    ]),
              )),
          backgroundColor: Colors.white,
          iconTheme: IconThemeData(color: Colors.green[800]),
          actions: <Widget>[
            SizedBox(
              width: 48,
            )
          ],
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
                        FlatButton(
                            padding: EdgeInsets.zero,
                            onPressed: () {
                              Navigator.push(
                                  context,
                                  MaterialPageRoute(
                                      builder: (context) => SearchScreen()));
                            },
                            child: ListTile(
                              leading: Icon(Icons.search),
                              title: Text("Wyszukaj produkt"),
                            )),
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
                          onPressed: () =>
                              {Navigator.pushNamed(context, "/stats")},
                        )
                      ])),
                  HistoryWidget(),
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
    if (_data != "-1") {
      Navigator.push(context,
          MaterialPageRoute(builder: (context) => Product(_data, false)));
    }
  }
}
