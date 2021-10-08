<?php

  /*
    "Класс-функция" или прослойка между отправителем и получателем
    Инкапсулирует набор операций, которые будут выполняться больше одного раза в разных частях программы
    Благодаря общему интерфейсу можно подменять наборы операций
    Команда имеет получателя, вызывается отправителем

    Пример задачи:
      Строим город . Есть три типа строений:
        -торговый центр,
        -коттедж
        - небоскреб

      Есть несколько комманд классов одного интерфейса с методом execute(): BuildCommand, DesignCommand, SaleCommand
      Каждый метод execute знает что делать со строением
  */

  abstract class Command
  {

    /* @var Executor */
    protected $_executor;

    public function __construct(Executor $executor) {
      $this->_executor = $executor;
    }


    abstract public function execute();

  }

  class BuildCommand extends Command
  {

    public function execute() {
      // возводим здание: берем материал, инструмент, строителей и строим
      $executor = $this->_executor;
      $executor->prepareWorkplace();
      $executor->buildTarget();
      $executor->cleanWorkPlace();
    }

  }

  class DesignCommand extends Command
  {

    public function execute() {
      // проектируем здание: берем наброски будущего строения и идем к архитектору
      $executor = $this->_executor;
      $executor->createEmptyProject();
      $executor->design();
      $executor->saveProject();
    }

  }

  class SaleCommand extends Command
  {

    public function execute() {
      // продаем здание
      $executor = $this->_executor;
      $executor->present();
      $executor->makeDeal();
    }

  }


  abstract class Executor {

    abstract public function prepareWorkplace();
    abstract public function buildTarget();
    abstract public function cleanWorkPlace();
    abstract public function createEmptyProject();
    abstract public function design();
    abstract public function saveProject();
    abstract public function present();
    abstract public function makeDeal();
}

  class ConcreteExecutor extends Executor {

    public function prepareWorkplace() {
      // TODO: Implement prepareWorkplace() method.
    }


    public function buildTarget() {
      // TODO: Implement buildTarget() method.
    }


    public function cleanWorkPlace() {
      // TODO: Implement cleanWorkPlace() method.
    }


    public function createEmptyProject() {
      // TODO: Implement createEmptyProject() method.
    }


    public function design() {
      // TODO: Implement design() method.
    }


    public function saveProject() {
      // TODO: Implement saveProject() method.
    }


    public function present() {
      // TODO: Implement present() method.
    }


    public function makeDeal() {
      // TODO: Implement makeDeal() method.
    }

  }


  class Build
  {

    /* @var Command */
    protected $c;


    public function __construct(Command $c) {
      $this->c = $c;
    }


    public function release() {
      $this->c->execute();
    }

  }



  class Car
  {

    /* @var Command */
    protected $c;


    public function __construct(Command $c) {
      $this->c = $c;
    }


    public function release() {
      $this->c->execute();
    }

  }


  $executor = new ConcreteExecutor();
  $command = new BuildCommand($executor);
  (new Build($command))->release();
  (new Fence($command))->do(); // or


  $executor = new ConcreteExecutor();
  $command = new SaleCommand($executor);


  // client
  (new Build($command))->release();
  (new Car($command))->release();












