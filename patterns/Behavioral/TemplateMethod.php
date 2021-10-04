<?php

   /*
    * В одном методе абстракции описывается конфигурирование объекта
    * Конфигурируем наследующие классы-потомки
    */

  abstract class TJob
  {

    abstract public function start();


    abstract public function dinner();


    abstract public function finish();


    public function templateMethod() {
      return $this->start() . "\n"
              . $this->dinner() . "\n"
              . $this->finish() . "\n";
    }

  }


  class BuildJob extends TJob
  {

    public function start() {
      return 'come to work and put on work clothes';
    }


    public function dinner() {
      return 'eat some snack food';
    }


    public function finish() {
      return 'change clothes and go home';
    }

  }


  class DriveJob extends TJob
  {

    public function start() {
      return 'Power on and drive';
    }


    public function dinner() {
      return 'eat some food at the nearest restaurant';
    }


    public function finish() {
      return 'Power off and go home';
    }

  }



  $j = new DriveJob();
  echo $j->templateMethod();