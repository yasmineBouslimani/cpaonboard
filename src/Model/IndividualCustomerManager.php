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

    public function countRecordsIndividualCustomers(): array
    {
        /**
         * Get the number of individual customers records in database.
         *
         * @return array
         */
        return $this->pdo->query(
            'SELECT COUNT(*) AS countRecords FROM customer WHERE customer.FK_customerType = 1')->fetchAll();
    }

    public function selectIndividualCustomersData(int $limit, int $offset): array
    {
        /**
         * Get all rows from customer and contact tables when criterion are meet.
         *
         * @return array
         */
        return $this->pdo->query(
            'SELECT customer.id_customer, contact.last_name, contact.first_name, 
            contact.phone_number, contact.cellphone_number, personal_email_address FROM customer
            LEFT JOIN contact ON customer.id_customer = contact.fk_id_customer2
            WHERE customer.FK_customerType = 1
            ORDER BY contact.last_name ASC, contact.first_name ASC
            LIMIT '.$limit.' OFFSET '.$offset.';')->fetchAll();
    }

}