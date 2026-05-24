@if(request('test_transitions') === 'true')
<style>
    .transition-demo-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 50;
        background: white;
        border: 2px solid #1b7f4d;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        max-width: 320px;
        font-family: 'Outfit', sans-serif;
    }

    .transition-demo-title {
        font-size: 14px;
        font-weight: 700;
        color: #1b7f4d;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .transition-buttons {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .transition-btn {
        padding: 10px 12px;
        background: #f0fdf4;
        border: 1px solid #1b7f4d;
        border-radius: 8px;
        cursor: pointer;
        font-size: 12px;
        font-weight: 600;
        color: #1b7f4d;
        transition: all 0.2s ease;
        text-align: left;
    }

    .transition-btn:hover {
        background: #1b7f4d;
        color: white;
        transform: translateX(4px);
    }

    .transition-btn.active {
        background: #1b7f4d;
        color: white;
        font-weight: 700;
    }

    .demo-info {
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid #e5e7eb;
        font-size: 11px;
        color: #666;
        line-height: 1.4;
    }

    .close-demo {
        position: absolute;
        top: 10px;
        right: 10px;
        background: none;
        border: none;
        font-size: 16px;
        cursor: pointer;
        color: #9ca3af;
    }

    .close-demo:hover {
        color: #1b7f4d;
    }
</style>

<div class="transition-demo-container">
    <button class="close-demo" onclick="window.location.href='{{ url('/') }}'">✕</button>
    <div class="transition-demo-title">Page Transitions</div>
    
    <div class="transition-buttons">
        <button class="transition-btn fade-btn" onclick="setTransition('fade')">
            🔲 Fade (Subtle)
        </button>
        <button class="transition-btn slide-up-btn" onclick="setTransition('slide-up')">
            ⬆️ Slide Up (Modern)
        </button>
        <button class="transition-btn blur-fade-btn active" onclick="setTransition('blur-fade')">
            ✨ Blur & Fade (Recommended)
        </button>
        <button class="transition-btn scale-fade-btn" onclick="setTransition('scale-fade')">
            📦 Scale & Fade
        </button>
        <button class="transition-btn slide-right-btn" onclick="setTransition('slide-right')">
            ➡️ Slide Right
        </button>
    </div>

    <div class="demo-info">
        <strong>Try it:</strong> Click the buttons above, then click any link on the page to see the transition. <br>Active: <strong id="active-transition">blur-fade</strong>
    </div>
</div>

<script>
    const transitions = ['fade', 'slide-up', 'blur-fade', 'scale-fade', 'slide-right'];
    let currentTransition = 'blur-fade';

    function setTransition(type) {
        if (!transitions.includes(type)) return;
        
        currentTransition = type;
        document.getElementById('active-transition').textContent = type;
        
        // Update button styles
        document.querySelectorAll('.transition-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        document.querySelector(`.${type.replace('-', '')}-btn`).classList.add('active');
        
        // Update overlay data attribute
        const overlay = document.getElementById('page-transition-overlay');
        if (overlay) {
            overlay.setAttribute('data-transition', type);
        }
    }

    // Make setTransition available globally
    window.setTransition = setTransition;
</script>
@endif
