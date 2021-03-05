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
            'SELECT sale.id_sale, sale.status_sale, sale.date_sale, sale.to_deliver
            FROM sale
            WHERE id_sale = '.$id.';')->fetchAll();
    }

}