<?php
require_once 'db_config.php';

// Fetch all gallery items
$gallery_items = $conn->query("SELECT * FROM gallery ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Explore the vibrant life at Sekgwari Primary School through our gallery">
    <title>School Gallery - Sekgwari Primary School</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .gallery-item {
            position: relative;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: var(--transition-normal);
            aspect-ratio: 4/3;
        }

        .gallery-item:hover {
            transform: scale(1.02);
            box-shadow: var(--shadow-lg);
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .gallery-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1.5rem;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
            color: white;
            opacity: 0;
            transition: var(--transition-normal);
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        .gallery-caption {
            font-weight: 600;
            margin: 0;
        }
    </style>
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
                <li><a href="staff.php">Staff</a></li>
                <li><a href="gallery.php" class="active">Gallery</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" style="min-height: 50vh;">
        <div class="hero-content">
            <div class="school-badge animate-fadeIn">🖼️ Visual Journey</div>
            <h1 class="animate-fadeInUp">Our School Gallery</h1>
            <p class="animate-fadeInUp stagger-1">Capturing precious moments and achievements</p>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="bg-white">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Latest Photos</h2>
                <p class="section-subtitle">A glimpse into the daily life and special events at Sekgwari Primary</p>
            </div>

            <div class="gallery-grid">
                <?php if ($gallery_items->num_rows > 0): ?>
                    <?php $stagger = 1; while($row = $gallery_items->fetch_assoc()): ?>
                    <div class="gallery-item animate-fadeInUp stagger-<?php echo $stagger; ?>">
                        <img src="<?php echo $row['image_path']; ?>" alt="<?php echo htmlspecialchars($row['caption']); ?>">
                        <?php if ($row['caption']): ?>
                            <div class="gallery-overlay">
                                <p class="gallery-caption"><?php echo htmlspecialchars($row['caption']); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php $stagger = ($stagger % 6) + 1; endwhile; ?>
                <?php else: ?>
                    <div style="grid-column: 1 / -1; text-align: center; padding: 4rem; color: var(--gray-500);">
                        <p>Our gallery is currently being curated. Please check back later for new photos!</p>
                    </div>
                <?php endif; ?>
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
