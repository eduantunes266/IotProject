#include <WiFi101.h>          // Biblioteca WiFi para MKR1000
#include <DHT.h>              // Biblioteca DHT
#include <ArduinoHttpClient.h>

// ==============================
// Configurações WiFi e API
// ==============================
char SSID[]     = "labs";
char PASSWORD[] = "1nv3nt@r2023_IPLEIRIA";
char HOST[]     = "iot.dei.estg.ipleiria.pt";
int  PORTO      = 80;

WiFiClient wifi;
HttpClient clienteHTTP(wifi, HOST, PORTO);

// ==============================
// Definição de pinos
// ==============================
#define DHTPIN           0    // Pino conectado ao DHT11
#define DHTTYPE       DHT11
#define LED_DIA_NOITE    6    // LED indicador Dia/Noite
#define LED_BANDEIRA     7    // **LED indicador de bandeira vermelha**

DHT dht(DHTPIN, DHTTYPE);

void setup() {
  Serial.begin(9600);
  dht.begin();
  pinMode(LED_DIA_NOITE, OUTPUT);
  pinMode(LED_BANDEIRA, OUTPUT);   // **Configura pino da bandeira**

  // Conecta ao WiFi
  Serial.print("Ligando ao WiFi");
  WiFi.begin(SSID, PASSWORD);
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    delay(500);
  }
  Serial.println("\nConectado ao WiFi!");
}

void loop() {
  // --- 1) Leitura do DHT11 ---
  float temperatura = dht.readTemperature();
  float humidade    = dht.readHumidity();
  float ventoFinal  = humidade / 3.0;

  if (isnan(temperatura) || isnan(humidade)) {
    Serial.println("Erro ao ler do DHT11");
    delay(2000);
    return;
  }

  Serial.print("Temperatura: ");
  Serial.print(temperatura, 1);
  Serial.print(" °C, Humidade: ");
  Serial.print(humidade, 1);
  Serial.println(" %");

  // --- 2) Envio de Dados via POST ---
  String dados = "";
  dados += "valor_Tempagua=" + String(temperatura, 1);
  dados += "&data_Tempagua=2025-06-14%2012:00:00";
  dados += "&nome_Tempagua=Tempagua";
  dados += "&valor_Vento="    + String(ventoFinal, 1);
  dados += "&data_Vento=2025-06-14%2012:00:00";
  dados += "&nome_Vento=Vento";

  clienteHTTP.post(
    "https://iot.dei.estg.ipleiria.pt/ti/ti169/PROJETO%20PRAIA%20INTELIGENTE/PROJETO/api.php",
    "application/x-www-form-urlencoded",
    dados
  );
  Serial.print("POST → ");
  Serial.println(clienteHTTP.responseStatusCode());
  Serial.println(clienteHTTP.responseBody());

  // --- 3) GET Dia/Noite ---
  clienteHTTP.get(
    "https://iot.dei.estg.ipleiria.pt/ti/ti169/PROJETO%20PRAIA%20INTELIGENTE/PROJETO/api.php?nome=Dia_Noite"
  );
  String respDN = clienteHTTP.responseBody();
  Serial.print("GET Dia/Noite → ");
  Serial.println(respDN);

  // --- 4) Controle do LED Dia/Noite ---
  if (respDN.indexOf(": Noite") >= 0) {
    digitalWrite(LED_DIA_NOITE, HIGH);
    Serial.println("LED Dia/Noite → ACESO");
  } else {
    digitalWrite(LED_DIA_NOITE, LOW);
    Serial.println("LED Dia/Noite → APAGADO");
  }

  // --- 5) GET Bandeira ---
  clienteHTTP.get(
    "https://iot.dei.estg.ipleiria.pt/ti/ti169/PROJETO%20PRAIA%20INTELIGENTE/PROJETO/api.php?nome=Bandeira"
  );
  String respBandeira = clienteHTTP.responseBody();
  Serial.print("GET Bandeira → ");
  Serial.println(respBandeira);

  // --- 6) Controle do LED da Bandeira ---
  // Supondo resposta algo como "Valor da bandeira: Vermelha"
  if (respBandeira.indexOf("Vermelha") >= 0) {
    digitalWrite(LED_BANDEIRA, HIGH);
    Serial.println("LED Bandeira → ACESO (Vermelha)");
  } else {
    digitalWrite(LED_BANDEIRA, LOW);
    Serial.println("LED Bandeira → APAGADO");
  }

  // --- 7) Aguarda antes de reiniciar o loop ---
  delay(10000);
}
