<?php
require_once 'db_config.php';

// Fetch stats for dashboard
$staff_count = $conn->query("SELECT COUNT(*) FROM staff")->fetch_row()[0];
$gallery_count = $conn->query("SELECT COUNT(*) FROM gallery")->fetch_row()[0];

// Fetch staff members
$staff_members = $conn->query("SELECT * FROM staff ORDER BY id DESC");

// Fetch gallery items
$gallery_items = $conn->query("SELECT * FROM gallery ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Sekgwari Primary School</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        :root {
            --sidebar-width: 280px;
        }

        body {
            background-color: var(--bg-gray);
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--primary-navy);
            color: white;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            padding: 2rem 0;
            z-index: 100;
        }

        .sidebar-logo {
            padding: 0 2rem 2.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 700;
            font-size: 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 2rem;
        }

        .nav-menu {
            list-style: none;
            padding: 0;
            flex-grow: 1;
        }

        .nav-item {
            padding: 0.5rem 1rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.875rem 1rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            border-radius: var(--radius-md);
            transition: var(--transition-fast);
            font-weight: 500;
        }

        .nav-link:hover,
        .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.1);
        }

        .nav-link.active {
            background: var(--primary-blue);
        }

        .sidebar-footer {
            padding: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Main Content Styles */
        .main-content {
            margin-left: var(--sidebar-width);
            flex-grow: 1;
            padding: 2.5rem;
        }

        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: white;
            padding: 0.5rem 1.25rem;
            border-radius: 100px;
            box-shadow: var(--shadow-sm);
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: var(--radius-md);
            background: var(--bg-gray);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-info h4 {
            color: var(--gray-500);
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-navy);
        }

        .quick-actions {
            margin-top: 3rem;
        }

        .action-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .action-card {
            background: white;
            padding: 2rem;
            border-radius: var(--radius-lg);
            text-align: center;
            text-decoration: none;
            color: var(--primary-navy);
            transition: var(--transition-normal);
            border: 2px solid transparent;
        }

        .action-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary-blue);
            box-shadow: var(--shadow-lg);
        }

        .action-card span {
            font-size: 2.5rem;
            display: block;
            margin-bottom: 1rem;
        }

        .action-card h3 {
            margin-bottom: 0.5rem;
        }

        .action-card p {
            font-size: 0.875rem;
            color: var(--gray-500);
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--primary-navy);
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-md);
            font-family: inherit;
            transition: var(--transition-fast);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .hero-preview {
            width: 100%;
            height: 200px;
            background: var(--gray-100);
            border-radius: var(--radius-lg);
            margin-top: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 2px dashed var(--gray-300);
        }

        .hero-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        @media (max-width: 1024px) {
            .sidebar {
                width: 80px;
                padding: 1rem 0;
            }

            .sidebar-logo span,
            .nav-link span,
            .sidebar-footer span {
                display: none;
            }

            .sidebar-logo {
                padding: 0;
                justify-content: center;
            }

            .main-content {
                margin-left: 80px;
            }

            .nav-link {
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-icon">🎓</div>
            <span>Admin Panel</span>
        </div>

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="#" class="nav-link active">
                    <span class="icon">📊</span>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="showSection('homepage')">
                    <span class="icon">🏠</span>
                    <span>Homepage</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <span class="icon">👥</span>
                    <span>Staff</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <span class="icon">📞</span>
                    <span>Contacts</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <span class="icon">🖼️</span>
                    <span>Gallery</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <span class="icon">📰</span>
                    <span>News</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <a href="login.html" class="nav-link" style="color: #ef4444;">
                <span class="icon">🚪</span>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <header class="header-actions">
            <div id="pageTitle">
                <h1 class="animate-fadeIn">Welcome, Principal</h1>
                <p class="animate-fadeIn stagger-1">Manage your school website content from here.</p>
            </div>
            <div class="user-profile">
                <span>Principal Sekgwari</span>
                <span style="font-size: 1.5rem;">👩‍🏫</span>
            </div>
        </header>

        <!-- Dashboard Home Content -->
        <div id="dashboardSection" class="content-section">
            <div class="dashboard-grid animate-fadeInUp stagger-2">
                <div class="stat-card">
                    <div class="stat-icon" style="color: var(--primary-blue);">👨‍🏫</div>
                    <div class="stat-info">
                        <h4>Staff Members</h4>
                        <div class="stat-value"><?php echo $staff_count; ?></div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="color: var(--accent-gold);">📸</div>
                    <div class="stat-info">
                        <h4>Gallery Images</h4>
                        <div class="stat-value"><?php echo $gallery_count; ?></div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="color: var(--primary-navy);">📬</div>
                    <div class="stat-info">
                        <h4>New Inquiries</h4>
                        <div class="stat-value">0</div>
                    </div>
                </div>
            </div>

            <section class="quick-actions">
                <h2 class="animate-fadeInUp stagger-3">Quick Management</h2>
                <div class="action-list animate-fadeInUp stagger-4">
                    <button onclick="showSection('staff')" class="action-card"
                        style="width: 100%; cursor: pointer; border: none; font-family: inherit;">
                        <span>➕</span>
                        <h3>Add Teacher</h3>
                        <p>Register a new staff member</p>
                    </button>
                    <button onclick="showSection('contacts')" class="action-card"
                        style="width: 100%; cursor: pointer; border: none; font-family: inherit;">
                        <span>✏️</span>
                        <h3>Update Info</h3>
                        <p>Change contact or school hours</p>
                    </button>
                    <button onclick="showSection('gallery')" class="action-card"
                        style="width: 100%; cursor: pointer; border: none; font-family: inherit;">
                        <span>📤</span>
                        <h3>Upload Photos</h3>
                        <p>Add news photos to the gallery</p>
                    </button>
                    <button onclick="showSection('news')" class="action-card"
                        style="width: 100%; cursor: pointer; border: none; font-family: inherit;">
                        <span>📣</span>
                        <h3>Post News</h3>
                        <p>Share school announcements</p>
                    </button>
                    <button onclick="showSection('homepage')" class="action-card"
                        style="width: 100%; cursor: pointer; border: none; font-family: inherit;">
                        <span>🏠</span>
                        <h3>Edit Homepage</h3>
                        <p>Change hero image and text</p>
                    </button>
                </div>
            </section>
        </div>

        <!-- Homepage Management Section -->
        <div id="homepageSection" class="content-section" style="display: none;">
            <form action="update_homepage.php" method="POST" enctype="multipart/form-data">
                <div class="header-actions" style="margin-bottom: 2rem;">
                    <h2>Homepage Management</h2>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
                <div class="grid grid-2">
                    <div class="card">
                        <h3 style="margin-bottom: 1.5rem;">Hero Section</h3>
                        <div class="form-group">
                            <label class="form-label">Hero Title</label>
                            <input type="text" name="hero_title" id="heroTitle" class="form-input"
                                value="Welcome to Sekgwari Primary School">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Hero Subtitle</label>
                            <textarea name="hero_subtitle" id="heroSubtitle" class="form-input"
                                rows="3">Nurturing Excellence in Education in Gamatlala</textarea>
                        </div>
                    </div>
                    <div class="card">
                        <h3 style="margin-bottom: 1.5rem;">Hero Background</h3>
                        <div class="form-group">
                            <label class="form-label">Upload Hero Photo</label>
                            <input type="file" name="hero_image" id="heroImageInput" class="form-input" accept="image/*"
                                onchange="previewHeroImage(this)">
                            <p style="font-size: 0.8rem; color: var(--gray-500); margin-top: 0.5rem;">
                                Recommended size: 1920x1080px. Max size: 5MB.
                            </p>
                        </div>
                        <div class="hero-preview" id="heroPreview">
                            <span style="color: var(--gray-400);">No image selected (Using blue gradient)</span>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Staff Management Section -->
        <div id="staffSection" class="content-section" style="display: none;">
            <div class="header-actions" style="margin-bottom: 2rem;">
                <h2>Manage Staff</h2>
                <button class="btn btn-primary"
                    onclick="document.getElementById('addStaffForm').style.display='block'">Add New Teacher</button>
            </div>

            <!-- Add Staff Form (Hidden by default) -->
            <div id="addStaffForm" class="card"
                style="display: none; margin-bottom: 2rem; border: 2px solid var(--primary-blue);">
                <form action="add_staff.php" method="POST" enctype="multipart/form-data">
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <h3 style="margin: 0;">Add New Teacher</h3>
                        <button type="button" onclick="document.getElementById('addStaffForm').style.display='none'"
                            style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">✕</button>
                    </div>
                    <div class="grid grid-2">
                        <div class="form-group">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-input" required placeholder="e.g. Mr. John Doe">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Position</label>
                            <input type="text" name="position" class="form-input" required
                                placeholder="e.g. Senior Teacher">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Qualification</label>
                            <input type="text" name="qualification" class="form-input" placeholder="e.g. B.Ed. Honors">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Grade/Subject</label>
                            <input type="text" name="grade" class="form-input" placeholder="e.g. Grade 5 / Mathematics">
                        </div>
                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">Teacher Message</label>
                            <textarea name="message" class="form-input" rows="3"
                                placeholder="A short welcoming message..."></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Teacher Photo</label>
                            <input type="file" name="staff_image" class="form-input" accept="image/*">
                        </div>
                    </div>
                    <div style="margin-top: 1rem; text-align: right;">
                        <button type="submit" class="btn btn-primary">Save Teacher</button>
                    </div>
                </form>
            </div>
            <div class="card">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--gray-100); color: var(--gray-500);">
                            <th style="padding: 1rem;">Photo</th>
                            <th style="padding: 1rem;">Name</th>
                            <th style="padding: 1rem;">Position</th>
                            <th style="padding: 1rem;">Grade/Subject</th>
                            <th style="padding: 1rem;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($staff_members->num_rows > 0): ?>
                            <?php while($row = $staff_members->fetch_assoc()): ?>
                            <tr style="border-bottom: 1px solid var(--gray-100);">
                                <td style="padding: 1rem;">
                                    <?php if ($row['image_path']): ?>
                                        <img src="<?php echo $row['image_path']; ?>" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                    <?php else: ?>
                                        <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--primary-light); display: flex; align-items: center; justify-content: center;">👤</div>
                                    <?php endif; ?>
                                </td>
                                <td style="padding: 1rem;"><strong><?php echo htmlspecialchars($row['name']); ?></strong></td>
                                <td style="padding: 1rem;"><span class="staff-position" style="font-size: 0.75rem; padding: 0.25rem 0.5rem; margin: 0;"><?php echo htmlspecialchars($row['position']); ?></span></td>
                                <td style="padding: 1rem;"><?php echo htmlspecialchars($row['grade']); ?></td>
                                <td style="padding: 1rem;">
                                    <a href="delete_item.php?type=staff&id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this staff member?')" style="color: var(--accent-red); text-decoration: none; font-weight: 600;">Delete</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="padding: 2rem; text-align: center; color: var(--gray-500);">No staff members added yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Contacts Management Section -->
        <div id="contactsSection" class="content-section" style="display: none;">
            <div class="header-actions" style="margin-bottom: 2rem;">
                <h2>School Information & Contacts</h2>
                <button class="btn btn-primary">Save Changes</button>
            </div>
            <div class="grid grid-2">
                <div class="card">
                    <h3 style="margin-bottom: 1.5rem;">General Contact Info</h3>
                    <div class="form-group">
                        <label class="form-label">School Phone Number</label>
                        <input type="text" class="form-input" value="+27 XX XXX XXXX">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-input" value="info@sekgwariprimary.co.za">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Physical Address</label>
                        <textarea class="form-input" rows="3">Gamatlala, Limpopo</textarea>
                    </div>
                </div>
                <div class="card">
                    <h3 style="margin-bottom: 1.5rem;">Operating Hours</h3>
                    <div class="form-group">
                        <label class="form-label">Monday - Friday</label>
                        <input type="text" class="form-input" value="7:30 AM - 2:00 PM">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Special Announcement (Top Bar)</label>
                        <input type="text" class="form-input" placeholder="e.g. 📚 Learning Never Stops">
                    </div>
                </div>
            </div>
        </div>

        <!-- Gallery Management Section -->
        <div id="gallerySection" class="content-section" style="display: none;">
            <div class="header-actions" style="margin-bottom: 2rem;">
                <h2>Image Gallery</h2>
                <button class="btn btn-primary"
                    onclick="document.getElementById('uploadGalleryForm').style.display='block'">Upload New
                    Images</button>
            </div>

            <!-- Upload Gallery Form (Hidden by default) -->
            <div id="uploadGalleryForm" class="card"
                style="display: none; margin-bottom: 2rem; border: 2px solid var(--accent-gold);">
                <form action="add_gallery.php" method="POST" enctype="multipart/form-data">
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <h3 style="margin: 0;">Upload to Gallery</h3>
                        <button type="button"
                            onclick="document.getElementById('uploadGalleryForm').style.display='none'"
                            style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">✕</button>
                    </div>
                    <div class="grid grid-2">
                        <div class="form-group">
                            <label class="form-label">Select Photo</label>
                            <input type="file" name="gallery_image" class="form-input" accept="image/*" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Caption (Optional)</label>
                            <input type="text" name="caption" class="form-input" placeholder="e.g. Sports Day 2026">
                        </div>
                    </div>
                    <div style="margin-top: 1rem; text-align: right;">
                        <button type="submit" class="btn btn-primary" style="background: var(--accent-gold);">Upload
                            Now</button>
                    </div>
                </form>
            </div>

            <div class="card">
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem;">
                    <?php if ($gallery_items->num_rows > 0): ?>
                        <?php while($row = $gallery_items->fetch_assoc()): ?>
                        <div style="aspect-ratio: 1/1; background: var(--gray-100); border-radius: var(--radius-md); position: relative; overflow: hidden; border: 2px solid var(--gray-200);">
                            <img src="<?php echo $row['image_path']; ?>" style="width: 100%; height: 100%; object-fit: cover;">
                            <a href="delete_item.php?type=gallery&id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this image?')"
                                style="position: absolute; top: 5px; right: 5px; background: rgba(220, 38, 38, 0.8); color: white; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; border-radius: 4px; font-size: 0.75rem; cursor: pointer; text-decoration: none;">✕</a>
                        </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div style="grid-column: 1 / -1; padding: 2rem; text-align: center; color: var(--gray-500);">No gallery images uploaded yet.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <script>
        function showSection(sectionId) {
            // Hide all sections
            document.querySelectorAll('.content-section').forEach(section => {
                section.style.display = 'none';
            });

            // Show selected section
            const targetSection = document.getElementById(sectionId + 'Section');
            if (targetSection) {
                targetSection.style.display = 'block';
            }

            // Update Page Title
            const titleMap = {
                'dashboard': 'Dashboard',
                'staff': 'Manage Staff',
                'contacts': 'School Contacts',
                'gallery': 'Image Gallery',
                'news': 'News & Announcements',
                'homepage': 'Homepage Management'
            };

            const titleH1 = document.querySelector('#pageTitle h1');
            const titleP = document.querySelector('#pageTitle p');

            if (sectionId === 'dashboard') {
                titleH1.textContent = 'Welcome, Principal';
                titleP.textContent = 'Manage your school website content from here.';
            } else {
                titleH1.textContent = titleMap[sectionId] || 'Management';
                titleP.textContent = 'Review and update your school information.';
            }

            // Update Sidebar Active State
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
                if (link.textContent.toLowerCase().includes(sectionId)) {
                    link.classList.add('active');
                }
            });
        }

        // Initialize with dashboard
        document.addEventListener('DOMContentLoaded', () => {
            // Check for URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');
            const section = urlParams.get('section');

            if (status === 'success') {
                alert('Changes saved successfully!');
            }

            if (section) {
                showSection(section);
            }

            // Link sidebar clicks
            document.querySelectorAll('.nav-link').forEach(link => {
                const sectionName = link.querySelector('span:last-child').textContent.toLowerCase();
                if (sectionName !== 'logout') {
                    link.onclick = (e) => {
                        e.preventDefault();
                        showSection(sectionName);
                    };
                }
            });
        });

        function previewHeroImage(input) {
            const preview = document.getElementById('heroPreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Hero Preview">`;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function saveHeroSettings() {
            // This will be implemented with PHP/Backend
            const btn = event.target;
            const originalText = btn.textContent;
            btn.textContent = 'Saving...';
            btn.disabled = true;

            setTimeout(() => {
                alert('Success! Hero settings have been saved (Simulation). In a real environment, this would call update_settings.php');
                btn.textContent = originalText;
                btn.disabled = false;
            }, 1000);
        }
    </script>
</body>

</html>