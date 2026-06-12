<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Secure Access — Dimarz</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Space+Mono:wght@400;700&family=Syne:wght@400;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
:root {
--bg: #0c0c14;
--bg-light: #12121e;
--bg-card: #161628;
--bg-hover: #1e1e36;
--text: #e8e8f0;
--text-dim: #9090b0;
--text-muted: #606080;
--border: #2a2a48;
--border-light: #3a3a60;
--accent: #00f0ff;
--accent-glow: rgba(0, 240, 255, 0.15);
--accent-bright: rgba(0, 240, 255, 0.3);
--secondary: #ff2a6d;
--secondary-glow: rgba(255, 42, 109, 0.15);
--error: #ff2a6d;
--error-glow: rgba(255, 42, 109, 0.2);
--glass: rgba(18, 18, 30, 0.65);
}

* { margin: 0; padding: 0; box-sizing: border-box; }

html, body {
width: 100%; height: 100%;
overflow: hidden;
background: var(--bg);
color: var(--text);
font-family: 'Inter', sans-serif;
-webkit-font-smoothing: antialiased;
}

/* Scrollbar hide */
html { scrollbar-width: none; -ms-overflow-style: none; }
html::-webkit-scrollbar { display: none; }

/* ===== AMBIENT BACKGROUND ===== */
.glow-orb {
position: fixed;
border-radius: 50%;
filter: blur(100px);
pointer-events: none;
z-index: 0;
opacity: 0.35;
animation: orbFloat 18s ease-in-out infinite;
}
.orb-1 { width: 500px; height: 500px; background: var(--accent); top: -10%; left: -10%; animation-delay: 0s; }
.orb-2 { width: 400px; height: 400px; background: var(--secondary); bottom: -10%; right: -10%; animation-delay: -6s; opacity: 0.25; }
.orb-3 { width: 300px; height: 300px; background: var(--accent); top: 50%; left: 60%; opacity: 0.15; animation-delay: -12s; }

@keyframes orbFloat {
0%, 100% { transform: translate(0, 0) scale(1); }
25% { transform: translate(25px, -25px) scale(1.08); }
50% { transform: translate(-15px, 15px) scale(0.95); }
75% { transform: translate(15px, 10px) scale(1.03); }
}

.noise {
position: fixed; inset: 0; pointer-events: none; z-index: 1; opacity: 0.025;
background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
}

.grid-bg {
position: fixed; inset: 0; pointer-events: none; z-index: 0;
background-image: 
linear-gradient(rgba(0, 240, 255, 0.03) 1px, transparent 1px),
linear-gradient(90deg, rgba(255, 42, 109, 0.02) 1px, transparent 1px);
background-size: 70px 70px;
}

.line {
position: fixed;
height: 1px;
animation: lineMove 10s linear infinite;
z-index: 0;
pointer-events: none;
}
.line:nth-child(1) { top: 20%; width: 40%; left: -40%; background: linear-gradient(90deg, transparent, var(--accent-glow), transparent); animation-duration: 12s; }
.line:nth-child(2) { top: 60%; width: 30%; left: -30%; background: linear-gradient(90deg, transparent, var(--secondary-glow), transparent); animation-duration: 9s; animation-delay: 3s; }
.line:nth-child(3) { top: 40%; width: 35%; right: -35%; background: linear-gradient(90deg, transparent, var(--accent-glow), transparent); animation: lineMoveReverse 11s linear infinite; animation-delay: 2s; }

@keyframes lineMove { 0% { left: -40%; } 100% { left: 100%; } }
@keyframes lineMoveReverse { 0% { right: -35%; } 100% { right: 100%; } }

/* ===== LAYOUT ===== */
.login-shell {
position: relative;
z-index: 10;
width: 100%;
height: 100vh;
display: flex;
align-items: center;
justify-content: center;
padding: 20px;
}

/* ===== LOGIN CARD ===== */
.login-card {
width: 100%;
max-width: 420px;
background: var(--glass);
backdrop-filter: blur(24px);
border: 1px solid var(--border);
border-radius: 16px;
padding: 48px 40px;
position: relative;
overflow: hidden;
animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
opacity: 0;
transform: translateY(20px);
box-shadow: 0 0 60px rgba(0, 240, 255, 0.04), 0 20px 60px rgba(0, 0, 0, 0.4);
transition: transform 0.1s ease-out;
}

/* Top gradient line */
.login-card::before {
content: '';
position: absolute;
top: 0; left: 0; right: 0; height: 2px;
background: linear-gradient(90deg, var(--accent), var(--secondary));
opacity: 0.8;
box-shadow: 0 0 20px var(--accent-glow);
}

/* Corner accents */
.corner {
position: absolute;
width: 32px; height: 32px;
border-color: var(--border);
border-style: solid;
opacity: 0.6;
}
.corner.tl { top: 16px; left: 16px; border-width: 1px 0 0 1px; }
.corner.tr { top: 16px; right: 16px; border-width: 1px 1px 0 0; }
.corner.bl { bottom: 16px; left: 16px; border-width: 0 0 1px 1px; }
.corner.br { bottom: 16px; right: 16px; border-width: 0 1px 1px 0; }

.brand {
text-align: center;
margin-bottom: 8px;
}
.brand-name {
font-family: 'Syne', sans-serif;
font-size: 1.8rem;
font-weight: 800;
letter-spacing: -1px;
background: linear-gradient(135deg, var(--text), var(--accent));
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;
}
.brand-tag {
font-family: 'Space Mono', monospace;
font-size: 0.6rem;
letter-spacing: 4px;
text-transform: uppercase;
color: var(--text-muted);
margin-bottom: 40px;
text-align: center;
}

/* ===== FORM ===== */
.form-group {
margin-bottom: 24px;
position: relative;
}

.form-label {
display: block;
font-family: 'Space Mono', monospace;
font-size: 0.6rem;
letter-spacing: 3px;
text-transform: uppercase;
color: var(--text-muted);
margin-bottom: 10px;
transition: color 0.3s ease;
}
.form-group:focus-within .form-label {
color: var(--accent);
text-shadow: 0 0 10px var(--accent-glow);
}

.input-wrap {
position: relative;
}

.form-input {
width: 100%;
background: var(--bg-card);
border: 1px solid var(--border);
color: var(--text);
font-family: 'Inter', sans-serif;
font-size: 0.95rem;
padding: 14px 16px;
border-radius: 8px;
outline: none;
transition: all 0.3s ease;
}
.form-input::placeholder {
color: var(--text-muted);
font-weight: 300;
}
.form-input:focus {
border-color: var(--accent);
background: var(--bg-hover);
box-shadow: 0 0 20px var(--accent-glow), inset 0 0 20px rgba(0, 240, 255, 0.03);
}
.form-input.error {
border-color: var(--error);
box-shadow: 0 0 15px var(--error-glow);
animation: shake 0.5s ease;
}

@keyframes shake {
0%, 100% { transform: translateX(0); }
20% { transform: translateX(-6px); }
40% { transform: translateX(6px); }
60% { transform: translateX(-4px); }
80% { transform: translateX(4px); }
}

/* Password toggle */
.password-toggle {
position: absolute;
right: 14px;
top: 50%;
transform: translateY(-50%);
background: none;
border: none;
color: var(--text-muted);
cursor: pointer;
padding: 4px;
display: flex;
align-items: center;
justify-content: center;
transition: color 0.3s ease;
}
.password-toggle:hover { color: var(--accent); }
.password-toggle svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2; }

/* Remember & Forgot row */
.form-extras {
display: flex;
justify-content: space-between;
align-items: center;
margin-bottom: 28px;
font-size: 0.85rem;
}

.remember-wrap {
display: flex;
align-items: center;
gap: 10px;
cursor: pointer;
color: var(--text-dim);
transition: color 0.3s ease;
}
.remember-wrap:hover { color: var(--text); }

.custom-check {
width: 18px; height: 18px;
border: 1px solid var(--border);
border-radius: 4px;
background: var(--bg-card);
display: flex;
align-items: center;
justify-content: center;
transition: all 0.3s ease;
flex-shrink: 0;
}
.remember-wrap:hover .custom-check { border-color: var(--accent); }
input[type="checkbox"]:checked + .custom-check {
background: linear-gradient(135deg, var(--accent), var(--secondary));
border-color: transparent;
}
input[type="checkbox"]:checked + .custom-check::after {
content: '✓';
color: var(--bg);
font-size: 0.7rem;
font-weight: 700;
}
input[type="checkbox"] { position: absolute; opacity: 0; width: 0; height: 0; }

.forgot-link {
color: var(--text-muted);
text-decoration: none;
font-size: 0.8rem;
font-weight: 500;
transition: all 0.3s ease;
border-bottom: 1px solid transparent;
padding-bottom: 1px;
}
.forgot-link:hover {
color: var(--accent);
border-bottom-color: var(--accent);
text-shadow: 0 0 10px var(--accent-glow);
}

/* Submit Button */
.submit-btn {
width: 100%;
font-family: 'Space Mono', monospace;
font-size: 0.75rem;
letter-spacing: 3px;
text-transform: uppercase;
padding: 16px;
border: none;
border-radius: 8px;
background: linear-gradient(135deg, var(--accent), var(--secondary));
color: var(--bg);
font-weight: 700;
cursor: pointer;
position: relative;
overflow: hidden;
transition: all 0.4s ease;
display: flex;
align-items: center;
justify-content: center;
gap: 10px;
}
.submit-btn::before {
content: '';
position: absolute;
top: 0; left: -100%;
width: 100%; height: 100%;
background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
transition: left 0.6s ease;
}
.submit-btn:hover {
box-shadow: 0 0 40px var(--accent-glow), 0 0 60px var(--secondary-glow);
transform: translateY(-2px);
}
.submit-btn:hover::before { left: 100%; }
.submit-btn:active { transform: translateY(0); }

/* Error Banner */
.error-banner {
background: rgba(255, 42, 109, 0.08);
border: 1px solid rgba(255, 42, 109, 0.2);
border-radius: 8px;
padding: 12px 16px;
margin-bottom: 24px;
display: flex;
align-items: center;
gap: 10px;
font-size: 0.85rem;
color: var(--secondary);
animation: fadeUp 0.5s ease;
}
.error-banner svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }

/* Session Success */
.success-banner {
background: rgba(34, 197, 94, 0.08);
border: 1px solid rgba(34, 197, 94, 0.2);
border-radius: 8px;
padding: 12px 16px;
margin-bottom: 24px;
display: flex;
align-items: center;
gap: 10px;
font-size: 0.85rem;
color: #22c55e;
animation: fadeUp 0.5s ease;
}

/* Back link */
.back-link {
display: block;
text-align: center;
margin-top: 28px;
font-family: 'Space Mono', monospace;
font-size: 0.65rem;
letter-spacing: 2px;
text-transform: uppercase;
color: var(--text-muted);
text-decoration: none;
transition: all 0.3s ease;
}
.back-link:hover {
color: var(--accent);
text-shadow: 0 0 10px var(--accent-glow);
}

/* Animations */
@keyframes fadeUp {
from { opacity: 0; transform: translateY(20px); }
to { opacity: 1; transform: translateY(0); }
}

/* Responsive */
@media (max-width: 480px) {
.login-card { padding: 36px 24px; }
.brand-name { font-size: 1.5rem; }
}
</style>
</head>
<body>

<div class="glow-orb orb-1"></div>
<div class="glow-orb orb-2"></div>
<div class="glow-orb orb-3"></div>
<div class="noise"></div>
<div class="grid-bg"></div>
<div class="line"></div>
<div class="line"></div>
<div class="line"></div>

<div class="login-shell">
<div class="login-card" id="loginCard">
<div class="corner tl"></div>
<div class="corner tr"></div>
<div class="corner bl"></div>
<div class="corner br"></div>

<div class="brand">
<div class="brand-name">DIMARZ</div>
</div>
<div class="brand-tag">Secure Command Access</div>

@if ($errors->any())
<div class="error-banner">
<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
<span>{{ $errors->first() }}</span>
</div>
@endif

@if (session('status'))
<div class="success-banner">
<svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" fill="none" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
<span>{{ session('status') }}</span>
</div>
@endif

<form method="POST" action="{{ route('login') }}" id="loginForm">
@csrf

<div class="form-group">
<label class="form-label" for="email">Email Address</label>
<div class="input-wrap">
<input 
type="email" 
id="email" 
name="email" 
class="form-input @error('email') error @enderror" 
placeholder="admin@dimarz.com" 
value="{{ old('email') }}" 
required 
autofocus
>
</div>
</div>

<div class="form-group">
<label class="form-label" for="password">Password</label>
<div class="input-wrap">
<input 
type="password" 
id="password" 
name="password" 
class="form-input @error('password') error @enderror" 
placeholder="••••••••" 
required
>
<button type="button" class="password-toggle" id="togglePassword" tabindex="-1">
<svg id="eyeIcon" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
<svg id="eyeOffIcon" viewBox="0 0 24 24" style="display: none;"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
</button>
</div>
</div>

<div class="form-extras">
<label class="remember-wrap">
<input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
<div class="custom-check"></div>
<span>Remember me</span>
</label>

@if (Route::has('password.request'))
<a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
@endif
</div>

<button type="submit" class="submit-btn" id="submitBtn">
Authenticate
<svg width="16" height="16" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="3"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
</button>
</form>

<a href="{{ route('portfolio') }}" class="back-link">← Return to Portfolio</a>
</div>
</div>

<script>
// Password visibility toggle
const passwordInput = document.getElementById('password');
const toggleBtn = document.getElementById('togglePassword');
const eyeIcon = document.getElementById('eyeIcon');
const eyeOffIcon = document.getElementById('eyeOffIcon');

toggleBtn.addEventListener('click', () => {
const isPassword = passwordInput.type === 'password';
passwordInput.type = isPassword ? 'text' : 'password';
eyeIcon.style.display = isPassword ? 'none' : 'block';
eyeOffIcon.style.display = isPassword ? 'block' : 'none';
});

// Subtle 3D tilt on mouse move
const card = document.getElementById('loginCard');
document.addEventListener('mousemove', (e) => {
const x = (e.clientX / window.innerWidth - 0.5) * 10;
const y = (e.clientY / window.innerHeight - 0.5) * 10;
card.style.transform = `perspective(1000px) rotateX(${-y * 0.3}deg) rotateY(${x * 0.3}deg) translateY(0)`;
});

// Loading state on submit
const form = document.getElementById('loginForm');
const submitBtn = document.getElementById('submitBtn');
const originalBtnText = submitBtn.innerHTML;

form.addEventListener('submit', () => {
submitBtn.disabled = true;
submitBtn.innerHTML = `
<span style="display: inline-block; width: 14px; height: 14px; border: 2px solid var(--bg); border-top-color: transparent; border-radius: 50%; animation: spin 0.8s linear infinite;"></span>
Verifying...
`;
submitBtn.style.opacity = '0.8';
});

// Add spin keyframe dynamically
const style = document.createElement('style');
style.textContent = `@keyframes spin { to { transform: rotate(360deg); } }`;
document.head.appendChild(style);

// Remove error class on input
document.querySelectorAll('.form-input').forEach(input => {
input.addEventListener('input', () => input.classList.remove('error'));
});
</script>
</body>
</html>
