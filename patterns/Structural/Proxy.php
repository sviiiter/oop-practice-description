<?php

  /*
    Реализуем объект-"канал"(того же интерфейса что и клиентский объект), выполняющий роль "вахтера"
  */

  interface Data
  {

    public function find(string $query);

  }


  class Db implements Data
  {

    public function find(string $query) {
      /*select from db*/
    }

  }


  class Cache implements Data
  {

    private static $queries = [];


    final public function find(string $query) {
      $key = json_encode($query);
      return static::$queries[$key] = static::$queries[$key] ?? (new Db())->find($query);
    }

  }


function getData(Data $instance) {
    echo $instance->find('asdf');
}

getData(new Db()); // no cache, load Db every time
getData(new Cache()); // use Proxy -> profit

