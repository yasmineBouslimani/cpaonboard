<?php

namespace App\Controller;

use App\Model\ProductManager;
use Dompdf\Dompdf;


class ProductController extends AbstractController
{

    public function index()
    {
        $productManager = new ProductManager();
        $products = $productManager->selectAll();

        return $this->twig->render('Product/index.html.twig', ['products' => $products]);

    }

    public function show(int $id)
    {
        $productManager = new ProductManager();
        $product = $productManager->selectProductById($id);

        return $this->twig->render('Product/show.html.twig', ['entityRequest' => $product]);

    }

    public function edit(int $id): string
    {
        $productManager = new ProductManager();
        $product = $productManager->selectProductById($id);

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

    public function extractPdf()
    {
        $productManager = new ProductManager();
        $products = $productManager->selectAll();
        $dompdf = new Dompdf();
        $html = $this->twig->render(
            'product/pdf.html.twig',
            ['products' => $products]
        );
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        ob_end_clean();

        $dompdf->stream(
            'products.pdf',
            ['attachment' => true]
        );
    }

    public function extractCsv()
    {
        $productManager = new ProductManager();
        $products = $productManager->selectAll();
        $filename = 'products_' . date('Y-m-d') . '.csv';
        $fopenAction = fopen('php://output', 'w');
        $delimiter = ';';
        $fields = [
            'Identifiant',
            'Nom',
            'Stock',
        ];
        fputcsv($fopenAction, $fields, $delimiter);

        foreach ($products as $product) {
            $lineData = [
                $product['id_product'],
                $product['label'],
                $product['stock'],
            ];
            fputcsv($fopenAction, $lineData, $delimiter);
        }

        fseek($fopenAction, 0);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');

        fpassthru($fopenAction);

        exit;
    }
}
