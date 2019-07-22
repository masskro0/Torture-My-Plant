//turns the stepper motor to position pos with delays del after each step
int stepperSteps(struct stepperMot *mot, int pos, int del){
  if (mot->current_pos != pos){ 
      #ifdef DEBUGSTEP
      Serial.print("test");
      #endif
      //if delaytime is reached move one step
      if (millis() > mot->old_steppertime){
      //switch between four steps
      switch(mot->stepperstate){
        case 0: PORTC |= (1<<mot->pinA0);
                PORTC &= ~(1<<mot->pinA1);
                PORTC |= (1<<mot->pinA2);
                PORTC &= ~(1<<mot->pinA3);
                mot->stepperstate++;
                break;
        case 1: PORTC &= ~(1<<mot->pinA0);
                PORTC |= (1<<mot->pinA1);
                PORTC |= (1<<mot->pinA2);
                PORTC &= ~(1<<mot->pinA3);
                mot->stepperstate++;
                break; 
        case 2: PORTC &= ~(1<<mot->pinA0);
                PORTC |= (1<<mot->pinA1);
                PORTC &= ~(1<<mot->pinA2);
                PORTC |= (1<<mot->pinA3);
                mot->stepperstate++;
                break; 
        case 3: PORTC |= (1<<mot->pinA0);
                PORTC &= ~(1<<mot->pinA1);
                PORTC &= ~(1<<mot->pinA2);
                PORTC |= (1<<mot->pinA3);  
                mot->stepperstate = 0;
                break; 
      }
      mot->current_pos++;
      mot->old_steppertime = millis() + del;
    }
    //return is working
    return 1;
  } else {
    //return is finished
    return 0;
  }
}

void calibrate(struct stepperMot *mot){
  #ifdef DEBUGSTEP
  Serial.println("tries to calibrate");
  #endif
  
  mot->is_working = 1;
  //move stepper until the interrupt is triggered
  while((mot->current_pos) > 0){
    //set destination of stepper to infinity to keep turning
    mot->is_working = stepperSteps(mot, 65535, STEPPERSPEED);
    #ifdef DEBUGSTEP
    Serial.print("calibrating, current pos: ");
    Serial.println(mot->current_pos);
    #endif
  }
  mot->is_working = 0;//maybe delete, for servo test
  write_to_all_clients('r'); //stupid
  stepper1.is_calibrated = 1;
}
