<?php include('includes/header.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="assets\images\logo.png"  type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome Icons -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Care Compass Hospitals</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Welcome to Care Compass Hospitals</h1>
                <p>Providing excellent medical care across Kandy, Colombo, and Kurunegala</p>
                <a href="services" class="btn">Explore Our Services</a>
            </div>
            <div class="hero-image">
                <img src="assets/images/image1.jpg" alt="Happy Patients and Doctors"> <!-- Update this with your desired image -->
            </div>
        </div>
    </section>


    <!-- About Us Section -->
    <section class="about-us">
        <h2>About Care Compass Hospitals</h2>
        <p>Care Compass Hospitals is dedicated to providing exceptional medical care across Kandy, Colombo, and Kurunegala. Our team of experienced doctors and healthcare professionals are committed to your health and well-being.</p>
        <img src="assets/images/about-us.jpg" alt="About Care Compass" class="about-us-img"> <!-- About Us Image -->
        <p><strong>Achievements:</strong> Over 1,000 successful surgeries, 95% patient satisfaction rate, and 20+ years of healthcare excellence.</p>
    </section>

    <!-- Our Services Section -->
    <section class="services">
        <h2>Our Services</h2>
        <div class="services-list">
            <div class="service-item">
                <i class="fas fa-stethoscope"></i> <!-- Icon -->
                <h3>General Medicine</h3>
                <p>Consult with experienced doctors for your general health needs.</p>
                <a href="#" class="btn">Learn More</a>
            </div>
            <div class="service-item">
                <i class="fas fa-scalpel"></i> <!-- Icon -->
                <h3>Surgery</h3>
                <p>Advanced surgical procedures with the latest technology and expert care.</p>
                <a href="#" class="btn">Learn More</a>
            </div>
            <div class="service-item">
                <i class="fas fa-flask"></i> <!-- Icon -->
                <h3>Laboratory Tests</h3>
                <p>Accurate and reliable lab tests to support your diagnosis and treatment plan.</p>
                <a href="#" class="btn">Learn More</a>
            </div>
            <div class="service-item">
                <i class="fas fa-heartbeat"></i> <!-- Icon -->
                <h3>Emergency Care</h3>
                <p>24/7 emergency medical services for urgent health concerns.</p>
                <a href="#" class="btn">Learn More</a>
            </div>
        </div>
    </section>

    <!-- Featured Services Section -->
<!-- Featured Services Section -->
<section class="featured-services">
    <h2>Featured Services</h2>
    <div class="services-list">
        <div class="service-item">
            <h3>Emergency Care</h3>
            <p>24/7 emergency services for critical medical conditions.</p>
            <a href="#">Learn More</a>
        </div>
        <div class="service-item">
            <h3>Laboratory Tests</h3>
            <p>Comprehensive lab tests to diagnose and monitor your health.</p>
            <a href="#">Learn More</a>
        </div>
        <div class="service-item">
            <h3>Specialist Consultations</h3>
            <p>Expert consultations in various medical specialties.</p>
            <a href="#">Learn More</a>
        </div>
    </div>
</section>


    <!-- Testimonials Section -->
<!-- Testimonials Section -->
<section class="testimonials">
    <h2>What Our Patients Say</h2>
    <blockquote>
        "Care Compass Hospitals helped me recover from a critical surgery. The staff was amazing!"
        <footer>- Jane D.</footer>
    </blockquote>
    <blockquote>
        "The emergency care team was so responsive. I felt cared for every step of the way."
        <footer>- Raj S.</footer>
    </blockquote>
</section>



    <!-- Quick Links Section -->
    <section class="icon-boxes">
    <div class="container">
        <a href="book-appointment.php" class="icon-box">
            <i class="fas fa-calendar-check"></i> <!-- Appointment icon -->
            <h3>Book an Appointment</h3>
            <p>Easy appointment scheduling for your convenience.</p>
        </a>
        <a href="meet-our-doctors.php" class="icon-box">
            <i class="fas fa-user-md"></i> <!-- Doctors icon -->
            <h3>Meet Our Doctors</h3>
            <p>Get to know our experienced doctors and specialists.</p>
        </a>
        <a href="contact.php" class="icon-box">
            <i class="fas fa-phone-alt"></i> <!-- Contact Us icon -->
            <h3>Contact Us</h3>
            <p>We're here to assist you with any queries.</p>
        </a>
        <a href="login.php" class="icon-box">
            <i class="fas fa-user-injured"></i> <!-- Patient Portal icon -->
            <h3>Patient Portal</h3>
            <p>Access your medical records and more.</p>
        </a>
    </div>
</section>



    <!-- News & Updates Section -->
    <section class="news-updates">
        <h2>Latest News</h2>
        <div class="news-item">
            <h3>New Pediatric Wing Opening Soon</h3>
            <p>We are excited to announce the opening of our new pediatric wing, designed to provide world-class care for children.</p>
        </div>
        <div class="news-item">
            <h3>Health Tips: Preventing the Flu</h3>
            <p>Stay healthy this season with our expert health tips on preventing the flu and boosting your immune system.</p>
        </div>
        <div class="news-item">
            <h3>Subscribe to Our Newsletter</h3>
            <p>Stay updated on the latest news and health tips by subscribing to our newsletter.</p>
            <a href="#" class="btn">Subscribe</a>
        </div>
    </section>

    <?php include('includes/footer.php'); ?>

</body>
</html>
