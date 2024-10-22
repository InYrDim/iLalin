// Utility function to debounce events.
function debounce(func, delay) {
  let timeoutId;
  return function (...args) {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(() => func.apply(this, args), delay);
  };
}

// Utility function to create elements with specific classes.
function createElement(elname, classList) {
  const el = document.createElement(elname);
  el.classList.add(...classList);
  return el;
}

// Class to represent a point on the map (like starting or finishing points).
class MapPoint {
  constructor(name, lat, ing, icon) {
    this.name = name;
    this.coordinates = L.latLng(lat, ing);
    this.marker = L.marker([lat, ing], { icon: icon }); // Leaflet marker with custom icon
    this.element = null;
  }

  addToMap(map) {
    this.marker.addTo(map);
  }

  updateCoordinates(lat, ing) {
    this.coordinates = L.latLng(lat, ing);
    this.marker.setLatLng(lat, ing);
  }
}

// LeafletMap class manages the map creation and current position tracking.
class LeafletMap {
  constructor(
    mapId,
    initialCoords = [-5.189293, 119.433751],
    initialZoom = 20
  ) {
    this.map = L.map(mapId, { zoomControl: false }).setView(
      initialCoords,
      initialZoom
    );
    this.currentPositionLayer = null;
    this.addTiles();
    this.getCurrentPosition({ fly: true });
    // this.watchPosition();
  }

  addTiles() {
    L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
      maxZoom: 19,
      attribution: "OSM",
    }).addTo(this.map);
  }

  updateCurrentPosition(position) {
    const { latitude: lat, longitude: lng } = position.coords;

    const icon = L.divIcon({
      html: `<i style="filter: drop-shadow(3px 3px 2px #0000006e);position: absolute;bottom: 100%;left: 0;right: 0;" class="ri-map-pin-user-fill fs-2 text-danger
      "></i>`,
      iconSize: [32, 32],
    });

    const marker = L.marker([lat, lng], { icon: icon });

    if (this.currentPositionLayer) {
      this.map.removeLayer(this.currentPositionLayer);
    }

    this.currentPositionLayer = L.featureGroup([marker]).addTo(this.map);
  }

  getNavigatorPosition(callback) {
    navigator.geolocation.getCurrentPosition(
      (position) => callback(position),
      (err) => console.log(err),
      { enableHighAccuracy: true }
    );
  }

  getCurrentPosition(opts) {
    this.getNavigatorPosition((position) => {
      this.updateCurrentPosition(position);
      if (opts.fly) {
        this.map.flyTo(
          [position.coords.latitude, position.coords.longitude],
          16
        );
      }
    });
  }

  watchPosition() {
    navigator.geolocation.watchPosition(
      (position) => this.updateCurrentPosition(position),
      (err) => console.log(err),
      { enableHighAccuracy: true }
    );
  }
}

// Routing class extends LeafletMap and adds search and routing functionality.
class Routing extends LeafletMap {
  constructor(mapId) {
    super(mapId);

    this.startingPoint = new MapPoint("Starting Point", 0, 0);
    this.finishingPoint = new MapPoint("Finishing Point", 0, 0);

    /**
     * Clearing Marker from Default Routing Machine (?), mybe not
     **/
    this.routing = this.initRouting();

    this.inputMarkers = {};
  }

  initRouting() {
    const finishIcon = L.divIcon({
      html: `<i style="filter: drop-shadow(3px 3px 2px #0000006e);position: absolute;bottom: 100%;left: 0;right: 0;" class="ri-map-pin-user-fill fs-2 text-primary
      "></i>`,
      iconSize: [32, 32],
    });
    const startIcon = L.divIcon({
      html: `<i style="filter: drop-shadow(3px 3px 2px #0000006e);position: absolute;bottom: 100%;left: 0;right: 0;" class="ri-map-pin-user-fill fs-2 text-secondary
      "></i>`,
      iconSize: [32, 32],
    });

    return L.Routing.control({
      show: false,
      createMarker: function (i, wp, n) {
        let marker_icon = null;
        if (i == 0) {
          marker_icon = startIcon;
        } else if (i == n - 1) {
          marker_icon = finishIcon;
        }
        return L.marker(wp.latLng, { icon: marker_icon });
      },
    }).addTo(this.map);
  }

  cancelRouting() {
    if (this.routing != null) {
      this.map.removeControl(this.routing);
      this.routing = null;
      this.inputs.forEach((input) => {
        input.value = "";
        input.dataset.lat = "";
        input.dataset.lng = "";
      });
    }
  }

  startRouting(startPoint, endPoint) {
    console.log("startRouting:", startPoint, endPoint);
    console.log(this.map);
    this.routing.setWaypoints([
      L.latLng(startPoint.coordinates),
      L.latLng(endPoint.coordinates),
    ]);
  }
  checkAndStartRouting() {
    const [inputTitikAwal, inputTitikAkhir] = this.inputs;
    const startLat = parseFloat(inputTitikAwal.dataset.lat);
    const startLng = parseFloat(inputTitikAwal.dataset.lng);
    const endLat = parseFloat(inputTitikAkhir.dataset.lat);
    const endLng = parseFloat(inputTitikAkhir.dataset.lng);

    if (
      !isNaN(startLat) &&
      !isNaN(startLng) &&
      !isNaN(endLat) &&
      !isNaN(endLng)
    ) {
      const startLatLng = L.latLng(startLat, startLng);
      const finisihLatLng = L.latLng(endLat, endLng);

      const routingStreetEl = document.getElementById("streetIdContainer");
      if (routingStreetEl.style.display == "none") {
        routingStreetEl.style.display = "block";
      }
      this.routing.on("routesfound", function (e) {
        var routes = e.routes;
        var summary = routes[0].summary;

        const distance = Math.round(summary.totalDistance / 1000);

        document.getElementById("routingDistanceId").innerHTML =
          distance + "km";
      });

      // Update koordinat startingPoint dan finishingPoint
      this.startingPoint.updateCoordinates(startLatLng);
      this.finishingPoint.updateCoordinates(finisihLatLng);

      console.log("All Is GOOD!");
      // All is good, Mulai routing
      this.startRouting(this.startingPoint, this.finishingPoint);
    }
  }
  initSearch(inputs) {
    const searchResultOptions = this.createSearchResultContainer();

    this.inputs = inputs;

    inputs.forEach((input) => {
      const optionsContainer = this.createOptionsContainer(input.id);

      // Listen for the 'keydown' event and check for the Enter key.
      input.addEventListener("keydown", async (event) => {
        if (event.key === "Enter") {
          await this.updateSearchResults(
            input,
            optionsContainer,
            searchResultOptions
          );
        }
      });

      input.addEventListener("focusout", () => {
        setTimeout(() => {
          this.removeSearchResult(optionsContainer.id);

          // this.checkAndStartRouting(inputs);
        }, 1000);
      });
    });
  }

  createSearchResultContainer() {
    const container = createElement("div", [
      "position-absolute",
      "w-100",
      "-bottom-100",
      "mt-1",
    ]);
    container.style.zIndex = 10;
    return container;
  }

  createOptionsContainer(inputId) {
    const container = createElement("div", [
      "search-results-container",
      "flex",
      "flex-column",
      "border-1",
      "border",
      "border-primary",
      "rounded",
      "bg-white",
      "shadow",
      "white",
    ]);
    container.id = `search-result-${inputId}`;
    return container;
  }

  async updateSearchResults(input, optionsContainer, searchResultOptions) {
    const places = await this.searchPlaces({ input: input.value });

    optionsContainer.innerHTML = "";

    this.removeExistingSearchResult(input);

    searchResultOptions.appendChild(optionsContainer);
    input.insertAdjacentElement("afterend", searchResultOptions);

    places.results.forEach((place) => {
      const option = this.createPlaceOption(place, input);
      optionsContainer.appendChild(option);
    });
  }

  createPlaceOption(place, input) {
    const option = document.createElement("div");
    option.classList.add(
      "placeOption",
      "py-2",
      "px-1",
      "border",
      "border-bottom-1",
      "lh-sm"
    );
    option.textContent = place.name;
    option.dataset.lat = place.geometry.location.lat;
    option.dataset.lng = place.geometry.location.lng;

    const span = document.createElement("span");
    span.classList.add("d-block", "opacity-75");
    span.style.fontSize = "0.8rem";
    span.textContent = place.formatted_address;
    option.appendChild(span);

    option.addEventListener("click", () => {
      const latllng = L.latLng([
        place.geometry.location.lat,
        place.geometry.location.lng,
      ]);

      input.value = place.name;

      input.dataset.lat = latllng.lat;
      input.dataset.lng = latllng.lng;

      if (input.id === "inputTitikAwal") {
        this.startingPoint.updateCoordinates(latllng);
        this.inputMarkers[input.id] = this.startingPoint;

        const startPoint = document.getElementById("startpoint");
        startPoint.children[0].innerHTML = place.name;
        startPoint.children[1].innerHTML = place.formatted_address;
      } else if (input.id === "inputTitikAkhir") {
        this.finishingPoint.updateCoordinates(latllng);
        this.inputMarkers[input.id] = this.finishingPoint;

        const startPoint = document.getElementById("endpoint");
        startPoint.children[0].innerHTML = place.name;
        startPoint.children[1].innerHTML = place.formatted_address;
      }

      // this.map.panTo(latllng);

      this.checkAndStartRouting();
    });

    return option;
  }

  removeExistingSearchResult(input) {
    const existingResult = input.nextElementSibling;
    console.log(existingResult);
    if (existingResult?.tagName === "DIV") {
      existingResult.remove();
    }
  }

  removeSearchResult(containerId) {
    document.getElementById(containerId)?.remove();
  }

  async searchPlaces({ input }) {
    const MAPS_API_URL = "https://google-map-places.p.rapidapi.com";
    const RAPID_API_KEY = "5f9f3ef246msh62120fc2d9b85e5p10e3cdjsnf5d1040f6404";
    const RAPID_API_HOST = "google-map-places.p.rapidapi.com";

    const client = new RapidAPIClient(
      RAPID_API_KEY,
      MAPS_API_URL,
      RAPID_API_HOST
    );

    try {
      const data = client.get("maps/api/place/textsearch/json", {
        radius: "1500",
        query: input,
      });

      console.log(data);

      return data;
    } catch (error) {
      console.log(error);
    }
  }
}

class RapidAPIClient {
  constructor(apiKey, url, rapidhost) {
    this.apiKey = apiKey;
    this.baseUrl = url;
    this.rapidapihost = rapidhost;
  }

  async get(endpoint, params = {}) {
    const queryString = new URLSearchParams(params).toString();
    const url = `${this.baseUrl}/${endpoint}?${queryString}`;

    try {
      const response = await fetch(url, {
        method: "GET",
        headers: {
          "x-rapidapi-key": this.apiKey,
          "x-rapidapi-host": this.rapidapihost,
        },
      });

      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }

      const data = await response.json(); // Parse the JSON response
      return data; // Return the response data
    } catch (error) {
      console.error("Error calling API:", error);
      throw error; // Rethrow the error for further handling
    }
  }
}

// Initialize the Routing map.
const routingMap = new Routing("ilalinMap");

// Set up search inputs.
const inputTitikAwal = document.getElementById("inputTitikAwal");
const inputTitikAkhir = document.getElementById("inputTitikAkhir");

routingMap.initSearch([inputTitikAwal, inputTitikAkhir]);

const cancelRouting = document.getElementById("cancelRouting");
cancelRouting.addEventListener("click", (e) => {
  routingMap.cancelRouting(e);
});
