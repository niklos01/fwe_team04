<?php
$csrfName = csrf_token();
$csrfHash = csrf_hash();
?>
<div class="container my-4">
    <div class="card">
        <h3 class="card-header">Personenliste</h3>
        <div class="ca            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer Team#04'
            },ody">
            <div class="container mt-2">
                <div class="table-responsive">
                    <div id="toolbar" class="d-flex justify-content-end gap-2 mb-2">
                        <a href="<?php echo base_url("home/generatePdfAll") ?>" class="btn btn-sm btn-outline-dark"
                            title="Gesamte Personen als PDF downloaden">
                            <i class="bi bi-file-earmark-pdf"></i> Alle Downloaden
                        </a>
                    </div>

                    <table id="personenTabelle" class="table table-bordered table-hover table-striped align-middle"
                        data-toggle="table" data-toolbar="#toolbar"
                        data-url="<?php echo base_url('home/getPersonenAjax') ?>" data-search="true"
                        data-pagination="true" data-show-refresh="true" data-show-columns="true"
                        data-side-pagination="client">
                        <thead class="table-dark">
                            <tr>
                                <th data-field="id" data-sortable="true">#</th>
                                <th data-field="vorname" data-sortable="true">Vorname</th>
                                <th data-field="name" data-sortable="true">Nachname</th>
                                <th data-field="strasse">Straße</th>
                                <th data-field="plz">PLZ</th>
                                <th data-field="ort">Ort</th>
                                <th data-field="username" data-sortable="true">Username</th>
                                <th data-field="aktionen" data-formatter="actionButtonFormatter" data-align="center">Aktionen
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <!-- Modal für CRUD Operationen -->
            <div class="modal fade" id="personModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Person bearbeiten</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="personForm">
                                <input type="hidden" id="personId">
                                <div class="mb-3">
                                    <label for="vorname" class="form-label">Vorname</label>
                                    <input type="text" class="form-control" id="vorname" required>
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nachname</label>
                                    <input type="text" class="form-control" id="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="strasse" class="form-label">Straße</label>
                                    <input type="text" class="form-control" id="strasse">
                                </div>
                                <div class="mb-3">
                                    <label for="plz" class="form-label">PLZ</label>
                                    <input type="text" class="form-control" id="plz" required>
                                </div>
                                <div class="mb-3">
                                    <label for="ort" class="form-label">Ort</label>
                                    <input type="text" class="form-control" id="ort" required>
                                </div>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" required>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                            <button type="button" class="btn btn-primary" id="saveButton">Speichern</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function actionButtonFormatter(value, row, index) {
    const id = row.id;
    const pdfUrl = "<?php echo base_url('home/pdf') ?>/" + id;

    return `
        <div class="btn-group" role="group">
            <a href="${pdfUrl}" class="btn btn-sm btn-outline-dark" target="_blank" title="Person als PDF anzeigen">
                <i class="bi bi-file-earmark-pdf"></i>
            </a>
            <button class="btn btn-sm btn-outline-primary" onclick="editPerson(${id})" title="Person bearbeiten">
                <i class="bi bi-pencil"></i>
            </button>
            <button class="btn btn-sm btn-outline-danger" onclick="deletePerson(${id})" title="Person löschen">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    `;
}

// CRUD Operationen
let currentOperation = 'create';

function showModal(title = 'Person erstellen') {
    document.querySelector('.modal-title').textContent = title;
    $('#personModal').modal('show');
}

function clearForm() {
    document.getElementById('personForm').reset();
    document.getElementById('personId').value = '';
}

function editPerson(id) {
    currentOperation = 'update';
    fetch(`<?= base_url('api/crud') ?>/${id}`, {
        headers: {
            'Authorization': 'Bearer Team#04'
        }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('personId').value = data.id;
        document.getElementById('vorname').value = data.vorname;
        document.getElementById('name').value = data.name;
        document.getElementById('strasse').value = data.strasse || '';
        document.getElementById('plz').value = data.plz;
        document.getElementById('ort').value = data.ort;
        document.getElementById('username').value = data.username;
        showModal('Person bearbeiten');
    });
}

function deletePerson(id) {
    if (confirm('Möchten Sie diese Person wirklich löschen?')) {
        fetch(`<?= base_url('api/crud') ?>/${id}`, {
            method: 'DELETE',
            headers: {
                'Authorization': 'Bearer Team#04'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                $('#personenTabelle').bootstrapTable('refresh');
            } else {
                alert('Fehler beim Löschen: ' + data.message);
            }
        });
    }
}

function createPerson() {
    currentOperation = 'create';
    clearForm();
    showModal();
}

// Event Listener für den "Neue Person" Button
document.addEventListener('DOMContentLoaded', function() {
    const toolbar = document.getElementById('toolbar');
    const createButton = document.createElement('button');
    createButton.className = 'btn btn-sm btn-outline-primary';
    createButton.innerHTML = '<i class="bi bi-plus-lg"></i> Neue Person';
    createButton.onclick = createPerson;
    toolbar.insertBefore(createButton, toolbar.firstChild);
});

// Speichern-Button Event Handler
document.getElementById('saveButton').addEventListener('click', function() {
    const formData = {
        vorname: document.getElementById('vorname').value,
        name: document.getElementById('name').value,
        strasse: document.getElementById('strasse').value,
        plz: document.getElementById('plz').value,
        ort: document.getElementById('ort').value,
        username: document.getElementById('username').value
    };

    if (currentOperation === 'update') {
        formData.id = document.getElementById('personId').value;
    }

    fetch('<?= base_url('api/crud') ?>' + (currentOperation === 'update' ? '/' + formData.id : ''), {
        method: currentOperation === 'create' ? 'POST' : 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer Team#04'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            $('#personModal').modal('hide');
            $('#personenTabelle').bootstrapTable('refresh');
        } else {
            alert('Fehler: ' + data.message);
        }
    });
});
</script>
