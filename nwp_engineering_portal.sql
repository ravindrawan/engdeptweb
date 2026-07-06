<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Member Access - NWP Engineering</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --portal-dark: #0A1128;
            --portal-blue: #122340;
            --portal-light-blue: #1E3A8A;
            --accent-gold: #D4AF37;
            --portal-bg: #E2E8F0;
            --glass-bg: rgba(255, 255, 255, 0.85);
            --border-glass: rgba(255, 255, 255, 0.3);
            --text-dark: #1e293b;
            --text-muted: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #cbd5e1 0%, #f1f5f9 100%);
            color: var(--text-dark);
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Premium Sidebar */
        .sidebar {
            width: 280px;
            background: var(--portal-dark);
            color: white;
            display: flex;
            flex-direction: column;
            box-shadow: 10px 0 30px rgba(0, 0, 0, 0.15);
            z-index: 50;
            position: relative;
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://www.transparenttextures.com/patterns/carbon-fibre.png') opacity(0.05);
            pointer-events: none;
        }

        .sidebar-header {
            padding: 30px 20px;
            text-align: center;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.4), transparent);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            position: relative;
        }

        .sidebar-header h2 {
            font-size: 1.1rem;
            margin-top: 15px;
            font-weight: 400;
            letter-spacing: 2px;
            color: var(--accent-gold);
            text-transform: uppercase;
        }

        .sidebar-menu {
            flex: 1;
            overflow-y: auto;
            padding: 20px 0;
            list-style: none;
        }

        .sidebar-menu::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }

        .menu-category {
            padding: 10px 25px;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #475569;
            font-weight: 700;
            letter-spacing: 1.5px;
            margin-top: 20px;
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .sidebar-menu li a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 0;
            background: var(--accent-gold);
            transition: width 0.3s ease;
            z-index: -1;
        }

        .sidebar-menu li a:hover {
            color: white;
            background: rgba(255, 255, 255, 0.05);
            padding-left: 30px;
        }

        .sidebar-menu li a.active {
            color: var(--portal-dark);
            font-weight: 600;
        }

        .sidebar-menu li a.active::before {
            width: 100%;
        }

        .sidebar-menu li a.active i {
            color: var(--portal-dark);
            transform: scale(1.1);
        }

        .sidebar-menu li a i {
            width: 30px;
            font-size: 1.1rem;
            transition: transform 0.3s, color 0.3s;
        }

        /* Main Workspace */
        .main-workspace {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: relative;
        }

        .main-workspace::after {
            content: '';
            position: fixed;
            top: -200px;
            right: -200px;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.1) 0%, transparent 70%);
            z-index: -1;
            pointer-events: none;
        }

        /* Top Navbar */
        .top-nav {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(12px);
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            border-bottom: 1px solid var(--border-glass);
            z-index: 10;
        }

        .top-nav .page-header-title {
            font-size: 1.2rem;
            color: var(--portal-blue);
            font-weight: 600;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 20px;
            background: white;
            padding: 8px 20px;
            border-radius: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-glass);
        }

        .logout-btn {
            background: #ef4444;
            color: white;
            border: none;
            padding: 8px 18px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .logout-btn:hover {
            background: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);
        }

        /* Content Area Container */
        .content-area {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
            position: relative;
            z-index: 1;
        }

        .page-title {
            font-size: 2rem;
            margin-bottom: 30px;
            color: var(--portal-dark);
            font-weight: 300;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .page-title span {
            font-weight: 700;
            background: linear-gradient(135deg, var(--portal-blue), var(--portal-light-blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Content Views */
        .view-section {
            display: none;
            animation: slideUpFade 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        .view-section.active {
            display: block;
        }

        @keyframes slideUpFade {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Modern Glass Cards (Grid) */
        .officers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
        }

        .officer-card {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            border: 1px solid var(--border-glass);
            border-radius: 20px;
            padding: 30px 20px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.03);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .officer-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--portal-blue), var(--accent-gold));
        }

        .officer-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            border-color: rgba(212, 175, 55, 0.4);
        }

        .img-ring {
            width: 120px;
            height: 120px;
            margin: 0 auto 20px;
            border-radius: 50%;
            padding: 4px;
            background: linear-gradient(135deg, var(--portal-blue), var(--accent-gold));
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .officer-card img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid white;
        }

        .officer-card h4 {
            color: var(--portal-blue);
            margin-bottom: 5px;
            font-size: 1.3rem;
            font-weight: 600;
        }

        .officer-card p.title {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .officer-card p.contact {
            background: rgba(18, 35, 64, 0.04);
            padding: 10px 15px;
            border-radius: 12px;
            font-weight: 500;
            color: var(--portal-blue);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 1rem;
        }

        .officer-card p.contact i {
            color: var(--accent-gold);
        }

        /* Premium Downloads List */
        .downloads-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .download-item {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            border: 1px solid var(--border-glass);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .download-item::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 0;
            height: 3px;
            background: var(--accent-gold);
            transition: width 0.4s ease;
        }

        .download-item:hover {
            transform: translateX(5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
            background: white;
        }

        .download-item:hover::after {
            width: 100%;
        }

        .download-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .icon-box {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, rgba(29, 78, 216, 0.1), rgba(212, 175, 55, 0.1));
            color: var(--portal-blue);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .dl-text strong {
            display: block;
            font-size: 1.1rem;
            color: var(--portal-dark);
            margin-bottom: 2px;
        }

        .dl-text p {
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .dl-btn {
            background: var(--portal-blue);
            color: white;
            padding: 10px 25px;
            border-radius: 30px;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.3s;
            box-shadow: 0 4px 10px rgba(18, 35, 64, 0.2);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .dl-btn:hover {
            background: var(--accent-gold);
            color: var(--portal-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(212, 175, 55, 0.3);
        }

        .admin-tab-btn {
            padding: 10px 20px;
            background: var(--portal-bg);
            border: 1px solid var(--border-glass);
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            color: var(--portal-dark);
            transition: 0.3s;
        }

        .admin-tab-btn.active {
            background: var(--portal-blue);
            color: white;
        }

        /* Responsive Sidebar Toggle */
        .mobile-toggle {
            display: none;
            background: var(--portal-dark);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 15px;
            font-size: 1.1rem;
        }

        /* Sidebar overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 9998;
        }
        .sidebar-overlay.active { display: block; }

        /* =====================================================
           RESPONSIVE — members portal
           Breakpoints: 1200px | 992px | 768px | 576px | 400px
           ===================================================== */

        /* --- Laptop (≤1200px) --- */
        @media (max-width: 1200px) {
            .sidebar { width: 240px; }
            .officers-grid {
                grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            }
        }

        /* --- Tablet (≤992px) --- */
        @media (max-width: 992px) {
            body {
                flex-direction: column;
                overflow-y: auto;
                height: auto;
                min-height: 100vh;
            }

            /* Sidebar becomes a slide-in drawer */
            .sidebar {
                position: fixed;
                left: -280px;
                top: 0;
                bottom: 0;
                width: 280px !important;
                height: 100vh;
                transition: left 0.3s ease;
                z-index: 9999 !important;
                box-shadow: 10px 0 40px rgba(0,0,0,0.3);
            }
            .sidebar.active { left: 0; }

            .mobile-toggle { display: block; }

            /* Main workspace fills viewport */
            .main-workspace {
                width: 100%;
                height: auto;
                min-height: 100vh;
                overflow-y: visible;
            }

            /* Top nav */
            .top-nav {
                padding: 0 15px;
                height: 60px;
                position: sticky;
                top: 0;
                z-index: 100;
                background: white;
                box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            }

            /* Content area */
            .content-area {
                padding: 20px 15px;
                overflow-y: visible;
            }

            .page-title {
                font-size: 1.4rem;
                margin-bottom: 20px;
                gap: 10px;
            }

            /* Officers */
            .officers-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 20px;
            }

            /* Downloads */
            .download-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
                padding: 18px;
            }
            .download-info { flex-direction: column; gap: 10px; }
            .dl-btn { width: 100%; justify-content: center; }

            /* Admin tab buttons — scrollable row */
            #admin-panel > div:first-of-type {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                padding-bottom: 6px;
                flex-wrap: nowrap !important;
            }
            .admin-tab-btn {
                flex-shrink: 0;
                font-size: 0.82rem;
                padding: 8px 14px;
            }

            /* Admin forms — single column */
            #addOfficerForm,
            #addDownloadForm {
                grid-template-columns: 1fr !important;
            }
            #addOfficerForm > div[style*="span 2"],
            #addDownloadForm > div[style*="span 2"] {
                grid-column: span 1 !important;
            }

            /* User profile condensed */
            .user-profile {
                padding: 6px 12px;
                gap: 10px;
            }
            #loggedUserRole { display: none; }
        }

        /* --- Mobile (≤768px) --- */
        @media (max-width: 768px) {
            .top-nav {
                padding: 0 10px;
                height: 55px;
            }

            .content-area {
                padding: 15px 10px;
            }

            .page-title {
                font-size: 1.2rem;
                margin-bottom: 16px;
            }
            .page-title i { font-size: 1rem; }

            /* Officers — single column */
            .officers-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            /* Officer card compact */
            .officer-card {
                padding: 20px 15px;
                border-radius: 14px;
            }
            .img-ring { width: 90px; height: 90px; }
            .officer-card h4 { font-size: 1.05rem; }

            /* Admin form compact */
            #addUserForm {
                flex-direction: column;
            }
            #addUserForm input,
            #addUserForm select,
            #addUserForm button {
                width: 100%;
                flex: none;
                min-width: 0;
            }

            /* Download items */
            .icon-box { width: 40px; height: 40px; font-size: 1.2rem; }
            .dl-text strong { font-size: 0.95rem; }
            .dl-text p { font-size: 0.82rem; }

            /* User profile very compact */
            .user-profile {
                padding: 5px 8px;
                gap: 6px;
            }
            #loggedUserName { font-size: 0.8rem; }
            .logout-btn { padding: 6px 12px; font-size: 0.8rem; }
        }

        /* --- Small Mobile (≤576px) --- */
        @media (max-width: 576px) {
            .top-nav { height: 50px; }
            .page-title { font-size: 1.05rem; }

            .content-area { padding: 12px 8px; }

            .officer-card { padding: 16px 12px; }
            .img-ring { width: 78px; height: 78px; }

            /* Admin tab scroll */
            .admin-tab-btn { font-size: 0.75rem; padding: 7px 10px; }

            /* Admin container compact */
            .admin-container { padding: 15px !important; }

            /* Settings form grid → single col */
            #settingsForm > div > div[style*="grid-template-columns"] {
                grid-template-columns: 1fr !important;
            }
        }

        /* --- Small Phone (≤400px) --- */
        @media (max-width: 400px) {
            .sidebar { width: 250px !important; }
            .page-title { font-size: 0.95rem; }
            .officer-card h4 { font-size: 0.95rem; }
            .img-ring { width: 68px; height: 68px; }
        }
    </style>
</head>

<body>

    <!-- Mobile Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Premium Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-fingerprint"
                style="font-size: 3rem; color:var(--accent-gold); filter: drop-shadow(0 0 10px rgba(212,175,55,0.4));"></i>
            <h2>Secure Portal</h2>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-category">About Us</li>
            <li><a class="nav-link active" data-target="about-officers"><i class="fas fa-user-tie"></i> Officers
                    Information</a></li>

            <li class="menu-category">Divisions</li>
            <li><a class="nav-link" data-target="division-officers"><i class="fas fa-network-wired"></i> Officers
                    Information</a></li>

            <li class="menu-category">Downloads</li>
            <li><a class="nav-link" data-target="dl-formats"><i class="fas fa-file-alt"></i> Internal Formats</a></li>
            <li><a class="nav-link" data-target="dl-transfers"><i class="fas fa-exchange-alt"></i> Internal
                    Transfers</a></li>
            <li><a class="nav-link" data-target="dl-circulars"><i class="fas fa-book"></i> Circulars</a></li>
            <li><a class="nav-link" data-target="dl-rate"><i class="fas fa-chart-line"></i> Rate Analysis</a></li>

            <li class="menu-category admin-only" style="color: #ef4444; display: none; margin-top: 30px;">Administration
            </li>
            <li class="admin-only" style="display: none;"><a class="nav-link" data-target="admin-panel"><i
                        class="fas fa-users-cog"></i> Website Administration</a></li>
        </ul>
    </aside>

    <!-- Main Workspace -->
    <main class="main-workspace">
        <header class="top-nav">
            <div class="page-header-title">
                <button class="mobile-toggle" id="mobileToggle"><i class="fas fa-bars"></i></button>
                <i class="fas fa-shield-alt" style="color:var(--accent-gold);"></i> <span>NWP Internal Access
                    Network</span>
            </div>
            <div class="user-profile">
                <div style="text-align:right;">
                    <strong id="loggedUserName"
                        style="display:block; font-size:0.9rem; color:var(--portal-dark); text-transform: capitalize;">Admin</strong>
                    <span id="loggedUserRole" style="font-size:0.75rem; color:var(--text-muted);">System Admin</span>
                </div>
                <img src="https://ui-avatars.com/api/?name=Admin&background=122340&color=fff"
                    style="width:35px; border-radius:50%;" alt="User">
                <a href="index.html" class="logout-btn" onclick="sessionStorage.removeItem('loggedInUser');"><i
                        class="fas fa-power-off"></i></a>
            </div>
        </header>

        <div class="content-area">

            <!-- 1. HQ Officers -->
            <div class="view-section active" id="about-officers">
                <h2 class="page-title"><i class="fas fa-user-tie" style="color:var(--accent-gold);"></i> <span>Officers
                        Information (About Us)</span></h2>
                <div class="officers-grid" id="hq-officers-grid"></div>
            </div>

            <!-- 2. Division Officers -->
            <div class="view-section" id="division-officers">
                <h2 class="page-title"><i class="fas fa-network-wired" style="color:var(--accent-gold);"></i>
                    <span>Officers Information (Divisions)</span></h2>
                <div class="officers-grid" id="div-officers-grid"></div>
            </div>

            <!-- 3. Formats -->
            <div class="view-section" id="dl-formats">
                <h2 class="page-title"><i class="fas fa-file-alt" style="color:var(--accent-gold);"></i> <span>Internal
                        Formats (Word / Excel / PowerPoint / PDF)</span></h2>
                <div class="downloads-list" id="formats-list"></div>
            </div>

            <!-- 4. Transfers -->
            <div class="view-section" id="dl-transfers">
                <h2 class="page-title"><i class="fas fa-exchange-alt" style="color:var(--accent-gold);"></i>
                    <span>Internal Transfers</span></h2>
                <div class="downloads-list" id="transfers-list"></div>
            </div>

            <!-- 5. Circulars -->
            <div class="view-section" id="dl-circulars">
                <h2 class="page-title"><i class="fas fa-book" style="color:var(--accent-gold);"></i>
                    <span>Circulars</span></h2>
                <div class="downloads-list" id="circulars-list"></div>
            </div>

            <!-- 6. Rate Analysis -->
            <div class="view-section" id="dl-rate">
                <h2 class="page-title"><i class="fas fa-chart-line" style="color:var(--accent-gold);"></i> <span>Rate
                        Analysis</span></h2>
                <div class="downloads-list" id="rate-list"></div>
            </div>

            <!-- 7. Admin Panel -->
            <div class="view-section" id="admin-panel">
                <h2 class="page-title"><i class="fas fa-database" style="color:var(--accent-gold);"></i> <span>Database
                        & Management</span></h2>

                <div style="display:flex; gap:10px; margin-bottom:20px; flex-wrap: wrap;">
                    <button class="admin-tab-btn active" onclick="switchAdminTab('users', this)">Users</button>
                    <button class="admin-tab-btn" onclick="switchAdminTab('officers', this)">Officers</button>
                    <button class="admin-tab-btn" onclick="switchAdminTab('downloads', this)">Downloads</button>
                    <button class="admin-tab-btn" onclick="switchAdminTab('settings', this)">Site Settings</button>
                    <button class="admin-tab-btn" onclick="switchAdminTab('divisions', this)">Divisions Info</button>
                    <button class="admin-tab-btn" onclick="switchAdminTab('services', this)">Services Info</button>
                    <button class="admin-tab-btn" onclick="switchAdminTab('procurements', this)">Procurements</button>
                    <button class="admin-tab-btn" onclick="switchAdminTab('projects', this)">Projects</button>
                    <button class="admin-tab-btn" onclick="switchAdminTab('gallery', this)">Gallery</button>
                    <button class="admin-tab-btn" onclick="switchAdminTab('announcements', this)">Announcements</button>
                    <button class="admin-tab-btn" onclick="switchAdminTab('news', this)">Latest News</button>
                    <button class="admin-tab-btn" onclick="switchAdminTab('courses', this)">Courses / Events</button>
                    <button class="admin-tab-btn" onclick="switchAdminTab('links', this)">Important Links</button>
                    <button class="admin-tab-btn" onclick="switchAdminTab('achievements', this)">Achievements</button>
                    <button class="admin-tab-btn" onclick="switchAdminTab('rti_officers', this)">RTI Officers</button>
                </div>

                <!-- Users Tab -->
                <div id="admin-tab-users" class="admin-tab-content" style="display:block;">
                    <div class="admin-container" style="background: var(--glass-bg); backdrop-filter: blur(10px); border-radius: 16px; border: 1px solid var(--border-glass); padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                        <div style="margin-bottom: 40px;">
                            <h3 style="margin-bottom: 20px; color: var(--portal-blue); font-size: 1.2rem;"><i class="fas fa-user-plus"></i> Add New User</h3>
                            <form id="addUserForm" style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
                                <input type="text" id="newUsername" placeholder="Username" required style="flex: 1; min-width: 200px; padding: 12px 20px; border-radius: 10px; border: 1px solid var(--border-glass); background: white; outline: none;">
                                <input type="password" id="newPassword" placeholder="Password" required style="flex: 1; min-width: 200px; padding: 12px 20px; border-radius: 10px; border: 1px solid var(--border-glass); background: white; outline: none;">
                                <select id="newRole" style="padding: 12px 20px; border-radius: 10px; border: 1px solid var(--border-glass); background: white; outline: none; cursor: pointer;">
                                    <option value="user">Member (User)</option>
                                    <option value="staff">Staff Admin</option>
                                    <option value="admin">System Admin</option>
                                </select>
                                <button type="submit" class="dl-btn" style="border: none; cursor: pointer; padding: 12px 25px;"><i class="fas fa-plus-circle"></i> Create User</button>
                            </form>
                        </div>
                        <h3 style="margin-bottom: 20px; color: var(--portal-blue); font-size: 1.2rem;"><i class="fas fa-users"></i> Existing Members Directory</h3>
                        <div style="background: white; border-radius: 12px; border: 1px solid var(--border-glass); overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                                <thead style="background: var(--portal-blue); color: white;">
                                    <tr>
                                        <th style="padding: 15px 20px; font-weight: 500;">Username</th>
                                        <th style="padding: 15px 20px; font-weight: 500;">Access Level</th>
                                        <th style="padding: 15px 20px; font-weight: 500; text-align: right;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="userTableBody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Officers Tab -->
                <div id="admin-tab-officers" class="admin-tab-content" style="display:none;">
                    <div class="admin-container" style="background: var(--glass-bg); padding: 30px; border-radius: 16px; border: 1px solid var(--border-glass);">
                        <h3 id="officerFormHeader" style="margin-bottom: 20px; color: var(--portal-blue);"><i class="fas fa-plus"></i> Add Officer</h3>
                        <form id="addOfficerForm" style="display: grid; gap: 15px; grid-template-columns: 1fr 1fr; margin-bottom: 30px;">
                            <input type="hidden" id="officerId" value="">
                            <input type="text" id="offName" placeholder="Name (e.g. Eng. A. Kumara)" required style="padding: 10px; border-radius: 8px; border: 1px solid var(--border-glass);">
                            <input type="text" id="offTitle" placeholder="Title/Designation" required style="padding: 10px; border-radius: 8px; border: 1px solid var(--border-glass);">
                            <input type="text" id="offPhone" placeholder="Phone" required style="padding: 10px; border-radius: 8px; border: 1px solid var(--border-glass);">
                            <input type="email" id="offEmail" placeholder="Email Address" style="padding: 10px; border-radius: 8px; border: 1px solid var(--border-glass);">
                            <select id="offCategory" style="padding: 10px; border-radius: 8px; border: 1px solid var(--border-glass);">
                                <option value="executive">Executive Officer (HQ)</option>
                                <option value="admin">Administrative Officer (HQ)</option>
                                <option value="technical">Technical Officer (HQ)</option>
                                <option value="div">Division Officer</option>
                                <option value="hq">General HQ Staff</option>
                            </select>
                            <input type="text" id="offDivision" placeholder="Division Name (e.g. Kurunegala, Maho, Head Office)" required style="padding: 10px; border-radius: 8px; border: 1px solid var(--border-glass);">
                            
                            <div style="grid-column: span 2; display: flex; flex-direction: column; gap: 5px;">
                                <label style="font-size: 0.85rem; font-weight: 600; color: #475569; margin-bottom: 2px;">Officer Profile Photo (Optional)</label>
                                <input type="file" id="offPhoto" accept="image/*" style="padding: 10px; border-radius: 8px; border: 1px solid var(--border-glass); background: white;">
                            </div>
                            
                            <div style="grid-column: span 2; display: flex; gap: 10px;">
                                <button type="submit" id="officerSubmitBtn" class="dl-btn" style="border: none; cursor: pointer; flex: 1; justify-content: center; padding: 12px 25px;"><i class="fas fa-plus-circle"></i> Add Officer</button>
                                <button type="button" id="officerCancelBtn" onclick="cancelOfficerEdit()" style="display:none; background:#64748b; color:white; border:none; padding:12px 25px; border-radius:30px; font-size:0.95rem; font-weight:500; cursor:pointer; justify-content:center; align-items:center; gap:8px;"><i class="fas fa-times"></i> Cancel</button>
                            </div>
                        </form>
                        <h3 style="margin-bottom: 20px; color: var(--portal-blue);">Existing Officers</h3>
                        <div id="admin-officers-list" style="display: grid; gap: 10px;"></div>
                    </div>
                </div>

                <!-- Downloads Tab -->
                <div id="admin-tab-downloads" class="admin-tab-content" style="display:none;">
                    <div class="admin-container" style="background: var(--glass-bg); padding: 30px; border-radius: 16px; border: 1px solid var(--border-glass);">
                        <h3 id="downloadFormHeader" style="margin-bottom: 20px; color: var(--portal-blue);"><i class="fas fa-plus"></i> Add Document</h3>
                        <form id="addDownloadForm" style="display: grid; gap: 15px; grid-template-columns: 1fr 1fr; margin-bottom: 30px;">
                            <input type="hidden" id="downloadId" value="">
                            <input type="text" id="dlTitle" placeholder="Document Title" required style="padding: 12px; border-radius: 10px; border: 1px solid #ddd;">
                            <input type="text" id="dlDesc" placeholder="Description" required style="padding: 12px; border-radius: 10px; border: 1px solid #ddd;">
                            <select id="dlCategory" style="padding: 12px; border-radius: 10px; border: 1px solid #ddd; background: white;">
                                <option style="font-weight: bold; color: var(--primary-blue);" disabled>--- Public Downloads ---</option>
                                <option value="rate_books">Rate Books</option>
                                <option value="type_plans">Type Plans</option>
                                <option value="progress_reports">Progress Reports</option>
                                <option value="rti">Right to Information Act</option>
                                <option style="font-weight: bold; color: var(--primary-blue);" disabled>--- Private (Member Only) ---</option>
                                <option value="forms">Internal Formats</option>
                                <option value="transfers">Internal Transfers</option>
                                <option value="circulars">Circulars</option>
                                <option value="rate_analysis">Rate Analysis</option>
                            </select>
                            <input type="file" id="dlFile" style="padding: 10px; border-radius: 10px; border: 1px solid #ddd; background: white;">
                            <div style="grid-column: span 2; display: flex; gap: 10px;">
                                <button type="submit" id="downloadSubmitBtn" class="dl-btn" style="flex: 1; border: none; cursor: pointer; justify-content: center; padding: 12px 25px;"><i class="fas fa-upload"></i> Upload & Save Document</button>
                                <button type="button" id="downloadCancelBtn" onclick="cancelDownloadEdit()" class="dl-btn" style="display: none; background: #64748b; border: none; cursor: pointer; justify-content: center; padding: 12px 25px;"><i class="fas fa-times"></i> Cancel</button>
                            </div>
                        </form>
                        <h3 style="margin-bottom: 20px; color: var(--portal-blue);">Existing Documents</h3>
                        <div id="admin-downloads-list" style="display: grid; gap: 10px;"></div>
                    </div>
                </div>

                <!-- Settings Tab -->
                <div id="admin-tab-settings" class="admin-tab-content" style="display:none;">
                    <div class="admin-container" style="background: var(--glass-bg); padding: 30px; border-radius: 16px; border: 1px solid var(--border-glass);">
                        <h3 style="margin-bottom: 20px; color: var(--portal-blue);"><i class="fas fa-cog"></i> Update Website Text Blocks</h3>
                        <form id="settingsForm" style="display: grid; gap: 20px; margin-bottom: 30px;">
                            <div>
                                <label style="font-weight:600; display:block; margin-bottom:5px;">Section: About Us - Overview</label>
                                <textarea id="setOverviewEn" placeholder="Overview (English)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd; margin-bottom:8px;"></textarea>
                                <textarea id="setOverviewSi" placeholder="Overview (Sinhala)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd; margin-bottom:8px;"></textarea>
                                <textarea id="setOverviewTa" placeholder="Overview (Tamil)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd;"></textarea>
                            </div>
                            <hr style="border:none; border-top:1px solid #ddd;">
                            <div>
                                <label style="font-weight:600; display:block; margin-bottom:5px;">Section: About Us - Objectives</label>
                                <textarea id="setObjectivesEn" placeholder="Objectives (English)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd; margin-bottom:8px;"></textarea>
                                <textarea id="setObjectivesSi" placeholder="Objectives (Sinhala)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd; margin-bottom:8px;"></textarea>
                                <textarea id="setObjectivesTa" placeholder="Objectives (Tamil)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd;"></textarea>
                            </div>
                            <hr style="border:none; border-top:1px solid #ddd;">
                            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px;">
                                <div>
                                    <label style="font-weight:600; display:block; margin-bottom:5px;">Contact Info: Address (English)</label>
                                    <input type="text" id="setAddressEn" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                                </div>
                                <div>
                                    <label style="font-weight:600; display:block; margin-bottom:5px;">Contact Info: Address (Sinhala)</label>
                                    <input type="text" id="setAddressSi" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                                </div>
                                <div>
                                    <label style="font-weight:600; display:block; margin-bottom:5px;">Contact Info: Phone</label>
                                    <input type="text" id="setPhone" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                                </div>
                                <div>
                                    <label style="font-weight:600; display:block; margin-bottom:5px;">Contact Info: Email</label>
                                    <input type="text" id="setEmail" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                                </div>
                                <div style="grid-column: span 2;">
                                    <label style="font-weight:600; display:block; margin-bottom:5px;">Contact Info: Google Maps Embed URL</label>
                                    <input type="text" id="setMapUrl" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                                </div>
                            </div>
                            <hr style="border:none; border-top:1px solid #ddd;">
                            <div>
                                <label style="font-weight:600; display:block; margin-bottom:5px;">Total Visitor Counter</label>
                                <input type="number" id="setVisitorCount" required style="width:100%; max-width: 300px; padding:10px; border-radius:8px; border:1px solid #ddd;" min="0">
                            </div>
                            <hr style="border:none; border-top:1px solid #ddd;">
                            <div>
                                <label style="font-weight:600; display:block; margin-bottom:5px;">News Ticker Bar / Welcome Strip Text</label>
                                <textarea id="setNewsBarEn" placeholder="News Ticker Text (English)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd; margin-bottom:8px;"></textarea>
                                <textarea id="setNewsBarSi" placeholder="News Ticker Text (Sinhala)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd; margin-bottom:8px;"></textarea>
                                <textarea id="setNewsBarTa" placeholder="News Ticker Text (Tamil)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd;"></textarea>
                            </div>
                            <button type="submit" class="dl-btn" style="border: none; cursor: pointer; justify-content: center; padding: 12px 25px;"><i class="fas fa-save"></i> Save Website Text & Settings</button>
                        </form>

                        <hr style="border:none; border-top:1.5px solid var(--accent-gold); margin: 40px 0;">

                        <h3 style="margin-bottom: 20px; color: var(--portal-blue);"><i class="fas fa-images"></i> Manage Home Page Slideshow (Slider)</h3>
                        <div id="homeSliderManager" style="margin-bottom: 30px;">
                            <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 15px;">You can upload and display up to 6 photos in the homepage slideshow. The default slides will be shown if no custom photos are uploaded.</p>
                            
                            <!-- Upload New Slide Form -->
                            <form id="uploadSlideForm" style="display: flex; gap: 15px; align-items: center; margin-bottom: 25px; flex-wrap: wrap;">
                                <div style="flex: 1; min-width: 250px;">
                                    <input type="file" id="slideFile" accept="image/*" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd; background: white;">
                                </div>
                                <button type="submit" id="uploadSlideBtn" class="dl-btn" style="border: none; cursor: pointer; padding: 11px 25px;"><i class="fas fa-plus-circle"></i> Add New Slide</button>
                            </form>

                            <!-- Current Slides Grid -->
                            <h4 style="margin-bottom: 15px; color: var(--portal-blue); font-size: 1rem;"><i class="fas fa-photo-video"></i> Current Slideshow Photos (<span id="slideCount">0</span>/6)</h4>
                            <div id="slidesGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
                                <!-- Slides will load dynamically here -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Divisions Tab -->
                <div id="admin-tab-divisions" class="admin-tab-content" style="display:none;">
                    <div class="admin-container" style="background: var(--glass-bg); padding: 30px; border-radius: 16px; border: 1px solid var(--border-glass);">
                        <h3 style="margin-bottom: 20px; color: var(--portal-blue);"><i class="fas fa-network-wired"></i> Update Division Office Details</h3>
                        <div style="margin-bottom: 20px;">
                            <label style="font-weight:600; display:block; margin-bottom:5px;">Select Division Office to Edit:</label>
                            <select id="divisionSelect" onchange="populateDivisionEditForm()" style="width:100%; padding:12px; border-radius:8px; border:1px solid #ddd; background:white; cursor:pointer;">
                                <option value="">-- Choose Division --</option>
                            </select>
                        </div>
                        <form id="divisionEditForm" style="display: grid; gap: 15px; grid-template-columns: 1fr 1fr; display:none;">
                            <input type="hidden" id="divSlug">
                            <div style="grid-column: span 2; display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
                                <div>
                                    <label style="font-weight:600; display:block; margin-bottom:5px;">Division Name (English)</label>
                                    <input type="text" id="divNameEn" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                                </div>
                                <div>
                                    <label style="font-weight:600; display:block; margin-bottom:5px;">Division Name (Sinhala)</label>
                                    <input type="text" id="divNameSi" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                                </div>
                                <div>
                                    <label style="font-weight:600; display:block; margin-bottom:5px;">Division Name (Tamil)</label>
                                    <input type="text" id="divNameTa" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                                </div>
                            </div>
                            <div style="grid-column: span 2; display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
                                <div>
                                    <label style="font-weight:600; display:block; margin-bottom:5px;">Location (English)</label>
                                    <input type="text" id="divLocEn" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                                </div>
                                <div>
                                    <label style="font-weight:600; display:block; margin-bottom:5px;">Location (Sinhala)</label>
                                    <input type="text" id="divLocSi" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                                </div>
                                <div>
                                    <label style="font-weight:600; display:block; margin-bottom:5px;">Location (Tamil)</label>
                                    <input type="text" id="divLocTa" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                                </div>
                            </div>
                            <div style="grid-column: span 2;">
                                <label style="font-weight:600; display:block; margin-bottom:5px;">Address (English)</label>
                                <input type="text" id="divAddrEn" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                            </div>
                            <div style="grid-column: span 2;">
                                <label style="font-weight:600; display:block; margin-bottom:5px;">Address (Sinhala)</label>
                                <input type="text" id="divAddrSi" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                            </div>
                            <div style="grid-column: span 2;">
                                <label style="font-weight:600; display:block; margin-bottom:5px;">Address (Tamil)</label>
                                <input type="text" id="divAddrTa" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                            </div>
                            <div>
                                <label style="font-weight:600; display:block; margin-bottom:5px;">Phone Number</label>
                                <input type="text" id="divPhone" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                            </div>
                            <div>
                                <label style="font-weight:600; display:block; margin-bottom:5px;">Fax Number</label>
                                <input type="text" id="divFax" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                            </div>
                            <div style="grid-column: span 2;">
                                <label style="font-weight:600; display:block; margin-bottom:5px;">Email Address</label>
                                <input type="email" id="divEmail" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                            </div>
                            <div style="grid-column: span 2;">
                                <label style="font-weight:600; display:block; margin-bottom:5px;">Division Banner Image (Optional)</label>
                                <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 8px;">
                                    <input type="file" id="divBanner" accept="image/*" style="flex: 1; padding:10px; border-radius:8px; border:1px solid #ddd; background: white;">
                                    <button type="button" id="divRemoveBannerBtn" onclick="removeDivisionBanner()" style="display: none; background: #ef4444; color: white; border: none; padding: 10px 15px; border-radius: 8px; cursor: pointer; transition: background 0.3s; align-items: center; gap: 5px;"><i class="fas fa-trash"></i> Remove Banner</button>
                                </div>
                                <input type="hidden" id="divRemoveBannerFlag" value="0">
                                <div id="divBannerPreviewContainer" style="margin-top:10px; display:none;">
                                    <span style="font-size:0.85rem; color:#64748b; display:block; margin-bottom:5px;">Current Banner:</span>
                                    <img id="divBannerPreview" src="" style="max-width: 100%; max-height: 180px; border-radius: 8px; border: 1px solid #ddd; object-fit: contain; background: #f8fafc;">
                                </div>
                            </div>
                            <div style="grid-column: span 2;">
                                <label style="font-weight:600; display:block; margin-bottom:5px;">Division Profile Photo / Logo (Optional)</label>
                                <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 8px;">
                                    <input type="file" id="divLogo" accept="image/*" style="flex: 1; padding:10px; border-radius:8px; border:1px solid #ddd; background: white;">
                                    <button type="button" id="divRemoveLogoBtn" onclick="removeDivisionLogo()" style="display: none; background: #ef4444; color: white; border: none; padding: 10px 15px; border-radius: 8px; cursor: pointer; transition: background 0.3s; align-items: center; gap: 5px;"><i class="fas fa-trash"></i> Remove Logo</button>
                                </div>
                                <input type="hidden" id="divRemoveLogoFlag" value="0">
                                <div id="divLogoPreviewContainer" style="margin-top:10px; display:none;">
                                    <img id="divLogoPreview" src="" style="max-width: 180px; max-height: 120px; border-radius: 12px; border: 2px solid #d4af37; object-fit: contain; background: white;">
                                </div>
                            </div>
                            <button type="submit" class="dl-btn" style="border: none; cursor: pointer; grid-column: span 2; justify-content: center; padding: 12px 25px;"><i class="fas fa-save"></i> Save Division Details</button>
                        </form>
                        
                        <div id="divisionStaffSection" style="display: none; margin-top: 40px; border-top: 1px dashed var(--border-glass); padding-top: 30px;">
                            <h3 style="margin-bottom: 20px; color: var(--portal-blue); font-size: 1.2rem;"><i class="fas fa-users"></i> Division Key Staff</h3>
                            
                            <!-- List of current staff in this division -->
                            <div id="division-staff-list" style="display: grid; gap: 10px; margin-bottom: 20px;"></div>
                            
                            <!-- Sub-form to add/edit division staff -->
                            <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid var(--border-glass);">
                                <h4 id="divStaffFormHeader" style="margin-bottom: 15px; color: var(--portal-blue); font-size: 1.05rem; font-weight: 600;"><i class="fas fa-user-plus"></i> Add Division Staff Member</h4>
                                <form id="divStaffForm" style="display: grid; gap: 12px; grid-template-columns: 1fr 1fr;">
                                    <input type="hidden" id="divStaffId" value="">
                                    <input type="text" id="divStaffName" placeholder="Staff Name (e.g. Eng. K. Kumara)" required style="padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                                    <input type="text" id="divStaffTitle" placeholder="Designation (e.g. Divisional Engineer)" required style="padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                                    <input type="text" id="divStaffPhone" placeholder="Phone Number" required style="padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                                    <input type="email" id="divStaffEmail" placeholder="Email Address (Optional)" style="padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                                    
                                    <div style="grid-column: span 2; display: flex; gap: 10px; margin-top: 5px;">
                                        <button type="submit" id="divStaffSubmitBtn" class="dl-btn" style="flex: 1; border: none; cursor: pointer; justify-content: center; padding: 10px 20px;"><i class="fas fa-save"></i> Save Staff Member</button>
                                        <button type="button" id="divStaffCancelBtn" onclick="cancelDivStaffEdit()" class="dl-btn" style="display: none; background: #64748b; border: none; cursor: pointer; justify-content: center; padding: 10px 20px;"><i class="fas fa-times"></i> Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Services Tab -->
                <div id="admin-tab-services" class="admin-tab-content" style="display:none;">
                    <div class="admin-container" style="background: var(--glass-bg); padding: 30px; border-radius: 16px; border: 1px solid var(--border-glass);">
                        <h3 style="margin-bottom: 20px; color: var(--portal-blue);"><i class="fas fa-hand-holding-hand"></i> Update Services Details</h3>
                        <form id="servicesForm" style="display: grid; gap: 20px; margin-bottom: 30px;">
                            <div>
                                <label style="font-weight:600; display:block; margin-bottom:5px;">Investigations & Feasibility (One item per line)</label>
                                <textarea id="setServiceInvEn" placeholder="Items (English)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd; margin-bottom:8px;"></textarea>
                                <textarea id="setServiceInvSi" placeholder="Items (Sinhala)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd; margin-bottom:8px;"></textarea>
                                <textarea id="setServiceInvTa" placeholder="Items (Tamil)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd;"></textarea>
                            </div>
                            <hr style="border:none; border-top:1px solid #ddd;">
                            <div>
                                <label style="font-weight:600; display:block; margin-bottom:5px;">Detailed Engineering (One item per line)</label>
                                <textarea id="setServiceEngEn" placeholder="Items (English)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd; margin-bottom:8px;"></textarea>
                                <textarea id="setServiceEngSi" placeholder="Items (Sinhala)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd; margin-bottom:8px;"></textarea>
                                <textarea id="setServiceEngTa" placeholder="Items (Tamil)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd;"></textarea>
                            </div>
                            <div style="margin-top: 10px;">
                                <label style="font-weight:600; display:block; margin-bottom:5px;">Detailed Engineering Description</label>
                                <textarea id="setServiceEngDescEn" placeholder="Description (English)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd; margin-bottom:8px;"></textarea>
                                <textarea id="setServiceEngDescSi" placeholder="Description (Sinhala)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd; margin-bottom:8px;"></textarea>
                                <textarea id="setServiceEngDescTa" placeholder="Description (Tamil)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd;"></textarea>
                            </div>
                            <hr style="border:none; border-top:1px solid #ddd;">
                            <div>
                                <label style="font-weight:600; display:block; margin-bottom:5px;">Construction Management (One item per line)</label>
                                <textarea id="setServiceConstEn" placeholder="Items (English)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd; margin-bottom:8px;"></textarea>
                                <textarea id="setServiceConstSi" placeholder="Items (Sinhala)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd; margin-bottom:8px;"></textarea>
                                <textarea id="setServiceConstTa" placeholder="Items (Tamil)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd;"></textarea>
                            </div>
                            <div style="margin-top: 10px;">
                                <label style="font-weight:600; display:block; margin-bottom:5px;">Construction Management Description</label>
                                <textarea id="setServiceConstDescEn" placeholder="Description (English)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd; margin-bottom:8px;"></textarea>
                                <textarea id="setServiceConstDescSi" placeholder="Description (Sinhala)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd; margin-bottom:8px;"></textarea>
                                <textarea id="setServiceConstDescTa" placeholder="Description (Tamil)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd;"></textarea>
                            </div>
                            <hr style="border:none; border-top:1px solid #ddd;">
                            <div>
                                <label style="font-weight:600; display:block; margin-bottom:5px;">Operation & Maintenance (One item per line)</label>
                                <textarea id="setServiceOpEn" placeholder="Items (English)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd; margin-bottom:8px;"></textarea>
                                <textarea id="setServiceOpSi" placeholder="Items (Sinhala)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd; margin-bottom:8px;"></textarea>
                                <textarea id="setServiceOpTa" placeholder="Items (Tamil)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd;"></textarea>
                            </div>
                            <hr style="border:none; border-top:1px solid #ddd;">
                            <div>
                                <label style="font-weight:600; display:block; margin-bottom:5px;">Institutional & Manpower (One item per line)</label>
                                <textarea id="setServiceInstEn" placeholder="Items (English)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd; margin-bottom:8px;"></textarea>
                                <textarea id="setServiceInstSi" placeholder="Items (Sinhala)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd; margin-bottom:8px;"></textarea>
                                <textarea id="setServiceInstTa" placeholder="Items (Tamil)" required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd;"></textarea>
                            </div>
                            <button type="submit" class="dl-btn" style="border: none; cursor: pointer; justify-content: center; padding: 12px 25px;"><i class="fas fa-save"></i> Save Services Details</button>
                        </form>
                    </div>
                </div>

                <!-- Procurements Tab -->
                <div id="admin-tab-procurements" class="admin-tab-content" style="display:none;">
                    <div class="admin-container" style="background: var(--glass-bg); padding: 30px; border-radius: 16px; border: 1px solid var(--border-glass);">
                        <h3 id="procurementFormHeader" style="margin-bottom: 20px; color: var(--portal-blue);"><i class="fas fa-plus"></i> Add Procurement / Tender Notice</h3>
                        <form id="addProcurementForm" style="display: grid; gap: 15px; grid-template-columns: 1fr 1fr; margin-bottom: 30px;">
                            <input type="hidden" id="procurementId" value="">
                            <input type="text" id="procTitle" placeholder="Tender Title (e.g. Supply of Computers 2026)" required style="grid-column: span 2; padding: 12px; border-radius: 10px; border: 1px solid #ddd;">
                            <input type="file" id="procFile" style="grid-column: span 2; padding: 10px; border-radius: 10px; border: 1px solid #ddd; background: white;">
                            <select id="procStatus" style="grid-column: span 2; padding: 12px; border-radius: 10px; border: 1px solid #ddd; background: white;">
                                <option value="active">Active</option>
                                <option value="expired">Expired</option>
                            </select>
                            <div style="grid-column: span 2; display: flex; gap: 10px;">
                                <button type="submit" id="procSubmitBtn" class="dl-btn" style="flex: 1; border: none; cursor: pointer; justify-content: center; padding: 12px 25px;"><i class="fas fa-upload"></i> Publish Notice</button>
                                <button type="button" id="procCancelBtn" onclick="cancelProcurementEdit()" class="dl-btn" style="display: none; background: #64748b; border: none; cursor: pointer; justify-content: center; padding: 12px 25px;"><i class="fas fa-times"></i> Cancel</button>
                            </div>
                        </form>
                        <h3 style="margin-bottom: 20px; color: var(--portal-blue);">Existing Active Notices</h3>
                        <div id="admin-procurements-list" style="display: grid; gap: 10px;"></div>
                    </div>
                </div>

                <!-- Projects Tab -->
                <div id="admin-tab-projects" class="admin-tab-content" style="display:none;">
                    <div class="admin-container" style="background: var(--glass-bg); padding: 30px; border-radius: 16px; border: 1px solid var(--border-glass);">
                        <h3 id="projectFormHeader" style="margin-bottom: 20px; color: var(--portal-blue);"><i class="fas fa-plus"></i> Add Department Project</h3>
                        <form id="addProjectForm" style="display: grid; gap: 15px; grid-template-columns: 1fr 1fr; margin-bottom: 30px;">
                            <input type="hidden" id="projectId" value="">
                            <select id="projCategory" required style="grid-column: span 2; padding: 12px; border-radius: 10px; border: 1px solid #ddd; background:white;">
                                <option value="summary">Project Count/Financial Summary</option>
                                <option value="key">Key Ongoing Project</option>
                                <option value="completed">Completed Project</option>
                            </select>
                            <input type="text" id="projTitleEn" placeholder="Project Title (English)" required style="padding: 12px; border-radius: 10px; border: 1px solid #ddd;">
                            <input type="text" id="projTitleSi" placeholder="Project Title (Sinhala)" style="padding: 12px; border-radius: 10px; border: 1px solid #ddd;">
                            <textarea id="projDescEn" placeholder="Project Description (English)" required style="grid-column: span 2; height:80px; padding: 12px; border-radius: 10px; border: 1px solid #ddd;"></textarea>
                            <textarea id="projDescSi" placeholder="Project Description (Sinhala)" style="grid-column: span 2; height:80px; padding: 12px; border-radius: 10px; border: 1px solid #ddd;"></textarea>
                            <input type="text" id="projFinancial" placeholder="Financial details (e.g. LKR 150 Million)" style="padding: 12px; border-radius: 10px; border: 1px solid #ddd;">
                            <div style="display:flex; flex-direction:column; justify-content:center;">
                                <label style="font-size: 0.85rem; font-weight: 600; color: #475569; display: block; margin-bottom: 5px;">Main Cover Images (Optional)</label>
                                <input type="file" id="projImage" multiple accept="image/*" style="width:100%; padding: 10px; border-radius: 10px; border: 1px solid #ddd; background: white;">
                                <span style="font-size:0.75rem; color:#64748b; margin-top:3px; margin-left:5px;">Select up to 4 images</span>
                            </div>
                            
                            <div style="grid-column: span 2;">
                                <label style="font-size: 0.85rem; font-weight: 600; color: #475569; display: block; margin-bottom: 5px;">Project Photo Gallery Type</label>
                                <select id="projGalleryType" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #ddd; background:white;">
                                    <option value="none">No Gallery / Photos</option>
                                    <option value="renovation">Before / After Renovation Photos</option>
                                    <option value="event">Event / Gallery Photos</option>
                                </select>
                            </div>
                            
                            <!-- Before/After Renovation inputs for projects -->
                            <div id="projRenovationPhotosContainer" style="grid-column: span 2; display: none; grid-template-columns: 1fr 1fr; gap: 15px;">
                                <div>
                                    <label style="font-size: 0.85rem; font-weight: 600; color: #475569; display: block; margin-bottom: 5px;">Before Renovation Photos (Optional, Can upload multiple)</label>
                                    <input type="file" id="projImageBefore" multiple style="width: 100%; padding: 10px; border-radius: 10px; border: 1px solid #ddd; background: white;">
                                </div>
                                <div>
                                    <label style="font-size: 0.85rem; font-weight: 600; color: #475569; display: block; margin-bottom: 5px;">After Renovation Photos (Optional, Can upload multiple)</label>
                                    <input type="file" id="projImageAfter" multiple style="width: 100%; padding: 10px; border-radius: 10px; border: 1px solid #ddd; background: white;">
                                </div>
                            </div>
                            
                            <!-- Event Photos input for projects -->
                            <div id="projEventPhotosContainer" style="grid-column: span 2; display: none;">
                                <label style="font-size: 0.85rem; font-weight: 600; color: #475569; display: block; margin-bottom: 5px;">Event / Gallery Photos (Optional, Can upload multiple)</label>
                                <input type="file" id="projImageEvent" multiple style="width: 100%; padding: 10px; border-radius: 10px; border: 1px solid #ddd; background: white;">
                            </div>
                            <div style="grid-column: span 2; display: flex; gap: 10px;">
                                <button type="submit" id="projSubmitBtn" class="dl-btn" style="flex: 1; border: none; cursor: pointer; justify-content: center; padding: 12px 25px;"><i class="fas fa-save"></i> Save Project</button>
                                <button type="button" id="projCancelBtn" onclick="cancelProjectEdit()" class="dl-btn" style="display: none; background: #64748b; border: none; cursor: pointer; justify-content: center; padding: 12px 25px;"><i class="fas fa-times"></i> Cancel</button>
                            </div>
                        </form>
                        <h3 style="margin-bottom: 20px; color: var(--portal-blue);">Existing Projects</h3>
                        <div id="admin-projects-list" style="display: grid; gap: 10px;"></div>
                    </div>
                </div>

                <!-- Gallery Tab -->
                <div id="admin-tab-gallery" class="admin-tab-content" style="display:none;">
                    <div class="admin-container" style="background: var(--glass-bg); padding: 30px; border-radius: 16px; border: 1px solid var(--border-glass);">
                        <h3 id="galleryFormHeader" style="margin-bottom: 20px; color: var(--portal-blue);"><i class="fas fa-plus"></i> Upload Photo to Gallery</h3>
                        <form id="addGalleryForm" style="display: grid; gap: 15px; grid-template-columns: 1fr 1fr; margin-bottom: 30px;">
                            <input type="hidden" id="galleryId" value="">
                            <input type="text" id="galTitle" placeholder="Photo Caption / Title" required style="grid-column: span 2; padding: 12px; border-radius: 10px; border: 1px solid #ddd;">
                            <input type="text" id="galDesc" placeholder="Brief Description" required style="grid-column: span 2; padding: 12px; border-radius: 10px; border: 1px solid #ddd;">
                            <div style="grid-column: span 2; display: flex; flex-direction: column;">
                                <label style="font-size: 0.85rem; font-weight: 600; color: #475569; display: block; margin-bottom: 5px;">Select Image(s) (Optional)</label>
                                <input type="file" id="galImage" multiple style="width: 100%; padding: 10px; border-radius: 10px; border: 1px solid #ddd; background: white;">
                                <span style="font-size:0.75rem; color:#64748b; margin-top:3px; margin-left:5px;">Select up to 10 images</span>
                            </div>
                            <div style="grid-column: span 2; display: flex; gap: 10px;">
                                <button type="submit" id="galSubmitBtn" class="dl-btn" style="flex: 1; border: none; cursor: pointer; justify-content: center; padding: 12px 25px;"><i class="fas fa-upload"></i> Upload to Gallery</button>
                                <button type="button" id="galCancelBtn" onclick="cancelGalleryEdit()" class="dl-btn" style="display: none; background: #64748b; border: none; cursor: pointer; justify-content: center; padding: 12px 25px;"><i class="fas fa-times"></i> Cancel</button>
                            </div>
                        </form>
                        <h3 style="margin-bottom: 20px; color: var(--portal-blue);">Existing Photos</h3>
                        <div id="admin-gallery-list" style="display: grid; gap: 10px;"></div>
                    </div>
                </div>

                <!-- Announcements Tab -->
                <div id="admin-tab-announcements" class="admin-tab-content" style="display:none;">
                    <div class="admin-container" style="background: var(--glass-bg); padding: 30px; border-radius: 16px; border: 1px solid var(--border-glass);">
                        <h3 id="announcementFormHeader" style="margin-bottom: 20px; color: var(--portal-blue);"><i class="fas fa-bullhorn"></i> Add Announcement</h3>
                        <form id="addAnnouncementForm" style="display: grid; gap: 15px; grid-template-columns: 1fr 1fr; margin-bottom: 30px;">
                            <input type="hidden" id="announcementId" value="">
                            <select id="annCategory" required style="padding: 12px; border-radius: 10px; border: 1px solid #ddd; background:white;">
                                <option value="internal">Internal Announcement</option>
                                <option value="outside">Outside Announcement</option>
                            </select>
                            <input type="text" id="annTitle" placeholder="Announcement Title (e.g. Technical Training 2026)" required style="padding: 12px; border-radius: 10px; border: 1px solid #ddd;">
                            <input type="text" id="annUrl" placeholder="Link URL (optional, e.g. details.html)" style="padding: 12px; border-radius: 10px; border: 1px solid #ddd;">
                            <input type="text" id="annBadge" placeholder="Badge text (optional, e.g. New, Hot)" style="padding: 12px; border-radius: 10px; border: 1px solid #ddd;">
                            <div style="grid-column: span 2; display: flex; gap: 10px;">
                                <button type="submit" id="annSubmitBtn" class="dl-btn" style="flex: 1; border: none; cursor: pointer; justify-content: center; padding: 12px 25px;"><i class="fas fa-save"></i> Save Announcement</button>
                                <button type="button" id="annCancelBtn" onclick="cancelAnnouncementEdit()" class="dl-btn" style="display: none; background: #64748b; border: none; cursor: pointer; justify-content: center; padding: 12px 25px;"><i class="fas fa-times"></i> Cancel</button>
                            </div>
                        </form>
                        <h3 style="margin-bottom: 20px; color: var(--portal-blue);">Existing Announcements</h3>
                        <div id="admin-announcements-list" style="display: grid; gap: 10px;"></div>
                    </div>
                </div>

                <!-- Latest News Tab -->
                <div id="admin-tab-news" class="admin-tab-content" style="display:none;">
                    <div class="admin-container" style="background: var(--glass-bg); padding: 30px; border-radius: 16px; border: 1px solid var(--border-glass);">
                        <h3 id="newsFormHeader" style="margin-bottom: 20px; color: var(--portal-blue);"><i class="fas fa-newspaper"></i> Add News Article</h3>
                        <form id="addNewsForm" style="display: grid; gap: 15px; grid-template-columns: 1fr 1fr; margin-bottom: 30px;">
                            <input type="hidden" id="newsId" value="">
                            <select id="newsCategory" required style="grid-column: span 2; padding: 12px; border-radius: 10px; border: 1px solid #ddd; background:white;">
                                <option value="dept-news">Department News</option>
                                <option value="prov-news">Provincial News</option>
                            </select>
                            <input type="text" id="newsTitle" placeholder="News Title" required style="padding: 12px; border-radius: 10px; border: 1px solid #ddd;">
                            <input type="date" id="newsDate" required style="padding: 12px; border-radius: 10px; border: 1px solid #ddd;">
                            <textarea id="newsContent" placeholder="News Content Description" required style="grid-column: span 2; height: 100px; padding: 12px; border-radius: 10px; border: 1px solid #ddd;"></textarea>
                            <input type="text" id="newsUrl" placeholder="Read More Link URL (optional)" style="grid-column: span 2; padding: 12px; border-radius: 10px; border: 1px solid #ddd;">
                            
                            <div style="grid-column: span 2; display: grid; grid-template-columns: 1fr; gap: 15px;">
                                <div>
                                    <label style="font-size: 0.85rem; font-weight: 600; color: #475569; display: block; margin-bottom: 5px;">Main News Cover Photo (Optional)</label>
                                    <input type="file" id="newsImage" style="width: 100%; padding: 10px; border-radius: 10px; border: 1px solid #ddd; background: white;">
                                </div>
                            </div>
                            
                            <div style="grid-column: span 2;">
                                <label style="font-size: 0.85rem; font-weight: 600; color: #475569; display: block; margin-bottom: 5px;">News Photo Gallery Type</label>
                                <select id="newsGalleryType" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #ddd; background:white;">
                                    <option value="none">No Gallery / Photos</option>
                                    <option value="renovation">Before / After Renovation Photos</option>
                                    <option value="event">Event / Gallery Photos</option>
                                </select>
                            </div>
                            
                            <!-- Before/After Renovation inputs -->
                            <div id="newsRenovationPhotosContainer" style="grid-column: span 2; display: none; grid-template-columns: 1fr 1fr; gap: 15px;">
                                <div>
                                    <label style="font-size: 0.85rem; font-weight: 600; color: #475569; display: block; margin-bottom: 5px;">Before Renovation Photos (Optional, Can upload multiple)</label>
                                    <input type="file" id="newsImageBefore" multiple style="width: 100%; padding: 10px; border-radius: 10px; border: 1px solid #ddd; background: white;">
                                </div>
                                <div>
                                    <label style="font-size: 0.85rem; font-weight: 600; color: #475569; display: block; margin-bottom: 5px;">After Renovation Photos (Optional, Can upload multiple)</label>
                                    <input type="file" id="newsImageAfter" multiple style="width: 100%; padding: 10px; border-radius: 10px; border: 1px solid #ddd; background: white;">
                                </div>
                            </div>
                            
                            <!-- Event Photos input -->
                            <div id="newsEventPhotosContainer" style="grid-column: span 2; display: none;">
                                <label style="font-size: 0.85rem; font-weight: 600; color: #475569; display: block; margin-bottom: 5px;">Event / Gallery Photos (Optional, Can upload multiple)</label>
                                <input type="file" id="newsImageEvent" multiple style="width: 100%; padding: 10px; border-radius: 10px; border: 1px solid #ddd; background: white;">
                            </div>
                            
                            <div style="grid-column: span 2; display: flex; gap: 10px;">
                                <button type="submit" id="newsSubmitBtn" class="dl-btn" style="border: none; cursor: pointer; flex: 1; justify-content: center; padding: 12px 25px;"><i class="fas fa-save"></i> Publish News</button>
                                <button type="button" id="newsCancelBtn" onclick="cancelNewsEdit()" style="display:none; background:#64748b; color:white; border:none; padding:12px 25px; border-radius:30px; font-size:0.95rem; font-weight:500; cursor:pointer; justify-content:center; align-items:center; gap:8px;"><i class="fas fa-times"></i> Cancel</button>
                            </div>
                        </form>
                        <h3 style="margin-bottom: 20px; color: var(--portal-blue);">Existing Articles</h3>
                        <div id="admin-news-list" style="display: grid; gap: 10px;"></div>
                    </div>
                </div>

                <!-- Courses Tab -->
                <div id="admin-tab-courses" class="admin-tab-content" style="display:none;">
                    <div class="admin-container" style="background: var(--glass-bg); padding: 30px; border-radius: 16px; border: 1px solid var(--border-glass);">
                        <h3 id="courseFormHeader" style="margin-bottom: 20px; color: var(--portal-blue);"><i class="fas fa-graduation-cap"></i> Add Course / Event</h3>
                        <form id="addCourseForm" style="display: grid; gap: 15px; grid-template-columns: 1fr 1fr; margin-bottom: 30px;">
                            <input type="hidden" id="courseId" value="">
                            <select id="courseCategory" required style="padding: 12px; border-radius: 10px; border: 1px solid #ddd; background:white;">
                                <option value="upcoming">Upcoming Course/Event</option>
                                <option value="completed">Completed Course/Event</option>
                            </select>
                            <input type="text" id="courseTitle" placeholder="Course Title (e.g. Building Automation)" required style="padding: 12px; border-radius: 10px; border: 1px solid #ddd;">
                            <input type="date" id="courseDate" required style="padding: 12px; border-radius: 10px; border: 1px solid #ddd;">
                            <input type="text" id="courseLocation" placeholder="Location (e.g. Zoom, Head Office)" required style="padding: 12px; border-radius: 10px; border: 1px solid #ddd;">
                            <input type="text" id="courseUrl" placeholder="Event Details URL (optional)" style="grid-column: span 2; padding: 12px; border-radius: 10px; border: 1px solid #ddd;">
                            <div style="grid-column: span 2; display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                                <div>
                                    <label style="font-weight:600; display:block; margin-bottom:5px; color:#475569; font-size:0.9rem;">Icon Style</label>
                                    <select id="courseIcon" style="width:100%; padding: 12px; border-radius: 10px; border: 1px solid #ddd; background:white; cursor:pointer;">
                                        <option value="fa-graduation-cap">Graduation Cap (fa-graduation-cap)</option>
                                        <option value="fa-laptop-code">Laptop Code (fa-laptop-code)</option>
                                        <option value="fa-user-gear">User Gear (fa-user-gear)</option>
                                        <option value="fa-calculator">Calculator (fa-calculator)</option>
                                        <option value="fa-calendar-days">Calendar (fa-calendar-days)</option>
                                        <option value="fa-book">Book (fa-book)</option>
                                        <option value="fa-award">Award (fa-award)</option>
                                        <option value="fa-users">Users / Team (fa-users)</option>
                                        <option value="fa-chalkboard-user">Chalkboard User (fa-chalkboard-user)</option>
                                        <option value="fa-network-wired">Network Wired (fa-network-wired)</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-weight:600; display:block; margin-bottom:5px; color:#475569; font-size:0.9rem;">Custom Icon Class (Optional)</label>
                                    <input type="text" id="courseIconCustom" placeholder="e.g. fa-flag (overrides selection)" style="width:100%; padding: 12px; border-radius: 10px; border: 1px solid #ddd;">
                                </div>
                            </div>
                            <div style="grid-column: span 2; display: flex; gap: 10px;">
                                <button type="submit" id="courseSubmitBtn" class="dl-btn" style="flex: 1; border: none; cursor: pointer; justify-content: center; padding: 12px 25px;"><i class="fas fa-save"></i> Save Course</button>
                                <button type="button" id="courseCancelBtn" onclick="cancelCourseEdit()" class="dl-btn" style="display: none; background: #64748b; border: none; cursor: pointer; justify-content: center; padding: 12px 25px;"><i class="fas fa-times"></i> Cancel</button>
                            </div>
                        </form>
                        <h3 style="margin-bottom: 20px; color: var(--portal-blue);">Existing Courses & Events</h3>
                        <div id="admin-courses-list" style="display: grid; gap: 10px;"></div>
                    </div>
                </div>

                <!-- Links Tab -->
                <div id="admin-tab-links" class="admin-tab-content" style="display:none;">
                    <div class="admin-container" style="background: var(--glass-bg); padding: 30px; border-radius: 16px; border: 1px solid var(--border-glass);">
                        <h3 id="linkFormHeader" style="margin-bottom: 20px; color: var(--portal-blue);"><i class="fas fa-link"></i> Add Important Link</h3>
                        <form id="addLinkForm" style="display: grid; gap: 15px; grid-template-columns: 1fr 1fr; margin-bottom: 30px;">
                            <input type="hidden" id="linkId" value="">
                            <select id="linkCategory" required style="grid-column: span 2; padding: 12px; border-radius: 10px; border: 1px solid #ddd; background:white;">
                                <option value="govt-links">Government Link</option>
                                <option value="tech-links">Engineering Link</option>
                            </select>
                            <input type="text" id="linkTitle" placeholder="Link Text Title" required style="padding: 12px; border-radius: 10px; border: 1px solid #ddd;">
                            <input type="url" id="linkUrl" placeholder="Target URL (e.g. https://govt.lk)" required style="padding: 12px; border-radius: 10px; border: 1px solid #ddd;">
                            <input type="file" id="linkImage" style="grid-column: span 2; padding: 10px; border-radius: 10px; border: 1px solid #ddd; background: white;">
                            <div style="grid-column: span 2; display: flex; gap: 10px;">
                                <button type="submit" id="linkSubmitBtn" class="dl-btn" style="flex: 1; border: none; cursor: pointer; justify-content: center; padding: 12px 25px;"><i class="fas fa-save"></i> Save Link</button>
                                <button type="button" id="linkCancelBtn" onclick="cancelLinkEdit()" class="dl-btn" style="display: none; background: #64748b; border: none; cursor: pointer; justify-content: center; padding: 12px 25px;"><i class="fas fa-times"></i> Cancel</button>
                            </div>
                        </form>
                        <h3 style="margin-bottom: 20px; color: var(--portal-blue);">Existing Links</h3>
                        <div id="admin-links-list" style="display: grid; gap: 10px;"></div>
                    </div>
                </div>

                <!-- Achievements Tab -->
                <div id="admin-tab-achievements" class="admin-tab-content" style="display:none;">
                    <div class="admin-container" style="background: var(--glass-bg); padding: 30px; border-radius: 16px; border: 1px solid var(--border-glass);">
                        <h3 id="achievementFormHeader" style="margin-bottom: 20px; color: var(--portal-blue);"><i class="fas fa-trophy"></i> Add Achievement</h3>
                        <form id="addAchievementForm" style="display: grid; gap: 15px; grid-template-columns: 1fr 1fr; margin-bottom: 30px;">
                            <input type="hidden" id="achievementId" value="">
                            
                            <div style="grid-column: span 2; display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
                                <div>
                                    <label style="font-weight:600; display:block; margin-bottom:5px;">Title (English)</label>
                                    <input type="text" id="achTitleEn" placeholder="e.g. Construction Excellence" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                                </div>
                                <div>
                                    <label style="font-weight:600; display:block; margin-bottom:5px;">Title (Sinhala)</label>
                                    <input type="text" id="achTitleSi" placeholder="ජයග්‍රහණයේ මාතෘකාව" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                                </div>
                                <div>
                                    <label style="font-weight:600; display:block; margin-bottom:5px;">Title (Tamil)</label>
                                    <input type="text" id="achTitleTa" placeholder="தலைப்பு" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                                </div>
                            </div>

                            <div style="grid-column: span 2;">
                                <label style="font-weight:600; display:block; margin-bottom:5px;">Description (English)</label>
                                <textarea id="achDescEn" placeholder="Describe the achievement in English..." required style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd;"></textarea>
                            </div>
                            <div style="grid-column: span 2;">
                                <label style="font-weight:600; display:block; margin-bottom:5px;">Description (Sinhala)</label>
                                <textarea id="achDescSi" placeholder="විස්තරය සිංහලෙන්..." style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd;"></textarea>
                            </div>
                            <div style="grid-column: span 2;">
                                <label style="font-weight:600; display:block; margin-bottom:5px;">Description (Tamil)</label>
                                <textarea id="achDescTa" placeholder="විස්තරය දෙමළෙන්..." style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ddd;"></textarea>
                            </div>

                            <div>
                                <label style="font-weight:600; display:block; margin-bottom:5px;">Icon Style</label>
                                <select id="achIconClass" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd; background:white; cursor:pointer;">
                                    <option value="fa-trophy">Trophy (fa-trophy)</option>
                                    <option value="fa-building">Building (fa-building)</option>
                                    <option value="fa-award">Award (fa-award)</option>
                                    <option value="fa-medal">Medal (fa-medal)</option>
                                    <option value="fa-star">Star (fa-star)</option>
                                    <option value="fa-graduation-cap">Graduation Cap (fa-graduation-cap)</option>
                                    <option value="fa-users">Users / Team (fa-users)</option>
                                    <option value="fa-check-double">Check Double (fa-check-double)</option>
                                    <option value="fa-chart-line">Chart Line (fa-chart-line)</option>
                                    <option value="fa-landmark">Landmark (fa-landmark)</option>
                                    <option value="fa-gears">Gears (fa-gears)</option>
                                </select>
                            </div>
                            <div>
                                <label style="font-weight:600; display:block; margin-bottom:5px;">Custom Icon Class (Optional)</label>
                                <input type="text" id="achIconClassCustom" placeholder="e.g. fa-flag (overrides selection)" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                            </div>

                            <div style="grid-column: span 2; display: flex; gap: 10px;">
                                <button type="submit" id="achSubmitBtn" class="dl-btn" style="flex: 1; border: none; cursor: pointer; justify-content: center; padding: 12px 25px;"><i class="fas fa-save"></i> Save Achievement</button>
                                <button type="button" id="achCancelBtn" onclick="cancelAchievementEdit()" class="dl-btn" style="display: none; background: #64748b; border: none; cursor: pointer; justify-content: center; padding: 12px 25px;"><i class="fas fa-times"></i> Cancel</button>
                            </div>
                        </form>
                        <h3 style="margin-bottom: 20px; color: var(--portal-blue);">Existing Achievements</h3>
                        <div id="admin-achievements-list" style="display: grid; gap: 10px;"></div>
                    </div>
                </div>

                <!-- RTI Officers Tab -->
                <div id="admin-tab-rti_officers" class="admin-tab-content" style="display:none;">
                    <div class="admin-container" style="background: var(--glass-bg); padding: 30px; border-radius: 16px; border: 1px solid var(--border-glass);">
                        <h3 id="rtiOfficerFormHeader" style="margin-bottom: 20px; color: var(--portal-blue);"><i class="fas fa-plus"></i> Add RTI Officer</h3>
                        <form id="addRtiOfficerForm" style="display: grid; gap: 15px; grid-template-columns: 1fr 1fr; margin-bottom: 30px;">
                            <input type="hidden" id="rtiOfficerId" value="">
                            
                            <div>
                                <label style="font-weight:600; display:block; margin-bottom:5px;">Role Type</label>
                                <select id="rtiRoleType" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd; background:white; cursor:pointer;">
                                    <option value="designated">Designated Officer (නම් කළ නිලධාරියා)</option>
                                    <option value="information">Information Officer (තොරතුරු නිලධාරි)</option>
                                </select>
                            </div>
                            
                            <div>
                                <label style="font-weight:600; display:block; margin-bottom:5px;">Phone Number</label>
                                <input type="text" id="rtiPhone" placeholder="e.g. +94 37 222 4510" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                            </div>
                            
                            <div style="grid-column: span 2; display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
                                <div>
                                    <label style="font-weight:600; display:block; margin-bottom:5px;">Full Name (English)</label>
                                    <input type="text" id="rtiNameEn" placeholder="e.g. T.H.M.D.C.E. Peiris" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                                </div>
                                <div>
                                    <label style="font-weight:600; display:block; margin-bottom:5px;">Full Name (Sinhala)</label>
                                    <input type="text" id="rtiNameSi" placeholder="e.g. ටී.එච්.එම්.ඩී.සී.ඊ. පීරිස්" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                                </div>
                                <div>
                                    <label style="font-weight:600; display:block; margin-bottom:5px;">Full Name (Tamil)</label>
                                    <input type="text" id="rtiNameTa" placeholder="e.g. டி.எச்.எம்.டி.சி.ஈ. பீரிஸ்" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                                </div>
                            </div>

                            <div style="grid-column: span 2; display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
                                <div>
                                    <label style="font-weight:600; display:block; margin-bottom:5px;">Designation (English)</label>
                                    <input type="text" id="rtiDesignationEn" placeholder="e.g. Provincial Director" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                                </div>
                                <div>
                                    <label style="font-weight:600; display:block; margin-bottom:5px;">Designation (Sinhala)</label>
                                    <input type="text" id="rtiDesignationSi" placeholder="e.g. පළාත් අධ්‍යක්ෂ" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                                </div>
                                <div>
                                    <label style="font-weight:600; display:block; margin-bottom:5px;">Designation (Tamil)</label>
                                    <input type="text" id="rtiDesignationTa" placeholder="e.g. மாகாண பணிப்பாளர்" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                                </div>
                            </div>

                            <div style="grid-column: span 2;">
                                <label style="font-weight:600; display:block; margin-bottom:5px;">Email Address</label>
                                <input type="email" id="rtiEmail" placeholder="e.g. peirishmd@yahoo.com" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                            </div>

                            <div style="grid-column: span 2; display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
                                <div>
                                    <label style="font-weight:600; display:block; margin-bottom:5px;">Address (English)</label>
                                    <input type="text" id="rtiAddressEn" placeholder="e.g. Department of Engineering, NWP, Kurunegala" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                                </div>
                                <div>
                                    <label style="font-weight:600; display:block; margin-bottom:5px;">Address (Sinhala)</label>
                                    <input type="text" id="rtiAddressSi" placeholder="e.g. ඉංජිනේරු දෙපාර්තමේන්තුව, වයඹ පළාත, කුරුණෑගල" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                                </div>
                                <div>
                                    <label style="font-weight:600; display:block; margin-bottom:5px;">Address (Tamil)</label>
                                    <input type="text" id="rtiAddressTa" placeholder="e.g. பொறியியல் திணைக்களம், வடமேல் மாகாணம், குருநாகல்" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                                </div>
                            </div>

                            <div style="grid-column: span 2; display: flex; gap: 10px;">
                                <button type="submit" id="rtiSubmitBtn" class="dl-btn" style="flex: 1; border: none; cursor: pointer; justify-content: center; padding: 12px 25px;"><i class="fas fa-save"></i> Save RTI Officer</button>
                                <button type="button" id="rtiCancelBtn" onclick="cancelRtiOfficerEdit()" class="dl-btn" style="display: none; background: #64748b; border: none; cursor: pointer; justify-content: center; padding: 12px 25px;"><i class="fas fa-times"></i> Cancel</button>
                            </div>
                        </form>
                        <h3 style="margin-bottom: 20px; color: var(--portal-blue);">Existing RTI Officers</h3>
                        <div id="admin-rti-officers-list" style="display: grid; gap: 10px; margin-bottom: 30px;"></div>

                        <!-- Separator line -->
                        <hr style="margin: 40px 0; border: none; border-top: 1px dashed #cbd5e1;">

                        <!-- RTI Application Form Upload Panel -->
                        <h3 style="margin-bottom: 20px; color: var(--portal-blue); display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-file-pdf"></i> Official RTI Application Form (RTI 01)
                        </h3>
                        <form id="uploadRtiForm" style="display: grid; gap: 15px; grid-template-columns: 1fr 1fr 1fr; margin-bottom: 20px;">
                            <div>
                                <label style="font-weight:600; display:block; margin-bottom:5px;">English Version Form</label>
                                <input type="file" id="rtiFileEn" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd; background:white;">
                                <div id="rtiFileStatusEn" style="margin-top: 5px; font-size: 0.8rem; color: #64748b; word-break: break-all;">No file uploaded</div>
                            </div>
                            <div>
                                <label style="font-weight:600; display:block; margin-bottom:5px;">Sinhala Version Form</label>
                                <input type="file" id="rtiFileSi" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd; background:white;">
                                <div id="rtiFileStatusSi" style="margin-top: 5px; font-size: 0.8rem; color: #64748b; word-break: break-all;">No file uploaded</div>
                            </div>
                            <div>
                                <label style="font-weight:600; display:block; margin-bottom:5px;">Tamil Version Form</label>
                                <input type="file" id="rtiFileTa" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd; background:white;">
                                <div id="rtiFileStatusTa" style="margin-top: 5px; font-size: 0.8rem; color: #64748b; word-break: break-all;">No file uploaded</div>
                            </div>
                            <div style="grid-column: span 3; display: flex; gap: 10px;">
                                <button type="submit" class="dl-btn" style="flex: 1; border: none; cursor: pointer; justify-content: center; padding: 12px 25px;"><i class="fas fa-upload"></i> Upload & Save RTI Forms</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <script src="members_login_db.js?v=1"></script>
    <script>
        // Check Session
        const loggedInUser = JSON.parse(sessionStorage.getItem('loggedInUser'));
        if (loggedInUser) {
            document.getElementById('loggedUserName').textContent = loggedInUser.username;
            const isSystemAdmin = loggedInUser.role === 'admin' || loggedInUser.role === 'staff';
            document.getElementById('loggedUserRole').textContent = isSystemAdmin ? 'System Admin' : 'Member';
            
            if (isSystemAdmin) {
                document.querySelectorAll('.admin-only').forEach(el => {
                    if(el.tagName === 'LI') el.style.display = 'list-item';
                });
                setTimeout(loadUsers, 100);
            }
        } else {
            // Redirect to login page
            window.location.href = 'login.html';
        }

        const navLinks = document.querySelectorAll('.nav-link');
        const sections = document.querySelectorAll('.view-section');

        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                navLinks.forEach(l => l.classList.remove('active'));
                sections.forEach(s => s.classList.remove('active'));
                
                link.classList.add('active');
                const targetId = link.getAttribute('data-target');
                document.getElementById(targetId).classList.add('active');
            });
        });

        // --- CMS Backend Integration Logic ---
        let globalDivisions = [];
        let globalOfficers = [];

        // 1. Users
        const userTableBody = document.getElementById('userTableBody');
        const addUserForm = document.getElementById('addUserForm');

        function loadUsers() {
            if (!userTableBody) return;
            fetch('manage_users.php')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    renderUserTable(data.users);
                }
            })
            .catch(err => console.error("User load error:", err));
        }

        function renderUserTable(users) {
            userTableBody.innerHTML = '';
            users.forEach((user) => {
                let badgeStyle = '';
                if (user.role === 'admin') {
                    badgeStyle = 'background: #fee2e2; color: #ef4444;';
                } else if (user.role === 'staff') {
                    badgeStyle = 'background: #fef3c7; color: #d97706;';
                } else {
                    badgeStyle = 'background: #e0e7ff; color: #4f46e5;';
                }
                const tr = document.createElement('tr');
                tr.style.borderBottom = '1px solid var(--border-glass)';
                tr.innerHTML = `
                    <td style="padding: 15px 20px; color: var(--text-dark);"><strong>${user.username}</strong></td>
                    <td style="padding: 15px 20px; color: var(--text-muted); text-transform: capitalize;">
                        <span style="${badgeStyle} padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">${user.role}</span>
                    </td>
                    <td style="padding: 15px 20px; text-align: right;">
                        ${user.username !== 'admin' ? `<button onclick="deleteUser('${user.username}')" style="background: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; transition: all 0.3s; font-size: 0.85rem;"><i class="fas fa-trash"></i> Delete</button>` : '<span style="color: #94a3b8; font-size: 0.85rem; font-style: italic;">Cannot delete</span>'}
                    </td>
                `;
                userTableBody.appendChild(tr);
            });
        }

        window.deleteUser = function(username) {
            if (!confirm(`Are you sure you want to remove access for ${username}?`)) return;
            fetch(`manage_users.php?username=${encodeURIComponent(username)}`, {
                method: 'DELETE'
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    // Sync with local fallback database in localStorage
                    let localUsers = JSON.parse(localStorage.getItem('portalUsers')) || [];
                    localUsers = localUsers.filter(u => u.username !== username);
                    localStorage.setItem('portalUsers', JSON.stringify(localUsers));
                    
                    loadUsers();
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(err => alert("Failed to delete user."));
        };

        if (addUserForm) {
            addUserForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const username = document.getElementById('newUsername').value.trim();
                const password = document.getElementById('newPassword').value.trim();
                const role = document.getElementById('newRole').value;

                if (!username || !password) {
                    alert('Please enter both username and password.');
                    return;
                }

                const formData = new FormData();
                formData.append('username', username);
                formData.append('password', password);
                formData.append('role', role);

                fetch('manage_users.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Sync with local fallback database in localStorage
                        const localUsers = JSON.parse(localStorage.getItem('portalUsers')) || [];
                        // Check if user already exists in localStorage before pushing
                        if (!localUsers.some(u => u.username === username)) {
                            localUsers.push({ username: username, password: password, name: username, role: role });
                            localStorage.setItem('portalUsers', JSON.stringify(localUsers));
                        }
                        
                        addUserForm.reset();
                        loadUsers();
                        alert("User created successfully!");
                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch(err => alert("Database connection failed."));
            });
        }

        // 2. Officers
        const addOfficerForm = document.getElementById('addOfficerForm');
        function loadOfficers() {
            fetch('manage_officers.php')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    globalOfficers = data.officers;
                    renderOfficers(data.officers);
                }
            })
            .catch(err => console.error("Error loading officers:", err));
        }

        function renderOfficers(officers) {
            // HQ Officers
            const hqGrid = document.getElementById('hq-officers-grid');
            if (hqGrid) {
                hqGrid.innerHTML = officers.filter(o => o.category === 'executive' || o.category === 'admin' || o.category === 'hq').map(o => `
                    <div class="officer-card">
                        <div class="img-ring"><img src="${o.photo_url ? o.photo_url : `https://ui-avatars.com/api/?name=${encodeURIComponent(o.name)}&background=random`}" alt="Photo"></div>
                        <h4>${o.name}</h4><p class="title">${o.title}</p><p class="contact"><i class="fas fa-phone"></i> ${o.phone}</p>
                        ${o.email ? `<p class="contact" style="font-size: 0.8rem; word-break: break-all;"><i class="far fa-envelope"></i> ${o.email}</p>` : ''}
                    </div>
                `).join('');
            }

            // Division Officers
            const divGrid = document.getElementById('div-officers-grid');
            if (divGrid) {
                divGrid.innerHTML = officers.filter(o => o.category === 'div').map(o => `
                    <div class="officer-card">
                        <div class="img-ring"><img src="${o.photo_url ? o.photo_url : `https://ui-avatars.com/api/?name=${encodeURIComponent(o.name)}&background=random`}" alt="Photo"></div>
                        <h4>${o.name}</h4><p class="title">${o.title}</p><p class="contact"><i class="fas fa-phone"></i> ${o.phone}</p>
                        <p class="contact" style="font-size:0.8rem;"><i class="fas fa-map-marker-alt"></i> ${o.division}</p>
                        ${o.email ? `<p class="contact" style="font-size: 0.8rem; word-break: break-all;"><i class="far fa-envelope"></i> ${o.email}</p>` : ''}
                    </div>
                `).join('');
            }

            // Admin Officers List
            const adminOffList = document.getElementById('admin-officers-list');
            if (adminOffList) {
                adminOffList.innerHTML = officers.map(o => `
                    <div style="background:white; padding:12px; border-radius:8px; display:flex; justify-content:space-between; align-items:center; border:1px solid #e2e8f0; margin-bottom: 8px;">
                        <span><i class="fas fa-user text-muted" style="margin-right:10px;"></i> <strong>${o.name}</strong> <span style="font-size:0.8rem; color:#64748b;">(${o.category} - ${o.division})</span></span>
                        <div style="display: flex; gap: 5px;">
                            <button type="button" onclick="editOfficer(${o.id})" style="background:#3b82f6; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer;"><i class="fas fa-edit"></i></button>
                            <button type="button" onclick="deleteOfficer(${o.id})" style="background:#ef4444; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer;"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                `).join('');
            }
        }

        window.editOfficer = function(id) {
            const o = globalOfficers.find(item => item.id == id);
            if (!o) return;

            document.getElementById('officerId').value = o.id;
            document.getElementById('offName').value = o.name || '';
            document.getElementById('offTitle').value = o.title || '';
            document.getElementById('offPhone').value = o.phone || '';
            document.getElementById('offEmail').value = o.email || '';
            document.getElementById('offCategory').value = o.category || 'hq';
            document.getElementById('offDivision').value = o.division || '';

            document.getElementById('officerFormHeader').innerHTML = `<i class="fas fa-edit"></i> Edit Officer`;
            document.getElementById('officerSubmitBtn').innerHTML = `<i class="fas fa-save"></i> Update Officer`;
            document.getElementById('officerCancelBtn').style.display = 'inline-flex';

            document.getElementById('officerFormHeader').scrollIntoView({ behavior: 'smooth' });
        };

        window.cancelOfficerEdit = function() {
            if (addOfficerForm) addOfficerForm.reset();
            document.getElementById('officerId').value = '';
            document.getElementById('officerFormHeader').innerHTML = `<i class="fas fa-plus"></i> Add Officer`;
            document.getElementById('officerSubmitBtn').innerHTML = `<i class="fas fa-plus-circle"></i> Add Officer`;
            document.getElementById('officerCancelBtn').style.display = 'none';
        };

        window.deleteOfficer = function(id) {
            if (!confirm("Are you sure you want to delete this officer?")) return;
            fetch(`manage_officers.php?id=${id}`, { method: 'DELETE' })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    if (document.getElementById('officerId').value == id) {
                        cancelOfficerEdit();
                    }
                    loadOfficers();
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(err => alert("Failed to delete officer."));
        };

        if (addOfficerForm) {
            addOfficerForm.addEventListener('submit', e => {
                e.preventDefault();
                const officerIdVal = document.getElementById('officerId').value;
                const name = document.getElementById('offName').value.trim();
                const title = document.getElementById('offTitle').value.trim();
                const phone = document.getElementById('offPhone').value.trim();
                const email = document.getElementById('offEmail').value.trim();
                const category = document.getElementById('offCategory').value;
                const division = document.getElementById('offDivision').value.trim();
                const fileInput = document.getElementById('offPhoto');

                const formData = new FormData();
                if (officerIdVal) {
                    formData.append('id', officerIdVal);
                }
                formData.append('name', name);
                formData.append('title', title);
                formData.append('phone', phone);
                if (email) {
                    formData.append('email', email);
                }
                formData.append('category', category);
                formData.append('division', division);
                if (fileInput.files.length > 0) {
                    formData.append('photo', fileInput.files[0]);
                }

                fetch('manage_officers.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        cancelOfficerEdit();
                        loadOfficers();
                        alert(officerIdVal ? "Officer updated successfully!" : "Officer added successfully!");
                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch(err => alert("Failed to save officer."));
            });
        }

        // 3. Downloads
        let globalAdminDownloads = [];
        const addDownloadForm = document.getElementById('addDownloadForm');
        function loadDownloads() {
            fetch('manage_downloads.php')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    globalAdminDownloads = data.downloads;
                    renderDownloads(data.downloads);
                }
            })
            .catch(err => console.error("Error loading downloads:", err));
        }

        function renderDownloads(downloads) {
            const renderDl = (cat, elId) => {
                const el = document.getElementById(elId);
                if (!el) return;
                const filtered = downloads.filter(d => d.category === cat);
                el.innerHTML = filtered.length > 0 ? filtered.map(d => `
                    <div class="download-item">
                        <div class="download-info">
                            <div class="icon-box"><i class="fas ${d.icon_class || 'fa-file-alt'}"></i></div>
                            <div class="dl-text"><strong>${d.title}</strong><p>${d.description || ''}</p></div>
                        </div>
                        <a href="${d.file_url}" class="dl-btn" style="text-decoration:none;" download>
                            <i class="fas fa-cloud-download-alt"></i> Access
                        </a>
                    </div>
                `).join('') : '<p style="padding:20px; color:#64748b; text-align:center;">No documents available in this category.</p>';
            };

            renderDl('forms', 'formats-list');
            renderDl('transfers', 'transfers-list');
            renderDl('circulars', 'circulars-list');
            renderDl('rate_analysis', 'rate-list');

            // Render Admin Downloads List
            const adminDlList = document.getElementById('admin-downloads-list');
            if (adminDlList) {
                const catNames = {
                    rate_books: 'Rate Books (Public)',
                    type_plans: 'Type Plans (Public)',
                    progress_reports: 'Progress Reports (Public)',
                    rti: 'RTI Act (Public)',
                    forms: 'Internal Formats (Private)',
                    transfers: 'Internal Transfers (Private)',
                    circulars: 'Circulars (Private)',
                    rate_analysis: 'Rate Analysis (Private)',
                    rates: 'Rate Analysis (Legacy)'
                };
                adminDlList.innerHTML = downloads.map(d => `
                    <div style="background:white; padding:12px; border-radius:8px; display:flex; justify-content:space-between; align-items:center; border:1px solid #e2e8f0; margin-bottom: 8px;">
                        <span><i class="fas ${d.icon_class || 'fa-file-alt'} text-muted" style="margin-right:10px;"></i> <strong>${d.title}</strong> <span style="font-size:0.8rem; color:#64748b;">(${catNames[d.category] || d.category})</span></span>
                        <div style="display:flex; gap:8px;">
                            <button type="button" onclick="editDownload(${d.id})" style="background:#3b82f6; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer;"><i class="fas fa-edit"></i></button>
                            <button type="button" onclick="deleteDownload(${d.id})" style="background:#ef4444; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer;"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                `).join('');
            }
        }

        window.editDownload = function(id) {
            const d = globalAdminDownloads.find(item => item.id == id);
            if (!d) return;

            document.getElementById('downloadId').value = d.id;
            document.getElementById('dlTitle').value = d.title || '';
            document.getElementById('dlDesc').value = d.description || d.desc || '';
            document.getElementById('dlCategory').value = d.category || 'forms';
            document.getElementById('dlFile').value = '';

            document.getElementById('downloadFormHeader').innerHTML = `<i class="fas fa-edit"></i> Edit Document`;
            document.getElementById('downloadSubmitBtn').innerHTML = `<i class="fas fa-upload"></i> Update Document`;
            document.getElementById('downloadCancelBtn').style.display = 'inline-flex';

            document.getElementById('downloadFormHeader').scrollIntoView({ behavior: 'smooth' });
        };

        window.cancelDownloadEdit = function() {
            if (addDownloadForm) addDownloadForm.reset();
            document.getElementById('downloadId').value = '';
            document.getElementById('downloadFormHeader').innerHTML = `<i class="fas fa-plus"></i> Add Document`;
            document.getElementById('downloadSubmitBtn').innerHTML = `<i class="fas fa-upload"></i> Upload & Save Document`;
            document.getElementById('downloadCancelBtn').style.display = 'none';
        };

        window.deleteDownload = function(id) {
            if (!confirm("Are you sure you want to delete this document?")) return;
            fetch(`manage_downloads.php?id=${id}`, { method: 'DELETE' })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    if (document.getElementById('downloadId').value == id) {
                        cancelDownloadEdit();
                    }
                    loadDownloads();
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(err => alert("Failed to delete document."));
        };

        if (addDownloadForm) {
            addDownloadForm.addEventListener('submit', e => {
                e.preventDefault();
                const downloadIdVal = document.getElementById('downloadId').value;
                const fileInput = document.getElementById('dlFile');
                if (!downloadIdVal && !fileInput.files.length) {
                    alert("Please select a file to upload.");
                    return;
                }
                const title = document.getElementById('dlTitle').value.trim();
                const description = document.getElementById('dlDesc').value.trim();
                const category = document.getElementById('dlCategory').value;

                const formData = new FormData();
                if (downloadIdVal) {
                    formData.append('id', downloadIdVal);
                }
                formData.append('title', title);
                formData.append('description', description);
                formData.append('category', category);
                if (fileInput.files.length > 0) {
                    formData.append('file', fileInput.files[0]);
                }

                fetch('manage_downloads.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        cancelDownloadEdit();
                        loadDownloads();
                        alert(downloadIdVal ? "Document updated successfully!" : "Document uploaded and saved successfully!");
                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch(err => alert("Failed to save document."));
            });
        }

        // 4. Site Settings
        const settingsForm = document.getElementById('settingsForm');
        function loadSettings() {
            fetch('manage_settings.php')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    const s = data.settings;
                    
                    if (s.about_overview) {
                        document.getElementById('setOverviewEn').value = s.about_overview.en || '';
                        document.getElementById('setOverviewSi').value = s.about_overview.si || '';
                        document.getElementById('setOverviewTa').value = s.about_overview.ta || '';
                    }
                    if (s.about_objectives) {
                        document.getElementById('setObjectivesEn').value = s.about_objectives.en || '';
                        document.getElementById('setObjectivesSi').value = s.about_objectives.si || '';
                        document.getElementById('setObjectivesTa').value = s.about_objectives.ta || '';
                    }
                    if (s.contact_address) {
                        document.getElementById('setAddressEn').value = s.contact_address.en || '';
                        document.getElementById('setAddressSi').value = s.contact_address.si || '';
                    }
                    if (s.contact_phone) document.getElementById('setPhone').value = s.contact_phone.en || '';
                    if (s.contact_email) document.getElementById('setEmail').value = s.contact_email.en || '';
                    if (s.contact_map_url) document.getElementById('setMapUrl').value = s.contact_map_url.en || '';
                    if (s.news_bar) {
                        document.getElementById('setNewsBarEn').value = s.news_bar.en || '';
                        document.getElementById('setNewsBarSi').value = s.news_bar.si || '';
                        document.getElementById('setNewsBarTa').value = s.news_bar.ta || '';
                    }
                    if (s.visitor_count) {
                        document.getElementById('setVisitorCount').value = s.visitor_count.en || '';
                    }

                    // Load homepage slides
                    loadSlides();
                } else {
                    console.error("Database Error:", data.message);
                    alert("Database Error: " + data.message + "\n\nPlease make sure to run http://[server]/db_setup.php to configure the database.");
                }
            })
            .catch(err => {
                console.error("Error loading settings:", err);
                alert("Failed to load settings from server. Please check database connection.");
            });
        }

        if (settingsForm) {
            settingsForm.addEventListener('submit', e => {
                e.preventDefault();
                
                const payload = [
                    {
                        key: 'about_overview',
                        en: document.getElementById('setOverviewEn').value,
                        si: document.getElementById('setOverviewSi').value,
                        ta: document.getElementById('setOverviewTa').value
                    },
                    {
                        key: 'about_objectives',
                        en: document.getElementById('setObjectivesEn').value,
                        si: document.getElementById('setObjectivesSi').value,
                        ta: document.getElementById('setObjectivesTa').value
                    },
                    {
                        key: 'contact_address',
                        en: document.getElementById('setAddressEn').value,
                        si: document.getElementById('setAddressSi').value,
                        ta: document.getElementById('setAddressSi').value // use Sinhala as fallback
                    },
                    {
                        key: 'contact_phone',
                        en: document.getElementById('setPhone').value,
                        si: document.getElementById('setPhone').value,
                        ta: document.getElementById('setPhone').value
                    },
                    {
                        key: 'contact_email',
                        en: document.getElementById('setEmail').value,
                        si: document.getElementById('setEmail').value,
                        ta: document.getElementById('setEmail').value
                    },
                    {
                        key: 'contact_map_url',
                        en: document.getElementById('setMapUrl').value,
                        si: document.getElementById('setMapUrl').value,
                        ta: document.getElementById('setMapUrl').value
                    },
                    {
                        key: 'news_bar',
                        en: document.getElementById('setNewsBarEn').value.trim(),
                        si: document.getElementById('setNewsBarSi').value.trim(),
                        ta: document.getElementById('setNewsBarTa').value.trim()
                    },
                    {
                        key: 'visitor_count',
                        en: document.getElementById('setVisitorCount').value.trim(),
                        si: document.getElementById('setVisitorCount').value.trim(),
                        ta: document.getElementById('setVisitorCount').value.trim()
                    }
                ];

                let promises = payload.map(item => {
                    const formData = new FormData();
                    formData.append('section_key', item.key);
                    formData.append('content_en', item.en);
                    formData.append('content_si', item.si);
                    formData.append('content_ta', item.ta);
                    return fetch('manage_settings.php', { method: 'POST', body: formData }).then(res => res.json());
                });

                Promise.all(promises)
                .then(results => {
                    const errors = results.filter(r => r.status !== 'success');
                    if (errors.length === 0) {
                        alert("All site settings and text blocks updated successfully!");
                        loadSettings();
                    } else {
                        alert("Some settings failed to update: " + errors.map(e => e.message).join(', '));
                    }
                })
                .catch(err => alert("Failed to save settings."));
            });
        }

        // 4.1 Homepage Slideshow Management
        const uploadSlideForm = document.getElementById('uploadSlideForm');
        let globalSlides = [];

        function loadSlides() {
            const grid = document.getElementById('slidesGrid');
            const countEl = document.getElementById('slideCount');
            const fileInput = document.getElementById('slideFile');
            const uploadBtn = document.getElementById('uploadSlideBtn');
            if (!grid) return;

            fetch('manage_slides.php')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    globalSlides = data.slides;
                    if (countEl) countEl.innerText = globalSlides.length;
                    
                    if (globalSlides.length === 0) {
                        grid.innerHTML = '<div style="grid-column: span 3; padding: 30px; text-align: center; color: #64748b; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 12px;"><i class="fas fa-images" style="font-size: 2rem; margin-bottom: 8px; color: #94a3b8;"></i><p>No slideshow photos found. The homepage will display the default slideshow.</p></div>';
                    } else {
                        grid.innerHTML = globalSlides.map((slide, index) => `
                            <div class="slide-card" style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); display: flex; flex-direction: column; transition: all 0.3s;">
                                <div style="position: relative; height: 120px; background: #f1f5f9;">
                                    <img src="${slide.image_url}" style="width: 100%; height: 100%; object-fit: cover;">
                                    <span style="position: absolute; top: 8px; left: 8px; background: rgba(18, 35, 64, 0.85); color: white; padding: 3px 8px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">Slide ${index + 1}</span>
                                </div>
                                <div style="padding: 12px; display: flex; justify-content: space-between; align-items: center; background: #fafafa; border-top: 1px solid #f1f5f9;">
                                    <span style="font-size: 0.8rem; color: #64748b; font-family: monospace; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 110px;" title="${slide.image_url.split('/').pop()}">${slide.image_url.split('/').pop()}</span>
                                    <button type="button" onclick="deleteSlide(${slide.id})" style="background: #fee2e2; color: #ef4444; border: none; padding: 6px 10px; border-radius: 6px; cursor: pointer; transition: all 0.2s; font-size: 0.8rem;" onmouseover="this.style.background='#fecaca'; this.style.color='#dc2626';" onmouseout="this.style.background='#fee2e2'; this.style.color='#ef4444';">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        `).join('');
                    }

                    if (fileInput && uploadBtn) {
                        if (globalSlides.length >= 6) {
                            fileInput.disabled = true;
                            uploadBtn.disabled = true;
                            uploadBtn.style.opacity = '0.5';
                            uploadBtn.style.cursor = 'not-allowed';
                            uploadBtn.innerHTML = `<i class="fas fa-exclamation-circle"></i> Slide Limit Reached`;
                        } else {
                            fileInput.disabled = false;
                            uploadBtn.disabled = false;
                            uploadBtn.style.opacity = '1';
                            uploadBtn.style.cursor = 'pointer';
                            uploadBtn.innerHTML = `<i class="fas fa-plus-circle"></i> Add New Slide`;
                        }
                    }
                } else {
                    console.error("Error loading slides:", data.message);
                    grid.innerHTML = `<div style="grid-column: span 3; padding: 20px; text-align: center; color: #ef4444; background: #fee2e2; border: 1px solid #fecaca; border-radius: 8px;"><i class="fas fa-exclamation-triangle" style="font-size: 1.5rem; margin-bottom: 5px;"></i><p>Database Error: ${data.message}</p></div>`;
                }
            })
            .catch(err => {
                console.error("Error loading slides:", err);
                grid.innerHTML = '<div style="grid-column: span 3; padding: 20px; text-align: center; color: #ef4444; background: #fee2e2; border: 1px solid #fecaca; border-radius: 8px;"><i class="fas fa-exclamation-triangle" style="font-size: 1.5rem; margin-bottom: 5px;"></i><p>Failed to load slides from server.</p></div>';
            });
        }

        if (uploadSlideForm) {
            uploadSlideForm.addEventListener('submit', e => {
                e.preventDefault();
                const fileInput = document.getElementById('slideFile');
                if (!fileInput || fileInput.files.length === 0) {
                    alert("Please select an image file to upload.");
                    return;
                }

                if (globalSlides.length >= 6) {
                    alert("Maximum limit of 6 slideshow photos reached. Please delete a photo before adding a new one.");
                    return;
                }

                const formData = new FormData();
                formData.append('image', fileInput.files[0]);

                fetch('manage_slides.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        uploadSlideForm.reset();
                        loadSlides();
                        alert("Slideshow photo uploaded successfully!");
                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch(err => {
                    console.error("Upload failed:", err);
                    alert("Failed to upload slide.");
                });
            });
        }

        window.deleteSlide = function(id) {
            if (!confirm("Are you sure you want to delete this slideshow photo?")) return;

            fetch(`manage_slides.php?id=${id}`, {
                method: 'DELETE'
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    loadSlides();
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(err => {
                console.error("Delete failed:", err);
                alert("Failed to delete slideshow photo.");
            });
        };

        // 4b. Services Info
        const servicesForm = document.getElementById('servicesForm');
        function loadServices() {
            fetch('manage_settings.php')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    const s = data.settings;
                    
                    if (s.service_inv_list) {
                        document.getElementById('setServiceInvEn').value = s.service_inv_list.en || '';
                        document.getElementById('setServiceInvSi').value = s.service_inv_list.si || '';
                        document.getElementById('setServiceInvTa').value = s.service_inv_list.ta || '';
                    }
                    if (s.service_eng_list) {
                        document.getElementById('setServiceEngEn').value = s.service_eng_list.en || '';
                        document.getElementById('setServiceEngSi').value = s.service_eng_list.si || '';
                        document.getElementById('setServiceEngTa').value = s.service_eng_list.ta || '';
                    }
                    if (s.service_eng_desc) {
                        document.getElementById('setServiceEngDescEn').value = s.service_eng_desc.en || '';
                        document.getElementById('setServiceEngDescSi').value = s.service_eng_desc.si || '';
                        document.getElementById('setServiceEngDescTa').value = s.service_eng_desc.ta || '';
                    }
                    if (s.service_const_list) {
                        document.getElementById('setServiceConstEn').value = s.service_const_list.en || '';
                        document.getElementById('setServiceConstSi').value = s.service_const_list.si || '';
                        document.getElementById('setServiceConstTa').value = s.service_const_list.ta || '';
                    }
                    if (s.service_const_desc) {
                        document.getElementById('setServiceConstDescEn').value = s.service_const_desc.en || '';
                        document.getElementById('setServiceConstDescSi').value = s.service_const_desc.si || '';
                        document.getElementById('setServiceConstDescTa').value = s.service_const_desc.ta || '';
                    }
                    if (s.service_op_list) {
                        document.getElementById('setServiceOpEn').value = s.service_op_list.en || '';
                        document.getElementById('setServiceOpSi').value = s.service_op_list.si || '';
                        document.getElementById('setServiceOpTa').value = s.service_op_list.ta || '';
                    }
                    if (s.service_inst_list) {
                        document.getElementById('setServiceInstEn').value = s.service_inst_list.en || '';
                        document.getElementById('setServiceInstSi').value = s.service_inst_list.si || '';
                        document.getElementById('setServiceInstTa').value = s.service_inst_list.ta || '';
                    }
                }
            })
            .catch(err => console.error("Error loading services settings:", err));
        }

        if (servicesForm) {
            servicesForm.addEventListener('submit', e => {
                e.preventDefault();
                
                const payload = [
                    {
                        key: 'service_inv_list',
                        en: document.getElementById('setServiceInvEn').value,
                        si: document.getElementById('setServiceInvSi').value,
                        ta: document.getElementById('setServiceInvTa').value
                    },
                    {
                        key: 'service_eng_list',
                        en: document.getElementById('setServiceEngEn').value,
                        si: document.getElementById('setServiceEngSi').value,
                        ta: document.getElementById('setServiceEngTa').value
                    },
                    {
                        key: 'service_eng_desc',
                        en: document.getElementById('setServiceEngDescEn').value,
                        si: document.getElementById('setServiceEngDescSi').value,
                        ta: document.getElementById('setServiceEngDescTa').value
                    },
                    {
                        key: 'service_const_list',
                        en: document.getElementById('setServiceConstEn').value,
                        si: document.getElementById('setServiceConstSi').value,
                        ta: document.getElementById('setServiceConstTa').value
                    },
                    {
                        key: 'service_const_desc',
                        en: document.getElementById('setServiceConstDescEn').value,
                        si: document.getElementById('setServiceConstDescSi').value,
                        ta: document.getElementById('setServiceConstDescTa').value
                    },
                    {
                        key: 'service_op_list',
                        en: document.getElementById('setServiceOpEn').value,
                        si: document.getElementById('setServiceOpSi').value,
                        ta: document.getElementById('setServiceOpTa').value
                    },
                    {
                        key: 'service_inst_list',
                        en: document.getElementById('setServiceInstEn').value,
                        si: document.getElementById('setServiceInstSi').value,
                        ta: document.getElementById('setServiceInstTa').value
                    }
                ];

                let promises = payload.map(item => {
                    const formData = new FormData();
                    formData.append('section_key', item.key);
                    formData.append('content_en', item.en);
                    formData.append('content_si', item.si);
                    formData.append('content_ta', item.ta);
                    return fetch('manage_settings.php', { method: 'POST', body: formData }).then(res => res.json());
                });

                Promise.all(promises)
                .then(results => {
                    const errors = results.filter(r => r.status !== 'success');
                    if (errors.length === 0) {
                        alert("All services details updated successfully!");
                        loadServices();
                    } else {
                        alert("Some services failed to update: " + errors.map(e => e.message).join(', '));
                    }
                })
                .catch(err => alert("Failed to save services."));
            });
        }

        // 5. Divisions Info
        const divisionSelect = document.getElementById('divisionSelect');
        const divisionEditForm = document.getElementById('divisionEditForm');

        function loadDivisions() {
            if (!divisionSelect) return;
            fetch('manage_divisions.php')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    globalDivisions = data.divisions;
                    divisionSelect.innerHTML = '<option value="">-- Choose Division --</option>' + 
                        data.divisions.map(d => `<option value="${d.slug}">${d.name_en}</option>`).join('');
                }
            })
            .catch(err => console.error("Error loading divisions:", err));
        }

        window.removeDivisionBanner = function() {
            if (confirm("Are you sure you want to remove the current division banner image?")) {
                document.getElementById('divRemoveBannerFlag').value = '1';
                document.getElementById('divBannerPreviewContainer').style.display = 'none';
                document.getElementById('divRemoveBannerBtn').style.display = 'none';
                document.getElementById('divBanner').value = '';
            }
        };

        window.removeDivisionLogo = function() {
            if (confirm("Are you sure you want to remove the current division logo/profile photo?")) {
                document.getElementById('divRemoveLogoFlag').value = '1';
                document.getElementById('divLogoPreviewContainer').style.display = 'none';
                document.getElementById('divRemoveLogoBtn').style.display = 'none';
                document.getElementById('divLogo').value = '';
            }
        };

        function getDivisionOfficers(slug, d) {
            if (!d) return [];
            return globalOfficers.filter(off => {
                if (!off.division) return false;
                const divLow = off.division.toLowerCase();
                const dNameLow = d.name_en.toLowerCase();
                const dSlugLow = d.slug.toLowerCase();
                const slugLow = slug.toLowerCase();
                return divLow === dNameLow || 
                       divLow === dSlugLow || 
                       divLow === slugLow ||
                       dNameLow.includes(divLow) || 
                       divLow.includes(dSlugLow) ||
                       (dSlugLow === 'head-office' && divLow === 'head office');
            });
        }

        function renderDivisionStaff(divOfficers) {
            const listEl = document.getElementById('division-staff-list');
            if (!listEl) return;
            
            if (divOfficers.length === 0) {
                listEl.innerHTML = '<p style="color:#64748b; font-style:italic; font-size:0.9rem;">No staff configured for this division yet.</p>';
                return;
            }
            
            listEl.innerHTML = divOfficers.map(o => `
                <div style="background:#f8fafc; padding:12px; border-radius:8px; display:flex; justify-content:space-between; align-items:center; border:1px solid #e2e8f0; margin-bottom: 8px;">
                    <span>
                        <strong>${o.name}</strong> 
                        <span style="font-size:0.8rem; color:#64748b;">(${o.title})</span>
                        ${o.phone ? `<span style="font-size:0.8rem; color:#64748b; margin-left: 10px;"><i class="fas fa-phone"></i> ${o.phone}</span>` : ''}
                        ${o.email ? `<span style="font-size:0.8rem; color:#64748b; margin-left: 10px;"><i class="far fa-envelope"></i> ${o.email}</span>` : ''}
                    </span>
                    <div style="display: flex; gap: 5px;">
                        <button type="button" onclick="editDivStaff(${o.id})" style="background:#3b82f6; color:white; border:none; padding:4px 8px; border-radius:4px; cursor:pointer; font-size:0.8rem;"><i class="fas fa-edit"></i></button>
                        <button type="button" onclick="deleteDivStaff(${o.id})" style="background:#ef4444; color:white; border:none; padding:4px 8px; border-radius:4px; cursor:pointer; font-size:0.8rem;"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            `).join('');
        }

        window.editDivStaff = function(id) {
            const o = globalOfficers.find(item => item.id == id);
            if (!o) return;
            
            document.getElementById('divStaffId').value = o.id;
            document.getElementById('divStaffName').value = o.name || '';
            document.getElementById('divStaffTitle').value = o.title || '';
            document.getElementById('divStaffPhone').value = o.phone || '';
            document.getElementById('divStaffEmail').value = o.email || '';
            
            document.getElementById('divStaffFormHeader').innerHTML = `<i class="fas fa-edit"></i> Edit Division Staff Member`;
            document.getElementById('divStaffSubmitBtn').innerHTML = `<i class="fas fa-save"></i> Update Staff Member`;
            document.getElementById('divStaffCancelBtn').style.display = 'inline-flex';
            
            document.getElementById('divStaffFormHeader').scrollIntoView({ behavior: 'smooth' });
        };

        window.cancelDivStaffEdit = function() {
            const form = document.getElementById('divStaffForm');
            if (form) form.reset();
            document.getElementById('divStaffId').value = '';
            document.getElementById('divStaffFormHeader').innerHTML = `<i class="fas fa-user-plus"></i> Add Division Staff Member`;
            document.getElementById('divStaffSubmitBtn').innerHTML = `<i class="fas fa-save"></i> Save Staff Member`;
            document.getElementById('divStaffCancelBtn').style.display = 'none';
        };

        window.deleteDivStaff = function(id) {
            if (!confirm("Are you sure you want to delete this staff member?")) return;
            fetch(`manage_officers.php?id=${id}`, { method: 'DELETE' })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    // Reload officers
                    fetch('manage_officers.php')
                    .then(res => res.json())
                    .then(data2 => {
                        if (data2.status === 'success') {
                            globalOfficers = data2.officers;
                            renderOfficers(data2.officers);
                            
                            const slug = divisionSelect.value;
                            const d = globalDivisions.find(item => item.slug === slug);
                            const divisionOfficers = getDivisionOfficers(slug, d);
                            renderDivisionStaff(divisionOfficers);
                        }
                    });
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(err => alert("Failed to delete staff member."));
        };

        window.populateDivisionEditForm = function() {
            const slug = divisionSelect.value;
            if (!slug) {
                divisionEditForm.style.display = 'none';
                const staffSection = document.getElementById('divisionStaffSection');
                if (staffSection) staffSection.style.display = 'none';
                return;
            }
            const d = globalDivisions.find(item => item.slug === slug);
            if (d) {
                document.getElementById('divSlug').value = d.slug;
                document.getElementById('divNameEn').value = d.name_en || '';
                document.getElementById('divNameSi').value = d.name_si || '';
                document.getElementById('divNameTa').value = d.name_ta || '';
                document.getElementById('divLocEn').value = d.location_en || '';
                document.getElementById('divLocSi').value = d.location_si || '';
                document.getElementById('divLocTa').value = d.location_ta || '';
                document.getElementById('divAddrEn').value = d.address_en || '';
                document.getElementById('divAddrSi').value = d.address_si || '';
                document.getElementById('divAddrTa').value = d.address_ta || '';
                document.getElementById('divPhone').value = d.phone || '';
                document.getElementById('divFax').value = d.fax || '';
                document.getElementById('divEmail').value = d.email || '';
                
                // Reset file inputs and removal flags
                const bannerInput = document.getElementById('divBanner');
                if (bannerInput) bannerInput.value = '';
                document.getElementById('divRemoveBannerFlag').value = '0';

                const logoInput = document.getElementById('divLogo');
                if (logoInput) logoInput.value = '';
                document.getElementById('divRemoveLogoFlag').value = '0';
                
                const previewContainer = document.getElementById('divBannerPreviewContainer');
                const previewImg = document.getElementById('divBannerPreview');
                const removeBtn = document.getElementById('divRemoveBannerBtn');
                
                if (d.banner_url) {
                     previewImg.src = d.banner_url;
                     previewContainer.style.display = 'block';
                     if (removeBtn) removeBtn.style.display = 'inline-flex';
                } else {
                     previewContainer.style.display = 'none';
                     previewImg.src = '';
                     if (removeBtn) removeBtn.style.display = 'none';
                }

                const logoPreviewContainer = document.getElementById('divLogoPreviewContainer');
                const logoPreviewImg = document.getElementById('divLogoPreview');
                const removeLogoBtn = document.getElementById('divRemoveLogoBtn');

                if (d.logo_url) {
                     logoPreviewImg.src = d.logo_url;
                     logoPreviewContainer.style.display = 'block';
                     if (removeLogoBtn) removeLogoBtn.style.display = 'inline-flex';
                } else {
                     logoPreviewContainer.style.display = 'none';
                     logoPreviewImg.src = '';
                     if (removeLogoBtn) removeLogoBtn.style.display = 'none';
                }
                
                divisionEditForm.style.display = 'grid';

                // Show division staff section and load staff
                cancelDivStaffEdit();
                const staffSection = document.getElementById('divisionStaffSection');
                if (staffSection) staffSection.style.display = 'block';
                
                const divisionOfficers = getDivisionOfficers(slug, d);
                renderDivisionStaff(divisionOfficers);
            }
        };

        if (divisionEditForm) {
            divisionEditForm.addEventListener('submit', e => {
                e.preventDefault();
                const slug = document.getElementById('divSlug').value;

                const formData = new FormData();
                formData.append('slug', slug);
                formData.append('name_en', document.getElementById('divNameEn').value.trim());
                formData.append('name_si', document.getElementById('divNameSi').value.trim());
                formData.append('name_ta', document.getElementById('divNameTa').value.trim());
                formData.append('location_en', document.getElementById('divLocEn').value.trim());
                formData.append('location_si', document.getElementById('divLocSi').value.trim());
                formData.append('location_ta', document.getElementById('divLocTa').value.trim());
                formData.append('address_en', document.getElementById('divAddrEn').value.trim());
                formData.append('address_si', document.getElementById('divAddrSi').value.trim());
                formData.append('address_ta', document.getElementById('divAddrTa').value.trim());
                formData.append('phone', document.getElementById('divPhone').value.trim());
                formData.append('fax', document.getElementById('divFax').value.trim());
                formData.append('email', document.getElementById('divEmail').value.trim());
                
                const bannerInput = document.getElementById('divBanner');
                if (bannerInput && bannerInput.files.length > 0) {
                    formData.append('banner', bannerInput.files[0]);
                }
                formData.append('remove_banner', document.getElementById('divRemoveBannerFlag').value);

                const logoInput = document.getElementById('divLogo');
                if (logoInput && logoInput.files.length > 0) {
                    formData.append('logo', logoInput.files[0]);
                }
                formData.append('remove_logo', document.getElementById('divRemoveLogoFlag').value);

                fetch('manage_divisions.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert("Division details updated successfully!");
                        loadDivisions();
                        divisionEditForm.style.display = 'none';
                        const staffSection = document.getElementById('divisionStaffSection');
                        if (staffSection) staffSection.style.display = 'none';
                        divisionSelect.value = '';
                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch(err => alert("Failed to update division details."));
            });
        }

        const divStaffForm = document.getElementById('divStaffForm');
        if (divStaffForm) {
            divStaffForm.addEventListener('submit', e => {
                e.preventDefault();
                const staffIdVal = document.getElementById('divStaffId').value;
                const name = document.getElementById('divStaffName').value.trim();
                const title = document.getElementById('divStaffTitle').value.trim();
                const phone = document.getElementById('divStaffPhone').value.trim();
                const email = document.getElementById('divStaffEmail').value.trim();
                
                const slug = divisionSelect.value;
                const d = globalDivisions.find(item => item.slug === slug);
                const divisionName = d.name_en;
                
                const formData = new FormData();
                if (staffIdVal) {
                    formData.append('id', staffIdVal);
                }
                formData.append('name', name);
                formData.append('title', title);
                formData.append('phone', phone);
                if (email) {
                    formData.append('email', email);
                }
                formData.append('category', slug === 'head-office' ? 'executive' : 'div');
                formData.append('division', divisionName);
                
                fetch('manage_officers.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        cancelDivStaffEdit();
                        // Reload officers
                        fetch('manage_officers.php')
                        .then(res => res.json())
                        .then(data2 => {
                            if (data2.status === 'success') {
                                globalOfficers = data2.officers;
                                renderOfficers(data2.officers);
                                
                                const divisionOfficers = getDivisionOfficers(slug, d);
                                renderDivisionStaff(divisionOfficers);
                            }
                        });
                        alert(staffIdVal ? "Staff member updated successfully!" : "Staff member added successfully!");
                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch(err => alert("Failed to save staff member."));
            });
        }

        // 6. Procurements
        const addProcurementForm = document.getElementById('addProcurementForm');
        function loadProcurements() {
            fetch('manage_procurements.php')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    globalProcurements = data.procurements;
                    renderProcurements(data.procurements);
                }
            })
            .catch(err => console.error("Error loading procurements:", err));
        }

        function renderProcurements(procurements) {
            const listEl = document.getElementById('admin-procurements-list');
            if (listEl) {
                listEl.innerHTML = procurements.map(p => `
                    <div style="background:white; padding:12px; border-radius:8px; display:flex; justify-content:space-between; align-items:center; border:1px solid #e2e8f0; margin-bottom: 8px;">
                        <span>
                            <i class="fas fa-file-invoice text-muted" style="margin-right:10px;"></i> 
                            <strong>${p.title}</strong> 
                            <span style="font-size:0.8rem; color:#64748b;">(Published: ${p.publish_date})</span>
                            <span style="font-size:0.8rem; font-weight:600; color:${p.status === 'active' ? '#10b981' : '#ef4444'}; margin-left: 8px;">(${p.status.toUpperCase()})</span>
                        </span>
                        <div style="display:flex; gap:8px;">
                            <button type="button" onclick="editProcurement(${p.id})" style="background:#3b82f6; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer;"><i class="fas fa-edit"></i></button>
                            <button type="button" onclick="deleteProcurement(${p.id})" style="background:#ef4444; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer;"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                `).join('');
            }
        }

        window.editProcurement = function(id) {
            const p = globalProcurements.find(item => item.id == id);
            if (!p) return;

            document.getElementById('procurementId').value = p.id;
            document.getElementById('procTitle').value = p.title || '';
            document.getElementById('procStatus').value = p.status || 'active';

            document.getElementById('procurementFormHeader').innerHTML = `<i class="fas fa-edit"></i> Edit Procurement / Tender Notice`;
            document.getElementById('procSubmitBtn').innerHTML = `<i class="fas fa-save"></i> Update Notice`;
            document.getElementById('procCancelBtn').style.display = 'inline-flex';

            document.getElementById('procurementFormHeader').scrollIntoView({ behavior: 'smooth' });
        };

        window.cancelProcurementEdit = function() {
            if (addProcurementForm) addProcurementForm.reset();
            document.getElementById('procurementId').value = '';
            document.getElementById('procurementFormHeader').innerHTML = `<i class="fas fa-plus"></i> Add Procurement / Tender Notice`;
            document.getElementById('procSubmitBtn').innerHTML = `<i class="fas fa-upload"></i> Publish Notice`;
            document.getElementById('procCancelBtn').style.display = 'none';
        };

        window.deleteProcurement = function(id) {
            if (!confirm("Are you sure you want to delete this procurement notice?")) return;
            fetch(`manage_procurements.php?id=${id}`, { method: 'DELETE' })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    if (document.getElementById('procurementId').value == id) {
                        cancelProcurementEdit();
                    }
                    loadProcurements();
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(err => alert("Failed to delete notice."));
        };

        if (addProcurementForm) {
            addProcurementForm.addEventListener('submit', e => {
                e.preventDefault();
                const procurementIdVal = document.getElementById('procurementId').value;
                const fileInput = document.getElementById('procFile');
                const title = document.getElementById('procTitle').value.trim();
                const status = document.getElementById('procStatus').value;

                if (!procurementIdVal && !fileInput.files.length) {
                    alert("Please select a file to upload.");
                    return;
                }

                const formData = new FormData();
                if (procurementIdVal) {
                    formData.append('id', procurementIdVal);
                }
                formData.append('title', title);
                formData.append('status', status);
                if (fileInput.files.length > 0) {
                    formData.append('file', fileInput.files[0]);
                }

                fetch('manage_procurements.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        cancelProcurementEdit();
                        loadProcurements();
                        alert(procurementIdVal ? "Procurement notice updated successfully!" : "Procurement tender published successfully!");
                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch(err => alert("Failed to save procurement notice."));
            });
        }

        // 7. Projects
        const addProjectForm = document.getElementById('addProjectForm');
        const projGalleryTypeSelect = document.getElementById('projGalleryType');
        const projRenovationPhotosContainer = document.getElementById('projRenovationPhotosContainer');
        const projEventPhotosContainer = document.getElementById('projEventPhotosContainer');
        if (projGalleryTypeSelect) {
            projGalleryTypeSelect.addEventListener('change', function() {
                const val = this.value;
                if (val === 'renovation') {
                    projRenovationPhotosContainer.style.display = 'grid';
                    projEventPhotosContainer.style.display = 'none';
                } else if (val === 'event') {
                    projRenovationPhotosContainer.style.display = 'none';
                    projEventPhotosContainer.style.display = 'block';
                } else {
                    projRenovationPhotosContainer.style.display = 'none';
                    projEventPhotosContainer.style.display = 'none';
                }
            });
        }
        function loadProjects() {
            fetch('manage_projects.php')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    globalProjects = data.projects;
                    renderProjects(data.projects);
                }
            })
            .catch(err => console.error("Error loading projects:", err));
        }

        function renderProjects(projects) {
            const listEl = document.getElementById('admin-projects-list');
            if (listEl) {
                listEl.innerHTML = projects.map(p => `
                    <div style="background:white; padding:12px; border-radius:8px; display:flex; justify-content:space-between; align-items:center; border:1px solid #e2e8f0; margin-bottom: 8px;">
                        <span><i class="fas fa-building text-muted" style="margin-right:10px;"></i> <strong>${p.title_en}</strong> <span style="font-size:0.8rem; color:#64748b;">(${p.category} - ${p.financial_details || 'No Cost Specified'})</span></span>
                        <div style="display:flex; gap:8px;">
                            <button type="button" onclick="editProject(${p.id})" style="background:#3b82f6; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer;"><i class="fas fa-edit"></i></button>
                            <button type="button" onclick="deleteProject(${p.id})" style="background:#ef4444; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer;"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                `).join('');
            }
        }

        window.editProject = function(id) {
            const p = globalProjects.find(item => item.id == id);
            if (!p) return;

            document.getElementById('projectId').value = p.id;
            document.getElementById('projCategory').value = p.category || 'summary';
            document.getElementById('projTitleEn').value = p.title_en || '';
            document.getElementById('projTitleSi').value = p.title_si || '';
            document.getElementById('projDescEn').value = p.description_en || '';
            document.getElementById('projDescSi').value = p.description_si || '';
            document.getElementById('projFinancial').value = p.financial_details || '';

            const gType = p.gallery_type || 'none';
            if (projGalleryTypeSelect) {
                projGalleryTypeSelect.value = gType;
                projGalleryTypeSelect.dispatchEvent(new Event('change'));
            }

            document.getElementById('projectFormHeader').innerHTML = `<i class="fas fa-edit"></i> Edit Department Project`;
            document.getElementById('projSubmitBtn').innerHTML = `<i class="fas fa-save"></i> Update Project`;
            document.getElementById('projCancelBtn').style.display = 'inline-flex';

            document.getElementById('projectFormHeader').scrollIntoView({ behavior: 'smooth' });
        };

        window.cancelProjectEdit = function() {
            if (addProjectForm) addProjectForm.reset();
            document.getElementById('projectId').value = '';
            if (projGalleryTypeSelect) {
                projGalleryTypeSelect.value = 'none';
                projGalleryTypeSelect.dispatchEvent(new Event('change'));
            }
            document.getElementById('projectFormHeader').innerHTML = `<i class="fas fa-plus"></i> Add Department Project`;
            document.getElementById('projSubmitBtn').innerHTML = `<i class="fas fa-save"></i> Save Project`;
            document.getElementById('projCancelBtn').style.display = 'none';
        };

        window.deleteProject = function(id) {
            if (!confirm("Are you sure you want to delete this project?")) return;
            fetch(`manage_projects.php?id=${id}`, { method: 'DELETE' })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    if (document.getElementById('projectId').value == id) {
                        cancelProjectEdit();
                    }
                    loadProjects();
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(err => alert("Failed to delete project."));
        };

        if (addProjectForm) {
            addProjectForm.addEventListener('submit', e => {
                e.preventDefault();
                const projectIdVal = document.getElementById('projectId').value;
                const category = document.getElementById('projCategory').value;
                const titleEn = document.getElementById('projTitleEn').value.trim();
                const titleSi = document.getElementById('projTitleSi').value.trim();
                const descEn = document.getElementById('projDescEn').value.trim();
                const descSi = document.getElementById('projDescSi').value.trim();
                const financial = document.getElementById('projFinancial').value.trim();
                const fileInput = document.getElementById('projImage');
                const fileInputBefore = document.getElementById('projImageBefore');
                const fileInputAfter = document.getElementById('projImageAfter');
                const fileInputEvent = document.getElementById('projImageEvent');
                
                const formData = new FormData();
                if (projectIdVal) {
                    formData.append('id', projectIdVal);
                }
                formData.append('category', category);
                formData.append('title_en', titleEn);
                formData.append('title_si', titleSi || titleEn);
                formData.append('title_ta', titleEn);
                formData.append('description_en', descEn);
                formData.append('description_si', descSi || descEn);
                formData.append('description_ta', descEn);
                formData.append('financial_details', financial);
                
                const galleryTypeVal = projGalleryTypeSelect ? projGalleryTypeSelect.value : 'none';
                formData.append('gallery_type', galleryTypeVal);

                if (fileInput && fileInput.files.length > 0) {
                    for (let i = 0; i < Math.min(fileInput.files.length, 4); i++) {
                        formData.append('images[]', fileInput.files[i]);
                    }
                }
                
                if (galleryTypeVal === 'renovation') {
                    if (fileInputBefore && fileInputBefore.files.length > 0) {
                        for (let i = 0; i < fileInputBefore.files.length; i++) {
                            formData.append('image_before[]', fileInputBefore.files[i]);
                        }
                    }
                    if (fileInputAfter && fileInputAfter.files.length > 0) {
                        for (let i = 0; i < fileInputAfter.files.length; i++) {
                            formData.append('image_after[]', fileInputAfter.files[i]);
                        }
                    }
                } else if (galleryTypeVal === 'event') {
                    if (fileInputEvent && fileInputEvent.files.length > 0) {
                        for (let i = 0; i < fileInputEvent.files.length; i++) {
                            formData.append('image_before[]', fileInputEvent.files[i]);
                        }
                    }
                }

                fetch('manage_projects.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        cancelProjectEdit();
                        loadProjects();
                        alert(projectIdVal ? "Project updated successfully!" : "Project saved successfully!");
                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch(err => alert("Failed to save project."));
            });
        }

        // 8. Gallery
        const addGalleryForm = document.getElementById('addGalleryForm');
        function loadGallery() {
            fetch('manage_gallery.php')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    globalGallery = data.gallery;
                    renderGallery(data.gallery);
                }
            })
            .catch(err => console.error("Error loading gallery:", err));
        }

        function renderGallery(gallery) {
            const listEl = document.getElementById('admin-gallery-list');
            if (listEl) {
                listEl.innerHTML = gallery.map(g => `
                    <div style="background:white; padding:12px; border-radius:8px; display:flex; justify-content:space-between; align-items:center; border:1px solid #e2e8f0; margin-bottom: 8px;">
                        <span><i class="fas fa-image text-muted" style="margin-right:10px;"></i> <strong>${g.title}</strong></span>
                        <div style="display:flex; gap:8px;">
                            <button type="button" onclick="editGallery(${g.id})" style="background:#3b82f6; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer;"><i class="fas fa-edit"></i></button>
                            <button type="button" onclick="deleteGallery(${g.id})" style="background:#ef4444; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer;"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                `).join('');
            }
        }

        window.editGallery = function(id) {
            const g = globalGallery.find(item => item.id == id);
            if (!g) return;

            document.getElementById('galleryId').value = g.id;
            document.getElementById('galTitle').value = g.title || '';
            document.getElementById('galDesc').value = g.description || '';

            document.getElementById('galleryFormHeader').innerHTML = `<i class="fas fa-edit"></i> Edit Gallery Item`;
            document.getElementById('galSubmitBtn').innerHTML = `<i class="fas fa-save"></i> Update Gallery Item`;
            document.getElementById('galCancelBtn').style.display = 'inline-flex';

            document.getElementById('galleryFormHeader').scrollIntoView({ behavior: 'smooth' });
        };

        window.cancelGalleryEdit = function() {
            if (addGalleryForm) addGalleryForm.reset();
            document.getElementById('galleryId').value = '';
            document.getElementById('galleryFormHeader').innerHTML = `<i class="fas fa-plus"></i> Upload Photo to Gallery`;
            document.getElementById('galSubmitBtn').innerHTML = `<i class="fas fa-upload"></i> Upload to Gallery`;
            document.getElementById('galCancelBtn').style.display = 'none';
        };

        window.deleteGallery = function(id) {
            if (!confirm("Are you sure you want to delete this photo from the gallery?")) return;
            fetch(`manage_gallery.php?id=${id}`, { method: 'DELETE' })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    if (document.getElementById('galleryId').value == id) {
                        cancelGalleryEdit();
                    }
                    loadGallery();
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(err => alert("Failed to delete gallery item."));
        };

        if (addGalleryForm) {
            addGalleryForm.addEventListener('submit', e => {
                e.preventDefault();
                const galleryIdVal = document.getElementById('galleryId').value;
                const fileInput = document.getElementById('galImage');
                
                if (!galleryIdVal && !fileInput.files.length) {
                    alert("Please select at least one image to upload.");
                    return;
                }
                if (fileInput.files.length > 10) {
                    alert("You can upload a maximum of 10 photos at a time.");
                    return;
                }
                const title = document.getElementById('galTitle').value.trim();
                const desc = document.getElementById('galDesc').value.trim();

                const formData = new FormData();
                if (galleryIdVal) {
                    formData.append('id', galleryIdVal);
                }
                formData.append('title', title);
                formData.append('description', desc);
                
                if (fileInput.files.length > 0) {
                    for (let i = 0; i < Math.min(fileInput.files.length, 10); i++) {
                        formData.append('image[]', fileInput.files[i]);
                    }
                }

                fetch('manage_gallery.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        cancelGalleryEdit();
                        loadGallery();
                        alert(galleryIdVal ? "Gallery item updated successfully!" : (data.message || "Photo(s) uploaded successfully to gallery!"));
                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch(err => alert("Failed to save photo(s)."));
            });
        }

        window.switchAdminTab = function (tab, btn) {
            document.querySelectorAll('.admin-tab-content').forEach(el => el.style.display = 'none');
            document.querySelectorAll('.admin-tab-btn').forEach(el => el.classList.remove('active'));
            document.getElementById('admin-tab-' + tab).style.display = 'block';
            btn.classList.add('active');
        };

        // 9. Announcements
        const addAnnouncementForm = document.getElementById('addAnnouncementForm');
        function loadAdminAnnouncements() {
            fetch('manage_announcements.php')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    globalAdminAnnouncements = data.announcements;
                    renderAdminAnnouncements(data.announcements);
                }
            })
            .catch(err => console.error("Error loading announcements:", err));
        }
        function renderAdminAnnouncements(announcements) {
            const listEl = document.getElementById('admin-announcements-list');
            if (listEl) {
                listEl.innerHTML = announcements.map(a => `
                    <div style="background:white; padding:12px; border-radius:8px; display:flex; justify-content:space-between; align-items:center; border:1px solid #e2e8f0; margin-bottom: 8px;">
                        <span><i class="fas fa-bullhorn text-muted" style="margin-right:10px;"></i> <strong>${a.title}</strong> <span style="font-size:0.8rem; color:#64748b;">(${a.category})</span></span>
                        <div style="display:flex; gap:8px;">
                            <button type="button" onclick="editAnnouncement(${a.id})" style="background:#3b82f6; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer;"><i class="fas fa-edit"></i></button>
                            <button type="button" onclick="deleteAnnouncement(${a.id})" style="background:#ef4444; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer;"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                `).join('');
            }
        }
        window.editAnnouncement = function(id) {
            const a = globalAdminAnnouncements.find(item => item.id == id);
            if (!a) return;

            document.getElementById('announcementId').value = a.id;
            document.getElementById('annCategory').value = a.category || 'internal';
            document.getElementById('annTitle').value = a.title || '';
            document.getElementById('annUrl').value = a.url || '';
            document.getElementById('annBadge').value = a.badge || '';

            document.getElementById('announcementFormHeader').innerHTML = `<i class="fas fa-edit"></i> Edit Announcement`;
            document.getElementById('annSubmitBtn').innerHTML = `<i class="fas fa-save"></i> Update Announcement`;
            document.getElementById('annCancelBtn').style.display = 'inline-flex';

            document.getElementById('announcementFormHeader').scrollIntoView({ behavior: 'smooth' });
        };
        window.cancelAnnouncementEdit = function() {
            if (addAnnouncementForm) addAnnouncementForm.reset();
            document.getElementById('announcementId').value = '';
            document.getElementById('announcementFormHeader').innerHTML = `<i class="fas fa-bullhorn"></i> Add Announcement`;
            document.getElementById('annSubmitBtn').innerHTML = `<i class="fas fa-save"></i> Save Announcement`;
            document.getElementById('annCancelBtn').style.display = 'none';
        };
        window.deleteAnnouncement = function(id) {
            if (!confirm("Are you sure you want to delete this announcement?")) return;
            fetch(`manage_announcements.php?id=${id}`, { method: 'DELETE' })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    if (document.getElementById('announcementId').value == id) {
                        cancelAnnouncementEdit();
                    }
                    loadAdminAnnouncements();
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(err => alert("Failed to delete announcement."));
        };
        if (addAnnouncementForm) {
            addAnnouncementForm.addEventListener('submit', e => {
                e.preventDefault();
                const announcementIdVal = document.getElementById('announcementId').value;
                const formData = new FormData();
                if (announcementIdVal) {
                    formData.append('id', announcementIdVal);
                }
                formData.append('category', document.getElementById('annCategory').value);
                formData.append('title', document.getElementById('annTitle').value.trim());
                formData.append('url', document.getElementById('annUrl').value.trim());
                formData.append('badge', document.getElementById('annBadge').value.trim());

                fetch('manage_announcements.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        cancelAnnouncementEdit();
                        loadAdminAnnouncements();
                        alert(announcementIdVal ? "Announcement updated successfully!" : "Announcement added successfully!");
                    } else {
                        alert("Error: " + data.message);
                    }
                });
            });
        }

        // 10. News
        let globalAdminNews = [];
        const addNewsForm = document.getElementById('addNewsForm');
        const newsGalleryTypeSelect = document.getElementById('newsGalleryType');
        const newsRenovationPhotosContainer = document.getElementById('newsRenovationPhotosContainer');
        const newsEventPhotosContainer = document.getElementById('newsEventPhotosContainer');
        if (newsGalleryTypeSelect) {
            newsGalleryTypeSelect.addEventListener('change', function() {
                const val = this.value;
                if (val === 'renovation') {
                    newsRenovationPhotosContainer.style.display = 'grid';
                    newsEventPhotosContainer.style.display = 'none';
                } else if (val === 'event') {
                    newsRenovationPhotosContainer.style.display = 'none';
                    newsEventPhotosContainer.style.display = 'block';
                } else {
                    newsRenovationPhotosContainer.style.display = 'none';
                    newsEventPhotosContainer.style.display = 'none';
                }
            });
        }
        function loadAdminNews() {
            fetch('manage_news.php')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    globalAdminNews = data.news;
                    renderAdminNews(data.news);
                }
            })
            .catch(err => console.error("Error loading news:", err));
        }
        function renderAdminNews(news) {
            const listEl = document.getElementById('admin-news-list');
            if (listEl) {
                listEl.innerHTML = news.map(n => `
                    <div style="background:white; padding:12px; border-radius:8px; display:flex; justify-content:space-between; align-items:center; border:1px solid #e2e8f0; margin-bottom: 8px;">
                        <span><i class="fas fa-newspaper text-muted" style="margin-right:10px;"></i> <strong>${n.title}</strong> <span style="font-size:0.8rem; color:#64748b;">(${n.category} - ${n.news_date})</span></span>
                        <div style="display:flex; gap:6px;">
                            <button type="button" onclick="editNews(${n.id})" style="background:#3b82f6; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer;"><i class="fas fa-edit"></i> Edit</button>
                            <button type="button" onclick="deleteNews(${n.id})" style="background:#ef4444; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer;"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                `).join('');
            }
        }
        window.editNews = function(id) {
            const n = globalAdminNews.find(item => item.id == id);
            if (!n) return;
            
            document.getElementById('newsId').value = n.id;
            document.getElementById('newsCategory').value = n.category;
            document.getElementById('newsTitle').value = n.title;
            document.getElementById('newsDate').value = n.news_date;
            document.getElementById('newsContent').value = n.content;
            document.getElementById('newsUrl').value = n.url === '#' ? '' : n.url;
            
            const gType = n.gallery_type || 'none';
            if (newsGalleryTypeSelect) {
                newsGalleryTypeSelect.value = gType;
                newsGalleryTypeSelect.dispatchEvent(new Event('change'));
            }
            
            document.getElementById('newsFormHeader').innerHTML = `<i class="fas fa-edit"></i> Edit News Article`;
            document.getElementById('newsSubmitBtn').innerHTML = `<i class="fas fa-save"></i> Update News`;
            document.getElementById('newsCancelBtn').style.display = 'inline-flex';
            
            document.getElementById('newsFormHeader').scrollIntoView({ behavior: 'smooth' });
        };
        window.cancelNewsEdit = function() {
            if (addNewsForm) addNewsForm.reset();
            document.getElementById('newsId').value = '';
            if (newsGalleryTypeSelect) {
                newsGalleryTypeSelect.value = 'none';
                newsGalleryTypeSelect.dispatchEvent(new Event('change'));
            }
            document.getElementById('newsFormHeader').innerHTML = `<i class="fas fa-newspaper"></i> Add News Article`;
            document.getElementById('newsSubmitBtn').innerHTML = `<i class="fas fa-save"></i> Publish News`;
            document.getElementById('newsCancelBtn').style.display = 'none';
        };
        window.deleteNews = function(id) {
            if (!confirm("Are you sure you want to delete this news article?")) return;
            fetch(`manage_news.php?id=${id}`, { method: 'DELETE' })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    if (document.getElementById('newsId').value == id) {
                        cancelNewsEdit();
                    }
                    loadAdminNews();
                } else {
                    alert("Error: " + data.message);
                }
            });
        };
        if (addNewsForm) {
            addNewsForm.addEventListener('submit', e => {
                e.preventDefault();
                const newsIdVal = document.getElementById('newsId').value;
                const fileInput = document.getElementById('newsImage');
                const fileInputBefore = document.getElementById('newsImageBefore');
                const fileInputAfter = document.getElementById('newsImageAfter');
                const fileInputEvent = document.getElementById('newsImageEvent');
                
                const formData = new FormData();
                formData.append('category', document.getElementById('newsCategory').value);
                formData.append('title', document.getElementById('newsTitle').value.trim());
                formData.append('news_date', document.getElementById('newsDate').value);
                formData.append('content', document.getElementById('newsContent').value.trim());
                formData.append('url', document.getElementById('newsUrl').value.trim());
                
                const galleryTypeVal = newsGalleryTypeSelect ? newsGalleryTypeSelect.value : 'none';
                formData.append('gallery_type', galleryTypeVal);
                
                if (newsIdVal) {
                    formData.append('id', newsIdVal);
                }
                if (fileInput && fileInput.files.length > 0) {
                    formData.append('image', fileInput.files[0]);
                }
                
                if (galleryTypeVal === 'renovation') {
                    if (fileInputBefore && fileInputBefore.files.length > 0) {
                        for (let i = 0; i < fileInputBefore.files.length; i++) {
                            formData.append('image_before[]', fileInputBefore.files[i]);
                        }
                    }
                    if (fileInputAfter && fileInputAfter.files.length > 0) {
                        for (let i = 0; i < fileInputAfter.files.length; i++) {
                            formData.append('image_after[]', fileInputAfter.files[i]);
                        }
                    }
                } else if (galleryTypeVal === 'event') {
                    if (fileInputEvent && fileInputEvent.files.length > 0) {
                        for (let i = 0; i < fileInputEvent.files.length; i++) {
                            formData.append('image_before[]', fileInputEvent.files[i]);
                        }
                    }
                }

                fetch('manage_news.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        const isEdit = !!newsIdVal;
                        cancelNewsEdit();
                        loadAdminNews();
                        alert(isEdit ? "News updated successfully!" : "News published successfully!");
                    } else {
                        alert("Error: " + data.message);
                    }
                });
            });
        }

        // 11. Courses
        let globalAdminCourses = [];
        const addCourseForm = document.getElementById('addCourseForm');
        function loadAdminCourses() {
            fetch('manage_courses.php')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    globalAdminCourses = data.courses;
                    renderAdminCourses(data.courses);
                }
            })
            .catch(err => console.error("Error loading courses:", err));
        }
        function renderAdminCourses(courses) {
            const listEl = document.getElementById('admin-courses-list');
            if (listEl) {
                listEl.innerHTML = courses.map(c => `
                    <div style="background:white; padding:12px; border-radius:8px; display:flex; justify-content:space-between; align-items:center; border:1px solid #e2e8f0; margin-bottom: 8px;">
                        <span><i class="fas ${c.icon_class || 'fa-graduation-cap'} text-muted" style="margin-right:10px; width:16px; text-align:center;"></i> <strong>${c.title}</strong> <span style="font-size:0.8rem; color:#64748b;">(${c.category} - ${c.event_date})</span></span>
                        <div style="display:flex; gap:8px;">
                            <button type="button" onclick="editCourse(${c.id})" style="background:#3b82f6; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer;"><i class="fas fa-edit"></i></button>
                            <button type="button" onclick="deleteCourse(${c.id})" style="background:#ef4444; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer;"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                `).join('');
            }
        }
        window.editCourse = function(id) {
            const c = globalAdminCourses.find(item => item.id == id);
            if (!c) return;

            document.getElementById('courseId').value = c.id;
            document.getElementById('courseCategory').value = c.category || 'upcoming';
            document.getElementById('courseTitle').value = c.title || '';
            document.getElementById('courseDate').value = c.event_date || '';
            document.getElementById('courseLocation').value = c.location || '';
            const standardCourseIcons = ['fa-graduation-cap', 'fa-laptop-code', 'fa-user-gear', 'fa-calculator', 'fa-calendar-days', 'fa-book', 'fa-award', 'fa-users', 'fa-chalkboard-user', 'fa-network-wired'];
            if (standardCourseIcons.includes(c.icon_class)) {
                document.getElementById('courseIcon').value = c.icon_class;
                document.getElementById('courseIconCustom').value = '';
            } else {
                document.getElementById('courseIcon').value = 'fa-graduation-cap';
                document.getElementById('courseIconCustom').value = c.icon_class || '';
            }
            document.getElementById('courseUrl').value = c.url || '';

            document.getElementById('courseFormHeader').innerHTML = `<i class="fas fa-edit"></i> Edit Course / Event`;
            document.getElementById('courseSubmitBtn').innerHTML = `<i class="fas fa-save"></i> Update Course`;
            document.getElementById('courseCancelBtn').style.display = 'inline-flex';

            document.getElementById('courseFormHeader').scrollIntoView({ behavior: 'smooth' });
        };
        window.cancelCourseEdit = function() {
            if (addCourseForm) addCourseForm.reset();
            document.getElementById('courseId').value = '';
            document.getElementById('courseIconCustom').value = '';
            document.getElementById('courseFormHeader').innerHTML = `<i class="fas fa-graduation-cap"></i> Add Course / Event`;
            document.getElementById('courseSubmitBtn').innerHTML = `<i class="fas fa-save"></i> Save Course`;
            document.getElementById('courseCancelBtn').style.display = 'none';
        };
        window.deleteCourse = function(id) {
            if (!confirm("Are you sure you want to delete this course/event?")) return;
            fetch(`manage_courses.php?id=${id}`, { method: 'DELETE' })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    if (document.getElementById('courseId').value == id) {
                        cancelCourseEdit();
                    }
                    loadAdminCourses();
                } else {
                    alert("Error: " + data.message);
                }
            });
        };
        if (addCourseForm) {
            addCourseForm.addEventListener('submit', e => {
                e.preventDefault();
                const courseIdVal = document.getElementById('courseId').value;
                const formData = new FormData();
                if (courseIdVal) {
                    formData.append('id', courseIdVal);
                }
                formData.append('category', document.getElementById('courseCategory').value);
                formData.append('title', document.getElementById('courseTitle').value.trim());
                formData.append('event_date', document.getElementById('courseDate').value);
                formData.append('location', document.getElementById('courseLocation').value.trim());
                const customIcon = document.getElementById('courseIconCustom').value.trim();
                const iconClass = customIcon ? customIcon : document.getElementById('courseIcon').value;
                formData.append('icon_class', iconClass);
                formData.append('url', document.getElementById('courseUrl').value.trim());

                fetch('manage_courses.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        cancelCourseEdit();
                        loadAdminCourses();
                        alert(courseIdVal ? "Course/Event updated successfully!" : "Course/Event saved successfully!");
                    } else {
                        alert("Error: " + data.message);
                    }
                });
            });
        }

        // 12. Links
        let globalAdminLinks = [];
        const addLinkForm = document.getElementById('addLinkForm');
        function loadAdminLinks() {
            fetch('manage_links.php')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    globalAdminLinks = data.links;
                    renderAdminLinks(data.links);
                }
            })
            .catch(err => console.error("Error loading links:", err));
        }
        function renderAdminLinks(links) {
            const listEl = document.getElementById('admin-links-list');
            if (listEl) {
                listEl.innerHTML = links.map(l => `
                    <div style="background:white; padding:12px; border-radius:8px; display:flex; justify-content:space-between; align-items:center; border:1px solid #e2e8f0; margin-bottom: 8px;">
                        <span><i class="fas fa-link text-muted" style="margin-right:10px;"></i> <strong>${l.title}</strong> <span style="font-size:0.8rem; color:#64748b;">(${l.category})</span></span>
                        <div style="display:flex; gap:8px;">
                            <button type="button" onclick="editLink(${l.id})" style="background:#3b82f6; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer;"><i class="fas fa-edit"></i></button>
                            <button type="button" onclick="deleteLink(${l.id})" style="background:#ef4444; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer;"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                `).join('');
            }
        }
        window.editLink = function(id) {
            const l = globalAdminLinks.find(item => item.id == id);
            if (!l) return;

            document.getElementById('linkId').value = l.id;
            document.getElementById('linkCategory').value = l.category || 'govt-links';
            document.getElementById('linkTitle').value = l.title || '';
            document.getElementById('linkUrl').value = l.url || '';
            document.getElementById('linkImage').value = '';

            document.getElementById('linkFormHeader').innerHTML = `<i class="fas fa-edit"></i> Edit Important Link`;
            document.getElementById('linkSubmitBtn').innerHTML = `<i class="fas fa-save"></i> Update Link`;
            document.getElementById('linkCancelBtn').style.display = 'inline-flex';

            document.getElementById('linkFormHeader').scrollIntoView({ behavior: 'smooth' });
        };
        window.cancelLinkEdit = function() {
            if (addLinkForm) addLinkForm.reset();
            document.getElementById('linkId').value = '';
            document.getElementById('linkFormHeader').innerHTML = `<i class="fas fa-link"></i> Add Important Link`;
            document.getElementById('linkSubmitBtn').innerHTML = `<i class="fas fa-save"></i> Save Link`;
            document.getElementById('linkCancelBtn').style.display = 'none';
        };
        window.deleteLink = function(id) {
            if (!confirm("Are you sure you want to delete this link?")) return;
            fetch(`manage_links.php?id=${id}`, { method: 'DELETE' })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    if (document.getElementById('linkId').value == id) {
                        cancelLinkEdit();
                    }
                    loadAdminLinks();
                } else {
                    alert("Error: " + data.message);
                }
            });
        };
        if (addLinkForm) {
            addLinkForm.addEventListener('submit', e => {
                e.preventDefault();
                const linkIdVal = document.getElementById('linkId').value;
                const fileInput = document.getElementById('linkImage');
                const formData = new FormData();
                if (linkIdVal) {
                    formData.append('id', linkIdVal);
                }
                formData.append('category', document.getElementById('linkCategory').value);
                formData.append('title', document.getElementById('linkTitle').value.trim());
                formData.append('url', document.getElementById('linkUrl').value.trim());
                if (fileInput.files.length > 0) {
                    formData.append('image', fileInput.files[0]);
                }

                fetch('manage_links.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        cancelLinkEdit();
                        loadAdminLinks();
                        alert(linkIdVal ? "Link updated successfully!" : "Link saved successfully!");
                    } else {
                        alert("Error: " + data.message);
                    }
                });
            });
        }

        // 17. Achievements CRUD Javascript
        let globalAdminAchievements = [];
        const addAchievementForm = document.getElementById('addAchievementForm');
        
        function loadAdminAchievements() {
            fetch('manage_achievements.php')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    globalAdminAchievements = data.achievements;
                    renderAdminAchievements(data.achievements);
                }
            })
            .catch(err => console.error("Error loading achievements:", err));
        }

        function renderAdminAchievements(achievements) {
            const listEl = document.getElementById('admin-achievements-list');
            if (listEl) {
                if (achievements.length === 0) {
                    listEl.innerHTML = '<p style="padding:10px; color:#64748b;">No achievements available.</p>';
                    return;
                }
                listEl.innerHTML = achievements.map(a => `
                    <div style="background:white; padding:15px; border-radius:10px; display:flex; justify-content:space-between; align-items:center; border:1px solid #e2e8f0; margin-bottom: 10px; box-shadow:0 2px 5px rgba(0,0,0,0.02);">
                        <div style="display:flex; align-items:center; gap:15px;">
                            <div style="width:40px; height:40px; background:#f1f5f9; color:#d4af37; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:1.2rem;">
                                <i class="fas ${a.icon_class || 'fa-trophy'}"></i>
                            </div>
                            <div>
                                <strong style="color:var(--portal-blue); display:block; font-size:1rem;">${a.title_en}</strong>
                                <span style="font-size:0.85rem; color:#64748b; display:block; max-width: 500px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">${a.description_en}</span>
                            </div>
                        </div>
                        <div style="display:flex; gap:8px;">
                            <button type="button" onclick="editAchievement(${a.id})" style="background:#3b82f6; color:white; border:none; padding:8px 14px; border-radius:6px; cursor:pointer; transition:0.2s;"><i class="fas fa-edit"></i> Edit</button>
                            <button type="button" onclick="deleteAchievement(${a.id})" style="background:#ef4444; color:white; border:none; padding:8px 14px; border-radius:6px; cursor:pointer; transition:0.2s;"><i class="fas fa-trash"></i> Delete</button>
                        </div>
                    </div>
                `).join('');
            }
        }

        window.editAchievement = function(id) {
            const a = globalAdminAchievements.find(item => item.id == id);
            if (!a) return;

            document.getElementById('achievementId').value = a.id;
            document.getElementById('achTitleEn').value = a.title_en || '';
            document.getElementById('achTitleSi').value = a.title_si || '';
            document.getElementById('achTitleTa').value = a.title_ta || '';
            document.getElementById('achDescEn').value = a.description_en || '';
            document.getElementById('achDescSi').value = a.description_si || '';
            document.getElementById('achDescTa').value = a.description_ta || '';
            
            // Check if icon is standard
            const standardIcons = ['fa-trophy', 'fa-building', 'fa-award', 'fa-medal', 'fa-star', 'fa-graduation-cap', 'fa-users', 'fa-check-double', 'fa-chart-line', 'fa-landmark', 'fa-gears'];
            if (standardIcons.includes(a.icon_class)) {
                document.getElementById('achIconClass').value = a.icon_class;
                document.getElementById('achIconClassCustom').value = '';
            } else {
                document.getElementById('achIconClassCustom').value = a.icon_class || '';
            }

            document.getElementById('achievementFormHeader').innerHTML = `<i class="fas fa-edit"></i> Edit Achievement`;
            document.getElementById('achSubmitBtn').innerHTML = `<i class="fas fa-save"></i> Update Achievement`;
            document.getElementById('achCancelBtn').style.display = 'inline-flex';

            document.getElementById('achievementFormHeader').scrollIntoView({ behavior: 'smooth' });
        };

        window.cancelAchievementEdit = function() {
            if (addAchievementForm) addAchievementForm.reset();
            document.getElementById('achievementId').value = '';
            document.getElementById('achievementFormHeader').innerHTML = `<i class="fas fa-trophy"></i> Add Achievement`;
            document.getElementById('achSubmitBtn').innerHTML = `<i class="fas fa-save"></i> Save Achievement`;
            document.getElementById('achCancelBtn').style.display = 'none';
        };

        window.deleteAchievement = function(id) {
            if (!confirm("Are you sure you want to delete this achievement?")) return;
            fetch(`manage_achievements.php?id=${id}`, { method: 'DELETE' })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    if (document.getElementById('achievementId').value == id) {
                        cancelAchievementEdit();
                    }
                    loadAdminAchievements();
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(err => alert("Failed to delete achievement."));
        };

        if (addAchievementForm) {
            addAchievementForm.addEventListener('submit', e => {
                e.preventDefault();
                const achievementIdVal = document.getElementById('achievementId').value;
                const formData = new FormData();
                if (achievementIdVal) {
                    formData.append('id', achievementIdVal);
                }
                
                const titleEn = document.getElementById('achTitleEn').value.trim();
                const titleSi = document.getElementById('achTitleSi').value.trim() || titleEn;
                const titleTa = document.getElementById('achTitleTa').value.trim() || titleEn;
                const descEn = document.getElementById('achDescEn').value.trim();
                const descSi = document.getElementById('achDescSi').value.trim() || descEn;
                const descTa = document.getElementById('achDescTa').value.trim() || descEn;
                
                const customIcon = document.getElementById('achIconClassCustom').value.trim();
                const iconClass = customIcon ? customIcon : document.getElementById('achIconClass').value;

                formData.append('title_en', titleEn);
                formData.append('title_si', titleSi);
                formData.append('title_ta', titleTa);
                formData.append('description_en', descEn);
                formData.append('description_si', descSi);
                formData.append('description_ta', descTa);
                formData.append('icon_class', iconClass);

                fetch('manage_achievements.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        cancelAchievementEdit();
                        loadAdminAchievements();
                        alert(achievementIdVal ? "Achievement updated successfully!" : "Achievement added successfully!");
                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch(err => alert("Failed to save achievement."));
            });
        }

        // 17. RTI Officers Management
        let globalRtiOfficers = [];
        const addRtiOfficerForm = document.getElementById('addRtiOfficerForm');

        function loadRtiOfficers() {
            fetch('manage_rti_officers.php')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    globalRtiOfficers = data.officers;
                    renderRtiOfficers(data.officers);
                }
            })
            .catch(err => console.error("Error loading RTI officers:", err));
        }

        function renderRtiOfficers(officers) {
            const listEl = document.getElementById('admin-rti-officers-list');
            if (listEl) {
                if (officers.length === 0) {
                    listEl.innerHTML = '<p style="padding:15px; color:#64748b; font-style:italic;">No RTI officers found.</p>';
                    return;
                }
                listEl.innerHTML = officers.map(o => {
                    const roleLabel = o.role_type === 'designated' ? 'Designated Officer' : 'Information Officer';
                    return `
                        <div style="background:white; padding:15px; border-radius:8px; display:flex; justify-content:space-between; align-items:center; border:1px solid #e2e8f0; margin-bottom: 8px;">
                            <div>
                                <span style="background: ${o.role_type === 'designated' ? '#fef3c7' : '#dbeafe'}; color: ${o.role_type === 'designated' ? '#d97706' : '#2563eb'}; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; margin-right: 10px;">${roleLabel}</span>
                                <strong>${o.name_en}</strong>
                                <span style="font-size:0.85rem; color:#64748b; margin-left:10px;">(${o.designation_en})</span>
                            </div>
                            <div style="display: flex; gap: 5px;">
                                <button type="button" onclick="editRtiOfficer(${o.id})" style="background:#3b82f6; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer;"><i class="fas fa-edit"></i> Edit</button>
                                <button type="button" onclick="deleteRtiOfficer(${o.id})" style="background:#ef4444; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer;"><i class="fas fa-trash"></i> Delete</button>
                            </div>
                        </div>
                    `;
                }).join('');
            }
        }

        window.editRtiOfficer = function(id) {
            const o = globalRtiOfficers.find(item => item.id == id);
            if (!o) return;

            document.getElementById('rtiOfficerId').value = o.id;
            document.getElementById('rtiRoleType').value = o.role_type || 'designated';
            document.getElementById('rtiPhone').value = o.phone || '';
            document.getElementById('rtiEmail').value = o.email || '';
            
            document.getElementById('rtiNameEn').value = o.name_en || '';
            document.getElementById('rtiNameSi').value = o.name_si || '';
            document.getElementById('rtiNameTa').value = o.name_ta || '';
            
            document.getElementById('rtiDesignationEn').value = o.designation_en || '';
            document.getElementById('rtiDesignationSi').value = o.designation_si || '';
            document.getElementById('rtiDesignationTa').value = o.designation_ta || '';
            
            document.getElementById('rtiAddressEn').value = o.address_en || '';
            document.getElementById('rtiAddressSi').value = o.address_si || '';
            document.getElementById('rtiAddressTa').value = o.address_ta || '';

            document.getElementById('rtiOfficerFormHeader').innerHTML = `<i class="fas fa-edit"></i> Edit RTI Officer`;
            document.getElementById('rtiSubmitBtn').innerHTML = `<i class="fas fa-save"></i> Update RTI Officer`;
            document.getElementById('rtiCancelBtn').style.display = 'inline-flex';

            document.getElementById('rtiOfficerFormHeader').scrollIntoView({ behavior: 'smooth' });
        };

        window.cancelRtiOfficerEdit = function() {
            if (addRtiOfficerForm) addRtiOfficerForm.reset();
            document.getElementById('rtiOfficerId').value = '';
            document.getElementById('rtiOfficerFormHeader').innerHTML = `<i class="fas fa-plus"></i> Add RTI Officer`;
            document.getElementById('rtiSubmitBtn').innerHTML = `<i class="fas fa-save"></i> Save RTI Officer`;
            document.getElementById('rtiCancelBtn').style.display = 'none';
        };

        window.deleteRtiOfficer = function(id) {
            if (!confirm("Are you sure you want to delete this RTI officer?")) return;
            fetch(`manage_rti_officers.php?id=${id}`, { method: 'DELETE' })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    if (document.getElementById('rtiOfficerId').value == id) {
                        cancelRtiOfficerEdit();
                    }
                    loadRtiOfficers();
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(err => alert("Failed to delete RTI officer."));
        };

        if (addRtiOfficerForm) {
            addRtiOfficerForm.addEventListener('submit', e => {
                e.preventDefault();
                const rtiOfficerIdVal = document.getElementById('rtiOfficerId').value;
                const roleType = document.getElementById('rtiRoleType').value;
                const rtiPhone = document.getElementById('rtiPhone').value.trim();
                const rtiEmail = document.getElementById('rtiEmail').value.trim();
                
                const nameEn = document.getElementById('rtiNameEn').value.trim();
                const nameSi = document.getElementById('rtiNameSi').value.trim();
                const nameTa = document.getElementById('rtiNameTa').value.trim();
                
                const designationEn = document.getElementById('rtiDesignationEn').value.trim();
                const designationSi = document.getElementById('rtiDesignationSi').value.trim();
                const designationTa = document.getElementById('rtiDesignationTa').value.trim();
                
                const addressEn = document.getElementById('rtiAddressEn').value.trim();
                const addressSi = document.getElementById('rtiAddressSi').value.trim();
                const addressTa = document.getElementById('rtiAddressTa').value.trim();

                const formData = new FormData();
                if (rtiOfficerIdVal) {
                    formData.append('id', rtiOfficerIdVal);
                }
                formData.append('role_type', roleType);
                formData.append('phone', rtiPhone);
                formData.append('email', rtiEmail);
                
                formData.append('name_en', nameEn);
                formData.append('name_si', nameSi);
                formData.append('name_ta', nameTa);
                
                formData.append('designation_en', designationEn);
                formData.append('designation_si', designationSi);
                formData.append('designation_ta', designationTa);
                
                formData.append('address_en', addressEn);
                formData.append('address_si', addressSi);
                formData.append('address_ta', addressTa);

                fetch('manage_rti_officers.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        cancelRtiOfficerEdit();
                        loadRtiOfficers();
                        alert(rtiOfficerIdVal ? "RTI Officer updated successfully!" : "RTI Officer added successfully!");
                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch(err => alert("Failed to save RTI officer."));
            });
        }

        // 18. RTI Application Forms Upload & Status
        function loadRtiApplicationFormStatus() {
            fetch('manage_settings.php')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    const s = data.settings;
                    if (s.rti_application_form) {
                        const updateStatus = (statusElId, fileUrl, fileKey) => {
                            const statusEl = document.getElementById(statusElId);
                            if (statusEl) {
                                if (fileUrl && fileUrl !== '#') {
                                    const filename = fileUrl.split('/').pop();
                                    statusEl.innerHTML = `<i class="fas fa-file-pdf" style="color:#ef4444; margin-right:5px;"></i> <a href="${fileUrl}" target="_blank" style="color:var(--portal-light-blue); text-decoration:underline;">${filename}</a> <a href="#" onclick="removeRtiFile('${fileKey}', event)" style="color:#ef4444; margin-left:10px; font-weight:bold; text-decoration:none;" title="Delete file">&times;</a>`;
                                } else {
                                    statusEl.innerHTML = '<span style="color:#64748b; font-style:italic;">No file uploaded</span>';
                                }
                            }
                        };
                        updateStatus('rtiFileStatusEn', s.rti_application_form.en, 'en');
                        updateStatus('rtiFileStatusSi', s.rti_application_form.si, 'si');
                        updateStatus('rtiFileStatusTa', s.rti_application_form.ta, 'ta');
                    }
                }
            })
            .catch(err => console.error("Error loading RTI form status:", err));
        }

        window.removeRtiFile = function(lang, event) {
            event.preventDefault();
            if (!confirm(`Are you sure you want to remove the ${lang.toUpperCase()} RTI form?`)) return;
            
            const formData = new FormData();
            formData.append('section_key', 'rti_application_form');
            formData.append('remove_rti_' + lang, '1');
            
            fetch('manage_settings.php', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    loadRtiApplicationFormStatus();
                    alert("RTI Form removed successfully!");
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(err => alert("Failed to remove RTI Form."));
        };

        const uploadRtiForm = document.getElementById('uploadRtiForm');
        if (uploadRtiForm) {
            uploadRtiForm.addEventListener('submit', e => {
                e.preventDefault();
                
                const fileEn = document.getElementById('rtiFileEn');
                const fileSi = document.getElementById('rtiFileSi');
                const fileTa = document.getElementById('rtiFileTa');
                
                if (!fileEn.files.length && !fileSi.files.length && !fileTa.files.length) {
                    alert("Please select at least one file to upload.");
                    return;
                }
                
                const formData = new FormData();
                formData.append('section_key', 'rti_application_form');
                if (fileEn.files.length) formData.append('rti_file_en', fileEn.files[0]);
                if (fileSi.files.length) formData.append('rti_file_si', fileSi.files[0]);
                if (fileTa.files.length) formData.append('rti_file_ta', fileTa.files[0]);
                
                fetch('manage_settings.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        uploadRtiForm.reset();
                        loadRtiApplicationFormStatus();
                        alert("RTI application forms uploaded and saved successfully!");
                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch(err => alert("Failed to upload RTI files."));
            });
        }

        function initDatabase() {
            loadUsers();
            loadOfficers();
            loadDownloads();
            loadSettings();
            loadDivisions();
            loadServices();
            loadProcurements();
            loadProjects();
            loadGallery();
            loadAdminAnnouncements();
            loadAdminNews();
            loadAdminCourses();
            loadAdminLinks();
            loadAdminAchievements();
            loadRtiOfficers();
            loadRtiApplicationFormStatus();
        }

        // Mobile Sidebar Toggle
        const mobileToggle = document.getElementById('mobileToggle');
        const sidebar = document.querySelector('.sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function openSidebar() {
            sidebar.classList.add('active');
            if (sidebarOverlay) sidebarOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        function closeSidebar() {
            sidebar.classList.remove('active');
            if (sidebarOverlay) sidebarOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        if (mobileToggle && sidebar) {
            mobileToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                sidebar.classList.contains('active') ? closeSidebar() : openSidebar();
            });

            // Close when clicking a nav link (mobile)
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 992) closeSidebar();
                });
            });

            // Close when clicking the overlay
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', closeSidebar);
            }
        }

        // Start
        initDatabase();
    </script>
</body>

</html>