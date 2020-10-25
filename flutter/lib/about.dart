import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';
import 'package:barcode_food_scaner/defaultAppBar.dart';

class AboutPage extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
        appBar: flcAppBar("O aplikacji"),
        body: Align(
            alignment: Alignment.center,
            child: Container(
              padding: EdgeInsets.all(25),
              child: Column(children: [
                RichText(
                  text: TextSpan(
                      style: TextStyle(
                          color: Colors.grey[800],
                          fontSize: 22,
                          fontFamily: 'Monospace'),
                      children: [
                        TextSpan(
                            text: "F",
                            style: TextStyle(color: Colors.green[800])),
                        TextSpan(text: "ood"),
                        TextSpan(
                            text: " L",
                            style: TextStyle(color: Colors.green[800])),
                        TextSpan(text: "egit"),
                        TextSpan(
                            text: " C",
                            style: TextStyle(color: Colors.green[800])),
                        TextSpan(text: "heck"),
                      ]),
                ),
                Text(
                    "Aplikacja mająca na celu uświadamianie o chorobach jakie może powodować nasze pożywienie "),
                Text("Aplikacja powstała na konkurs Hack Heroes 2020"),
                Text("Autorami są Jakub Karp i Kamil Kuźma")
              ]),
            )));
  }
}
