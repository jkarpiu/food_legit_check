import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter_spinkit/flutter_spinkit.dart';
import 'package:barcode_food_scaner/apiController.dart';
import 'package:google_sign_in/google_sign_in.dart';
import 'package:flutter_signin_button/flutter_signin_button.dart';
import 'package:shared_preferences/shared_preferences.dart';

class RegisterPage extends StatefulWidget {
  @override
  _RegisterPageState createState() => _RegisterPageState();
}

class _RegisterPageState extends State<RegisterPage> {
  final GlobalKey<FormState> _formKey = GlobalKey<FormState>();
  final GlobalKey<ScaffoldState> _scaffoldKey = new GlobalKey<ScaffoldState>();
  bool isLoading = false;
  Map loginData = {
    "name": "",
    'email': "",
    'password': "",
    "password_confirmation": ""
  };
  @override
  Widget build(BuildContext context) {
    return Scaffold(
        appBar: AppBar(
          backgroundColor: Colors.white,
          elevation: 0,
          leading: IconButton(
              icon: Icon(
                Icons.arrow_back,
                color: Colors.green[800],
              ),
              onPressed: () {
                Navigator.pop(context);
              }),
        ),
        key: _scaffoldKey,
        backgroundColor: Colors.white,
        body: SingleChildScrollView(
            child: Align(
          alignment: Alignment.center,
          child: Form(
              key: _formKey,
              child: Container(
                  margin: EdgeInsets.fromLTRB(0, 10, 0, 0),
                  child: Column(
                    children: <Widget>[
                      SizedBox(
                        width: 256,
                        child: Image.asset("splash.png"),
                      ),
                      Padding(
                        padding: EdgeInsets.fromLTRB(50, 100, 25, 20),
                        child: Column(
                          children: <Widget>[
                            TextFormField(
                              decoration: InputDecoration(
                                  hintText: "Nazwa",
                                  prefixIcon: Icon(Icons.person)),
                              validator: (String value) {
                                if (value.isEmpty)
                                  return "To pole nie może być puste";
                              },
                              onSaved: (String value) {
                                loginData['name'] = value;
                              },
                              keyboardType: TextInputType.text,
                              textInputAction: TextInputAction.next,
                            ),
                            TextFormField(
                              decoration: InputDecoration(
                                  hintText: "E-Mail",
                                  prefixIcon: Icon(Icons.email)),
                              validator: (String value) {
                                if (value.isEmpty)
                                  return "To pole nie może być puste";
                                if (!RegExp(
                                        r"^[a-zA-Z0-9.a-zA-Z0-9.!#$%&'*+-/=?^_`{|}~]+@[a-zA-Z0-9]+\.[a-zA-Z]+")
                                    .hasMatch(value))
                                  return "Podaj poprawny adres E-Mail";
                              },
                              onSaved: (String value) {
                                loginData['email'] = value;
                              },
                              keyboardType: TextInputType.emailAddress,
                              textInputAction: TextInputAction.next,
                            ),
                            TextFormField(
                              decoration: InputDecoration(
                                  hintText: "Hasełko",
                                  prefixIcon: Icon(Icons.lock)),
                              obscureText: true,
                              validator: (String value) {
                                if (value.isEmpty)
                                  return "To pole nie może być puste";
                                if (value.length < 8)
                                  return "Hasło musi mieć minimum 8 znaków";
                              },
                              onSaved: (String value) {
                                loginData['password'] = value;
                              },
                              textInputAction: TextInputAction.next,
                            ),
                            TextFormField(
                              decoration: InputDecoration(
                                  hintText: "Potwierdź Hasełko",
                                  prefixIcon: Icon(Icons.lock)),
                              obscureText: true,
                              validator: (String value) {
                                if (value.isEmpty)
                                  return "To pole nie może być puste";
                                if (value.length < 8)
                                  return "Hasło musi mieć minimum 8 znaków";
                              },
                              onSaved: (String value) {
                                loginData['password_confirmation'] = value;
                              },
                              textInputAction: TextInputAction.done,
                              onEditingComplete: () async {
                                await sendData();
                              },
                            ),
                          ],
                        ),
                      ),
                      RaisedButton(
                          color: Colors.green[800],
                          onPressed: () async {
                            await sendData();
                          },
                          child: SizedBox(
                              width: 200,
                              height: 50,
                              child: isLoading
                                  ? SpinKitWanderingCubes(
                                      color: Colors.white, size: 20.0)
                                  : Align(
                                      alignment: Alignment.center,
                                      child: Text("Zarejestruj się",
                                          style: TextStyle(
                                              color: Colors.white,
                                              fontSize: 16)),
                                    ))),
                      SizedBox(
                        height: 10,
                      ),
                    ],
                  ))),
        )));
  }

  sendData() async {
    if (isLoading == false) {
      if (!_formKey.currentState.validate()) {
        return;
      }
      _formKey.currentState.save();
      setState(() {
        isLoading = true;
      });
      var apilocal = new Api();
      var token = await apilocal.register(loginData);
      setState(() {
        isLoading = false;
      });
      if (token['statusCode'] == 200) {
        Navigator.pushNamed(context, '/login');
      } else {
        final snackBar = SnackBar(
            content: ListTile(
          leading: Text(token['statusCode'].toString()),
          title: Text(token['body']['message'].toString()),
          trailing: FlatButton(
              onPressed: () {
                _scaffoldKey.currentState.hideCurrentSnackBar();
              },
              child: Text("Zamknij")),
        ));
        _scaffoldKey.currentState.showSnackBar(snackBar);
        // _showMyDialog(token['statusCode'], token['body']);
      }
    }
  }
}
