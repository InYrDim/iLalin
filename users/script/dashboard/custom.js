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

  function displayAlert(message) {
    document.body.innerHTML += `
            <!-- Cancel Alert Componet -->
            <div style="z-index: 99999;" id="alert-modal" tabindex="-1"
                class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 bottom-0 z-50 flex justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full backdrop-blur">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="py-10 text-center">
                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <h3 class="text-lg font-normal text-gray-500 dark:text-gray-400">${message}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>`;
  }

  function sendFormDataAfterTime(data, time) {
    setTimeout(() => {
      const form = document.createElement("form");
      form.method = "POST";
      form.action = "action/gateway.php";

      const tripIdInput = document.createElement("input");
      tripIdInput.type = "hidden";
      tripIdInput.name = "trip_id";
      tripIdInput.value = data.trip_id;

      const tripStatusInput = document.createElement("input");
      tripStatusInput.type = "hidden";
      tripStatusInput.name = "trip_status";
      tripStatusInput.value = "ongoing";

      form.appendChild(tripStatusInput);
      form.appendChild(tripIdInput);

      document.body.appendChild(form);

      form.submit();
    }, time);
  }

  routeBtn.addEventListener("click", async function (e) {
    // Check if had payment with onGoing status
    await fetch("../controller/php/payment/checkPaymentStatus.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        status: "ongoing",
      }),
    })
      .then(function (response) {
        const contentType = response.headers.get("content-type");
        console.log(contentType);
        if (contentType && contentType.includes("application/json")) {
          return response.json(); // If JSON, parse it as JSON
        } else {
          return {
            status: "-",
          };
        }
      })
      .then(function (data) {
        if (data.status === "ongoing") {
          displayAlert("Masih ada pesanan yang sedang berlangsung");

          sendFormDataAfterTime(data, 2000);
        }
      });

    // Check if had payment with pending status
    await fetch("../controller/php/payment/checkPaymentStatus.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        status: "pending",
      }),
    })
      .then(function (response) {
        const contentType = response.headers.get("content-type");
        console.log(contentType);
        if (contentType && contentType.includes("application/json")) {
          return response.json(); // If JSON, parse it as JSON
        } else {
          return {
            status: "-",
          };
        }
      })
      .then(function (data) {
        if (data.status === "pending") {
          displayAlert("Pembayaran anda belum selesai");

          sendFormDataAfterTime(data, 2000);
        }
      });

    const greetContent = document.getElementById("greet");
    const mapContainer = document.getElementById("ilalinMap");
    const rountingForm = document.getElementById("routingForm");
    const routingStreetEl = document.getElementById("streetIdContainer");

    const cardElContainer = document.createElement("div");

    const cardHtml = `<div class="card"></div>`;

    greetContent.style.marginTop = "-100%";
    rountingForm.style.bottom = "0%";

    cardElContainer.innerHTML = cardHtml;
    mapContainer.appendChild(cardElContainer);

    const cancelRouting = document.getElementById("cancelRouting");
    cancelRouting.addEventListener("click", function (e) {
      if (routingStreetEl.style.display == "block") {
        routingStreetEl.style.display = "none";
      }
      cardElContainer.remove();
      greetContent.style.marginTop = "0";
      rountingForm.style.bottom = "-100%";
    });
  });
}

startRouting();
