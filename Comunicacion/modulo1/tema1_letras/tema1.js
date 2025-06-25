// Tema 1: Reconozco letras del abecedario (Comunicación)
// Elige la letra correcta según el emoji/imagen

let currentQuestionIndex = 0;
let coins = 0;
let hearts = 3;
let correctAnswers = 0;
let selectedOption = null;
let timerInterval;
let timerValue = 10;
let timeTaken = 0;

const questions = [
  { 
    type: 'letter_recognition', 
    title: "¡Mira este lindo animalito! ¿Con qué letra empieza su nombre?", 
    content: "🐝 Abeja", 
    options: ['A', 'B', 'E', 'J'], 
    correct: 'A' 
  },
  { 
    type: 'letter_recognition', 
    title: "¿Sabes qué letra inicia el nombre de este gigante amigable?", 
    content: "🐘 Elefante", 
    options: ['L', 'E', 'F', 'T'], 
    correct: 'E' 
  },
  { 
    type: 'letter_recognition', 
    title: "¿Con qué letra comienza esta deliciosa fruta?", 
    content: "🍎 Manzana", 
    options: ['M', 'N', 'Z', 'A'], 
    correct: 'M' 
  },
  { 
    type: 'letter_recognition', 
    title: "¡Rugido! ¿Cuál es la primera letra del rey de la selva?", 
    content: "🦁 León", 
    options: ['L', 'E', 'O', 'N'], 
    correct: 'L' 
  },
  { 
    type: 'letter_recognition', 
    title: "¡Beep beep! ¿Qué letra arranca este vehículo?", 
    content: "🚗 Carro", 
    options: ['C', 'R', 'O', 'A'], 
    correct: 'C' 
  },
  { 
    type: 'letter_recognition', 
    title: "¡Miau! ¿Con qué letra maúlla este tierno amigo?", 
    content: "🐱 Gato", 
    options: ['G', 'A', 'T', 'O'], 
    correct: 'G' 
  },
  { 
    type: 'letter_recognition', 
    title: "¡Qué brillante! ¿Cuál es la primera letra de nuestra estrella?", 
    content: "☀️ Sol", 
    options: ['S', 'O', 'L', 'T'], 
    correct: 'S' 
  },
  { 
    type: 'letter_recognition', 
    title: "¡Mmm, qué rica! ¿Qué letra abre esta fruta amarilla?", 
    content: "🍌 Banana", 
    options: ['B', 'A', 'N', 'M'], 
    correct: 'B' 
  },
  { 
    type: 'letter_recognition', 
    title: "¡Guau guau! ¿Con qué letra ladra este fiel compañero?", 
    content: "🐶 Perro", 
    options: ['P', 'E', 'R', 'O'], 
    correct: 'P' 
  },
  { 
    type: 'letter_recognition', 
    title: "¡Mira qué bonita! ¿Cuál es la primera letra de nuestra compañera nocturna?", 
    content: "🌙 Luna", 
    options: ['L', 'U', 'N', 'A'], 
    correct: 'L' 
  },
  { 
    type: 'letter_recognition', 
    title: "¡Splash! ¿Con qué letra nada este amigo del océano?", 
    content: "🐠 Pez", 
    options: ['P', 'E', 'Z', 'S'], 
    correct: 'P' 
  },
  { 
    type: 'letter_recognition', 
    title: "¡Qué dulce! ¿Cuál es la primera letra de esta rica golosina?", 
    content: "🍯 Miel", 
    options: ['M', 'I', 'E', 'L'], 
    correct: 'M' 
  },
  { 
    type: 'letter_recognition', 
    title: "¡Vuelo alto! ¿Con qué letra vuela este hermoso ser?", 
    content: "🦋 Mariposa", 
    options: ['M', 'A', 'R', 'I'], 
    correct: 'M' 
  },
  { 
    type: 'letter_recognition', 
    title: "¡Tick tock! ¿Qué letra marca el tiempo en este objeto?", 
    content: "⏰ Reloj", 
    options: ['R', 'E', 'L', 'O'], 
    correct: 'R' 
  },
  { 
    type: 'letter_recognition', 
    title: "¡Qué verde y alto! ¿Con qué letra crece este gigante natural?", 
    content: "🌳 Árbol", 
    options: ['A', 'R', 'B', 'O'], 
    correct: 'A' 
  },
  { 
    type: 'letter_recognition', 
    title: "¡Moo moo! ¿Cuál es la primera letra de este animal de granja?", 
    content: "🐄 Vaca", 
    options: ['V', 'A', 'C', 'M'], 
    correct: 'V' 
  },
  { 
    type: 'letter_recognition', 
    title: "¡Zas! ¿Con qué letra corta este útil objeto?", 
    content: "✂️ Tijeras", 
    options: ['T', 'I', 'J', 'E'], 
    correct: 'T' 
  },
  { 
    type: 'letter_recognition', 
    title: "¡Qué rica! ¿Cuál es la primera letra de esta fruta tropical?", 
    content: "🍍 Piña", 
    options: ['P', 'I', 'Ñ', 'A'], 
    correct: 'P' 
  },
  { 
    type: 'letter_recognition', 
    title: "¡Hop hop! ¿Con qué letra salta este tierno animalito?", 
    content: "🐰 Conejo", 
    options: ['C', 'O', 'N', 'E'], 
    correct: 'C' 
  },
  { 
    type: 'letter_recognition', 
    title: "¡Qué colorido! ¿Cuál es la primera letra de este hermoso fenómeno?", 
    content: "🌈 Arcoíris", 
    options: ['A', 'R', 'C', 'O'], 
    correct: 'A' 
  }
];

function initLesson() {
  coins = parseInt(localStorage.getItem('coins')) || 0;
  updateCoins();
  updateHearts();
  showQuestion();
  updateProgress();
}

function showQuestion() {
  clearInterval(timerInterval);
  timerValue = 10;
  timeTaken = 0;
  updateTimerBar();

  const q = questions[currentQuestionIndex];
  document.getElementById('questionTitle').textContent = q.title;
  document.getElementById('btnContinue').disabled = true;
  selectedOption = null;

  const optionsContainer = document.getElementById('questionOptions');
  optionsContainer.innerHTML = '';
  q.options.forEach(opt => {
    const btn = document.createElement('button');
    btn.className = 'option-btn';
    btn.textContent = opt;
    btn.setAttribute('data-value', opt);
    btn.onclick = () => selectOption(btn, opt);
    optionsContainer.appendChild(btn);
  });

  const questionContent = document.getElementById('questionContent');
  questionContent.innerHTML = '';
  if (q.content && q.content !== '?') {
    const displayDiv = document.createElement('div');
    displayDiv.className = 'letter-emoji-display';
    displayDiv.textContent = q.content;
    questionContent.appendChild(displayDiv);
  }

  timerInterval = setInterval(() => {
    timerValue--;
    timeTaken++;
    updateTimerBar();
    if (timerValue <= 0) {
      clearInterval(timerInterval);
      document.getElementById('btnContinue').disabled = false;
    }
  }, 1000);
}

function selectOption(button, value) {
  document.querySelectorAll('.option-btn').forEach(btn => btn.classList.remove('selected'));
  button.classList.add('selected');
  selectedOption = value;
  document.getElementById('btnContinue').disabled = false;
}

function nextQuestion() {
  clearInterval(timerInterval);
  if (!selectedOption) return;

  const q = questions[currentQuestionIndex];
  const correct = selectedOption === q.correct;
  showAnswerFeedback(correct);

  if (correct) {
    correctAnswers++;
    const gained = 100 + timerValue * 10;
    coins += gained;
    updateCoins();
    document.getElementById('coinChangeTextCorrect').textContent = `+${gained} monedas`;
    setTimeout(() => showModal('correctModal'), 800);
  } else {
    hearts--;
    coins = Math.max(0, coins - 200);
    updateCoins();
    document.getElementById('correctAnswerText').textContent = `La respuesta correcta es: ${q.correct}`;
    document.getElementById('coinChangeTextIncorrect').textContent = `-200 monedas`;
    setTimeout(() => showModal('incorrectModal'), 800);
  }
}

function showAnswerFeedback(correct) {
  const q = questions[currentQuestionIndex];
  document.querySelectorAll('.option-btn').forEach(btn => {
    const val = btn.getAttribute('data-value');
    if (val === q.correct) btn.classList.add('correct');
    else if (val === selectedOption && !correct) btn.classList.add('incorrect');
    btn.disabled = true;
  });
  document.getElementById('btnContinue').disabled = true;
}

function continueAfterModal() {
  currentQuestionIndex++;
  if (currentQuestionIndex >= questions.length || hearts <= 0) {
    localStorage.setItem('comunicacion_modulo1_tema1_completed', 'true');
    localStorage.setItem('coins', coins);
    showCompletionModal();
  } else {
    updateProgress();
    showQuestion();
  }
}

function showModal(id) {
  document.getElementById(id).classList.add('show');
  // Feedback visual motivacional
  if (id === 'correctModal') {
    triggerConfetti();
  }
}

function triggerConfetti() {
  if (window.confetti) {
    window.confetti({
      particleCount: 70,
      spread: 90,
      origin: { y: 0.7 }
    });
  } else {
    document.body.style.background = "#b5f5c2";
    setTimeout(() => document.body.style.background = "", 350);
  }
}

function closeModal() {
  document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('show'));
  setTimeout(() => continueAfterModal(), 300);
}

function showCompletionModal() {
  document.getElementById('finalCoins').textContent = coins;
  document.getElementById('finalAccuracy').textContent = `${Math.round((correctAnswers / questions.length) * 100)}%`;
  // Actualiza el progreso general del módulo para Comunicación
  localStorage.setItem('currentTopic_comunicacion_modulo1', 'tema2');
  showModal('completedModal');
}

function restartLesson() {
  currentQuestionIndex = 0;
  coins = 0;
  hearts = 3;
  correctAnswers = 0;
  selectedOption = null;
  localStorage.setItem('coins', 0);
  closeModal();
  setTimeout(() => initLesson(), 300);
}

function goToNextLesson() {
  window.location.href = "../tema2_formo_silabas/leccion.php";
}

function updateProgress() {
  const percent = ((currentQuestionIndex + 1) / questions.length) * 100;
  document.getElementById('progressFill').style.width = `${percent}%`;
  document.getElementById('progressText').textContent = `${currentQuestionIndex + 1}/${questions.length}`;
}

function updateCoins() {
  document.getElementById('coinsCount').textContent = coins;
  localStorage.setItem('coins', coins);
}

function updateHearts() {
  for (let i = 1; i <= 3; i++) {
    const heart = document.getElementById(`heart${i}`);
    i > hearts ? heart.classList.add('lost') : heart.classList.remove('lost');
  }
}

function updateTimerBar() {
  const bar = document.getElementById('timerBar');
  const barText = document.getElementById('timerBarText');
  let percent = (timerValue / 10) * 100;
  bar.style.width = percent + "%";

  bar.classList.remove('low', 'critical');
  if (timerValue <= 3) {
    bar.classList.add('critical');
  } else if (timerValue <= 6) {
    bar.classList.add('low');
  }

  barText.textContent = timerValue > 0 ? timerValue : "¡Tiempo!";

  if (timerValue === 3 && window.navigator && window.navigator.vibrate) {
    window.navigator.vibrate(150);
  }
}

document.addEventListener('DOMContentLoaded', initLesson);