<?php

namespace App\Controller;

use App\Model\ProfessionalCustomerManager;
use App\Model\IndividualCustomerManager;
use App\Model\ProductManager;
use App\Model\SaleManager;

class SaleController extends AbstractController
{
    public function index(int $currentPage=1)
    {
        /**
         * Display sales listing
         */
        /*if ($_SESSION['is_admin'] == "1") {
            header('location:/auth/login');
        }*/

        $saleManager = new SaleManager();

        $salesCountRequest=$saleManager->countRecords();
        $salesCount=$salesCountRequest[0]['countRecords'];
        $resultsPerPage = 5;
        $pagesCount = ceil($salesCount / $resultsPerPage);
        $firstResult = ($currentPage * $resultsPerPage) - $resultsPerPage;
        $sales = $saleManager->selectSalesAndAssociatedData($resultsPerPage, $firstResult);
        $paginationDefaultPagesGap = 2;

        return $this->twig->render('sale/index.html.twig', ['resultPerPage' => $resultsPerPage, 'sales' => $sales,
            'salesCount' => $salesCount, 'pagesCount' => $pagesCount, 'currentPage' => $currentPage,
            'paginationDefaultPagesGap' => $paginationDefaultPagesGap]);
    }


    public function getDataforSale(int $id, int $customerType): array
    {
        /**
         * Get in database all data need for displaying a sale record.
         */
        $saleManager = new SaleManager();
        $sale=$saleManager->selectSaleById($id);

        $saleController = new SaleController();
        $saleAllEnumValues = $saleController->getDataEnumforSale($customerType);

        return ['sale' => $sale, 'statusEnum' => $saleAllEnumValues['statusEnum'],
            'customerRecords' => $saleAllEnumValues['customerRecords']];
    }

    public function getDataEnumforSale(int $customerType): array
    {
        /**
         * Get in database all enum fields values for displaying a sale record.
         */
        $saleManager = new SaleManager();
        $statusEnumRequest=$saleManager->SelectEnumValues('sale', 'status_sale');
        if ($customerType == 1) {
            $individualCustomerManager = new IndividualCustomerManager();
            $customerRecords=$individualCustomerManager->selectIndividualCustomers();
        }
        else{
            $professionalCustomerManager = new ProfessionalCustomerManager();
            $customerRecords=$professionalCustomerManager->selectProfessionalCustomers();
        }

        $saleController = new SaleController();
        $statusEnumFormatted = $saleController->enumRequestFormatting($statusEnumRequest);
        $statusEnum=$statusEnumFormatted['enum'];

        return ['statusEnum' => $statusEnum, 'customerRecords' => $customerRecords];
    }

    public function getFormDataForUpdateOrAdd(array $dataFromForm): array
    {
        /**
         * Get all fields in a sale record form.
         */
        $productManager = new ProductManager();
        $allData = [];
        ksort($dataFromForm);
        $allProducts = [];
        $productFormFields=['quantity', 'product_discount'];
        foreach($dataFromForm as $key => $value) {
            $snakeKey = $this->camelToSnakeCase($key);
            $allData[$snakeKey] = $_POST[$key];
            $fieldLabel  = substr("$snakeKey", 0,-2);
            $fieldIndex = substr("$snakeKey", -1,1);
            //GET ALL PRODUCTS DATA IN FORM
            if (in_array($fieldLabel, $productFormFields)){
                $allProducts[$fieldIndex][$fieldLabel] = $allData[$snakeKey];
                $allProducts[$fieldIndex]['id_product'] = $fieldIndex;
            }
        }

        $productSaleData = $this->ComputeProductSaleData($allProducts, $productManager, $allData['id_sale']);
        $saleData = $this->ComputeSaleData($allData, $productSaleData);

        return ['saleData' => $saleData, 'productSaleData' => $productSaleData];

    }

    public function ComputeProductSaleData(array $allProducts, ProductManager $productManager, $id_sale): array
    {
        /**
         * Compute Product Sale Data with the fields of a sale record form.
         * @param array $allProducts
         * @param ProductManager $productManager
         * @param array $productSaleData
         * @param $id_sale
         * @return array
         */
        $productSaleData = [];
        $index = 0;
        for ($i = 1; $i <= count($allProducts); $i++) {
            $quantity = $allProducts[$i]['quantity'];
            //GET SOLD PRODUCTS ONLY
            if ($quantity) {
                $id_product = $allProducts[$i]['id_product'];
                $ComputationPriceRequest = $productManager->getProductInformationsForPriceComputation($id_product);
                $tva = $ComputationPriceRequest[0]['ratio'];
                $HTUnitPrice = $ComputationPriceRequest[0]['price'];
                $discountPercentage = $allProducts[$i]['product_discount'];
                if ($discountPercentage) {
                    $HTUnitPriceForSale = $HTUnitPrice - $discountPercentage * $HTUnitPrice / 100;
                } else {
                    $HTUnitPriceForSale = $HTUnitPrice;
                }
                $HTPriceForSale = $HTUnitPriceForSale * $quantity;
                $TTCUnitPriceForSale = $HTUnitPriceForSale + $tva * $HTUnitPrice / 100;
                $TTCPriceForSale = $TTCUnitPriceForSale * $quantity;

                $productSaleData[$index]['fk_id_product'] = $id_product;
                $productSaleData[$index]['fk_id_sale'] = $id_sale;
                $productSaleData[$index]['original_price'] = $HTPriceForSale;
                $productSaleData[$index]['quantity'] = $quantity;
                $productSaleData[$index]['discount_percentage'] = $discountPercentage;
                $productSaleData[$index]['finalised_price'] = $TTCPriceForSale;
                //$productSaleData[$index]['created_at'] = '';

                $index++;
            }
        }
        return $productSaleData;
    }


    public function ComputeSaleData(array $allData, array $productSaleData)
    {
        /**
     * @param array $allData
     * @param array $productSaleData
     * @param $saleData
     * @return mixed
     */
        $saleData = [];
        $globalPriceOriginal = 0;
        $globalPriceFinalised = 0;
        $globalDiscountPercentage = $allData['discount_sale_percentage'];
        foreach ($productSaleData as $product) {
            $globalPriceOriginal = $globalPriceOriginal + $product['original_price'];
            $globalPriceFinalised = $globalPriceFinalised + $product['finalised_price'];
        }
        $globalPriceFinalised = $globalPriceFinalised - $globalDiscountPercentage / 100 * $globalPriceOriginal;

        $saleData['id_sale'] = $allData['id_sale'];
        $saleData['date_sale'] = $allData['date_sale'];
        $saleData['to_deliver'] = $allData['to_deliver'] ? 1 : 0;;
        $saleData['status_sale'] = $allData['status_sale'];
        $saleData['fk_users'] = $_SESSION['id'];
        $saleData['fk_customer'] = $allData['id_customer'];
        $saleData['global_price_original'] = $globalPriceOriginal;
        $saleData['discount_percentage'] = $globalDiscountPercentage;
        $saleData['global_price_finalised'] = $globalPriceFinalised;
        return $saleData;
    }

    public function UpdateForEdit(SaleManager $saleManager)
    {
        /**
         * @param SaleManager $saleManager
         */
        $datafromForm = $this->getFormDataForUpdateOrAdd($_POST);
        $saleManager->update('sale', $datafromForm['saleData']);
        foreach ($datafromForm['productSaleData'] as $productSale){
            $productId = $productSale['fk_id_product'];
            $saleId = $productSale['fk_id_sale'];
            if ($saleManager->selectProductsForSaleByProductAndSaleId($productId, $saleId)) {
                $saleManager->updateAssociativeTable(
                    'product_sale', 'fk_id_product', 'fk_id_sale', $productSale);
            }
            else{
                $saleManager->insert('product_sale', $productSale, null,true);
            }

        }
    }

    public function showProfessional(int $id)
    {
        /**
         * Display a sale record for read purpose only.
         */
        /*if ($_SESSION['is_admin'] == "1") {
            header('location:/auth/login');
        }*/

        $data = $this->getDataforSale($id, 2);

        return $this->twig->render('sale/show.html.twig', ['sale' => $data['sale'],
            'statusEnum' => $data['statusEnum'], 'customerRecords' => $data['customerRecords'], 'customerType' => '2',
            'productsRecords' => $data['productsRecords'],'operation' => 'show']);
    }

    public function showIndividual(int $id)
    {
        /**
         * Display a sale record for read purpose only.
         */
        /*if ($_SESSION['is_admin'] == "1") {
            header('location:/auth/login');
        }*/


        $data = $this->getDataforSale($id, 1);

        return $this->twig->render('sale/show.html.twig', ['sale' => $data['sale'],
            'statusEnum' => $data['statusEnum'], 'customerRecords' => $data['customerRecords'], 'customerType' => '1',
            'productsRecords' => $data['productsRecords'], 'operation' => 'show']);
    }

    public function editProfessional(int $id)
    {
        /**
         * Display a sale record for modification purpose.
         */
        /*if ($_SESSION['is_admin'] == "1") {
            header('location:/auth/login');
        }*/
        $saleManager = new SaleManager();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->UpdateForEdit($saleManager);
        }

        $data = $this->getDataforSale($id, 2);
        $productsRecords = $saleManager->selectProductsForSale($id);

        return $this->twig->render('sale/show.html.twig', ['sale' => $data['sale'],
            'statusEnum' => $data['statusEnum'], 'customerRecords' => $data['customerRecords'], 'customerType' => '2',
            'productsRecords' => $productsRecords,'operation' => 'edit']);

    }

    public function editIndividual(int $id)
    {
        /**
         * Display a sale record for modification purpose.
         */
        /*if ($_SESSION['is_admin'] == "1") {
            header('location:/auth/login');
        }*/
        $saleManager = new SaleManager();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->UpdateForEdit($saleManager);
        }

        $data = $this->getDataforSale($id, 1);
        $productsRecords = $saleManager->selectProductsForSale($id);

        return $this->twig->render('sale/show.html.twig', ['sale' => $data['sale'],
            'statusEnum' => $data['statusEnum'], 'customerRecords' => $data['customerRecords'], 'customerType' => '1',
            'productsRecords' => $productsRecords, 'operation' => 'edit']);

    }

    public function addProfessional()
    {
        /**
         * Display employee creation page
         *
         * @return string
         * @throws \Twig\Error\LoaderError
         * @throws \Twig\Error\RuntimeError
         * @throws \Twig\Error\SyntaxError
         */
        $saleManager = new SaleManager();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $datafromForm = $this->getFormDataForUpdateOrAdd($_POST);

            $idEmployee = $saleManager->insert('employee', $datafromForm['employeeData']);
            $contactFk = ['fk_id_employee2' => $idEmployee];
            $saleManager->insert('contact', $datafromForm['contactData'], $contactFk);
            $contractFk = ['fk_employee' => $idEmployee];
            $saleManager->insert('contract', $datafromForm['contractData'], $contractFk);

            header('Location:/employee/index');
        }
        else
        {
            $data = $this->getDataEnumforSale(2);
            $productsRecords = $saleManager->selectProductsForNewSale();
        }
        return $this->twig->render('sale/show.html.twig', ['statusEnum' => $data['statusEnum'],
            'customerRecords' => $data['customerRecords'], 'customerType' => '2',
            'productsRecords' => $productsRecords, 'operation' => 'add']);
    }

    public function addIndividual()
    {
        /**
         * Display employee creation page
         *
         * @return string
         * @throws \Twig\Error\LoaderError
         * @throws \Twig\Error\RuntimeError
         * @throws \Twig\Error\SyntaxError
         */

        $saleManager = new SaleManager();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $datafromForm = $this->getFormDataForUpdateOrAdd($_POST);

            $idEmployee = $saleManager->insert('employee', $datafromForm['employeeData']);
            $contactFk = ['fk_id_employee2' => $idEmployee];
            $saleManager->insert('contact', $datafromForm['contactData'], $contactFk);
            $contractFk = ['fk_employee' => $idEmployee];
            $saleManager->insert('contract', $datafromForm['contractData'], $contractFk);

            header('Location:/employee/index');
        }
        else
        {
            $data = $this->getDataEnumforSale(1);
            $productsRecords = $saleManager->selectProductsForNewSale();
        }
        return $this->twig->render('sale/show.html.twig', ['statusEnum' => $data['statusEnum'],
            'customerRecords' => $data['customerRecords'], 'customerType' => '1',
            'productsRecords' => $productsRecords, 'operation' => 'add']);
    }

    public function delete(int $id)
    {
        /**
         * Handle employee deletion
         *
         * @param int $id
         */
        $saleManager = new SaleManager();

        $contactId = $saleManager->GetIdRecordsByForeignKeys('contact','fk_id_employee2', $id);
        $contractsId = $saleManager->GetIdRecordsByForeignKeys('contract','fk_employee', $id);

        $saleManager->delete('contact', $contactId[0]['id_contact']);
        foreach($contractsId as $contract) {
            $saleManager->delete('contract', $contract['id_contract']);
        }
        $saleManager->delete('employee', $id);

        header('Location:/employee/index');
    }

    function cancel() {
        return header('Location:/sale/index');
    }

    function camelToSnakeCase($string, $us = "_") {
        return strtolower(preg_replace(
            '/(?<=\d)(?=[A-Za-z])|(?<=[A-Za-z])(?=\d)|(?<=[a-z])(?=[A-Z])/', $us, $string));
    }

}