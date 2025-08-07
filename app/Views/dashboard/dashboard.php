<div class="container text-center my-4">
    <div class="row gap-2 align-items-stretch">
        <div class="col col-8">
            <?= $this->include('dashboard/charts/last-12-months-bar-chart') ?>
        </div>
        <div class="col">
            <?= $this->include('dashboard/charts/current-vs-previous-year-gauge.php') ?>
        </div>
    </div>

    <div class="row gap-2 align-items-stretch mt-4">
        <div class="col">
            <?= $this->include('dashboard/maps/leaflet-map.php') ?>
        </div>
    </div>
</div>
