<?php

namespace App\Model;

class SaleManager extends AbstractManager
{
    const TABLE = 'sale';

    public function __construct()
    {
        /**
         *  Initializes this class.
         */
        parent::__construct(self::TABLE);
    }


    public function selectSalesAndAssociatedData(int $limit, int $offset): array
    {
        /**
         * Get all row from table sales when criterion are meet.
         *
         * @return array
         */
        return $this->pdo->query(
            'SELECT sale.id_sale, sale.status_sale, sale.date_sale, sale.fk_customer, sale.global_price_original,
                customer.id_customer, customer.fk_customerType, customertype.id_customerType,
                customertype.label, contact.last_name, contact.fk_id_customer2,
                contact.first_name, contact.corporate_name FROM sale
            LEFT JOIN customer ON customer.id_customer = sale.fk_customer
            LEFT JOIN customertype ON customertype.id_customertype = customer.fk_customerType 
			LEFT JOIN contact ON contact.fk_id_customer2 = customer.id_customer
            LIMIT '.$limit.' OFFSET '.$offset.';')->fetchAll();
    }

    public function selectSaleById(int $id): array
    {
        /**
         * Get a sale record in database.
         *
         * @return array
         */
        return $this->pdo->query(
            'SELECT sale.id_sale, sale.status_sale, sale.date_sale, sale.to_deliver, 
                sale.global_price_original, sale.discount_percentage, sale.global_price_finalised
            FROM sale
            WHERE id_sale = '.$id.';')->fetchAll();
    }

    public function selectProductsForSale(int $id=Null): array
    {
        /**
         * Get all row from table product and product_sale when criterion are meet.
         *
         * @return array
         */
        return $this->pdo->query(
            'SELECT product_sale.quantity, product_sale.discount_percentage, product_sale.finalised_price,
                product_sale.fk_id_sale, product.id_product, product.label, product.stock, product.price, product.fk_tva,
                producttype.type, tva.id_tva, tva.ratio
            FROM product
            LEFT JOIN product_sale ON product_sale.fk_id_product = 
                (SELECT product.id_product 
                WHERE product_sale.fk_id_product=product.id_product AND product_sale.fk_id_sale = '.$id.')
            LEFT JOIN producttype ON producttype.id_producttype = product.fk_productType
            LEFT JOIN tva ON tva.id_tva = product.fk_tva
            ORDER BY producttype.type ASC, product.price ASC, product.label ASC ;')->fetchAll();
    }

    public function selectProductsForSaleByProductAndSaleId(int $fkIdProduct, int $fkIdSale): array
    {
        /**
         * Get record by sale and product id in product_sale table.
         *
         * @return array
         */
        return $this->pdo->query(
            'SELECT product_sale.fk_id_product , product_sale.fk_id_sale
            FROM product_sale
            WHERE fk_id_product = '. $fkIdProduct .' AND `fk_id_sale`='. $fkIdSale . ';')->fetchAll();
    }
}