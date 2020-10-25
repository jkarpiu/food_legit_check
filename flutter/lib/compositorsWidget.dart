import "package:flutter/cupertino.dart";
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';

class Compositors extends StatefulWidget {
  final Composition = new List();
  bool execute = true;
  @override
  _CompositorsState createState() => _CompositorsState();
}

class _CompositorsState extends State<Compositors> {
  @override
  Widget build(BuildContext context) {
    addCompositor(false);
    return Column(children: [
      ListView.builder(
        physics: NeverScrollableScrollPhysics(),
        shrinkWrap: true,
        itemCount: widget.Composition.length,
        itemBuilder: (BuildContext ctxt, int index) {
          widget.Composition[index]["id"] = index;
          var units = new UnitsDropdown();
          return Card(
              elevation: 4,
              child: Container(
                padding: EdgeInsets.fromLTRB(10, 5, 10, 10),
                child: Column(
                  children: [
                    Flex(
                        direction: Axis.horizontal,
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: [
                          Text(
                            "Składnik: ",
                            style: TextStyle(
                                color: Colors.green[800],
                                fontFamily: "Monospace"),
                          ),
                          IconButton(
                            icon: Icon(Icons.cancel),
                            iconSize: 16,
                            color: Colors.red[900],
                            onPressed: () {
                              print("remove" + index.toString());
                              setState(() {
                                widget.Composition.removeAt(index);
                              });
                            },
                            constraints: BoxConstraints(maxHeight: 16),
                          )
                        ]),
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
                            if (value.isEmpty)
                              return "To pole nie może być puste";
                          },
                          onSaved: (String value) {
                            widget.Composition[index]["amount"] = value;
                            widget.Composition[index]["amountUnit"] =
                                units.dropdownValue;
                          },
                          keyboardType: TextInputType.number,
                          textInputAction:
                              index == widget.Composition.length - 1
                                  ? TextInputAction.done
                                  : TextInputAction.next,
                        ),
                        trailing: units)
                  ],
                ),
              ));
        },
      ),
      RaisedButton.icon(
          color: Colors.white,
          icon: Icon(Icons.add),
          label: Text("Dodaj składnik"),
          onPressed: () {
            addCompositor(true);
          })
    ]);
  }

  addCompositor(execution) {
    if (widget.execute || execution) {
      print("tst");
      setState(() {
        widget.Composition.add(new _CompositionElement().element);
      });
      widget.execute = false;
    }
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
