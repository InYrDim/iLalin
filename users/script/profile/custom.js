function changePhoto(event) {
  const file = event.target.files[0];
  const reader = new FileReader();

  var c = new Croppie(document.getElementById("croppieContaier"), {
    viewPort: { width: 400, height: 400, type: "square" },
    boundary: { width: 200, height: 200 },
    enableOrientation: true,
    enableExif: true,
  });

  reader.onload = function (e) {
    const base64String = e.target.result;

    const image_container = document.getElementById("profileImage");

    c.bind({
      url: base64String,
    });

    const cropbtn = document.getElementById("cropBtn");
    const cropImage = document.getElementById("cropImage");

    cropbtn.addEventListener("click", function () {
      c.result({ type: "canvas", size: { width: 600, height: 600 } }).then(
        (res) => {
          image_container.src = res;

          fetch("profile.php", {
            method: "POST",
            body: JSON.stringify({
              image: res,
              btn: "crop",
            }),
            headers: {
              "Content-Type": "application/json",
            },
          }).then((response) => {
            if (response.status === 200) {
              window.location.reload();
            }
          });
        }
      );
    });

    cropImage.addEventListener("hide.bs.modal", function () {
      c.destroy();
    });

    // Send fetch request to the PHP script
  };
  if (file) {
    reader.readAsDataURL(file);
  }
}
