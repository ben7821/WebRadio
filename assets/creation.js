const newAudio = document.querySelector(".new_audio");
let selectedEmission = null;
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".emission-row").forEach((row) => {
    row.addEventListener("click", () => {
      var id = row.dataset.id;
      selectedEmission = id;

      fetch(`/creation/${id}/audios`)
        .then((response) => response.json())
        .then((data) => {
          var audios = document.querySelector(".audios");

          audios.innerHTML = "";

          if (data.length > 0) {
            data.forEach((audio) => {
              var tr = document.createElement("tr");

              tr.innerHTML = `
                <td>${audio.ID}</td>
                <td>${audio.NOM}</td>
                <td>${audio.DESCRIPTION}</td>
                <td>${audio.HEURE}</td>
                <td>${audio.DATE}</td>
                <td>${audio.AUDIO}</td>
                <td>${audio.AUTEURS}</td>
                <td>
                    <a href="/audio/${audio.ID}">show</a>
                    <a href="/audio/${audio.ID}/edit">edit</a>
                </td>
              `;

              audios.appendChild(tr);
            });
          } else {
            var tr = document.createElement("tr");

            tr.innerHTML = `<td colspan="7">Pas d'audio</td>`;

            audios.appendChild(tr);
          }
        })
        .catch((error) => {
          console.log(error);
        });
    });
  });

  newAudio.addEventListener("click", (event) => {
    if (selectedEmission) {
      event.preventDefault();
      window.location.href = `{{ path('app_audio_new')}}?emission=${selectedEmission}`;
    }
  });
});
