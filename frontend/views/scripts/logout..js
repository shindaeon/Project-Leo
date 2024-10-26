function logout() {
  fetch("/controllers/logout_handler.php")
    .then((response) => response.text())
    .then((data) => {
      if (data == "success") {
        window.location.href = "/";
      } else {
        alert(
          "There seems to be an issue logging you out. Please try again later."
        );
        console.log(data);
      }
    });
}
