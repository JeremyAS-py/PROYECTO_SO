<?php
// leccion.php para Tema 2: Conteo con objetos reales
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Conteo con objetos reales</title>
  <link rel="stylesheet" href="../../style.css">
</head>
<body>
  <!-- Navbar de lección -->
  <div class="navbar-leccion">
    <div class="nav-left">
      <button class="btn-cerrar" onclick="window.location.href='../../index.php'">✖</button>
      <div class="progress-container">
        <div class="progress-bar"><div class="progress-fill" id="progressFill"></div></div>
        <span class="progress-text" id="progressText">0%</span>
      </div>
    </div>
    <div class="nav-right">
      <div class="coins-display">
        <div class="coin-icon-small"><img src="../../assets/coin-symbol.png" alt="Coin"></div>
        <span class="coins-count" id="coinsCount">0</span>
      </div>
      <div class="hearts-display">
        <span class="heart" id="heart1">❤️</span>
        <span class="heart" id="heart2">❤️</span>
        <span class="heart" id="heart3">❤️</span>
      </div>
    </div>
  </div>

  <!-- Contenedor principal -->
  <div class="leccion-container">
    <div class="question-card">
      <div class="question-header"><h2 class="question-title" id="questionTitle"></h2></div>
      <div class="question-content" id="questionContent"></div>
      <div class="question-options" id="questionOptions"></div>
    </div>

    <div class="continue-section">
      <button class="btn-continue" id="btnContinue" onclick="nextQuestion()" disabled>Continuar</button>
    </div>
  </div>

  <!-- Modales -->
  <div class="modal-overlay" id="correctModal">
    <div class="modal-content correct">
      <div class="modal-icon">✅</div>
      <h3>¡Correcto!</h3>
      <button class="modal-btn" onclick="closeModal()">Seguir</button>
    </div>
  </div>

  <div class="modal-overlay" id="incorrectModal">
    <div class="modal-content incorrect">
      <div class="modal-icon">❌</div>
      <h3>¡Incorrecto!</h3>
      <p id="correctAnswerText"></p>
      <button class="modal-btn" onclick="closeModal()">Intentar otra</button>
    </div>
  </div>

  <div class="modal-overlay" id="completedModal">
    <div class="modal-content completed">
      <div class="modal-icon">🎉</div>
      <h3>¡Lección completada!</h3>
      <div class="completion-stats">
        <div class="stat-item"><span class="stat-number" id="finalCoins">0</span><div class="stat-label">Monedas</div></div>
        <div class="stat-item"><span class="stat-number" id="finalAccuracy">0%</span><div class="stat-label">Precisión</div></div>
      </div>
      <div class="completion-buttons">
        <button class="modal-btn" onclick="restartLesson()">Repetir</button>
        <button class="modal-btn secondary" onclick="window.location.href='../../detalle.php'">Salir</button>
      </div>
    </div>
  </div>

  <script src="tema2.js"></script>
</body>
</html>
