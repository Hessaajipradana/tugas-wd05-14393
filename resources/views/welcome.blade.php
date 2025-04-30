<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Poliklinikikuk</title>
  <style>
    /* Reset and base styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
      min-height: 100vh;
      width: 100%;
      overflow-x: hidden;
      background-color: white;
      color: #0f172a;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    body.dark {
      background-color: #0a0a0a;
      color: white;
    }

    /* Container styles */
    .container {
      position: relative;
      min-height: 100vh;
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }

    .content {
      position: relative;
      z-index: 10;
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 1rem;
      text-align: center;
    }

    .inner-content {
      max-width: 56rem;
      margin: 0 auto;
      opacity: 0;
      animation: fadeIn 2s forwards;
    }

    /* Title styles */
    .title {
      font-size: 4rem;
      font-weight: 700;
      margin-bottom: 2rem;
      letter-spacing: -0.05em;
      line-height: 1.1;
    }

    @media (min-width: 640px) {
      .title {
        font-size: 5rem;
      }
    }

    @media (min-width: 768px) {
      .title {
        font-size: 6rem;
      }
    }

    @media (min-width: 1024px) {
      .title {
        font-size: 8rem;
      }
    }

    .title span.word {
      display: inline-block;
      margin-right: 1rem;
    }

    .title span.word:last-child {
      margin-right: 0;
    }

    .letter {
      display: inline-block;
      background: linear-gradient(to right, #0f172a, rgba(107, 114, 128, 0.8));
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      transform: translateY(100px);
      opacity: 0;
    }

    body.dark .letter {
      background: linear-gradient(to right, white, rgba(255, 255, 255, 0.8));
      -webkit-background-clip: text;
      background-clip: text;
    }

    /* Button styles */
    .button-container {
      display: inline-flex;
      gap: 1rem;
      margin-top: 2rem;
      flex-wrap: wrap;
      justify-content: center;
    }

    .button-wrapper {
      display: inline-block;
      position: relative;
      background: linear-gradient(to bottom, rgba(0, 0, 0, 0.1), rgba(255, 255, 255, 0.1));
      padding: 1px;
      border-radius: 1.15rem;
      backdrop-filter: blur(8px);
      overflow: hidden;
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
      transition: box-shadow 0.3s ease, transform 0.3s ease;
    }

    body.dark .button-wrapper {
      background: linear-gradient(to bottom, rgba(255, 255, 255, 0.1), rgba(0, 0, 0, 0.1));
    }

    .button-wrapper:hover {
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
      transform: translateY(-2px);
    }

    .button {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 1.15rem;
      padding: 0.75rem 2rem;
      font-size: 1.125rem;
      font-weight: 600;
      background-color: rgba(255, 255, 255, 0.95);
      color: black;
      border: 1px solid rgba(0, 0, 0, 0.1);
      cursor: pointer;
      transition: all 0.3s ease;
      backdrop-filter: blur(4px);
      min-width: 140px;
    }

    body.dark .button {
      background-color: rgba(0, 0, 0, 0.95);
      color: white;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .button:hover {
      background-color: rgba(255, 255, 255, 1);
    }

    body.dark .button:hover {
      background-color: rgba(0, 0, 0, 1);
    }

    .button span {
      opacity: 0.9;
      transition: opacity 0.3s ease;
    }

    .button:hover span {
      opacity: 1;
    }

    .button .arrow {
      margin-left: 0.75rem;
      opacity: 0.7;
      transform: translateX(0);
      transition: all 0.3s ease;
    }

    .button:hover .arrow {
      opacity: 1;
      transform: translateX(6px);
    }

    /* SVG background styles */
    .background {
      position: absolute;
      inset: 0;
      pointer-events: none;
    }

    .svg-container {
      width: 100%;
      height: 100%;
      color: #0f172a;
    }

    body.dark .svg-container {
      color: white;
    }

    /* Animations */
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes letterAnimation {
      0% {
        transform: translateY(100px);
        opacity: 0;
      }
      100% {
        transform: translateY(0);
        opacity: 1;
      }
    }

    /* Loading animation */
    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 1000;
      transition: opacity 0.5s ease, visibility 0.5s ease;
    }

    body.dark .loading-overlay {
      background-color: #0a0a0a;
    }

    .loading-spinner {
      width: 50px;
      height: 50px;
      border: 5px solid rgba(0, 0, 0, 0.1);
      border-radius: 50%;
      border-top-color: #0f172a;
      animation: spin 1s ease-in-out infinite;
    }

    body.dark .loading-spinner {
      border: 5px solid rgba(255, 255, 255, 0.1);
      border-top-color: white;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    .hidden {
      opacity: 0;
      visibility: hidden;
    }
  </style>
</head>
<body>
  <!-- Loading overlay -->
  <div class="loading-overlay" id="loading-overlay">
    <div class="loading-spinner"></div>
  </div>

  <div class="container">
    <div class="background" id="background1"></div>
    <div class="background" id="background2"></div>

    <div class="content">
      <div class="inner-content">
        <h1 class="title" id="title">Poliklinikikuk</h1>

        <div class="button-container">
          <div class="button-wrapper">
            <button class="button" id="masuk-btn">
              <span>Masuk</span>
              <span class="arrow">→</span>
            </button>
          </div>
          <div class="button-wrapper">
            <button class="button" id="daftar-btn">
              <span>Daftar</span>
              <span class="arrow">→</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Create static SVG paths for background
    function createStaticPaths(containerId, position) {
      const container = document.getElementById(containerId);
      const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
      svg.setAttribute('class', 'svg-container');
      svg.setAttribute('viewBox', '0 0 696 316');
      svg.setAttribute('fill', 'none');
      
      const title = document.createElementNS('http://www.w3.org/2000/svg', 'title');
      title.textContent = 'Background Paths';
      svg.appendChild(title);
      
      for (let i = 0; i < 36; i++) {
        const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        const d = `M-${380 - i * 5 * position} -${189 + i * 6}C-${
          380 - i * 5 * position
        } -${189 + i * 6} -${312 - i * 5 * position} ${216 - i * 6} ${
          152 - i * 5 * position
        } ${343 - i * 6}C${616 - i * 5 * position} ${470 - i * 6} ${
          684 - i * 5 * position
        } ${875 - i * 6} ${684 - i * 5 * position} ${875 - i * 6}`;
        
        path.setAttribute('d', d);
        path.setAttribute('stroke', 'currentColor');
        path.setAttribute('stroke-width', (0.5 + i * 0.03).toString());
        path.setAttribute('stroke-opacity', (0.1 + i * 0.03).toString());
        
        svg.appendChild(path);
      }
      
      container.appendChild(svg);
    }

    // Create animated title
    function animateTitle() {
      const titleElement = document.getElementById('title');
      const text = titleElement.textContent;
      titleElement.textContent = '';
      
      const words = text.split(' ');
      
      words.forEach((word, wordIndex) => {
        const wordSpan = document.createElement('span');
        wordSpan.classList.add('word');
        
        Array.from(word).forEach((letter, letterIndex) => {
          const letterSpan = document.createElement('span');
          letterSpan.classList.add('letter');
          letterSpan.textContent = letter;
          
          // Set animation delay based on word and letter index
          const delay = wordIndex * 0.1 + letterIndex * 0.03;
          letterSpan.style.animation = `letterAnimation 0.5s forwards ease-out`;
          letterSpan.style.animationDelay = `${delay + 0.5}s`; // Add 0.5s for initial loading
          
          wordSpan.appendChild(letterSpan);
        });
        
        titleElement.appendChild(wordSpan);
      });
    }

    // Check for dark mode preference
    function setupDarkMode() {
      if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        document.body.classList.add('dark');
      }
      
      // Listen for changes in color scheme preference
      window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
        if (event.matches) {
          document.body.classList.add('dark');
        } else {
          document.body.classList.remove('dark');
        }
      });
    }

    // Button click handlers
    function setupButtons() {
      const masukBtn = document.getElementById('masuk-btn');
      const daftarBtn = document.getElementById('daftar-btn');
      
      masukBtn.addEventListener('click', () => {
        window.location.href = "{{ route('login') }}";
      });
      
      daftarBtn.addEventListener('click', () => {
        window.location.href = "{{ route('register') }}";
      });
    }

    // Handle loading screen
    function handleLoading() {
      const loadingOverlay = document.getElementById('loading-overlay');
      
      // Hide loading screen after everything is loaded
      window.addEventListener('load', () => {
        setTimeout(() => {
          loadingOverlay.classList.add('hidden');
        }, 800); // Give a little extra time for animations to prepare
      });
    }

    // Initialize everything
    document.addEventListener('DOMContentLoaded', () => {
      setupDarkMode();
      createStaticPaths('background1', 1);
      createStaticPaths('background2', -1);
      animateTitle();
      setupButtons();
      handleLoading();
    });
  </script>
</body>
</html>