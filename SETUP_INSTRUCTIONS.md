# How to Run Student System on Web (Windows)

## Option 1: Using XAMPP (Recommended - Easiest)

### Step 1: Install XAMPP
1. Download XAMPP from https://www.apachefriends.org/
2. Install it (usually to `C:\xampp`)

### Step 2: Start XAMPP Services
1. Open **XAMPP Control Panel**
2. Start **Apache** (click "Start" button)
3. Start **MySQL** (click "Start" button)

### Step 3: Set Up Database
1. Open your web browser and go to: `http://localhost/phpmyadmin`
2. Click on "New" to create a new database
3. Name it: `student_db`
4. Click "Import" tab
5. Click "Choose File" and select `student_db.sql` from your project folder
6. Click "Go" to import

### Step 4: Update Database Connection (if needed)
If your MySQL password is different, edit `php/connection.php`:
- Update `$db_password` with your MySQL password (default XAMPP password is usually empty `""`)

### Step 5: Copy Project to XAMPP
1. Copy your entire `student-system` folder to: `C:\xampp\htdocs\`
2. Or create a symbolic link to your project folder

### Step 6: Access Your Application
Open your web browser and go to:
```
http://localhost/student-system/
```
or
```
http://localhost/student-system/index.php
```

---

## Option 2: Using PHP Built-in Server (Requires MySQL separately)

### Prerequisites
1. Install PHP from https://windows.php.net/download/
2. Install MySQL separately from https://dev.mysql.com/downloads/

### Step 1: Set Up Database
1. Open MySQL command line or MySQL Workbench
2. Create database: `CREATE DATABASE student_db;`
3. Import `student_db.sql` file

### Step 2: Update Database Connection
Edit `php/connection.php` with your MySQL credentials

### Step 3: Start PHP Server
Open PowerShell in your project folder and run:
```powershell
php -S localhost:8000
```

### Step 4: Access Your Application
Open your web browser and go to:
```
http://localhost:8000
```

---

## Option 3: Using WAMP Server

1. Download and install WAMP from https://www.wampserver.com/
2. Start WAMP services (Apache and MySQL)
3. Copy project to `C:\wamp64\www\student-system\`
4. Set up database in phpMyAdmin (same as XAMPP steps)
5. Access at: `http://localhost/student-system/`

---

## Troubleshooting

### Database Connection Error
- Check if MySQL is running in XAMPP/WAMP
- Verify database name is `student_db`
- Check username/password in `php/connection.php`
- Default XAMPP MySQL username: `root`, password: (empty)

### Port Already in Use
- XAMPP uses port 80 for Apache and 3306 for MySQL
- If port 80 is busy, change Apache port in XAMPP Control Panel → Config → Apache (httpd.conf)
- Change `Listen 80` to `Listen 8080`, then access at `http://localhost:8080/student-system/`

### Permission Errors
- Make sure you have write permissions in the project folder
- On Windows, run XAMPP Control Panel as Administrator if needed

---

## Quick Start (XAMPP)
1. Install XAMPP
2. Start Apache and MySQL in XAMPP Control Panel
3. Copy project to `C:\xampp\htdocs\student-system\`
4. Create database `student_db` in phpMyAdmin and import `student_db.sql`
5. Open browser: `http://localhost/student-system/`
