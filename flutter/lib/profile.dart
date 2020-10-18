import 'package:barcode_food_scaner/apiController.dart';
import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';
import 'package:barcode_food_scaner/userLibrary.dart' as user;

class ProfileSettings extends StatefulWidget {
  @override
  _ProfileSettingsState createState() => _ProfileSettingsState();
}

class _ProfileSettingsState extends State<ProfileSettings> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        leading: IconButton(
            icon: Icon(Icons.arrow_back),
            onPressed: () {
              Navigator.pop(context, false);
            }),
        title: Text("Konto użytkownika"),
      ),
      body: ListView(
        padding: EdgeInsets.fromLTRB(10, 10, 10, 0),
        children: <Widget>[
          ListTile(
            leading: Text("Nazwa: "),
            title: Text(user.userData["name"]),
          ),
          ListTile(
            leading: Text("E-Mail: "),
            title: Text(user.userData["email"]),
          ),
          ListTile(
            leading: Text("Zweryfikowano : "),
            title: Text(user.userData["email_verified_at"] == null
                ? "Nie zweryfikowano"
                : user.userData["email_verified_at"]),
          ),
          Align(
            alignment: Alignment.bottomCenter,
            child: FlatButton(
                color: Colors.green[800],
                onPressed: () async {
                  await Api().logout();
                  Navigator.pop(context);
                },
                child: Text(
                  "Wyloguj się",
                  style: TextStyle(color: Colors.white),
                )),
          )
        ],
      ),
    );
  }
}
