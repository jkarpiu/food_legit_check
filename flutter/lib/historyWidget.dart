import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter_spinkit/flutter_spinkit.dart';
import 'package:barcode_food_scaner/apiController.dart';
import 'package:barcode_food_scaner/userLibrary.dart' as user;
import 'package:shared_preferences/shared_preferences.dart';

class HistoryWidget extends StatefulWidget {
  _HistoryWidgetState createState() => _HistoryWidgetState();
}

class _HistoryWidgetState extends State<HistoryWidget> {
  bool _isLoading = true;
  List _data;
  bool logged = false;
  Widget build(BuildContext context) {
    if (_isLoading) _getData();
    if (_isLoading) {
      return Card(
        elevation: 4,
        child: Center(
            child: SizedBox(
                height: 45,
                child: SpinKitWanderingCubes(
                  color: Colors.green[900],
                  size: 25.0,
                ))),
      );
    } else {
      return Card(
          elevation: 4,
          child: (logged
              ? Flex(direction: Axis.vertical, children: [
                  SizedBox(
                      height: 225,
                      child: _data.isEmpty
                          ? Center(
                              child: Text(
                                  "Twoja historia jest niestety pusta ://"),
                            )
                          : ListView.builder(
                              physics: NeverScrollableScrollPhysics(),
                              itemCount: _data.length,
                              itemBuilder: (BuildContext ctxt, int index) {
                                return ListTile(
                                  title:
                                      (_data[index]['product']['name'].length >
                                              20
                                          ? Text(_data[index]['product']['name']
                                                  .toString()
                                                  .substring(0, 20) +
                                              "...")
                                          : Text(_data[index]['product']['name']
                                              .toString())),
                                  trailing: Text(_data[index]['created_at']
                                      .substring(0, 10)),
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
                ])
              : Center(
                  child: FlatButton(
                      onPressed: () {
                        Navigator.pushNamed(context, "/login");
                      },
                      child: Text("Zaloguj się, aby wyświetlić historie")),
                )));
    }
  }

  _getData() async {
    await Api().getUser();
    if (user.userData != null) {
      logged = true;
      var response = await Api().getHistory(0, 4);
      setState(() {
        _data = response;
      });
    }
    setState(() {
      _isLoading = false;
    });
  }
}
