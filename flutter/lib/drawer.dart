import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';

class AppDrawer extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    var route = ModalRoute.of(context);
    if (route != null) {
      print(route.settings.name);
    }

    return Drawer(
        child: Column(children: <Widget>[
      Expanded(
          child: ListView(
        padding: EdgeInsets.zero,
        children: <Widget>[
          DrawerHeader(
            child: Column(
              children: <Widget>[
                Expanded(
                  child: Align(
                      alignment: Alignment.bottomRight,
                      child: Text('Jan Kowalski')),
                )
              ],
            ),
            decoration: BoxDecoration(
              color: Colors.green,
            ),
          ),
          ListTile(
            title: Text('Posumowanie'),
            leading: Icon(Icons.home_outlined),
            // selected: (selectedOption == "home"),
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
              // Update the state of the app.
              // ...
              Navigator.pop(context);
            },
          ),
          ListTile(
            title: Text('Katalog'),
            leading: Icon(Icons.book),
            onTap: () {
              // Update the state of the app.
              // ...
              Navigator.pop(context);
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