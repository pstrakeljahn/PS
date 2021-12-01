How to use the entity-Builder:

    [
        'name'* => Attribute name,  can not be an int
        'type'* => Typ (int, varchar, bool, enum, datetime),
        'length'* => length,
        'required' => this attribute is necessary (bool)
        'values' => if enum: array of values
        'notnull' => not null (bool)

        // necessary for FKs
        'reference' => 'User',
        'ref_column' => 'ID',
        'ref_delete' => 'CASCADE',
        'ref_update' => 'CASCADE'
    ]

The information marked with * is required!