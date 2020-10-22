import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter_spinkit/flutter_spinkit.dart';
import 'package:barcode_food_scaner/apiController.dart';
import 'package:barcode_food_scaner/userLibrary.dart' as user;

class HistoryWidget extends StatefulWidget {
  _HistoryWidgetState createState() => _HistoryWidgetState();
}

class _HistoryWidgetState extends State<HistoryWidget> {
  bool _isLoading = true;
  List _data;
  Widget build(BuildContext context) {
    if (user.userData != null) {
      _getData();
      return Card(
          elevation: 4,
          child: _isLoading
              ? Center(
                  child: SizedBox(
                      height: 45,
                      child: SpinKitWanderingCubes(
                        color: Colors.green[900],
                        size: 25.0,
                      )))
              : Flex(direction: Axis.vertical, children: [
                  SizedBox(
                      height: 225,
                      child: ListView.builder(
                          physics: NeverScrollableScrollPhysics(),
                          itemCount: 4,
                          itemBuilder: (BuildContext ctxt, int index) {
                            return ListTile(
                              title: Text(_data[index]['product']['name']
                                      .toString()
                                      .substring(0, 20) +
                                  (_data[index]['product']['name'].length > 20
                                      ? "..."
                                      : "")),
                              trailing: Text(
                                  _data[index]['created_at'].substring(0, 10)),
                            );
                          })),
                  Divider(
                    height: 1,
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
                          child: Flex(direction: Axis.horizontal, children: [
                            Text("Pokaż więcej"),
                            Icon(Icons.arrow_forward)
                          ])),
                    ),
                    onPressed: () {
                      Navigator.pushNamed(context, '/history');
                    },
                  )
                ]));
    } else {
      return Card(
        elevation: 4,
        child: Center(
          child: FlatButton(
              onPressed: () {
                Navigator.pushNamed(context, "/login");
              },
              child: Text("Zaloguj się, aby wyświetlić historie")),
        ),
      );
    }
  }

  _getData() async {
    if (_isLoading) {
      var response = await Api().getHistory(0, 4);
      setState(() {
        _data = response;
        _isLoading = false;
      });
    }
  }
}
