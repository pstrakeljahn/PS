<?php

use PS\Source\Helper\FetchFupaDataHelper;
use PS\Source\Helper\FetchMyTischtennisHelper;
use PS\Source\Helper\FetchNwvvHelper;
use PS\Source\Settings\Config;

require_once __DIR__ . '/autoload.php';

// Fetch Fupa Data
foreach(Config::ARR_TEAMS as $teamID) {
    $fupa = new FetchFupaDataHelper();
    $fupa->go($teamID);
}

// Fetch NWVV Data
foreach(Config::ARR_SEASONKEYS as $season => $key) {
    $nwvv = new FetchNwvvHelper();
    $nwvv->go($key, $season);
}

// Fetch NWVV Data
foreach(Config::ARR_TEAMS_TT as $key) {
    $nwvv = new FetchMyTischtennisHelper();
    $nwvv->go($key);
}
die();
