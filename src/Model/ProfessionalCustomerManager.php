<?php

namespace App\Model;

class ProfessionalCustomerManager extends AbstractManager
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

    public function countRecordsProfessionalCustomers(): array
    {
        /**
         * Get the number of individual customers records in database.
         *
         * @return array
         */
        return $this->pdo->query(
            'SELECT COUNT(*) AS countRecords FROM customer WHERE customer.FK_customerType = 2')->fetchAll();
    }

    public function selectProfessionalCustomersData(int $limit, int $offset): array
    {
        /**
         * Get all rows from customer and contact tables when criterion are meet.
         *
         * @return array
         */
        return $this->pdo->query(
            'SELECT customer.id_customer, contact.last_name, contact.first_name, contact.corporate_name, contact.phone_number,
                contact.cellphone_number, contact.professional_email_address FROM customer
            LEFT JOIN contact ON customer.id_customer = contact.fk_id_customer2
            WHERE customer.FK_customerType = 2
            ORDER BY contact.corporate_name ASC, contact.last_name ASC, contact.first_name ASC
            LIMIT '.$limit.' OFFSET '.$offset.';')->fetchAll();
    }

    public function selectProfessionalCustomers(): array
    {
        /**
         * Get all row from table Customers when customer type = professional for customers list.
         *
         * @return array
         */
        return $this->pdo->query(
            'SELECT customer.id_customer, customer.fk_customerType, customertype.id_customerType,
                customertype.label, contact.fk_id_customer2, CONCAT( contact.last_name, \' \' , contact.first_name) as contactIdentity,
                contact.corporate_name FROM customer
			LEFT JOIN contact ON contact.fk_id_customer2 = customer.id_customer
			LEFT JOIN customertype ON customertype.id_customertype = customer.fk_customerType
			WHERE customer.FK_customerType = 2
            ORDER BY contact.corporate_name ASC, contactIdentity ASC ;')->fetchAll();
    }

    public function selectProfessionalCustomerById(int $id): array
    {
        /**
         * Get an employee record in database.
         *
         * @return array
         */
        return $this->pdo->query(
            'SELECT customer.id_customer, contact.id_contact, contact.last_name, contact.first_name,
                contact.corporate_name, contact.address_street_number, contact.address_addition, contact.address_street,
                contact.address_zip_code, contact.address_city, contact.phone_number, contact.cellphone_number,
                contact.professional_email_address
            FROM customer
            LEFT JOIN contact ON customer.id_customer = contact.fk_id_customer2
            WHERE customer.id_customer =' . $id)->fetchAll();
    }

    public function selectVehiclesByCustomerId(int $id): array
    {
        /**
         * Get an employee record in database.
         *
         * @return array
         */
        return $this->pdo->query(
            'SELECT vehicle.id_vehicle , vehicle.manufacture_year, vehicle.license_plate, vehicle.fiscal_horse_power,
                vehicle.door_number, vehicle.energy_type, vehicle.gear_box_type, vehicle.fk_vehicleModel,
                customer_vehicle.fk_id_vehicle, customer_vehicle.fk_id_customer, vehiclemodel.model, vehiclemodel.make
            FROM customer_vehicle
            INNER JOIN vehicle ON vehicle.id_vehicle = customer_vehicle.fk_id_vehicle
            LEFT JOIN vehiclemodel ON vehiclemodel.id_vehicleModel = vehicle.fk_vehicleModel 
            WHERE customer_vehicle.fk_id_customer =' . $id)->fetchAll();
    }

}