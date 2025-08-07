<div id="weather"></div>

<script>
    fetch('https://api.openweathermap.org/data/2.5/weather?q=Trier,de&appid=f565171f49fd6353914ea7be853091fa&units=metric&lang=de')
        .then(res => res.json())
        .then(data => {
            const icon = data.weather[0].icon;
            const html = `
        <h2>Wetter in ${data.name}</h2>
        <img src="https://openweathermap.org/img/wn/${icon}@2x.png" alt="${data.weather[0].description}" />
        <p>${data.weather[0].description}</p>
        <p>🌡️ Temperatur: ${data.main.temp} °C</p>
        <p>💧 Luftfeuchtigkeit: ${data.main.humidity} %</p>
        <p>🌬️ Wind: ${data.wind.speed} m/s</p>
      `;
            document.getElementById('weather').innerHTML = html;
        });
</script>
