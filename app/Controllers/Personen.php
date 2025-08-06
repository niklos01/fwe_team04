<?php

namespace App\Controllers;

use App\Models\PersonModel;
use Mpdf\Mpdf;
use Mpdf\MpdfException;

class Personen extends BaseController
{
    public function index(): void
    {
        $this->renderLayout([
            'personen/tableAjax'
        ]);
    }

    public function getPersonenAjax()
    {
        $model = new PersonModel();
        $personen = $model->getPersonen();

        return json_encode($personen);
    }


    /**
     * @throws MpdfException
     */
    public function pdf(int $id): \CodeIgniter\HTTP\ResponseInterface
    {
        $model = new PersonModel();
        $person = $model->getPersonen($id);

        if (!$person) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Person mit ID {$id} nicht gefunden.");
        }

        $mpdf = new Mpdf();

        $html = view('personen/pdf_template', ['person' => $person]);

        $mpdf->WriteHTML($html);

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setBody($mpdf->Output("person_{$id}.pdf", 'S')); // Stream to browser
    }
}
