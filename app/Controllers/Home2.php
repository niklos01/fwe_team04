<?php
namespace App\Controllers;

use App\Models\PersonModel;
use Mpdf\Mpdf;

class Home2 extends BaseController
{

    public function viewPDFFormat()
    {
        $model    = new PersonModel();
        $personen = $model->getPersonen();

        echo view('pdf_table', ['personen' => $personen]); // Pass data directly

    }

    public function generatePDF()
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
