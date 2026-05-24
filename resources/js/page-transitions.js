/**
 * Page Transition Manager
 * Provides multiple transition animations for page navigation
 * 
 * TRANSITION OPTIONS:
 * 1. 'fade'        - Simple fade out/in (most subtle)
 * 2. 'slide-up'    - Content slides upward (smooth, modern)
 * 3. 'blur-fade'   - Blur effect with fade (elegant, premium feel)
 * 4. 'scale-fade'  - Content scales down and fades (focused exit)
 * 5. 'slide-right' - Slide to the right (directional, dynamic)
 * 
 * To change: Update ACTIVE_TRANSITION below
 */

const ACTIVE_TRANSITION = 'blur-fade'; // Change this to switch animations

// Store original href getter to avoid interference
const originalHrefDescriptor = Object.getOwnPropertyDescriptor(HTMLAnchorElement.prototype, 'href');

export function initPageTransitions() {
    document.addEventListener('click', handleLinkClick);
    // Fade out transition on page unload
    window.addEventListener('beforeunload', () => {
        const overlay = document.getElementById('page-transition-overlay');
        if (overlay) {
            overlay.classList.add('page-transition-active');
        }
    });
}

function handleLinkClick(e) {
    const link = e.target.closest('a');
    
    if (!link) return;
    
    // Skip if it's an external link, anchor, or has special attributes
    if (
        link.target === '_blank' ||
        link.target === '_parent' ||
        link.target === '_top' ||
        link.hasAttribute('data-no-transition') ||
        link.href.includes('#') ||
        (link.href && !link.href.startsWith(window.location.origin)) ||
        link.onclick
    ) {
        return;
    }

    // Skip form submissions
    const form = link.closest('form');
    if (form) return;

    // Skip logout and special forms
    if (link.href.includes('logout') || link.hasAttribute('onclick')) return;

    // Allow middle-click and ctrl+click to open in new tab
    if (e.ctrlKey || e.metaKey || e.button === 1) return;

    // Don't transition if already on the same page
    if (link.href === window.location.href) return;

    e.preventDefault();
    
    const href = link.href;
    triggerPageTransition(href);
}

function triggerPageTransition(href) {
    const overlay = document.getElementById('page-transition-overlay');
    if (!overlay) return;

    overlay.classList.add('page-transition-active');

    // Allow transition animation to play before navigation
    setTimeout(() => {
        window.location.href = href;
    }, 400); // Adjust based on animation duration
}

export function setTransitionType(type) {
    const overlay = document.getElementById('page-transition-overlay');
    if (overlay) {
        overlay.setAttribute('data-transition', type);
    }
}

export function getAvailableTransitions() {
    return ['fade', 'slide-up', 'blur-fade', 'scale-fade', 'slide-right'];
}

export function getActiveTransition() {
    return ACTIVE_TRANSITION;
}
