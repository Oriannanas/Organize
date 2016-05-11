<?php
/**
 * Created by PhpStorm.
 * User: marijn
 * Date: 14-3-16
 * Time: 18:01
 */

namespace Type;


class FieldType extends BaseType
{
    const FIELD_STRING = 'string';
    const FIELD_NUMBER = 'number';
    const FILED_FUNCTION = 'function';

    public function getTypes()
    {
        return array(
            self::FIELD_STRING,
            self::FIELD_NUMBER,
            self::FILED_FUNCTION
        );
    }
}