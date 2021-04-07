<?php


namespace App\Model;


class ProductTypeManager extends AbstractManager
{
    const TABLE = 'producttype';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

}