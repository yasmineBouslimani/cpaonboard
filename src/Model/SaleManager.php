<?php

namespace App\Model;

class SaleManager extends AbstractManager
{
    const TABLE = 'employee';

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

    public function selectEmployeeById(int $id): array
    {
        /**
         * Get an employee record in database.
         *
         * @return array
         */
        return $this->pdo->query(
            'SELECT employee.id_employee, contact.id_contact, contract.id_contract, employee.active, employee.employee_hr_id, employee.gender, employee.civility,
                contact.last_name, contact.first_name, employee.birth_date, employee.birth_place, employee.social_security_number, employee.department,
                employee.bank_name, employee.bank_city, employee.bank_iban, employee.bank_bic, employee.wage_ratio, employee.wage_hiring,
                contact.address_street_number, contact.address_street, contact.address_addition, contact.address_zip_code, contact.address_city,
                contact.phone_number, contact.cellphone_number, contact.personal_email_address, contract.type_contract, contract.starting_date,
                contract.end_date, contract.wage_first_year, contract.wage_second_year, contract.wage_third_year, contract.on_going 
            FROM employee
            LEFT JOIN contact ON employee.id_employee = contact.fk_id_employee2
            LEFT JOIN contract ON employee.id_employee = contract.fk_employee AND contract.on_going = TRUE
            WHERE id_employee = '.$id.';')->fetchAll();
    }

}