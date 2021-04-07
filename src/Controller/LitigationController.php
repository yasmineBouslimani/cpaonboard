<?php

namespace App\Controller;

use App\Model\LitigationManager;
use Dompdf\Dompdf;


class LitigationController extends AbstractController
{
    public function index(int $currentPage = 1)
    {
        /**
         * @param int $currentPage
         * @return string
         * @throws \Twig\Error\LoaderError
         * @throws \Twig\Error\RuntimeError
         * @throws \Twig\Error\SyntaxError
         */
        $litigationManager = new LitigationManager();

        $litigationsCountRequest = $litigationManager->countRecords();
        $litigationsCount = $litigationsCountRequest[0]['countRecords'];
        $resultsPerPage = 5;
        $pagesCount = ceil($litigationsCount / $resultsPerPage);
        $firstResult = ($currentPage * $resultsPerPage) - $resultsPerPage;
        $litigations = $litigationManager->selectLitigationsWithAcquisitionAndSaleWithLimit($resultsPerPage, $firstResult);
        $paginationDefaultPagesGap = 2;

        return $this->twig->render('Litigation/index.html.twig', [
            'litigations' => $litigations,
            'litigationsCount' => $litigationsCount,
            'resultPerPage' => $resultsPerPage,
            'pagesCount' => $pagesCount,
            'currentPage' => $currentPage,
            'paginationDefaultPagesGap' => $paginationDefaultPagesGap
        ]);
    }


    public function show(int $id)
    {
        /**
         * @param int $id
         * @return string
         * @throws \Twig\Error\LoaderError
         * @throws \Twig\Error\RuntimeError
         * @throws \Twig\Error\SyntaxError
         */
        /*   if (!in_array("litigation_management", $_SESSION['permissions'])) {
               header('location:/admin/index');
           }*/

        $data = $this->getDataForLitigation($id);

        return $this->twig->render('Litigation/show.html.twig', [
            'litigation' => $data['litigationTypeRecords'],
            'operation' => 'read'
        ]);
    }


    public function getDataForLitigation(int $id): array
    {
        /**
         * @param int $id
         * @return array
         */
        $litigationManager = new LitigationManager();

        $litigationTypeRecords = $litigationManager->selectLitigationWithAcquisitionAndSaleById($id);

        return [
            'litigationTypeRecords' => $litigationTypeRecords,
        ];
    }


    public function edit(int $id): string
    {
        /**
         * @param int $id
         * @return string
         * @throws \Twig\Error\LoaderError
         * @throws \Twig\Error\RuntimeError
         * @throws \Twig\Error\SyntaxError
         */
        $data = $this->getDataForLitigation($id);
        $litigationManager = new LitigationManager();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            $litigation['comment_litigation'] = $_POST['label'];
            $litigationManager->update('litigation', $litigation);
            header('Location:/admin/index');
        }


        return $this->twig->render('Litigation/show.html.twig', [
            'litigation' => $data['litigationTypeRecords'],
            'operation' => 'edit'
        ]);
    }

    public function add()
    {
        /**
         * @return string
         * @throws \Twig\Error\LoaderError
         * @throws \Twig\Error\RuntimeError
         * @throws \Twig\Error\SyntaxError
         */
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $litigationManager = new LitigationManager();
            $litigation = [
                'title' => $_POST['title'],
            ];
            $id = $litigationManager->insert($litigation);
            header('Location:/litigation/show/' . $id);
        }
        return $this->twig->render('Litigation/add.html.twig');
    }


    public function delete(int $id)
    {
        /**
         * @param int $id
         */
        $litigationManager = new LitigationManager();
        $litigationManager->delete($id);
        header('Location:/litigation/index');
    }


    public function search()
    {
        /**
         * @return string
         * @throws \Twig\Error\LoaderError
         * @throws \Twig\Error\RuntimeError
         * @throws \Twig\Error\SyntaxError
         */
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $search = $_POST['search'];
            $search = str_replace('\'', '', $search);
            $words = explode(' ', $search);

            $litigationManager = new LitigationManager();
            $litigations = $litigationManager->selectLitigationByWords($words);

            return $this->twig->render(
                'Litigation/search.html.twig',
                [
                    'litigations' => $litigations,
                    'search' => $search,
                ]
            );
        }
    }


    public function extractPdf(int $id)
    {
        /**
         * @param int $id
         * @throws \Twig\Error\LoaderError
         * @throws \Twig\Error\RuntimeError
         * @throws \Twig\Error\SyntaxError
         */
        /* //A ajuster en fonction des permissions accordées !
         if ($_SESSION['permissions'] != 'Magazinier') {
             header('location:/admin/index');
         }*/

        $dompdf = new Dompdf();
        $litigationManager = new LitigationManager();

        $litigation = $litigationManager->selectLitigationWithAcquisitionAndSaleById($id);

        $html = $this->twig->render(
            'litigation/pdf.html.twig',
            ['litigation' => $litigation]
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
        $litigationManager = new LitigationManager();
        $litigations = $litigationManager->selectAll();
        $filename = 'litigations_' . date('Y-m-d') . '.csv';
        $fopenAction = fopen('php://output', 'w');
        $delimiter = ';';
        $fields = [
            'Reference',
            'Date d\'ouverture du litige',
            'Reference de l\'achat concerne',
            'Reference de la vente concernee',
            'Commentaire',
        ];
        fputcsv($fopenAction, $fields, $delimiter);

        foreach ($litigations as $litigation) {
            $lineData = [
                $litigation['id_litigation'],
                $litigation['date_litigation'],
                $litigation['fk_acqusition'],
                $litigation['fk_sale'],
                $litigation['comment_litigation'],
            ];
            fputcsv($fopenAction, $lineData, $delimiter);
        }

        fseek($fopenAction, 0);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');

        fpassthru($fopenAction);
    }

}