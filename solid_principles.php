<?php

  // SINGLE RESPONSIBILITY

  interface WrongFirst
  {

    public function saveIntoDb($result);

    public function downloadByCurl($connection);

  }


  // =>

  interface SingleRightDbConnection
  {

    public function saveIntoDb($result);

  }


  interface SingleRightCurl
  {

    public function downloadByCurl($connection);

  }


  // OPEN-CLOSED

  class WaterWrong
  {

  }


  class IceWrong
  {

  }


  class WrongProfile
  {
    public function getInstanceState($instance) {
      if ($instance instanceof WaterWrong) {
        return 'liquid';
      }

      if ($instance instanceof IceWrong) {
        return 'solid';
      }
    }
  }


  // =>

  interface Substance
  {

    function getState();

  }


  class Profile // stable locked class
  {
    public function getInstanceState(Substance $instance) {
      $instance->getState();
    }
  }


  class WaterRight implements Substance // implementation example
  {
    public function getState() {
      return 'liquid';
    }
  }


  class IceRight implements Substance // implementation example
  {
    public function getState() {
      return 'solid';
    }
  }


//  LISKOV SUBSTITUTE

  abstract class SubstanceLiskov
  {

    abstract function getState(object $instance): string;

  }


  class WaterRightLiskov extends SubstanceLiskov
  {
    public function getState(object $instance): int {
      return 10; // wrong, this must be a string type
    }
  }


//  INTERFACE SEGREGATION

  interface Substances
  {

    function getIce();


    function getWater();


    function getGround();

  }

  // =>

  interface Ice
  {
    function getIce();
  }


  interface Water
  {
    function getWater();
  }


  interface Ground
  {
    function getGround();
  }


  class ConcreteSubstances implements Ice, Water
  {
    function getIce() {
      // TODO: Implement getIce() method.
    }

    function getWater() {
      // TODO: Implement getWater() method.
    }

  }


//  DEPENDENCY INVERSION

interface Connection {

  function initConnection();

}


abstract class DbLoader implements Connection
{

  public function save() {
    $this->initConnection();
    Db::update();
  }

  abstract function initConnection();

}


class PostgresLoader extends DbLoader
{

  function initConnection() {
    return /* connection to ps */;
  }

}