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
    type: 'suma_juntar',
    title: '🐣 Tienes 2 pollitos amarillos en el corral. Llegan 3 pollitos más. ¿Cuántos pollitos hay cuando los juntas todos?',
    content: 'Juntar: 2 + 3',
    options: ['4', '5', '6'],
    correct: '5'
  },
  {
    type: 'suma_juntar',
    title: '🎒 En tu mochila tienes 1 libro. Tu mamá pone 4 libros más. ¿Cuántos libros tienes si los juntas todos?',
    content: 'Juntar: 1 + 4',
    options: ['4', '5', '6'],
    correct: '5'
  },
  {
    type: 'suma_juntar',
    title: '🧸 Tienes 3 ositos en tu cama. Tu abuela te regala 2 ositos más. ¿Cuántos ositos tienes al juntarlos?',
    content: 'Juntar: 3 + 2',
    options: ['4', '5', '6'],
    correct: '5'
  },
  {
    type: 'suma_juntar',
    title: '🚗 En el estacionamiento hay 2 carros rojos. Llegan 2 carros azules. ¿Cuántos carros hay si los juntas todos?',
    content: 'Juntar: 2 + 2',
    options: ['3', '4', '5'],
    correct: '4'
  },
  {
    type: 'suma_juntar',
    title: '🌟 Por la mañana viste 4 estrellas. Por la noche viste 1 estrella más. ¿Cuántas estrellas viste en total al juntarlas?',
    content: 'Juntar: 4 + 1',
    options: ['4', '5', '6'],
    correct: '5'
  },
  {
    type: 'suma_juntar',
    title: '🎈 En la fiesta hay 5 globos rojos. Tu primo trae 2 globos verdes. ¿Cuántos globos hay si los juntas todos?',
    content: 'Juntar: 5 + 2',
    options: ['6', '7', '8'],
    correct: '7'
  },
  {
    type: 'suma_juntar',
    title: '🍎 En el árbol hay 3 manzanas. En otro árbol hay 4 manzanas. ¿Cuántas manzanas hay si las juntas todas?',
    content: 'Juntar: 3 + 4',
    options: ['6', '7', '8'],
    correct: '7'
  },
  {
    type: 'suma_juntar',
    title: '🐝 En el jardín hay 6 abejas trabajando. Llegan 2 abejas más. ¿Cuántas abejas hay al juntarlas todas?',
    content: 'Juntar: 6 + 2',
    options: ['7', '8', '9'],
    correct: '8'
  },
  {
    type: 'suma_juntar',
    title: '🎨 Tienes 2 crayones en una caja y 5 crayones en otra caja. ¿Cuántos crayones tienes si los juntas todos?',
    content: 'Juntar: 2 + 5',
    options: ['6', '7', '8'],
    correct: '7'
  },
  {
    type: 'suma_juntar',
    title: '🦆 En el lago nadan 4 patitos. Llegan 3 patitos más nadando. ¿Cuántos patitos hay cuando los juntas?',
    content: 'Juntar: 4 + 3',
    options: ['6', '7', '8'],
    correct: '7'
  },
  {
    type: 'suma_juntar',
    title: '🌸 En el jardín hay 6 flores rosadas. Plantas 3 flores amarillas. ¿Cuántas flores hay si las juntas todas?',
    content: 'Juntar: 6 + 3',
    options: ['8', '9', '10'],
    correct: '9'
  },
  {
    type: 'suma_juntar',
    title: '⚽ Tienes 5 pelotas en tu cuarto. Tu hermano te da 4 pelotas más. ¿Cuántas pelotas tienes al juntarlas todas?',
    content: 'Juntar: 5 + 4',
    options: ['8', '9', '10'],
    correct: '9'
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
    const numberDiv = document.createElement('div');
    numberDiv.className = 'number-display';
    numberDiv.textContent = q.content;
    questionContent.appendChild(numberDiv);
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
    localStorage.setItem('tema1SumaCompleted', 'true');
    localStorage.setItem('coins', coins);
    showCompletionModal();
  } else {
    updateProgress();
    showQuestion();
  }
}

function showModal(id) {
  document.getElementById(id).classList.add('show');
  if (id === 'correctModal') {
    triggerConfetti();
    setMotivationalText('correctModal', '¡Muy bien! ¡Eres un genio!');
  } else if (id === 'incorrectModal') {
    setMotivationalText('incorrectModal', '¡No pasa nada, tú puedes!');
  }
}

function setMotivationalText(modalId, text) {
  const modal = document.getElementById(modalId);
  if (!modal) return;
  let txt = modal.querySelector('.motivational-text');
  if (!txt) {
    txt = document.createElement('div');
    txt.className = 'motivational-text';
    modal.querySelector('.modal-content').appendChild(txt);
  }
  txt.textContent = text;
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
  localStorage.setItem('currentTopic', 'tema2_objetos');
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
  window.location.href = "../tema2_objetos_para_sumar/leccion.php";
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