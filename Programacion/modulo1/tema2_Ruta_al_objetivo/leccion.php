<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Programación Visual - Tema 2: Ruta al Objetivo</title>
  <script src="https://unpkg.com/blockly/blockly.min.js"></script>
  <style>
    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      margin: 0;
      display: flex;
      flex-direction: row;
      height: 100vh;
      background: #f8f9fa;
    }
    #blocklyDiv {
      height: 100%;
      width: 50%;
      border-right: 2px solid #e0e0e0;
    }
    #rightPanel {
      width: 50%;
      display: flex;
      flex-direction: column;
    }
    #output {
      flex: 1;
      padding: 1rem;
      background: #f0f2f5;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      box-shadow: inset 2px 0 4px rgba(0,0,0,0.1);
    }
    #objectives {
      background: #fff;
      border-top: 3px solid #2196F3;
      padding: 1rem;
      max-height: 40%;
      overflow-y: auto;
    }
    h3 {
      margin: 0 0 1rem 0;
      color: #333;
      font-size: 1.2rem;
      text-align: center;
    }
    .objectives-title {
      font-size: 1.1rem;
      color: #2196F3;
      font-weight: bold;
      margin-bottom: 0.5rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    #arena {
      width: 240px;
      height: 240px;
      background: #ffffff;
      border: 3px solid #333;
      border-radius: 8px;
      position: relative;
      margin: 0.5rem 0;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      background-image: 
        linear-gradient(rgba(0,0,0,0.3) 2px, transparent 2px),
        linear-gradient(90deg, rgba(0,0,0,0.3) 2px, transparent 2px);
      background-size: 40px 40px;
    }
    #robot {
      width: 35px;
      height: 35px;
      background: linear-gradient(135deg, #ff9800, #f57c00);
      position: absolute;
      border-radius: 8px;
      transition: all 1.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 15px rgba(255, 152, 0, 0.6);
      border: 3px solid #fff;
      z-index: 10;
    }
    #robot::before {
      content: '🤖';
      font-size: 18px;
      transition: transform 1.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      display: block;
      filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
    }
    
    .target {
      width: 30px;
      height: 30px;
      position: absolute;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      z-index: 5;
      animation: pulse 2s infinite;
      border: 3px solid #fff;
      box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    }
    
    .target.star {
      background: linear-gradient(135deg, #ffd700, #ffb300);
    }
    
    .target.gem {
      background: linear-gradient(135deg, #e91e63, #c2185b);
    }
    
    .target.coin {
      background: linear-gradient(135deg, #4caf50, #388e3c);
    }
    
    .target.reached {
      animation: collect 0.8s ease-in-out;
      transform: scale(0);
    }
    
    @keyframes pulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.1); }
    }
    
    @keyframes collect {
      0% { transform: scale(1); opacity: 1; }
      50% { transform: scale(1.5); opacity: 0.8; }
      100% { transform: scale(0); opacity: 0; }
    }
    
    @keyframes robotMove {
      0% { transform: scale(1); }
      50% { transform: scale(1.1); }
      100% { transform: scale(1); }
    }
    
    .robot-moving {
      animation: robotMove 0.6s ease-in-out;
    }
    
    .path-indicator {
      position: absolute;
      width: 8px;
      height: 8px;
      background: rgba(33, 150, 243, 0.4);
      border-radius: 50%;
      z-index: 3;
      animation: fadeIn 0.3s ease-in-out;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0); }
      to { opacity: 1; transform: scale(1); }
    }
    
    .button-container {
      display: flex;
      gap: 0.5rem;
      margin-top: 0.5rem;
      flex-wrap: wrap;
      justify-content: center;
    }
    button {
      padding: 0.6rem 1rem;
      font-size: 0.9rem;
      font-weight: 600;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: all 0.2s ease;
    }
    #runBtn {
      background: linear-gradient(135deg, #4CAF50, #45a049);
      color: white;
    }
    #resetBtn {
      background: linear-gradient(135deg, #ff9800, #e68900);
      color: white;
    }
    #stopBtn {
      background: linear-gradient(135deg, #f44336, #d32f2f);
      color: white;
    }
    #newTargetBtn {
      background: linear-gradient(135deg, #2196F3, #1976D2);
      color: white;
    }
    #nextBtn {
      background: linear-gradient(135deg, #9c27b0, #7b1fa2);
      color: white;
      font-size: 1rem;
      padding: 0.8rem 1.5rem;
      margin-top: 1rem;
      transition: all 0.3s ease;
    }
    #nextBtn:disabled {
      background: #ccc;
      cursor: not-allowed;
      opacity: 0.6;
    }
    #nextBtn:not(:disabled):hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(156, 39, 176, 0.4);
    }
    #backBtn {
      background: linear-gradient(135deg, #607d8b, #455a64);
      color: white;
      font-size: 0.9rem;
      padding: 0.6rem 1rem;
      position: absolute;
      top: 1rem;
      right: 1rem;
      z-index: 1000;
      transition: all 0.3s ease;
      box-shadow: 0 2px 8px rgba(96, 125, 139, 0.3);
    }
    #backBtn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(96, 125, 139, 0.4);
    }
    .status {
      margin-top: 0.5rem;
      padding: 0.4rem 0.8rem;
      border-radius: 4px;
      font-size: 0.8rem;
      font-weight: 500;
      text-align: center;
      min-height: 16px;
    }
    .status.ready { background: #e8f5e8; color: #2e7d32; border: 1px solid #c8e6c9; }
    .status.running { background: #fff3e0; color: #ef6c00; border: 1px solid #ffcc02; }
    .status.error { background: #ffebee; color: #c62828; border: 1px solid #ef5350; }
    .status.success { background: #e3f2fd; color: #1565c0; border: 1px solid #2196f3; }
    
    .debug-info {
      margin-top: 0.5rem;
      padding: 0.4rem;
      background: #f5f5f5;
      border-radius: 4px;
      font-size: 0.7rem;
      font-family: monospace;
      text-align: center;
      color: #666;
    }

    .objective {
      display: flex;
      align-items: center;
      padding: 0.8rem;
      margin: 0.5rem 0;
      border-radius: 8px;
      background: #f8f9fa;
      border: 2px solid transparent;
      transition: all 0.3s ease;
    }
    .objective.completed {
      background: #e8f5e8;
      border-color: #4CAF50;
    }
    .objective-icon {
      font-size: 1.5rem;
      margin-right: 0.8rem;
      min-width: 30px;
    }
    .objective-text {
      flex: 1;
      font-size: 0.9rem;
      color: #333;
    }
    .objective.completed .objective-text {
      color: #2e7d32;
      font-weight: 500;
    }
    .progress-bar {
      background: #e0e0e0;
      height: 8px;
      border-radius: 4px;
      overflow: hidden;
      margin: 1rem 0;
    }
    .progress-fill {
      background: linear-gradient(90deg, #2196F3, #64b5f6);
      height: 100%;
      transition: width 0.5s ease;
      border-radius: 4px;
    }
    .celebration {
      animation: bounce 0.6s ease-in-out;
    }
    @keyframes bounce {
      0%, 20%, 60%, 100% { transform: translateY(0); }
      40% { transform: translateY(-10px); }
      80% { transform: translateY(-5px); }
    }
    
    .score-display {
      display: flex;
      gap: 1rem;
      margin: 0.5rem 0;
      font-size: 0.9rem;
      font-weight: 600;
    }
    
    .score-item {
      display: flex;
      align-items: center;
      gap: 0.3rem;
      padding: 0.3rem 0.6rem;
      background: #f5f5f5;
      border-radius: 4px;
    }
  </style>
</head>
<body>
  <button id="backBtn" onclick="goBack()">← Regresar</button>
  <div id="blocklyDiv"></div>
  <div id="rightPanel">
    <div id="output">
      <h3>🎯 Robot Explorador</h3>
      <div id="arena">
        <div id="robot"></div>
      </div>
      <div class="score-display">
        <div class="score-item">
          <span>⭐</span>
          <span id="starCount">0</span>
        </div>
        <div class="score-item">
          <span>💎</span>
          <span id="gemCount">0</span>
        </div>
        <div class="score-item">
          <span>🪙</span>
          <span id="coinCount">0</span>
        </div>
      </div>
      <div class="button-container">
        <button id="runBtn" onclick="runCode()">▶ Ejecutar</button>
        <button id="resetBtn" onclick="resetRobot()">🔄 Reiniciar</button>
        <button id="stopBtn" onclick="stopExecution()" disabled>⏹ Detener</button>
        <button id="newTargetBtn" onclick="generateNewTarget()">🎲 Nuevo Objetivo</button>
      </div>
      <div id="status" class="status ready">Encuentra el objetivo brillante</div>
      <div id="debug" class="debug-info">Pos: (0,0) | Dir: Norte | Objetivo: Esperando...</div>
      <button id="nextBtn" onclick="goToNextLesson()" disabled>
        🚀 Siguiente: Esquiva Obstáculos
      </button>
    </div>
    
    <div id="objectives">
      <div class="objectives-title">
        <span>🎯</span>
        <span>Objetivos de Navegación</span>
        <span id="progressText">(0/6)</span>
      </div>
      <div class="progress-bar">
        <div class="progress-fill" id="progressFill" style="width: 0%"></div>
      </div>
      
      <div class="objective" id="obj1">
        <div class="objective-icon">⭕</div>
        <div class="objective-text">Alcanza tu primer objetivo</div>
      </div>
      
      <div class="objective" id="obj2">
        <div class="objective-icon">⭕</div>
        <div class="objective-text">Recoge una estrella ⭐</div>
      </div>
      
      <div class="objective" id="obj3">
        <div class="objective-icon">⭕</div>
        <div class="objective-text">Recoge una gema 💎</div>
      </div>
      
      <div class="objective" id="obj4">
        <div class="objective-icon">⭕</div>
        <div class="objective-text">Recoge una moneda 🪙</div>
      </div>
      
      <div class="objective" id="obj5">
        <div class="objective-icon">⭕</div>
        <div class="objective-text">Planifica una ruta en forma de L</div>
      </div>
      
      <div class="objective" id="obj6">
        <div class="objective-icon">⭕</div>
        <div class="objective-text">Alcanza 3 objetivos en una sola ejecución</div>
      </div>
    </div>
  </div>

  <script>
    // === DEFINICIÓN DE BLOQUES ===
    Blockly.defineBlocksWithJsonArray([
      { type: "move_forward", message0: "avanzar", previousStatement: null, nextStatement: null, colour: 120 },
      { type: "turn_left", message0: "gira a la izquierda", previousStatement: null, nextStatement: null, colour: 100 },
      { type: "turn_right", message0: "gira a la derecha", previousStatement: null, nextStatement: null, colour: 20 }
    ]);

    const javascriptGenerator = new Blockly.Generator('JavaScript');
    javascriptGenerator.ORDER_NONE = 0;
    javascriptGenerator.forBlock['move_forward'] = () => 'moveForward();\n';
    javascriptGenerator.forBlock['turn_left'] = () => 'turnLeft();\n';
    javascriptGenerator.forBlock['turn_right'] = () => 'turnRight();\n';
    javascriptGenerator.scrub_ = (block, code, thisOnly) => {
      const next = block.nextConnection?.targetBlock();
      return code + (!thisOnly && next ? javascriptGenerator.blockToCode(next) : '');
    };

    const toolbox = {
      kind: 'categoryToolbox',
      contents: [{
        kind: 'category',
        name: '🚀 Movimiento',
        colour: '120',
        contents: [
          { kind: 'block', type: 'move_forward' },
          { kind: 'block', type: 'turn_left' },
          { kind: 'block', type: 'turn_right' }
        ]
      }]
    };

    const workspace = Blockly.inject('blocklyDiv', {
      toolbox,
      scrollbars: true,
      trashcan: true,
      grid: { spacing: 20, length: 3, colour: '#ccc', snap: true },
      zoom: { controls: true, wheel: true, startScale: 1.0, maxScale: 3, minScale: 0.3, scaleSpeed: 1.2 }
    });

    // === VARIABLES GLOBALES ===
    let x = 0, y = 0, direction = 0, isExecuting = false;
    let targets = [];
    let collectedItems = { stars: 0, gems: 0, coins: 0 };
    let pathHistory = [];
    let totalObjectivesReached = 0;
    let currentExecutionCollected = 0;
    let stopped = false;

    const robot = document.getElementById('robot');
    const statusElement = document.getElementById('status');
    const debugElement = document.getElementById('debug');
    const runBtn = document.getElementById('runBtn');
    const stopBtn = document.getElementById('stopBtn');
    const nextBtn = document.getElementById('nextBtn');

    const objectives = {
      firstTarget: false,
      collectedStar: false,
      collectedGem: false,
      collectedCoin: false,
      lShapedPath: false,
      threeInOne: false
    };

    const directionNames = ['Norte', 'Este', 'Sur', 'Oeste'];
    const targetTypes = [
      { class: 'star', emoji: '⭐', type: 'stars' },
      { class: 'gem', emoji: '💎', type: 'gems' },
      { class: 'coin', emoji: '🪙', type: 'coins' }
    ];

    // === FUNCIONES DEL ROBOT ===
    function updateRobotPosition() {
      const visualX = x * 40 + 2.5;
      const visualY = y * 40 + 2.5;

      robot.classList.add('robot-moving');
      setTimeout(() => robot.classList.remove('robot-moving'), 600);

      robot.style.left = `${visualX}px`;
      robot.style.top = `${visualY}px`;
      robot.style.transform = `rotate(${direction * 90}deg)`;

      addPathIndicator(x, y);

      const currentTarget = targets[0] ? `(${targets[0].x},${targets[0].y})` : 'Ninguno';
      debugElement.textContent = `Pos: (${x},${y}) | Dir: ${directionNames[direction]} | Objetivo: ${currentTarget}`;

      checkTargetReached();
    }

    function addPathIndicator(x, y) {
      const dot = document.createElement('div');
      dot.className = 'path-indicator';
      dot.style.left = `${x * 40 + 16}px`;
      dot.style.top = `${y * 40 + 16}px`;
      document.getElementById('arena').appendChild(dot);
      setTimeout(() => dot.remove(), 3000);
    }

    function moveForward() {
      const oldX = x, oldY = y;
      let moved = false;
      if (direction === 0 && y > 0) { y--; moved = true; }
      else if (direction === 1 && x < 5) { x++; moved = true; }
      else if (direction === 2 && y < 5) { y++; moved = true; }
      else if (direction === 3 && x > 0) { x--; moved = true; }

      if (moved) {
        pathHistory.push({ x: oldX, y: oldY, newX: x, newY: y, direction });
        updateRobotPosition();
      } else {
        statusElement.textContent = "¡Límite del área alcanzado!";
        statusElement.className = "status error";
        setTimeout(() => {
          if (!isExecuting) {
            statusElement.textContent = "Listo para navegar";
            statusElement.className = "status ready";
          }
        }, 1500);
      }
    }

    function turnLeft() {
      direction = (direction + 3) % 4;
      updateRobotPosition();
    }

    function turnRight() {
      direction = (direction + 1) % 4;
      updateRobotPosition();
    }

    function generateTarget() {
      // Borra anteriores
      targets.forEach(t => t.element.remove());
      targets = [];

      let tx, ty;
      do {
        tx = Math.floor(Math.random() * 6);
        ty = Math.floor(Math.random() * 6);
      } while (tx === x && ty === y);

      const tType = targetTypes[Math.floor(Math.random() * targetTypes.length)];

      const el = document.createElement('div');
      el.className = `target ${tType.class}`;
      el.style.left = `${tx * 40 + 5}px`;
      el.style.top = `${ty * 40 + 5}px`;
      el.textContent = tType.emoji;

      document.getElementById('arena').appendChild(el);
      targets.push({ x: tx, y: ty, element: el, type: tType });

      statusElement.textContent = `¡Nuevo objetivo ${tType.emoji} en (${tx},${ty})!`;
      statusElement.className = "status ready";
    }

    function generateNewTarget() {
      generateTarget();
      const currentTarget = targets[0] ? `(${targets[0].x},${targets[0].y})` : 'Ninguno';
      debugElement.textContent = `Pos: (${x},${y}) | Dir: ${directionNames[direction]} | Objetivo: ${currentTarget}`;
    }

    function checkTargetReached() {
      for (let i = targets.length - 1; i >= 0; i--) {
        const t = targets[i];
        if (t.x === x && t.y === y) {
          t.element.classList.add('reached');
          collectedItems[t.type.type]++;
          updateScoreDisplay();

          if (!objectives.firstTarget) completeObjective('obj1', "¡Primer objetivo alcanzado! 🎯");
          if (t.type.type === 'stars' && !objectives.collectedStar) completeObjective('obj2', "¡Estrella recolectada! ⭐");
          if (t.type.type === 'gems' && !objectives.collectedGem) completeObjective('obj3', "¡Gema recolectada! 💎");
          if (t.type.type === 'coins' && !objectives.collectedCoin) completeObjective('obj4', "¡Moneda recolectada! 🪙");

          currentExecutionCollected++;
          totalObjectivesReached++;
          setTimeout(() => t.element?.remove(), 800);
          targets.splice(i, 1);

          statusElement.textContent = `¡Objetivo alcanzado! ${t.type.emoji} (+1)`;
          statusElement.className = "status success";

          setTimeout(generateTarget, 1000);
          break;
        }
      }
    }

    function updateScoreDisplay() {
      document.getElementById('starCount').textContent = collectedItems.stars;
      document.getElementById('gemCount').textContent = collectedItems.gems;
      document.getElementById('coinCount').textContent = collectedItems.coins;
    }

    function checkObjectives() {
      if (!objectives.lShapedPath && checkLShapedPath()) completeObjective('obj5', "¡Ruta en forma de L! 📐");
      if (!objectives.threeInOne && currentExecutionCollected >= 3) completeObjective('obj6', "¡3 objetivos en una ejecución! 🏆");
      updateProgress();
    }

    function checkLShapedPath() {
      if (pathHistory.length < 2) return false;
      for (let i = 0; i < pathHistory.length - 1; i++) {
        const d1 = pathHistory[i], d2 = pathHistory[i + 1];
        const dir1 = d1.newX !== d1.x ? 'h' : 'v';
        const dir2 = d2.newX !== d2.x ? 'h' : 'v';
        if (dir1 !== dir2) return true;
      }
      return false;
    }

    function completeObjective(id, msg) {
      objectives[id.replace('obj', '')] = true;
      const el = document.getElementById(id);
      el.classList.add('completed', 'celebration');
      el.querySelector('.objective-icon').textContent = '✅';
      statusElement.textContent = msg;
      statusElement.className = "status success";
      setTimeout(() => el.classList.remove('celebration'), 600);
    }

    function updateProgress() {
      const done = Object.values(objectives).filter(Boolean).length;
      const total = Object.keys(objectives).length;
      document.getElementById('progressFill').style.width = `${(done / total) * 100}%`;
      document.getElementById('progressText').textContent = `(${done}/${total})`;
      if (done === total) {
        nextBtn.disabled = false;
        nextBtn.textContent = "🎉 ¡Navegación Completada! Siguiente Tema";
      }
    }

    function runCode() {
      if (isExecuting) return;
      const code = workspace.getTopBlocks(true).map(b => javascriptGenerator.blockToCode(b)).join('');
      const commands = code.trim().split('\n').filter(Boolean);
      if (!commands.length) {
        statusElement.textContent = "Arrastra bloques para crear una ruta";
        statusElement.className = "status error";
        return;
      }

      isExecuting = true;
      runBtn.disabled = true;
      stopBtn.disabled = false;
      currentExecutionCollected = 0;
      statusElement.textContent = "¡Ejecutando programa!";
      statusElement.className = "status running";
      let i = 0; stopped = false;

      window.stopExecution = function () {
        stopped = true;
        stopBtn.disabled = true;
        runBtn.disabled = false;
      };

      function step() {
        if (stopped || i >= commands.length) {
          isExecuting = false;
          runBtn.disabled = false;
          stopBtn.disabled = true;
          checkObjectives();
          statusElement.textContent = stopped ? "Ejecución detenida" : "Ejecución completada";
          statusElement.className = stopped ? "status error" : "status ready";
          return;
        }

        try {
          eval(commands[i]);
        } catch {
          statusElement.textContent = "Error en el bloque " + (i + 1);
          statusElement.className = "status error";
          isExecuting = false;
          runBtn.disabled = false;
          stopBtn.disabled = true;
          return;
        }

        i++;
        setTimeout(step, 1000);
      }

      step();
    }

    function resetRobot() {
      x = 0; y = 0; direction = 0;
      pathHistory = [];
      currentExecutionCollected = 0;
      document.querySelectorAll('.path-indicator').forEach(el => el.remove());
      updateRobotPosition();
      generateNewTarget();
      statusElement.textContent = "Robot reiniciado";
      statusElement.className = "status ready";
    }

    function goBack() { window.history.back(); }
    function goToNextLesson() { alert("¡Felicidades! Has completado la lección."); }

    updateRobotPosition();
    generateNewTarget();
    updateScoreDisplay();
    updateProgress();

    workspace.addChangeListener(() => {
      workspace.setReadOnly(isExecuting);
    });

    // Exportar funciones al global
    window.moveForward = moveForward;
    window.turnLeft = turnLeft;
    window.turnRight = turnRight;
    window.runCode = runCode;
    window.resetRobot = resetRobot;
    window.generateNewTarget = generateNewTarget;
    window.goBack = goBack;
    window.goToNextLesson = goToNextLesson;
  </script>
</body>
</html>