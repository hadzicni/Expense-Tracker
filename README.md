# 💰 Expense Tracker

A simple and lightweight PHP web app to track your expenses efficiently. Built with PHP, SQLite, and powered by [`vlucas/phpdotenv`](https://github.com/vlucas/phpdotenv) for environment management. Clean UI and minimal dependencies.

![PHP Version](https://img.shields.io/badge/PHP-8.0%2B-blue)
![License](https://img.shields.io/badge/license-Apache--2.0-blue)
![Platform](https://img.shields.io/badge/platform-web-lightgrey)

---

## ✨ Features

- 📝 Add and delete transactions with title, amount, and category
- 📅 View transactions sorted by date
- 💾 SQLite for simple file-based persistence
- 🔒 Environment configuration via `.env`
- 🎨 Responsive and clean UI for desktop and mobile

---

## 🚀 Getting Started

### ⚡ Requirements

- PHP 8.0 or newer
- Composer
- SQLite (included in PHP by default)

### 📦 Install dependencies

```bash
composer install
```

### 🧪 Run development server

```bash
php -S localhost:8000 -t public
```

**Open [http://localhost:8000](http://localhost:8000) in your browser.**

---

## ⚙️ Configuration

Copy `.env.example` to `.env` and edit if needed.

```env
DB_PATH=data/database.sqlite
```

---

## 📋 Usage

- Fill out the form to add a new expense
- Click Delete next to a transaction to remove it (confirmation required)
- View the total amount of all expenses

---

## 👨‍💻 Author

Made by **Nikola Hadzic**  
GitHub: [@hadzicni](https://github.com/hadzicni)

---

## 📄 License

This project is licensed under the Apache License 2.0. See the [LICENSE](./LICENSE) file for details.
