#include <Adafruit_Sensor.h>
#include <DHT.h>  
#include <SoftwareSerial.h>

#define DHTTYPE DHT22

const int DHTPin = 4; 
const String server = "ec2-52-3-232-93.compute-1.amazonaws.com"; // server = "52.3.232.93"; 


SoftwareSerial BT1(3, 2); // RX | TX
DHT dht(DHTPin, DHTTYPE);


void setup() {

  /* 
   *  Init serial and wifi ports
   */
  Serial.begin(9600);
  BT1.begin(19200);

  /*
   * Init DHT sensor Humidity and Temperatures
   */
  dht.begin();

  /*
   * Set time not uset for the moment
   */
  // setTime(12,07,59,25,06,2019);

  /*
   * Wifi client mode
   */
  Serial.println("****** MODO CLIENTE ******"); 
  BT1.println("AT+CWMODE_DEF=1");
  // respuesta();  
  delay(500);


  /**
   * Wifi connect
   */
  Serial.println("****** CONECTAR WIFI ******");
  // BT1.println("AT+CWJAP=\"TECNOLOGIA\",\"tecnologia4321\""); 
  BT1.println("AT+CWJAP=\"dpto_informatica\",\"wHtoxrHM\"");
  // respuesta(); 
  delay(3000);

  /*
   * Wifi check ip
   */
  Serial.println("****** COMPROBAR IP ASIGNADA ******");
  BT1.println("AT+CIFSR");
  // respuesta();
  delay(500);

  /**
   * Wifi disable multiple connections
   */
  Serial.println("****** DESHABILITAMOS LAS CONEXIONES MULTIPLES *******");
  BT1.println("AT+CIPMUX=0");
  // respuesta();
  delay(500);



}

void loop() {
  /*
   * LEER TEMPARATURA 
   */
   float humedad = dht.readHumidity();
   float temperatura = dht.readTemperature();
   Serial.println("Nueva temperatura " + String(temperatura) + "ºC");

       /**
   * Wifi conexión con el servidor
   */
  Serial.println("****** CONEXIÓN TCP CON EL SERVIDOR *******");
  BT1.println("AT+CIPSTART=\"TCP\",\"" + server + "\",80"); 
  // respuesta();
  delay(1000);

  
  /*
   * Componemos mensaje para enviar a server 
   */
  String peticionHTTP = "GET /insert.php?temperature=" + String(temperatura) 
                      + "&humidity=" + String(humedad) + " HTTP/1.1\r\n"
                      + "Host: " + server + "\r\n\r\n";

  
  /**
   * Wifi: Envió tamaño del comando
   */
  BT1.print("AT+CIPSEND=");
  BT1.println(peticionHTTP.length());
  Serial.print("AT+CIPSEND=");
  Serial.println(peticionHTTP.length());

  delay(1000);
  // respuesta();
  /**
   * Si recibimos respuesta positiva
   */
  // if (BT1.find(">"))
  // {
      // Enviamos petición GET http
      BT1.println(peticionHTTP);
      
      Serial.println("PETICION ENVIADA: " + peticionHTTP);

      delay(1000);     
       // Si petición correcta  
      if( BT1.find("SEND OK"))
      {   
          Serial.println("Peticion HTTP enviada");  
      }
      else
      {
          Serial.println("No se ha podido enviar HTTP.....");
      }           
 //   }
   // delay(2000);
}




void respuesta() {
  String respuesta = "";
  boolean ok = 1;
  while (BT1.available() == 0) {
    //nada
  }
  do {
    if (BT1.available() > 0) {
      char caracter_leido = BT1.read();
      respuesta = respuesta + caracter_leido;
      Serial.print(caracter_leido);
      if (respuesta.endsWith("OK")) ok = 0;
    }
  }  while (ok || (BT1.available() == 0));
  Serial.println();
}
