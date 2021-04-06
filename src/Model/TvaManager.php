<?php


namespace App\Model;


class TvaManager extends AbstractManager
{
    const TABLE = 'tva';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

}