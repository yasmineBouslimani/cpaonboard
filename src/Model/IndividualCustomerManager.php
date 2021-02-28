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
            'SELECT customer.id_customer, contact.last_name, contact.first_name, contact.phone_number,
                contact.cellphone_number, personal_email_address FROM customer
            LEFT JOIN contact ON customer.id_customer = contact.fk_id_customer2
            WHERE customer.FK_customerType = 1
            ORDER BY contact.last_name ASC, contact.first_name ASC
            LIMIT '.$limit.' OFFSET '.$offset.';')->fetchAll();
    }

    public function selectIndividualCustomerById(int $id): array
    {
        /**
         * Get an employee record in database.
         *
         * @return array
         */
        return $this->pdo->query(
            'SELECT customer.id_customer, contact.id_contact, contact.last_name, contact.first_name,
                contact.address_street_number, contact.address_addition, contact.address_street , contact.address_zip_code,
                contact.address_city, contact.phone_number, contact.cellphone_number, personal_email_address FROM customer
            LEFT JOIN contact ON customer.id_customer = contact.fk_id_customer2
            WHERE customer.id_customer =' . $id)->fetchAll();
    }

    public function selectVehiculesByCustomerId(int $id): array
    {
        /**
         * Get an employee record in database.
         *
         * @return array
         */
        return $this->pdo->query(
            'SELECT vehicle.id_vehicle , vehicle.manufacture_year, vehicle.license_plate, vehicle.fiscal_horse_power,
                vehicle.door_number, vehicle.fk_energyType, vehicle.fk_gearBoxType, vehicle.fk_vehicleModel,
                customer_vehicle.fk_id_vehicle, customer_vehicle.fk_id_customer, vehiclemodel.model, vehiclemodel.make
            FROM customer_vehicle
            INNER JOIN vehicle ON vehicle.id_vehicle = customer_vehicle.fk_id_vehicle
            INNER JOIN vehiclemodel ON vehiclemodel.id_vehicleModel = vehicle.fk_vehicleModel 
            WHERE customer_vehicle.fk_id_customer =' . $id)->fetchAll();
    }

}