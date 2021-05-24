<?php

/*
  Используется для создания большого числа экземпляров различных типов, имеющих в своей структуре сходство
  Сходство можно описать одним объектом-экземпляром(легковесом)
  Метод клиентского класса вызывает одноименный метод(одного интерфейса, необязательно) легковеса с параметрами, который выполняет ту же задачу что и сконфигурированный клиентский класс
  Вместо тысячи объектов с сотнями свойств-настроек получаем тысячу объектов с 2 уникальными свойствами-настройками и одним идентичным объектом - простейший случай
  Экономия памяти -> profit
  */

  class Car
  {

    public $wheels;

    public $engine;

    public $model;

    public $price;


    public function __construct(...$data) { /*assign props*/
    }

  }

  $a = new Car(true, 'Feat', true, 1000);
  $b = new Car(true, 'Volga', true, 2000);

//  ....


  class CarFlyweight
  {

    private $wheels;

    private $engine;


    public function __construct(...$data) { /*assign props*/ }

    public function go($price, $model) { }

  }


  class CarRight
  {

    public $price;

    public $model;

    /** @var CarFlyweight */
    private $type;


    public function __construct(...$data) { /*assign props*/ }

    public function start() {
      $this->type->go($this->price, $this->model);
    }
  }


  $factory = [];

  function search($wheels, $engine) use (&$factory): CarFlyweight {
    if (isset($factory[$wheels . '_' . $engine])) {
      return $factory[$wheels . '_' . $engine];
    }

    return $factory[$wheels . '_' . $engine] = new CarFlyweight($wheels, $engine);
  }

  (new CarRight(1000, 'Volga', search(false, true)))->start();
  (new CarRight(2000, 'Skoda', search(true, true)))->start();
  (new CarRight(1000, 'Feat', search(true, false)))->start();
  (new CarRight(1000, 'Volga', search(true, true)))->start();
//  ... etc


