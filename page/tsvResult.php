<?php

use PS\Source\Classes\FubaResult;
use PS\Source\Classes\TtResult;
use PS\Source\Classes\VolleyballResult;

header('Content-Type: application/json; charset=utf-8');

$instanceFuba = new FubaResult();
$instanceTT = new TtResult();
$instanceVolleyball = new VolleyballResult();

$results = [];

$resultsFuba = $instanceFuba->getLatestResult();
$resultsTT = $instanceTT->getLatestResult();
$resultVolleyBall = $instanceVolleyball->getLatestResult();

$results['football'] = $resultsFuba;
$results['tabletennis'] = $resultsTT;
$results['volleyball'] = $resultVolleyBall;

echo json_encode($results);
