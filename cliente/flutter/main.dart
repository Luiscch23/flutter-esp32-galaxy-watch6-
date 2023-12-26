import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;

void main() {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      home: MyHomePage(),
    );
  }
}

class MyHomePage extends StatefulWidget {
  @override
  _MyHomePageState createState() => _MyHomePageState();
}

class _MyHomePageState extends State<MyHomePage> {
  TextEditingController parametro1Controller = TextEditingController();
  TextEditingController parametro2Controller = TextEditingController();

  bool switchValue = false;
   bool switchValue1 = false;

  Future<void> enviarDatos() async {
    final url = 'https://www..com.mx/vocho.php'; // Reemplaza con la URL correcta

    final response = await http.post(
      Uri.parse(url),
      body: {
        'parametro1': switchValue1 ? 'on' : 'off', 
        'parametro2': switchValue ? 'on' : 'off', // Usa el valor del switch
      },
    );

    if (response.statusCode == 200) {
      // Maneja la respuesta exitosa aquí
      final Map<String, dynamic> data = json.decode(response.body);
      print(data);
    } else {
      // Maneja errores aquí
      print('Error en la solicitud: ${response.reasonPhrase}');
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
     
      body: Center(
        child: Container(
          child: Padding(
            padding: const EdgeInsets.all(16.0),
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
             
                SizedBox(height: 20),
            
                   
                    Switch(
                      value: switchValue,
                      onChanged: (value) {
                        setState(() {
                          switchValue = value;
                          enviarDatos();
                        });
                      },
                    ),
                  
              
                SizedBox(height: 20),
           
                SizedBox(height: 20),
              Switch(
                      value: switchValue1,
                      onChanged: (value) {
                        setState(() {
                          switchValue1 = value;
                          enviarDatos();
                        });
                      },
                    ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}