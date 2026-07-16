<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NWP Engineering Department | Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Noto+Sans+Sinhala:wght@400;600&family=Times+New+Roman&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css?v=17">
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
                    <button><i class="fas fa-search"></i></button>
                </div>
                <a href="#" class="member-login-btn" id="loginBtn"><i class="fas fa-user-lock"></i><span data-i18n="btn_login"> Members Login</span></a>
            </div>
        </div>
    </div>

    <!-- Main Branding Header -->
    <header class="branding-header">
        <div class="container branding-container" onclick="window.location.href='index.html'" style="cursor:pointer;">
            <div class="all-logos">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5f/Emblem_of_Sri_Lanka.svg/200px-Emblem_of_Sri_Lanka.svg.png" alt="National Logo" class="emblem" onerror="this.src='logo2.jpg'">
                <img src="Nwp_sri_lanka.jpg" alt="Provincial Logo" class="emblem">
                <img src="office logo-Model.jpg.jpeg" alt="Department Logo" class="emblem dept-logo" onerror="this.src='logo2.jpg'">
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
                <li><a href="index.html" data-i18n="nav_home">Home</a></li>
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
            <!-- Slides using the provided images -->
            <div class="slide active" style="background-image: url('slider1.jpg');"></div>
            <div class="slide" data-bg="slider2.jpg"></div>
            <div class="slide" data-bg="slider3.jpg"></div>
            <div class="slide" data-bg="slider4.jpg"></div>
            <div class="slide" data-bg="slider5.jpg"></div>
        </div>
        <div class="banner-controls">
            <button id="prevBtn"><i class="fas fa-chevron-left"></i></button>
            <button id="nextBtn"><i class="fas fa-chevron-right"></i></button>
        </div>
    </section>

    <!-- Welcome Strip -->
    <div class="welcome-strip">
        <div class="container">
            <marquee behavior="scroll" direction="left" scrollamount="5">
                <i class="fas fa-bullhorn" style="color: #fbbf24; margin-right: 10px;"></i> 
                <span id="newsBarText" data-i18n="welcome_strip_text"><strong>Welcome to the Official Web Portal of the North Western Province Engineering Department</strong> - Providing modern technical advice and sustainable development through architectural and engineering design.</span>
            </marquee>
        </div>
    </div>

    <!-- Content Sections (Vision, Mission, Announcements, News) -->
    <section class="main-content container">
        <div class="content-grid">
            
            <!-- Left Column: Vision/Mission & Announcements -->
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
                        <marquee direction="up" scrollamount="2" height="350px">
                            <ul class="announcement-list" id="announcementsList">
                                <!-- Dynamically loaded -->
                            </ul>
                        </marquee>
                    </div>
                </div>

                <!-- Divisional Engineers Divisions Map -->
                <div class="boxed-panel">
                    <h3 class="panel-header"><span>Divisional Engineers Divisions</span> <i class="fas fa-map-marked-alt"></i></h3>
                    <div style="padding: 10px;">
                        <img src="divisional_map.jpg"
                             alt="Divisional Engineers Divisions Map"
                             style="width:100%; height:auto; border-radius:8px; display:block; border:1px solid #e2e8f0; cursor:pointer;"
                             onclick="this.requestFullscreen ? this.requestFullscreen() : window.open(this.src,'_blank')"
                             title="Click to view full size">
                    </div>
                </div>

            </div>

            <!-- Right Column: Latest News & Important Links -->
            <div class="right-col">
                <div class="news-section boxed-panel" id="news">
                    <h3 class="panel-header"><span data-i18n="heading_news">Latest News</span> <i class="fas fa-newspaper"></i></h3>
                    <div class="announcement-tabs" id="newsTabs">
                        <button class="tab-btn active" data-tab="dept-news" data-i18n="tab_dept">Department</button>
                        <button class="tab-btn" data-tab="prov-news" data-i18n="tab_prov">Provincial</button>
                    </div>
                    <div class="news-slider">
                        <marquee direction="up" scrollamount="2" height="450px" id="newsList">
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

                <!-- Suggestions & Feedback Box -->
                <div class="feedback-section boxed-panel" id="feedback">
                    <h3 class="panel-header"><span data-i18n="heading_feedback">Suggestions &amp; Feedback</span> <i class="fas fa-comment-dots"></i></h3>
                    <div style="padding: 18px 20px;">
                        <form id="feedbackForm" onsubmit="submitFeedback(event)">
                            <div class="responsive-grid-2" style="margin-bottom:12px;">
                                <div>
                                    <label style="display:block; font-size:0.8rem; font-weight:600; color:#475569; margin-bottom:5px;" data-i18n="lbl_fb_name">Your Name</label>
                                    <input type="text" id="fbName" placeholder="Full Name" required
                                        style="width:100%; padding:9px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.88rem; outline:none; transition:border-color 0.2s;"
                                        onfocus="this.style.borderColor='var(--accent-gold)'" onblur="this.style.borderColor='#e2e8f0'">
                                </div>
                                <div>
                                    <label style="display:block; font-size:0.8rem; font-weight:600; color:#475569; margin-bottom:5px;" data-i18n="lbl_fb_email">Email (Optional)</label>
                                    <input type="email" id="fbEmail" placeholder="email@example.com"
                                        style="width:100%; padding:9px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.88rem; outline:none; transition:border-color 0.2s;"
                                        onfocus="this.style.borderColor='var(--accent-gold)'" onblur="this.style.borderColor='#e2e8f0'">
                                </div>
                            </div>

                            <!-- Star Rating -->
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
                                <label style="display:block; font-size:0.8rem; font-weight:600; color:#475569; margin-bottom:5px;" data-i18n="lbl_fb_message">Message / Suggestion</label>
                                <textarea id="fbMessage" rows="3" required placeholder="Write your suggestion or feedback here..."
                                    style="width:100%; padding:9px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.88rem; outline:none; resize:vertical; transition:border-color 0.2s; font-family:inherit;"
                                    onfocus="this.style.borderColor='var(--accent-gold)'" onblur="this.style.borderColor='#e2e8f0'"></textarea>
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

    <!-- Map & Footer Details -->
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
                    <!-- Standard Google map embed placeholder -->
                    <iframe id="footerContactMap" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126490.13327670732!2d80.28841443690623!3d7.494747385966427!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae33a1e944b419b%3A0xe542385cc820b924!2sKurunegala!5e0!3m2!1sen!2slk!4v1714207907572!5m2!1sen!2slk" width="100%" height="150" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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



    <!-- Member Login Modal -->
    <div class="modal" id="loginModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-lock" style="margin-right:8px; color:var(--accent-gold);"></i> <span data-i18n="modal_login_title">System Access</span></h2>
                <span class="close-btn" id="closeModal">&times;</span>
            </div>
            <div class="modal-body">
                <form id="loginForm">
                    <div class="form-group">
                        <label data-i18n="lbl_username">Officer ID / Username</label>
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" id="username" class="form-control" placeholder="Enter username" data-i18n-placeholder="placeholder_username">
                    </div>
                    <div class="form-group">
                        <label data-i18n="lbl_password">Access Credential</label>
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

    <!-- Projects Modal (Split Layout) -->
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

    <!-- Completed Projects Modal -->
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

    <!-- Downloads Modal (Split Layout) -->
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
                        
                        <!-- Prominent RTI Form Download Button -->
                        <div id="rti-application-download-container" style="margin-bottom: 25px; display: none;">
                            <div class="download-item" style="background: rgba(212, 175, 55, 0.1); border: 1px solid var(--accent-gold); border-radius: 12px; padding: 15px; display: flex; justify-content: space-between; align-items: center; gap: 15px; flex-wrap: wrap;">
                                <div class="download-info" style="display: flex; align-items: center; gap: 15px; flex: 1; min-width: 200px;">
                                    <div class="icon-box" style="background: var(--accent-gold); color: var(--portal-dark); width: 45px; height: 45px; border-radius: 10px; display: flex; justify-content: center; align-items: center; font-size: 1.3rem;"><i class="fas fa-file-pdf"></i></div>
                                    <div class="dl-text" style="text-align: left;">
                                        <strong style="color: var(--portal-blue); font-size: 1.05rem;" data-i18n="lbl_rti_application_title">Official RTI Application Form (RTI 01)</strong>
                                        <p style="margin: 3px 0 0 0; font-size: 0.85rem; color: #475569;" data-i18n="lbl_rti_application_desc">Download the official application form to request information under the RTI Act.</p>
                                    </div>
                                </div>
                                <a id="rti-application-download-link" href="#" class="dl-btn" style="text-decoration:none; background: var(--accent-gold); color: var(--portal-dark); padding: 10px 20px; border-radius: 30px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; font-size: 0.9rem;" download>
                                    <i class="fas fa-cloud-download-alt"></i> <span data-i18n="btn_download">Download</span>
                                </a>
                            </div>
                        </div>

                        <div class="downloads-list" id="rti-list" style="margin-top: 15px;"></div>
                        
                        <!-- RTI Officers Section -->
                        <div class="rti-officers-section" style="margin-top: 30px; border-top: 1px dashed #cbd5e1; padding-top: 20px;">
                            <h3 style="font-size: 1.2rem; color: var(--primary-blue); font-weight: 600; margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-user-shield"></i> <span data-i18n="heading_rti_officers">Right to Information (RTI) Officers</span>
                            </h3>
                            <div id="rti-officers-container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
                                <!-- Dynamically loaded from script.js -->
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- About Us Modal (In-Page Split Layout) -->
    <div class="modal" id="aboutUsModal">
        <div class="modal-content about-modal-content">
            <div class="modal-header">
                <h2 data-i18n="modal_about_title">About the Department</h2>
                <span class="close-btn" id="closeAboutModal">&times;</span>
            </div>
            <div class="modal-body about-modal-body">
                <aside class="sidebar about-sidebar">
                    <ul class="sidebar-nav">
                        <li><a href="#" class="about-tab-btn active" data-tab="overview"><i class="fas fa-align-left"></i> <span data-i18n="nav_about_overview">Overview / Description</span></a></li>
                        <li><a href="#" class="about-tab-btn" data-tab="orgchart"><i class="fas fa-sitemap"></i> <span data-i18n="nav_about_orgchart">Organization Chart</span></a></li>
                        <li><a href="#" class="about-tab-btn" data-tab="objectives"><i class="fas fa-bullseye"></i> <span data-i18n="nav_about_objectives">Purpose & Objectives</span></a></li>
                        <li><a href="#" class="about-tab-btn" data-tab="achievements"><i class="fas fa-trophy"></i> <span data-i18n="nav_about_achievements">Achievements</span></a></li>
                        <li><a href="#" class="about-tab-btn" data-tab="citizen"><i class="fas fa-file-alt"></i> <span data-i18n="nav_about_citizen">Citizen Chart</span></a></li>
                        <li><a href="#" class="about-tab-btn" data-tab="staff"><i class="fas fa-users-gear"></i> <span data-i18n="nav_about_staff">Staff Details</span></a></li>
                    </ul>
                </aside>
                <main class="content-area about-content-area">
                    <div id="tab-overview" class="about-pane" style="display:block;">
                        <h2 class="content-title" data-i18n="nav_about_overview">Overview / Description</h2>
                        <p id="aboutOverviewText">The NWP Engineering Department is a multidisciplinary consultancy body committed to delivering efficient, sustainable, and innovative engineering solutions for government building projects. We deliver end-to-end solutions including planning, architectural, structural and MEP design, cost estimation, procurement support, contract administration and construction supervision for public facilities such as schools, hospitals and administrative buildings.</p>
                    </div>
                    <div id="tab-orgchart" class="about-pane" style="display:none;">
                        <h2 class="content-title" data-i18n="nav_about_orgchart">Department Organizational Chart</h2>
                        <div style="text-align: center;">
                            <a href="DEPARTMENT ORGANISATION CHRT 1-Model.jpg (1).jpeg" target="_blank" title="Click to view full size">
                                <img src="DEPARTMENT ORGANISATION CHRT 1-Model.jpg (1).jpeg" alt="Organizational Chart" style="max-width:100%; height:auto; border-radius:5px; border:1px solid #ddd;">
                            </a>
                        </div>
                    </div>
                    <div id="tab-objectives" class="about-pane" style="display:none;">
                        <h2 class="content-title" data-i18n="nav_about_objectives">Purpose & Objectives</h2>
                        <p id="aboutObjectivesText">Provincial Engineering Department as a provincial organization aims primarily to conduct a general business of consultancy management and specialty service for the investigations survey study, planning and consulting of building projects undertakings either alone or jointly with other corporations or entities.</p>
                    </div>
                    <div id="tab-achievements" class="about-pane" style="display:none;">
                        <h2 class="content-title" data-i18n="nav_about_achievements">Achievements</h2>
                        <div id="achievementsListContainer" style="display: flex; flex-direction: column; gap: 20px;">
                            <!-- Dynamically loaded multiple achievements -->
                        </div>
                    </div>
                    <div id="tab-citizen" class="about-pane" style="display:none;">
                        <h2 class="content-title" data-i18n="citizen_charter_title">Citizen's Charter Downloads</h2>
                        <p data-i18n="citizen_charter_desc">Please click on the links below to download the relevant Citizen's Charter details in varying formats.</p>
                        <ul class="announcement-list">
                            <li><a href="පුරවැසි ප්_රඥප්තිය  Sinhala.xlsx" download><i class="fas fa-file-excel" style="color: green;"></i> <span data-i18n="citizen_charter_si_xlsx">Citizen's Charter (Sinhala) - Excel</span></a></li>
                            <li><a href="පුරවැසි  Tamil.xlsx" download><i class="fas fa-file-excel" style="color: green;"></i> <span data-i18n="citizen_charter_ta_xlsx">Citizen's Charter (Tamil) - Excel</span></a></li>
                            <li><a href="පුරුවැසි ප්_රඥප්තිය අවසන් පිටුව සිංහල.docx" download><i class="fas fa-file-word" style="color: blue;"></i> <span data-i18n="citizen_charter_si_docx">Citizen's Charter Final Page (Sinhala)</span></a></li>
                            <li><a href="පුරවැසි ප්_රඥප්තිය අවසන් පිටුව දෙමළ.docx" download><i class="fas fa-file-word" style="color: blue;"></i> <span data-i18n="citizen_charter_ta_docx">Citizen's Charter Final Page (Tamil)</span></a></li>
                            <li><a href="පුරුවැසි ප්_රඥප්තිය අවසන් පිටුව ඉංග්_රීසි Amended.docx" download><i class="fas fa-file-word" style="color: blue;"></i> <span data-i18n="citizen_charter_en_docx">Citizen's Charter Final Page (English)</span></a></li>
                        </ul>
                    </div>
                    <div id="tab-staff" class="about-pane" style="display:none;">
                        <h2 class="content-title" data-i18n="nav_about_staff">Staff Details</h2>
                        <div class="premium-table-wrapper">
                            <table class="premium-table">
                                <thead>
                                    <tr>
                                        <th data-i18n="col_ser">Ser No</th>
                                        <th data-i18n="col_name">Full Name</th>
                                        <th data-i18n="col_designation">Designation</th>
                                        <th data-i18n="col_institution">Institution</th>
                                        <th data-i18n="col_email">Email</th>
                                    </tr>
                                </thead>
                                <tbody id="aboutStaffTableBody">
                                    <tr>
                                        <td>1</td>
                                        <td><strong>T H M D C E Peiris</strong></td>
                                        <td>Provincial Director</td>
                                        <td>Head Office</td>
                                        <td><a href="mailto:peirishmd@yahoo.com"><i class="far fa-envelope"></i> peirishmd@yahoo.com</a></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td><strong>E M S B Ekanayake</strong></td>
                                        <td>Additional director</td>
                                        <td>Head Office</td>
                                        <td><a href="mailto:emsbeke@gmail.com"><i class="far fa-envelope"></i> emsbeke@gmail.com</a></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td><strong>S D D Rajapakshe</strong></td>
                                        <td>Chief Accountant</td>
                                        <td>Head Office</td>
                                        <td><a href="mailto:damayanthiacc@gmail.com"><i class="far fa-envelope"></i> damayanthiacc@gmail.com</a></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td><strong>W M H D K Wickramasinghe</strong></td>
                                        <td>Chief Engineer (Education)</td>
                                        <td>Head Office</td>
                                        <td><a href="mailto:devikawickramasinghe@gmail.com"><i class="far fa-envelope"></i> devikawickramasinghe@gmail.com</a></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td><strong>D M B Dissanayake</strong></td>
                                        <td>Chief Engineer (Structural Design &amp; O)</td>
                                        <td>Head Office</td>
                                        <td><a href="mailto:buddhika84@gmail.com"><i class="far fa-envelope"></i> buddhika84@gmail.com</a></td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td><strong>R A N A Bandara</strong></td>
                                        <td>Chief Engineer (Health)</td>
                                        <td>Head Office</td>
                                        <td><a href="mailto:nalakkaarjuna1983@gmail.com"><i class="far fa-envelope"></i> nalakkaarjuna1983@gmail.com</a></td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td><strong>K G N Gallage</strong></td>
                                        <td>Divisional Engineer</td>
                                        <td>Maho</td>
                                        <td><a href="mailto:eng.nishangallage@gmail.com"><i class="far fa-envelope"></i> eng.nishangallage@gmail.com</a></td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td><strong>R P M Weerasena</strong></td>
                                        <td>Divisional Engineer</td>
                                        <td>Puttalam</td>
                                        <td><a href="mailto:engprasadnwp@gmail.com"><i class="far fa-envelope"></i> engprasadnwp@gmail.com</a></td>
                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td><strong>G A K M Bandara</strong></td>
                                         <td>Divisional Engineer</td>
                                         <td>Kurunegala</td>
                                         <td><a href="mailto:kasunmrt@yahoo.com"><i class="far fa-envelope"></i> kasunmrt@yahoo.com</a></td>
                                    </tr>
                                    <tr>
                                        <td>10</td>
                                        <td><strong>J A A L Jayasinghe</strong></td>
                                        <td>Divisional Engineer</td>
                                        <td>Kuliyapitiya</td>
                                        <td><a href="mailto:ayeshmantha132@gmail.com"><i class="far fa-envelope"></i> ayeshmantha132@gmail.com</a></td>
                                    </tr>
                                    <tr>
                                        <td>11</td>
                                        <td><strong>W M I P Thilakarathna</strong></td>
                                        <td>Divisional Engineer</td>
                                        <td>Rideegama</td>
                                        <td><a href="mailto:ipthilakarathna@gmail.com"><i class="far fa-envelope"></i> ipthilakarathna@gmail.com</a></td>
                                    </tr>
                                    <tr>
                                        <td>12</td>
                                        <td><strong>M A N Dilrukshika</strong></td>
                                        <td>Divisional Engineer</td>
                                        <td>Wariyapola</td>
                                        <td><a href="mailto:nilminitcp@gmail.com"><i class="far fa-envelope"></i> nilminitcp@gmail.com</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Services Modal (Split Layout) -->
    <div class="modal" id="servicesModal">
        <div class="modal-content about-modal-content">
            <div class="modal-header">
                <h2 data-i18n="modal_services_title">Our Services</h2>
                <span class="close-btn" id="closeServicesModal">&times;</span>
            </div>
            <div class="modal-body about-modal-body">
                <aside class="sidebar about-sidebar">
                    <ul class="sidebar-nav">
                        <li><a href="#" class="services-tab-btn active" data-tab="investigations"><i class="fas fa-search"></i> <span data-i18n="service_tab_investigations">Investigations & Feasibility</span></a></li>
                        <li><a href="#" class="services-tab-btn" data-tab="engineering"><i class="fas fa-drafting-compass"></i> <span data-i18n="service_tab_engineering">Detailed Engineering</span></a></li>
                        <li><a href="#" class="services-tab-btn" data-tab="construction"><i class="fas fa-trowel-bricks"></i> <span data-i18n="service_tab_construction">Construction Management</span></a></li>
                        <li><a href="#" class="services-tab-btn" data-tab="operation"><i class="fas fa-tools"></i> <span data-i18n="service_tab_operation">Operation & Maintenance</span></a></li>
                        <li><a href="#" class="services-tab-btn" data-tab="institutional"><i class="fas fa-graduation-cap"></i> <span data-i18n="service_tab_institutional">Institutional & Manpower</span></a></li>
                    </ul>
                </aside>
                <main class="content-area about-content-area">
                    <!-- Investigations -->
                    <div id="stab-investigations" class="services-pane" style="display:block;">
                        <h2 class="content-title" data-i18n="service_title_investigations">1. Investigations and Feasibility Studies of Projects</h2>
                        <ul class="announcement-list" id="servicesInvestigationsList">
                            <li><i class="fas fa-check-circle" style="color:var(--primary-light);"></i> <span>Site investigations &amp; Topographic Surveys</span></li>
                            <li><i class="fas fa-check-circle" style="color:var(--primary-light);"></i> <span>Foundation investigations</span></li>
                            <li><i class="fas fa-check-circle" style="color:var(--primary-light);"></i> <span>Economic and Sociological Surveys</span></li>
                            <li><i class="fas fa-check-circle" style="color:var(--primary-light);"></i> <span>Evaluation of engineering surveys, formulation of projects, preparation of layouts, design and cost estimates</span></li>
                            <li><i class="fas fa-check-circle" style="color:var(--primary-light);"></i> <span>Economic and Financial analysis</span></li>
                        </ul>
                    </div>
                    <!-- Detailed Engineering -->
                    <div id="stab-engineering" class="services-pane" style="display:none;">
                        <h2 class="content-title" data-i18n="service_title_engineering">2. Detailed Engineering</h2>
                        <ul class="announcement-list" style="margin-bottom:20px;" id="servicesEngineeringList">
                            <li><i class="fas fa-check-circle" style="color:var(--primary-light);"></i> <span>Detailed designs for architectural and structural designs</span></li>
                            <li><i class="fas fa-check-circle" style="color:var(--primary-light);"></i> <span>Quantity surveying, preparation of cost analysis and Total Cost estimates</span></li>
                            <li><i class="fas fa-check-circle" style="color:var(--primary-light);"></i> <span>Specifications for Civil Works</span></li>
                            <li><i class="fas fa-check-circle" style="color:var(--primary-light);"></i> <span>Bid Documents</span></li>
                            <li><i class="fas fa-check-circle" style="color:var(--primary-light);"></i> <span>Procurement Procedures</span></li>
                        </ul>
                        <div class="vm-item" style="background:#f8fafc; border-left:4px solid var(--accent-gold); margin-top:20px; padding:15px; border-radius:8px; display:block;">
                            <p id="servicesEngineeringDesc" style="font-size:0.95rem; line-height:1.6; color:#334155; font-style:italic; text-align:left;">PED engineers and architects also have experience and proven ability in loan administration, contract and force-account work implementation, preparation of bid documents, specifications, bid evaluation, procurement of goods and services, project implementation, monitoring, quality control and general construction supervision.</p>
                        </div>
                    </div>
                    <!-- Construction Management -->
                    <div id="stab-construction" class="services-pane" style="display:none;">
                        <h2 class="content-title" data-i18n="service_title_construction">3. Construction Management</h2>
                        <ul class="announcement-list" style="margin-bottom:20px;" id="servicesConstructionList">
                            <li><i class="fas fa-check-circle" style="color:var(--primary-light);"></i> <span>Construction Planning and Scheduling</span></li>
                            <li><i class="fas fa-check-circle" style="color:var(--primary-light);"></i> <span>Quality Control</span></li>
                            <li><i class="fas fa-check-circle" style="color:var(--primary-light);"></i> <span>Contract Administration and Supervision</span></li>
                            <li><i class="fas fa-check-circle" style="color:var(--primary-light);"></i> <span>Project Progress monitoring and Evaluation</span></li>
                        </ul>
                        <div class="vm-item" style="background:#f8fafc; border-left:4px solid var(--accent-gold); margin-top:20px; padding:15px; border-radius:8px; display:block;">
                            <p id="servicesConstructionDesc" style="font-size:0.95rem; line-height:1.6; color:#334155; font-style:italic; text-align:left;">PED is proud of its expertise in the management of a wide range of development projects which include the construction of multi storeyed buildings. Most of these were implemented with funding assistance from IDA, IBRD, ADB, IFAD, and JBIC.</p>
                        </div>
                    </div>
                    <!-- Operation and Maintenance -->
                    <div id="stab-operation" class="services-pane" style="display:none;">
                        <h2 class="content-title" data-i18n="service_title_operation">4. Operation and Maintenance</h2>
                        <ul class="announcement-list" id="servicesOperationList">
                            <li><i class="fas fa-check-circle" style="color:var(--primary-light);"></i> <span>Repair and maintenance of government buildings</span></li>
                        </ul>
                    </div>
                    <!-- Institutional & Manpower Development -->
                    <div id="stab-institutional" class="services-pane" style="display:none;">
                        <h2 class="content-title" data-i18n="service_title_institutional">5. Institutional & Manpower Development</h2>
                        <ul class="announcement-list" id="servicesInstitutionalList">
                            <li><i class="fas fa-check-circle" style="color:var(--primary-light);"></i> <span>Training and development of Technical staff annually</span></li>
                            <li><i class="fas fa-check-circle" style="color:var(--primary-light);"></i> <span>Training and development of supporting staff annually</span></li>
                        </ul>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Procurement Notices Modal -->
    <div class="modal" id="procurementsModal">
        <div class="modal-content about-modal-content">
            <div class="modal-header">
                <h2 data-i18n="modal_procurement_title">Procurement & Tender Notices</h2>
                <span class="close-btn" id="closeProcurementsModal">&times;</span>
            </div>
            <div class="modal-body about-modal-body" style="padding: 20px 30px; display: block;">
                <p style="margin-bottom: 20px; color: #64748b;" data-i18n="procurement_desc">Below are the active and upcoming procurement and bidding opportunities for the NWP Engineering Department.</p>
                <div class="downloads-list" id="procurementsList">
                    <!-- Dynamically populated -->
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Modal -->
    <div class="modal" id="galleryModal">
        <div class="modal-content about-modal-content" style="max-width: 900px;">
            <div class="modal-header">
                <h2 data-i18n="modal_gallery_title">Department Media Gallery</h2>
                <span class="close-btn" id="closeGalleryModal">&times;</span>
            </div>
            <div class="modal-body about-modal-body" style="padding: 30px; display: block; max-height: 70vh; overflow-y: auto;">
                <div class="officers-grid" id="galleryGrid" style="grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));">
                    <!-- Dynamically populated -->
                </div>
            </div>
        </div>
    </div>

    <!-- News Details Modal -->
    <div class="modal" id="newsDetailsModal">
        <div class="modal-content about-modal-content">
            <div class="modal-header">
                <h2 id="newsModalTitle" data-i18n="modal_news_title">News Details</h2>
                <span class="close-btn" id="closeNewsDetailsModal">&times;</span>
            </div>
            <div class="modal-body about-modal-body" style="padding: 30px; display: block; height: calc(100% - 70px); overflow-y: auto;">
                <div id="newsModalImageContainer" style="width:100%; aspect-ratio: 21 / 9; max-height: 400px; overflow:hidden; border-radius:12px; margin-bottom:20px; display:none; border:1px solid var(--border-gray);">
                    <img id="newsModalImage" src="" alt="News Cover" style="width:100%; height:100%; object-fit:cover;">
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px; border-bottom:1px solid #e2e8f0; padding-bottom:10px;">
                    <span id="newsModalCategory" style="background:var(--primary-blue); color:var(--accent-gold); padding:4px 12px; border-radius:20px; font-size:0.8rem; font-weight:600; text-transform:uppercase;"></span>
                    <span id="newsModalDate" style="font-size:0.85rem; color:var(--text-muted); font-weight:500;"></span>
                </div>
                <!-- Before/After Photos -->
                <div id="newsModalBeforeAfterContainer" class="before-after-grid" style="display:none; margin-bottom:20px;">
                    <!-- Before Wrapper -->
                    <div id="newsModalBeforeWrapper" style="display:flex; flex-direction:column; gap:10px;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span style="background:rgba(239, 68, 68, 0.1); color:rgb(239, 68, 68); padding:4px 12px; border-radius:20px; font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; border:1px solid rgba(239, 68, 68, 0.2);" data-i18n="news_before">Before Renovation</span>
                        </div>
                        <div id="newsModalBeforeImages" style="display:grid; grid-template-columns:1fr; gap:10px;">
                            <!-- Dynamically populated <img> tags -->
                        </div>
                    </div>
                    <!-- After Wrapper -->
                    <div id="newsModalAfterWrapper" style="display:flex; flex-direction:column; gap:10px;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span style="background:rgba(34, 197, 94, 0.1); color:rgb(34, 197, 94); padding:4px 12px; border-radius:20px; font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; border:1px solid rgba(34, 197, 94, 0.2);" data-i18n="news_after">After Renovation</span>
                        </div>
                        <div id="newsModalAfterImages" style="display:grid; grid-template-columns:1fr; gap:10px;">
                            <!-- Dynamically populated <img> tags -->
                        </div>
                    </div>
                </div>
                <p id="newsModalContent" style="font-size:1rem; line-height:1.7; color:var(--text-dark); text-align:justify; white-space:pre-line;"></p>
            </div>
        </div>
    </div>

    <script src="translations.js?v=17"></script>
    <script src="members_login_db.js?v=17"></script>
    <script src="script.js?v=17"></script>
</body>
</html>
