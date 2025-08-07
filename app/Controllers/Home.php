<?php
namespace App\Controllers;

use App\Models\PersonModel;
use App\Models\UmsatzModel;
use Mpdf\Mpdf;
use Mpdf\MpdfException;

class Home extends BaseController
{
    public function index(): void
    {
        $this->renderLayout([
            'dashboard/dashboard',
        ]);
    }

    // Personen
    public function indexPersonen()
    {
        $this->renderLayout([
            "personen/tableAjax",
        ]);
    }

    public function getPersonenAjax()
    {
        $model    = new PersonModel();
        $personen = $model->getPersonen();

        return json_encode($personen);
    }

    /**
     * @throws MpdfException
     */
    public function pdf(int $id): \CodeIgniter\HTTP\ResponseInterface
    {
        $model  = new PersonModel();
        $person = $model->getPersonen($id);

        if (! $person) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Person mit ID {$id} nicht gefunden.");
        }

        $mpdf = new Mpdf();

        $html = view('personen/pdf_template', ['person' => $person]);

        $mpdf->WriteHTML($html);

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setBody($mpdf->Output("person_{$id}.pdf", 'S')); // Stream to browser
    }

    // Umsatz
    public function last12Months()
    {
        $model = new UmsatzModel();
        $data  = $model->getLast12Months();
        return $this->response->setJSON($data);
    }

    public function currentMonthComparison()
    {
        $model = new UmsatzModel();
        $data  = $model->getCurrentMonthComparison();
        return $this->response->setJSON($data);
    }

    // PDF
    public function generatePdfAll()
    {

        $model = new PersonModel();

        // Only generate PDF for first 1000 records
        $maxRecords = 1000;
        $personen   = $model->getPersonenChunk($maxRecords, 0);

        $mpdf = new Mpdf();

        $html = '<h1>Personenliste (Erste ' . count($personen) . ' Einträge)</h1>';
        $html .= '<table border="1" cellpadding="2" style="width:100%; font-size:8px;">';
        $html .= '<tr style="background:#f0f0f0;"><th>ID</th><th>Vorname</th><th>Name</th><th>Ort</th><th>Username</th></tr>';

        foreach ($personen as $person) {
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($person['id']) . '</td>';
            $html .= '<td>' . htmlspecialchars($person['vorname']) . '</td>';
            $html .= '<td>' . htmlspecialchars($person['name']) . '</td>';
            $html .= '<td>' . htmlspecialchars($person['ort'] ?? '') . '</td>';
            $html .= '<td>' . htmlspecialchars($person['username']) . '</td>';
            $html .= '</tr>';
        }

        $html .= '</table>';

        $mpdf->WriteHTML(view('pdf_table', ['personen' => $personen]));
        $mpdf->Output('personenliste.pdf', 'D');
    }
}
