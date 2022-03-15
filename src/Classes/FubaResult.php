<?php

namespace PS\Source\Classes;

use PS\Source\BasicClasses\FubaResultBasic;
use PS\Source\Settings\Config;

/*
*   Logic can be implemented here that is not overwritten
*/

class FubaResult extends FubaResultBasic
{
    public function getLatestResult(int $teamID = null)
    {
        $output = [];
        if (is_null($teamID)) {
            foreach (Config::ARR_TEAMS as $tID) {
                $selfInstance = new self;
                $result = $selfInstance->add('teamNumber', $tID)->add('goalsAway', null, 'isNotNull')->orderBy('kickoff', 'DESC')->limit(1)->select();
                if (count($result)) {
                    $output[] = $result[0];
                }
            }
        }
        if ($teamID) {
            $result = $this->add('teamNumber', $teamID)->add('goalsAway', null, 'isNotNull')->orderBy('kickoff', 'DESC')->limit(1)->select()[0];
            $output[] = count($result) ? $result[0] : [];
        }
        return $output;
    }
}