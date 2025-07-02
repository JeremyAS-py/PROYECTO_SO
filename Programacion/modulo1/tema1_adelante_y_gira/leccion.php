<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Programación Visual - Tema 1: Movimiento Básico</title>
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
      border-top: 3px solid #4CAF50;
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
      color: #4CAF50;
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
    
    @keyframes robotMove {
      0% { transform: scale(1); }
      50% { transform: scale(1.1); }
      100% { transform: scale(1); }
    }
    
    .robot-moving {
      animation: robotMove 0.6s ease-in-out;
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
      background: linear-gradient(90deg, #4CAF50, #66bb6a);
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
  </style>
</head>
<body>
  <button id="backBtn" onclick="goBack()">← Regresar</button>
  <div id="blocklyDiv"></div>
  <div id="rightPanel">
    <div id="output">
      <h3>🤖 Mi Robot Naranja</h3>
      <div id="arena">
        <div id="robot"></div>
      </div>
      <div class="button-container">
        <button id="runBtn" onclick="runCode()">▶ Ejecutar</button>
        <button id="resetBtn" onclick="resetRobot()">🔄 Reiniciar</button>
        <button id="stopBtn" onclick="stopExecution()" disabled>⏹ Detener</button>
      </div>
      <div id="status" class="status ready">Listo para programar</div>
      <div id="debug" class="debug-info">Pos: (3,3) | Dir: Norte</div>
      <button id="nextBtn" onclick="goToNextLesson()" disabled>
        🚀 Siguiente: Ruta al Objetivo
      </button>
    </div>
    
    <div id="objectives">
      <div class="objectives-title">
        <span>🎯</span>
        <span>Objetivos del Tema</span>
        <span id="progressText">(0/5)</span>
      </div>
      <div class="progress-bar">
        <div class="progress-fill" id="progressFill" style="width: 0%"></div>
      </div>
      
      <div class="objective" id="obj1">
        <div class="objective-icon">⭕</div>
        <div class="objective-text">Ejecuta tu primer programa</div>
      </div>
      
      <div class="objective" id="obj2">
        <div class="objective-icon">⭕</div>
        <div class="objective-text">Haz que el robot avance 3 pasos seguidos</div>
      </div>
      
      <div class="objective" id="obj3">
        <div class="objective-icon">⭕</div>
        <div class="objective-text">Usa el bloque "gira a la izquierda"</div>
      </div>
      
      <div class="objective" id="obj4">
        <div class="objective-icon">⭕</div>
        <div class="objective-text">Usa el bloque "gira a la derecha"</div>
      </div>
      
      <div class="objective" id="obj5">
        <div class="objective-icon">⭕</div>
        <div class="objective-text">Crea un programa con al menos 6 bloques</div>
      </div>
    </div>
  </div>

  <script>
    // === DEFINICIÓN DE BLOQUES ===
    Blockly.defineBlocksWithJsonArray([
      {
        type: "move_forward",
        message0: "avanzar",
        previousStatement: null,
        nextStatement: null,
        colour: 120,
        tooltip: "Mueve el robot hacia adelante"
      },
      {
        type: "turn_left",
        message0: "gira a la izquierda",
        previousStatement: null,
        nextStatement: null,
        colour: 100,
        tooltip: "Gira el robot 90° a la izquierda"
      },
      {
        type: "turn_right",
        message0: "gira a la derecha",
        previousStatement: null,
        nextStatement: null,
        colour: 20,
        tooltip: "Gira el robot 90° a la derecha"
      }
    ]);

    // === GENERADORES DE CÓDIGO JAVASCRIPT ===
    const javascriptGenerator = new Blockly.Generator('JavaScript');

    // Configurar orden de precedencia
    javascriptGenerator.ORDER_NONE = 0;

    javascriptGenerator.forBlock['move_forward'] = function(block, generator) {
      return 'moveForward();\n';
    };

    javascriptGenerator.forBlock['turn_left'] = function(block, generator) {
      return 'turnLeft();\n';
    };

    javascriptGenerator.forBlock['turn_right'] = function(block, generator) {
      return 'turnRight();\n';
    };

    // Sobrescribir el método para generar código de bloques conectados
    javascriptGenerator.scrub_ = function(block, code, thisOnly) {
      const nextBlock = block.nextConnection && block.nextConnection.targetBlock();
      if (nextBlock && !thisOnly) {
        return code + javascriptGenerator.blockToCode(nextBlock);
      }
      return code;
    };

    // === CONFIGURACIÓN DEL TOOLBOX ===
    const toolbox = {
      kind: 'categoryToolbox',
      contents: [
        {
          kind: 'category',
          name: '🚀 Movimiento',
          colour: '120',
          contents: [
            { kind: 'block', type: 'move_forward' },
            { kind: 'block', type: 'turn_left' },
            { kind: 'block', type: 'turn_right' }
          ]
        }
      ]
    };

    // === INYECTAR WORKSPACE ===
    const workspace = Blockly.inject('blocklyDiv', {
      toolbox: toolbox,
      scrollbars: true,
      trashcan: true,
      grid: {
        spacing: 20,
        length: 3,
        colour: '#ccc',
        snap: true
      },
      zoom: {
        controls: true,
        wheel: true,
        startScale: 1.0,
        maxScale: 3,
        minScale: 0.3,
        scaleSpeed: 1.2
      }
    });

    // === VARIABLES DEL ROBOT ===
    let x = 3, y = 3, direction = 0, isExecuting = false;
    const robot = document.getElementById('robot');
    const statusElement = document.getElementById('status');
    const debugElement = document.getElementById('debug');
    const runBtn = document.getElementById('runBtn');
    const stopBtn = document.getElementById('stopBtn');
    const nextBtn = document.getElementById('nextBtn');

    // === SISTEMA DE OBJETIVOS ===
    let objectives = {
      firstRun: false,
      threeSteps: false,
      usedTurnLeft: false,
      usedTurnRight: false,
      sixBlocks: false
    };

    // Nombres de direcciones para debug
    const directionNames = ['Norte', 'Este', 'Sur', 'Oeste'];

    // === FUNCIONES DEL ROBOT ===
    function updateRobotPosition() {
      const visualX = x * 40 + 2.5;
      const visualY = y * 40 + 2.5;
      
      robot.classList.add('robot-moving');
      setTimeout(() => robot.classList.remove('robot-moving'), 600);
      
      robot.style.left = `${visualX}px`;
      robot.style.top = `${visualY}px`;
      
      const rotationDegrees = direction * 90;
      robot.style.transform = `rotate(${rotationDegrees}deg)`;
      
      debugElement.textContent = `Pos: (${x},${y}) | Dir: ${directionNames[direction]} (${rotationDegrees}°)`;
    }

    function moveForward() {
      const oldX = x, oldY = y;
      let moved = false;
      
      switch(direction) {
        case 0: // Norte
          if (y > 0) { y--; moved = true; }
          break;
        case 1: // Este
          if (x < 5) { x++; moved = true; }
          break;
        case 2: // Sur
          if (y < 5) { y++; moved = true; }
          break;
        case 3: // Oeste
          if (x > 0) { x--; moved = true; }
          break;
      }
      
      if (moved) {
        updateRobotPosition();
      } else {
        statusElement.textContent = "¡No se puede avanzar más!";
        statusElement.className = "status error";
        setTimeout(() => {
          if (!isExecuting) {
            statusElement.textContent = "Listo para programar";
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

    // === FUNCIONES DE OBJETIVOS ===
    function checkObjectives(commands) {
      // Objetivo 1: Primer programa ejecutado
      if (!objectives.firstRun && commands.length > 0) {
        objectives.firstRun = true;
        completeObjective('obj1', "¡Genial! Ejecutaste tu primer programa 🎉");
      }

      // Objetivo 2: 3 pasos seguidos
      let consecutiveSteps = 0;
      let maxConsecutive = 0;
      for (let cmd of commands) {
        if (cmd.includes('moveForward')) {
          consecutiveSteps++;
          maxConsecutive = Math.max(maxConsecutive, consecutiveSteps);
        } else {
          consecutiveSteps = 0;
        }
      }
      if (!objectives.threeSteps && maxConsecutive >= 3) {
        objectives.threeSteps = true;
        completeObjective('obj2', "¡Excelente! 3 pasos seguidos 👏");
      }

      // Objetivo 3: Usar giro a la izquierda
      if (!objectives.usedTurnLeft && commands.some(cmd => cmd.includes('turnLeft'))) {
        objectives.usedTurnLeft = true;
        completeObjective('obj3', "¡Bien! Usaste giro a la izquierda 🔄");
      }

      // Objetivo 4: Usar giro a la derecha
      if (!objectives.usedTurnRight && commands.some(cmd => cmd.includes('turnRight'))) {
        objectives.usedTurnRight = true;
        completeObjective('obj4', "¡Perfecto! Usaste giro a la derecha 🔄");
      }

      // Objetivo 5: Programa con 6 bloques
      if (!objectives.sixBlocks && commands.length >= 6) {
        objectives.sixBlocks = true;
        completeObjective('obj5', "¡Increíble! Programa de 6+ bloques 🌟");
      }

      updateProgress();
    }

    function completeObjective(objId, message) {
      const objective = document.getElementById(objId);
      objective.classList.add('completed', 'celebration');
      objective.querySelector('.objective-icon').textContent = '✅';
      
      // Mostrar mensaje de felicitación
      statusElement.textContent = message;
      statusElement.className = "status ready";
      
      setTimeout(() => {
        objective.classList.remove('celebration');
      }, 600);
    }

    function updateProgress() {
      const completed = Object.values(objectives).filter(Boolean).length;
      const total = Object.keys(objectives).length;
      const percentage = (completed / total) * 100;
      
      document.getElementById('progressFill').style.width = `${percentage}%`;
      document.getElementById('progressText').textContent = `(${completed}/${total})`;
      
      // Habilitar botón siguiente si se completan todos los objetivos
      if (completed === total) {
        nextBtn.disabled = false;
        nextBtn.textContent = "🎉 ¡Completado! Ir al Siguiente Tema";
        statusElement.textContent = "¡Felicitaciones! Has completado todos los objetivos";
        statusElement.className = "status ready";
      }
    }

    // === FUNCIONES DE CONTROL ===
    function runCode() {
      if (isExecuting) return;
      
      let code = '';
      const topBlocks = workspace.getTopBlocks(true);
      
      for (let i = 0; i < topBlocks.length; i++) {
        const blockCode = javascriptGenerator.blockToCode(topBlocks[i]);
        if (blockCode) {
          code += blockCode;
        }
      }
      
      if (!code.trim()) {
        statusElement.textContent = "Arrastra bloques para crear un programa";
        statusElement.className = "status error";
        return;
      }

      const commands = code.trim().split('\n').filter(line => line.trim());
      
      // Verificar objetivos antes de ejecutar
      checkObjectives(commands);

      isExecuting = true;
      runBtn.disabled = true;
      stopBtn.disabled = false;
      statusElement.textContent = "Ejecutando...";
      statusElement.className = "status running";

      let commandIndex = 0;
      
      function executeNextCommand() {
        if (!isExecuting || commandIndex >= commands.length) {
          isExecuting = false;
          runBtn.disabled = false;
          stopBtn.disabled = true;
          
          if (statusElement.textContent === "Ejecutando...") {
            statusElement.textContent = "Ejecución completada";
            statusElement.className = "status ready";
          }
          return;
        }
        
        try {
          const command = commands[commandIndex].trim();
          eval(command);
          commandIndex++;
          setTimeout(executeNextCommand, 1500);
        } catch (error) {
          console.error('Error:', error);
          isExecuting = false;
          runBtn.disabled = false;
          stopBtn.disabled = true;
          statusElement.textContent = "Error en ejecución";
          statusElement.className = "status error";
        }
      }
      
      executeNextCommand();
    }

    function resetRobot() {
      isExecuting = false;
      x = 3;
      y = 3; 
      direction = 0;
      updateRobotPosition();
      statusElement.textContent = "Listo para programar";
      statusElement.className = "status ready";
      runBtn.disabled = false;
      stopBtn.disabled = true;
    }

    function stopExecution() {
      isExecuting = false;
      runBtn.disabled = false;
      stopBtn.disabled = true;
      statusElement.textContent = "Ejecución detenida";
      statusElement.className = "status ready";
    }

    function goToNextLesson() {
      // Aquí puedes redirigir a la siguiente lección
      alert("¡Excelente trabajo! 🎉\n\nHas completado el tema 'Movimiento Básico'.\n\nEl siguiente tema 'Ruta al Objetivo' se abrirá pronto...");
      window.location.href = "../tema2_Ruta_al_objetivo/leccion.php";
    }

    function goBack() {
      window.location.href = "../../../detalle_progra.php";
    }

    // === INICIALIZACIÓN ===
    window.addEventListener('load', () => {
      resetRobot();
      updateProgress();
      
      // Cargar bloques de ejemplo más simples para empezar
      const xmlText = `<xml xmlns="https://developers.google.com/blockly/xml">
        <block type="move_forward" x="50" y="50">
          <next>
            <block type="turn_left"></block>
          </next>
        </block>
      </xml>`;
      
      try {
        const xmlDom = Blockly.utils.xml.textToDom(xmlText);
        Blockly.Xml.domToWorkspace(xmlDom, workspace);
      } catch (error) {
        console.error('Error cargando bloques:', error);
      }
    });
  </script>
</body>
</html>