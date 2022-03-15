<?php

use PS\Source\Classes\FubaResult;
use PS\Source\Classes\TtResult;
use PS\Source\Classes\VolleyballResult;

header('Content-Type: application/json; charset=utf-8');

$instanceFuba = new FubaResult();
$instanceTT = new TtResult();
$instanceVolleyball = new VolleyballResult();

$results = [];

$results['football'] = $instanceFuba->getLatestResult();
$results['tabletennis'] = $instanceTT->getLatestResult();
$results['volleyball'] = $instanceVolleyball->getLatestResult();

echo json_encode($results);
