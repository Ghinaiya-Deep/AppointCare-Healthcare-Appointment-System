<?php
session_start();

require "../config.php";


$is_logged_in = isset($_SESSION['valid']) && !empty($_SESSION['valid']);
$patient_id = $is_logged_in ? $_SESSION['id'] : null;
$patient_username = $is_logged_in ? $_SESSION['username'] : 'Guest';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>AppointCare</title>
  <meta name="description" content="">
  <meta name="keywords" content="">


  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <link href="assets/css/main.css" rel="stylesheet">

</head>

<body class="index-page">

  <header id="header" class="header sticky-top">
    <div class="branding d-flex align-items-center">

      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="index.php" class="logo d-flex align-items-center me-auto">

          <h1 class="sitename">AppointCare</h1>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="#hero" class="active">Home<br></a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#departments">Departments</a></li>
            <li><a href="feedback.php">Feedback</a></li>
            <li><a href="#faq">FAQ</a></li>
            <li><a href="#contact">Contact</a></li>

            <?php
            if ($is_logged_in):
            ?>
              <li>
                <a href="logout.php" title="Logout (<?php echo htmlspecialchars($patient_username); ?>)">
                  <img
                    src="assets/img/logout.png"
                    alt="Profile"
                    style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; margin-right: 5px;">

                </a>
              </li>
            <?php else: ?>
              <li>
                <a href="login.php" title="Login">
                  <img
                    src="assets/img/login.png"
                    alt="Login"
                    style="width: 40px; height: 40px; object-fit: cover; margin-right: 5px;">
                </a>
              </li>
            <?php endif; ?>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <a class="cta-btn d-none d-sm-block" href="appointment.php">Make an Appointment</a>
        <a class="cta-btn d-none d-sm-block" href="cancel.php">Cancel an Appointment</a>
      </div>
    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section light-background">

      <img src="assets/img/hero-bg.jpg" alt="" data-aos="fade-in">

      <div class="container position-relative">

        <div class="welcome position-relative" data-aos="fade-down" data-aos-delay="100">
          <h2>WELCOME TO APPOINTCARE</h2>
          <p>Connecting patients with Nashik’s top doctors for easy online appointments.</p>
        </div><!-- End Welcome -->

        <div class="content row gy-4">
          <div class="col-lg-4 d-flex align-items-stretch">
            <div class="why-box" data-aos="zoom-out" data-aos-delay="200">
              <h3>Why Choose APPOINTCARE?</h3>
              <p>
                AppointCare connects patients with Nashik’s top doctors for easy online appointments.
                Our platform makes scheduling fast, secure, and hassle-free.
                From routine check-ups to specialized care, we make healthcare simple and accessible.
              </p>
              <div class="text-center">
                <a href="#about" class="more-btn"><span>Learn More</span> <i class="bi bi-chevron-right"></i></a>
              </div>
            </div>
          </div><!-- End Why Box -->

          <div class="col-lg-8 d-flex align-items-stretch">
            <div class="d-flex flex-column justify-content-center">
              <div class="row gy-4">

                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box" data-aos="zoom-out" data-aos-delay="300">
                    <i class="bi bi-clipboard-data"></i>
                    <h4>Fast & Convenient Appointments</h4>
                    <p>Book consultations with Nashik’s top doctors quickly and securely, without long waiting times.</p>
                  </div>
                </div><!-- End Icon Box -->

                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box" data-aos="zoom-out" data-aos-delay="400">
                    <i class="bi bi-gem"></i>
                    <h4>Reliable Healthcare Support</h4>
                    <p>Our platform features verified and experienced doctors across all major specialties in Nashik.</p>
                  </div>
                </div><!-- End Icon Box -->

                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box" data-aos="zoom-out" data-aos-delay="500">
                    <i class="bi bi-inboxes"></i>
                    <h4>Reliable Healthcare Support</h4>
                    <p>From routine check-ups to specialized treatments,
                      AppointCare ensures safe, accessible, and high-quality care for all patients.</p>
                  </div>
                </div><!-- End Icon Box -->

              </div>
            </div>
          </div>
        </div><!-- End  Content-->

      </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">
      <div class="container">
        <div class="row gy-4 gx-5">

          <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="200">
            <img src="assets/img/about.jpg" class="img-fluid" alt="">
          </div>

          <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
            <h3>About Us</h3>
            <p>
              AppointCare is a leading online platform connecting patients in Nashik with top doctors across all major specialties.
              Our mission is to make healthcare accessible, convenient, and secure for everyone.
            </p>
            <ul>
              <li>
                <i class="fa-solid fa-vial-circle-check"></i>
                <div>
                  <h5>Fast & Easy Appointments</h5>
                  <p>Patients can quickly book consultations with verified doctors, choose convenient time slots, and manage appointments effortlessly from home.</p>
                </div>
              </li>
              <li>
                <i class="fa-solid fa-pump-medical"></i>
                <div>
                  <h5>Trusted Healthcare Network</h5>
                  <p>We collaborate with experienced doctors and hospitals to ensure high-quality care for every patient,
                    from routine check-ups to specialized treatments.</p>
                </div>
              </li>
              <li>
                <i class="fa-solid fa-heart-circle-xmark"></i>
                <div>
                  <h5>Patient-Centric Approach</h5>
                  <p>AppointCare prioritizes patient safety and satisfaction, providing reliable support and
                    seamless healthcare experiences for all.</p>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section><!-- /About Section -->

  

    <!-- Departments Section -->
    <section id="departments" class="departments section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Departments</h2>
        <p>Explore our departments and find top doctors in Nashik.</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <!-- First row of 6 departments -->
        <div class="row mb-3">
          <div class="col-lg-12">
            <ul class="nav nav-tabs flex-row justify-content-center">
              <li class="nav-item"><a class="nav-link active" href="#">Cardiology</a></li>
              <li class="nav-item"><a class="nav-link" href="#">Neurology</a></li>
              <li class="nav-item"><a class="nav-link" href="#">Orthopaedics</a></li>
              <li class="nav-item"><a class="nav-link" href="#">Dermatology</a></li>
              <li class="nav-item"><a class="nav-link" href="#">Dentistry</a></li>
              <li class="nav-item"><a class="nav-link" href="#">Gynaecology & Obstetrics</a></li>
            </ul>
          </div>
        </div>

        <!-- Second row of 6 departments -->
        <div class="row mb-3">
          <div class="col-lg-12">
            <ul class="nav nav-tabs flex-row justify-content-center">
              <li class="nav-item"><a class="nav-link" href="#appointment">ENT</a></li>
              <li class="nav-item"><a class="nav-link" href="#appointment">Paediatrics</a></li>
              <li class="nav-item"><a class="nav-link" href="#appointment">Psychiatry</a></li>
              <li class="nav-item"><a class="nav-link" href="#appointment">Ophthalmology</a></li>
              <li class="nav-item"><a class="nav-link" href="#appointment">Gastroenterology</a></li>
              <li class="nav-item"><a class="nav-link" href="#appointment">Urology</a></li>
            </ul>
          </div>
        </div>

        <!-- Optional third row for remaining departments -->
        <div class="row">
          <div class="col-lg-12">
            <ul class="nav nav-tabs flex-row justify-content-center">
              <li class="nav-item"><a class="nav-link" href="#appointment">Pulmonology</a></li>
              <li class="nav-item"><a class="nav-link" href="#appointment">Nephrology</a></li>
              <li class="nav-item"><a class="nav-link" href="#appointment">General Medicine</a></li>
              <li class="nav-item"><a class="nav-link" href="#appointment">Rheumatology</a></li>
              <li class="nav-item"><a class="nav-link" href="#appointment">Endocrinology</a></li>
              <li class="nav-item"><a class="nav-link" href="#appointment">Oncology</a></li>
            </ul>
          </div>
        </div>

        <!-- Optional fourth row for last 2 departments -->
        <div class="row">
          <div class="col-lg-12">
            <ul class="nav nav-tabs flex-row justify-content-center">
              <li class="nav-item"><a class="nav-link" href="#appointment">Hematology</a></li>
              <li class="nav-item"><a class="nav-link" href="#appointment">Physiotherapy / Rehabilitation</a></li>
            </ul>
          </div>
        </div>

      </div>
    </section><!-- /Departments Section -->

    <style>
      #departments {
        padding: 60px 0;
        background: #f9f9f9;
      }

      #departments .section-title h2 {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 10px;
        color: #333;
      }

      #departments .section-title p {
        font-size: 16px;
        color: #666;
      }

      /* Department tabs */
      #departments .nav-tabs {
        border-bottom: none;
      }

      #departments .nav-tabs .nav-item {
        margin-right: 15px;
      }

      #departments .nav-tabs .nav-link {
        font-size: 16px;
        font-weight: 500;
        color: #555;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 30px;
        padding: 8px 20px;
        transition: all 0.3s ease;
        margin-bottom: 10px;
      }

      #departments .nav-tabs .nav-link:hover {
        background: #007bff;
        color: #fff;
        border-color: #007bff;
      }

      #departments .nav-tabs .nav-link.active {
        background: #007bff;
        color: #fff;
        border-color: #007bff;
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.25);
      }

      /* Responsive adjustments */
      @media (max-width: 768px) {
        #departments .nav-tabs {
          flex-wrap: wrap;
        }

        #departments .nav-tabs .nav-item {
          margin-right: 8px;
          margin-bottom: 8px;
        }
      }
    </style>



    <!-- Faq Section -->
    <section id="faq" class="faq section light-background">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Frequently Asked Questions</h2>
        <p>Find answers to common queries about booking appointments and visiting our doctors.</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row justify-content-center">

          <div class="col-lg-10" data-aos="fade-up" data-aos-delay="100">

            <div class="faq-container">

              <div class="faq-item faq-active">
                <h3>How can I book an appointment online?</h3>
                <div class="faq-content">
                  <p>You can book an appointment by selecting your preferred department and doctor from the “Appointment” section, choosing an available date and time, and submitting your details. You will receive a confirmation via email or phone.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Can I reschedule or cancel my appointment?</h3>
                <div class="faq-content">
                  <p>Yes, you can cancel your appointment by logging into your account or contacting the hospital’s reception directly at the provided phone number.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Do I need to pay online or at the hospital?</h3>
                <div class="faq-content">
                  <p>No, appointments can be booked free of cost through the system. There is no payment required while scheduling an appointment online.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>What documents should I bring for my appointment?</h3>
                <div class="faq-content">
                  <p>It is recommended to bring a valid ID, previous medical records (if any), insurance documents, and any relevant test reports to ensure a smooth consultation with the doctor.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section><!-- /Faq Section -->


    <section id="contact" class="contact section">

      <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
        <p>Have questions or need assistance? Our team is here to help you with appointments, departments, and medical queries — reach out anytime. 💬</p>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">

          <div class="col-lg-4">
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
              <i class="bi bi-geo-alt flex-shrink-0"></i>
              <div>
                <h3>Location</h3>
                <p>Nashik City, Maharashtra, India</p>
              </div>
            </div>
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-telephone flex-shrink-0"></i>
              <div>
                <h3>Call Us</h3>
                <p>+91 63524 42624</p>
              </div>
            </div>
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
              <i class="bi bi-envelope flex-shrink-0"></i>
              <div>
                <h3>Email Us</h3>
                <p>contact@appointcarenashik.com</p>
              </div>
            </div>
          </div>

          <div class="col-lg-8">
            <div class="map-in-form-area" data-aos="fade-up" data-aos-delay="200" style="height: 100%; min-height: 400px;">
              <iframe
                style="border:0; width: 100%; height: 100%; min-height: 400px;"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d239992.6901368647!2d73.8587713179162!3d19.971305059778715!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bddd290b09914b3%3A0xcb07845d9d28215c!2sNashik%2C%20Maharashtra!5e0!3m2!1sen!2sin!4v1761198594413!5m2!1sen!2sin"
                frameborder="0"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
              </iframe>
            </div>
          </div>
        </div>

      </div>

    </section>
    </div>
    </div>
    </section><!-- /Contact Section -->
  </main>

  <footer id="footer" class="footer light-background">
    <div class="container footer-top">
      <div class="row gy-4">

        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">AppointCare</span>
          </a>
          <div class="footer-contact pt-3">
            <p><strong>Serving Area:</strong> Nashik City, Maharashtra, India</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+91 63524 42624</span></p>
            <p><strong>Email:</strong> <span>contact@appointcarenashik.com</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href="#"><i class="bi bi-twitter"></i></a>
            <a href="#"><i class="bi bi-facebook"></i></a>
            <a href="#"><i class="bi bi-instagram"></i></a>
            <a href="#"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 footer-links">
          <h4>Quick Links</h4>
          <ul>
            <li><a href="#hero">Home</a></li>
            <li><a href="#about">About Us</a></li>
            <li><a href="#departments">Departments</a></li>
            <li><a href="#departments">Book Appointment</a></li>
            <li><a href="#feedback">Patient Feedback</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-6 footer-links">
          <h4>Support & Policy</h4>
          <ul>
            <li><a href="#contact">Contact</a></li>
            <li><a href="#faq">FAQ</a></li>
            <li><a href="#contact">Emergency Help</a></li>
            <li><a href="#terms">Terms of Service</a></li>
            <li><a href="#privacy">Privacy Policy</a></li>
          </ul>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">AppointCare 2025</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        Designed by <a href="https://deepghinaiya.netlify.app/">Deep Ghinaiya</a>
      </div>
    </div>
  </footer>


  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>