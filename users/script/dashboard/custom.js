function setSpanDate() {
  const dateSpan = document.getElementById("date-span");
  const dateElement = document.getElementById("date");
  const timeElement = document.getElementById("time");

  function updateDateTime() {
    const date = new Date();
    const day = date.toLocaleString("id-ID", {
      weekday: "long",
    });
    const dayNumber = date.getDate();
    const month = date.toLocaleString("id-ID", {
      month: "long",
    });
    const year = date.getFullYear();
    const hours = date.getHours().toString().padStart(2, "0");
    const minutes = date.getMinutes().toString().padStart(2, "0");
    const seconds = date.getSeconds().toString().padStart(2, "0");
    const formattedDate = `${day}, ${dayNumber} ${month} ${year}`;
    const formattedTime = `${hours}:${minutes}:${seconds}`;
    dateElement.textContent = formattedDate;
    timeElement.textContent = formattedTime;
  }

  updateDateTime();
  setInterval(updateDateTime, 1000);
}

document
  .getElementById("showCurrentPositionBtn")

  .addEventListener("click", function () {
    this.classList.add("animate");
    setTimeout(
      function () {
        this.classList.remove("animate");
      }.bind(this),
      500
    ); // remove the class after 500ms
    showCurrentPosition(); // call the showCurrentPosition function

    // add the overlay animation
    document.getElementById("map-overlay").classList.add("show");
    setTimeout(function () {
      document.getElementById("map-overlay").classList.remove("show");
    }, 2000); // remove the overlay after 2 seconds
  });

setSpanDate();

function startRouting() {
  const routeBtn = document.getElementById("btn-route");

  routeBtn.addEventListener("click", function (e) {
    const greetContent = document.getElementById("greet");
    const mapContainer = document.getElementById("ilalinMap");
    const rountingForm = document.getElementById("routingForm");

    const cardElContainer = document.createElement("div");

    const cardHtml = `<div class="card"></div>`;

    greetContent.style.marginTop = "-100%";
    rountingForm.style.bottom = "0%";

    cardElContainer.innerHTML = cardHtml;
    mapContainer.appendChild(cardElContainer);

    const cancelRouting = document.getElementById("cancelRouting");
    cancelRouting.addEventListener("click", function (e) {
      cardElContainer.remove();
      greetContent.style.marginTop = "0";
      rountingForm.style.bottom = "-100%";
    });
  });
}

startRouting();
