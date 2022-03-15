<?php

namespace PS\Source\Classes;

use PS\Source\BasicClasses\VolleyballResultBasic;
use PS\Source\Settings\Config;

/*
*   Logic can be implemented here that is not overwritten
*/

class VolleyballResult extends VolleyballResultBasic
{
    public function getLatestResult(array $teamIDs = [])
    {
        $output = [];
        if (!count($teamIDs)) {
            foreach (array_values(Config::ARR_SEASONKEYS) as $tID) {
                $selfInstance = new self;
                $result = $selfInstance->add('teamID', $tID)->orderBy('kickoff', 'DESC')->limit(1)->select();
                if (count($result)) {
                    $output[] = $result[0];
                }
            }
        }
        if (count($teamIDs)) {
            foreach ($teamIDs as $teamID) {
                $selfInstance = new self;
                $result = $selfInstance->add('teamID', $teamID)->orderBy('kickoff', 'DESC')->limit(1)->select();
                $output[] = count($result) ? $result[0] : [];
            }
        }
        return $output;
    }
}