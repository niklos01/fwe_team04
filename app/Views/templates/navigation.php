<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= base_url('/') ?>">FWE-Team 04</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link<?= uri_string() === '' ? ' active' : '' ?>" href="<?= base_url('/') ?>">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= uri_string() === 'personen' ? ' active' : '' ?>" href="<?= base_url('personen') ?>">Personen</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main>
