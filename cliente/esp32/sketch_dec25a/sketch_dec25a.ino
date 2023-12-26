#include <WiFi.h>
#include <HTTPClient.h>

const char *ssid = "INFINITUM53EM_2.4";
const char *password = "t49UXsH9Gc";
const char *serverUrl = "https://www.tudservidos.com.mx/estados.php"; // Reemplaza con la URL correcta

const int ledPin1 = 5; // Puedes cambiar este número según el pin GPIO que estés utilizando para el LED 1
const int ledPin2 = 18; // Puedes cambiar este número según el pin GPIO que estés utilizando para el LED 2

void setup() {
  Serial.begin(115200);

  pinMode(ledPin1, OUTPUT);
  pinMode(ledPin2, OUTPUT);

  // Conéctate a la red WiFi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(10000);
    Serial.println("Conectando a WiFi...");
  }
  Serial.println("Conectado a WiFi");
}

void loop() {
  // Realiza la consulta GET cada 300 ms
  realizarConsulta();
  delay(300);
}

void realizarConsulta() {
  HTTPClient http;

  // Realiza la solicitud GET al servidor
  http.begin(serverUrl);
  int httpCode = http.GET();

  if (httpCode > 0) {
    if (httpCode == HTTP_CODE_OK) {
      String payload = http.getString();
      Serial.println("Respuesta del servidor:");
      Serial.println(payload);

      // Procesa la respuesta JSON
      // Asume que la respuesta es un JSON con campos "parametro1_estado" y "parametro2_estado"
      // Si el estado es "on", enciende el LED; si es "off", apaga el LED

      if (payload.indexOf("parametro1_estado\":\"on") != -1) {
        digitalWrite(ledPin1, HIGH); // Enciende el LED 1
      } else {
        digitalWrite(ledPin1, LOW); // Apaga el LED 1
      }

      if (payload.indexOf("parametro2_estado\":\"on") != -1) {
        digitalWrite(ledPin2, HIGH); // Enciende el LED 2
      } else {
        digitalWrite(ledPin2, LOW); // Apaga el LED 2
      }

    } else {
      Serial.printf("Error en la solicitud HTTP: %d\n", httpCode);
    }
  } else {
    Serial.println("Error en la conexión al servidor");
  }

  http.end();
}
