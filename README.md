**🩺 AppointCare — Healthcare Appointment Management System**

**📘 Overview:**

AppointCare is a full-stack hospital appointment management system built using PHP, MySQL, HTML5, CSS3, and XAMPP.
It provides two separate interfaces — one for Patients to book or cancel appointments and give feedback, and another for Admins to manage doctors, departments, and appointments.
The project is fully responsive, follows semantic HTML5 standards, and includes form validation, hover effects, and email notifications using PHPMailer.

**🚀 Key Features:
**
**🧑‍⚕️ Patient Panel:**
• Book new appointments by selecting department & doctor.
• Cancel appointments using reference ID or email (no reschedule).
• Submit feedback directly to the hospital.
• Receive email confirmation for booking and cancellation via PHPMailer.
• Fully responsive layout with semantic structure and hover effects.

**🛠️ Admin Dashboard:**
• Secure Admin login/logout system.
• Manage all departments, doctors, and patients.
• View appointments.
• Access and manage feedback submitted by patients.
• Simple, intuitive dashboard interface built with CSS3 and Bootstrap.

**🧱 Technologies Used:**
• Frontend: HTML5, CSS3, Bootstrap, JavaScript
• Backend:	PHP (XAMPP)
• Database:	MySQL
• Mail Service:	PHPMailer
• Server:	Apache (via XAMPP)
• IDE / Tools:	VS Code, phpMyAdmin

**🗄️ Database:**
• Database Name: appointment_system

**Main Tables:**
• patient - Stores all patient details.
• departments – Stores all medical departments.
• doctors – Stores doctor details with department mapping.
• appointments – Stores appointment details booked by patients.
• feedback – Stores user feedback.
• admin – Admin login credentials.

**📂 Folder Structure**
AppointCare/
│
├── config.php                   # Database connection file
│
├── Admin/                       # Admin Dashboard
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
├── Patient/                     # Patient Interface
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
│   │   └── vendor/              # Libraries: Bootstrap, AOS, Swiper, FontAwesome, etc.
│   └── styles.css
│
└── PHPMailer-master/            # Email Notification Library
    ├── src/
    │   ├── PHPMailer.php
    │   ├── SMTP.php
    │   ├── Exception.php
    │   └── OAuth.php
    └── README.md

**⚙️ How to Run Locally**
1. Install XAMPP and start Apache & MySQL.
2. Place the AppointCare folder inside:
C:\xampp\htdocs\AppointCare
3. Open phpMyAdmin → Create a new database:
appointment_system
4. Import your SQL structure and data (departments, doctors, etc.).
5. Configure database connection in config.php.

**Run the project:**
👉 http://localhost/AppointCare/Patient #Patient Side
👉 http://localhost/AppointCare/Admin   #Admin Side

**📧 Email Integration (PHPMailer)**
• Configure SMTP settings inside PHPMailer-master/src/PHPMailer.php.
• Use it in booking and cancellation scripts to send confirmation emails.

**🎨 Frontend Design Highlights:**
• HTML5 Semantic Tags (<header>, <nav>, <section>, <footer>)
• CSS3 Transitions & Hover Effects
• Responsive Layout using Flexbox and Media Queries
• Form validation using HTML5 attributes and PHP checks

**🧠 Learning Outcomes:**
• Built a real-time CRUD system using PHP and MySQL.
• Applied HTML5 + CSS3 features in a professional healthcare web project.
• Integrated PHPMailer for automated email notifications.
• Designed Admin & Patient interfaces with full form validation.
• Gained understanding of full-stack workflow using local server deployment.
• This project fulfills the WDE511MJ learning outcomes, demonstrating skills in both front-end and back-end web development.

**🔮 Future Enhancements**
• Add appointment rescheduling option.
• Integrate payment gateway (e.g., Razorpay).
• Add doctor dashboard for real-time appointment view.
• Create analytics and reports in the admin panel.

**👨‍💻 Developer**
Deep Ghinaiya
[Software Developer]


**🌐 Connect with Me: **
🔗 Linkedin: https://www.linkedin.com/in/deep-ghinaiya/
🔗 Github: https://github.com/Ghinaiya-Deep/
📧 Email: deep.c617.app@gmail.com 
