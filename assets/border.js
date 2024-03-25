document.addEventListener("DOMContentLoaded", function () {
    // Sélectionnez tous les éléments avec la classe "border-"
    const elements = document.querySelectorAll('[class*="border-"]');
  
    // Tableau des classes CSS disponibles
    const borderClasses = ["border-red", "border-blue", "border-green"];
  
    // Parcourez chaque élément et ajoutez une classe CSS aléatoire
    elements.forEach(function (element) {
      // Vérifiez si l'élément a déjà des classes CSS
      const existingClasses = element.getAttribute("class").split(" ");
      const borderClassesToRemove = existingClasses.filter((className) =>
        className.startsWith("border-")
      );
  
      // Retirez toutes les classes CSS "border-" existantes de l'élément
      borderClassesToRemove.forEach((className) => {
        element.classList.remove(className);
      });
  
      // Générez un index aléatoire
      const randomIndex = Math.floor(Math.random() * borderClasses.length);
  
      // Obtenez la classe CSS aléatoire
      const randomBorderClass = borderClasses[randomIndex];
  
      // Ajoutez la nouvelle classe CSS aléatoire à l'élément
      element.classList.add(randomBorderClass);
    });

    const elements2 = document.querySelectorAll('.display-full');

    const bgClasses = ["bg-red", "bg-blue", "bg-green"];

    elements2.forEach(function (element) {
      const randomIndex = Math.floor(Math.random() * bgClasses.length);
      element.classList.add(bgClasses[randomIndex]);
    })
  });