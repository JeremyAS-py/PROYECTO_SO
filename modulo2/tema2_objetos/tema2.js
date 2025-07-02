let currentQuestionIndex = 0;
let coins = 0;
let hearts = 3;
let correctAnswers = 0;
let selectedOption = null;
let timerInterval;
let timerValue = 20;
let timeTaken = 0;

const questions = [
  {
    type: 'objetos_sumar',
    title: '🔵🔵 + 🔵 = ¿? Tienes DOS fichas azules en tu mano izquierda, UNA ficha azul en tu mano derecha. Cuenta todas las fichas, ¿cuántas fichas tienes en total?',
    content: 'Cuenta las fichas: 2 + 1',
    options: ['2', '3', '4'],
    correct: '3'
  },
  {
    type: 'objetos_sumar',
    title: '🍌 + 🍌🍌 = ¿? En la mesa hay UN plátano, en la canasta hay DOS plátanos. Si cuentas todos los plátanos, ¿cuántos plátanos hay?',
    content: 'Cuenta los plátanos: 1 + 2',
    options: ['2', '3', '4'],
    correct: '3'
  },
  {
    type: 'objetos_sumar',
    title: '🟡🟡🟡 + 🟡 = ¿? Juegas con TRES fichas amarillas en el suelo, encuentras UNA ficha amarilla más debajo del sofá. Cuenta todas las fichas amarillas, ¿cuántas son?',
    content: 'Cuenta las fichas: 3 + 1',
    options: ['3', '4', '5'],
    correct: '4'
  },
  {
    type: 'objetos_sumar',
    title: '🥕🥕 + 🥕🥕 = ¿? Tu mamá corta DOS zanahorias para el almuerzo, tu papá corta DOS zanahorias más. Si cuentas todas las zanahorias cortadas, ¿cuántas zanahorias hay?',
    content: 'Cuenta las zanahorias: 2 + 2',
    options: ['3', '4', '5'],
    correct: '4'
  },
  {
    type: 'objetos_sumar',
    title: '🟢🟢🟢🟢 + 🟢 = ¿? Guardas CUATRO fichas verdes en tu caja, tu hermana te da UNA ficha verde más. Cuenta todas las fichas verdes, ¿cuántas fichas tienes ahora?',
    content: 'Cuenta las fichas: 4 + 1',
    options: ['4', '5', '6'],
    correct: '5'
  },
  {
    type: 'objetos_sumar',
    title: '🍊🍊 + 🍊🍊🍊 = ¿? Compras DOS naranjas en la tienda, tu abuela te regala TRES naranjas de su árbol. Cuenta todas las naranjas, ¿cuántas naranjas tienes?',
    content: 'Cuenta las naranjas: 2 + 3',
    options: ['4', '5', '6'],
    correct: '5'
  },
  {
    type: 'objetos_sumar',
    title: '🔴🔴🔴 + 🔴🔴🔴 = ¿? En tu escritorio hay TRES fichas rojas, en tu mochila hay TRES fichas rojas más. Si cuentas todas las fichas rojas, ¿cuántas fichas son?',
    content: 'Cuenta las fichas: 3 + 3',
    options: ['5', '6', '7'],
    correct: '6'
  },
  {
    type: 'objetos_sumar',
    title: '🍇🍇🍇🍇 + 🍇🍇 = ¿? Comes CUATRO uvas de un racimo, luego comes DOS uvas más de otro racimo. Cuenta todas las uvas que comiste, ¿cuántas uvas fueron?',
    content: 'Cuenta las uvas: 4 + 2',
    options: ['5', '6', '7'],
    correct: '6'
  },
  {
    type: 'objetos_sumar',
    title: '⚪⚪⚪⚪⚪ + ⚪⚪ = ¿? Juegas con CINCO fichas blancas en la alfombra, tu amigo trae DOS fichas blancas más. Cuenta todas las fichas blancas, ¿cuántas fichas hay en total?',
    content: 'Cuenta las fichas: 5 + 2',
    options: ['6', '7', '8'],
    correct: '7'
  },
  {
    type: 'objetos_sumar',
    title: '🍎🍎🍎 + 🍎🍎🍎🍎 = ¿? En una bolsa tienes TRES manzanas rojas, en otra bolsa tienes CUATRO manzanas rojas. Si cuentas todas las manzanas rojas, ¿cuántas manzanas tienes?',
    content: 'Cuenta las manzanas: 3 + 4',
    options: ['6', '7', '8'],
    correct: '7'
  },
  {
    type: 'objetos_sumar',
    title: '🟣🟣🟣🟣🟣 + 🟣🟣🟣 = ¿? Organizas CINCO fichas moradas en una fila, luego agregas TRES fichas moradas más a la fila. Cuenta todas las fichas moradas, ¿cuántas fichas hay?',
    content: 'Cuenta las fichas: 5 + 3',
    options: ['7', '8', '9'],
    correct: '8'
  },
  {
    type: 'objetos_sumar',
    title: '🥒🥒🥒🥒 + 🥒🥒🥒🥒🥒 = ¿? Tu mamá compra CUATRO pepinos en el mercado, tu tía trae CINCO pepinos de su huerta. Si cuentas todos los pepinos, ¿cuántos pepinos hay?',
    content: 'Cuenta los pepinos: 4 + 5',
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
  timerValue = 20;
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
    const gained = 100 + timerValue * 5;
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
    localStorage.setItem('tema2SumaCompleted', 'true');
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
    setMotivationalText('correctModal', '¡Excelente! ¡Sabes contar muy bien!');
  } else if (id === 'incorrectModal') {
    setMotivationalText('incorrectModal', '¡Sigue practicando, lo harás mejor!');
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
  localStorage.setItem('modulo2_tema2_terminado', 'true');
  localStorage.setItem('currentTopic_modulo2', 'tema3');
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
  window.location.href = "../tema3_sumas_apoyo_visual/leccion.php";
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
  let percent = (timerValue / 20) * 100;
  bar.style.width = percent + "%";

  bar.classList.remove('low', 'critical');
  if (timerValue <= 5) {
    bar.classList.add('critical');
  } else if (timerValue <= 10) {
    bar.classList.add('low');
  }

  barText.textContent = timerValue > 0 ? timerValue : "¡Tiempo!";

  if (timerValue === 5 && window.navigator && window.navigator.vibrate) {
    window.navigator.vibrate(150);
  }
}

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
      padding: 15px;
      background: linear-gradient(45deg, #e8f5e8, #f0f8f0);
      border-radius: 12px;
      border: 2px dashed #28a745;
      max-width: 90%;
      margin-left: auto;
      margin-right: auto;
    `;
    
    const numbers = q.content.match(/\d+/g);
    if (numbers && numbers.length === 2) {
      const first = parseInt(numbers[0]);
      const second = parseInt(numbers[1]);
      
      const emoji = q.title.match(/[\u{1F300}-\u{1F9FF}]|🔵|🟡|🟢|🔴|⚪|🟣/u)?.[0] || '⭐';
      
      const firstGroup = emoji.repeat(Math.min(first, 5)) + (first > 5 ? `+${first-5}` : '');
      const secondGroup = emoji.repeat(Math.min(second, 5)) + (second > 5 ? `+${second-5}` : '');
      
      visualDiv.innerHTML = `
        <div style="margin-bottom: 15px;">
          <div style="font-size: 0.9rem; color: #666; margin-bottom: 8px; font-weight: 600;">
            🧮 Cuenta los objetos paso a paso:
          </div>
        </div>
        <div style="display: flex; justify-content: center; align-items: center; gap: 15px; flex-wrap: wrap; margin-bottom: 12px;">
          <div style="display: flex; flex-direction: column; align-items: center; gap: 5px;">
            <div style="display: flex; gap: 3px; align-items: center; font-size: 1.2rem;">
              ${firstGroup}
            </div>
            <div style="font-size: 0.8rem; color: #495057; font-weight: 600;">
              ${first} objeto${first !== 1 ? 's' : ''}
            </div>
          </div>
          <span style="font-size: 1.4rem; font-weight: bold; color: #dc3545;">+</span>
          <div style="display: flex; flex-direction: column; align-items: center; gap: 5px;">
            <div style="display: flex; gap: 3px; align-items: center; font-size: 1.2rem;">
              ${secondGroup}
            </div>
            <div style="font-size: 0.8rem; color: #495057; font-weight: 600;">
              ${second} objeto${second !== 1 ? 's' : ''}
            </div>
          </div>
          <span style="font-size: 1.4rem; font-weight: bold; color: #dc3545;">=</span>
          <span style="font-size: 1.4rem; font-weight: bold; color: #28a745;">?</span>
        </div>
        <div style="font-size: 1rem; color: #495057; font-weight: 600; padding: 8px; background: rgba(40, 167, 69, 0.1); border-radius: 8px;">
          ${q.content}
        </div>
      `;
    }
    
    questionContent.appendChild(visualDiv);
  }
}

document.addEventListener('DOMContentLoaded', initLesson);