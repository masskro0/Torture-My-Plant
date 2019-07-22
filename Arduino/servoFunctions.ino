//move servo from idle position to destination and back
void move_servo(struct servoMot *serv){
  //check if you have to move forward or backward
  if (serv->target_pos > serv->idle_pos){
    //move to destination
    int i = serv->current_pos;
    
    #ifdef DEBUGSERVO
    Serial.print("i should be current pos: ");
    Serial.println(i);
    #endif
    
    while(!(serv->state)){
      //check if servo is at its destination
      if (serv->current_pos == (serv->target_pos)-1){
        serv->state = 1;
      }
      (serv->connected_servo).write(i);
      
      #ifdef DEBUGSERVO
      Serial.print("position i: ");
      Serial.println(i);
      Serial.print("state: ");
      Serial.println(serv->state);
      #endif
      
      serv->current_pos = i;
      i++;
      delay(20);
      
    }
    i = serv->current_pos;
    //return to idle position
    while (serv->state){
      if (serv->current_pos == (serv->idle_pos)+1){
        serv->state = 0;
      }
      (serv->connected_servo).write(i);
      
      #ifdef DEBUGSERVO
      Serial.print("position i: ");
      Serial.println(i);
      Serial.print("target_pos_fetcher: ");
      Serial.println(serv->target_pos);
      #endif
      
      serv->current_pos = i;
      i--;
      delay(10);
    }
  } else {
    int i = serv->current_pos;
    while(!(serv->state)){
      if (serv->current_pos == (serv->target_pos)+1){
        serv->state = 1;
      }
      (serv->connected_servo).write(i);
      serv->current_pos = i;
      i--;
      delay(20);
      
    }
    i = serv->current_pos;
    //return to idle position
    while (serv->state){
      if (serv->current_pos == (serv->idle_pos)-1){
        serv->state = 0;
      }
      (serv->connected_servo).write(i);
      serv->current_pos = i;
      i++;
      delay(10);
    }
  }
}

void move_servos_to_idle(struct servoMot *serv1, struct servoMot *serv2){
  //move to starting position
  (serv1->connected_servo).write(serv1->idle_pos);
  serv1->current_pos = serv1->idle_pos;
  (serv2->connected_servo).write(serv2->idle_pos);
  serv2->current_pos = serv2->idle_pos;
}
