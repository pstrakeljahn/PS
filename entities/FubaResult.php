<?php

//  Generates a Table and BasicClasses

return [
    [
        'name' => 'kickoff',
        'type' => 'datetime',
        'required' => true,
        'notnull' => true
    ],
    [
        'name' => 'home',
        'type' => 'varchar',
        'length' => 255,
        'required' => true,
        'notnull' => true
    ],
    [
        'name' => 'away',
        'type' => 'varchar',
        'length' => 255,
        'required' => true,
        'notnull' => true
    ],
    [
        'name' => 'goalsHome',
        'type' => 'int',
        'length' => 20
    ],
    [
        'name' => 'goalsAway',
        'type' => 'int',
        'length' => 20
    ],
    [
        'name' => 'teamNumber',
        'type' => 'int',
        'length' => 20,
        'required' => true,
        'notnull' => true
    ],
    [
        'name' => 'link',
        'type' => 'varchar',
        'length' => 255,
        'required' => true,
        'notnull' => true
    ],
    [
        'name' => 'league',
        'type' => 'varchar',
        'length' => 255,
        'required' => true
    ]
];