import "package:flutter/cupertino.dart";
import 'package:flutter/material.dart';

class Compositors extends StatefulWidget {
  final _Composition = new List();
  @override
  _CompositorsState createState() => _CompositorsState();
}

class _CompositorsState extends State<Compositors> {
  Map _compositionElement = {
    "id": 0,
    "name": "",
    "diffrentName": "",
    "amount": 0
  };
  @override
  Widget build(BuildContext context) {
    widget._Composition.add(_compositionElement);
    return Column(children: [
      ListView.builder(
        physics: NeverScrollableScrollPhysics(),
        shrinkWrap: true,
        itemCount: widget._Composition.length,
        itemBuilder: (BuildContext ctxt, int index) {
          return ListTile(
            title: Column(
              children: [
                TextFormField(
                  decoration: InputDecoration(hintText: "Nazwa składnika"),
                  validator: (String value) {
                    if (value.isEmpty) return "To pole nie może być puste";
                  },
                  onSaved: (String value) {
                    widget._Composition[index]["name"] = value;
                  },
                  textInputAction: TextInputAction.next,
                )
              ],
            ),
          );
        },
      ),
      RaisedButton(
          child: Text("Czy karp jest idiotą? "),
          onPressed: () {
            setState(() {});
          })
    ]);
  }
}
