<?php

//  Generates a Table and BasicClasses

return [
    [
        'name' => 'username',
        'type' => 'varchar',
        'length' => 255,
        'required' => true,
        'unique' => true
    ],
    [
        'name' => 'password',
        'type' => 'varchar',
        'length' => 255,
        'required' => true
    ],
    [
        'name' => 'mail',
        'type' => 'varchar',
        'length' => 255,
        'required' => true
    ],
    [
        'name' => 'firstname',
        'type' => 'varchar',
        'length' => 255,
        'required' => true
    ],
    [
        'name' => 'surname',
        'type' => 'varchar',
        'length' => 255,
        'required' => true
    ],
    [
        'name' => 'dateofbirth',
        'type' => 'datetime',
        'length' => 255
    ],
    [
        'name' => 'street',
        'type' => 'varchar',
        'length' => 255
    ],
    [
        'name' => 'number',
        'type' => 'varchar',
        'length' => 255
    ],
    [
        'name' => 'zip',
        'type' => 'varchar',
        'length' => 255
    ],
    [
        'name' => 'city',
        'type' => 'varchar',
        'length' => 255
    ],
    [
        'name' => 'phone',
        'type' => 'varchar',
        'length' => 255
    ],
    [
        'name' => 'role',
        'type' => 'enum',
        'values' => ['admin', 'user'],
        'required' => true
    ]
];