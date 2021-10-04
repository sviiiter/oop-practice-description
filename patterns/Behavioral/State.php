<?php

  /*
  В объект клиентского класса внедряется объект другого класса, содержащий в себе реализацию задачи.
  Для реализаций разных задач, соответственно задачам, создают несколько разных типов одного интерфейса и внедряют объект интерфейса
*/


  abstract class State
  {

    /** @var Job */
    protected $_subject;


    public function __construct(Job $j) {
      $this->_subject = $j;
    }


    abstract public function do();

  }


  class StartState extends State
  {

    public function do() {
      echo 'Start' . "\n";
      $this->_subject->toggleState(new ProgressState($this->_subject));
      $this->_subject->do();
    }

  }


  class ProgressState extends State
  {

    public function do() {
      echo 'Progress' . "\n";
      $this->_subject->toggleState(new FinishState($this->_subject));
      $this->_subject->do();
    }

  }


  class FinishState extends State
  {

    public function do() {
      echo 'done' . "\n";
    }

  }


  class Job
  {

    /** @var State */
    private $_state;


    public function do() {
      $this->_state->do();
    }


    public function toggleState(State $s) {
      $this->_state = $s;
    }

  }


  $job = new Job();
  $job->toggleState(new StartState($job));
  $job->do();



