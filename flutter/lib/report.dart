import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';
import 'package:barcode_food_scaner/defaultAppBar.dart';
import 'package:flutter/services.dart';
import 'package:flutter_spinkit/flutter_spinkit.dart';
import 'package:barcode_food_scaner/userLibrary.dart' as user;
import 'package:barcode_food_scaner/apiController.dart';
import 'package:flushbar/flushbar.dart';

class ReportPage extends StatefulWidget {
  final String product;
  const ReportPage(this.product);
  @override
  _ReportPageState createState() => _ReportPageState();
}

class _ReportPageState extends State<ReportPage> {
  final GlobalKey<FormState> _formKey = GlobalKey<FormState>();
  bool _isloading = false;
  String _content;
  @override
  Widget build(BuildContext context) {
    if (user.userData != null)
      return Scaffold(
          appBar: flcAppBar("Zgłoś produkt"),
          body: SingleChildScrollView(
            child: Container(
                padding: EdgeInsets.all(10),
                child: Center(
                  child: Card(
                    elevation: 4,
                    child: Container(
                      padding: EdgeInsets.all(10),
                      child: Form(
                          key: _formKey,
                          child: Column(
                            children: [
                              TextFormField(
                                minLines: 10,
                                maxLines: 100,
                                keyboardType: TextInputType.text,
                                textInputAction: TextInputAction.done,
                                decoration: InputDecoration(
                                    hintText: "Co jest nie tak?"),
                                validator: (String value) {
                                  if (value.isEmpty)
                                    return "To pole nie może być puste";
                                },
                                onSaved: (String value) {
                                  _content = value;
                                },
                                onEditingComplete: () {
                                  _sendData();
                                },
                              ),
                              SizedBox(height: 25),
                              Center(
                                child: FlatButton(
                                  child: SizedBox(
                                      width: 100,
                                      child: _isloading
                                          ? SpinKitWanderingCubes(
                                              color: Colors.white,
                                              size: 20,
                                            )
                                          : Center(
                                              child: Text(
                                              "Wyślij",
                                              style: TextStyle(
                                                  color: Colors.white),
                                            ))),
                                  color: Colors.green[800],
                                  onPressed: () {
                                    _sendData();
                                  },
                                ),
                              )
                            ],
                          )),
                    ),
                  ),
                )),
          ));
    else
      return Scaffold(
        appBar: flcAppBar("Zgłoś produkt"),
        body: Center(
          child: FlatButton(
            child: Text("Musisz się zalogować, aby zgłosić produkt"),
            onPressed: () {
              Navigator.pushNamed(context, "/login");
            },
          ),
        ),
      );
  }

  _sendData() async {
    setState(() {
      _isloading = true;
      _formKey.currentState.save();
    });
    var _data = await Api().report(widget.product, _content);
    if (_data == 200) {
      setState(() {
        _isloading = false;
      });
      Navigator.pop(context);
      Flushbar(
        message: "Dziękujemy za zgłoszenie",
        duration: Duration(seconds: 3),
      )..show(context);
    } else {
      setState(() {
        _isloading = false;
      });
      Flushbar(
        message: "Coś poszło nie tak",
        duration: Duration(seconds: 3),
      )..show(context);
    }
  }
}
