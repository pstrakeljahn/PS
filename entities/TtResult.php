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
        'name' => 'pointsHome',
        'type' => 'int',
        'length' => 20,
        'required' => true
    ],
    [
        'name' => 'pointsAway',
        'type' => 'int',
        'length' => 20,
        'required' => true
    ],
    [
        'name' => 'league',
        'type' => 'varchar',
        'length' => 255,
        'required' => true
    ],
    [
        'name' => 'link',
        'type' => 'varchar',
        'length' => 255,
    ],
    [
        'name' => 'teamID',
        'type' => 'int',
        'length' => 11,
        'required' => true
    ]
];
