<div class="card h-100 w-100">
    <div class="card-header">Wetter in Trier</div>
    <div class="card-body">
        <div id="weather"></div>
    </div>
</div>

<script>
    fetch('<?= base_url('api/weather?city=Trier') ?>')
            .then(res => res.json())
        .then(data => {
            if (data.error) {
                document.getElementById('weather').innerHTML = `<p class="text-danger">${data.error}</p>`;
                return;
            }

            const { stadt, beschreibung, temperatur, luftfeuchte, wind, icon } = data;
            console.log("data", data)

            const html = `
                <img src="https://openweathermap.org/img/wn/${icon}@4x.png" class="img-fluid mb-2" style="max-width: 100px;" />
                <h5 class="fw-bold mb-1">${stadt}</h5>
                <p class="text-capitalize text-secondary mb-2">${beschreibung}</p>
                <ul class="list-group list-group-flush w-100 text-start">
                  <li class="list-group-item">
                    <i class="bi bi-thermometer-half me-2 text-danger"></i>
                    Temperatur: <strong>${temperatur} °C</strong>
                  </li>
                  <li class="list-group-item">
                    <i class="bi bi-droplet-fill me-2 text-primary"></i>
                    Luftfeuchtigkeit: <strong>${luftfeuchte}%</strong>
                  </li>
                  <li class="list-group-item">
                    <i class="bi bi-wind me-2 text-secondary"></i>
                    Windgeschwindigkeit: <strong>${wind} m/s</strong>
                  </li>
                </ul>
            `;

            document.getElementById('weather').innerHTML = html;
        })
        .catch(err => {
            document.getElementById('weather').innerHTML = `<p class="text-danger">Fehler beim Laden der Wetterdaten</p>`;
        });
</script>