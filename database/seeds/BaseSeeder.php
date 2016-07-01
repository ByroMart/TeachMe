<?php

use Faker\Factory as Faker;
use Faker\Generator;
use Illuminate\Database\Seeder;

abstract class BaseSeeder extends Seeder{

    protected static $pool;

    protected $total = 50;

    abstract public function getModel();
    
    abstract public function getDummydata(Generator $faker,array $customValues = array());

    public function run()
    {
        $this->createMultiple($this->total);
    }

	public function createMultiple($total,array $customValues = array())
	{
		for($i = 0;$i <= $total;$i++)
		{
			$this->create();
		}
	}

	protected function create(array $customValues = array())
	{
		$faker = Faker::create();
		$values = $this->getDummydata($faker,$customValues);
		$values = array_merge($values,$customValues);
		return $this->addToPool($this->getModel()->create($values));
	}

    protected function createFrom($seeder,array $customValues = array())
    {
        $seeder = new $seeder;
        return $seeder->create($customValues);
    }

    protected function getRandom($model)
    {
        if(!isset(static::$pool[$model]))
        {
        	throw new Exception("Error Processing Request", 1);

        }
        return static::$pool[$model]->random();
    }

    protected function addToPool($entity)
    {
    	$reflection = new ReflectionClass($entity);
    	$class = $reflection->getShortName();
        if(!isset(static::$pool[$class]))
        {
            static::$pool[$class] = new \Illuminate\Database\Eloquent\Collection();
        }
        static::$pool[$class]->add($entity);
        return $entity;
    }


}