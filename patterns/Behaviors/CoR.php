<?php

  /*
   * Chain of Responsibility
   * Потомку устанавливают указатель на следующий класс того же интерфейса.
   * Далее можно провести проверку ДО или ПОСЛЕ выполнения задачи потомка и вызвать выполнение одноименной задачи.
   */

  interface CoR
  {

    public function setNext(CoR $obj);


    public function do();

  }


  abstract class BaseCor implements CoR
  {

    /* @var BaseCor $_knot */
    protected $_knot;
    public $name;

    public function setNext(CoR $obj) {
      $this->_knot = $obj;
    }


    public function do() {
      if ($this->_knot instanceof CoR) {
        echo sprintf('Current knot name %s. Knot name is %s', $this->name, $this->_knot->name) . "\n";
        $this->_knot->do();
      }
    }

  }

  class ConcreteFirst extends BaseCor
  {

    public $isStop = false;


    public function __construct($name) {
      $this->name = $name;
    }


    public function do() {
      if ($this->isStop === true) { // some check
        echo 'Flag' . "\n";
        die;
      }
      parent::do();
    }
  }

  $a = new ConcreteFirst('knot1');
  $a->isStop = true;
  $b = new ConcreteFirst('knot2');
  $c = new ConcreteFirst('knot3');

  $b->setNext($a);
  $c->setNext($b);
  $c->do();



