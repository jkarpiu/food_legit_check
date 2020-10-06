import 'package:barcode_food_scaner/home.dart';
import 'package:barcode_food_scaner/stats.dart';
import 'package:barcode_food_scaner/addProduct.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

void main() => runApp(MaterialApp(
      home: FLC(),
      theme: ThemeData(primaryColor: Colors.green),
    ));

class FLC extends StatefulWidget {
  @override
  _FLCState createState() => _FLCState();
}

class _FLCState extends State<FLC> {
  Widget currentState = Home();
  String selectedOption = "home";
  @override
  Widget build(BuildContext context) {
    return Scaffold(
        appBar: new AppBar(
          title: Text("Food Legit Check"),
        ),
        drawer: Drawer(
          child: Column(children: <Widget>[
            Expanded(
                child: ListView(
              padding: EdgeInsets.zero,
              children: <Widget>[
                DrawerHeader(
                  child: Column(
                    children: <Widget>[
                      Expanded(
                        child: Align(
                            alignment: Alignment.bottomRight,
                            child: Text('Jan Kowalski')),
                      )
                    ],
                  ),
                  decoration: BoxDecoration(
                    color: Colors.green,
                  ),
                ),
                ListTile(
                  title: Text('Posumowanie'),
                  leading: Icon(Icons.home_outlined),
                  selected: (selectedOption == "home"),
                  onTap: () {
                    setState(() {
                      // XDDD sory czytający ten kod ale z jakiegoś powodu element o typie widget zawsze zwraca false, pewnie przez jakieś instancje
                      currentState = Home();
                      selectedOption = "home";
                    });
                    Navigator.pop(context);
                  },
                ),
                ListTile(
                  title: Text('Statystyki'),
                  selected: (selectedOption == "stats"),
                  leading: Icon(Icons.bar_chart),
                  onTap: () {
                    setState(() {
                      currentState = Stats();
                      selectedOption = "stats";
                    });
                    Navigator.pop(context);
                  },
                ),
                ListTile(
                  title: Text('Historia'),
                  leading: Icon(Icons.history),
                  onTap: () {
                    // Update the state of the app.
                    // ...
                    Navigator.pop(context);
                  },
                ),
                ListTile(
                  title: Text('Katalog'),
                  leading: Icon(Icons.book),
                  onTap: () {
                    // Update the state of the app.
                    // ...
                    Navigator.pop(context);
                  },
                ),
                Divider(
                  thickness: 1,
                  indent: 30,
                  endIndent: 30,
                ),
                ListTile(
                  title: Text('Dodaj produkt'),
                  leading: Icon(Icons.library_add_outlined),
                  selected: (selectedOption == "add"),
                  onTap: () {
                    setState(() {
                      currentState = Add();
                      selectedOption = "add";
                    });
                    Navigator.pop(context);
                  },
                ),
              ],
            )),
            Align(
                alignment: Alignment.bottomRight,
                child: Row(
                  children: <Widget>[
                    Expanded(
                        child: Flex(
                            direction: Axis.horizontal,
                            mainAxisAlignment: MainAxisAlignment.end,
                            crossAxisAlignment: CrossAxisAlignment.end,
                            children: <Widget>[
                          IconButton(
                            icon: Icon(Icons.info_outline),
                            onPressed: () {
                              Navigator.pop(context);
                            },
                          ),
                          IconButton(
                            icon: Icon(Icons.settings),
                            onPressed: () {
                              Navigator.pop(context);
                            },
                          ),
                          IconButton(
                            icon: Icon(Icons.logout),
                            onPressed: () {
                              Navigator.pop(context);
                            },
                          )
                        ]))
                  ],
                ))
          ]),
        ),
        body: currentState);
  }
}
