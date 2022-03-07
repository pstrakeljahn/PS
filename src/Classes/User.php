<?php

namespace PS\Source\Classes;

use PS\Source\BasicClasses\UserBasic;

/*
*   Logic can be implemented here that is not overwritten
*/

class User extends UserBasic
{
    public function savePre() {
        $this->setPassword(password_hash($this->getPassword(), PASSWORD_DEFAULT));
    }
}