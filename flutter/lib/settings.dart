import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';
import 'package:barcode_food_scaner/userLibrary.dart' as user;

class Settings extends StatefulWidget {
  bool isAuth = false;
  @override
  _SettingsState createState() => _SettingsState();
}

class _SettingsState extends State<Settings> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: new AppBar(
        leading: IconButton(
          icon: Icon(Icons.arrow_back),
          onPressed: () {
            Navigator.pop(context, false);
          },
        ),
        title: Text("Ustawienia"),
      ),
      body: ListView(
        padding: EdgeInsets.fromLTRB(10, 10, 10, 0),
        children: <Widget>[
          Card(
              elevation: 2,
              child: FlatButton(
                onPressed: () {
                  if (user.userData != null)
                    Navigator.pushNamed(context, "/settings/profile");
                  else
                    Navigator.pushNamed(context, "/login");
                },
                child: ListTile(
                  leading: Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: <Widget>[Icon(Icons.person)]),
                  title: Text("Konto użytkownika"),
                  subtitle: Text("Zaloguj, aktualizuj dane, wyloguj"),
                ),
              ))
        ],
      ),
    );
  }
}
