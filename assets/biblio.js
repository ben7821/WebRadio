document.addEventListener("DOMContentLoaded", function () {
    const biblioButton = document.querySelector('.biblio');
    const dropUp = document.querySelector('.drop-up');

    biblioButton.addEventListener('mouseenter', function () {
      dropUp.style.animation = 'fadeInUp 0.5s ease-in-out';
    });

    biblioButton.addEventListener('mouseleave', function () {
      dropUp.style.animation = 'fadeOutUp 0.5s ease-in-out';
    });
  });


  