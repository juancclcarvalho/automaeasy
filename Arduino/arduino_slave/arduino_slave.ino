//Inclui biblioteca xbee-arduino
#include <XBee.h>
#include <IRremote.h>
#include <SoftwareSerial.h>
//Cria um objeto Xbee
XBee xbee = XBee();
XBeeResponse response = XBeeResponse();

ZBRxResponse rx = ZBRxResponse();
ModemStatusResponse msr = ModemStatusResponse();

IRsend irsend;

char *data, dataArray[20];
String received, io, state, comand;

void setup() {
  //Porta de recepção de dados
  Serial.begin(9600);
  //Serial3.begin(9600);
  //Atribui porta serial ao objeto xbee
  xbee.begin(Serial);
  for (int i = 0; i < 14; i++) {
    pinMode(i, OUTPUT);
  }
}
// Lê continuamente pacotes, buscando por ZB Receive ou Modem Status
void loop() {

  xbee.readPacket();

  if (xbee.getResponse().isAvailable()) {
    //Recebeu algo
    if (xbee.getResponse().getApiId() == ZB_RX_RESPONSE) {
      // Recebeu um pacote zb rx
      //Preenche a classe zb rx
      xbee.getResponse().getZBRxResponse(rx);

      for (int i = 0; i < rx.getDataLength(); i++) {
        //Concatena os dados recebidos em uma string
        received.concat(char(rx.getData(i)));
        Serial.println(received);
      }
    
      //////////Quebra String//////////

      //Quebra a string serial em um array de caracteres
      received.toCharArray(dataArray, 20);
      

      if (received.indexOf(",") > 0) {
        data = strtok(dataArray, ",");
        /*for (int i = 1; i < 3; i++) {
          data = strtok(NULL, ",");
          if (i == 1) {
          state = data;
          } else if (i == 2) {
          io = data;

          }
          }
          }*/

        state = data;

        data = strtok(NULL, ",");
        io = data;
        data = "";


        Serial.print("Pino: ");
        Serial.println(io);
        Serial.print("Estado: " );
        Serial.println(state);

        //Seta pinos digitais
        digitalWrite(io.toInt(), state.toInt());

      } else {
        //Serial.println(dataArray);
        unsigned long receivedLong = strtoul(dataArray, NULL, 10);
        irsend.sendNEC(receivedLong, 32);
        delay(5000);
        receivedLong = "";
      }
      received = "";
    
    }
  }
}

