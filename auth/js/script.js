// Validate The Confirm Password
document
  .getElementById("confirm_password")
  .addEventListener("input", function () {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirm_password").value;

    if (password !== confirmPassword) {
      document
        .getElementById("confirm_password")
        .setCustomValidity("Passwords did not match");
    } else {
      document.getElementById("confirm_password").setCustomValidity("");
    }
  });
