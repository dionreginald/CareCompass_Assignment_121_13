<?php include('includes/header.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Care Compass Hospitals</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script>
        // JavaScript function to handle AJAX form submission
        function submitForm(event) {
            event.preventDefault(); // Prevent the default form submission

            // Get the form data
            var name = document.getElementById("name").value;
            var email = document.getElementById("email").value;
            var message = document.getElementById("message").value;

            // Check if all fields are filled
            if (name && email && message) {
                // Create an object to send data to the server
                var formData = new FormData();
                formData.append('name', name);
                formData.append('email', email);
                formData.append('message', message);

                // Create an AJAX request
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "send-message.php", true);

                // When the response is received from the server
                xhr.onload = function () {
                    if (xhr.status == 200) {
                        // If the server response is successful, show the Thank You message
                        var response = xhr.responseText.trim();
                        if (response === "Message sent successfully!") {
                            showNotification("Thank you for contacting us. We will get back to you shortly!");
                        } else {
                            showNotification("Oops! Something went wrong. Please try again.");
                        }
                        document.getElementById("contact-form").reset(); // Clear the form
                    } else {
                        // Show an error message if something goes wrong
                        showNotification("Oops! Something went wrong. Please try again.");
                    }
                };

                // Send the data to the server
                xhr.send(formData);
            } else {
                showNotification("Please fill out all fields before submitting.");
            }
        }

        // Function to show a notification at the top of the page
        function showNotification(message) {
            var notification = document.createElement('div');
            notification.classList.add('notification');
            notification.innerText = message;

            // Append notification to the top of the page
            document.body.insertBefore(notification, document.body.firstChild);

            // Remove the notification after 4 seconds
            setTimeout(function () {
                notification.remove();
            }, 4000); // Hide after 4 seconds
        }
    </script>
</head>
<body>

    <!-- Contact Us Section -->
    <section class="contact-us">
    <div class="container">
        <h1>Contact Us</h1>

        <!-- Contact Information -->
        <div class="contact-info">
            <div class="contact-item">
                <i class="fas fa-map-marker-alt"></i>
                <h3>Our Address</h3>
                <p>123 Care Compass Street, Kandy, Sri Lanka</p>
            </div>
            <div class="contact-item">
                <i class="fas fa-phone-alt"></i>
                <h3>Phone</h3>
                <p>+94 123 456 789</p>
            </div>
            <div class="contact-item">
                <i class="fas fa-envelope"></i>
                <h3>Email</h3>
                <p>info@carecompasshospitals.com</p>
            </div>
            <div class="contact-item">
                <i class="fab fa-facebook"></i>
                <h3>Social Media</h3>
                <p>
                    <a href="" target="_blank">Facebook</a> | 
                    <a href="#" target="_blank">Twitter</a> | 
                    <a href="#" target="_blank">Instagram</a>
                </p>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="contact-form">
            <h2>Get In Touch</h2>
            <form id="contact-form" onsubmit="submitForm(event)">
                <input type="text" id="name" name="name" placeholder="Your Name" required>
                <input type="email" id="email" name="email" placeholder="Your Email" required>
                <textarea id="message" name="message" placeholder="Your Message" required></textarea>
                <button type="submit" class="btn">Submit</button>
            </form>
        </div>

        <!-- Location Map -->
        <div class="map">
            <h2>Find Us Here</h2>
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7921.811267466338!2d79.853214!3d6.901888!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2596094db18b9%3A0xb0ffe5ca94529291!2sDurdans%20Hospital!5e0!3m2!1sen!2slk!4v1738843859473!5m2!1sen!2slk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</section>

    <?php include('includes/footer.php'); ?>

</body>
</html>
