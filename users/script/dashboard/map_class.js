class LeafletMap {
  /**
   * Membuat instance objek LeafletMap.
   *
   * @param {string} mapId - ID elemen HTML tempat peta akan ditampilkan.
   * @param {Array<number>} [initialCoords=[-5.189293, 119.433751]] - Koordinat awal peta (latitude, longitude).
   * @param {number} [initialZoom=20] - Tingkat zoom awal peta.
   */
  constructor(
    mapId,
    initialCoords = [-5.189293, 119.433751],
    initialZoom = 20
  ) {
    // Membuat objek peta Leaflet dengan kontrol zoom dinonaktifkan.
    this.map = L.map(mapId, { zoomControl: false }).setView(
      initialCoords,
      initialZoom
    );
    // Inisialisasi layer untuk posisi saat ini.
    this.currentPositionLayer = null;

    // Menambahkan tile peta dari OpenStreetMap.
    this.addTiles();

    // Mendapatkan posisi saat ini dan menerbangkan peta ke lokasi tersebut.
    this.getCurrentPosition({ fly: true });

    // Memantau perubahan posisi secara terus menerus.
    this.watchPosition();
  }
  addTiles() {
    L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
      maxZoom: 19,
      attribution: "OSM",
    }).addTo(this.map);
  }

  updateCurrentPosition(position) {
    const lat = position.coords.latitude;
    const lng = position.coords.longitude;
    const accuracy = position.coords.accuracy;
    const curPositionMarker = L.marker([lat, lng]);
    // Menghapus layer posisi sebelumnya jika ada.
    if (this.currentPositionLayer) {
      this.map.removeLayer(this.currentPositionLayer);
    }

    // Membuat layer baru untuk posisi saat ini,
    // terdiri dari lingkaran akurasi dan marker.
    this.currentPositionLayer = L.featureGroup([curPositionMarker]).addTo(
      this.map
    );
  }

  getNavigatorPosition(coords) {
    if (!navigator.geolocation) {
      console.log("Geolocation not supported");
      return;
    }
    navigator.geolocation.getCurrentPosition(
      (position) => {
        coords(
          {
            latitude: position.coords.latitude,
            longitude: position.coords.longitude,
          },
          position
        );
      },
      (err) => {
        console.log(err);
      },
      { enableHighAccuracy: true }
    );
  }

  /**
   * Mendapatkan posisi saat ini dan memperbarui peta.
   *
   * @param {object} [opts] - Objek opsi.
   * @param {boolean} [opts.fly=false] - Apakah peta akan "terbang" ke lokasi saat ini.
   */
  getCurrentPosition(opts) {
    if (!navigator.geolocation) {
      console.log("Geolocation not supported");
      return;
    }
    this.getNavigatorPosition(({}, position) => {
      this.updateCurrentPosition(position);
      if (opts && opts.fly) {
        this.map.flyTo(
          [position.coords.latitude, position.coords.longitude],
          16
        );
      }
    });
  }

  /**
   * Memantau perubahan posisi dan memperbarui peta secara terus menerus.
   */
  watchPosition() {
    if (!navigator.geolocation) {
      console.log("Geolocation not supported");
      return;
    }

    navigator.geolocation.watchPosition(
      (position) => {
        this.updateCurrentPosition(position);
      },
      (err) => {
        console.log(err);
      },
      { enableHighAccuracy: true }
    );
  }

  /**
   * Menampilkan posisi saat ini pada peta dan "terbang" ke lokasi tersebut.
   */
  showCurrentPosition() {
    this.getCurrentPosition({ fly: true });
  }
}

class Routing extends LeafletMap {
  constructor(mapId) {
    super(mapId);

    this.destMarkers = L.marker([0, 0]).addTo(this.map);
  }

  addRoutingFromCurrentPositon(onRoutesFound) {
    if (!navigator.geolocation) {
      console.log("Geolocation not supported");
      return;
    }

    navigator.geolocation.getCurrentPosition((position) => {
      const cPosLat = position.coords.latitude;
      const cPosLng = position.coords.longitude;
      const routing = L.Routing.control({
        show: false,
      });

      this.map.on("click", (e) => {
        const { lat, lng } = e.latlng;
        console.log(this.destMarkers);
        this.destMarkers.setLatLng([lat, lng]);

        routing
          .setWaypoints([L.latLng(cPosLat, cPosLng), L.latLng(lat, lng)])
          .on("routesfound", onRoutesFound)
          .addTo(this.map);
      });
    });
  }
}
// Membuat instance dari class LeafletMap
const routingMap = new Routing("ilalinMap");
routingMap.addRoutingFromCurrentPositon((e) => {
  const inputTitikAwal = document.getElementById("inputTitikAwal");
  const inputTitikAkhir = document.getElementById("inputTitikAkhir");

  // Mendapatkan koordinat titik awal dari e.waypoints
  const titikAwal = e.waypoints[0].latLng;
  const latAwal = titikAwal.lat;
  const lngAwal = titikAwal.lng;

  // Mengisi inputTitikAwal dengan koordinat
  inputTitikAwal.value = `${latAwal}, ${lngAwal}`;

  // Mendapatkan koordinat titik akhir dari e.waypoints
  const titikAkhir = e.waypoints[1].latLng;
  const latAkhir = titikAkhir.lat;
  const lngAkhir = titikAkhir.lng;

  // Mengisi inputTitikAkhir dengan koordinat
  inputTitikAkhir.value = `${latAkhir}, ${lngAkhir}`;
});
// Create the map instance
// const map = L.map("map", {
//   zoomControl: false,
// }).setView([-5.189293, 119.433751], 20);

// // Define the tile layer
// const tiles = L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
//   maxZoom: 19,
//   attribution:
//     '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
// }).addTo(map);

// const currentPositionMarker = L.marker();

// function getCurrentPosition() {
//   if (!navigator.geolocation) {
//     console.log("Geolocation not supported");
//     return;
//   }
//   navigator.geolocation.getCurrentPosition((position) => {
//     const cPosLat = position.coords.latitude;
//     const cPosLng = position.coords.longitude;
//     map.on("click", function (e) {
//       const { lat, lng } = e.latlng;
//       var newMarker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);

//       L.Routing.control({
//         waypoints: [L.latLng(cPosLat, cPosLng), L.latLng(lat, lng)],
//       }).addTo(map);
//     });
//   });
// }
// getCurrentPosition();
