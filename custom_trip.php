<!DOCTYPE html>
<html>


<head>
  <title>Interactive Trip Planner</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/nouislider@15.7.0/dist/nouislider.min.css" rel="stylesheet">
  <style>
    #map {
      height: 100vh;
    }

    .marker-img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      overflow: hidden;
      border: 3px solid #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }

    .sidebar {
      background: #f8f9fa;
      padding: 20px;
      height: 100vh;
      overflow-y: auto;
      border-right: 1px solid #ddd;
    }

    .noUi-target {
      border: 2px solid #007bff;
      height: 16px;
      background: #e9ecef;
      border-radius: 10px;
    }

    .noUi-connect {
      background: #007bff;
    }

    .noUi-handle {
      width: 20px;
      height: 20px;
      top: -3px;
      background: #007bff;
      border: 2px solid #0056b3;
      border-radius: 50%;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
      cursor: grab;
    }

    .noUi-horizontal .noUi-handle:before,
    .noUi-horizontal .noUi-handle:after {
      display: none;
    }

    .range-label {
      font-weight: 600;
      font-size: 15px;
      margin-top: 8px;
      color: #000;
    }

    .slider {
      display: flex;
      width: 100px;
      height: 100px;
      border-radius: 50%;
      overflow: hidden;
    }

    .slider img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      flex-shrink: 0;
      animation: slide 6s infinite;
    }

    @keyframes slide {
      0% {
        transform: translateX(0);
      }

      33% {
        transform: translateX(-100%);
      }

      66% {
        transform: translateX(-200%);
      }

      100% {
        transform: translateX(0);
      }
    }

    #map .leaflet-popup-content {
      text-align: center;
    }
  </style>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3 sidebar">
        <h5 class="mb-3">Plan Your Trip</h5>
        <form id="tripForm">
          <div class="mb-3">
            <label for="from" class="form-label">From</label>
            <select id="from" class="form-select" multiple></select>
          </div>
          <div class="mb-3">
            <label for="to" class="form-label">To</label>
            <select id="to" class="form-select" multiple></select>
          </div>
          <div class="mb-4">
            <label for="durationSlider" class="form-label">Trip Duration (in Nights)</label>
            <div id="durationSlider"></div>
            <div class="range-label text-center" id="durationRange">1N - 10N</div>
          </div>
          <div class="mb-4">
            <label for="priceSlider" class="form-label">Trip Price (in Rs)</label>
            <div id="priceSlider"></div>
            <div class="range-label text-center" id="priceRange">Rs. 5000 - Rs. 150000</div>
          </div>
          <div class="mb-4">
            <label class="form-label">Hotel Category</label>
            <div class="btn-group" role="group" id="hotelCategory">
              <button type="button" class="btn btn-primary active" data-value="3">⭐ 3</button>
              <button type="button" class="btn btn-outline-secondary" data-value="4">⭐ 4</button>
              <button type="button" class="btn btn-outline-secondary" data-value="5">⭐ 5</button>
            </div>
          </div>
          <button class="btn btn-primary w-100" type="submit">Plan Trip</button>
        </form>
      </div>
      <div class="col-md-9 px-0">
        <div id="map"></div>
      </div>
    </div>
  </div>
  <div></div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/nouislider@15.7.0/dist/nouislider.min.js"></script>

  <script>
    let allLocations = [];
    let map, markerMap = {}, routeLine;

    document.addEventListener('DOMContentLoaded', () => {
      const priceSlider = document.getElementById('priceSlider');
      const priceRange = document.getElementById('priceRange');
      const durationSlider = document.getElementById('durationSlider');
      const durationRange = document.getElementById('durationRange');
      const buttons = document.querySelectorAll('#hotelCategory button');

      let durationMin = 1, durationMax = 10;
      let priceMin = 5000, priceMax = 150000;
      let hotelCat = [3];

      const updateFormData = () => {
        const formData = {
          durationMin,
          durationMax,
          priceMin,
          priceMax,
          hotelCategory: hotelCat
        };

        $.ajax({
          url: 'assets/submit/get_coordinates.php',
          type: 'POST',
          contentType: 'application/json',
          data: JSON.stringify(formData),
          success: function (response) {
            if (response && response.destinations) {
              allLocations = response.destinations.map(item => {
                const lat = parseFloat(item.lat);
                const lng = parseFloat(item.lng);

                if (isNaN(lat) || isNaN(lng)) {
                  console.warn(`Invalid coordinates for ${item.name}:`, item.lat, item.lng);
                  return null;
                }

                return {
                  id: item.id.toString(),
                  name: item.name,
                  lat: lat,
                  lng: lng,
                  images: item.images || [item.image]
                };
              }).filter(Boolean); // remove nulls

              populateSelect('from', allLocations);
              populateSelect('to', allLocations);
              initMap(allLocations);
            }
          },
          error: function (xhr, status, error) {
            console.error('AJAX error:', error);
          }
        });
      };

      const populateSelect = (id, data) => {
        const select = document.getElementById(id);
        select.innerHTML = '';
        const defaultOpt = document.createElement('option');
        defaultOpt.value = '';
        defaultOpt.textContent = '-- Select --';
        select.appendChild(defaultOpt);

        data.forEach(loc => {
          const opt = document.createElement('option');
          opt.value = loc.id;
          opt.textContent = loc.name;
          select.appendChild(opt);
        });
      };

      const initMap = (locations) => {
        if (!map) {
          map = L.map('map'); // No setView
          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18 }).addTo(map);
        }

        // Clear old markers
        for (let id in markerMap) {
          map.removeLayer(markerMap[id]);
        }
        markerMap = {};

        locations.forEach(loc => {
          const popupHtml = `
            <div style="text-align:center;">
              <strong>${loc.name}</strong><br>
              <div class="slider">${loc.images.map(img => `<img src="${img}" alt="image">`).join('')}</div>
            </div>`;

          const marker = L.marker([loc.lat, loc.lng]).addTo(map).bindPopup(popupHtml);
          markerMap[loc.id] = marker;
        });

        // Fit map to all markers
        if (locations.length > 0) {
          const bounds = L.latLngBounds(locations.map(loc => [loc.lat, loc.lng]));
          map.fitBounds(bounds);
        }
         //hide leaflet lable bottom right conner
        $('.leaflet-control-attribution').hide();
      };

      $('#tripForm').on('submit', function (e) {
        e.preventDefault();
        if (routeLine) {
          map.removeLayer(routeLine);
        }

        const from = $('#from').val();
        const to = $('#to').val();

        if (!from || !to || from.length === 0 || to.length === 0) {
          alert("Please select both From and To destinations.");
          return;
        }

        const points = [...from, ...to].map(id => {
          const loc = allLocations.find(l => l.id === id);
          return loc ? [loc.lat, loc.lng] : null;
        }).filter(Boolean);

        if (points.length >= 2) {
          routeLine = L.polyline(points, { color: 'blue', weight: 4 }).addTo(map);
          map.fitBounds(routeLine.getBounds());
        }
      });

      buttons.forEach(button => {
        button.addEventListener('click', function () {
          this.classList.toggle('btn-primary');
          this.classList.toggle('btn-outline-secondary');
          this.classList.toggle('active');

          hotelCat = Array.from(document.querySelectorAll('#hotelCategory .active')).map(btn => btn.getAttribute('data-value'));
          updateFormData();
        });
      });

      if (durationSlider) {
        noUiSlider.create(durationSlider, {
          start: [1, 10],
          connect: true,
          step: 1,
          range: { min: 1, max: 10 }
        });

        durationSlider.noUiSlider.on('update', (values) => {
          durationMin = parseInt(values[0]);
          durationMax = parseInt(values[1]);
          durationRange.textContent = `${durationMin}N - ${durationMax}N`;
          updateFormData();
        });
      }

      if (priceSlider) {
        noUiSlider.create(priceSlider, {
          start: [5000, 150000],
          connect: true,
          step: 1000,
          range: { min: 5000, max: 150000 }
        });

        priceSlider.noUiSlider.on('update', (values) => {
          priceMin = parseInt(values[0]);
          priceMax = parseInt(values[1]);
          priceRange.textContent = `Rs. ${priceMin} - Rs. ${priceMax}`;
          updateFormData();
        });
      }

      updateFormData(); // Initial call
    });
    
    $(document).ready()
  </script>
</body>

</html>
