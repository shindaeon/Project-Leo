const searchButton = document.getElementById("btn_search");
searchButton.addEventListener("click", () => {
  const searchValue = document.getElementById("searchBar").value;
  fetch('../../controllers/searchDestination.php?searchValue='+searchValue, {
      method: 'GET',
  })
  .then((response) => {
    response.text().then((data) => {
      if (data != "" || data != null) {
        document.querySelector("#cards").innerHTML = data;
      }
    });
  });
});
