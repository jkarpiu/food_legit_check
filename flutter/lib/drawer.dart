import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';
import 'package:barcode_food_scaner/userLibrary.dart' as user;

class AppDrawer extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    var route = ModalRoute.of(context);
    if (route != null) {}

    return Drawer(
        child: Column(children: <Widget>[
      Expanded(
          child: ListView(
        padding: EdgeInsets.zero,
        children: <Widget>[
          DrawerHeader(
            child: Column(
              children: <Widget>[
                Align(
                    alignment: Alignment.centerLeft,
                    child: RichText(
                      text: TextSpan(
                          style: TextStyle(
                              color: Colors.grey[800],
                              fontSize: 27,
                              fontFamily: 'Monospace'),
                          children: [
                            TextSpan(
                                text: "F",
                                style: TextStyle(color: Colors.green[800])),
                            TextSpan(text: "ood \n"),
                            TextSpan(
                                text: "L",
                                style: TextStyle(color: Colors.green[800])),
                            TextSpan(text: "egit \n"),
                            TextSpan(
                                text: "C",
                                style: TextStyle(color: Colors.green[800])),
                            TextSpan(text: "heck"),
                          ]),
                    )),
                Expanded(
                    child: Align(
                        alignment: Alignment.bottomRight,
                        child: Text(user.userData != null
                            ? user.userData['name']
                            : "Zaloguj się, aby w pełni wykorzystywać naszą aplikacje")))
              ],
            ),
            decoration: BoxDecoration(),
          ),
          ListTile(
            title: Text('Posumowanie'),
            leading: Icon(Icons.home_outlined),
            selected: (route.settings.name == "/"),
            onTap: () {
              // setState(() {
              //   // XDDD sory czytający ten kod ale z jakiegoś powodu element o typie widget zawsze zwraca false, pewnie przez jakieś instancje
              //   currentState = Home();
              //   selectedOption = "home";
              // });
              Navigator.pop(context);
              Navigator.pushNamed(context, "/");
            },
          ),
          ListTile(
            title: Text('Statystyki'),
            // selected: (selectedOption == "stats"),
            leading: Icon(Icons.bar_chart),
            onTap: () {
              // setState(() {
              // currentState = Stats();
              // selectedOption = "stats";
              // });
              Navigator.pop(context);
              Navigator.pushNamed(context, "/stats");
            },
          ),
          ListTile(
            title: Text('Historia'),
            leading: Icon(Icons.history),
            onTap: () {
              Navigator.pop(context);
              Navigator.pushNamed(context, "/history");
            },
          ),
          ListTile(
            title: Text('Katalog'),
            leading: Icon(Icons.book),
            onTap: () {
              // Update the state of the app.
              // ...
              Navigator.pop(context);
              Navigator.pushNamed(context, '/catalog');
            },
          ),
          Divider(
            thickness: 1,
            indent: 30,
            endIndent: 30,
          ),
          ListTile(
            title: Text('Dodaj produkt'),
            leading: Icon(Icons.library_add_outlined),
            // selected: (selectedOption == "add"),
            onTap: () {
              // setState(() {
              // currentState = Add();
              // selectedOption = "add";
              // });
              Navigator.pop(context);
              Navigator.pushNamed(context, "/add");
            },
          ),
        ],
      )),
      Align(
          alignment: Alignment.bottomRight,
          child: Row(
            children: <Widget>[
              Expanded(
                  child: Flex(
                      direction: Axis.horizontal,
                      mainAxisAlignment: MainAxisAlignment.end,
                      crossAxisAlignment: CrossAxisAlignment.end,
                      children: <Widget>[
                    IconButton(
                      icon: Icon(Icons.info_outline),
                      onPressed: () {
                        Navigator.pop(context);
                      },
                    ),
                    IconButton(
                      icon: Icon(Icons.settings),
                      onPressed: () {
                        Navigator.pop(context);
                        Navigator.pushNamed(context, "/settings");
                      },
                    ),
                  ]))
            ],
          ))
    ]));
  }
}
