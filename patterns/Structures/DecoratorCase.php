<?php
//
//  простой пример оборачивания(декорирования) класса для построения запроса sql (без валидации исходных данных)
//  Декораторы - фильтры сортировки/условия и т.д.


  interface iDecor
  {

    public function getProvider(): Provider;

  }

  class Provider implements iDecor// decorated
  {

    /** @var array $in primary keys */
    public $in;

    public $order = [];

    public $where = [];


    public function __construct(array $in = []) {
      $this->in = $in;
    }


    final public function getProvider(): Provider {
      return $this;
    }

  }

  abstract class DecoratorCase
  {

    /* @var $decorated iDecor */
    protected $decorated;


    public function __construct(iDecor $obj) {
      $this->decorated = $obj;
    }


  }


  class FactoryProviderDecor extends DecoratorCase implements iDecor
  {

    private $_factory;


    public function __construct(iDecor $obj, ...$factory) {
      $this->_factory = $factory;
      parent::__construct($obj);
    }


    public function getProvider(): Provider {
      $provider = $this->decorated->getProvider();
      $provider->where[] = ['factory' => $this->_factory];

      return $provider;
    }

  }

  class SortProviderDecorator extends DecoratorCase implements iDecor
  {

    const ASC = 1;

    const DESC = 0;

    /* @var $decorated iDecor */
    public $decorated;

    private $column;

    private $direction;


    public function __construct(iDecor $obj, string $column, bool $desc) {
      $this->column = $column;
      $this->direction = $desc ? self::DESC : self::ASC;
      parent::__construct($obj);
    }


    public function getProvider(): Provider {
      $provider = $this->decorated->getProvider();

      $provider->order[] = sprintf('`%s` %s', $this->column, $this->direction == self::ASC ? 'asc' : 'desc');

      return $provider;
    }


  }


  class SimpleSqlBuilder
  {

    /* @var Provider */
    public $provider;


    public function __construct(Provider $p) {
      $this->provider = $p;
    }


    private function buildWhere() {
      $scalar = '';

      if ($in = $this->provider->in) {
        $scalar .= '`id` in (' . implode(',', $in) . ')';
      }

      if ($where = $this->provider->where) {
        $data[] = $scalar;
        foreach ($where as $i) {
          foreach ($i as $columnName => $value) {
            if (is_array($value) && count($value) > 1) {
              $data[] = sprintf('`%s` in (\'%s\')', $columnName, implode('\',\'', $value));
            } else {
              if (is_array($value)) { $value = array_shift($value); }
              $data[] = sprintf('`%s`=\'%s\'', $columnName, $value);
            }
          }
        }

        $data = array_filter($data);
        $scalar = implode(' AND ', $data);
      }

      return $scalar;
    }


    private function buildOrder(): string {
      return $this->provider->order ? 'order by ' . implode(',', $this->provider->order) : '';
    }


    public function getSql() {
      return sprintf('select * from `tableName` where %s %s', $this->buildWhere(), $this->buildOrder());
    }

  }

//  case 1
  $provider = new Provider([1, 2, 3]);

  echo (new SimpleSqlBuilder($provider->getProvider()))->getSql() . "\n";

// case 2
  $filter = new FactoryProviderDecor($provider, 'Panasonic', 'Adidas');
  $filter = new SortProviderDecorator($filter, 'price', true);
  $filter = new SortProviderDecorator($filter, 'factory', false);

  echo (new SimpleSqlBuilder($filter->getProvider()))->getSql() . "\n";

//  case 3
  $provider = new Provider([1, 2, 3]);
  $filter = new FactoryProviderDecor($provider, 'Panasonic', 'Adidas');
  $filter = new SortProviderDecorator($filter, 'price', true);
  $filter = new SortProviderDecorator($filter, 'factory', false);
  $filter = new FactoryProviderDecor($filter, 'Toyota');

  echo (new SimpleSqlBuilder($filter->getProvider()))->getSql() . "\n";

//  case 4

  $provider = new Provider();
  $filter = new SortProviderDecorator($provider, 'price', true);
  echo (new SimpleSqlBuilder($filter->getProvider()))->getSql() . "\n";
