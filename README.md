# Samiur Rahman — Dimarz Portfolio (Laravel)

A professional, high-performance portfolio website built with **Laravel 11**, featuring a stunning dark cyberpunk aesthetic with AI-powered B2B Lead Generation content. Originally extracted from `All Code my portfolio.odt` and converted into a fully functional, professional Laravel project.

---

## 📁 Project Structure

```
My portfolio larabel/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── PortfolioController.php   ← Handles homepage & contact form
│   └── Providers/
│       └── AppServiceProvider.php
├── public/
│   ├── css/
│   │   └── portfolio.css                 ← All styles (dark theme, animations, responsive)
│   └── js/
│       └── portfolio.js                  ← Modal system, form AJAX, parallax, glitch effects
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── portfolio.blade.php       ← Master layout (fonts, orbs, CSRF meta)
│       └── portfolio.blade.php           ← Hero section, modals, services
├── routes/
│   └── web.php                           ← GET / and POST /contact routes
├── .env                                  ← Environment config (auto-generated)
├── artisan                               ← Laravel CLI
├── composer.json                         ← PHP dependencies
├── start.sh                              ← One-command start script
└── All Code my portfolio.odt             ← Original source document (preserved)
```

---

## 🚀 Quick Start

### Requirements
- PHP 8.2+
- Composer 2+

### Run Locally

```bash
# Start the development server
bash start.sh
```

Or manually:

```bash
php artisan serve
```

Then open: **http://127.0.0.1:8000**

---

## 🗂️ Key Files Explained

| File | Purpose |
|------|---------|
| `routes/web.php` | Defines `GET /` (portfolio page) and `POST /contact` (form submission) |
| `app/Http/Controllers/PortfolioController.php` | `index()` renders the view; `submitContact()` validates & responds |
| `resources/views/layouts/portfolio.blade.php` | HTML shell — Google Fonts, CSRF meta, glow orbs, CSS/JS includes |
| `resources/views/portfolio.blade.php` | Hero section, contact modal, services modal (3 services) |
| `public/css/portfolio.css` | Full stylesheet — CSS vars, animations, 5 responsive breakpoints |
| `public/js/portfolio.js` | Modal open/close, AJAX form submit, parallax, glitch image effect |

---

## ✨ Features

- **Dark Cyberpunk Design** — Neon cyan/magenta gradients, glow orbs, noise overlay
- **Animated Marquee** — Scrolling DIMARZ / LEADS / AI / B2B ticker
- **Contact Modal** — AJAX form with CSRF protection, real Laravel validation
- **Services Modal** — 3 detailed service cards (B2B Leads, Data Entry, Web Dev)
- **Parallax Effect** — Hero image moves subtly with mouse
- **Glitch Effect** — Hero image glitches on hover
- **Fully Responsive** — 5 breakpoints (1280px, 1100px, 900px, 640px, 380px)
- **Stats Bar** — 98% Accuracy, 5,000+ Leads, &lt;24h Delivery, 12+ Industries, 15+ Data Points
- **Corner Decorations** — Sci-fi corner frame elements

---

## 📧 Adding Email Notifications

In `app/Http/Controllers/PortfolioController.php`, replace the TODO comment with:

```php
use Illuminate\Support\Facades\Mail;

Mail::raw($validated['description'], function($msg) use ($validated) {
    $msg->to('your@email.com')
        ->from($validated['email'], $validated['name'])
        ->subject('New Portfolio Inquiry from ' . $validated['name']);
});
```

---

## 🛠️ Artisan Commands

```bash
php artisan route:list      # Show all registered routes
php artisan cache:clear     # Clear application cache
php artisan view:clear      # Clear compiled blade templates
php artisan config:clear    # Clear config cache
php artisan serve           # Start dev server on :8000
```

---

*Built by Samiur Rahman — Top Rated Freelancer on Upwork*
