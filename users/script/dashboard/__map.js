async function getCpos() {
  return new Promise((resolve, reject) => {
    if (!navigator.geolocation) {
      console.log("Geolocation not supported");
      reject("Geolocation not supported");
      return;
    }

    navigator.geolocation.getCurrentPosition(
      (position) => {
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;
        resolve({ lat, lng });
      },
      (error) => {
        reject(error);
      }
    );
  });
}
async function resolveIlalinMap() {
  const ilalinMap = new L.map("ilalinMap", {
    zoomControl: false,
  });

  const tiles = L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 19,
    attribution:
      '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
  }).addTo(ilalinMap);

  const startMarker = L.marker([0, 0]);
  const endMarker = L.marker([0, 0]);
  const routing = L.Routing.control({
    collapsible: false,
    reverseWaypoints: true,
    show: true,
    geocoder: L.Control.Geocoder.nominatim({
      geocodingQueryParams: {
        countrycodes: "id",
      },
    }),
    position: "bottomleft",
  }).addTo(ilalinMap);

  async function routingMap() {
    try {
      const { lat, lng } = await getCpos();
      ilalinMap.setView([lat, lng], 20);
      startMarker.setLatLng([lat, lng]).addTo(ilalinMap);

      ilalinMap.on("click", (evt) => {
        const destLat = evt.latlng.lat;
        const destLng = evt.latlng.lng;

        endMarker.setLatLng(evt.latlng).addTo(ilalinMap);

        routing
          .setWaypoints([L.latLng(lat, lng), L.latLng(destLat, destLng)])
          .addTo(ilalinMap);

        const rountingForm = document.getElementById("routingForm");
        rountingForm.style.bottom = "0%";

        const cancelRouting = document.getElementById("cancelRouting");
        const greetContent = document.getElementById("greet");
        cancelRouting.addEventListener("click", function (e) {
          greetContent.style.marginTop = "0";
          rountingForm.style.bottom = "-100%";
        });
      });
    } catch (error) {
      console.error("Error:", error);
    }
  }
  routingMap();
}
resolveIlalinMap();
// [...document.querySelectorAll("[data-position]")].map((el, i) => {
//   return {
//     name: el.value,
//     coord: {
//       lat: el.dataset.lat,
//       lng: el.dataset.lng,
//     },
//   };
// });
// navigator.geolocation.getCurrentPosition((position) => {
//   const clat = position.coords.latitude;
//   const clng = position.coords.longitude;

//   console.log(clat, clng);
//   var marker = L.marker([clat, clng], { icon: taxiIcon }).addTo(map);
// });
