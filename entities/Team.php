<?php

//  Generates a Table and BasicClasses

return [
    [
        'name' => 'name',
        'type' => 'varchar',
        'length' => 255,
        'required' => true
    ],
    [
        'name' => 'trainer',
        'type' => 'int',
        'length' => 11,
        'reference' => 'User',
        'ref_column' => 'ID',
        'ref_delete' => 'CASCADE',
        'ref_update' => 'CASCADE'
    ],
    [
        'name' => 'cash',
        'type' => 'decimal',
        'range' => '5,2',
        'virtual' => true
    ],
    [
        'name' => 'staff_captain',
        'type' => 'int',
        'length' => 11,
        'reference' => 'User',
        'ref_column' => 'ID',
        'ref_delete' => 'CASCADE',
        'ref_update' => 'CASCADE'
    ],
    [
        'name' => 'staff_captain2',
        'type' => 'int',
        'length' => 11,
        'reference' => 'User',
        'ref_column' => 'ID',
        'ref_delete' => 'CASCADE',
        'ref_update' => 'CASCADE'
    ],
    [
        'name' => 'staff_cash',
        'type' => 'int',
        'length' => 11,
        'reference' => 'User',
        'ref_column' => 'ID',
        'ref_delete' => 'CASCADE',
        'ref_update' => 'CASCADE'
    ]
];
