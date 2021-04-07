<?php

namespace App\Model;

class AcquisitionManager extends AbstractManager
{
    public const TABLE = 'acquisition';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectLitigationsWithAcquisitionAndSaleWithLimit(int $limit, int $offset): array
    {
        return $this->pdo->query(
            "SELECT * FROM " . self::TABLE .
            " LEFT JOIN acquisition ON litigation.fk_acquisition = acquisition.id_acquisition
            LEFT JOIN sale  ON litigation.fk_sale = sale.id_sale
            LIMIT " . $limit . " OFFSET " . $offset)->fetchAll();
    }

    public function selectLitigationWithAcquisitionAndSaleById(int $id): array
    {
        /**
         * Get a product record in database.
         *
         * @return array
         */
        return $this->pdo->query(
            "SELECT * FROM " . self::TABLE .
            " LEFT JOIN acquisition ON litigation.fk_acquisition = acquisition.id_acquisition
            LEFT JOIN sale  ON litigation.fk_sale = sale.id_sale
            WHERE id_litigation = " . $id)->fetch();
    }

}