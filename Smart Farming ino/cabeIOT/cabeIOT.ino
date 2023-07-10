#include <ArduinoJson.h> 
#include <HTTPClient.h>
#include <WiFi.h>
#include <OneWire.h>
#include <DallasTemperature.h>

//Wifi Parameter
  const char* SSID = "Playstation 5 ";    //Nama WiFi
  const char* PASS = "janganshare";    //Password WiFi

//Variabel Pin Relay
  #define R1 12
  #define R2 13
  #define sensSuhu 32
  #define sensHum 33
  #define LED 2

  //Ultrasnik
  #define soundSpeed 0.034
  const int trigPin = 22;
  const int echoPin = 21;

//Jarak
  long duration;
  float jarakCm;
  float tinggian;
  float tinggiEm=50;    //Tinggi Ember/ Jarak Sensor Ultrasonik dgn dasar ember

int intMonitor = 30000;
long prevMilMon;
long currMilMon; 

//Config Sensor Suhu
  OneWire oneWire(sensSuhu);
  DallasTemperature sensorSuhu(&oneWire);
  float suhuOut;

float lembab;

void setup() {
  Serial.begin(115200);

  pinMode(trigPin,OUTPUT);
  pinMode(echoPin,INPUT);
  
  pinMode(R1,OUTPUT);
  pinMode(R2,OUTPUT);
  pinMode(LED,OUTPUT);

  Serial.println();
  Serial.print("Koneksi ke: ");Serial.println(SSID);
  WiFi.begin(SSID,PASS);
  while(WiFi.status() != WL_CONNECTED){
    delay(1000);
    Serial.print(".");
    digitalWrite(LED,LOW);
  }
  Serial.println("===WIFI TERKONEKSI===");
  Serial.print("IP: ");Serial.println(WiFi.localIP());
  sensorSuhu.begin();
  digitalWrite(R1,HIGH);  //LOW
  digitalWrite(R2,HIGH);  //LOW
  digitalWrite(LED,HIGH);
  delay(2000);
}

void loop() {
  currMilMon = millis();
  getKelembaban();
  getSuhu();
  getJarak();
  getKontrol();
  
  if(currMilMon - prevMilMon > intMonitor){
    Serial.println();
    sendData();
    prevMilMon = currMilMon;
  }
  Serial.println("===============");
  delay(1000);
}

void getSuhu(){
  sensorSuhu.requestTemperatures();
  suhuOut = sensorSuhu.getTempCByIndex(0);
  Serial.print("Suhu        : ");Serial.println(suhuOut);
}

void getKelembaban(){
  lembab = analogRead(sensHum);
  lembab = map(lembab,0,4095,100,0);
  Serial.print("Kelembaban  : ");Serial.println(lembab);
}

void getJarak(){
  digitalWrite(trigPin,LOW);
  delayMicroseconds(2);
  digitalWrite(trigPin,HIGH);
  delayMicroseconds(10);
  digitalWrite(trigPin,LOW);
  duration = pulseIn(echoPin,HIGH);
  jarakCm = duration * soundSpeed/2;
  Serial.print("Jarak       : ");Serial.println(jarakCm);
  tinggian = tinggiEm - jarakCm;
  Serial.print("Ketinggian  : ");Serial.println(tinggian);
}

void getKontrol(){
  if(WiFi.status() == WL_CONNECTED){
    HTTPClient http;
    http.begin("http://farming-fahri.000webhostapp.com/getLed.php");
    int httpcode = http.GET();

    if(httpcode > 0){
      const size_t capacity = JSON_ARRAY_SIZE(2) + JSON_OBJECT_SIZE(4) + 20;
      DynamicJsonDocument doc(capacity);

      String json = http.getString();
      deserializeJson(doc, json);

      const char* id1 = doc[0]["id"];
      const char* nilai1 = doc[0]["nilai"];
      const char* id2 = doc[1]["id"];
      const char* nilai2 = doc[1]["nilai"];

      //Print Serial
      Serial.print("ID1      : ");Serial.println(id1);
      Serial.print("Kondisi1 : ");Serial.println(nilai1);
      Serial.print("ID2      : ");Serial.println(id2);
      Serial.print("Kondisi2 : ");Serial.println(nilai2);

      if(doc[0]["nilai"] == "1"){
        digitalWrite(R1,HIGH);
      }
      else {
        digitalWrite(R1,LOW);
      }
      if(doc[1]["nilai"] == "1"){
        digitalWrite(R2,HIGH);
      }
      else{
        digitalWrite(R2,LOW);
      }
    }
  }
}

void sendData(){
   if(WiFi.status() == WL_CONNECTED){
    WiFiClient client;
    HTTPClient http;

    String httpReqData = "suhu=" + String(suhuOut) + "&kelembaban=" + String(lembab) + "&tinggian=" + String(tinggian);

    http.begin("http://farming-fahri.000webhostapp.com/insertDB.php");

    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    Serial.print("HTTP REQ Data: "); Serial.println(httpReqData);

    int httpResponCode = http.POST(httpReqData);
    String payload = http.getString();

    if(httpResponCode > 0){
      Serial.print("HTTP Response Code: ");Serial.println(httpResponCode);
      Serial.print("Payload           : ");Serial.println(payload);
      Serial.println("DATA TERKIRIM");
      digitalWrite(LED,LOW);
      delay(1000);
      digitalWrite(LED,HIGH);
    }
    else{
      Serial.print("ERROR CODE  :");Serial.println(httpResponCode);
      Serial.print("Payload     : ");Serial.println(payload);
      Serial.println("GAGAL TERKIRIM");
      digitalWrite(LED,LOW);
      delay(300);
      digitalWrite(LED,HIGH);
      delay(300);
      digitalWrite(LED,LOW);
      delay(300);
      digitalWrite(LED,HIGH);
    }

    http.end();
   }
}
