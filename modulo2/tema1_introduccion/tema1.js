let currentQuestionIndex = 0;
let coins = 0;
let hearts = 3;
let correctAnswers = 0;
let selectedOption = null;
let timerInterval;
let timerValue = 20; // Aumentado a 20 segundos
let timeTaken = 0;

const questions = [
  {
    type: 'concepto_juntar',
    title: '🐣🐣 + 🐣 = ¿? Aquí tienes DOS pollitos, luego llega UNO más. Cuando los JUNTAS todos, ¿cuántos pollitos ves?',
    content: 'JUNTAR significa poner todo junto: 2 + 1',
    options: ['2', '3', '4'],
    correct: '3'
  },
  {
    type: 'concepto_juntar',
    title: '🍎 + 🍎🍎 = ¿? Mira: UNA manzana aquí, DOS manzanas allá. Si las JUNTAS todas en una canasta, ¿cuántas manzanas tienes?',
    content: 'JUNTAR: 1 + 2',
    options: ['2', '3', '4'],
    correct: '3'
  },
  {
    type: 'concepto_juntar',
    title: '⭐⭐⭐ + ⭐ = ¿? Ves TRES estrellas en el cielo, después aparece UNA estrella más. Al JUNTARLAS todas, ¿cuántas estrellas hay?',
    content: 'JUNTAR: 3 + 1',
    options: ['3', '4', '5'],
    correct: '4'
  },
  {
    type: 'concepto_juntar',
    title: '🚗🚗 + 🚗🚗 = ¿? En un lado del garaje hay DOS carros, en el otro lado hay DOS carros. Si JUNTAS todos los carros, ¿cuántos son?',
    content: 'JUNTAR: 2 + 2',
    options: ['3', '4', '5'],
    correct: '4'
  },
  {
    type: 'concepto_juntar',
    title: '🌸🌸🌸🌸 + 🌸 = ¿? Tu mamá corta CUATRO flores del jardín, tú cortas UNA flor. Al JUNTAR todas las flores, ¿cuántas flores tienen?',
    content: 'JUNTAR: 4 + 1',
    options: ['4', '5', '6'],
    correct: '5'
  },
  {
    type: 'concepto_juntar',
    title: '🎈🎈 + 🎈🎈🎈 = ¿? Tienes DOS globos rojos en una mano, TRES globos azules en la otra mano. Si JUNTAS todos los globos, ¿cuántos globos tienes?',
    content: 'JUNTAR: 2 + 3',
    options: ['4', '5', '6'],
    correct: '5'
  },
  {
    type: 'concepto_juntar',
    title: '🧸🧸🧸 + 🧸🧸🧸 = ¿? En tu cama hay TRES ositos, en el piso hay TRES ositos más. Al JUNTARLOS todos, ¿cuántos ositos tienes?',
    content: 'JUNTAR: 3 + 3',
    options: ['5', '6', '7'],
    correct: '6'
  },
  {
    type: 'concepto_juntar',
    title: '🍓🍓🍓🍓 + 🍓🍓 = ¿? Recoges CUATRO fresas rojas, tu hermana recoge DOS fresas más. Si JUNTAN todas las fresas, ¿cuántas fresas tienen?',
    content: 'JUNTAR: 4 + 2',
    options: ['5', '6', '7'],
    correct: '6'
  },
  {
    type: 'concepto_juntar',
    title: '🦋🦋🦋🦋🦋 + 🦋🦋 = ¿? Ves CINCO mariposas volando cerca de las flores, llegan DOS mariposas más. Al JUNTARLAS todas, ¿cuántas mariposas hay?',
    content: 'JUNTAR: 5 + 2',
    options: ['6', '7', '8'],
    correct: '7'
  },
  {
    type: 'concepto_juntar',
    title: '🍪🍪🍪 + 🍪🍪🍪🍪 = ¿? Tu abuela hornea TRES galletas por la mañana, CUATRO galletas por la tarde. Si JUNTAS todas las galletas, ¿cuántas galletas hay?',
    content: 'JUNTAR: 3 + 4',
    options: ['6', '7', '8'],
    correct: '7'
  },
  {
    type: 'concepto_juntar',
    title: '🎨🎨🎨🎨🎨 + 🎨🎨🎨 = ¿? Tienes CINCO crayones en una caja, TRES crayones en tu escritorio. Al JUNTARLOS todos, ¿cuántos crayones tienes?',
    content: 'JUNTAR: 5 + 3',
    options: ['7', '8', '9'],
    correct: '8'
  },
  {
    type: 'concepto_juntar',
    title: '🐠🐠🐠🐠 + 🐠🐠🐠🐠🐠 = ¿? En una pecera nadan CUATRO pececitos, en otra pecera nadan CINCO pececitos. Si JUNTAS todos los pececitos, ¿cuántos son?',
    content: 'JUNTAR: 4 + 5',
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
  timerValue = 20; // Cambiado a 20 segundos
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
    
    // Función mejorada para mostrar representación visual más compacta
    showVisualRepresentation(currentQuestionIndex);
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
    const gained = 100 + timerValue * 5; // Reducido el bonus por segundo para balancear con más tiempo
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
  localStorage.setItem('modulo2_tema1_terminado', 'true');
  localStorage.setItem('currentTopic_modulo2', 'tema2');
  localStorage.setItem('coins', coins);  
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
  window.location.href = "../tema2_objetos/leccion.php";
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
  let percent = (timerValue / 20) * 100; // Cambiado para 20 segundos
  bar.style.width = percent + "%";

  bar.classList.remove('low', 'critical');
  if (timerValue <= 5) { // Ajustado para 20 segundos
    bar.classList.add('critical');
  } else if (timerValue <= 10) { // Ajustado para 20 segundos
    bar.classList.add('low');
  }

  barText.textContent = timerValue > 0 ? timerValue : "¡Tiempo!";

  if (timerValue === 5 && window.navigator && window.navigator.vibrate) {
    window.navigator.vibrate(150);
  }
}

// FUNCIÓN MEJORADA para mostrar representación visual más COMPACTA
function showVisualRepresentation(questionIndex) {
  const q = questions[questionIndex];
  const questionContent = document.getElementById('questionContent');
  
  if (q.content && q.content !== '?') {
    const visualDiv = document.createElement('div');
    visualDiv.className = 'visual-representation';
    visualDiv.style.cssText = `
      font-size: 1.1rem;
      text-align: center;
      margin: 10px 0;
      padding: 10px;
      background: linear-gradient(45deg, #fff3cd, #fef7e0);
      border-radius: 12px;
      border: 2px dashed #ffc107;
      max-width: 90%;
      margin-left: auto;
      margin-right: auto;
    `;
    
    // Extraer los números de la suma para crear la representación visual
    const numbers = q.content.match(/\d+/g);
    if (numbers && numbers.length === 2) {
      const first = parseInt(numbers[0]);
      const second = parseInt(numbers[1]);
      
      // Usar el emoji del título para la representación
      const emoji = q.title.match(/[\u{1F300}-\u{1F9FF}]/u)?.[0] || '⭐';
      
      // Crear grupos más compactos de emojis
      const firstGroup = first <= 3 ? emoji.repeat(first) : 
                        `${emoji.repeat(3)}${first > 3 ? `+${first-3}` : ''}`;
      const secondGroup = second <= 3 ? emoji.repeat(second) : 
                         `${emoji.repeat(3)}${second > 3 ? `+${second-3}` : ''}`;
      
      visualDiv.innerHTML = `
        <div style="display: flex; justify-content: center; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 8px;">
          <div style="display: flex; gap: 2px; align-items: center; font-size: 1rem;">
            ${firstGroup}
          </div>
          <span style="font-size: 1rem; font-weight: bold; color: #dc3545;">+</span>
          <div style="display: flex; gap: 2px; align-items: center; font-size: 1rem;">
            ${secondGroup}
          </div>
          <span style="font-size: 1rem; font-weight: bold; color: #dc3545;">=</span>
          <span style="font-size: 1rem; font-weight: bold; color: #28a745;">?</span>
        </div>
        <div style="font-size: 1rem; color: #495057; font-weight: 600;">
          ${q.content}
        </div>
      `;
    }
    
    questionContent.appendChild(visualDiv);
  }
}

document.addEventListener('DOMContentLoaded', initLesson);