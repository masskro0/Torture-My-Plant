#define F_CPU 16000000UL

#include <Servo.h>
//#define DEBUGSERVO
#include <SPI.h>
#include <Ethernet.h>
//#define DEBUGSTEP
//#define DEBUGGAME
//#define SERIALENABLE
//#define DEBUGSELECT
#define SOCKETPORT 23
#define STEPPEROFFSET 3
#define STEPPERSPEED 35 //optimal for 5V usage


//------------------structs and variables----------------------
//stepper struct for variables
struct stepperMot{
  int pinA0;//4 pins of the motor, only works with AnalogIn-Pins
  int pinA1;
  int pinA2;
  int pinA3;
  
  int stepperstate; //1 to 4, determins pin-output
  int is_working; //
  unsigned long old_steppertime; //important for delay time
  volatile int current_pos; // 
  int plant_pos[4]; //positions of fout plants, plant_pos[0] represents Plant 1
  int is_calibrated; // important at startup
};
//initialize struct for turntable
//public, because used in interrupt
volatile struct stepperMot stepper1;

//struct for servo motor variables
struct servoMot{
  int current_pos; //current position
  int target_pos; //target position to push the plant
  int idle_pos; //satrting and idle position
  int state; //state, determins whether to move backward or forward
  Servo connected_servo; //connected servo
};
Servo servo_fetcher;
Servo servo_returner;
//initialize 2 structs for both arms
struct servoMot fetcher_struct;
struct servoMot returner_struct;

struct gameStruct{
  int plant_to_be_fetched; //triggers servo
  int torture_table; //is a plant on torture table?
};
struct gameStruct game;


//mac adress of ethernet shield
byte mac[] = {
  0x90, 0xA2, 0xDA, 0x00, 0x7B, 0x60 };
//ip adress, first 3 numbers of gateway, the last one random
//Lab
IPAddress ip(10, 90, 1, 170);
IPAddress myDns(192, 168, 1, 1);
//copy from ipconfig
IPAddress gateway(10, 90, 1, 251);
IPAddress subnet(255, 255, 255, 0);

//Ethernet Server
EthernetServer server(SOCKETPORT);

//simplified variables
boolean alreadyConnected = false;
//-----------------------------------------------------



//variables for user input
int selected_plant = 0;
//positions of plants, 1 to 4
const int plant_pos[4] = {120+STEPPEROFFSET, 170+STEPPEROFFSET, 20+STEPPEROFFSET, 70+STEPPEROFFSET};


//-----------------prototype functions----------------------
//stepper prototype functions
//turn motor with (struct motor, int position, int delaytime)
int stepperSteps(struct stepperMot, int, int);
//move to zero position
void calibrate(struct stepperMot);
//setup variables for turntable
void initialize_stepper();

//servo prototype functions
//move selected servo to target and idlepos
void move_servo(struct servoMot);
//move plant to torture table
int fetch_plant();
//move plant to turntable
int return_plant();
//setup variables for both arms
void initialize_servos();
//move to idlepos
void move_servos_to_idle(struct servoMot, struct servoMot);

//game prototype functions
void initialize_game();

//ethernet prototype functions
//setup variables and IPs
void initialize_ethernet();
//read and write as socket server
void read_from_client();
void write_to_all_clients(char);
//select plant, start stepper
void select_plant(int);
//---------------------------------------------------------


//########################################################
//########################################################
void setup() {
  //setup serial, test variables
  #ifdef SERIALENABLE
  Serial.begin(9600);
  #endif
  initialize_ethernet();
  initialize_stepper();
  initialize_servos(&fetcher_struct, &returner_struct);
  initialize_game();
  calibrate(&stepper1);
}
void loop() {
  //connect client if not already and read byte
  read_from_client();

  //turn stepper to selected plant position
  while(stepper1.is_working && stepper1.is_calibrated == 1){
    //move stepper 1 to destination with speed 40
    stepper1.is_working = stepperSteps(&stepper1, plant_pos[selected_plant-1], STEPPERSPEED);
    //trigger returner arm, if there is a plant on the table and the stepper finished
    if(!stepper1.is_working && !game.torture_table){
      game.plant_to_be_fetched = 1;
      
    }
    #ifdef DEBUGSTEP
    Serial.print("current pos: ");
    Serial.println(stepper1.current_pos);
    #endif
  }

  //trigger servo arm
  if(game.plant_to_be_fetched){
    game.plant_to_be_fetched = 0;
    game.torture_table = 1;
    //fetch_plant(); ----------------------------------------
    move_servo(&fetcher_struct);
    #ifdef DEBUGGAME
    Serial.println("fetching my plant");
    #endif
    write_to_all_clients('r');
  }

  //debugstuff for stepper
  #ifdef DEBUGSTEP
  //current pos
  Serial.print("current pos: ");
  Serial.println(stepper1.current_pos);
  delay(100);
  #endif
  
}
//########################################################
//########################################################


//-------------------ethernet methods--------------------------------
void initialize_ethernet(){
  #ifdef DEBUGSELECT
  Serial.println("initializing ethernet");
  #endif
  
  //pin of standard ethernet shield
  Ethernet.init(10);
  // initialize ethernet device
  Ethernet.begin(mac, ip, myDns, gateway, subnet);
  
  // Check connected hardware
  if (Ethernet.hardwareStatus() == EthernetNoHardware) {
    #ifdef DEBUGSELECT
    Serial.println("No ethernet shield found.");
    #endif
    while (true) {
      delay(1); // abort, loop infinitely
    }
  }
  if (Ethernet.linkStatus() == LinkOFF) {
    #ifdef DEBUGSELECT
    Serial.println("Ethernet cable is not connected.");
    #endif
  }

  //start server, listen for clients
  server.begin();
  #ifdef DEBUGSELECT
  Serial.print("Socket server address:");
  Serial.println(Ethernet.localIP());
  Serial.print("port:");
  Serial.print(SOCKETPORT);
  #endif
}


void read_from_client(){
    EthernetClient client = server.available();
     #ifdef DEBUGSELECT
     //Serial.println("trying to read from client");
     #endif
    if (client) {
      if (!alreadyConnected) {
        // clear out the input buffer:
        client.flush();
        alreadyConnected = true;

        #ifdef DEBUGSELECT
        Serial.println("We have a new client");
        #endif
      }

    if (client.available() > 0) {
      // read the bytes incoming from the client:
      char thisChar = client.read();

      #ifdef DEBUGSELECT
      Serial.print(thisChar);
      #endif

      //no switchcase for chars
      if (thisChar == '1'){
            select_plant(1);
          } else if(thisChar == '2'){
            select_plant(2);
          } else if (thisChar == '3'){
            select_plant(3);
          } else if(thisChar == '4'){
            select_plant(4);
          } else {
            #ifdef DEBUGSELECT
            Serial.print(": invalid input");
            #endif
      }
    }   
  }
}

//only one client connected, so server.write() is viable
void write_to_all_clients(char c){
  server.write(c);
}

//return old plant if necessary and start stepper
void select_plant(int i){
  #ifdef DEBUGSELECT
  Serial.print("Plant ");
  Serial.print(i);
  Serial.println(" selected");
  #endif

  //starts stepper
  stepper1.is_working = 1;

  //check if plant has to be returned
  if(game.torture_table){
  
    #ifdef DEBUGGAME
    Serial.println("returning plant");
    #endif
    
    //return_plant(); ------------------------------
    move_servo(&returner_struct);
    game.torture_table = 0;
  }

  selected_plant = i;
}

//-------------------------------------------------------------------


//---------------------stepper methods--------------------------------
//initializes structs and interrupt for calibration
void initialize_stepper(){
  //setup stepper1 struct
  stepper1.pinA0 = PC0;
  stepper1.pinA1 = PC1;
  stepper1.pinA2 = PC2;
  stepper1.pinA3 = PC3;
  stepper1.stepperstate = 0;
  stepper1.is_working = 0;
  stepper1.old_steppertime = 0;
  stepper1.is_calibrated = 0;
  //initialize plant- and current position
  stepper1.current_pos = 200; //big number, not reachable, needed for calibration
  stepper1.plant_pos[0] = 120+STEPPEROFFSET; //plant 1
  stepper1.plant_pos[1] = 170+STEPPEROFFSET;
  stepper1.plant_pos[2] = 20+STEPPEROFFSET;
  stepper1.plant_pos[3] = 70+STEPPEROFFSET; //plant 4
  
  //initialize analog in pins 0 to 3 as outputs for stepper motor
  DDRC |= (1 << PC0);
  DDRC |= (1 << PC1);
  DDRC |= (1 << PC2);
  DDRC |= (1 << PC3);

  //use pin 3 as interrupt pin with vector 1 and external pulldown
  pinMode(3, INPUT);
  attachInterrupt(1, pin_ISR, FALLING);
}
//-------------------------------------------------------------------



//----------------------servo methods--------------------------------
/*int fetch_plant(){
  move_servo(&fetcher_struct);
  return 1;
}

int return_plant(){
  move_servo(&returner_struct);
  return 1;
}*/

//initializes structs
void initialize_servos(struct servoMot *fet, struct servoMot *ret){
  //initialize servo structs
  //servo 1
  fet->state = 0;
  fet->current_pos = 0;
  //set idle and targetpos
  fet->idle_pos = 80;
  fet->target_pos = 158;
  fet->connected_servo = servo_fetcher;
  //Servo2
  ret->state = 0;
  ret->current_pos = 0;
  //set idle and targetpos
  ret->idle_pos = 120;
  ret->target_pos = 156;
  ret->connected_servo = servo_returner;

  //attach outputs to servo
  servo_fetcher.attach(5);
  servo_returner.attach(6);

  //move to starting position
  move_servos_to_idle(fet, ret);
}
//-------------------------------------------------------------------


//--------------------game methods-----------------------------------
void initialize_game(){
  game.plant_to_be_fetched = 0;
  game.torture_table = 0;
}
//-------------------------------------------------------------------


//interrupt of turntable switch, calibrates position
 void pin_ISR(){
  #ifdef DEBUGSTEP
  Serial.println("interrupt");
  #endif
  stepper1.current_pos = 0;
}
