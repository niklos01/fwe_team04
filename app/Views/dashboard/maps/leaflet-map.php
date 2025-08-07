<div class="card">
    <div class="card-header">Standort der Universität Trier</div>
    <div class="card-body p-0">
        <div id="map" style="height: 400px; width: 100%;"></div>
    </div>
</div>

<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
/>
<script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js">
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const map = L.map('map').setView([49.745148290607496, 6.6878155391441085], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
        }).addTo(map);

        const marker = L.marker([49.745148290607496, 6.6878155391441085]).addTo(map);
        marker.bindPopup("Universität Trier").openPopup();

        setTimeout(() => map.invalidateSize(), 500); // falls Karte in verstecktem Container
    });
</script>
