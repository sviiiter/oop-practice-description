<?php

/*
  Используется для создания большого числа экземпляров различных типов, имеющих в своей структуре сходство
  Сходство можно описать одним объектом-экземпляром(легковесом)
  Метод клиентского класса вызывает одноименный метод(одного интерфейса, необязательно) легковеса с параметрами, который выполняет ту же задачу что и сконфигурированный клиентский класс
  Вместо тысячи объектов с сотнями свойств-настроек получаем тысячу объектов с 2 уникальными свойствами-настройками и одним идентичным объектом - простейший случай
  Экономия памяти -> profit

Псевдокод:
 <Town>->buildAHouse('forest', 2 floors, 2 flats)
    <house> = new HouseFactory('forest'): returns a <House> with hardware and material
    <house>->build(2 floors, 2 flats)
  */

  class Town
  {

    private $_houseFactory;


    public function __construct() {
      $this->_houseFactory = new HouseFactory();
    }


    public function buildAHouse($material, $countFloors, $countFlats): HouseType {
      $house = $this->_houseFactory->getType($material);
      $house->build($countFloors, $countFlats);
      return $house;
    }

    public function profileFactory(): HouseFactory {
      return $this->_houseFactory;
    }
  }


  class HouseFactory
  {
    // some kinda cache
    private $types;

    public function getType($material) {
      return $this->types[$material] = $this->types[$material] ?? new HouseType($material);
    }


    public function count() {
      return count($this->types);
    }
  }


  class HouseType { // легковес

    const FOREST = 'forest';


    private $_raw;
    private $_hardware;
    private $_floors;
    private $_flats;

    public function __construct($material) {
      if ($material === self::FOREST) {
        $this->_raw = 'tree';
        $this->_hardware = 'nails';
      } else {
        $this->_raw = 'concrete';
        $this->_hardware = 'screw';
      }
    }


    public function build($countFloors, $countFlats) {
      $this->addFloors($countFloors);
      $this->addFlats($countFlats);
    }


    public function addFloors($i) {
      $this->_floors = $i;
    }


    public function addFlats($i) {
      $this->_flats = $i;
    }


    public function profile() {
      echo sprintf('The house build with a "%s" tech using hardware "%s" and has %s floors and %s flats', $this->_raw, $this->_hardware, $this->_floors, $this->_flats);
      echo "\n";
    }
  }

  $town = new Town();

  for ($i = 0; $i < 5; $i++) {
    $town->buildAHouse(HouseType::FOREST, rand(0, 10), rand(0, 10))->profile();
  }

  for ($i = 0; $i < 5; $i++) {
    $town->buildAHouse('brick', rand(0, 10), rand(0, 10))->profile();
  }

  echo 'The count of unique objects: ' . $town->profileFactory()->count();
  echo "\n";


// Output:
//The house build with a "tree" tech using hardware "nails" and has 5 floors and 3 flats
//The house build with a "tree" tech using hardware "nails" and has 2 floors and 9 flats
//The house build with a "tree" tech using hardware "nails" and has 4 floors and 9 flats
//The house build with a "tree" tech using hardware "nails" and has 10 floors and 6 flats
//The house build with a "tree" tech using hardware "nails" and has 8 floors and 4 flats
//The house build with a "concrete" tech using hardware "screw" and has 1 floors and 5 flats
//The house build with a "concrete" tech using hardware "screw" and has 7 floors and 7 flats
//The house build with a "concrete" tech using hardware "screw" and has 6 floors and 5 flats
//The house build with a "concrete" tech using hardware "screw" and has 6 floors and 3 flats
//The house build with a "concrete" tech using hardware "screw" and has 0 floors and 0 flats
//The count of unique objects: 2


  die;



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

//
//  class CarFlyweight
//  {
//
//    private $wheels;
//
//    private $engine;
//
//
//    public function __construct(...$data) { /*assign props*/ }
//
//    public function go($price, $model) { }
//
//  }
//
//
//  class CarRight
//  {
//
//    public $price;
//
//    public $model;
//
//    /** @var CarFlyweight */
//    private $type;
//
//
//    public function __construct(...$data) { /*assign props*/ }
//
//    public function start() {
//      $this->type->go($this->price, $this->model);
//    }
//  }
//
//
//  $factory = [];
//
//  function search($wheels, $engine) use (&$factory): CarFlyweight {
//    if (isset($factory[$wheels . '_' . $engine])) {
//      return $factory[$wheels . '_' . $engine];
//    }
//
//    return $factory[$wheels . '_' . $engine] = new CarFlyweight($wheels, $engine);
//  }
//
//  (new CarRight(1000, 'Volga', search(false, true)))->start();
//  (new CarRight(2000, 'Skoda', search(true, true)))->start();
//  (new CarRight(1000, 'Feat', search(true, false)))->start();
//  (new CarRight(1000, 'Volga', search(true, true)))->start();
//  ... etc


