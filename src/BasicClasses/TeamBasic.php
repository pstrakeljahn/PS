<?php

namespace PS\Source\BasicClasses;

use Exception;
use PS\Source\Classes\Team;
use PS\Source\Core\Database\DatabaseHelper;

class TeamBasic extends DatabaseHelper
{
    const ID = 'ID';
    const NAME = 'name';
    const TRAINER = 'trainer';
    const STAFF_CAPTAIN = 'staff_captain';
    const STAFF_CAPTAIN2 = 'staff_captain2';
    const STAFF_CASH = 'staff_cash';

    const REQUIRED_VALUES = ['name'];

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
		return new Team();
	}

    public function getName()
	{
		return $this->{'name'};
	}

	public function setName($val): self
	{
		$this->{'name'} = $val;
		return $this;
	}

    public function getTrainer()
	{
		return $this->{'trainer'};
	}

	public function setTrainer($val): self
	{
		$this->{'trainer'} = $val;
		return $this;
	}

    public function getStaff_captain()
	{
		return $this->{'staff_captain'};
	}

	public function setStaff_captain($val): self
	{
		$this->{'staff_captain'} = $val;
		return $this;
	}

    public function getStaff_captain2()
	{
		return $this->{'staff_captain2'};
	}

	public function setStaff_captain2($val): self
	{
		$this->{'staff_captain2'} = $val;
		return $this;
	}

    public function getStaff_cash()
	{
		return $this->{'staff_cash'};
	}

	public function setStaff_cash($val): self
	{
		$this->{'staff_cash'} = $val;
		return $this;
	}
}