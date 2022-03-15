<?php

namespace PS\Source\Helper;

use PS\Source\Classes\TtResult;
use PS\Source\Core\ExternalApiHelper\Connector;
use PS\Source\Core\Logging\Logging;
use PS\Source\Settings\Config;

class FetchMyTischtennisHelper
{
    public static function go($teamID): void
    {
        $arrData = self::getMatchesByTeamID($teamID);

        foreach ($arrData as $data) {
            $homeTeam = $data['home'];
            $awayTeam = $data['away'];
            $kickoff = $data['date'];
            $pointsHome = $data['pointsHome'];
            $pointsAway = $data['pointsAway'];
            $league = $data['league'];
            $instanceResult = new TtResult();
            $result = $instanceResult->add('kickoff', $kickoff)->add('home', $homeTeam)->add('away', $awayTeam)->select();
            if (!count($result)) {
                self::createNewEntry($homeTeam, $awayTeam, $kickoff, $pointsHome, $pointsAway, $league, $teamID, $teamID);
            }
        }
    }

    private static function createNewEntry(string $home, string $away, string $kickoff, $pointsHome, $pointsAway, string $league, int $teamID): void
    {
        // Create new db entry
        $data = new TtResult();

        $data->setKickoff($kickoff)
            ->setHome($home)
            ->setAway($away)
            ->setPointsHome($pointsHome)
            ->setPointsAway($pointsAway)
            ->setLeague($league)
            ->setTeamID($teamID)
            ->save();

        Logging::getInstance()->add(Logging::LOG_TYPE_EXTERNAL, 'New entry created - (' . $kickoff . ')_' . $home . '_' . $away, true);
    }

    public static function getMatchesByTeamID(int $teamID): array
    {
        self::getHeaderToken();

        $objApiConnector = new Connector();
        $response = $objApiConnector->setUrl('https://www.mytischtennis.de/community/team?teamId=' . $teamID)
            ->setCookie(self::getCookiePath())
            ->getResponse();
        Logging::getInstance()->add(Logging::LOG_TYPE_EXTERNAL, 'Fetched data from myTischtennis Server (Team: ' . $teamID . ')');

        if(!self::loggedIn($response)){
            Logging::getInstance()->add(Logging::LOG_TYPE_EXTERNAL, 'Token might be exceeded.', true);
            unlink(self::getCookiePath());
            return array();
        }
        return self::prepareData($response);

    }

    private static function getHeaderToken(): void
    {
        // If cookie is not older than 5 minutes do nothing
        if (time() - filemtime(self::getCookiePath()) < 3000) {
            return;
        }
        unlink(self::getCookiePath());
        $objApiConnector = new Connector();
        $payload = [
            'userNameB' => array_keys(Config::MYTT_CREDENTIALS)[0],
            'userPassWordB' => array_values(Config::MYTT_CREDENTIALS)[0],
            'targetPage' => 'https://www.mytischtennis.de/public/home?fromlogin=1'
        ];

        $objApiConnector->setUrl('https://www.mytischtennis.de/community/login/')
            ->setPostfields($payload)
            ->setSaveCookie(self::getCookiePath())
            ->getResponse();

        Logging::getInstance()->add(Logging::LOG_TYPE_EXTERNAL, 'Sesion Cookie saved', true);
    }

    private static function getCookiePath(): string
    {
        return dirname(__FILE__) . '/cookie.txt';
    }

    private static function loggedIn($response): bool
    {
        preg_match_all(
            '/Passwort vergessen\?<\/a><br\/>\n<a href="\/community\/register\/" class="reg" title="Registrieren">Registrieren/',
            $response,
            $loginCheck
        );

        if (count($loginCheck[0])) {
            return false;
        }
        return true;
    }

    private static function prepareData(string $response): array
    {
        // Get League
        preg_match_all(
            '/<a href="group\?groupId=.*?">\n(.*?)\n<\/a>/',
            $response,
            $league
        );

        // Get matches
        preg_match_all(
            '/([0-3][0-9][\/.][0-3][0-9][\/.](?:[0-9][0-9])?[0-9][0-9])\n<\/span>\n<span class="visible-xs">\n[0-3][0-9][\/.][0-3][0-9]\n<\/span>\n([0-2][0-9][\/:][0-5][0-9])\n<span class="hidden-xs">&nbsp;Uhr<\/span>\n<\/td>\n<td class="hidden-xs">\n<a href="http:\/\/www\.mytischtennis\.de\/\/community\/team\/community\/team\?teamid=(.*?)">\n(.*?)\n<\/a>\n<\/td>\n<td class="hidden-xs">\n<a href="http:\/\/www\.mytischtennis\.de\/\/community\/team\/community\/team\?teamid=(.*?)">\n(.*?)\n<\/a>/',
            $response,
            $matches
        );

        // Get Results
        preg_match_all(
            '/\n(.*?)&nbsp;:&nbsp;(.*?)<\/a/',
            $response,
            $results
        );

        $arrData = [];
        for ($i = 0; $i < count($matches[0]); $i++) {
            $date = date_create_from_format('d.m.y H:i', $matches[1][$i] . ' ' . $matches[2][$i]);
            $homeID = (int)$matches[3][$i];
            $teamHome = $matches[4][$i];
            $awayID = (int)$matches[5][$i];
            $teamAway = $matches[6][$i];
            $pointsHome = (int)$results[1][$i];
            $pointsAway = (int)$results[2][$i];

            if ($pointsHome === 0 && $pointsAway === 0) {
                continue;
            }

            $arrData[$i] = [
                'date' => date('Y-m-d H:i:s', $date->getTimestamp()),
                'homeID' => $homeID,
                'home' => $teamHome,
                'awayID' => $awayID,
                'away' => $teamAway,
                'pointsHome' => $pointsHome,
                'pointsAway' => $pointsAway,
                'league' => $league[1][0]
            ];
        }

        return $arrData;
    }
}
