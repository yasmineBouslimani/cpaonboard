<?php

namespace App\Model;

class LitigationManager extends AbstractManager
{
    public const TABLE = 'litigation';

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

    public function selectLitigationByWords($words): array
    {
        $query = "SELECT * FROM " . $this->table .
            " LEFT JOIN acquisition ON litigation.fk_acquisition = acquisition.id_acquisition
            LEFT JOIN sale  ON litigation.fk_sale = sale.id_sale
             WHERE ";
        $conditions = [];
        foreach ($words as $val) {
            $conditions[] = "
            litigation.id_litigation LIKE '%" . $val . "%' 
            OR litigation.date_litigation LIKE '%" . $val . "%' 
            OR litigation.comment_litigation LIKE '%" . $val . "%'
            OR acquisition.global_price LIKE '%" . $val . "%' 
            OR sale.global_price_original LIKE '%" . $val . "%' 
            OR sale.status_sale LIKE '%" . $val . "%' 
            OR acquisition.status_acquisition LIKE '%" . $val . "%' 
            ";
        }
        $query .= implode(' AND ', $conditions);
        $query .= "GROUP BY litigation.id_litigation
            ORDER BY litigation.id_litigation DESC;";

        $statement = $this->pdo->prepare($query);

        $statement->execute();

        return $statement->fetchAll();
    }


}