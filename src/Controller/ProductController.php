<?php


namespace App\Controller;

use App\Model\ProductManager;

class ProductController extends AbstractController
{

    public function index()
    {
        $productManager = new ProductManager();
        $products = $productManager->selectAll();

        return $this->twig->render('Product/index.html.twig', ['products' => $products]);
    }

    /**
     * Display product informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $productManager = new ProductManager();
        $product = $productManager->selectProductById($id);

        return $this->twig->render('Product/show.html.twig', ['entityRequest' => $product]);
    }

    /**
     * Display product edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id)
    {
        $productManager = new ProductManager();
        $product = $productManager->selectProductById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product['title'] = $_POST['title'];
            $productManager->update($product);
        }

        return $this->twig->render('Product/show.html.twig', ['entityRequest' => $product, 'operation' => 'edit']);
    }

    /**
     * Display product creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
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

    /**
     * Handle product deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $productManager = new ProductManager();
        $productManager->delete($id);
        header('Location:/product/index');
    }
}