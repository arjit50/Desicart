import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Mint Leaves Falling Animation
document.addEventListener('DOMContentLoaded', () => {
  const container = document.getElementById('falling-leaves-container');
  if (!container) return;

  // SVG Mint Leaf - elegant and recognizable
  const createMintLeaf = () => {
    const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    svg.setAttribute('viewBox', '0 0 100 100');
    svg.setAttribute('width', '24'); // Decreased size from 35
    svg.setAttribute('height', '24');
    svg.setAttribute('class', 'text-emerald-500');

    svg.innerHTML = `
      <defs>
        <filter id="shadow">
          <feDropShadow dx="1" dy="1" stdDeviation="2" flood-opacity="0.3"/>
        </filter>
      </defs>
      <g fill="currentColor" filter="url(#shadow)" opacity="0.9">
        <!-- Mint leaf body (oval/pointed shape) -->
        <path d="M 50 10 Q 80 40 50 90 Q 20 40 50 10" stroke="currentColor" stroke-width="2"/>
        <!-- Central vein -->
        <path d="M 50 15 Q 45 50 50 85" stroke="#047857" stroke-width="2" fill="none" opacity="0.5"/>
        <!-- Side veins -->
        <path d="M 50 35 Q 65 30 70 25 M 50 55 Q 65 50 72 45 M 50 70 Q 60 65 65 60" stroke="#047857" stroke-width="1.5" fill="none" opacity="0.4"/>
        <path d="M 50 35 Q 35 30 30 25 M 50 55 Q 35 50 28 45 M 50 70 Q 40 65 35 60" stroke="#047857" stroke-width="1.5" fill="none" opacity="0.4"/>
      </g>
    `;

    return svg;
  };

  const leafCount = 18;

  // Create falling leaf element
  const createFallingLeaf = (index) => {
    const leaf = document.createElement('div');
    leaf.className = 'falling-leaf';
    
    // Distribute evenly across width to prevent clumping and ensure edge coverage
    const segmentWidth = 100 / leafCount;
    // Places leaf inside its designated column, with a little random variation inside that column
    const leftPercent = (index * segmentWidth) + (Math.random() * segmentWidth);
    
    const duration = 3 + Math.random() * 2; // 3-5 seconds
    const swayDuration = 1.5 + Math.random() * 1.5; // 1.5-3 seconds
    const spinDuration = 2 + Math.random() * 1.5; // 2-3.5 seconds
    const delay = Math.random() * 2; // more spread out start
    
    // Prevent leaf from overflowing right edge exactly
    leaf.style.left = `calc(${leftPercent}% - 12px)`;
    leaf.style.animation = `
      fall ${duration}s linear ${delay}s infinite,
      sway ${swayDuration}s ease-in-out ${delay}s infinite,
      spin-leaf ${spinDuration}s linear ${delay}s infinite
    `;
    
    const svg = createMintLeaf();
    leaf.appendChild(svg);
    
    return leaf;
  };

  // Create initial leaves - evenly distributed
  for (let i = 0; i < leafCount; i++) {
    container.appendChild(createFallingLeaf(i));
  }

  // Handle window resize - no longer strictly needed with percentages, but we can leave a simple refresh
  window.addEventListener('resize', () => {
    // Leaves will naturally adjust because they use % for left
  });
});
