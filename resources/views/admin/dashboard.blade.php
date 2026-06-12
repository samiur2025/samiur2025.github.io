<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Dimarz Admin — Lead Command Center</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Space+Mono:wght@400;700&family=Syne:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
--secondary-bright: rgba(255, 42, 109, 0.3);
--overlay: rgba(12, 12, 20, 0.96);
--glass: rgba(22, 22, 40, 0.6);
}

html { scrollbar-width: none; -ms-overflow-style: none; }
html::-webkit-scrollbar { display: none; }
* { margin: 0; padding: 0; box-sizing: border-box; }

body {
background: var(--bg);
color: var(--text);
font-family: 'Inter', sans-serif;
-webkit-font-smoothing: antialiased;
overflow-x: hidden;
}

/* Ambient Background */
.glow-orb {
position: fixed;
border-radius: 50%;
filter: blur(120px);
pointer-events: none;
z-index: 0;
opacity: 0.25;
animation: orbFloat 20s ease-in-out infinite;
}
.orb-1 { width: 600px; height: 600px; background: var(--accent); top: -10%; left: -10%; animation-delay: 0s; }
.orb-2 { width: 500px; height: 500px; background: var(--secondary); bottom: -10%; right: -10%; animation-delay: -7s; opacity: 0.2; }
.orb-3 { width: 400px; height: 400px; background: var(--accent); top: 40%; right: 30%; opacity: 0.15; animation-delay: -14s; }

@keyframes orbFloat {
0%, 100% { transform: translate(0, 0) scale(1); }
25% { transform: translate(30px, -30px) scale(1.1); }
50% { transform: translate(-20px, 20px) scale(0.95); }
75% { transform: translate(20px, 10px) scale(1.05); }
}

.noise {
position: fixed; inset: 0; pointer-events: none; z-index: 1000; opacity: 0.02;
background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
}

/* Layout */
.admin-shell { display: flex; min-height: 100vh; position: relative; z-index: 1; }

/* Sidebar */
.sidebar {
width: 260px;
background: rgba(12, 12, 20, 0.8);
backdrop-filter: blur(20px);
border-right: 1px solid var(--border);
padding: 40px 24px;
display: flex;
flex-direction: column;
position: fixed;
height: 100vh;
z-index: 50;
}
.brand {
font-family: 'Syne', sans-serif;
font-weight: 800;
font-size: 1.5rem;
letter-spacing: -1px;
background: linear-gradient(135deg, var(--text), var(--accent));
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;
margin-bottom: 8px;
}
.brand-sub {
font-family: 'Space Mono', monospace;
font-size: 0.6rem;
letter-spacing: 3px;
text-transform: uppercase;
color: var(--text-muted);
margin-bottom: 48px;
}
.nav-item {
display: flex;
align-items: center;
gap: 12px;
padding: 14px 16px;
border-radius: 8px;
color: var(--text-dim);
text-decoration: none;
font-size: 0.85rem;
font-weight: 500;
transition: all 0.3s ease;
margin-bottom: 4px;
border: 1px solid transparent;
}
.nav-item:hover, .nav-item.active {
background: var(--bg-card);
color: var(--text);
border-color: var(--border);
box-shadow: 0 0 20px var(--accent-glow);
}
.nav-item.active {
background: linear-gradient(135deg, rgba(0,240,255,0.1), rgba(255,42,109,0.05));
border-color: var(--border-light);
}
.nav-icon { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2; }

/* Main Content */
.main {
margin-left: 260px;
flex: 1;
padding: 40px 48px;
max-width: calc(100% - 260px);
}
.topbar {
display: flex;
justify-content: space-between;
align-items: center;
margin-bottom: 40px;
padding-bottom: 24px;
border-bottom: 1px solid var(--border);
}
.page-title {
font-family: 'Syne', sans-serif;
font-size: 1.8rem;
font-weight: 700;
letter-spacing: -1px;
}
.live-indicator {
display: flex;
align-items: center;
gap: 8px;
font-family: 'Space Mono', monospace;
font-size: 0.7rem;
color: var(--accent);
text-shadow: 0 0 10px var(--accent-glow);
}
.live-dot {
width: 8px; height: 8px; border-radius: 50%;
background: var(--accent);
box-shadow: 0 0 10px var(--accent);
animation: pulse 2s infinite;
}
@keyframes pulse {
0%, 100% { opacity: 1; transform: scale(1); }
50% { opacity: 0.5; transform: scale(0.8); }
}

/* Stats Grid */
.stats-grid {
display: grid;
grid-template-columns: repeat(4, 1fr);
gap: 20px;
margin-bottom: 40px;
}
.stat-card {
background: var(--glass);
backdrop-filter: blur(10px);
border: 1px solid var(--border);
border-radius: 12px;
padding: 28px 24px;
position: relative;
overflow: hidden;
transition: all 0.4s ease;
}
.stat-card::before {
content: '';
position: absolute;
top: 0; left: 0; right: 0; height: 2px;
background: linear-gradient(90deg, var(--accent), var(--secondary));
opacity: 0;
transition: opacity 0.4s ease;
}
.stat-card:hover {
border-color: var(--border-light);
transform: translateY(-4px);
box-shadow: 0 20px 40px rgba(0,0,0,0.3), 0 0 40px var(--accent-glow);
}
.stat-card:hover::before { opacity: 1; }
.stat-label {
font-family: 'Space Mono', monospace;
font-size: 0.65rem;
letter-spacing: 2px;
text-transform: uppercase;
color: var(--text-muted);
margin-bottom: 12px;
}
.stat-value {
font-family: 'Syne', sans-serif;
font-size: 2.2rem;
font-weight: 800;
letter-spacing: -2px;
background: linear-gradient(135deg, var(--text), var(--accent));
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;
line-height: 1;
}
.stat-card:nth-child(2) .stat-value {
background: linear-gradient(135deg, var(--text), var(--secondary));
-webkit-background-clip: text;
}
.stat-card:nth-child(3) .stat-value {
background: linear-gradient(135deg, var(--text), #a855f7);
-webkit-background-clip: text;
}
.stat-card:nth-child(4) .stat-value {
background: linear-gradient(135deg, var(--text), #22c55e);
-webkit-background-clip: text;
}

/* Toolbar */
.toolbar {
display: flex;
gap: 16px;
margin-bottom: 24px;
align-items: center;
flex-wrap: wrap;
}
.search-box {
position: relative;
flex: 1;
min-width: 280px;
max-width: 400px;
}
.search-box input {
width: 100%;
background: var(--bg-card);
border: 1px solid var(--border);
color: var(--text);
padding: 12px 16px 12px 44px;
border-radius: 8px;
font-family: 'Inter', sans-serif;
font-size: 0.9rem;
outline: none;
transition: all 0.3s ease;
}
.search-box input:focus {
border-color: var(--accent);
box-shadow: 0 0 20px var(--accent-glow);
}
.search-icon {
position: absolute;
left: 14px;
top: 50%;
transform: translateY(-50%);
width: 18px; height: 18px;
stroke: var(--text-muted);
fill: none; stroke-width: 2;
}
.filter-select {
background: var(--bg-card);
border: 1px solid var(--border);
color: var(--text);
padding: 12px 16px;
border-radius: 8px;
font-size: 0.85rem;
outline: none;
cursor: pointer;
transition: all 0.3s ease;
}
.filter-select:focus { border-color: var(--accent); }

.btn {
font-family: 'Space Mono', monospace;
font-size: 0.7rem;
letter-spacing: 1.5px;
text-transform: uppercase;
padding: 12px 20px;
border: 1px solid var(--border);
background: transparent;
color: var(--text);
cursor: pointer;
border-radius: 8px;
transition: all 0.3s ease;
display: inline-flex;
align-items: center;
gap: 8px;
text-decoration: none;
}
.btn:hover {
border-color: var(--accent);
box-shadow: 0 0 20px var(--accent-glow);
color: var(--accent);
}
.btn-danger:hover {
border-color: var(--secondary);
box-shadow: 0 0 20px var(--secondary-glow);
color: var(--secondary);
}
.btn-primary {
background: linear-gradient(135deg, var(--accent), var(--secondary));
color: var(--bg);
border-color: transparent;
font-weight: 700;
}
.btn-primary:hover {
box-shadow: 0 0 30px var(--accent-glow), 0 0 50px var(--secondary-glow);
color: var(--bg);
}

/* Table */
.table-wrap {
background: var(--glass);
backdrop-filter: blur(10px);
border: 1px solid var(--border);
border-radius: 12px;
overflow: hidden;
}
table {
width: 100%;
border-collapse: collapse;
font-size: 0.9rem;
}
thead {
background: rgba(22, 22, 40, 0.8);
border-bottom: 1px solid var(--border);
}
th {
font-family: 'Space Mono', monospace;
font-size: 0.65rem;
letter-spacing: 2px;
text-transform: uppercase;
color: var(--text-muted);
padding: 16px 20px;
text-align: left;
font-weight: 400;
white-space: nowrap;
}
td {
padding: 16px 20px;
border-bottom: 1px solid var(--border);
color: var(--text-dim);
vertical-align: middle;
}
tr {
transition: all 0.3s ease;
cursor: pointer;
}
tr:hover {
background: var(--bg-hover);
}
tr.unread {
background: rgba(0, 240, 255, 0.03);
}
tr.unread td:first-child {
border-left: 3px solid var(--accent);
}
.lead-name {
font-weight: 600;
color: var(--text);
font-size: 0.95rem;
margin-bottom: 4px;
}
.lead-email {
font-size: 0.8rem;
color: var(--text-muted);
font-family: 'Space Mono', monospace;
}
.lead-preview {
max-width: 300px;
white-space: nowrap;
overflow: hidden;
text-overflow: ellipsis;
font-size: 0.85rem;
}

/* Status Badge */
.status-badge {
display: inline-flex;
align-items: center;
gap: 6px;
padding: 6px 14px;
border-radius: 6px;
font-family: 'Space Mono', monospace;
font-size: 0.65rem;
letter-spacing: 1.5px;
text-transform: uppercase;
border: 1px solid;
transition: all 0.3s ease;
cursor: pointer;
position: relative;
}
.status-badge::before {
content: '';
width: 6px; height: 6px;
border-radius: 50%;
background: currentColor;
box-shadow: 0 0 8px currentColor;
}
.status-new { color: var(--accent); border-color: rgba(0,240,255,0.2); background: rgba(0,240,255,0.05); }
.status-contacted { color: var(--secondary); border-color: rgba(255,42,109,0.2); background: rgba(255,42,109,0.05); }
.status-qualified { color: #a855f7; border-color: rgba(168,85,247,0.2); background: rgba(168,85,247,0.05); }
.status-proposal { color: #f59e0b; border-color: rgba(245,158,11,0.2); background: rgba(245,158,11,0.05); }
.status-closed { color: #22c55e; border-color: rgba(34,197,94,0.2); background: rgba(34,197,94,0.05); }
.status-archived { color: var(--text-muted); border-color: rgba(96,96,128,0.2); background: rgba(96,96,128,0.05); }

.date-cell {
font-family: 'Space Mono', monospace;
font-size: 0.75rem;
color: var(--text-muted);
}
.actions-cell {
display: flex;
gap: 8px;
}
.icon-btn {
width: 32px; height: 32px;
border-radius: 6px;
border: 1px solid var(--border);
background: transparent;
color: var(--text-dim);
cursor: pointer;
display: flex;
align-items: center;
justify-content: center;
transition: all 0.3s ease;
}
.icon-btn:hover {
border-color: var(--accent);
color: var(--accent);
box-shadow: 0 0 15px var(--accent-glow);
}
.icon-btn.danger:hover {
border-color: var(--secondary);
color: var(--secondary);
box-shadow: 0 0 15px var(--secondary-glow);
}
.icon-btn svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; }

/* Checkbox */
.custom-checkbox {
width: 18px; height: 18px;
border: 1px solid var(--border);
border-radius: 4px;
background: var(--bg-card);
cursor: pointer;
display: flex;
align-items: center;
justify-content: center;
transition: all 0.3s ease;
}
.custom-checkbox:hover { border-color: var(--accent); }
.custom-checkbox.checked {
background: linear-gradient(135deg, var(--accent), var(--secondary));
border-color: transparent;
}
.custom-checkbox.checked::after {
content: '✓';
color: var(--bg);
font-size: 0.7rem;
font-weight: 700;
}

/* Empty State */
.empty-state {
text-align: center;
padding: 80px 20px;
color: var(--text-muted);
}
.empty-state svg {
width: 64px; height: 64px;
stroke: var(--border-light);
fill: none;
stroke-width: 1;
margin-bottom: 20px;
}
.empty-state h3 {
font-family: 'Syne', sans-serif;
font-size: 1.2rem;
color: var(--text-dim);
margin-bottom: 8px;
}

/* Pagination */
.pagination-wrap {
display: flex;
justify-content: space-between;
align-items: center;
padding: 20px;
border-top: 1px solid var(--border);
}
.pagination-info {
font-size: 0.8rem;
color: var(--text-muted);
}
.pagination-buttons {
display: flex;
gap: 8px;
}
.page-btn {
padding: 8px 14px;
border: 1px solid var(--border);
background: var(--bg-card);
color: var(--text-dim);
border-radius: 6px;
cursor: pointer;
font-family: 'Space Mono', monospace;
font-size: 0.75rem;
transition: all 0.3s ease;
}
.page-btn:hover:not(:disabled) {
border-color: var(--accent);
color: var(--accent);
}
.page-btn:disabled {
opacity: 0.4;
cursor: not-allowed;
}
.page-btn.active {
background: linear-gradient(135deg, var(--accent), var(--secondary));
color: var(--bg);
border-color: transparent;
font-weight: 700;
}

/* Modal */
.modal-overlay {
position: fixed;
inset: 0;
background: var(--overlay);
backdrop-filter: blur(20px);
z-index: 2000;
display: flex;
align-items: center;
justify-content: center;
opacity: 0;
visibility: hidden;
transition: opacity 0.4s ease, visibility 0.4s ease;
padding: 20px;
}
.modal-overlay.active {
opacity: 1;
visibility: visible;
}
.modal-box {
background: var(--bg-light);
border: 1px solid var(--border);
border-radius: 16px;
max-width: 600px;
width: 100%;
max-height: 85vh;
overflow-y: auto;
position: relative;
transform: translateY(30px) scale(0.95);
transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
box-shadow: 0 0 80px rgba(0, 240, 255, 0.05);
}
.modal-overlay.active .modal-box {
transform: translateY(0) scale(1);
}
.modal-header {
padding: 32px 32px 0;
display: flex;
justify-content: space-between;
align-items: flex-start;
}
.modal-title-group h2 {
font-family: 'Syne', sans-serif;
font-size: 1.5rem;
font-weight: 700;
letter-spacing: -1px;
margin-bottom: 4px;
}
.modal-sub {
font-size: 0.85rem;
color: var(--text-muted);
}
.modal-close {
width: 36px; height: 36px;
border: 1px solid var(--border);
background: transparent;
color: var(--text);
border-radius: 8px;
cursor: pointer;
display: flex;
align-items: center;
justify-content: center;
transition: all 0.3s ease;
font-size: 1.2rem;
}
.modal-close:hover {
background: linear-gradient(135deg, var(--accent), var(--secondary));
color: var(--bg);
border-color: transparent;
}
.modal-body {
padding: 24px 32px 32px;
}
.detail-row {
margin-bottom: 20px;
}
.detail-label {
font-family: 'Space Mono', monospace;
font-size: 0.6rem;
letter-spacing: 3px;
text-transform: uppercase;
color: var(--text-muted);
margin-bottom: 8px;
}
.detail-value {
color: var(--text);
font-size: 0.95rem;
line-height: 1.6;
}
.detail-value.description {
background: var(--bg-card);
border: 1px solid var(--border);
border-radius: 8px;
padding: 16px;
font-family: 'Playfair Display', serif;
font-size: 1rem;
line-height: 1.8;
color: var(--text-dim);
}
.detail-meta {
display: grid;
grid-template-columns: 1fr 1fr;
gap: 16px;
}
.detail-meta-box {
background: var(--bg-card);
border: 1px solid var(--border);
border-radius: 8px;
padding: 14px 16px;
}
.detail-meta-label {
font-family: 'Space Mono', monospace;
font-size: 0.55rem;
letter-spacing: 2px;
text-transform: uppercase;
color: var(--text-muted);
margin-bottom: 6px;
}
.detail-meta-value {
font-family: 'Space Mono', monospace;
font-size: 0.8rem;
color: var(--text-dim);
word-break: break-all;
}

/* Toast */
.toast-container {
position: fixed;
top: 24px;
right: 24px;
z-index: 3000;
display: flex;
flex-direction: column;
gap: 12px;
}
.toast {
background: var(--bg-card);
border: 1px solid var(--border);
border-radius: 10px;
padding: 16px 20px;
display: flex;
align-items: center;
gap: 12px;
box-shadow: 0 10px 40px rgba(0,0,0,0.4);
transform: translateX(120%);
transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
min-width: 280px;
}
.toast.show {
transform: translateX(0);
}
.toast-icon {
width: 32px; height: 32px;
border-radius: 8px;
display: flex;
align-items: center;
justify-content: center;
flex-shrink: 0;
}
.toast-success .toast-icon {
background: rgba(34, 197, 94, 0.1);
color: #22c55e;
}
.toast-error .toast-icon {
background: rgba(255, 42, 109, 0.1);
color: var(--secondary);
}
.toast-content strong {
display: block;
font-size: 0.9rem;
margin-bottom: 2px;
color: var(--text);
}
.toast-content span {
font-size: 0.8rem;
color: var(--text-muted);
}

/* Loading */
.loading-shimmer {
background: linear-gradient(90deg, var(--bg-card) 25%, var(--bg-hover) 50%, var(--bg-card) 75%);
background-size: 200% 100%;
animation: shimmer 1.5s infinite;
border-radius: 6px;
}
@keyframes shimmer {
0% { background-position: 200% 0; }
100% { background-position: -200% 0; }
}

/* Animations */
@keyframes fadeUp {
from { opacity: 0; transform: translateY(20px); }
to { opacity: 1; transform: translateY(0); }
}
.animate-in {
animation: fadeUp 0.6s ease forwards;
}
.delay-1 { animation-delay: 0.1s; opacity: 0; }
.delay-2 { animation-delay: 0.2s; opacity: 0; }
.delay-3 { animation-delay: 0.3s; opacity: 0; }
.delay-4 { animation-delay: 0.4s; opacity: 0; }

/* Responsive */
@media (max-width: 1024px) {
.sidebar { transform: translateX(-100%); transition: transform 0.3s ease; }
.sidebar.open { transform: translateX(0); }
.main { margin-left: 0; max-width: 100%; padding: 24px; }
.stats-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
.stats-grid { grid-template-columns: 1fr; }
.toolbar { flex-direction: column; align-items: stretch; }
.search-box { max-width: 100%; }
.table-wrap { overflow-x: auto; }
table { min-width: 800px; }
}

/* Status selector in modal */
.status-options {
display: flex;
gap: 8px;
flex-wrap: wrap;
}
.status-option {
padding: 8px 16px;
border: 1px solid var(--border);
border-radius: 6px;
background: var(--bg-card);
color: var(--text-dim);
cursor: pointer;
font-family: 'Space Mono', monospace;
font-size: 0.7rem;
letter-spacing: 1px;
text-transform: uppercase;
transition: all 0.3s ease;
}
.status-option:hover, .status-option.active {
border-color: currentColor;
background: rgba(255,255,255,0.03);
}
</style>
</head>
<body x-data="adminApp()" x-init="init()">

<div class="glow-orb orb-1"></div>
<div class="glow-orb orb-2"></div>
<div class="glow-orb orb-3"></div>
<div class="noise"></div>

<!-- Toast Container -->
<div class="toast-container">
<template x-for="toast in toasts" :key="toast.id">
<div class="toast" :class="'toast-' + toast.type" x-show="toast.show" x-transition:enter="show">
<div class="toast-icon">
<svg x-show="toast.type === 'success'" viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
<svg x-show="toast.type === 'error'" viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" fill="none" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
</div>
<div class="toast-content">
<strong x-text="toast.title"></strong>
<span x-text="toast.message"></span>
</div>
</div>
</template>
</div>

<div class="admin-shell">
<!-- Sidebar -->
<aside class="sidebar">
<div>
<div class="brand">DIMARZ</div>
<div class="brand-sub">Lead Command Center</div>

<nav>
<a href="#" class="nav-item active">
<svg class="nav-icon" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
Dashboard
</a>
<a href="{{ route('portfolio') }}" target="_blank" class="nav-item">
<svg class="nav-icon" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
View Portfolio
</a>
<a href="{{ route('admin.export') }}" class="nav-item">
<svg class="nav-icon" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
Export CSV
</a>
<a href="#" class="nav-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
<svg class="nav-icon" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
Logout
</a>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
</nav>
</div>

<div style="margin-top: auto; padding-top: 24px; border-top: 1px solid var(--border);">
<div style="font-family: 'Space Mono', monospace; font-size: 0.6rem; color: var(--text-muted); letter-spacing: 1px;">
<span x-text="currentTime"></span>
</div>
</div>
</aside>

<!-- Main -->
<main class="main">
<div class="topbar animate-in">
<h1 class="page-title">Lead Management</h1>
<div style="display: flex; gap: 20px; align-items: center;">
<div class="live-indicator">
<div class="live-dot"></div>
<span>LIVE SYSTEM</span>
</div>
<button onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="background: rgba(255, 42, 109, 0.1); border: 1px solid rgba(255, 42, 109, 0.3); color: #ff2a6d; padding: 8px 16px; border-radius: 6px; font-family: 'Space Mono', monospace; font-size: 0.7rem; cursor: pointer; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 1px; display: flex; align-items: center; gap: 8px;" onmouseover="this.style.background='rgba(255, 42, 109, 0.2)'; this.style.borderColor='#ff2a6d'; this.style.boxShadow='0 0 15px rgba(255, 42, 109, 0.3)'" onmouseout="this.style.background='rgba(255, 42, 109, 0.1)'; this.style.borderColor='rgba(255, 42, 109, 0.3)'; this.style.boxShadow='none'">
<svg viewBox="0 0 24 24" style="width: 14px; height: 14px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
Logout
</button>
</div>
</div>

<!-- Stats -->
<div class="stats-grid">
<div class="stat-card animate-in delay-1">
<div class="stat-label">Total Leads</div>
<div class="stat-value" x-text="animatedStats.total">0</div>
</div>
<div class="stat-card animate-in delay-2">
<div class="stat-label">New Today</div>
<div class="stat-value" x-text="animatedStats.new_today">0</div>
</div>
<div class="stat-card animate-in delay-3">
<div class="stat-label">Unread</div>
<div class="stat-value" x-text="animatedStats.unread">0</div>
</div>
<div class="stat-card animate-in delay-4">
<div class="stat-label">In Pipeline</div>
<div class="stat-value" x-text="animatedStats.conversion">0</div>
</div>
</div>

<!-- Toolbar -->
<div class="toolbar">
<div class="search-box">
<svg class="search-icon" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
<input 
type="text" 
placeholder="Search by name, email, or content..." 
x-model="search"
@input.debounce.300ms="fetchLeads()"
>
</div>

<select class="filter-select" x-model="statusFilter" @change="fetchLeads()">
<option value="all">All Status</option>
@foreach($statuses as $status)
<option value="{{ $status }}">{{ ucfirst($status) }}</option>
@endforeach
</select>

<template x-if="selectedIds.length > 0">
<button class="btn btn-danger" @click="bulkDelete()">
<svg width="14" height="14" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
Delete (<span x-text="selectedIds.length"></span>)
</button>
</template>
</div>

<!-- Table -->
<div class="table-wrap">
<table>
<thead>
<tr>
<th style="width: 40px;">
<div class="custom-checkbox" :class="{ 'checked': allSelected }" @click="toggleAll()"></div>
</th>
<th>Lead</th>
<th>Preview</th>
<th>Status</th>
<th>Date</th>
<th style="width: 100px;">Actions</th>
</tr>
</thead>
<tbody>
<template x-if="loading">
<tr><td colspan="6" style="padding: 40px;">
<div style="display: flex; gap: 12px; flex-direction: column;">
<div class="loading-shimmer" style="height: 20px; width: 100%;"></div>
<div class="loading-shimmer" style="height: 20px; width: 80%;"></div>
<div class="loading-shimmer" style="height: 20px; width: 60%;"></div>
</div>
</td></tr>
</template>

<template x-if="!loading && leads.length === 0">
<tr><td colspan="6">
<div class="empty-state">
<svg viewBox="0 0 24 24"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
<h3>No leads found</h3>
<p>When clients submit your portfolio form, they will appear here.</p>
</div>
</td></tr>
</template>

<template x-for="lead in leads" :key="lead.id">
<tr :class="{ 'unread': !lead.read_at }" @click="viewLead(lead.id)">
<td @click.stop>
<div class="custom-checkbox" 
:class="{ 'checked': selectedIds.includes(lead.id) }" 
@click="toggleSelect(lead.id)">
</div>
</td>
<td>
<div class="lead-name" x-text="lead.name"></div>
<div class="lead-email" x-text="lead.email"></div>
</td>
<td>
<div class="lead-preview" x-text="lead.description"></div>
</td>
<td @click.stop>
<div class="status-badge" :class="'status-' + lead.status" @click="openStatusModal(lead)">
<span x-text="lead.status"></span>
</div>
</td>
<td>
<div class="date-cell" x-text="formatDate(lead.created_at)"></div>
</td>
<td>
<div class="actions-cell" @click.stop>
<button class="icon-btn" @click="viewLead(lead.id)" title="View">
<svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
</button>
<button class="icon-btn danger" @click="deleteLead(lead.id)" title="Delete">
<svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
</button>
</div>
</td>
</tr>
</template>
</tbody>
</table>

<!-- Pagination -->
<div class="pagination-wrap" x-show="pagination.last_page > 1">
<div class="pagination-info">
Showing <span x-text="((pagination.current_page - 1) * pagination.per_page) + 1"></span> - 
<span x-text="Math.min(pagination.current_page * pagination.per_page, pagination.total)"></span> of 
<span x-text="pagination.total"></span> leads
</div>
<div class="pagination-buttons">
<button class="page-btn" :disabled="pagination.current_page === 1" @click="goToPage(pagination.current_page - 1)">Prev</button>
<template x-for="page in pageNumbers" :key="page">
<button class="page-btn" :class="{ 'active': page === pagination.current_page }" @click="goToPage(page)" x-text="page"></button>
</template>
<button class="page-btn" :disabled="pagination.current_page === pagination.last_page" @click="goToPage(pagination.current_page + 1)">Next</button>
</div>
</div>
</div>
</main>
</div>

<!-- Detail Modal -->
<div class="modal-overlay" :class="{ 'active': detailModal }" @click.self="detailModal = null">
<div class="modal-box" x-show="detailModal" x-transition.opacity.duration.300ms>
<template x-if="detailModal">
<div>
<div class="modal-header">
<div class="modal-title-group">
<h2 x-text="detailModal.name"></h2>
<div class="modal-sub" x-text="detailModal.email"></div>
</div>
<button class="modal-close" @click="detailModal = null">&times;</button>
</div>
<div class="modal-body">
<div class="detail-row">
<div class="detail-label">Project Request</div>
<div class="detail-value description" x-text="detailModal.description"></div>
</div>

<div class="detail-meta">
<div class="detail-meta-box">
<div class="detail-meta-label">Status</div>
<div class="status-badge" :class="'status-' + detailModal.status" style="margin-top: 4px;">
<span x-text="detailModal.status"></span>
</div>
</div>
<div class="detail-meta-box">
<div class="detail-meta-label">Submitted</div>
<div class="detail-meta-value" x-text="formatDate(detailModal.created_at)"></div>
</div>
<div class="detail-meta-box">
<div class="detail-meta-label">IP Address</div>
<div class="detail-meta-value" x-text="detailModal.ip_address || 'N/A'"></div>
</div>
<div class="detail-meta-box">
<div class="detail-meta-label">Lead ID</div>
<div class="detail-meta-value" x-text="'#' + detailModal.id"></div>
</div>
</div>

<div style="margin-top: 24px;">
<div class="detail-label">Update Status</div>
<div class="status-options">
<template x-for="status in ['new','contacted','qualified','proposal','closed','archived']" :key="status">
<div class="status-option" 
:class="{ 'active': detailModal.status === status }"
:style="detailModal.status === status ? 'color: ' + getStatusColor(status) + '; border-color: ' + getStatusColor(status) : ''"
@click="updateStatus(detailModal.id, status)"
x-text="status">
</div>
</template>
</div>
</div>

<div style="margin-top: 24px; display: flex; gap: 12px;">
<a :href="'mailto:' + detailModal.email" class="btn btn-primary" style="flex: 1; justify-content: center;">
Reply via Email
</a>
<button class="btn btn-danger" style="flex: 1; justify-content: center;" @click="deleteLead(detailModal.id); detailModal = null;">
Delete Lead
</button>
</div>
</div>
</div>
</template>
</div>
</div>

<!-- Status Quick Change Modal -->
<div class="modal-overlay" :class="{ 'active': statusModal }" @click.self="statusModal = null">
<div class="modal-box" style="max-width: 400px;" x-show="statusModal" x-transition.opacity.duration.300ms>
<div class="modal-header">
<div class="modal-title-group">
<h2>Update Status</h2>
<div class="modal-sub" x-text="statusModal?.name"></div>
</div>
<button class="modal-close" @click="statusModal = null">&times;</button>
</div>
<div class="modal-body">
<div class="status-options" style="margin-bottom: 20px;">
<template x-for="status in ['new','contacted','qualified','proposal','closed','archived']" :key="status">
<div class="status-option" 
:class="{ 'active': statusModal?.status === status }"
:style="statusModal?.status === status ? 'color: ' + getStatusColor(status) + '; border-color: ' + getStatusColor(status) : ''"
@click="updateStatus(statusModal.id, status); statusModal = null;"
x-text="status">
</div>
</template>
</div>
</div>
</div>
</div>

<script>
function adminApp() {
return {
leads: [],
loading: true,
search: '',
statusFilter: 'all',
selectedIds: [],
detailModal: null,
statusModal: null,
pagination: { current_page: 1, last_page: 1, per_page: 15, total: 0 },
stats: @json($stats),
animatedStats: { total: 0, new_today: 0, unread: 0, conversion: 0 },
toasts: [],
currentTime: '',

init() {
this.fetchLeads();
this.animateCounters();
this.updateTime();
setInterval(() => this.updateTime(), 1000);

// Auto refresh every 30 seconds
setInterval(() => this.fetchLeads(false), 30000);
},

updateTime() {
const now = new Date();
this.currentTime = now.toLocaleTimeString('en-US', { 
hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true 
}) + ' UTC';
},

animateCounters() {
const duration = 1500;
const steps = 60;
const interval = duration / steps;

Object.keys(this.stats).forEach(key => {
let current = 0;
const target = this.stats[key];
const increment = target / steps;

const timer = setInterval(() => {
current += increment;
if (current >= target) {
current = target;
clearInterval(timer);
}
this.animatedStats[key] = Math.floor(current);
}, interval);
});
},

async fetchLeads(showLoading = true) {
if (showLoading) this.loading = true;

try {
const params = new URLSearchParams({
page: this.pagination.current_page,
search: this.search,
status: this.statusFilter
});

const response = await fetch(`{{ route('admin.leads') }}?${params}`, {
headers: { 'X-Requested-With': 'XMLHttpRequest' }
});

const data = await response.json();
this.leads = data.data;
this.pagination = {
current_page: data.current_page,
last_page: data.last_page,
per_page: data.per_page,
total: data.total
};
} catch (error) {
this.showToast('Error', 'Failed to load leads', 'error');
} finally {
if (showLoading) this.loading = false;
}
},

get pageNumbers() {
const pages = [];
const max = this.pagination.last_page;
const current = this.pagination.current_page;

for (let i = 1; i <= max; i++) {
if (i === 1 || i === max || (i >= current - 1 && i <= current + 1)) {
pages.push(i);
} else if (i === current - 2 || i === current + 2) {
pages.push('...');
}
}
return [...new Set(pages)];
},

goToPage(page) {
if (page === '...') return;
this.pagination.current_page = page;
this.fetchLeads();
window.scrollTo({ top: 0, behavior: 'smooth' });
},

async viewLead(id) {
try {
const response = await fetch(`{{ url('admin/leads') }}/${id}`, {
headers: { 'X-Requested-With': 'XMLHttpRequest' }
});
this.detailModal = await response.json();
} catch (error) {
this.showToast('Error', 'Failed to load lead details', 'error');
}
},

openStatusModal(lead) {
this.statusModal = lead;
},

get allSelected() {
return this.leads.length > 0 && this.leads.every(l => this.selectedIds.includes(l.id));
},

toggleAll() {
if (this.allSelected) {
this.selectedIds = [];
} else {
this.selectedIds = this.leads.map(l => l.id);
}
},

toggleSelect(id) {
const index = this.selectedIds.indexOf(id);
if (index > -1) {
this.selectedIds.splice(index, 1);
} else {
this.selectedIds.push(id);
}
},

async updateStatus(id, status) {
try {
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const response = await fetch(`{{ url('admin/leads') }}/${id}/status`, {
method: 'PATCH',
headers: {
'Content-Type': 'application/json',
'X-CSRF-TOKEN': token,
'X-Requested-With': 'XMLHttpRequest'
},
body: JSON.stringify({ status })
});

const data = await response.json();

// Update local data
const lead = this.leads.find(l => l.id === id);
if (lead) lead.status = status;
if (this.detailModal && this.detailModal.id === id) {
this.detailModal.status = status;
}

this.showToast('Updated', `Status changed to ${status}`, 'success');
} catch (error) {
this.showToast('Error', 'Failed to update status', 'error');
}
},

async deleteLead(id) {
if (!confirm('Are you sure you want to delete this lead?')) return;

try {
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
await fetch(`{{ url('admin/leads') }}/${id}`, {
method: 'DELETE',
headers: {
'X-CSRF-TOKEN': token,
'X-Requested-With': 'XMLHttpRequest'
}
});

this.leads = this.leads.filter(l => l.id !== id);
this.selectedIds = this.selectedIds.filter(sid => sid !== id);
this.showToast('Deleted', 'Lead removed successfully', 'success');
} catch (error) {
this.showToast('Error', 'Failed to delete lead', 'error');
}
},

async bulkDelete() {
if (!confirm(`Delete ${this.selectedIds.length} selected leads?`)) return;

try {
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
await fetch(`{{ route('admin.leads.bulk') }}`, {
method: 'POST',
headers: {
'Content-Type': 'application/json',
'X-CSRF-TOKEN': token,
'X-Requested-With': 'XMLHttpRequest'
},
body: JSON.stringify({ ids: this.selectedIds })
});

this.leads = this.leads.filter(l => !this.selectedIds.includes(l.id));
this.showToast('Deleted', `${this.selectedIds.length} leads removed`, 'success');
this.selectedIds = [];
} catch (error) {
this.showToast('Error', 'Bulk delete failed', 'error');
}
},

getStatusColor(status) {
const colors = {
new: '#00f0ff',
contacted: '#ff2a6d',
qualified: '#a855f7',
proposal: '#f59e0b',
closed: '#22c55e',
archived: '#606080'
};
return colors[status] || '#9090b0';
},

formatDate(dateString) {
const date = new Date(dateString);
return date.toLocaleDateString('en-US', { 
month: 'short', day: 'numeric', year: 'numeric' 
}) + ' ' + date.toLocaleTimeString('en-US', { 
hour: '2-digit', minute: '2-digit' 
});
},

showToast(title, message, type = 'success') {
const id = Date.now();
const toast = { id, title, message, type, show: false };
this.toasts.push(toast);

setTimeout(() => toast.show = true, 10);
setTimeout(() => {
toast.show = false;
setTimeout(() => {
this.toasts = this.toasts.filter(t => t.id !== id);
}, 400);
}, 3000);
}
}
}
</script>
</body>
</html>

Run these commands in order after copying the files:
bash
Copy
# 1. Run the migration
php artisan migrate

# 2. Create storage link (if not done)
php artisan storage:link

# 3. Your admin panel is instantly live at:
# http://your-site.com/admin

Table
Feature
Effect
Same Neon Theme
Identical --accent: #00f0ff and --secondary: #ff2a6d from your portfolio
Glassmorphism Stats
Cards float with backdrop-blur and gradient top borders
Animated Counters
Numbers count up from 0 on page load
Live Indicator
Pulsing cyan dot shows the system is active
Real-Time Search
Alpine.js debounced search with instant filtering
Unread Highlighting
New submissions glow with a cyan left border until opened
Status Glow Badges
Each status has its own neon color with matching box-shadow
Detail Modal
Opens with the exact same modal animation as your portfolio
Inline Status Change
Click any badge to change status without leaving the page
Bulk Actions
Select multiple leads and delete them together
Toast Notifications
Slide-in alerts instead of ugly browser alerts
Auto-Refresh
Silently fetches new leads every 30 seconds
Export Ready
One-click CSV download of all data
Loading Shimmers
Skeleton screens while data loads
Keyboard/Click Away
Press Escape or click outside to close modals
The admin panel feels like a cyberpunk command center that perfectly matches your frontend aesthetic. Every lead that comes in from your portfolio form will appear here instantly with a "new" glow, ready for you to qualify, contact, and close.



