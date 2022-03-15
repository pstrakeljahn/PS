<?php

namespace PS\Source\Helper;

use PS\Source\Classes\VolleyballResult;
use PS\Source\Core\ExternalApiHelper\Connector;
use PS\Source\Core\Logging\Logging;

class FetchNwvvHelper
{

    public static function go($key, $season)
    {
        $arrData = self::getNwvvData($key, $season);

        foreach ($arrData as $data) {
            $homeTeam = $data['home'];
            $awayTeam = $data['away'];
            $kickoff = $data['date'];
            $pointsHome = $data['pointsHome'];
            $pointsAway = $data['pointsAway'];
            $sets = $data['sets'];
            $league = $data['league'];
            $link = $data['link'];
            $instanceResult = new VolleyballResult();
            if (is_null($kickoff) || is_null($sets)) {
                continue;
            }
            $result = $instanceResult->add('kickoff', $kickoff)->add('home', $homeTeam)->add('away', $awayTeam)->select();
            if (!count($result)) {
                self::createNewEntry($homeTeam, $awayTeam, $kickoff, $pointsHome, $pointsAway, $league, $sets, $link, $key);
            }
        }
    }

    private static function createNewEntry($homeTeam, $awayTeam, $kickoff, $pointsHome, $pointsAway, $league, $sets, $link, $key): void
    {
        // Create new db entry
        $data = new VolleyballResult();

        $data->setKickoff($kickoff)
            ->setHome($homeTeam)
            ->setAway($awayTeam)
            ->setPointsHome($pointsHome)
            ->setPointsAway($pointsAway)
            ->setLink($link)
            ->setLeague($league)
            ->setSets(!is_null($sets) ? implode(", ", $sets) : null)
            ->setTeamID($key)
            ->save();

        Logging::getInstance()->add(Logging::LOG_TYPE_EXTERNAL, 'New entry created - (' . $kickoff . ')_' . $homeTeam . '_' . $awayTeam, true);
    }

    private static function getNwvvData(int $key, string $season): array
    {
        $objApiConnector = new Connector();
        $response = $objApiConnector->setUrl('https://www.nwvv.de/popup/matchSeries/teamDetails.xhtml?teamId=' . $key)->getResponse();
        Logging::getInstance()->add(Logging::LOG_TYPE_EXTERNAL, 'Fetched data from nwvv Server (Team: ' . $key . ')');
        return self::prepareData($response, $season);
    }

    private static function prepareData(string $response, string $season): array
    {
         // Remove Tabs
         $string = trim(preg_replace('/\t+/', '', $response));

         // Get Dates
         preg_match_all(
             '/<span .*?>(.*?)<\/span>\n<\/td>/',
             $string,
             $arrDates
         );
         // Convert to usable date
         $dates = array();
         foreach ($arrDates[1] as $rawDate) {
             if ($rawDate === "Termin folgt") {
                 $dates[] = null;
             } else {
                 //This will possibly break someday
                 $trimedString = substr($rawDate, 26);
                 $dates[] = date('Y-m-d H:i:s', date_create_from_format('d.m.y H:i', $trimedString)->getTimestamp());
             }
         }
 
         // Get Teams
         preg_match_all(
             '/eries\/teamDetails\.xhtml\?teamId=(.*?)"><span class="preFormatted" style=".*">(.*?)<\/span><\/a>\n<\/td>\n\n<td class="textualTableCell">\n        \n        \n        <a href="popup\/matchSeries\/teamDetails\.xhtml\?teamId=(.*?)"><span class="preFormatted" style="">(.*?)<\/span><\/a>/',
             $string,
             $arrMatches
         );
 
         $stripedString = strip_tags($string);
         // Get Points
         preg_match_all(
             '/        (.*?):(.*?) \/ .*?:.*?/',
             $stripedString,
             $points
         );
 
         // Get Sets
         preg_match_all(
             '/        \((.*?)\)\n\n\n\n\n/',
             $stripedString,
             $sets
         );
 
         // Get Link
         preg_match_all(
             '/<span class="toolTipContent">Spieldetails\n        <\/span>\n    <\/span>\n    <\/span><\/a>\n        <a href="(.*?)" target="_blank">\n    <span class="actionIconContainer ">/',
             $string,
             $links
         );
 
         // Get League
         $season = str_replace('-', '\/20', $season);
         preg_match_all(
             '/<\/div>\n                <h1><span class="preLine">.*?<\/span>\n                <\/h1>\n                <strong>(.*?) ' . $season . '\n                <\/strong>/',
             $response,
             $league
         );
 
         $league = $league[1][0];
         $arrData = array();
 
         for ($i = 0; $i < count($arrMatches[0]); $i++) {
             $date = $dates[$i];
             $homeID = (int)$arrMatches[1][$i];
             $teamHome = $arrMatches[2][$i];
             $awayID = (int)$arrMatches[3][$i];
             $teamAway = $arrMatches[4][$i];
             if (isset($sets[1][$i])) {
                 $set = $sets[1][$i];
             } else {
                 $set = null;
             }
             if (isset($points[1][$i])) {
                 $pointsHome = $points[1][$i];
             } else {
                 $pointsHome = null;
             }
             if (isset($points[2][$i])) {
                 $pointsAway = $points[2][$i];
             } else {
                 $pointsAway = null;
             }
             if (isset($links[1][$i])) {
                 $link = $links[1][$i];
             } else {
                 $link = null;
             }

             $arrData[$i] = [
                 'date' => $date,
                 'homeID' => $homeID,
                 'home' => $teamHome,
                 'awayID' => $awayID,
                 'away' => $teamAway,
                 'pointsHome' => $pointsHome,
                 'pointsAway' => $pointsAway,
                 'league' => $league,
                 'sets' => explode(" ", $set),
                 'link' => $link
             ];
         }
 
         return $arrData;
    }
}
