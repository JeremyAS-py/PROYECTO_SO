<?php
// Lección del tema 1: Introducción a la suma como juntar
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Introducción a la suma - Suma hasta 10</title>
    <link rel="stylesheet" href="../../../style.css">
</head>
<body>
    <div class="navbar">
        <a href="../../../index.php">Inicio</a>
        <a href="../../cursos.php">Cursos</a>
        <span>Módulo 2 - Tema 1: Introducción a la suma</span>
    </div>
    <main>
        <h2>Introducción a la suma: Juntar cantidades</h2>
        <div class="lesson-header">
            <div class="coins">
                <span>Monedas: <span id="coinsCount">0</span></span>
            </div>
            <div class="hearts">
                <span id="heart1" class="heart">❤️</span>
                <span id="heart2" class="heart">❤️</span>
                <span id="heart3" class="heart">❤️</span>
            </div>
        </div>
        <div class="progress-bar">
            <div id="progressFill" class="progress-fill"></div>
            <span id="progressText" class="progress-text"></span>
        </div>
        <div class="timer-bar">
            <div id="timerBar" class="timer-fill"></div>
            <span id="timerBarText" class="timer-text"></span>
        </div>
        <div id="questionTitle" class="question-title"></div>
        <div id="questionContent" class="question-content"></div>
        <div id="questionOptions" class="question-options"></div>
        <button id="btnContinue" onclick="nextQuestion()" disabled>Siguiente</button>
    </main>

    <!-- Modales de feedback -->
    <div id="correctModal" class="modal-overlay">
        <div class="modal-content">
            <h3>¡Correcto!</h3>
            <span id="coinChangeTextCorrect"></span>
            <div class="motivational-text"></div>
            <button onclick="closeModal()">Continuar</button>
        </div>
    </div>
    <div id="incorrectModal" class="modal-overlay">
        <div class="modal-content">
            <h3>Incorrecto</h3>
            <span id="coinChangeTextIncorrect"></span>
            <div id="correctAnswerText"></div>
            <div class="motivational-text"></div>
            <button onclick="closeModal()">Continuar</button>
        </div>
    </div>
    <div id="completedModal" class="modal-overlay">
        <div class="modal-content">
            <h3>¡Lección completada!</h3>
            <p>Monedas finales: <span id="finalCoins"></span></p>
            <p>Puntaje: <span id="finalAccuracy"></span></p>
            <button onclick="restartLesson()">Reintentar</button>
            <button onclick="goToNextLesson()">Siguiente tema</button>
        </div>
    </div>

    <script src="tema1.js"></script>
    <!-- Si usas una librería de confetti, inclúyela aquí -->
</body>
</html>