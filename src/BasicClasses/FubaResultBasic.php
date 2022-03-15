<?php

namespace PS\Source\BasicClasses;

use Exception;
use PS\Source\Classes\FubaResult;
use PS\Source\Core\Database\DatabaseHelper;

class FubaResultBasic extends DatabaseHelper
{
    const ID = 'ID';
    const KICKOFF = 'kickoff';
    const HOME = 'home';
    const AWAY = 'away';
    const GOALSHOME = 'goalsHome';
    const GOALSAWAY = 'goalsAway';
    const TEAMNUMBER = 'teamNumber';
    const LINK = 'link';
    const LEAGUE = 'league';

    const REQUIRED_VALUES = ['kickoff', 'home', 'away', 'teamNumber', 'link', 'league'];

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
		return new FubaResult();
	}

    public function getKickoff()
	{
		return $this->{'kickoff'};
	}

	public function setKickoff($val): self
	{
		$this->{'kickoff'} = $val;
		return $this;
	}

    public function getHome()
	{
		return $this->{'home'};
	}

	public function setHome($val): self
	{
		$this->{'home'} = $val;
		return $this;
	}

    public function getAway()
	{
		return $this->{'away'};
	}

	public function setAway($val): self
	{
		$this->{'away'} = $val;
		return $this;
	}

    public function getGoalsHome()
	{
		return $this->{'goalsHome'};
	}

	public function setGoalsHome($val): self
	{
		$this->{'goalsHome'} = $val;
		return $this;
	}

    public function getGoalsAway()
	{
		return $this->{'goalsAway'};
	}

	public function setGoalsAway($val): self
	{
		$this->{'goalsAway'} = $val;
		return $this;
	}

    public function getTeamNumber()
	{
		return $this->{'teamNumber'};
	}

	public function setTeamNumber($val): self
	{
		$this->{'teamNumber'} = $val;
		return $this;
	}

    public function getLink()
	{
		return $this->{'link'};
	}

	public function setLink($val): self
	{
		$this->{'link'} = $val;
		return $this;
	}

    public function getLeague()
	{
		return $this->{'league'};
	}

	public function setLeague($val): self
	{
		$this->{'league'} = $val;
		return $this;
	}
}