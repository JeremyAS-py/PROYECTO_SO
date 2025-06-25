<?php
// Aquí puedes incluir lógica de sesión, usuario o cargar datos desde BD
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Escolar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="navbar">
        <img src="assets/municipalidad.png" alt="Logo" class="logo">
        <nav>
            <a href="index.php" class="nav-link active"><img src="assets/icono-panel.png" alt="Panel" class="nav-icon"> PANEL</a>
            <a href="cursos.php" class="nav-link"><img src="assets/icono-cursos.png" alt="Cursos" class="nav-icon"> CURSOS</a>
        </nav>
        <div class="dropdown">
            <span>1º PRIMARIA</span>
            <span class="arrow">&#9660;</span>
        </div>
    </div>

    <div class="dashboard">
        <div class="left-panel">
            <div class="streak card">
                <h2>Racha</h2>
                <img src="assets/fuego.png" alt="Fuego" class="icon-lg">
                <div class="streak-days"><b id="streakCount">0 día(s)</b></div>
                <div class="streak-desc">De aprendizaje</div>
            </div>
            <div class="coins card">
                <div class="coins-value"><b id="userCoins">1000</b></div>
                <div class="coin-row">
                    <div class="coin-icon">
                        <img src="assets/coin-symbol.png" alt="Moneda">
                    </div>
                    <span>Coins</span>
                </div>
            </div>
            <div class="completed card">
                <div class="completed-value"><b>0/10</b></div>
                <div>Cursos Completados</div>
            </div>
        </div>

        <div class="main-panel">
            <div class="recommended card">
                <div class="recommended-badge" id="recomendadoBadge">RECOMENDADO</div>
                <h2 id="mainCursoTitle">Matemáticas</h2>
                <img src="assets/math.png" alt="Matemáticas" class="icon-xl" id="mainCursoImg">
                <button class="start-btn" id="startBtn">Empezar</button>
            </div>

            <div class="courses-panel">
                <div class="course-icon" data-curso="matematicas"><img src="assets/math.png" alt="Math"></div>
                <div class="course-icon" data-curso="cerdito"><img src="assets/cerdito.png" alt="Cerdito"></div>
                <div class="course-icon" data-curso="comunicacion"><img src="assets/libro.png" alt="Libro"></div>
                <div class="course-icon" data-curso="historia"><img src="assets/reloj.png" alt="Reloj"></div>
                <div class="course-icon" data-curso="ciencia"><img src="assets/mano.png" alt="Mano"></div>
                <div class="course-icon" data-curso="dpcc"><img src="assets/meditacion.png" alt="Meditación"></div>
                <div class="course-icon" data-curso="carpinteria"><img src="assets/pinceles.png" alt="Pinceles"></div>
                <div class="course-icon" data-curso="cienciasocial"><img src="assets/ciencia.png" alt="Ciencia"></div>
                <div class="course-icon" data-curso="reciclaje"><img src="assets/reciclaje.png" alt="Reciclaje"></div>
                <div class="course-icon" data-curso="computacion"><img src="assets/computadora.png" alt="Computadora"></div>
            </div>
        </div>
    </div>

    <script>
      // Monedas actuales
      const coins = parseInt(localStorage.getItem('coins')) || 0;
      document.getElementById('userCoins').textContent = coins;

      // Manejo de racha de días
      function updateStreak() {
        const streakKey = 'userStreak';
        const lastVisitKey = 'lastVisit';
        const today = new Date();
        const lastVisit = localStorage.getItem(lastVisitKey);
        let streak = parseInt(localStorage.getItem(streakKey)) || 0;
        let showStreak = 1;

        if (lastVisit) {
          const last = new Date(lastVisit);
          const diffTime = today.setHours(0,0,0,0) - last.setHours(0,0,0,0);
          const diffDays = diffTime / (1000 * 60 * 60 * 24);

          if (diffDays === 1) {
            streak += 1;
            showStreak = streak;
          } else if (diffDays === 0) {
            showStreak = streak;
          } else {
            streak = 1;
            showStreak = streak;
          }
        }

        localStorage.setItem(streakKey, showStreak);
        localStorage.setItem(lastVisitKey, (new Date()).toISOString());
        document.getElementById('streakCount').textContent = `${showStreak} día(s)`;
      }

      updateStreak();

      // CURSO INFO PARA LA TARJETA PRINCIPAL
      const cursosInfo = {
        matematicas: {
          nombre: "Matemáticas",
          imagen: "assets/math.png"
        },
        cerdito: {
          nombre: "Educación Financiera",
          imagen: "assets/cerdito.png"
        },
        comunicacion: {
          nombre: "Comunicación",
          imagen: "assets/libro.png"
        },
        historia: {
          nombre: "Historia y Cultura",
          imagen: "assets/reloj.png"
        },
        ciencia: {
          nombre: "Ciencia del Entorno",
          imagen: "assets/mano.png"
        },
        dpcc: {
          nombre: "Desarrollo Personal, Cívica y Ciudadanía",
          imagen: "assets/meditacion.png"
        },
        carpinteria: {
          nombre: "Carpinteria",
          imagen: "assets/pinceles.png"
        },
        cienciasocial: {
          nombre: "Ciencias Sociales",
          imagen: "assets/ciencia.png"
        },
        reciclaje: {
          nombre: "Reciclaje",
          imagen: "assets/reciclaje.png"
        },
        computacion: {
          nombre: "Computación",
          imagen: "assets/computadora.png"
        }
      };

      // Selecciona elementos principales
      const mainTitle = document.getElementById('mainCursoTitle');
      const mainImg = document.getElementById('mainCursoImg');
      const mainBtn = document.getElementById('startBtn');
      const recomendadoBadge = document.getElementById('recomendadoBadge');

      // Por defecto selecciona matemáticas
      let cursoActual = 'matematicas';

      // Cambia la tarjeta principal al hacer click en un curso
      document.querySelectorAll('.course-icon').forEach(icon => {
        icon.addEventListener('click', function() {
          const curso = this.getAttribute('data-curso');
          if (cursosInfo[curso]) {
            mainTitle.textContent = cursosInfo[curso].nombre;
            mainImg.src = cursosInfo[curso].imagen;
            mainImg.alt = cursosInfo[curso].nombre;
            mainBtn.textContent = 'Empezar';
            cursoActual = curso;
            localStorage.setItem('cursoSeleccionado', curso);

            // Mostrar "Recomendado" solo para Matemáticas
            if (curso === "matematicas") {
              recomendadoBadge.style.display = "block";
            } else {
              recomendadoBadge.style.display = "none";
            }
          }
        });
      });

      // Inicialmente, el badge debe mostrarse solo si es matemáticas
      window.onload = function() {
        if(cursoActual === "matematicas") {
          recomendadoBadge.style.display = "block";
        } else {
          recomendadoBadge.style.display = "none";
        }
      };

      // Botón principal
      mainBtn.onclick = function() {
        const curso = localStorage.getItem('cursoSeleccionado') || cursoActual;

        if (curso === "matematicas") {
          window.location.href = "detalle.php";
        } else if (curso === "comunicacion") {
          window.location.href = "detalle_comunicacion.php?modulo=1";
        } else {
          alert("Próximamente disponible");
        }
      };
    </script>
</body>
</html>