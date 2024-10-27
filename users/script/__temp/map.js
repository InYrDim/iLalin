// Create the map instance
const map = L.map("map", {
  zoomControl: false,
}).setView([-5.189293, 119.433751], 20);

// Define the tile layer
const tiles = L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
  maxZoom: 19,
  attribution:
    '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
}).addTo(map);

// Define the current position layer
const search = new GeoSearch.GeoSearchControl({
  provider: new GeoSearch.OpenStreetMapProvider(),
});

map.addControl(search);

let currentPositionLayer;

// Function to update the current position
function updateCurrentPosition(position) {
  const lat = position.coords.latitude;
  const lng = position.coords.longitude;
  const accuracy = position.coords.accuracy;

  if (currentPositionLayer) {
    map.removeLayer(currentPositionLayer);
  }

  currentPositionLayer = L.featureGroup([
    L.circle([lat, lng], {
      color: "red",
      fillColor: "#f03",
      fillOpacity: 0.5,
      radius: accuracy,
    }),
    L.marker([lat, lng]),
  ]).addTo(map);
}

// Function to get the current position
function getCurrentPosition(opts) {
  if (!navigator.geolocation) {
    console.log("Geolocation not supported");
    return;
  }

  navigator.geolocation.getCurrentPosition(
    function (position) {
      updateCurrentPosition(position);
      if (opts && opts.fly) {
        map.flyTo([position.coords.latitude, position.coords.longitude], 16);
      }
    },
    function (err) {
      console.log(err);
    },
    {
      enableHighAccuracy: true,
    }
  );
}

// Function to watch the user's position
function watchPosition() {
  if (!navigator.geolocation) {
    console.log("Geolocation not supported");
    return;
  }

  navigator.geolocation.watchPosition(
    function (position) {
      updateCurrentPosition(position);
    },
    function (err) {
      console.log(err);
    },
    {
      enableHighAccuracy: true,
    }
  );
}

// Call getCurrentPosition on page load
getCurrentPosition({
  fly: true,
});

function showCurrentPosition() {
  getCurrentPosition({
    fly: true,
  });
}

document
  .querySelectorAll(".getCurrentLocationBtn")
  .entries()
  .forEach((entry) => {
    entry.addEventListener("click", showCurrentPosition);
  });

// Call watchPosition to track the user's position
watchPosition();
