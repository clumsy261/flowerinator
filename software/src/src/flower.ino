///sooo how does an arduino code look like
// ESP32 WiFi Scanning example 

const String api="hashed password";//hashed password
const String user="user";//username

#include "WiFi.h"
#include <string>
#include <HTTPClient.h>
void setup() {
  Serial.begin(115200);
  Serial.println("Initializing WiFi...");
  WiFi.mode(WIFI_STA);
  Serial.println("Setup done!");
  pinMode(34,INPUT);//first humidity sensor -- analogRead
  pinMode(35,INPUT);//second humidity sensor -- analogRead
  pinMode(36,INPUT);//water tank sensor -- digitalRead
  pinMode(39,INPUT);//height sensor
  pinMode(17,OUTPUT);//height motor output
  pinMode(14,OUTPUT);//growing light output
  pinMode(12,OUTPUT);//water pump output
}
#define soil_1 34
#define soil_2 35
#define water 36
#define touch 39
#define motor 17
#define led 14
#define pump 12
int water_ratio;
int led_ratio;

int read_height()
{
	///update the schematic to add an ir distance sensor and implement it here
}
int read_humidity()
  {
    int a=analogRead(soil_1),b=analogRead(soil_2);
    return a+b/2;
  }
bool read_tank()
  {
    return digitalRead(water);
  }
bool plant_touch()
  {
    return digitalRead(touch);
  }
struct settings{ //height + tank -- water + led
	int first;
	int second;
}s;

settings fetch_http(settings s) //send height and tank info in a settings struct and return water and led ratio in the same struct
	{String height=String(s.first, DEC);//height
	String tank=String(s.second, DEC);//tank info
	HTTPClient http;
	String host="flowerinator.free.nf";
	String url="http://"+host+"/?api="+api+"&user="+user+"&wat="+tank+"&height="+height;
	http.begin(url);
	settings s;
	host = http.getString(); //reusing a string to save memory
	int sep = host.indexOf('\n');
	s.first= host.substring(0,sep).toInt();//water ratio
	s.second=host.substring(sep+1).toInt();//led ratio
	return s;
}
void lift_plant()
{
	///while the touch sensor on the ceiling is active use the motor to lift it up and update height
}

void get_plant_data()
{
	s.second = read_tank();
	s.first = read_height();
}

void loop() {
  //the loop should do this:
	//TODO get the humidity and water the plant if necesary - also use water_ratio

	///TODO calculate the growing light time the plants get and turn them on/off

	//TODO find the tank status and height of the plant
	get_plant_data(); //stored in universal struct s
	///TODO connect to wifi
	Serial.println("Scanning..."); 
  int n = WiFi.scanNetworks();
  Serial.println("Scan done!");
  if (n == 0) {
    Serial.println("No networks found.");
  } else {
    Serial.println();
    Serial.print(n);
    Serial.println(" networks found");
    for (int i = 0; i < n; ++i) {
      // Print SSID and RSSI for each network found
      Serial.print(i + 1);
      Serial.print(": ");
      Serial.print(WiFi.SSID(i));
      Serial.print(" (");
      Serial.print(WiFi.RSSI(i));
      Serial.print(")");
      Serial.println((WiFi.encryptionType(i) == WIFI_AUTH_OPEN) ? " " : "*");
      delay(10);
    }
  }
  Serial.println("");
	///TODO send data to web portal and retrieve settings
	s = fetch_http(s);
	///TODO apply settings -done
	water_ratio=s.first;
	led_ratio = s.second;


  // Wait a bit before scanning again
  delay(5000);
}