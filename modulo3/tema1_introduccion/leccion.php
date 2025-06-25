<?php
// Lección del módulo 3 - Tema 1: Introducción a la resta como quitar
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lección: Introduccion a la Resta</title>
  <link rel="stylesheet" href="../../style.css">
</head>
<body>
  <!-- NAVBAR -->
  <div class="navbar-leccion">
    <div class="nav-left">
      <button class="btn-cerrar" onclick="window.location.href='../../detalle.php?modulo=3'">✕</button>
      <div class="progress-container">
        <div class="progress-bar"><div class="progress-fill" id="progressFill"></div></div>
        <span class="progress-text" id="progressText">1/10</span>
      </div>
    </div>
    <div class="nav-right">
      <div class="coins-display">
        <div class="coin-icon-small"><img src="../../assets/coin.png" alt="Moneda"></div>
        <span class="coins-count" id="coinsCount">0</span>
      </div>
      <div class="hearts-display">
        <span class="heart" id="heart1">❤️</span>
        <span class="heart" id="heart2">❤️</span>
        <span class="heart" id="heart3">❤️</span>
      </div>
    </div>
  </div>

  <!-- CONTENEDOR PRINCIPAL -->
  <div class="leccion-container">
    <div class="question-card">
      <div class="question-header">
        <h2 class="question-title" id="questionTitle">¿Pregunta?</h2>
      </div>
      <div class="timer-bar-container">
        <div id="timerBar" class="timer-bar-fill"></div>
        <div id="timerBarText" class="timer-bar-text"></div>
      </div>
      <div class="question-content" id="questionContent"></div>
      <div class="question-options" id="questionOptions"></div>
    </div>
    <div class="continue-section">
      <button class="btn-continue" id="btnContinue" onclick="nextQuestion()" disabled>Continuar</button>
    </div>
  </div>

  <!-- MODALES -->
  <div class="modal-overlay" id="correctModal">
    <div class="modal-content correct">
      <div class="modal-icon">🎉</div>
      <h3>¡Correcto!</h3>
      <p id="coinChangeTextCorrect">+100 monedas</p>
      <div class="motivational-text"></div>
      <button class="modal-btn" onclick="closeModal()">Continuar</button>
    </div>
  </div>

  <div class="modal-overlay" id="incorrectModal">
    <div class="modal-content incorrect">
      <div class="modal-icon">😔</div>
      <h3>¡Oops!</h3>
      <p id="correctAnswerText">La respuesta correcta es: X</p>
      <p id="coinChangeTextIncorrect" class="coin-change-text">-200 monedas</p>
      <div class="motivational-text"></div>
      <button class="modal-btn" onclick="closeModal()">Continuar</button>
    </div>
  </div>

  <div class="modal-overlay" id="completedModal">
    <div class="modal-content completed">
      <div class="modal-icon">🏁</div>
      <h3>¡Lección Completada!</h3>
      <div class="completion-stats">
        <div class="stat-item">
          <span class="stat-number" id="finalCoins">0</span>
          <span class="stat-label">Monedas</span>
        </div>
        <div class="stat-item">
          <span class="stat-number" id="finalAccuracy">0%</span>
          <span class="stat-label">Precisión</span>
        </div>
      </div>
      <div class="completion-buttons">
        <button class="modal-btn" onclick="restartLesson()">Repetir</button>
        <a href="../../detalle.php?modulo=3" class="modal-btn secondary">Volver al curso</a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js"></script>
  <script src="tema1.js"></script>
</body>
</html>