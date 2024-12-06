document.addEventListener("DOMContentLoaded", function () {
    // Ajout d'animation hover sur les liens
    const navLinks = document.querySelectorAll("header nav ul li a");

    navLinks.forEach(link => {
        link.addEventListener("mouseover", function () {
            link.style.transform = "scale(1.1)";
            link.style.transition = "transform 0.3s ease";
        });

        link.addEventListener("mouseout", function () {
            link.style.transform = "scale(1)";
        });
    });
    // Configuration des particules (dans le fichier scripts.js ou directement dans le HTML)
particlesJS('particles-js', {
    particles: {
      number: {
        value: 80,
        density: {
          enable: true,
          value_area: 800
        }
      },
      color: {
        value: '#ffffff'
      },
      shape: {
        type: 'circle',
        stroke: {
          width: 0,
          color: '#000000'
        }
      },
      opacity: {
        value: 0.5,
        random: true,
        anim: {
          enable: true,
          speed: 1,
          opacity_min: 0.1
        }
      },
      size: {
        value: 3,
        random: true,
        anim: {
          enable: true,
          speed: 40,
          size_min: 0.1
        }
      },
      line_linked: {
        enable: true,
        distance: 150,
        color: '#ffffff',
        opacity: 0.4,
        width: 1
      },
      move: {
        enable: true,
        speed: 6,
        direction: 'none',
        random: false,
        straight: false,
        out_mode: 'out',
        bounce: false
      }
    },
    interactivity: {
      detect_on: 'canvas',
      events: {
        onhover: {
          enable: true,
          mode: 'repulse'
        },
        onclick: {
          enable: true,
          mode: 'push'
        }
      }
    },
    retina_detect: true
  });
  

    // Boutons interactifs (si ajoutés dans le futur)
    const buttons = document.querySelectorAll("button");
    buttons.forEach(button => {
        button.addEventListener("mouseover", function () {
            button.style.boxShadow = "0px 4px 10px rgba(0, 0, 0, 0.2)";
            button.style.transform = "scale(1.05)";
        });

        button.addEventListener("mouseout", function () {
            button.style.boxShadow = "none";
            button.style.transform = "scale(1)";
        });
    });
});
