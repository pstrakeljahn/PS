<?php

//  Generates a Table and BasicClasses

return [
    [
        'name' => 'UserID',
        'type' => 'int',
        'length' => 11,
        'reference' => 'User',
        'ref_column' => 'ID',
        'ref_delete' => 'CASCADE',
        'ref_update' => 'CASCADE',
        'required' => true
    ],
    [
        'name' => 'position',
        'type' => 'varchar',
        'length' => 255
    ],
    [
        'name' => 'number',
        'type' => 'int',
        'length' => 2
    ],
    [
        'name' => 'cash_punish',
        'type' => 'decimal',
        'range' => '5,2'
    ],
    [
        'name' => 'cash_beer',
        'type' => 'decimal',
        'range' => '5,2'
    ]
];
