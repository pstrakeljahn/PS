<?php

namespace PS\Source\BasicClasses;

use Exception;
use PS\Source\Classes\Player;
use PS\Source\Core\Database\DatabaseHelper;

class PlayerBasic extends DatabaseHelper
{
    const ID = 'ID';
    const USERID = 'UserID';
    const POSITION = 'position';
    const NUMBER = 'number';
    const CASH_PUNISH = 'cash_punish';
    const CASH_BEER = 'cash_beer';

    const REQUIRED_VALUES = ['UserID'];

    public function __construct()
    {
        $entityPath = __DIR__.'/../../entities/' . self::getClassName() . '.php';
        if (!file_exists($entityPath)) {
            throw new Exception('Cannot instantiate class! Entity file missing.');
        }
        $entity = include($entityPath);
        // ID IS HARDCODED!
        $this->{'ID'} = null;
        foreach ($entity as $column) {
            $this->{$column['name']} = null;
        }
    }
    
	public static function getInstance() {
		return new Player();
	}

    public function getUserID()
	{
		return $this->{'UserID'};
	}

	public function setUserID($val): self
	{
		$this->{'UserID'} = $val;
		return $this;
	}

    public function getPosition()
	{
		return $this->{'position'};
	}

	public function setPosition($val): self
	{
		$this->{'position'} = $val;
		return $this;
	}

    public function getNumber()
	{
		return $this->{'number'};
	}

	public function setNumber($val): self
	{
		$this->{'number'} = $val;
		return $this;
	}

    public function getCash_punish()
	{
		return $this->{'cash_punish'};
	}

	public function setCash_punish($val): self
	{
		$this->{'cash_punish'} = $val;
		return $this;
	}

    public function getCash_beer()
	{
		return $this->{'cash_beer'};
	}

	public function setCash_beer($val): self
	{
		$this->{'cash_beer'} = $val;
		return $this;
	}
}