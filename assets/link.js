/**
 * JavaScript code that runs on DOMContentLoaded to handle:
 * - Toggling the display of the biblio element on click
 * - Setting up click handler to call setAudio() on audio elements
 */
import { setAudio } from "../assets/lecteur";

document.addEventListener("DOMContentLoaded", function () {
  var biblioContainer = document.querySelector(".Lbiblio");
  var biblioBtn = document.querySelector(".biblio");

  biblioBtn.addEventListener("click", function () {
    // Toggle la classe 'hidden' pour montrer/cacher la bibliothèque
    biblioContainer.classList.toggle("hidden");

    // Ajuster la propriété transform pour activer l'animation
    if (biblioContainer.classList.contains("hidden")) {
      biblioContainer.style.transform = "translateY(100%)";
    } else {
      biblioContainer.style.transform = "translateY(0)";
    }
  });

  $(".audio-container .ajouter").on("click", function () {
    const audiocontainer = $(this).closest(".audio-container");
    setAudio(audiocontainer, true);
  });
});
