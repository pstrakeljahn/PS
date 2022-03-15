<?php

namespace PS\Source\Settings;

class Config
{

    // AUTOLOADER CONFIG
    const PREFIX = 'PS\\Source\\';
    const BASE_DIR = __DIR__ . '/src/';

    // DATABASE CONNECTION
    const SERVERNAME = 'remotemysql.com';
    const USERNAME = 'IPmfcZfgac';
    const PASSWORD = 'vcXPRziApZ';
    const DATABASE = 'IPmfcZfgac';

    // JWT Configuration (exp in seconds / null is forever)
    const SECRET = "asjdfhkj&/(13asd";
    const EXPIRATION = "9999999999999";

    // FuPa Fetcher
    const LINK_PREFIX = "https://www.fupa.net/match/";
    const ARR_TEAMS = [1, 2, 3];

    // myTischtennis.de IDs
    const MYTT_CREDENTIALS = [
        'tsv_amin2019' => 'aaaa1111'
    ];
    const ARR_TEAMS_TT = [
        2519107,
        2521230,
        2524168,
        2521210,
        2518942,
        2519063,
        2519087
    ];

    // nwvv.de is using a unique season key. Has to be updated!
    const ARR_SEASONKEYS = [
        '2021-22' => 29341512
    ];
}
