<?php

namespace PS\Source\BasicClasses;

use Exception;
use PS\Source\Classes\TtResult;
use PS\Source\Core\Database\DatabaseHelper;

class TtResultBasic extends DatabaseHelper
{
    const ID = 'ID';
    const KICKOFF = 'kickoff';
    const HOME = 'home';
    const AWAY = 'away';
    const POINTSHOME = 'pointsHome';
    const POINTSAWAY = 'pointsAway';
    const LEAGUE = 'league';
    const LINK = 'link';
    const TEAMID = 'teamID';

    const REQUIRED_VALUES = ['kickoff', 'home', 'away', 'pointsHome', 'pointsAway', 'league', 'teamID'];

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
		return new TtResult();
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

    public function getPointsHome()
	{
		return $this->{'pointsHome'};
	}

	public function setPointsHome($val): self
	{
		$this->{'pointsHome'} = $val;
		return $this;
	}

    public function getPointsAway()
	{
		return $this->{'pointsAway'};
	}

	public function setPointsAway($val): self
	{
		$this->{'pointsAway'} = $val;
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

    public function getLink()
	{
		return $this->{'link'};
	}

	public function setLink($val): self
	{
		$this->{'link'} = $val;
		return $this;
	}

    public function getTeamID()
	{
		return $this->{'teamID'};
	}

	public function setTeamID($val): self
	{
		$this->{'teamID'} = $val;
		return $this;
	}
}