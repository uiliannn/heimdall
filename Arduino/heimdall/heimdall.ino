//Shield Ethernet
#include <Ethernet.h>
#include <SPI.h>
//sensores Wiegand
#include <Wiegand.h>
#include "configuracao.h"
#define FALSE 0
#define TRUE  1
WIEGAND wg;

//definicoes ethernet
byte mac[] = {
  0x00, 0xAA, 0xBB, 0xCC, 0xDE, 0x02
};

byte ip[] = { 10, 10, 10, 125 };

EthernetClient client;






void setup()
{

  Serial.begin(9600);
  //GATE A
  wg.D0PinA = 2;
  wg.D1PinA = 3;
  //GATE B
  wg.D0PinB = 18;
  wg.D1PinB = 19;
  //GATE C
  wg.D0PinC = 20;
  wg.D1PinC = 21;

  pinMode(sala1, OUTPUT);
  pinMode(sala2, OUTPUT);
  pinMode(sala3, OUTPUT);


  wg.begin(TRUE, TRUE, TRUE);

  delay(500); // Delay que permite depois de iniciar ainda para iniciar o Monitor de série


  if (Ethernet.begin(mac) == 0) {
    Serial.println("Conexão via DHCP não pôde ser estabelecida. 'endereço IP fixo");
    Ethernet.begin(mac, ip); // Se nenhum DHCP encontrado, utilizar o 192.168.1.177 IP estático
  }
  delay(500); //Aguarde um momento para importar configuração Ethernet Shield


  Serial.println("fim do setup");




}

void loop()
{


  leitura();

  alterPorts();



}


void alterPorts()
{
  //porta 1
  if (resposta_1 == 1) {
    digitalWrite(sala1, HIGH);
    estado_rele_1 = 0;
    //Serial.println("rele aberto");

  }
  else if (resposta_1 == 0) {
    digitalWrite(sala1, LOW);
    estado_rele_1 = 1;
    //Serial.println("rele fechado ");

  }

    //porta 2
  if (resposta_2 == 1) {
    digitalWrite(sala2, HIGH);
    estado_rele_2 = 0;
    //Serial.println("rele aberto");

  }
  else if (resposta_2 == 0) {
    digitalWrite(sala2, LOW);
    estado_rele_2 = 1;
    //Serial.println("rele fechado ");

  }
    //porta 3
  if (resposta_3 == 1) {
    digitalWrite(sala3, HIGH);
    estado_rele_3 = 0;
    //Serial.println("rele aberto");

  }
  else if (resposta_3 == 0) {
    digitalWrite(sala3, LOW);
    estado_rele_3 = 1;
    //Serial.println("rele fechado ");

  }


}

void leitura() {

  if (wg.available())
  {
    token = String(wg.getCode(), HEX);
    Serial.print("Gate = ");
    Serial.println(wg.getGateActive());
    Serial.print("Token = ");
    Serial.println(wg.getCode(), HEX);

    int porta = wg.getGateActive()  ;


    if (porta == 1 && client.connect(server, httpPort))
    {


      String url =  api ;
      url += "porta1.php?token=";
      url +=  token, HEX;
      url += "&sala=";
      url += "sala-101b";
      url += "&controladora=";
      url += nome;
      url += "&status1=";
      url += estado_rele_1;




      Serial.println("  ");
      Serial.println("estado do rele:  ");
      Serial.println(estado_rele_1);
      Serial.println("  ");
      Serial.println("Conectado ao servidor.");
      Serial.println(server + url);
      Serial.println("  ");


      client.println("POST " + url + " HTTP/1.1");
      client.println("Host: 10.10.10.108");
      client.println("Content-Type: application/x-www-form-urlencoded");
      client.println("Connection: close");
      client.print("Content-Length: ");
      client.println(url.length());
      client.println();
      client.println(url);
      client.println();


      if (client.find("<porta_1>")) {
        resposta_1 = client.parseInt();

      }

      Serial.print("Fechando conexão... ");
      client.stop();



      porta = 0;

    }


    if (porta == 2 && client.connect(server, httpPort))
    {


      String url =  api ;
      url += "porta2.php?token=";
      url +=  token, HEX;
      url += "&sala=";
      url += "sala-102b";
      url += "&controladora=";
      url += nome;
      url += "&status2=";
      url += estado_rele_2;




      Serial.println("  ");
      Serial.println("estado do rele:  ");
      Serial.println(estado_rele_2);
      Serial.println("  ");
      Serial.println("Conectado ao servidor.");
      Serial.println(server + url);
      Serial.println("  ");


      client.println("POST " + url + " HTTP/1.1");
      client.println("Host: 10.10.10.108");
      client.println("Content-Type: application/x-www-form-urlencoded");
      client.println("Connection: close");
      client.print("Content-Length: ");
      client.println(url.length());
      client.println();
      client.println(url);
      client.println();


      if (client.find("<porta_2>")) {
        resposta_2 = client.parseInt();

      }

      Serial.print("Fechando conexão... ");
      client.stop();



      porta = 0;

    }

    if (porta == 3 && client.connect(server, httpPort))
    {


      String url =  api ;
      url += "porta3.php?token=";
      url +=  token, HEX;
      url += "&sala=";
      url += "sala-103b";
      url += "&controladora=";
      url += nome;
      url += "&status3=";
      url += estado_rele_3;




      Serial.println("  ");
      Serial.println("estado do rele:  ");
      Serial.println(estado_rele_3);
      Serial.println("  ");
      Serial.println("Conectado ao servidor.");
      Serial.println(server + url);
      Serial.println("  ");


      client.println("POST " + url + " HTTP/1.1");
      client.println("Host: 10.10.10.108");
      client.println("Content-Type: application/x-www-form-urlencoded");
      client.println("Connection: close");
      client.print("Content-Length: ");
      client.println(url.length());
      client.println();
      client.println(url);
      client.println();


      if (client.find("<porta_3>")) {
        resposta_3 = client.parseInt();

      }

      Serial.print("Fechando conexão... ");
      client.stop();



      porta = 0;

    }



  }

}







