<?php

/*
  Работаем со схожими объектами деревьями одного интерфейса
  Client::write()
    -> Storage::write()
      -> File::write()
      -> Db::write()
    -> Notification::write()
      -> Push::write()
      -> Mail::write()
  */

  interface Employee
  {

    public function doWork();

  }

  class Courier implements Employee
  {

    public function doWork() {}

  }

  class Manager extends Courier
  {

    public function doWork() {
      parent::doWork();
    }

  }


  class Composite implements Employee
  {
    /** @var Employee[] */
    private static $employees = [];




    final public function doWork() {
      foreach (static::$employees as $item) {
        $item->doWork();
      }
    }

  }