<?php
// Aquí puedes incluir lógica de autenticación, cargar contenido desde base de datos, etc.
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Detalle: Reconocimiento de números</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- NAVBAR -->
  <div class="navbar">
    <img src="assets/municipalidad.png" alt="Logo" class="logo">
    <nav>
      <a href="index.php" class="nav-link">
        <img src="assets/icono-panel.png" alt="Panel" class="nav-icon"> PANEL
      </a>
      <a href="cursos.php" class="nav-link active">
        <img src="assets/icono-cursos.png" alt="Cursos" class="nav-icon"> CURSOS
      </a>
    </nav>
    <div class="dropdown">
      <span>1º PRIMARIA</span><span class="arrow">&#9660;</span>
    </div>
  </div>

  <!-- CONTENEDOR PRINCIPAL -->
  <div class="detalle-container">
    
    <!-- VISTA DETALLE -->
    <div class="detalle-curso">

      <!-- Tarjeta izquierda -->
      <div class="detalle-card">
        <img src="assets/math.png" alt="Matemáticas" class="icon-detalle">
        <h2>Matemáticas</h2>
        <p class="descripcion-detalle">Descripción…</p>
        <div class="stats-detalle">
          <div class="stat">
            <img src="assets/icon-lecciones.png" alt="Lecciones">
            <span>55 lecciones</span>
          </div>
          <div class="stat">
            <img src="assets/icon-ejercicios.png" alt="Ejercicios">
            <span>75 ejercicios</span>
          </div>
        </div>
      </div>

      <!-- Panel derecho -->
      <div class="detalle-info">

        <!-- Pestaña Módulo -->
        <div class="module-tab active">
          MÓDULO I<br><small>Números del 1 al 10</small>
        </div>

        <!-- Contenedor del camino con tucán -->
        <div class="path-section">
          <!-- Camino + Óvalos -->
          <div class="path-container">
            <div class="path-step step-1">
              <div class="step-oval completed">
                <span class="step-text">Reconocimiento de números y su escritura.</span>
              </div>
            </div>
            <div class="path-step step-2">
              <div class="step-oval">
                <span class="step-text">Conteo con objetos reales</span>
              </div>
            </div>
            <div class="path-step step-3">
              <div class="step-oval">
                <span class="step-text">Asociación número-cantidad.</span>
              </div>
            </div>
            <!-- Líneas conectoras -->
            <div class="path-line line-1"></div>
            <div class="path-line line-2"></div>
          </div>
        </div>

        <!-- CTA Empezar/Continuar -->
        <div class="detalle-cta">
          <h3 id="ctaTitulo">Reconocimiento de números y su escritura.</h3>
          <button class="btn-empezar" id="btnInicioCurso">Empezar</button>
        </div>

      </div>
    </div>
  </div>

  <!-- Script para redirigir según el progreso -->
  <script>
    const currentTopic = localStorage.getItem('currentTopic');
    const boton = document.getElementById('btnInicioCurso');
    const titulo = document.getElementById('ctaTitulo');

    if (currentTopic === 'tema2') {
      boton.textContent = 'Continuar';
      boton.onclick = () => window.location.href = 'modulo1/tema2_conteo/tema2.php';
      titulo.textContent = 'Conteo con objetos reales';
    } else if (currentTopic === 'tema3') {
      boton.textContent = 'Continuar';
      boton.onclick = () => window.location.href = 'modulo1/tema3_asociacion/tema3.php';
      titulo.textContent = 'Asociación número-cantidad';
    } else {
      boton.textContent = 'Empezar';
      boton.onclick = () => window.location.href = 'modulo1/tema1_reconocimiento/leccion.php';
      titulo.textContent = 'Reconocimiento de números y su escritura.';
    }
  </script>
</body>
</html>









