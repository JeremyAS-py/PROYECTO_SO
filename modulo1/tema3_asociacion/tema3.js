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
    type: 'match', 
    title: "¡Cuenta las manzanas rojas! 🍎", 
    count: 3, 
    emoji: '🍎',
    options: [2, 3, 4, 5], 
    correct: 3 
  },
  { 
    type: 'match', 
    title: "¿Cuántas estrellitas brillan? ⭐", 
    count: 5, 
    emoji: '⭐',
    options: [4, 5, 6, 3], 
    correct: 5 
  },
  { 
    type: 'match', 
    title: "¡Solo hay una pelota! ⚽", 
    count: 1, 
    emoji: '⚽',
    options: [0, 1, 2, 3], 
    correct: 1 
  },
  { 
    type: 'match', 
    title: "Cuenta los corazones de amor 💖", 
    count: 4, 
    emoji: '💖',
    options: [3, 4, 5, 2], 
    correct: 4 
  },
  { 
    type: 'match', 
    title: "¿Cuántas flores hay en el jardín? 🌸", 
    count: 6, 
    emoji: '🌸',
    options: [5, 6, 7, 4], 
    correct: 6 
  },
  { 
    type: 'match', 
    title: "Los patitos van nadando 🦆", 
    count: 2, 
    emoji: '🦆',
    options: [1, 2, 3, 4], 
    correct: 2 
  },
  { 
    type: 'match', 
    title: "¡Cuenta las caramelos dulces! 🍬", 
    count: 7, 
    emoji: '🍬',
    options: [6, 7, 8, 5], 
    correct: 7 
  },
  { 
    type: 'match', 
    title: "Los gatitos juegan juntos 🐱", 
    count: 8, 
    emoji: '🐱',
    options: [7, 8, 9, 6], 
    correct: 8 
  },
  { 
    type: 'match', 
    title: "¿Cuántos globos vuelan alto? 🎈", 
    count: 9, 
    emoji: '🎈',
    options: [8, 9, 10, 7], 
    correct: 9 
  },
  { 
    type: 'match', 
    title: "Las mariposas bailan 🦋", 
    count: 4, 
    emoji: '🦋',
    options: [3, 4, 5, 6], 
    correct: 4 
  },
  { 
    type: 'match', 
    title: "¡Son muchos pastelitos! 🧁", 
    count: 10, 
    emoji: '🧁',
    options: [9, 10, 8, 11], 
    correct: 10 
  },
  { 
    type: 'match', 
    title: "Los soles brillan radiantes ☀️", 
    count: 3, 
    emoji: '☀️',
    options: [2, 3, 4, 1], 
    correct: 3 
  }
];

function generateObjects(count, emoji) {
  // Si no se especifica emoji, usar uno aleatorio
  const defaultEmojis = ['🍎', '🪨', '🌰', '🍓', '🌟', '🍇', '🌼', '⚽', '🔵', '🧩', '🍪'];
  const selectedEmoji = emoji || defaultEmojis[Math.floor(Math.random() * defaultEmojis.length)];
  
  let html = '<div class="objects-container">';
  for (let i = 0; i < count; i++) {
    html += `<div class="object-item animate-bounce-${i % 3}">${selectedEmoji}</div>`;
  }
  html += '</div>';
  return html;
}

function initLesson() {
  updateProgress();
  updateCoins();
  updateHearts();
  showQuestion();
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

  // Usar el emoji específico de la pregunta si existe
  document.getElementById('questionContent').innerHTML = generateObjects(q.count, q.emoji);

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
  const correct = String(selectedOption) === String(q.correct);
  showAnswerFeedback(correct);

  if (correct) {
    correctAnswers++;
    coins += 100;
    updateCoins();
    document.getElementById('coinChangeTextCorrect').textContent = '+100 monedas';
    setTimeout(() => showModal('correctModal'), 800);
  } else {
    hearts--;
    updateHearts();
    document.getElementById('correctAnswerText').textContent = `La respuesta correcta es: ${q.correct}`;
    setTimeout(() => showModal('incorrectModal'), 800);
  }
}

function showAnswerFeedback(correct) {
  const q = questions[currentQuestionIndex];
  document.querySelectorAll('.option-btn').forEach(btn => {
    const val = btn.getAttribute('data-value');
    if (val === String(q.correct)) btn.classList.add('correct');
    else if (val === selectedOption && !correct) btn.classList.add('incorrect');
    btn.disabled = true;
  });
  document.getElementById('btnContinue').disabled = true;
}

function continueAfterModal() {
  currentQuestionIndex++;
  if (currentQuestionIndex >= questions.length || hearts <= 0) {
    showCompletionModal();
  } else {
    updateProgress();
    showQuestion();
  }
}

function showModal(id) {
  document.getElementById(id).classList.add('show');
  // Feedback visual motivacional más variado
  if (id === 'correctModal') {
    triggerConfetti();
    const motivationalMessages = [
      '¡Excelente! ¡Eres increíble!',
      '¡Muy bien! ¡Sigue así!',
      '¡Perfecto! ¡Eres un campeón!',
      '¡Genial! ¡Lo hiciste súper bien!',
      '¡Fantástico! ¡Eres muy inteligente!'
    ];
    const randomMessage = motivationalMessages[Math.floor(Math.random() * motivationalMessages.length)];
    setMotivationalText('correctModal', randomMessage);
  } else if (id === 'incorrectModal') {
    const encouragingMessages = [
      '¡No te preocupes, tú puedes!',
      '¡Inténtalo otra vez, casi lo tienes!',
      '¡Está bien, todos aprendemos!',
      '¡No pasa nada, sigues siendo genial!',
      '¡Vamos, la próxima la tienes!'
    ];
    const randomMessage = encouragingMessages[Math.floor(Math.random() * encouragingMessages.length)];
    setMotivationalText('incorrectModal', randomMessage);
  }
}

function setMotivationalText(modalId, text) {
  const modal = document.getElementById(modalId);
  if (!modal) return;
  let txt = modal.querySelector('.motivational-text');
  if (!txt) {
    txt = document.createElement('div');
    txt.className = 'motivational-text';
    txt.style.marginTop = '10px';
    txt.style.fontSize = '16px';
    txt.style.fontWeight = 'bold';
    txt.style.color = modalId === 'correctModal' ? '#4CAF50' : '#FF9800';
    modal.querySelector('.modal-content').appendChild(txt);
  }
  txt.textContent = text;
}

function triggerConfetti() {
  if (window.confetti) {
    window.confetti({
      particleCount: 100,
      spread: 70,
      origin: { y: 0.6 },
      colors: ['#ff0000', '#00ff00', '#0000ff', '#ffff00', '#ff00ff', '#00ffff']
    });
  } else {
    document.body.style.background = "linear-gradient(45deg, #b5f5c2, #ffd1dc)";
    setTimeout(() => document.body.style.background = "", 500);
  }
}

function closeModal() {
  document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('show'));
  setTimeout(() => continueAfterModal(), 300);
}

function showCompletionModal() {
  document.getElementById('finalCoins').textContent = coins;
  document.getElementById('finalAccuracy').textContent = `${Math.round((correctAnswers / questions.length) * 100)}%`;
  
  // Mensaje especial según el rendimiento
  const accuracy = (correctAnswers / questions.length) * 100;
  let completionMessage = '';
  if (accuracy >= 90) {
    completionMessage = '¡Eres un súper genio de los números! 🌟';
  } else if (accuracy >= 70) {
    completionMessage = '¡Muy buen trabajo! ¡Sigue practicando! 👏';
  } else {
    completionMessage = '¡Buen intento! ¡La práctica te hará mejor! 💪';
  }
  
  // Agregar mensaje personalizado al modal
  const completedModal = document.getElementById('completedModal');
  let customMsg = completedModal.querySelector('.custom-completion-message');
  if (!customMsg) {
    customMsg = document.createElement('p');
    customMsg.className = 'custom-completion-message';
    customMsg.style.fontSize = '18px';
    customMsg.style.fontWeight = 'bold';
    customMsg.style.color = '#4CAF50';
    customMsg.style.marginTop = '15px';
    completedModal.querySelector('.modal-content').insertBefore(customMsg, completedModal.querySelector('.completion-buttons'));
  }
  customMsg.textContent = completionMessage;
  
  showModal('completedModal');
}

function restartLesson() {
  currentQuestionIndex = 0;
  coins = 0;
  hearts = 3;
  correctAnswers = 0;
  selectedOption = null;
  closeModal();
  setTimeout(() => initLesson(), 300);
}

function updateProgress() {
  const percent = ((currentQuestionIndex + 1) / questions.length) * 100;
  document.getElementById('progressFill').style.width = `${percent}%`;
  document.getElementById('progressText').textContent = `${currentQuestionIndex + 1}/${questions.length}`;
}

function updateCoins() {
  document.getElementById('coinsCount').textContent = coins;
}

function updateHearts() {
  for (let i = 1; i <= 3; i++) {
    const heart = document.getElementById(`heart${i}`);
    if (i > hearts) {
      heart.classList.add('lost');
    } else {
      heart.classList.remove('lost');
    }
  }
}

// Barra de tiempo funcional
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