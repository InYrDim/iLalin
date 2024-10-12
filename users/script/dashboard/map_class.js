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
      html: `<i style="filter: drop-shadow(3px 3px 2px #0000006e);" class="ri-map-pin-user-fill fs-2 text-danger
      "></i>`,
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

    const finishIcon = L.divIcon({
      html: `<i style="filter: drop-shadow(3px 3px 2px #0000006e);" class="ri-map-pin-user-fill fs-2 text-primary
      "></i>`,
    });
    const startIcon = L.divIcon({
      html: `<i style="filter: drop-shadow(3px 3px 2px #0000006e);" class="ri-map-pin-user-fill fs-2 text-secondary
      "></i>`,
    });

    this.startingPoint = new MapPoint("Starting Point", 0, 0, startIcon);
    this.finishingPoint = new MapPoint("Finishing Point", 0, 0, finishIcon);

    /**
     * Clearing Marker from Default Routing Machine
     **/
    this.routing = L.Routing.control({
      show: false,
      createMarker: function () {
        return null;
      },
    }).addTo(this.map);

    this.inputMarkers = {};
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

      input.value = place.formatted_address;

      input.dataset.lat = latllng.lat;
      input.dataset.lng = latllng.lng;

      if (input.id === "inputTitikAwal") {
        this.startingPoint.updateCoordinates(latllng);
        this.inputMarkers[input.id] = this.startingPoint;
      } else if (input.id === "inputTitikAkhir") {
        this.finishingPoint.updateCoordinates(latllng);
        this.inputMarkers[input.id] = this.finishingPoint;
      }

      this.map.panTo(latllng);

      this.inputMarkers[input.id].marker.addTo(this.map);

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
    const method = "TextSearch";

    const url = new URL("https://map-places.p.rapidapi.com/textsearch/json");
    url.searchParams.append("radius", "1500");
    url.searchParams.append("query", input);

    const response = await fetch(url.toString(), {
      method: "GET",
      headers: {
        "x-rapidapi-host": "map-places.p.rapidapi.com",
        "x-rapidapi-key": "5f9f3ef246msh62120fc2d9b85e5p10e3cdjsnf5d1040f6404",
      },
    });

    return await response.json();
  }
}

// Initialize the Routing map.
const routingMap = new Routing("ilalinMap");

// Set up search inputs.
const inputTitikAwal = document.getElementById("inputTitikAwal");
const inputTitikAkhir = document.getElementById("inputTitikAkhir");

routingMap.initSearch([inputTitikAwal, inputTitikAkhir]);
