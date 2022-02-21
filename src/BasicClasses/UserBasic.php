<?php

namespace PS\Source\BasicClasses;

use Exception;
use PS\Source\Core\DB;

class UserBasic extends DB
{
    const ID = 'ID';
    const USERNAME = 'username';
    const PASSWORD = 'password';
    const MAIL = 'mail';
    const FIRSTNAME = 'firstname';
    const SURNAME = 'surname';
    const DATEOFBIRTH = 'dateofbirth';
    const STREET = 'street';
    const NUMBER = 'number';
    const ZIP = 'zip';
    const CITY = 'city';
    const PHONE = 'phone';
    const ROLE = 'role';
    const ENUM_ROLE_ADMIN = 'admin';
    const ENUM_ROLE_USER = 'user';

    const REQUIRED_VALUES = ['username', 'password', 'mail', 'firstname', 'surname', 'role'];

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

    public function getUsername()
	{
		return $this->{'username'};
	}

	public function setUsername($val): self
	{
		$this->{'username'} = $val;
		return $this;
	}

    public function getPassword()
	{
		return $this->{'password'};
	}

	public function setPassword($val): self
	{
		$this->{'password'} = $val;
		return $this;
	}

    public function getMail()
	{
		return $this->{'mail'};
	}

	public function setMail($val): self
	{
		$this->{'mail'} = $val;
		return $this;
	}

    public function getFirstname()
	{
		return $this->{'firstname'};
	}

	public function setFirstname($val): self
	{
		$this->{'firstname'} = $val;
		return $this;
	}

    public function getSurname()
	{
		return $this->{'surname'};
	}

	public function setSurname($val): self
	{
		$this->{'surname'} = $val;
		return $this;
	}

    public function getDateofbirth()
	{
		return $this->{'dateofbirth'};
	}

	public function setDateofbirth($val): self
	{
		$this->{'dateofbirth'} = $val;
		return $this;
	}

    public function getStreet()
	{
		return $this->{'street'};
	}

	public function setStreet($val): self
	{
		$this->{'street'} = $val;
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

    public function getZip()
	{
		return $this->{'zip'};
	}

	public function setZip($val): self
	{
		$this->{'zip'} = $val;
		return $this;
	}

    public function getCity()
	{
		return $this->{'city'};
	}

	public function setCity($val): self
	{
		$this->{'city'} = $val;
		return $this;
	}

    public function getPhone()
	{
		return $this->{'phone'};
	}

	public function setPhone($val): self
	{
		$this->{'phone'} = $val;
		return $this;
	}

    public function getRole()
	{
		return $this->{'role'};
	}

	public function setRole($val): self
	{
		$this->{'role'} = $val;
		return $this;
	}
}