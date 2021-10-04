<?php


  abstract class Builder
  {
    /** @var Phone */
    protected $_phone;


    abstract public function __construct();


    abstract public function addBattery();


    abstract public function addScreen();


    abstract public function applyOs();

    public function getPhone(): Phone {
      return $this->_phone;
    }

  }


  class IphoneBuilder extends Builder
  {

    public function __construct() {
      $this->_phone = new Iphone();
    }


    public function addBattery() {
      // TODO: Implement addBattery() method.
    }


    public function addScreen() {
      // TODO: Implement addScreen() method.
    }


    public function applyOs() {
      // TODO: Implement applyOs() method.
    }

  }


  class GalaxyBuilder extends Builder
  {

    public function __construct() {
      $this->_phone = new Galaxy();
    }


    public function addBattery() {
      // TODO: Implement addBattery() method.
    }


    public function addScreen() {
      // TODO: Implement addScreen() method.
    }


    public function applyOs() {
      // TODO: Implement applyOs() method.
    }

  }

  class Phone
  {}

  class Iphone extends Phone
  {}

  class Galaxy extends Phone
  {}