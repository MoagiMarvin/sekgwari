<?php
require_once 'db_config.php';

// Fetch all staff members
$staff_members = $conn->query("SELECT * FROM staff ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Meet the dedicated staff at Sekgwari Primary School">
    <title>Our Staff - Sekgwari Primary School</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!-- Navigation -->
    <nav>
        <div class="nav-container">
            <div class="logo">
                <div class="logo-icon">🎓</div>
                <span>Sekgwari Primary</span>
            </div>
            <div class="menu-toggle" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <ul class="nav-links" id="navLinks">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="staff.php" class="active">Staff</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" style="min-height: 50vh;">
        <div class="hero-content">
            <div class="school-badge animate-fadeIn">👥 Our Team</div>
            <h1 class="animate-fadeInUp">Meet Our Dedicated Staff</h1>
            <p class="animate-fadeInUp stagger-1">Passionate educators committed to your child's success</p>
        </div>
    </section>

    <!-- Teaching Staff Section -->
    <section class="bg-white">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Our Teaching Staff</h2>
                <p class="section-subtitle">Dedicated professionals making a difference every day</p>
            </div>

            <div class="grid grid-3">
                <?php if ($staff_members->num_rows > 0): ?>
                    <?php $stagger = 1; while($row = $staff_members->fetch_assoc()): ?>
                    <div class="staff-card animate-fadeInUp stagger-<?php echo $stagger; ?>">
                        <div class="staff-image-wrapper">
                            <?php if ($row['image_path']): ?>
                                <img src="<?php echo $row['image_path']; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="staff-image">
                            <?php else: ?>
                                <img src="data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22200%22%3E%3Crect fill=%22%232563eb%22 width=%22200%22 height=%22200%22/%3E%3Ctext fill=%22white%22 font-size=%2280%22 x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dy=%22.3em%22%3E👨‍🏫%3C/text%3E%3C/svg%3E" alt="Fallback Icon" class="staff-image">
                            <?php endif; ?>
                        </div>
                        <h3 class="staff-name"><?php echo htmlspecialchars($row['name']); ?></h3>
                        <span class="staff-position"><?php echo htmlspecialchars($row['position']); ?></span>
                        <p class="staff-qualification"><?php echo htmlspecialchars($row['qualification']); ?></p>
                        <p class="staff-message">"<?php echo htmlspecialchars($row['message']); ?>"</p>
                        <p class="staff-grade"><?php echo htmlspecialchars($row['grade']); ?></p>
                    </div>
                    <?php $stagger = ($stagger % 6) + 1; endwhile; ?>
                <?php else: ?>
                    <div style="grid-column: 1 / -1; text-align: center; padding: 4rem; color: var(--gray-500);">
                        <p>No staff members listed at the moment. Please check back soon!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Join Our Team Section -->
    <section class="bg-gray">
        <div class="container text-center">
            <div style="max-width: 700px; margin: 0 auto;">
                <h2 class="section-title">Join Our Team</h2>
                <p class="section-subtitle">Are you a passionate educator looking to make a difference? We're always
                    looking for talented individuals to join our school family.</p>
                <div style="margin-top: 2rem;">
                    <a href="contact.html" class="btn btn-primary">Get In Touch</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>Sekgwari Primary School</h3>
                <p>Nurturing excellence in education and building tomorrow's leaders through quality teaching and strong
                    values.</p>
                <div class="social-links">
                    <a href="#" class="social-link">📘</a>
                    <a href="#" class="social-link">📷</a>
                    <a href="#" class="social-link">🐦</a>
                </div>
            </div>

            <div class="footer-section">
                <h3>Quick Links</h3>
                <a href="index.php">Home</a>
                <a href="about.html">About Us</a>
                <a href="staff.php">Our Staff</a>
                <a href="gallery.php">Gallery</a>
                <a href="contact.html">Contact</a>
            </div>

            <div class="footer-section">
                <h3>Contact Info</h3>
                <p>📍 Gamatlala, Limpopo</p>
                <p>📞 +27 XX XXX XXXX</p>
                <p>✉️ info@sekgwariprimary.co.za</p>
            </div>

            <div class="footer-section">
                <h3>School Hours</h3>
                <p>Monday - Friday</p>
                <p>7:30 AM - 2:00 PM</p>
                <p style="margin-top: 1rem; color: #f59e0b;">📚 Learning Never Stops</p>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2026 Sekgwari Primary School. All rights reserved.</p>
        </div>
    </footer>

    <!-- Mobile Menu Script -->
    <script>
        function toggleMenu() {
            const navLinks = document.getElementById('navLinks');
            navLinks.classList.toggle('active');
        }

        document.addEventListener('click', function (event) {
            const nav = document.querySelector('nav');
            const navLinks = document.getElementById('navLinks');

            if (!nav.contains(event.target)) {
                navLinks.classList.remove('active');
            }
        });
    </script>
</body>

</html>
