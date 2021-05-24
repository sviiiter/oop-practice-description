<?php

  /*
  В клиентском объекте вызывается метод внедренного объекта другого типа с передачей себя параметром метода.
  Внедренный объект делает действия в зависимости от клиентского объекта
  Для того чтобы использовать разные внедренные объекты можно внедрять интерфейс
  Внедренный объект - посредник
  */

  interface Notifier //mediatior
  {

    public function react(MEmployee $e);

  }


  class Boss implements Notifier // class Manager is another mediator
  {

    public function react(MEmployee $e) {
      if ($e instanceof Courier) {
        $this->reactCourier();
      }

      if ($e instanceof  Driver) {
        $this->reactDriver();
      }
    }


    public function reactCourier() {
      echo 'thx, go home' . "\n";
    }


    public function reactDriver() {
      echo 'thx, go to garage, leave the car and go home' . "\n";
    }
  }


  class MEmployee
  {

    private $_boss;


    public function __construct(Notifier $n) {
      $this->_boss = $n;
    }


    public function done() {
      $this->_boss->react($this);
    }

  }

  class Courier extends MEmployee
  {

  }

  class Driver extends MEmployee
  {

  }

  (new Courier(new Boss()))->done();
  (new Driver(new Boss()))->done();