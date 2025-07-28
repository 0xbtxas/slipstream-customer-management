# 🧩 Customer & Contact Management – Fullstack App

A **fullstack application** built with **Laravel 11 (API)** and **Vue 3 (frontend)**, styled with **Tailwind CSS** and bundled with **Vite**. The system manages customers, their categories, and related contacts in a modern SPA experience.

---

## ⚙️ Tech Stack

| Layer       | Technology                     |
|-------------|--------------------------------|
| Backend     | Laravel 11, MySQL, Eloquent ORM |
| Frontend    | Vue 3 (Composition API)         |
| Styling     | Tailwind CSS                   |
| Build Tool  | Vite (Laravel-integrated)      |
| Testing     | PHPUnit (Backend)             |

---

## 🚀 Features

- Fullstack CRUD for **Customers** and **Contacts**
- Vue 3 SPA architecture with dynamic routing
- Search, filter by category, and paginate customers
- REST API powered by Laravel + Eloquent Resources
- Responsive UI with Tailwind utility classes
- Typed service layer and validation via Form Requests
- Hot Module Reloading (HMR) via Vite for frontend

---
## 🚧 Prerequisites

Ensure the following tools are installed on your machine:

### Backend (Laravel)
- PHP 8.2+
- Composer 2.x
- MySQL or MariaDB
- Node.js 20+ (for Vite assets)

### Frontend (Vue 3)
- Node.js 20+ (or latest LTS)
- npm or Yarn
- Vite (installed via npm)
- Tailwind CSS (already configured)

---
## 🧰 Setup Instructions

### 🔧 1. Backend (Laravel)

```bash
git clone https://github.com/0xbtxas/slipstream-customer-management.git
cd slipstream-customer-management

composer install

cp .env.example .env
php artisan key:generate

php artisan migrate --seed
```

### 🌐 2. Frontend (Vue + Tailwind + Vite)

```bash
npm install

npm run dev      # for local development
npm run build    # for production
```

> Vite is already integrated with Laravel via `vite.config.js`. Entry point: `resources/js/app.ts`.

---

## 🖥️ Usage

```bash
php artisan serve

npm run dev
```

Navigate to `http://localhost:8000` for the app UI.

---

## 🧪 Testing

```bash
php artisan test
```

> Frontend unit/E2E testing support can be added via Vitest or Cypress.

---

## 🔌 API Overview

### Customers

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET    | `/api/customers` | List customers with search, category_id filter |
| GET    | `/api/customers/{id}` | Show single customer with contacts |
| POST   | `/api/customers` | Create a new customer |
| PUT    | `/api/customers/{id}` | Update customer |
| DELETE | `/api/customers/{id}` | Delete customer |

### Contacts

| Method | Endpoint |
|--------|----------|
| GET    | `/api/customers/{id}/contacts` |
| GET    | `/api/customers/{id}/contacts/{contactId}` |
| POST   | `/api/customers/{id}/contacts` |
| PUT    | `/api/customers/{id}/contacts/{contactId}` |
| DELETE | `/api/customers/{id}/contacts/{contactId}` |

---

## 🎨 Styling & UI

- Tailwind is configured via `tailwind.config.js`
- Uses utility-first responsive design
- Example classes:
  ```html
  <div class="bg-white shadow rounded p-4 hover:bg-gray-50">
      <h2 class="text-xl font-semibold">Customer Name</h2>
  </div>
  ```

---

## 🧠 Future Enhancements

- Auth system (Sanctum/JWT)
- Role-based access control (RBAC)
- Vuex/Pinia for state management
- Full E2E test suite with Cypress
