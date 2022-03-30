<?php

namespace PS\Source\Settings;

class Config
{

    // AUTOLOADER CONFIG
    const PREFIX = 'PS\\Source\\';
    const BASE_DIR = __DIR__ . '/src/';

    // DATABASE CONNECTION
    const SERVERNAME = '';
    const USERNAME = '';
    const PASSWORD = '';
    const DATABASE = '';

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


    // Mail Server information
    const MAIL_SENDER = "TSV Venne von 1928 e.V.";
    const MAIL_HOST = "smtp.ionos.de";
    const MAIL_PORT = "25";
    const MAIL_USERNAME = "";
    const MAIL_PASSWORD = "";

    // TSV register
    const REGISTER_MAIL = '';
    const REGISTER_SUBJECT_INTERNAL = 'Neues Mitglied';
    const REGISTER_SUBJECT_EXTERNAL = 'Willkommen im TSV Venne';
}
