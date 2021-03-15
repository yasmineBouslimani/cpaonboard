<?php

namespace App\Model;

class ProductManager extends AbstractManager
{
    public const TABLE = 'product';

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
        return $this->pdo->query('SELECT * FROM product
            LEFT JOIN producttype ON product.fk_productType = producttype.id_productType
            WHERE id_product = ' . $id . ';')->fetchAll();
    }

    public function selectProductsWithTypeAndDependancyAndTvaWithLimit(int $limit, int $offset): array
    {
        return $this->pdo->query(
            "SELECT * FROM " . self::TABLE .
            " LEFT JOIN tva ON product.fk_tva = tva.id_tva
            LEFT JOIN producttype  ON product.fk_productType = producttype.id_productType
            LIMIT " . $limit . " OFFSET " . $offset)->fetchAll();
    }

    public function selectProductsWithTypeAndDependancyAndTva(): array
    {
        return $this->pdo->query(
            "SELECT * FROM " . self::TABLE .
            " LEFT JOIN tva ON product.fk_tva = tva.id_tva
            LEFT JOIN producttype  ON product.fk_productType = producttype.id_productType")
            ->fetchAll();
    }

    public function selectProductsWithTypeAndDependancyAndTvaByd(int $id): array
    {
        return $this->pdo->query(
            " SELECT * FROM " . self::TABLE .
            " LEFT JOIN tva ON product.fk_tva = tva.id_tva
            LEFT JOIN producttype  ON product.fk_productType = producttype.id_productType
            WHERE product.id_product =" . $id)->fetchAll();
    }


    public function selectProductByWord($words): array
    {
        $query = "SELECT * FROM " . self::TABLE .
            " WHERE ";
        $conditions = [];
        foreach ($words as $val) {
            $conditions[] = "
            product.label LIKE '%" . $val . "%' 
            OR product.id_product LIKE '%" . $val . "%' 
            OR product.comment_product LIKE '%" . $val . "%'
            ";
        }
        $query .= implode(' AND ', $conditions);
        $query .= "GROUP BY product.id_product
            ORDER BY product.id_product DESC;";

        $statement = $this->pdo->prepare($query);

        $statement->execute();

        return $statement->fetchAll();
    }

    public function getProductInformationsForPriceComputation(int $id): array
    {
        /**
         * Get needed informations  by product for compute price.
         *
         * @param int product id
         * @return array
         */
        return $this->pdo->query(
            'SELECT product.price, product.fk_tva, tva.id_tva, tva.ratio
            FROM product
            LEFT JOIN tva ON tva.id_tva = product.fk_tva
            WHERE id_product = ' . $id . ';')->fetchAll();
    }
}