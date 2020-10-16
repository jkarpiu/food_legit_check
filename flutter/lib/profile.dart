import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter_spinkit/flutter_spinkit.dart';

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
LoginPage()
        ],
      ),
    );
  }
}


class LoginPage extends StatefulWidget {
  @override
  _LoginPageState createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  final GlobalKey<FormState> _formKey = GlobalKey<FormState>();
  bool isLoading = false;
  @override
  Widget build (BuildContext context){
    return Align(
      alignment: Alignment.center,
      child: Form(
          key: _formKey,
          child: Column(
        children: <Widget>[
          TextFormField(
            decoration: InputDecoration(hintText: "E-Mail"),
            validator: (String value) {
              if (value.isEmpty) return "To pole nie może być puste";
            },
            onSaved: (String value) {

            } ,
            textInputAction: TextInputAction.next,
          ),
          TextFormField(
            decoration: InputDecoration(hintText: "Hasełko"),
            obscureText: true,
            validator: (String value) {
              if (value.isEmpty) return "To pole nie może być puste";
            },
            onSaved: (String value) {

            } ,
            textInputAction: TextInputAction.next,
          ),
          RaisedButton(onPressed: () {
            setState(() {
              isLoading = true;
            });
          }, child: isLoading ? SpinKitFoldingCube(color: Colors.green[800], size: 50.0) : Text("Zaloguj się"))
        ],
      )),
    );
  }
}
