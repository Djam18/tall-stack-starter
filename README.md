# TALL Stack Starter

**T**ailwind + **A**lpine.js + **L**ivewire + **L**aravel

A production-ready starter kit built after 3 months of learning the TALL stack.
Everything I wish existed when I started coming from React.

## Stack

| Layer | Technology | Version |
|-------|-----------|---------|
| Backend | Laravel | 9.x |
| Full-stack components | Livewire | 2.10 |
| Interactivity | Alpine.js | 3.10 |
| Styling | Tailwind CSS | 3.1 |
| Auth scaffolding | Laravel Breeze | 1.13 |
| Testing | Pest | 1.21 |
| Build tool | Vite | 3.x |

## Features

- Auth (login, register, password reset) via Breeze
- Responsive sidebar layout with Alpine.js mobile toggle
- Dark mode (Tailwind `darkMode: 'class'` + Alpine.js + localStorage)
- Full CRUD with Livewire (search, sort, paginate, bulk actions)
- Reusable Blade components (button, badge, card, modal)
- Livewire flash notification system
- Pest tests for all Livewire components

## Quick Start

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run dev
php artisan serve
```

## Why TALL?

Coming from React + REST API, I was building the same features repeatedly:
- Client state management (Redux / Zustand)
- Data fetching layer (React Query / SWR)
- Form validation (react-hook-form + yup)
- Loading/error states
- Optimistic updates

With TALL, the server owns the state. Livewire handles server-client sync.
Alpine handles pure UI state. The result: dramatically less code for CRUD apps.

## Folder Structure

```
app/
  Http/
    Livewire/          — Livewire PHP components
  Models/              — Eloquent models
resources/
  views/
    layouts/           — app.blade.php (sidebar layout)
    livewire/          — Livewire Blade views
    components/        — Reusable Blade components
```
