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
        return $this->pdo->query('SELECT product.label as product_label, product.price, product.stock,
            producttype.label as product_type_label, tva.ratio
            FROM product
            LEFT JOIN tva ON product.fk_tva = tva.id_tva
            LEFT JOIN producttype  ON product.fk_productType = producttype.id_productType
            WHERE id_product = '.$id.';')->fetchAll();
    }

    public function insert(array $product): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`title`) VALUES (:title)");
        $statement->bindValue('title', $product['title'], \PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }


    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }


    /**
     * @param array $product
     * @return bool
     */
    public function update(array $product): bool
    {
        // prepared request
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `title` = :title WHERE id=:id");
        $statement->bindValue('id', $product['id'], \PDO::PARAM_INT);
        $statement->bindValue('title', $product['title'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}