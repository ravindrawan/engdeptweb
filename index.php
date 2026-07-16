<?php
if (strpos($_SERVER['HTTP_HOST'], 'www.') === 0) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $new_url = $protocol . str_replace('www.', '', $_SERVER['HTTP_HOST']) . $_SERVER['REQUEST_URI'];
    header("HTTP/1.1 301 Permanently");
    header("Location: " . $new_url);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- ====== SEO Meta Tags ====== -->
    <title>NWP Engineering Department | Home - Wayamba Province</title>
    <meta name="description" content="Official Web Portal of the North Western Province (NWP) Engineering Department, Sri Lanka. Providing modern technical advice, architectural designs, structural plans, and sustainable development infrastructure services in Wayamba.">
    <meta name="keywords" content="NWP Engineering Department, Wayamba Engineering, North Western Province, Kurunegala, Puttalam, Rate Books Sri Lanka, Type Plans, Government Engineering Sri Lanka, Civil Engineering Government, RTI 01 Form">
    <meta name="author" content="Digital Division - NWP">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph / Facebook (Social SEO) -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://<?php echo str_replace('www.', '', $_SERVER['HTTP_HOST']); ?>/">
    <meta property="og:title" content="NWP Engineering Department | Home - Wayamba Province">
    <meta property="og:description" content="Official Web Portal of the North Western Province Engineering Department. Access Rate Books, Type Plans, and Procurement Notices.">
    <meta property="og:image" content="Nwp_sri_lanka.jpg">

    <!-- ====== Fonts & Stylesheets ====== -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Noto+Sans+Sinhala:wght@400;600&family=Times+New+Roman&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css?v=18"> <!-- Cache busting updated to v=18 -->
</head>
<body>

    <!-- Top utility bar: Lang, Search, Login -->
    <div class="top-utility-bar">
        <div class="container utility-container">
            <div class="lang-selector" id="langSwitcher">
                <a href="#" class="active" data-lang="en">English</a> | 
                <a href="#" data-lang="si">සිංහල</a> | 
                <a href="#" data-lang="ta">தமிழ்</a>
            </div>
            
            <div class="utility-right">
                <div class="search-bar">
                    <input type="text" placeholder="Search ..." data-i18n-placeholder="placeholder_search">
                    <button aria-label="Search"><i class="fas fa-search"></i></button>
                </div>
                <a href="#" class="member-login-btn" id="loginBtn"><i class="fas fa-user-lock"></i><span data-i18n="btn_login"> Members Login</span></a>
            </div>
        </div>
    </div>

    <!-- Main Branding Header -->
    <header class="branding-header">
        <div class="container branding-container" onclick="window.location.href='index.php'" style="cursor:pointer;">
            <div class="all-logos">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5f/Emblem_of_Sri_Lanka.svg/200px-Emblem_of_Sri_Lanka.svg.png" alt="National Emblem of Sri Lanka" class="emblem" onerror="this.src='logo2.jpg'">
                <img src="Nwp_sri_lanka.jpg" alt="North Western Provincial Council Logo" class="emblem">
                <img src="office logo-Model.jpg.jpeg" alt="NWP Engineering Department Logo" class="emblem dept-logo" onerror="this.src='logo2.jpg'">
            </div>
            
            <div class="department-titles">
                <h1 class="eng-title">NWP ENGINEERING DEPARTMENT</h1>
                <h2 class="sin-title">වයඹ ඉංජිනේරු දෙපාර්තමේන්තුව</h2>
                <h3 class="tam-title">வடமேல் பொறியியல் திணைக்களம்</h3>
            </div>
        </div>
    </header>

    <!-- Horizontal Navigation Panel -->
    <nav class="horizontal-nav">
        <div class="container">
            <div class="hamburger">
                <i class="fas fa-bars"></i> Menu
            </div>
            <ul class="nav-menu">
                <li><a href="index.php" data-i18n="nav_home">Home</a></li>
                <li class="dropdown">
                    <a href="#"><span data-i18n="nav_about">About Us</span> <i class="fas fa-caret-down"></i></a>
                    <ul class="dropdown-content">
                        <li><a href="#" onclick="openAboutUsTab('overview')" data-i18n="nav_about_overview">Overview / Description</a></li>
                        <li><a href="#" onclick="openAboutUsTab('orgchart')" data-i18n="nav_about_orgchart">Organization Chart</a></li>
                        <li><a href="#" onclick="openAboutUsTab('objectives')" data-i18n="nav_about_objectives">Purpose & Objectives</a></li>
                        <li><a href="#" onclick="openAboutUsTab('achievements')" data-i18n="nav_about_achievements">Achievements</a></li>
                        <li><a href="#" onclick="openAboutUsTab('citizen')" data-i18n="nav_about_citizen">Citizen Chart</a></li>
                        <li><a href="#" onclick="openAboutUsTab('staff')" data-i18n="nav_about_staff">Staff Details</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#"><span data-i18n="nav_divisions">Divisions</span> <i class="fas fa-caret-down"></i></a>
                    <ul class="dropdown-content">
                        <li><a href="division.html?id=head-office" data-i18n="div_head_office">Head Office</a></li>
                        <li><a href="division.html?id=kurunegala" data-i18n="div_kurunegala">Kurunegala</a></li>
                        <li><a href="division.html?id=kuliyapitiya" data-i18n="div_kuliyapitiya">Kuliyapitiya</a></li>
                        <li><a href="division.html?id=maho" data-i18n="div_maho">Maho</a></li>
                        <li><a href="division.html?id=ridigama" data-i18n="div_ridigama">Ridigama</a></li>
                        <li><a href="division.html?id=wariyapola" data-i18n="div_wariyapola">Wariyapola</a></li>
                        <li class="division-07-item"><a href="division.html?id=puttalam" data-i18n="div_puttalam">Puttalam</a></li>
                        <li><a href="division.html?id=wennappuwa" data-i18n="div_wennappuwa">Wennappuwa</a></li>
                    </ul>
                </li>
                <li><a href="#" onclick="openServicesTab('investigations')" data-i18n="nav_services">Services</a></li>
                <li><a href="#" onclick="openProcurementsModal()" data-i18n="nav_procurement">Procurement Notices</a></li>
                <li class="dropdown">
                    <a href="#"><span data-i18n="nav_projects">Projects</span> <i class="fas fa-caret-down"></i></a>
                    <ul class="dropdown-content">
                        <li><a href="#" onclick="openProjectsTab('summary')" data-i18n="proj_summary">Project Summary</a></li>
                        <li><a href="#" onclick="openProjectsTab('key-projects')" data-i18n="proj_key">Key Projects Overview</a></li>
                        <li><a href="#" onclick="openCompletedProjectsModal()" data-i18n="proj_completed">Completed Projects</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#"><span data-i18n="nav_downloads">Downloads</span> <i class="fas fa-caret-down"></i></a>
                    <ul class="dropdown-content">
                        <li><a href="#" onclick="openDownloadsTab('rate_books')" data-i18n="dl_rate_books">Rate Books</a></li>
                        <li><a href="#" onclick="openDownloadsTab('type_plans')" data-i18n="dl_type_plans">Type Plans</a></li>
                        <li><a href="#" onclick="openDownloadsTab('progress_reports')" data-i18n="dl_progress_reports">Progress Reports</a></li>
                        <li><a href="#" onclick="openDownloadsTab('rti')" data-i18n="dl_rti">Right to Information Act</a></li>
                    </ul>
                </li>
                <li><a href="#" onclick="openGalleryModal()" data-i18n="nav_gallery">Gallery</a></li>
                <li><a href="#contact" data-i18n="nav_contact">Contact Us</a></li>
            </ul>
        </div>
    </nav>

    <!-- Banner (Auto Changing) -->
    <section class="main-banner">
        <div class="banner-slider" id="homeSlider">
            <div class="slide active" style="background-image: url('slider1.jpg');"></div>
            <div class="slide" data-bg="slider2.jpg"></div>
            <div class="slide" data-bg="slider3.jpg"></div>
            <div class="slide" data-bg="slider4.jpg"></div>
            <div class="slide" data-bg="slider5.jpg"></div>
        </div>
        <div class="banner-controls">
            <button id="prevBtn" aria-label="Previous Slide"><i class="fas fa-chevron-left"></i></button>
            <button id="nextBtn" aria-label="Next Slide"><i class="fas fa-chevron-right"></i></button>
        </div>
    </section>

    <!-- Welcome Strip -->
    <div class="welcome-strip">
        <div class="container">
            <marquee behavior="scroll" direction="left" scrollamount="5" onmouseover="this.stop();" onmouseout="this.start();">
                <i class="fas fa-bullhorn" style="color: #fbbf24; margin-right: 10px;"></i> 
                <span id="newsBarText" data-i18n="welcome_strip_text"><strong>Welcome to the Official Web Portal of the North Western Province Engineering Department</strong> - Providing modern technical advice and sustainable development through architectural and engineering design.</span>
            </marquee>
        </div>
    </div>

    <!-- Content Sections -->
    <section class="main-content container">
        <div class="content-grid">
            
            <!-- Left Column -->
            <div class="left-col">
                <div class="vm-section boxed-panel beautiful-vm" id="vision">
                    <div class="vm-item vision-card">
                        <div class="vm-icon"><i class="fas fa-eye"></i></div>
                        <div class="vm-content">
                            <div class="vm-title" data-i18n="lbl_vision">Vision</div>
                            <div class="vm-text" data-i18n="vm_vision_text">Being the Engineering Strength for Sustainable Development of Wayamba Province.</div>
                        </div>
                    </div>
                    <div class="vm-divider"></div>
                    <div class="vm-item mission-card">
                        <div class="vm-icon"><i class="fas fa-bullseye"></i></div>
                        <div class="vm-content">
                            <div class="vm-title" data-i18n="lbl_mission">Mission</div>
                            <div class="vm-text" data-i18n="vm_mission_text">Providing modern technical advice and services for proud sustainable development through architectural and engineering design and planning that preserves the aesthetic and proudness of Wayamba.</div>
                        </div>
                    </div>
                </div>

                <div class="announcements boxed-panel">
                    <h3 class="panel-header" data-i18n="heading_announcements">Announcements</h3>
                    <div class="announcement-tabs" id="announcementTabs">
                        <button class="tab-btn active" data-tab="internal" data-i18n="tab_internal">Internal</button>
                        <button class="tab-btn" data-tab="outside" data-i18n="tab_outside">Outside</button>
                    </div>
                    <div class="announcement-content">
                        <marquee direction="up" scrollamount="2" height="350px" onmouseover="this.stop();" onmouseout="this.start();">
                            <ul class="announcement-list" id="announcementsList">
                                <!-- Dynamically loaded -->
                            </ul>
                        </marquee>
                    </div>
                </div>

                <div class="boxed-panel">
                    <h3 class="panel-header"><span>Divisional Engineers Divisions Map</span> <i class="fas fa-map-marked-alt"></i></h3>
                    <div style="padding: 10px;">
                        <img src="divisional_map.jpg"
                             alt="Map of NWP Divisional Engineers Divisions"
                             style="width:100%; height:auto; border-radius:8px; display:block; border:1px solid #e2e8f0; cursor:pointer;"
                             onclick="this.requestFullscreen ? this.requestFullscreen() : window.open(this.src,'_blank')"
                             title="Click to view full size">
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="right-col">
                <div class="news-section boxed-panel" id="news">
                    <h3 class="panel-header"><span data-i18n="heading_news">Latest News</span> <i class="fas fa-newspaper"></i></h3>
                    <div class="announcement-tabs" id="newsTabs">
                        <button class="tab-btn active" data-tab="dept-news" data-i18n="tab_dept">Department</button>
                        <button class="tab-btn" data-tab="prov-news" data-i18n="tab_prov">Provincial</button>
                    </div>
                    <div class="news-slider">
                        <marquee direction="up" scrollamount="2" height="450px" id="newsList" onmouseover="this.stop();" onmouseout="this.start();">
                            <!-- Dynamically loaded -->
                        </marquee>
                    </div>
                </div>

                <div class="courses-section boxed-panel">
                    <h3 class="panel-header"><span data-i18n="heading_courses">PD COURSES / IESL EVENTS</span> <i class="fas fa-graduation-cap"></i></h3>
                    <div class="announcement-tabs" id="coursesTabs">
                        <button class="tab-btn active" data-tab="upcoming" data-i18n="tab_upcoming">Upcoming</button>
                        <button class="tab-btn" data-tab="completed" data-i18n="tab_completed_courses">Completed</button>
                    </div>
                    <ul class="courses-list" id="coursesList">
                        <!-- Dynamically loaded -->
                    </ul>
                </div>

                <div class="links-section boxed-panel">
                    <h3 class="panel-header"><span data-i18n="heading_links">Important Links</span> <i class="fas fa-external-link-alt"></i></h3>
                    <div class="announcement-tabs" id="linksTabs">
                        <button class="tab-btn active" data-tab="govt-links" data-i18n="tab_govt">Government</button>
                        <button class="tab-btn" data-tab="tech-links" data-i18n="tab_eng">Engineering</button>
                    </div>
                    <ul class="external-links" id="linksList">
                        <!-- Dynamically loaded -->
                    </ul>
                </div>

                <div class="feedback-section boxed-panel" id="feedback">
                    <h3 class="panel-header"><span data-i18n="heading_feedback">Suggestions &amp; Feedback</span> <i class="fas fa-comment-dots"></i></h3>
                    <div style="padding: 18px 20px;">
                        <form id="feedbackForm" onsubmit="submitFeedback(event)">
                            <div class="responsive-grid-2" style="margin-bottom:12px;">
                                <div>
                                    <label for="fbName" style="display:block; font-size:0.8rem; font-weight:600; color:#475569; margin-bottom:5px;" data-i18n="lbl_fb_name">Your Name</label>
                                    <input type="text" id="fbName" placeholder="Full Name" required
                                        style="width:100%; padding:9px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.88rem; outline:none; transition:border-color 0.2s;"
                                        onfocus="this.style.borderColor='var(--accent-gold)'" onblur="this.style.borderColor='#e2e8f0'">
                                </div>
                                <div>
                                    <label for="fbEmail" style="display:block; font-size:0.8rem; font-weight:600; color:#475569; margin-bottom:5px;" data-i18n="lbl_fb_email">Email (Optional)</label>
                                    <input type="email" id="fbEmail" placeholder="email@example.com"
                                        style="width:100%; padding:9px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.88rem; outline:none; transition:border-color 0.2s;"
                                        onfocus="this.style.borderColor='var(--accent-gold)'" onblur="this.style.borderColor='#e2e8f0'">
                                </div>
                            </div>

                            <div style="margin-bottom:12px;">
                                <label style="display:block; font-size:0.8rem; font-weight:600; color:#475569; margin-bottom:6px;" data-i18n="lbl_fb_rating">Rating</label>
                                <div class="star-rating" id="starRating" style="display:flex; gap:6px;">
                                    <i class="fas fa-star fb-star" data-val="1" style="font-size:1.4rem; color:#cbd5e1; cursor:pointer; transition:color 0.2s;"></i>
                                    <i class="fas fa-star fb-star" data-val="2" style="font-size:1.4rem; color:#cbd5e1; cursor:pointer; transition:color 0.2s;"></i>
                                    <i class="fas fa-star fb-star" data-val="3" style="font-size:1.4rem; color:#cbd5e1; cursor:pointer; transition:color 0.2s;"></i>
                                    <i class="fas fa-star fb-star" data-val="4" style="font-size:1.4rem; color:#cbd5e1; cursor:pointer; transition:color 0.2s;"></i>
                                    <i class="fas fa-star fb-star" data-val="5" style="font-size:1.4rem; color:#cbd5e1; cursor:pointer; transition:color 0.2s;"></i>
                                </div>
                                <input type="hidden" id="fbRating" value="0">
                            </div>

                            <div style="margin-bottom:12px;">
                                <label for="fbMessage" style="display:block; font-size:0.8rem; font-weight:600; color:#475569; margin-bottom:5px;" data-i18n="lbl_fb_message">Message / Suggestion</label>
                                <textarea id="fbMessage" rows="3" required placeholder="Write your suggestion or feedback here..."
                                    style="width:100%; padding:9px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.88rem; outline:none; resize:vertical; transition:border-color 0.2s; font-family:inherit;"></textarea>
                            </div>

                            <div id="fbMsg" style="display:none; font-size:0.85rem; padding:8px 12px; border-radius:8px; margin-bottom:10px;"></div>

                            <button type="submit"
                                style="width:100%; padding:10px; background:linear-gradient(135deg,var(--primary-blue),#1e3a8a); color:white; border:none; border-radius:8px; font-size:0.92rem; font-weight:600; cursor:pointer; letter-spacing:0.5px; transition:all 0.3s; display:flex; align-items:center; justify-content:center; gap:8px;"
                                onmouseover="this.style.background='linear-gradient(135deg,var(--accent-gold),#c59b27)'; this.style.color='var(--primary-blue)'"
                                onmouseout="this.style.background='linear-gradient(135deg,var(--primary-blue),#1e3a8a)'; this.style.color='white'">
                                <i class="fas fa-paper-plane"></i> <span data-i18n="btn_submit_feedback">Submit Feedback</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="main-footer" id="contact">
        <div class="container footer-grid">
            <div class="footer-box">
                <h4 data-i18n="footer_divs">Divisions Links</h4>
                <ul class="footer-list">
                    <li><a href="division.html?id=head-office" data-i18n="div_head_office">Head Office</a></li>
                    <li><a href="division.html?id=kurunegala" data-i18n="div_kurunegala_div">Kurunegala Division</a></li>
                    <li><a href="division.html?id=kuliyapitiya" data-i18n="div_kuliyapitiya_div">Kuliyapitiya Division</a></li>
                    <li><a href="division.html?id=maho" data-i18n="div_maho_div">Maho Division</a></li>
                    <li><a href="division.html?id=ridigama" data-i18n="div_ridigama_div">Ridigama Division</a></li>
                    <li><a href="division.html?id=wariyapola" data-i18n="div_wariyapola_div">Wariyapola Division</a></li>
                    <li class="division-07-item"><a href="division.html?id=puttalam" data-i18n="div_puttalam_div">Puttalam Division</a></li>
                    <li><a href="division.html?id=wennappuwa" data-i18n="div_wennappuwa_div">Wennappuwa Division</a></li>
                </ul>
            </div>
            
            <div class="footer-box">
                <h4 data-i18n="footer_contact">Contact Us</h4>
                <ul class="footer-list">
                    <li id="footerContactAddress"><i class="fas fa-map-marker-alt"></i> Department of Engineering, NWP, Kurunegala</li>
                    <li id="footerContactPhone"><i class="fas fa-phone"></i> +94 37 222 0000</li>
                    <li id="footerContactEmail"><i class="fas fa-envelope"></i> info@nwpeng.gov.lk</li>
                </ul>
            </div>
            
            <div class="footer-box map-box">
                <h4 data-i18n="footer_map">Location Map</h4>
                <div class="map-placeholder">
                    <iframe id="footerContactMap" title="NWP Engineering Department Location Map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126490.13327670732!2d80.28841443690623!3d7.494747385966427!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae33a1e944b419b%3A0xe542385cc820b924!2sKurunegala!5e0!3m2!1sen!2slk!4v1714207907572!5m2!1sen!2slk" width="100%" height="150" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
        
        <div class="visitor-counter text-center p-3" style="background-color: #0b1528;">
            <div class="container d-flex justify-content-between align-items-center">
                <span><span data-i18n="footer_visitors">Total Visitors: </span><span id="visitorCountBadge" class="badge" style="background:#8b1c1c; padding: 5px 10px; border-radius: 5px;">0 0 1 4 5 8</span></span>
                <span data-i18n="footer_powered">Powered by Digital Division - NWP © 2026</span>
            </div>
        </div>
    </footer>

    <!-- Modals (Login, Projects, Completed Projects, Downloads) -->
    <div class="modal" id="loginModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-lock" style="margin-right:8px; color:var(--accent-gold);"></i> <span data-i18n="modal_login_title">System Access</span></h2>
                <span class="close-btn" id="closeModal">&times;</span>
            </div>
            <div class="modal-body">
                <form id="loginForm">
                    <div class="form-group">
                        <label for="username" data-i18n="lbl_username">Officer ID / Username</label>
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" id="username" class="form-control" placeholder="Enter username" data-i18n-placeholder="placeholder_username">
                    </div>
                    <div class="form-group">
                        <label for="password" data-i18n="lbl_password">Access Credential</label>
                        <i class="fas fa-key input-icon"></i>
                        <input type="password" id="password" class="form-control" placeholder="Enter password" data-i18n-placeholder="placeholder_password">
                    </div>
                    <div class="error-msg" id="errorMsg" style="display:none; color: #dc2626; margin-bottom: 15px; font-size: 0.9em; font-weight: 500; background: #fee2e2; padding: 10px; border-radius: 5px;"><i class="fas fa-exclamation-circle"></i> <span data-i18n="login_error">Invalid credentials provided.</span></div>
                    <button type="submit" class="login-submit-btn"><span data-i18n="btn_authenticate">Authenticate</span> <i class="fas fa-arrow-right" style="margin-left:5px;"></i></button>
                    <p style="text-align: center; margin-top: 15px; font-size: 0.8rem; color: #94a3b8;" data-i18n="login_restricted">Restricted Access for Authorized NWP Personnel Only</p>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="projectsModal">
        <div class="modal-content about-modal-content">
            <div class="modal-header">
                <h2 data-i18n="modal_projects_title">Departmental Projects</h2>
                <span class="close-btn" id="closeProjectsModal">&times;</span>
            </div>
            <div class="modal-body about-modal-body">
                <aside class="sidebar about-sidebar">
                    <ul class="sidebar-nav">
                        <li><a href="#" class="projects-tab-btn active" data-tab="summary"><i class="fas fa-chart-pie"></i> <span data-i18n="proj_summary">Project Summary</span></a></li>
                        <li><a href="#" class="projects-tab-btn" data-tab="key-projects"><i class="fas fa-hammer"></i> <span data-i18n="proj_key">Key Projects</span></a></li>
                    </ul>
                </aside>
                <main class="content-area about-content-area">
                    <div id="ptab-summary" class="projects-pane" style="display:block;">
                        <h2 class="content-title" data-i18n="proj_summary">Project Summary</h2>
                        <p data-i18n="proj_summary_desc">Total project counts and financial summaries for the current year.</p>
                    </div>
                    <div id="ptab-key-projects" class="projects-pane" style="display:none;">
                        <h2 class="content-title" data-i18n="proj_key">Key Ongoing Projects</h2>
                        <p data-i18n="proj_key_desc">Major infrastructure and building projects currently in progress.</p>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <div class="modal" id="completedProjectsModal">
        <div class="modal-content about-modal-content" style="max-width: 900px; height: 80vh; max-height: 700px;">
            <div class="modal-header">
                <h2 data-i18n="proj_completed">Completed Projects</h2>
                <span class="close-btn" id="closeCompletedProjectsModal">&times;</span>
            </div>
            <div class="modal-body" style="padding: 25px 30px; overflow-y: auto; height: calc(100% - 70px);">
                <p style="color: #64748b; margin-bottom: 20px; font-size: 0.95rem;" data-i18n="proj_completed_desc">Archive of recently completed civil engineering projects.</p>
                <div id="completedProjectsListContainer" style="display: flex; flex-direction: column; gap: 20px;">
                    <!-- Dynamically loaded completed projects -->
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="downloadsModal">
        <div class="modal-content about-modal-content">
            <div class="modal-header">
                <h2 data-i18n="modal_downloads_title">Document Downloads</h2>
                <span class="close-btn" id="closeDownloadsModal">&times;</span>
            </div>
            <div class="modal-body about-modal-body">
                <aside class="sidebar about-sidebar">
                    <ul class="sidebar-nav">
                        <li><a href="#" class="downloads-tab-btn active" data-tab="rate_books"><i class="fas fa-book"></i> <span data-i18n="dl_rate_books">Rate Books</span></a></li>
                        <li><a href="#" class="downloads-tab-btn" data-tab="type_plans"><i class="fas fa-drafting-compass"></i> <span data-i18n="dl_type_plans">Type Plans</span></a></li>
                        <li><a href="#" class="downloads-tab-btn" data-tab="progress_reports"><i class="fas fa-chart-line"></i> <span data-i18n="dl_progress_reports">Progress Reports</span></a></li>
                        <li><a href="#" class="downloads-tab-btn" data-tab="rti"><i class="fas fa-info-circle"></i> <span data-i18n="dl_rti">Right to Information Act</span></a></li>
                    </ul>
                </aside>
                <main class="content-area about-content-area">
                    <div id="dtab-rate_books" class="downloads-pane" style="display:block;">
                        <h2 class="content-title" data-i18n="dl_rate_books">Rate Books</h2>
                        <p data-i18n="dl_rate_books_desc">Standard provincial rate books for engineering estimation.</p>
                        <div class="downloads-list" id="rate_books-list" style="margin-top: 15px;"></div>
                    </div>
                    <div id="dtab-type_plans" class="downloads-pane" style="display:none;">
                        <h2 class="content-title" data-i18n="dl_type_plans">Type Plans</h2>
                        <p data-i18n="dl_type_plans_desc">Standard architectural and engineering type plans.</p>
                        <div class="downloads-list" id="type_plans-list" style="margin-top: 15px;"></div>
                    </div>
                    <div id="dtab-progress_reports" class="downloads-pane" style="display:none;">
                        <h2 class="content-title" data-i18n="dl_progress_reports">Progress Reports</h2>
                        <p data-i18n="dl_progress_reports_desc">Monthly and annual progress reports of department projects.</p>
                        <div class="downloads-list" id="progress_reports-list" style="margin-top: 15px;"></div>
                    </div>
                    <div id="dtab-rti" class="downloads-pane" style="display:none;">
                        <h2 class="content-title" data-i18n="dl_rti">Right to Information Act</h2>
                        <p data-i18n="dl_rti_desc">Guidelines, request forms, and disclosures under the RTI Act.</p>
                        
                        <!-- Fixed RTI Form Layout -->
                        <div id="rti-application-download-container" style="margin-bottom: 25px;">
                            <div class="download-item" style="background: rgba(212, 175, 55, 0.1); border: 1px solid #d4af37; border-radius: 12px; padding: 15px; display: flex; justify-content: space-between; align-items: center; gap: 15px; flex-wrap: wrap;">
                                <div class="download-info" style="display: flex; align-items: center; gap: 15px; flex: 1; min-width: 200px;">
                                    <div class="icon-box" style="background: #d4af37; color: #0b1528; width: 45px; height: 45px; border-radius: 10px; display: flex; justify-content: center; align-items: center; font-size: 1.3rem;"><i class="fas fa-file-pdf"></i></div>
                                    <div class="dl-text" style="text-align: left;">
                                        <strong style="color: #1e3a8a; font-size: 1.05rem;" data-i18n="lbl_rti_application_title">Official RTI Application Form (RTI 01)</strong>
                                        <p style="margin: 3px 0 0 0; font-size: 0.85rem; color: #475569;" data-i18n="lbl_rti_application_desc">Download the official application form to request information under the RTI Act.</p>
                                    </div>
                                </div>
                                <a id="rti-application-download-link" href="#" class="dl-btn" style="text-decoration:none; background: #d4af37; color: #0b1528; padding: 10px 20px; border-radius: 30px; font-weight:600; font-size:0.9rem;">Download PDF</a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

</body>
</html>
