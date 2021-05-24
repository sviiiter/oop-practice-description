<?php

/*
  В клиентский тип объекта внедряется метод объекта, хранящего поведения
  В поведенческом объекте хранится поведение для различных клиентских типов
  Чтобы использовать разные поведения для одного клиентского класса в него внедряют интерфейс поведения
*/

  interface Visitor // поведение
  {

    public function applyBus(Transport $transport);


    public function applyCar(Transport $transport);


    public function applyTrain(Transport $transport);

  }

  class Route implements Visitor
  {

    public function applyBus(Transport $transport) {
      echo 'Go forward and get stops';
    }


    public function applyCar(Transport $transport) {
      echo 'Go forward and fast';
    }


    public function applyTrain(Transport $transport) {
      echo 'Go forward, fast and get stops';
    }

  }

  class Time implements Visitor
  {

    public function applyBus(Transport $transport) {
      echo '11::00 PM';
    }


    public function applyCar(Transport $transport) {
      echo 'now, anytime';
    }


    public function applyTrain(Transport $transport) {
      echo 'morning';
    }

  }



  interface Transport
  {

    public function behave(Visitor $visitor);

  }


  class Bus implements Transport
  {

    public function behave(Visitor $visitor) {
      $visitor->applyBus($this);
    }

  }


  class Car implements Transport
  {

    public function behave($visitor) {
      $visitor->applyCar($this);
    }

  }


  class Train implements Transport
  {

    public function behave($visitor) {
      $visitor->applyTrain($this);
    }

  }

  $obj = new Bus();
  $obj->behave(new Route());
  $obj->behave(new Time());
  // e.t.c. example saving in different storages OR export into formats
