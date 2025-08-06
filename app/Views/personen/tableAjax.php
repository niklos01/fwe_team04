<div class="container mt-5">
    <h2>Personenliste</h2>

    <table
            id="personenTabelle"
            class="table"
            data-toggle="table"
            data-url="<?= base_url('home/getPersonenAjax') ?>"
            data-search="true"
            data-pagination="true"
            data-show-refresh="true"
            data-show-columns="true"
            data-side-pagination="client"
    >
        <thead>
        <tr>
            <th data-field="id" data-sortable="true">#</th>
            <th data-field="vorname" data-sortable="true">Vorname</th>
            <th data-field="name" data-sortable="true">Nachname</th>
            <th data-field="strasse">Straße</th>
            <th data-field="plz">PLZ</th>
            <th data-field="ort">Ort</th>
            <th data-field="username" data-sortable="true">Username</th>
            <th data-field="aktionen" data-formatter="pdfButtonFormatter" data-align="center">Aktion</th>
        </tr>
        </thead>
    </table>
</div>


<script>
    function pdfButtonFormatter(value, row, index) {
        const id = row.id;
        const url = "<?= base_url('pdf/person') ?>/" + id;

        return `
            <a href="${url}" class="btn btn-sm btn-outline-danger" target="_blank" title="Person als PDF anzeigen">
                <i class="bi bi-file-earmark-pdf"></i> PDF
            </a>
        `;
    }
</script>
