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
                <div class="streak-days"><b>0 día(s)</b></div>
                <div class="streak-desc">De aprendizaje</div>
            </div>
            <div class="coins card">
                <div class="coins-value"><b>1000</b></div>
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
                <div class="recommended-badge">RECOMENDADO</div>
                <h2>Matemáticas</h2>
                <img src="assets/math.png" alt="Matemáticas" class="icon-xl">
                <button class="start-btn" id="startBtn">Empezar</button>
            </div>

            <div class="courses-panel">
                <div class="course-icon"><img src="assets/math.png" alt="Math"></div>
                <div class="course-icon"><img src="assets/cerdito.png" alt="Cerdito"></div>
                <div class="course-icon"><img src="assets/libro.png" alt="Libro"></div>
                <div class="course-icon"><img src="assets/reloj.png" alt="Reloj"></div>
                <div class="course-icon"><img src="assets/mano.png" alt="Mano"></div>
                <div class="course-icon"><img src="assets/meditacion.png" alt="Meditación"></div>
                <div class="course-icon"><img src="assets/pinceles.png" alt="Pinceles"></div>
                <div class="course-icon"><img src="assets/ciencia.png" alt="Ciencia"></div>
                <div class="course-icon"><img src="assets/reciclaje.png" alt="Reciclaje"></div>
                <div class="course-icon"><img src="assets/computadora.png" alt="Computadora"></div>
            </div>
        </div>
    </div>

    <script>
      const startBtn = document.getElementById('startBtn');
      const current = localStorage.getItem('currentTopic');

      if (current === 'tema2') {
        startBtn.textContent = 'Continuar';
        startBtn.onclick = () => window.location.href = 'detalle.php';
      } else if (current === 'tema3') {
        startBtn.textContent = 'Continuar';
        startBtn.onclick = () => window.location.href = 'detalle.php';
      } else if (current === 'tema1') {
        startBtn.textContent = 'Continuar';
        startBtn.onclick = () => window.location.href = 'detalle.php';
      } else {
        startBtn.textContent = 'Empezar';
        startBtn.onclick = () => window.location.href = 'detalle.php';
      }
    </script>
</body>
</html>



