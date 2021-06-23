<?php

  class Singleton
  {
    
    private static $_instance;

    private function __construct() {}


    public static function getInstance(): Singleton {
      return static::$_instance = static::$_instance ?? new static;
    }

  }

  $i = Singleton::getInstance(); // new
  $i = Singleton::getInstance(); // static