<?php

namespace PS\Source\BasicClasses;

use Exception;
use PS\Source\Core\ORM;

class SfdfBasic extends ORM {

    const REQUIRED_VALUES = ['randNumber', 'sda'];
    
    public function __construct() {
        if(!file_exists('./entities/'.self::getClassName().'.php')){
            throw new Exception('Cannot instantiate class! Entity file missing.');
        }
        $entity = include('./entities/'.self::getClassName().'.php');
        // ID IS HARDCODED!
        $this->{'ID'} = null;
        foreach($entity as $column){
            $this->{$column['name']} = null;
        }
    }

    public function getID() {
		return $this->{'ID'};
	}

    public function getName() {
		return $this->{'name'};
	}

	public function setName($val): self
	{
		$this->{'name'} = $val;
		return $this;
	}

    public function getRandNumber() {
		return $this->{'randNumber'};
	}

	public function setRandNumber($val): self
	{
		$this->{'randNumber'} = $val;
		return $this;
	}

    public function getSda() {
		return $this->{'sda'};
	}

	public function setSda($val): self
	{
		$this->{'sda'} = $val;
		return $this;
	}
}