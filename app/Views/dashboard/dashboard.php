<div class="container my-4">
    <div class="card">
        <div class="card-header text-start">
            <h2 class="card-title">Dashboard</h2>
        </div>
        <div class="card-body">
            <div class="row g-4 align-items-stretch mb-4">
                <div class="col-lg-8 d-flex">
                    <?= $this->include('dashboard/charts/last-12-months-bar-chart') ?>
                </div>
                <div class="col d-flex">
                    <?= $this->include('dashboard/charts/current-vs-previous-year-gauge.php') ?>
                </div>
            </div>

            <div class="row g-4 align-items-stretch">
                <div class="col">
                    <?= $this->include('dashboard/maps/leaflet-map.php') ?>
                </div>
            </div>

        </div>
    </div>
</div>
