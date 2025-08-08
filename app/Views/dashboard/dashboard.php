<div class="container my-4">
    <div class="card">
        <h3 class="card-header text-start">
           Dashboard
        </h3>
        <div class="card-body">
            <div class="row mx-1 mb-4">
                    <a href="https://github.com/niklos01/fwe_04_react.git" class="btn btn-primary" role="button" target="_blank">Zum Github Repo</a>
            </div>

            <div class="row g-4 align-items-stretch mb-4">
                <div class="col-lg-8 d-flex">
                    <?= $this->include('dashboard/charts/last-12-months-bar-chart') ?>
                </div>
                <div class="col d-flex">
                    <?= $this->include('dashboard/charts/current-vs-previous-year-gauge.php') ?>
                </div>
            </div>

            <div class="row g-4 align-items-stretch mb-4">
                <div class="col">
                    <?= $this->include('dashboard/weather/weather.php') ?>
                </div>

                <div class="col-lg-8">
                    <?= $this->include('dashboard/maps/leaflet-map.php') ?>
                </div>
            </div>


        </div>
    </div>
</div>
