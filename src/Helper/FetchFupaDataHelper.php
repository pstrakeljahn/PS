<?php

namespace PS\Source\Helper;

use DateTime;
use PS\Source\Classes\FubaResult;
use PS\Source\Core\ExternalApiHelper\Connector;
use PS\Source\Core\Logging\Logging;
use PS\Source\Settings\Config;

class FetchFupaDataHelper
{

    public static function go(int $team)
    {
        // Needed to create sesson string
        $month = (int)date('m');
        $year = (int)date("Y");
        if ($month > 8) {
            $season = $year . '-' . substr(strval($year + 1), 2);
        } else {
            $season = strval($year - 1) . '-' . substr($year, 2);
        }

        $date = new DateTime();

        $arrMatchData = self::getExternalData($team, $season);

        foreach ($arrMatchData as $match) {
            $homeTeam = $match['homeTeam']['name']['full'] . self::levelConvert($match['homeTeam']['level']);
            $awayTeam = $match['awayTeam']['name']['full'] . self::levelConvert($match['awayTeam']['level']);
            $kickoff = $date->setTimestamp(strtotime($match['kickoff']))->format('Y-m-d H:i:s');
            $homeGoal = $match['homeGoal'];
            $awayGoal = $match['awayGoal'];
            $slug = $match['slug'];
            $league = $match['competition']['name'];
            $instanceResult = new FubaResult();
            $result = $instanceResult->add('kickoff', $kickoff)->add('home', $homeTeam)->add('away', $awayTeam)->select();
            if (!count($result)) {
                self::createNewEntry($homeTeam, $awayTeam, $kickoff, $homeGoal, $awayGoal, $team, $slug, $league);
                continue;
            }
            if ($result && is_null($result[0]->getGoalsHome()) && is_null($result[0]->getGoalsAway()) && !is_null($homeGoal) && !is_null($awayGoal)) {
                $instanceResult = new FubaResult();
                $data = $instanceResult->getByPK($result[0]->getID());
                $data->setGoalsHome($homeGoal)->setGoalsAway($awayGoal)->save();
                Logging::getInstance()->add(Logging::LOG_TYPE_EXTERNAL, 'Entry with ID ' . $result[0]->getID() . ' updated - ' . $homeGoal . ':' . $awayGoal, true);
            }
        }
    }

    private static function createNewEntry(string $home, string $away, string $kickoff, $homeGoal, $awayGoal, int $team, string $slug, string $league): void
    {
        // Create new db entry
        $data = new FubaResult();

        $data->setKickoff($kickoff)
            ->setHome($home)
            ->setAway($away)
            ->setGoalsHome($homeGoal)
            ->setGoalsAway($awayGoal)
            ->setTeamNumber($team)
            ->setLink(Config::LINK_PREFIX . $slug)
            ->setLeague($league)
            ->save();

        Logging::getInstance()->add(Logging::LOG_TYPE_EXTERNAL, 'New entry created - (' . $kickoff . ')_' . $home . '_' . $away, true);
    }

    private static function getExternalData($team, $season): array
    {
        $objApiConnector = new Connector();
        $response = $objApiConnector->setUrl('https://api.fupa.net/v1/teams/tsv-venne-m' . $team . '-' . $season . '/matches')->getResponse();
        return json_decode($response, true);
    }

    private static function levelConvert($number): string
    {
        // First Team does not get an roman number
        if ($number === 1) {
            return '';
        }
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if ($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return ' ' . $returnValue;
    }
}
