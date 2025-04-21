# 🏥 Hospital Appointment System - Deployment Guide

This guide explains how to set up and run the Hospital Appointment Management System locally using **XAMPP** and **phpMyAdmin**.

---

## ✅ Requirements

- [XAMPP](https://www.apachefriends.org/index.html) (Ensure Apache and MySQL are enabled)
- A web browser
- Project source code (Download as ZIP file)
- The MySQL database file (`hospital_db.sql`)

---

## 🚀 Deployment Steps

### 1. Copy Project Files to XAMPP
- Place the entire project folder inside:
  ```
  C:\xampp\htdocs\
  ```
  So the final link is:
  ```
  C:\xampp\htdocs\Hospital-mgmt-system\
  ```

### 2. Start Apache and MySQL
- Open the XAMPP Control Panel
- Click **Start** next to **Apache** and **MySQL**

### 3. Import the Database
- Open your browser and go to:
  ```
  http://localhost/phpmyadmin
  ```
- Click **New** on the sidebar and create a new database:
  ```
  Name: hospital_db
  Collation: utf8_general_ci
  ```
- Click **Create**
- Now select the `hospital_db` database from the sidebar
- Go to the **Import** tab at the top
- Click **Choose File** and select the `hospital_db.sql` file from your project
- Click **Go** to import the tables

### 4. Configure and Run the Project
- Visit the project in your browser:
  ```
  http://localhost/Hospital-mgmt-system/
  ```

- You can now:
  - Register patients and doctors
  - Book and manage appointments
  - Use the admin panel to approve doctors

---

## 🛠 Notes

- The database connection is configured in `db.php`. Make sure these values match your XAMPP setup:
  ```php
  $conn = new mysqli("localhost", "root", "", "hospital_db");
  ```

- Default MySQL user: `root`
- Default password: *(empty)*

---