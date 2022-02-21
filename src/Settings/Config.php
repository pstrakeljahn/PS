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
}
