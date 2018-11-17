// Bibliotecas
#include <IRremote.h>
#include <XBee.h>
#include<SoftwareSerial.h>


const byte rxPin = 7;// Pino Rx do Explorer
const byte txPin = 8;// Pino Tx do Explorer
SoftwareSerial mySerial =  SoftwareSerial(rxPin, txPin);// Instancia nova porta serial


//Cria um objeto Xbee
XBee xbee = XBee();

ZBRxResponse rx = ZBRxResponse();
ModemStatusResponse msr = ModemStatusResponse();

// Dados de envio
char *data, dataArray[100];
char sh[10], sl[10], payload[10];
String shString, slString, payloadString, firstDigit;

// Configura o Infravermelho
int RECV_PIN = 11;
IRrecv irrecv(RECV_PIN);
decode_results results;
IRsend irsend;

void setup() {
  //Porta de recepção de dados
  Serial.begin(9600);
  //Porta de transmissão de dados
  mySerial.begin(9600);
  //Atribui porta serial 3 ao objeto xbee
  xbee.setSerial(mySerial);

  irrecv.enableIRIn();

}
void loop() {
  Serial.flush();
  //Aguarda data na serial 1
  if (Serial.available() > 0) {
    //Concatena todos os caracteres recebidos na serial em uma string
    String received = readSerialString();

    //Quebra a String
    //Converte a string em um array de caracteres
    received.toCharArray(dataArray, 100);
    //Esvazia a string
    received = "";

    data = strtok(dataArray, ".");
    firstDigit = data;
    if (firstDigit == "1") { // Ligar/Desligar equipamentos
      //Separa os dados a partir da separação anterior, tendo por base o caractere "."
      for (int i = 1; i < 4; i++) {
        data = strtok(NULL, ".");
        if (i == 1) {
          shString = data;
        } else if (i == 2) {
          //Parte inferior do endereço (SL)
          slString = data;
        } else if (i == 3) {
          //Dados a serem enviados
          payloadString = data;
        }
      }
      data = "";

      //Conversão Hexadecimal
      //Converte a string da parte superior do endereço em um array de caracteres
      shString.toCharArray(sh, 10);
      //Converte a parte superior do endereço em hexadecimal
      uint32_t shAdr = strtoul(sh, NULL, 16);

      //Converte a string da parte superior do endereço em um array de caracteres
      slString.toCharArray(sl, 10);
      //Converte a parte inferior do endereço em hexadecimal
      uint32_t slAdr = strtoul(sl, NULL, 16);

      //Converte a string dos dados em um array de caracteres
      payloadString.toCharArray(payload, 10);
      Serial.print("Porta: ");
      Serial.print(payload[2]);
      Serial.println(payload[3]);
      Serial.print("Estado: ");
      Serial.println(payload[0]);

      //Definição de Parâmetros de envio
      //Endereço do xbee destino
      XBeeAddress64 addr64 = XBeeAddress64(shAdr, slAdr);
      //Protocolo de envio (endereço e dados)
      ZBTxRequest zbTx = ZBTxRequest(addr64, payload, sizeof(payload));
      //Status do envio
      ZBTxStatusResponse txStatus = ZBTxStatusResponse();

      //Envia os dados
      xbee.send(zbTx);

      //Retorno da Transmissão
      if (xbee.readPacket(500)) {
        // Obteve resposta
        if (xbee.getResponse().getApiId() == ZB_TX_STATUS_RESPONSE) {
          xbee.getResponse().getZBTxStatusResponse(txStatus);

          if (txStatus.getDeliveryStatus() == SUCCESS) {
            // Transmissão bem sucedida
            Serial.println("Transmissão bem sucedida!");
            digitalWrite(success, 1);
          } else {
            // Transmissão sem resposta! Verificar alimentação do dispositivo remoto
            Serial.println("Transmissão sem resposta! Verificar alimentação do dispositivo remoto");
            digitalWrite(warning, 1);
          }
        }
      } else if (xbee.getResponse().isError()) {
      } else {
        // Transmissão não realizada! Falha no dispositivo local
        Serial.println("Transmissão não realizada! Falha no dispositivo local");
        digitalWrite(error, 1);
      }

    } else if (firstDigit == "2") {// Controle remoto
      int rxInit = millis();
      while ((millis() - rxInit) < 5000);
      if (irrecv.decode(&results)) {
        Serial.println(results.value);
        irrecv.resume();
        Serial.flush();
      }
    }
  }
}
String readSerialString() {
  String content = "";
  char character;
  // Enquanto receber algo pela serial
  while (Serial.available() > 0) {
    // Lê byte da serial
    character = Serial.read();
    // Ignora caractere de quebra de linha
    if (character != '\n') {
      // Concatena valores
      content.concat(character);
    }
    // Aguarda buffer serial ler próximo caractere
    delay(10);
  }
  return content;
}
