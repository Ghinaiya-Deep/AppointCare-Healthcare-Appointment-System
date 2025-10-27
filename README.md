# 🩺 AppointCare — Healthcare Appointment  System

## 📘 Overview

**AppointCare** is a full-stack hospital appointment  system built using **PHP, MySQL, HTML5, CSS3, and XAMPP**.
It provides two interfaces — one for **Patients** to book/cancel appointments and submit feedback, and another for **Admins** to manage doctors, departments, and appointments.

The project is **fully responsive**, follows **semantic HTML5 standards**, includes **form validation**, **hover effects**, and **email notifications** via **PHPMailer**.

---

## 🚀 Key Features

### 🧑‍⚕️ Patient Panel

* Book new appointments by selecting department & doctor.
* Cancel appointments using reference ID or email (no reschedule).
* Submit feedback directly to the hospital.
* Receive email confirmation for booking and cancellation via **PHPMailer**.
* Fully responsive layout with semantic structure and hover effects.

### 🛠️ Admin Dashboard

* Secure Admin login/logout system.
* Manage departments, doctors, and patients.
* View and manage appointments.
* Access and review patient feedback.
* Simple, intuitive dashboard with **Bootstrap + CSS3** design.

---

## 🧱 Technologies Used

| Category         | Technologies                       |
| ---------------- | ---------------------------------- |
| **Frontend**     | HTML5, CSS3, Bootstrap, JavaScript |
| **Backend**      | PHP (XAMPP)                        |
| **Database**     | MySQL                              |
| **Mail Service** | PHPMailer                          |
| **Server**       | Apache (via XAMPP)                 |
| **IDE / Tools**  | VS Code, phpMyAdmin                |

---

## 🗄️ Database Information

**Database Name:** `appointment_system`

**Main Tables:**

* `patient` – Stores patient details
* `departments` – Medical departments
* `doctors` – Doctor details with department mapping
* `appointments` – Appointment records
* `feedback` – Patient feedback
* `admin` – Admin login credentials

---

## 📂 Folder Structure

```
AppointCare/
├── config.php                # Database connection file
│
├── Admin/                    # Admin Dashboard
│   ├── admin_login.php
│   ├── admin_dashboard.php
│   ├── add_department.php
│   ├── add_doctor.php
│   ├── departments.php
│   ├── doctors.php
│   ├── appointments.php
│   ├── patients.php
│   ├── feedback.php
│   ├── delete_department.php
│   ├── delete_doctor.php
│   ├── edit_department.php
│   ├── edit_doctor.php
│   ├── admin_logout.php
│   ├── style.css
│   └── img/
│       ├── doctor.png
│       ├── feedback.png
│       ├── logout.png
│       ├── schedule.png
│       └── medical.png
│
├── Patient/                  # Patient Interface
│   ├── index.php
│   ├── appointment.php
│   ├── cancel.php
│   ├── feedback.php
│   ├── login.php
│   ├── logout.php
│   ├── register.php
│   ├── bg.jpeg
│   ├── assets/
│   │   ├── css/main.css
│   │   ├── js/main.js
│   │   ├── img/
│   │   │   ├── about.jpg
│   │   │   ├── hero-bg.jpg
│   │   │   ├── login.png
│   │   │   └── logout.png
│   │   └── vendor/  # Bootstrap, AOS, Swiper, FontAwesome, etc.
│   └── styles.css
│
└── PHPMailer-master/         # Email Notification Library
    └── src/
        ├── PHPMailer.php
        ├── SMTP.php
        ├── Exception.php
        └── OAuth.php
```

---

## ⚙️ How to Run Locally

1. **Install XAMPP** and start **Apache** & **MySQL**.
2. Place the `AppointCare` folder inside:

   ```
   C:\xampp\htdocs\AppointCare
   ```
3. Open **phpMyAdmin** → Create database:

   ```
   appointment_system
   ```
4. Import the SQL file with your tables and sample data.
5. Configure DB connection in `config.php`.
6. Run the project in browser:

   * 🧑‍⚕️ Patient: [http://localhost/AppointCare/Patient](http://localhost/AppointCare/Patient)
   * 🛠️ Admin: [http://localhost/AppointCare/Admin](http://localhost/AppointCare/Admin)

---

## 📧 Email Integration (PHPMailer)

* Configure SMTP settings in `PHPMailer-master/src/PHPMailer.php`.
* Used for booking and cancellation confirmation emails.

---

## 🎨 Frontend Design Highlights

* Semantic HTML5 structure (`<header>`, `<main>`, `<section>`, `<footer>`)
* CSS3 transitions and hover effects
* Responsive layout (Flexbox + Media Queries)
* Client-side validation using HTML5 attributes
* Server-side validation via PHP

---

## 🧠 Learning Outcomes

* Built a real-time **CRUD system** using PHP & MySQL.
* Implemented **HTML5 + CSS3** professionally in healthcare domain.
* Integrated **PHPMailer** for email notifications.
* Designed separate Admin and Patient interfaces.
* Learned full-stack deployment on XAMPP.
* Mapped all outcomes to **WDE511MJ** course objectives.

---

## 💻 **Browser Support**

AppointCare works seamlessly on:

* Google Chrome ✅
* Mozilla Firefox ✅
* Microsoft Edge ✅
* Safari ✅
* Opera ✅

---

## 🔮 Future Enhancements

* Add appointment **rescheduling**.
* Integrate **Razorpay** payment gateway.
* Add **Doctor Dashboard** for live appointment tracking.
* Generate **analytics & reports** in admin panel.

---

## 👨‍💻 Developer

**Deep Ghinaiya**
💼 *Software Developer

🌐 **Connect with Me:**

* 🔗 [LinkedIn](https://www.linkedin.com/in/deep-ghinaiya/)
* 💻 [GitHub](https://github.com/Ghinaiya-Deep/)
* 📧 [deep.c617.app@gmail.com](mailto:deep.c617.app@gmail.com)

