#include <WiFi.h>
#include <HTTPClient.h>

const char* ssid = "Nothing Happened";
const char* password = "Semicolon123*";
const char* serverUrl = "http://192.168.1.14/LEDtest/get_led_state.php"; // Update with your actual URL

#define LED1 4  // Define individual LED pins
#define LED2 12
#define LED3 13

void setup() {
    Serial.begin(115200);
    
    WiFi.begin(ssid, password);
    Serial.print("Connecting to WiFi");
    while (WiFi.status() != WL_CONNECTED) {
        delay(500);
        Serial.print(".");
    }
    Serial.println("\nConnected to WiFi!");
    Serial.print("ESP32 IP Address: ");
    Serial.println(WiFi.localIP());


    // Set each LED pin as output and turn them off initially
    pinMode(LED1, OUTPUT);
    pinMode(LED2, OUTPUT);
    pinMode(LED3, OUTPUT);
    
    digitalWrite(LED1, LOW);
    digitalWrite(LED2, LOW);
    digitalWrite(LED3, LOW);
}

void loop() {
    if (WiFi.status() == WL_CONNECTED) {
        HTTPClient http;
        http.begin(serverUrl);
        int httpResponseCode = http.GET();

        if (httpResponseCode == 200) {
            String payload = http.getString();
            Serial.println("Received data: " + payload);

            int led1, led2, led3;
            sscanf(payload.c_str(), "%d,%d,%d", &led1, &led2, &led3);

            digitalWrite(LED1, led1);
            digitalWrite(LED2, led2);
            digitalWrite(LED3, led3);
        } else {
            Serial.print("Error in HTTP request: ");
            Serial.println(httpResponseCode);
            Serial.println(http.errorToString(httpResponseCode).c_str()); // Print detailed error

        }

        http.end();
    } else {
        Serial.println("WiFi disconnected!");
    }

    delay(1000); // Check every 5 seconds
}
