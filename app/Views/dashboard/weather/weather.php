<div class="card h-100 w-100">
    <div class="card-header">Wetter in Trier</div>
    <div class="card-body">
        <div id="weather"></div>
    </div>
</div>

<script>
    fetch('https://api.openweathermap.org/data/2.5/weather?q=Trier,de&appid=f565171f49fd6353914ea7be853091fa&units=metric&lang=de')
        .then(res => res.json())
        .then(data => {
            const icon = data.weather[0].icon;
            const description = data.weather[0].description;
            const temp = Math.round(data.main.temp);
            const humidity = data.main.humidity;
            const wind = data.wind.speed;
            const city = data.name;

            const html = `
                <img src="https://openweathermap.org/img/wn/${icon}@4x.png" class="img-fluid mb-2" style="max-width: 100px;" />
                <h5 class="fw-bold mb-1">${city}</h5>
                <p class="text-capitalize text-secondary mb-2">${description}</p>
                <ul class="list-group list-group-flush w-100">
                  <li class="list-group-item">
                    <i class="bi bi-thermometer-half me-2 text-danger"></i>
                    Temperatur: <strong>${temp} °C</strong>
                  </li>
                  <li class="list-group-item">
                    <i class="bi bi-droplet-fill me-2 text-primary"></i>
                    Luftfeuchtigkeit: <strong>${humidity}%</strong>
                  </li>
                  <li class="list-group-item">
                    <i class="bi bi-wind me-2 text-secondary"></i>
                    Windgeschwindigkeit: <strong>${wind} m/s</strong>
                  </li>
                </ul>
            `;
            document.getElementById('weather').innerHTML = html;
        });
</script>
