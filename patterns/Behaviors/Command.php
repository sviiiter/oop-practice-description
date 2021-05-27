<?php

  /*
    "Класс-функция"
    Является инъекцией в абстрактный объект, на контекст предка которого реагирует функцией
    Пример задачи:
      Строим город . Есть три типа строений:
        -торговый центр,
        -коттедж
        - небоскреб

      Есть несколько комманд классов одного интерфейса с методом execute(): BuildCommand, DesignCommand, SaleCommand
      Каждый метод execute знает что делать со строением
  */

  interface Command
  {

    public function execute(Build $b);

  }

  class BuildCommand implements Command
  {

    public function execute(Build $b) {
      // возводим здание: берем материал, инструмент, строителей и строим
    }

  }

  class DesignCommand implements Command
  {

    public function execute(Build $b) {
      // проектируем здание: берем наброски будущего строения и идем к архитектору
    }

  }

  class SaleCommand implements Command
  {

    public function execute(Build $b) {
      // продаем здание
    }

  }

  class Build
  {

    /* @var Command */
    protected $c;


    public function __construct(Command $c) {
      $this->c = $c;
    }


    public function run() {
      $this->c->execute($this);
    }

  }

  class Moll extends Build
  {

  }

  class Cottage extends Build
  {

  }

  class Skyscraper extends Build
  {

  }


  (new Moll(new BuildCommand()))->run();








