# 2ca-todo: Full Stack To-Do List (Vue.js + Laravel + JWT + Pusher)

A modern, real-time, full-stack To-Do List application built with:

- **Backend:** Laravel (PostgreSQL/MySQL), JWT Auth, SOLID, Service & Repository Patterns
- **Frontend:** Vue.js, Pinia, shadcn UI, Axios, Laravel Echo, Pusher-js
- **Features:** Secure authentication, CRUD tasks, real-time notifications

---

## 🚀 Features

- **User Authentication (JWT)**

  - Register with full name, email, phone, address, password
  - Login with JWT (token in HttpOnly cookie)
  - Protected API routes (`/api/tasks/*`)
  - Each user sees only their own tasks

- **Task Management (CRUD)**

  - List, view, create, update, delete tasks

- **Real-Time Notifications**

  - Receive notification when a task is created (via Pusher & Laravel Echo)
  - Dedicated notifications page

- **Best Practices**
  - SOLID principles
  - Service & Repository patterns
  - Well-documented code

---

## 🛠️ Tech Stack

- **Backend:** Laravel 10+, JWT Auth, Pusher, PostgreSQL
- **Frontend:** Vue 3, Pinia, shadcn UI, Axios, Laravel Echo, Pusher-js

---

## ⚡ Quick Start

### 1. **Clone the Repository**

```sh
git clone https://github.com/MouhsineNejmi/2ca-project
cd 2ca-todo
```

---

### 2. **Backend Setup (Laravel)**

```sh
cd backend
cp .env.example .env
# Set your DB and Pusher credentials in .env
composer install
php artisan key:generate
php artisan migrate
php artisan serve
```

- **.env**:
  - Set `DB_*` for your database
  - Set `BROADCAST_DRIVER=pusher` and your Pusher keys

---

### 3. **Frontend Setup (Vue.js)**

```sh
cd ../frontend
cp .env.example .env
# Set VITE_API_URL to your backend API (e.g., http://localhost:8000/api)
npm install
npm run dev
```

---

### 4. **Pusher Setup**

- Create a free account at [pusher.com](https://pusher.com/)
- Create a Channels app and copy your keys to both backend `.env` and frontend `echo` config

---

### 5. **Usage**

- Register a new user
- Login
- Create, edit, delete tasks
- Open the Notifications page to see real-time task creation notifications

---

## 📋 API Endpoints

| Method | Endpoint           | Description                    |
| ------ | ------------------ | ------------------------------ |
| POST   | /api/auth/register | Register a new user            |
| POST   | /api/auth/login    | Login and receive JWT          |
| GET    | /api/tasks         | List user's tasks              |
| GET    | /api/tasks/:id     | Get a single task (user's own) |
| POST   | /api/tasks         | Create a new task              |
| PUT    | /api/tasks/:id     | Update a task                  |
| DELETE | /api/tasks/:id     | Delete a task                  |

---

## 📡 Real-Time Notifications

- After creating a task, a notification is broadcast via Pusher.
- The frontend listens using Laravel Echo and displays notifications in real time.

---

## 🧑‍💻 Project Structure

```
2ca-todo/
  backend/    # Laravel API
  frontend/   # Vue 3 SPA
```

- **Backend:**

  - `app/Services/` and `app/Repositories/` for SOLID, clean code
  - Events, broadcasting, and JWT auth

- **Frontend:**
  - Pinia for state management
  - shadcn UI for modern interface
  - Echo + Pusher for real-time

---

## 🛡️ Security

- JWT stored in HttpOnly cookie (not localStorage)
- All task routes protected by `auth:api` middleware
- Users can only access their own tasks

---

## 📝 Best Practices

- SOLID principles in backend
- Service and Repository patterns
- Code is commented and organized

---

## 🧪 Testing

- Use Postman or curl to test API endpoints
- Use the app UI to test real-time notifications
