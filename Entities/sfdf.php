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
        'values' => ['aaa','bbb','ccc'],
        'required' => true
    ],
];