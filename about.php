<?php include('includes/header.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Care Compass Hospitals</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

</head>
<body>

    <!-- About Us Section -->
    <section class="about-us">
        <div class="container">
            <h1>About Us</h1>
            
            <!-- Introduction -->
            <div class="intro">
                <h2>Welcome to Care Compass Hospitals</h2>
                <p>At Care Compass Hospitals, we are committed to providing high-quality healthcare services to our community. With a focus on patient care and medical innovation, we aim to deliver the best possible healthcare experience for every patient.</p>
                <img src="assets/images/image2.jpg" alt="Happy Patients and Doctors">
            </div>

            <!-- Our Mission and Vision -->
            <div class="mission-vision">
                <div class="mission">
                    <h3>Our Mission</h3>
                    <p>To deliver compassionate, high-quality healthcare to all our patients, ensuring the best outcomes with a focus on patient-centered care.</p>
                </div>
                <div class="vision">
                    <h3>Our Vision</h3>
                    <p>To be a leading hospital that sets the benchmark for excellence in healthcare, contributing to the well-being of our community.</p>
                </div>
            </div>

            <!-- Our Services -->
<!-- Our Services -->
<div class="services">
    <h2>Our Services</h2>
    <div class="service-buttons">
        <button class="service-button">
            <img src="assets/images/general-medicine.jpg" alt="General Medicine">
            <span>General Medicine</span>
        </button>
        <button class="service-button">
            <img src="assets/images/pediatrics.jpg" alt="Pediatrics">
            <span>Pediatrics</span>
        </button>
        <button class="service-button">
            <img src="assets/images/orthopedics.jpg" alt="Orthopedics">
            <span>Orthopedics</span>
        </button>
        <button class="service-button">
            <img src="assets/images/surgery.jpg" alt="Surgery">
            <span>Surgery</span>
        </button>
        <button class="service-button">
            <img src="assets/images/laboratory.jpg" alt="Laboratory Services">
            <span>Laboratory Services</span>
        </button>
        <button class="service-button">
            <img src="assets/images/emergency-care.jpg" alt="Emergency Care">
            <span>Emergency Care</span>
        </button>
    </div>
</div>


            <!-- Our Team -->
            <div class="team">
                <h2>Meet Our Team</h2>
                <div class="team-member">
                    <img src="assets/images/doctor1.jpg" alt="Dr. John Doe">
                    <h3>Dr. John Doe</h3>
                    <p>Chief Medical Officer</p>
                    <p>Dr. John Doe has over 20 years of experience in the medical field, providing high-quality care to thousands of patients.</p>
                </div>
                <div class="team-member">
                    <img src="assets/images/doctor2.jpg" alt="Dr. Jane Smith">
                    <h3>Dr. Jane Smith</h3>
                    <p>Lead Surgeon</p>
                    <p>Dr. Jane Smith specializes in surgeries and has successfully performed over 500+ procedures.</p>
                </div>
                <!-- Add more team members as needed -->
            </div>

<!-- Contact Information -->
<div class="contact-info">
    <h2>Contact Information</h2>
    <div class="contact-item">
        <button class="contact-btn" onclick="window.location.href='tel:+94112345678'">
            <i class="fas fa-phone-alt"></i> Call Us
        </button>
    </div>
    <div class="contact-item">
        <button class="contact-btn" onclick="window.location.href='mailto:info@carecompass.lk'">
            <i class="fas fa-envelope"></i> Email Us
        </button>
    </div>
</div>
    </section>

    <?php include('includes/footer.php'); ?>

</body>
</html>
