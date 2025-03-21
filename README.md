# Employee Management Web Portal

A mini web portal designed for managing employee records with two user roles, department management with hierarchical structure, and an integrated real-time chat system.

## ✨ Features

### 🔐 Authentication
- **Login / Logout** functionality for users.
- Two User Roles:
  - **Employee**: Can update personal profile data and profile picture.
  - **Administrator**: Has full access to manage departments and employee records.

### 🧑‍💼 Employee Management
- Admin can **Create, View (Paginated DataTable), Update, and Delete Employees**.
- Employee listing:
  - Displays 10 records per page.
  - Implements **server-side pagination**, **sorting**, and **filtering**.

### 🏢 Department Management
- Admin can **Create, Update, and Delete Departments**.
- Departments are displayed as a **hierarchical tree** (unlimited levels).
- Clicking a department node filters employees shown in the DataTable.

### 💬 Chat System
- Users can send and receive messages **without page refresh**.
- Real-time communication using **AJAX** or **WebSockets**.
- Messages persist and are displayed per user.

---

## 🛠 Tech Stack

### Front-End
- **HTML**
- **Bootstrap**
- **jQuery**
  - **DataTables** for grids and employee listing

### Back-End
- **PHP** (Recommended Framework: Laravel or CodeIgniter)
- **MySQL** (via MariaDB)

---

## 🔧 Tools & Setup

###  Prerequisites
Ensure you have the following installed:

- **[XAMPP](https://www.apachefriends.org/index.html)**  
  All-in-one solution for Apache, PHP, and MariaDB.
- **[VS Code](https://code.visualstudio.com/)**  
  Recommended IDE for code editing.
- **[HeidiSQL](https://www.heidisql.com/)**  
  Lightweight SQL client for managing MariaDB/MySQL databases.

---

## 🚀 Getting Started

1. **Clone the Repository**
   ```bash
   git clone https://github.com/zikomuca25/PhpProject.git
