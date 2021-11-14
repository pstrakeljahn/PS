How to use the entity-Builder:

    [
        'name'* => Attribute name,  can not be an int
        'type'* => Typ (int, varchar, bool, enum, datetime),
        'length'* => length,
        'required' => this attribute is necessary (bool)
        'values' => if enum: array of values
        'notnull' => not null (bool)
    ]

The information marked with * is required!