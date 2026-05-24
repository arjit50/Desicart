# Page Transition Animations Guide

Your grocery shop now has **5 beautiful page transition animations** that fit your modern glassmorphic theme. Here's how to use them:

## Available Transitions

### 1. **FADE** (Most Subtle)
- Simple fade out and fade in
- Duration: 0.4s
- Best for: Minimal, professional feel
- Activating code: `'fade'`

```
User sees the page fade to white, then fade back in
```

---

### 2. **SLIDE UP** (Modern & Smooth)
- Content slides upward like a new page coming from below
- Duration: 0.5s
- Best for: Dynamic, forward-moving feel
- Activating code: `'slide-up'`

```
The page slides upward revealing the new content
Like turning a page in a book
```

---

### 3. **BLUR & FADE** ⭐ (RECOMMENDED - Currently Active)
- Page blurs and fades with a white overlay
- Duration: 0.5s
- Best for: Premium, elegant feel (matches your design)
- Activating code: `'blur-fade'`

```
Premium glassmorphic effect with blur
Perfect for your modern theme
Current: ACTIVE ✓
```

---

### 4. **SCALE & FADE** (Focus Effect)
- Content scales down slightly while fading
- Creates a "zooming out" effect
- Duration: 0.5s
- Best for: Drawing focus to transitions
- Activating code: `'scale-fade'`

```
Page shrinks slightly and fades
Emphasizes the transition moment
```

---

### 5. **SLIDE RIGHT** (Directional)
- Page slides out to the right with a sliding overlay
- Duration: 0.5s
- Best for: SPA-like experience
- Activating code: `'slide-right'`

```
Content slides right with gradient overlay
Creates motion and direction
```

---

## How to Change the Active Transition

Edit this file:
```
resources/js/page-transitions.js
```

Find this line (near the top):
```javascript
const ACTIVE_TRANSITION = 'blur-fade'; // Change this
```

Replace `'blur-fade'` with any of:
- `'fade'`
- `'slide-up'`
- `'blur-fade'` (current default)
- `'scale-fade'`
- `'slide-right'`

Then rebuild your assets:
```bash
npm run dev
```

---

## Features

✅ Works with all page navigation (links, forms, buttons)
✅ Respects special link attributes (external links, new tabs, etc.)
✅ Smooth 400-500ms transitions
✅ Styled to match your green/orange theme
✅ Mobile responsive
✅ Accessible (non-blocking)

## Excluded from Transitions

- External links (open in same tab behavior)
- New tab links (target="_blank")
- Links with `data-no-transition` attribute
- Anchor links (#)
- Form submissions with action attributes
- Logout button

## Testing All Transitions

To quickly test each one:

1. Go to `resources/js/page-transitions.js`
2. Change the `ACTIVE_TRANSITION` value
3. Run `npm run dev`
4. Navigate between pages on your site
5. Observe the transition effect

---

## Recommendation

**BLUR & FADE** is set as default because it:
- Matches your glassmorphic design system
- Feels premium and modern
- Not too fast, not too slow
- Works well on all device sizes
- Complements your green (#1b7f4d) and orange (#f59e0b) theme

---

## Customization

Want to modify animation durations or styles? Edit `resources/css/theme.css` at the bottom where you'll find all transition keyframes.

Example: To make blur-fade faster, change `0.5s` to `0.3s` in the animation.

---

## How It Works (Technical)

The system:
1. Intercepts all navigation link clicks
2. Adds `page-transition-active` class to the overlay
3. Plays the chosen animation (400-500ms)
4. Navigates to the new page
5. On new page load, overlay is reset

The overlay uses your color scheme (white background, optional blur) and animates based on the selected transition type.
