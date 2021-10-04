<?php

  require __DIR__ . '/../../../br.php';

  /*
   * Chain of Responsibility
   * Потомку устанавливают указатель на следующий класс того же интерфейса.
   * Далее можно провести проверку ДО или ПОСЛЕ выполнения задачи потомка и вызвать выполнение одноименной задачи потомка.
   *
   * По принципу действия цепочки похож на конструкцию if - else
   *
   */

  abstract class BaseCor
  {

    /* @var BaseCor $_knot */
    protected $_knot;


    public function setNext(BaseCor $obj) {
      $this->_knot = $obj;
    }


    public function do() {
      $this->printAction();
      if ($this->_knot instanceof BaseCor) {
        $this->_knot->do();
      }
    }


    abstract public function printAction();

  }

  class Check extends BaseCor
  {

    public function printAction() {
      echo 'check input' . "\n";
    }

  }

  class Save extends BaseCor
  {

    public function printAction() {
      echo 'save into db' . "\n";
    }

  }

  class Log extends BaseCor
  {

    const STATE_STARTED = 'start';

    const STATE_STOPPED = 'stop';

    /* @var string */
    private $_message;


    public function __construct($_message = Log::STATE_STARTED) {
      $this->_message = $_message;
    }


    public function printAction() {
      echo 'state ' . $this->_message;
      newline();
    }


    public function do() {

      if ($this->_message == self::STATE_STARTED)
        $this->printAction();

      if ($this->_knot instanceof BaseCor) {
        $this->_knot->do();
      }

      if ($this->_message == self::STATE_STOPPED)
        $this->printAction();
    }

  }

  $pipes = [
    new Log(Log::STATE_STARTED),
    new Check(),
    new Save(),
    new Log(Log::STATE_STOPPED)
  ];

  $pipes = array_reverse($pipes);

  $next = array_shift($pipes);

  foreach ($pipes as $pipe) {
    /* @var BaseCor $pipe */
    $pipe->setNext($next);
    $next = $pipe;
  }

  $next->do();

  newline();


  // Callback realization


  interface I
  {

    public function ring($content, $chain);

  }

  class A implements I
  {
    function ring($content, $chain) {
      $content = $chain($content);
      $content .= ' hello';
      return $content;
    }
  }


  class B implements I
  {
    function ring($content, $chain) {
      $content .= ' word';
      $content = $chain($content);
      return $content;
    }
  }

  class C implements I
  {
    function ring($content, $chain) {
      return $content .= ':';
    }
  }

  function pipe($content, ...$pipes) {
    $reversed = array_reverse($pipes);
    $chain = null;

    foreach ($reversed as $k => $item) {
      $chain = function ($content) use ($item, $chain) {
        return $item->ring($content, $chain);
      };
    }
    return $chain($content);
  }


  echo pipe('Say', new A, new B, new C);
  newline();
  // Output: Say word: hello
