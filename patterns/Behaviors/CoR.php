<?php

  /*
   * Chain of Responsibility
   * Потомку устанавливают указатель на следующий класс того же интерфейса.
   * Далее можно провести проверку ДО или ПОСЛЕ выполнения задачи потомка и вызвать выполнение одноименной задачи потомка.
   *
   * По принципу действия цепочки похож на конструкцию if - else
   *
   */

  abstract class BaseCor
  {

    /* @var BaseCor $_knot */
    protected $_knot;

    /** @var false|mixed has check failed */
    protected $stop;


    public function __construct($stop = false) {
      $this->stop = $stop;
    }


    public function setNext(BaseCor $obj) {
      $this->_knot = $obj;
    }


    public function do() {

      if ($this->stop) {
        echo 'failed.' . "\n";
      } else {
        $this->printAction();
        if ($this->_knot instanceof BaseCor) {
          $this->_knot->do();
        }
      }
    }

    abstract public function printAction();

  }

  class Check extends BaseCor
  {

    public function printAction() {
      echo 'check input' . "\n";
    }

  }

  class Save extends BaseCor
  {

    public function printAction() {
      echo 'save into db' . "\n";
    }


  }

  $a = new Check();
  $b = new Save(true);

  $a->setNext($b);
  $a->do();

  echo "\n";
  $c = new Save();
  $a->setNext($c);
  $a->do();



