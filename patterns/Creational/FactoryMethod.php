<?php

  namespace oop\FactoryMethod;

  abstract class SocialNetwork
  {
    // Factory method
    // создает идентичные объекты различных типов, что позволяет выполнять над ними
    abstract public function getConnection(): Connection;

    public function comment() {
      // создаем объект
      $connection = $this->getConnection();
      $connection->login();
      $connection->post();
    }
  }

  // подключаемый обьект.
  class Instagram extends SocialNetwork
  {
    public function getConnection(): Connection {
        return new InstaConnection('test', '123');
    }
  }

  // подключаемый обьект
  class Facebook extends SocialNetwork
  {
    public function getConnection(): Connection {
      return new FbConnection('test', '123');
    }
  }
  // ....
  // подключаемый обьект

  // коннекторы
  interface Connection
  {
    public function login();
    public function post();
  }

  class InstaConnection implements Connection
  {
    private $_login;
    private $_pass;
    public function __construct($login, $pass) {
      $this->_login = $login;
      $this->_pass = $pass;
    }

    public function login(): void {
      echo 'logged by QR';
      echo "\n"; // correct output
    }

    public function post() {
      echo 'Insta comment: Hello world';
      echo "\n"; // correct output
    }
  }

  class FbConnection implements Connection
  {
    private $_login;
    private $_pass;
    public function __construct($login, $pass) {
      $this->_login = $login;
      $this->_pass = $pass;
    }

    public function login() {
      echo 'logged by pass';
      echo "\n"; // correct output
    }

    public function post() {
      echo 'Fb comment: Hello world';
      echo "\n"; // correct output
    }
  }