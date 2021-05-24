<?php

  class Singleton
  {
    
    private static $_instanse;

    private function __construct() {}


    public static function getInstance(): Singleton {
      return static::$_instanse = static::$_instanse ?? new static;
    }

  }

  $i = Singleton::getInstance(); // new
  $i = Singleton::getInstance(); // static