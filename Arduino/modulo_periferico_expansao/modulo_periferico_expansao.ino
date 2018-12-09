// Bibliotecas
#include <XBee.h>
#include <IRremote.h>
#include <SoftwareSerial.h>

// Pinos 74HC595
#define DS 10
#define SHCP 8
#define STCP 9
// Array 74HC595
boolean registers[8] = { 0, 0, 0, 0, 0, 0, 0, 0 };

//Cria um objeto Xbee
XBee xbee = XBee();
XBeeResponse response = XBeeResponse();

const byte rxPin = 0;// Pino Rx do Explorer
const byte txPin = 1;// Pino Tx do Explorer
SoftwareSerial mySerial =  SoftwareSerial(rxPin, txPin);// Instancia nova porta serial


ZBRxResponse rx = ZBRxResponse();
ModemStatusResponse msr = ModemStatusResponse();

// Sensor IR
IRsend irsend;

// Dados de envio
char *data, dataArray[30];
String received, io, state, comand;

void setup() {
  //Porta de recepção de dados
  mySerial.begin(9600);
  pinMode(DS, OUTPUT);
  pinMode(SHCP, OUTPUT);
  pinMode(STCP, OUTPUT);
  //Atribui porta serial ao objeto xbee
  xbee.setSerial(mySerial);
  for (int i = 2; i < 14; i++) {
    pinMode(i, OUTPUT);
  }
  setup74HC595();
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
        //Serial.println(received);
      }

      //Quebra a String
      //Converte a string serial em um array de caracteres
      received.toCharArray(dataArray, 30);


      if (received.indexOf(",") > 0) { // Ligar/Desligar equipamento
        //Separa os dados a partir da separação anterior, tendo por base o caractere ","
        data = strtok(dataArray, ",");
        state = data;
        data = strtok(NULL, ",");
        io = data;
        data = "";

        //Seta pinos digitais
        if (io.toInt() > 13) {
          registers[io.toInt() - 13] = state.toInt();
          setup74HC595();
        } else {
          digitalWrite(io.toInt(), state.toInt());
        }

      } else {
        // Devido a problemas com o reload da pagina, foi necessario agrupar todas as teclas numericas em um unico pacote de dados
        // Este bloco conta a quantidade de teclas numericas pressionadas
        if (received.indexOf("-") > 0) {
          int count = 0;
          for (int i = 0; dataArray[i] != '\0'; i++) {
            if (dataArray[i] == '-') {
              count++;
            }
          }
          // Envia os códigos referentes a tecla numerica pressionada
          for (int i = 0; i < count; i++) {
            if (i == 0) { // Primeira tecla numerica
              data = strtok(dataArray, "-");
              unsigned long receivedLong = strtoul(data, NULL, 10);
              Serial.println(receivedLong);
              irsend.sendNEC(receivedLong, 32);
              delay(10);
            } else { //Demais teclas
              data = strtok(NULL, "-");
              unsigned long receivedLong = strtoul(data, NULL, 10);
              Serial.println(receivedLong);
              irsend.sendNEC(receivedLong, 32);
              delay(10);
            }
          }
        } else { // Caso seja pressionada uma tecla de função ao inves de uma numerica
          unsigned long receivedLong = strtoul(dataArray, NULL, 10);
          Serial.println(receivedLong);
          irsend.sendNEC(receivedLong, 32);
          delay(10);
        }
      }
      received = "";

    }
  }
}

void setup74HC595() {
  digitalWrite(STCP, LOW);
  for (int i = 8; i > 0; i--)
  {
    digitalWrite(SHCP, LOW);
    digitalWrite(DS, registers[i]);
    digitalWrite(SHCP, HIGH);
  }
  digitalWrite(STCP, HIGH);
}
