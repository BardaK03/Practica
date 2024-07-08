document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("filter-form");
  form.addEventListener("submit", function (event) {
    event.preventDefault();
    const limit = document.getElementById("limit").value;
    const offset = document.getElementById("offset").value;
    fetch(`principal.php?limit=${limit}&offset=${offset}`)
      .then((response) => response.json())
      .then((data) => {
        const tableBody = document.getElementById("movies-table-body");
        tableBody.innerHTML = "";
        data.forEach((movie) => {
          const row = document.createElement("tr");
          row.innerHTML = `
              <td>${movie.id}</td>
              <td>${movie.title}</td>
              <td>${movie.category}</td>
            `;
          tableBody.appendChild(row);
        });
      })
      .catch((error) => console.error(error));
  });
});
