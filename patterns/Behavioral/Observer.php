<?php

/*
  Объекту класса исполнителю(за кем наблюдают) назначаются "смотрящие"(реализующие интерфейс)
  Когда исполнитель решает оповестить он в цикле вызывает метод интерфеса "смотрящих"
*/

  class Publisher
  {

    /** @var Subscriber */
    protected $_subscribers = [];


    public function add(Subscriber $i) {
      $this->_subscribers[json_encode($i)] = $i;
    }


    public function remove(Subscriber $i) {
      unset($this->_subscribers[json_encode($i)]);
    }


    public function iAmChanging() {
      array_walk($this->_subscribers, function (Subscriber $i) {
        $i->update();
      });
    }

  }


  interface Subscriber
  {

    public function update();

  }


  class LogState implements Subscriber
  {

    protected $notified = 0;


    public function update() {
      $this->notified++;
    }

  }

  $target = new Publisher();

  $job1 = new LogState();
  $target->add($job1);

  $job2 = new LogState();
  $target->add($job2);
  /*...*/

  $target->iAmChanging();

