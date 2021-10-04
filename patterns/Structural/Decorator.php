<?php

  /*
    Имеем клиентский тип, который нужно "нарядить".
    Создаем декорирующие типы того же интерфейса что и клиентский тип и ссылку на сам клиентский тип
    В каждом подклассе ДОБАВЛЯЕМ что-то к базовому поведению
    В клиентском приложении используем интерфейс для вызова метода, а реализацию декорирующего класса
    Как правило используется вместо расширения зафинализированного класса
    Profit: вносим конкретику на высоких уровнях
  */

  interface Html
  {

    public function add();

  }


  class Page implements Html // init page
  {

    final public function add() {
      return self::class;
      /* create file .html */
    }


  }


  class Decorator implements Html
  {

    /** @var Html */
    protected $_subject;


    public function __construct(Html $_subject) {
      $this->_subject = $_subject;
    }


    public function add() {
      return $this->_subject->add() . '->' . self::class;

      /*add html tag*/
    }

  }


  class BodyDecorator extends Decorator implements Html
  {

    public function add() {
      return $this->_subject->add() . '->' . self::class;
    }

  }

//  class App
//  {
//
//    public static function load(Html $page):string {
//      return $page->add() . "\n"; //Page->Decorator->Decorator->BodyDecorator
//    }
//
//  }

  $page = new Page();
  $decorator = new Decorator($page);
  $decorator1 = new BodyDecorator($decorator);


  echo $decorator1->add() . "\n";

//  echo App::load($page);
//  echo App::load($decorator);
//  echo App::load($decorator1);







