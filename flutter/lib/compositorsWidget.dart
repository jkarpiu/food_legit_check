import "package:flutter/cupertino.dart";
import 'package:flutter/material.dart';

class Compositors extends StatefulWidget {
  final Composition = new List();
  @override
  _CompositorsState createState() => _CompositorsState();
}

class _CompositorsState extends State<Compositors> {
  @override
  Widget build(BuildContext context) {
    widget.Composition.add(new _CompositionElement().element);
    return Column(children: [
      ListView.builder(
        physics: NeverScrollableScrollPhysics(),
        shrinkWrap: true,
        itemCount: widget.Composition.length,
        itemBuilder: (BuildContext ctxt, int index) {
          print(index);
          widget.Composition[index]["id"] = index;
          var units = new UnitsDropdown();
          return ListTile(
            title: Column(
              children: [
                TextFormField(
                  decoration: InputDecoration(hintText: "Nazwa składnika"),
                  validator: (String value) {
                    if (value.isEmpty) return "To pole nie może być puste";
                  },
                  onSaved: (String value) {
                    widget.Composition[index]["name"] = value;
                  },
                  textInputAction: TextInputAction.next,
                ),
                ListTile(
                    title: TextFormField(
                      decoration:
                          InputDecoration(hintText: "Ilość (jeśli znasz)"),
                      validator: (String value) {
                        if (value.isEmpty) return "To pole nie może być puste";
                      },
                      onSaved: (String value) {
                        widget.Composition[index]["amount"] = value;
                        widget.Composition[index]["amountUnit"] =
                            units.dropdownValue;
                      },
                      keyboardType: TextInputType.number,
                      textInputAction: TextInputAction.next,
                    ),
                    trailing: units)
              ],
            ),
          );
        },
      ),
      RaisedButton(
          child: Text("Czy karp jest idiotą? "),
          onPressed: () {
            print(widget.Composition);
            setState(() {});
          })
    ]);
  }
}

class UnitsDropdown extends StatefulWidget {
  UnitsDropdown({Key key}) : super(key: key);
  String dropdownValue = 'g';
  @override
  _UnitsDropdownState createState() => _UnitsDropdownState();
}

class _UnitsDropdownState extends State<UnitsDropdown> {
  @override
  Widget build(BuildContext context) {
    return DropdownButton<String>(
      value: widget.dropdownValue,
      icon: Icon(Icons.arrow_downward),
      iconSize: 24,
      elevation: 16,
      underline: Container(
        height: 2,
      ),
      onChanged: (String newValue) {
        setState(() {
          widget.dropdownValue = newValue;
        });
      },
      items: <String>['g', 'ml', '%']
          .map<DropdownMenuItem<String>>((String value) {
        return DropdownMenuItem<String>(
          value: value,
          child: Text(value),
        );
      }).toList(),
    );
  }
}

class _CompositionElement {
  Map element = {
    "id": 0,
    "name": "",
    "diffrentName": "",
    "amount": 0,
    "amountUnit": "g"
  };
}
