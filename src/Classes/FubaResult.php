<?php

namespace PS\Source\Classes;

use PS\Source\BasicClasses\FubaResultBasic;
use PS\Source\Core\Database\DatabaseHelper;
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
                $result = $selfInstance->add(FubaResult::TEAMNUMBER, $tID)
                                    ->add(FubaResult::GOALSAWAY, null, DatabaseHelper::IS_NOT_NULL)
                                    ->orderBy(FubaResult::KICKOFF, 'DESC')
                                    ->limit(1)
                                    ->select();
                if (count($result)) {
                    $output[] = $result[0];
                }
            }
        }
        if ($teamID) {
            $result = $this->add(FubaResult::TEAMNUMBER, $tID)
                        ->add(FubaResult::GOALSAWAY, null, DatabaseHelper::IS_NOT_NULL)
                        ->orderBy(FubaResult::KICKOFF, 'DESC')
                        ->limit(1)
                        ->select();
            $output[] = count($result) ? $result[0] : [];
        }
        return $output;
    }
}