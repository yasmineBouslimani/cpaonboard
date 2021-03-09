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

    public function selectProductWithTypeAndDependancyAndTvaByd(int $id): array
    {
        return $this->pdo->query(
            " SELECT * FROM " . self::TABLE .
            " LEFT JOIN tva ON product.fk_tva = tva.id_tva
            LEFT JOIN producttype  ON product.fk_productType = producttype.id_productType
            WHERE product.id_product =" . $id)->fetchAll();
    }


    public function selectProductByWord($words): array
    {
        $query = "SELECT * FROM " . $this->table .
  " LEFT JOIN tva ON product.fk_tva = tva.id_tva
            LEFT JOIN producttype  ON product.fk_productType = producttype.id_productType

             WHERE ";
        $conditions = [];
        foreach ($words as $val) {
            $conditions[] = "
            product.label LIKE '%" . $val . "%' 
            OR product.id_product LIKE '%" . $val . "%' 
            OR product.comment_product LIKE '%" . $val . "%'
            OR producttype.type LIKE '%" . $val . "%' 
            ";
        }
        $query .= implode(' AND ', $conditions);
        $query .= "GROUP BY product.id_product
            ORDER BY product.id_product DESC;";

        $statement = $this->pdo->prepare($query);

        $statement->execute();

        return $statement->fetchAll();
    }


    public function updateProduct(array $product):bool
    {
        $statement = $this->pdo->prepare("UPDATE $this->table SET `label` = :label, 
        `stock` = :stock, `price` = :price, `comment_product` = :comment_product,
         `fk_productType` = :fk_productType, `fk_tva` = :fk_tva WHERE id_product=:id_product");
        $statement->bindValue('id_product', $product['id_product'], \PDO::PARAM_INT);
        $statement->bindValue('label', $product['label'], \PDO::PARAM_STR);
        $statement->bindValue('stock', $product['stock'], \PDO::PARAM_INT);
        $statement->bindValue('price', $product['price'], \PDO::PARAM_INT);
        $statement->bindValue('comment_product', $product['comment_product'], \PDO::PARAM_STR);
        $statement->bindValue('fk_productType', $product['fk_productType'], \PDO::PARAM_INT);
        $statement->bindValue('fk_tva', $product['fk_tva'], \PDO::PARAM_INT);
        return $statement->execute();
    }

}