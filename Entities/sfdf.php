<?php

//  Generates a Table and BasicClasses

return [
    [
        'name' => 'name',
        'type' => 'varchar',
        'length' => 255
    ],
    [
        'name' => 'randNumber',
        'type' => 'int',
        'length' => 20,
        'required' => true
    ],
    [
        'name' => 'sda',
        'type' => 'enum',
        'values' => ['aaa', 'bbb', 'ccc'],
        'required' => true
    ],
    [
        'name' => 'UserID',
        'type' => 'int',
        'length' => 11,
        'reference' => 'User',
        'ref_column' => 'ID',
        'ref_delete' => 'CASCADE',
        'ref_update' => 'CASCADE'
    ]
];
