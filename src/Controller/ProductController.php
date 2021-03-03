<?php

namespace App\Controller;

use App\Model\ProductManager;
use Dompdf\Dompdf;


class ProductController extends AbstractController
{
    public function index(int $currentPage = 1)
    {
        $productManager = new ProductManager();

        $productsCountRequest = $productManager->countRecords();
        $productsCount = $productsCountRequest[0]['countRecords'];
        $resultsPerPage = 5;
        $pagesCount = ceil($productsCount / $resultsPerPage);
        $firstResult = ($currentPage * $resultsPerPage) - $resultsPerPage;
        $products = $productManager->selectProductsWithTypeAndDependancyAndTvaWithLimit($resultsPerPage, $firstResult);
        $paginationDefaultPagesGap = 2;

        return $this->twig->render('Product/index.html.twig', [
            'products'                  => $products,
            'productsCount'             => $productsCount,
            'resultPerPage'             => $resultsPerPage,
            'pagesCount'                => $pagesCount,
            'currentPage'               => $currentPage,
            'paginationDefaultPagesGap' => $paginationDefaultPagesGap
        ]);
    }

    public function show(int $id)
    {
        $productManager = new ProductManager();
        $product = $productManager->selectProductsWithTypeAndDependancyAndTvaByd($id);

        return $this->twig->render('Product/show.html.twig', [
            'product' => $product
        ]);
    }

    public function edit(int $id): string
    {
        $productManager = new ProductManager();
        $product = $productManager->selectProductsWithTypeAndDependancyAndTvaByd($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product['title'] = $_POST['title'];
            $productManager->update($product);
        }

        return $this->twig->render('Product/edit.html.twig', ['product' => $product]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productManager = new ProductManager();
            $product = [
                'title' => $_POST['title'],
            ];
            $id = $productManager->insert($product);
            header('Location:/product/show/' . $id);
        }
        return $this->twig->render('Product/add.html.twig');
    }

    public function delete(int $id)
    {
        $productManager = new ProductManager();
        $productManager->delete($id);
        header('Location:/product/index');
    }

    public function search()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $search = $_POST['search'];
            $search = str_replace('\'', '', $search);
            $words = explode(' ', $search);

            $productManager = new ProductManager();
            $products = $productManager->selectProductByWord($words);

            return $this->twig->render(
                'Product/search.html.twig',
                [
                    'products' => $products,
                    'search' => $search,
                ]
            );
        }
    }

    public function extractPdf(int $id)
    {
        /* //A ajuster en fonction des permissions accordées !
         if ($_SESSION['permissions'] != 'Magazinier') {
             header('location:/admin/index');
         }*/

        $dompdf = new Dompdf();
        $productManager = new ProductManager();

        $product = $productManager->selectProductsWithTypeAndDependancyAndTvaByd($id);

        $html = $this->twig->render(
            'product/pdf.html.twig',
            ['product' => $product]
        );
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        ob_end_clean();
        $dompdf->stream(
            'cpa_produit.pdf',
            ['attachment' => true]
        );
    }

    public function extractCsv()
    {
        /*  //A ajuster en fonction de l'entrée en bdd !
          if ($_SESSION['fk_id_userType'] != '2') {
              header('location:/admin/index');
          }*/
        $productManager = new ProductManager();
        $products = $productManager->selectProductsWithTypeAndDependancyAndTva();
        $filename = 'products_' . date('Y-m-d') . '.csv';
        $fopenAction = fopen('php://output', 'w');
        $delimiter = ';';
        $fields = [
            'Reference',
            'Categorie',
            'Nom',
            'Prix',
            'Stock',
            'TVA appliquee',
            'Commentaires',
        ];
        fputcsv($fopenAction, $fields, $delimiter);

        foreach ($products as $product) {
            $lineData = [
                $product['id_product'],
                $product['type'],
                $product['label'],
                $product['price'],
                $product['stock'],
                $product['ratio'],
                $product['comment_product'],
            ];
            fputcsv($fopenAction, $lineData, $delimiter);
        }

        fseek($fopenAction, 0);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');

        fpassthru($fopenAction);
    }

}
