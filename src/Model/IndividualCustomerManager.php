<?php

namespace App\Model;

class IndividualCustomerManager extends AbstractManager
{
    public const TABLE = 'customer';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * @param array $product
     * @return int
     */

    public function selectProductById(int $id): array
    {
        /**
         * Get a product record in database.
         *
         * @return array
         */
        return $this->pdo->query('SELECT product.label as product_label, product.price, product.stock,
            producttype.label as product_type_label, tva.ratio
            FROM product
            LEFT JOIN tva ON product.fk_tva = tva.id_tva
            LEFT JOIN producttype  ON product.fk_productType = producttype.id_productType
            WHERE id_product = '.$id.';')->fetchAll();
    }
}