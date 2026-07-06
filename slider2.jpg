document.addEventListener('DOMContentLoaded', () => {

    // === Mobile Navigation & Dropdowns ===
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');
    
    if (hamburger && navMenu) {
        hamburger.addEventListener('click', (e) => {
            e.stopPropagation();
            navMenu.classList.toggle('active');
        });

        // Close nav when a link is clicked (mobile)
        navMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 992) {
                    navMenu.classList.remove('active');
                }
            });
        });

        // Close nav when clicking outside
        document.addEventListener('click', (e) => {
            if (navMenu.classList.contains('active') && !navMenu.contains(e.target) && !hamburger.contains(e.target)) {
                navMenu.classList.remove('active');
            }
        });
    }

    const dropdowns = document.querySelectorAll('.dropdown');
    dropdowns.forEach(dropdown => {
        dropdown.addEventListener('click', function(e) {
            // For mobile view, toggle dropdown on click
            if (window.innerWidth <= 992) {
                e.stopPropagation();
                this.classList.toggle('open');
                const content = this.querySelector('.dropdown-content');
                if (content) {
                    content.style.display = (this.classList.contains('open')) ? 'block' : 'none';
                }
            }
        });
    });

    // === Home Banner Slider logic ===
    let slides = [];
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    let currentSlide = 0;
    let slideInterval;

    function showSlide(index) {
        if (slides.length === 0) return;
        slides.forEach(slide => slide.classList.remove('active'));
        if (index >= slides.length) {
            currentSlide = 0;
        } else if (index < 0) {
            currentSlide = slides.length - 1;
        } else {
            currentSlide = index;
        }

        const activeSlide = slides[currentSlide];
        // Lazy load background image if data-bg exists
        if (activeSlide && activeSlide.dataset.bg && !activeSlide.style.backgroundImage) {
            activeSlide.style.backgroundImage = `url('${activeSlide.dataset.bg}')`;
        }
        
        if (activeSlide) {
            activeSlide.classList.add('active');
        }
    }

    function autoSlide() {
        showSlide(currentSlide + 1);
    }

    function startSlideIter() {
        if (slides.length > 1) {
            slideInterval = setInterval(autoSlide, 5000); // 5 seconds interval
        }
    }

    function resetSlideInterval() {
        clearInterval(slideInterval);
        startSlideIter();
    }

    function initHomeSlider() {
        slides = document.querySelectorAll('.slide');
        if (slides.length > 0) {
            currentSlide = 0;
            const activeSlide = slides[currentSlide];
            if (activeSlide && activeSlide.dataset.bg && !activeSlide.style.backgroundImage) {
                activeSlide.style.backgroundImage = `url('${activeSlide.dataset.bg}')`;
            }
            startSlideIter();
        }
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            showSlide(currentSlide + 1);
            resetSlideInterval();
        });
    }
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            showSlide(currentSlide - 1);
            resetSlideInterval();
        });
    }

    function loadHomepageSlider() {
        const homeSlider = document.getElementById('homeSlider');
        if (!homeSlider) return;

        fetch('manage_slides.php')
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success' && data.slides && data.slides.length > 0) {
                homeSlider.innerHTML = data.slides.map((s, index) => {
                    const activeClass = index === 0 ? 'active' : '';
                    if (index === 0) {
                        return `<div class="slide ${activeClass}" style="background-image: url('${s.image_url}');"></div>`;
                    } else {
                        return `<div class="slide ${activeClass}" data-bg="${s.image_url}"></div>`;
                    }
                }).join('');
                
                const controlsContainer = document.querySelector('.banner-controls');
                if (data.slides.length === 1 && controlsContainer) {
                    controlsContainer.style.display = 'none';
                } else if (controlsContainer) {
                    controlsContainer.style.display = 'flex';
                }
            }
            initHomeSlider();
        })
        .catch(err => {
            console.error("Failed to load database slider, falling back to static slides:", err);
            initHomeSlider();
        });
    }

    loadHomepageSlider();

    // === Tab Switching Logic scoped to parent containers ===
    document.querySelectorAll('.announcement-tabs').forEach(tabContainer => {
        const btns = tabContainer.querySelectorAll('.tab-btn');
        btns.forEach(btn => {
            btn.addEventListener('click', function() {
                btns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const tab = this.getAttribute('data-tab');
                const containerId = tabContainer.id;
                if (containerId === 'announcementTabs') {
                    renderAnnouncements(tab);
                } else if (containerId === 'newsTabs') {
                    renderNews(tab);
                } else if (containerId === 'coursesTabs') {
                    renderCourses(tab);
                } else if (containerId === 'linksTabs') {
                    renderLinks(tab);
                }
            });
        });
    });

    // === External Database Synchronization ===
    if (typeof syncWithPortalDatabase === 'function') {
        syncWithPortalDatabase();
    }

    const loginBtn = document.getElementById('loginBtn');
    const loginModal = document.getElementById('loginModal');
    const closeModal = document.getElementById('closeModal');
    const loginForm = document.getElementById('loginForm');
    const errorMsg = document.getElementById('errorMsg');

    if(loginBtn && loginModal) {
        loginBtn.addEventListener('click', (e) => {
            e.preventDefault();
            loginModal.classList.add('active');
        });
    }

    if(closeModal && loginModal) {
        closeModal.addEventListener('click', () => {
            loginModal.classList.remove('active');
            if(errorMsg) errorMsg.style.display = 'none';
        });

        // Click outside to close
        window.addEventListener('click', (e) => {
            if (e.target === loginModal) {
                loginModal.classList.remove('active');
                if(errorMsg) errorMsg.style.display = 'none';
            }
        });
    }

    if(loginForm) {
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const uname = document.getElementById('username')?.value.trim();
            const pass = document.getElementById('password')?.value.trim();

            const handleLocalFallback = () => {
                if (typeof portalDatabase !== 'undefined') {
                    const localUsers = JSON.parse(localStorage.getItem('portalUsers')) || portalDatabase.users;
                    const foundUser = localUsers.find(u => u.username === uname && u.password === pass);
                    
                    if (foundUser) {
                        sessionStorage.setItem('loggedInUser', JSON.stringify(foundUser));
                        if(errorMsg) errorMsg.style.display = 'none';
                        loginModal.classList.remove('active');
                        loginForm.reset();
                        window.location.href = 'members.html';
                        return true;
                    }
                }
                return false;
            };

            // Try PHP Database Authentication First
            const formData = new FormData();
            formData.append('username', uname);
            formData.append('password', pass);

            fetch('auth.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    sessionStorage.setItem('loggedInUser', JSON.stringify(data.user));
                    if(errorMsg) errorMsg.style.display = 'none';
                    loginModal.classList.remove('active');
                    loginForm.reset();
                    window.location.href = 'members.html';
                } else {
                    // Try local fallback
                    if (!handleLocalFallback()) {
                        if(errorMsg) {
                            errorMsg.innerText = data.message;
                            errorMsg.style.display = 'block';
                        }
                    }
                }
            })
            .catch(error => {
                console.error('Database connection failed. Trying local fallback:', error);
                if (!handleLocalFallback()) {
                    if(errorMsg) {
                        errorMsg.innerHTML = "Access Failed. <br><small>Try: <b>admin / admin123</b></small>";
                        errorMsg.style.display = 'block';
                    }
                }
            });
        });
    }


    // === Projects Modal Logic ===
    const projectsModal = document.getElementById('projectsModal');
    const closeProjectsModal = document.getElementById('closeProjectsModal');
    
    if(closeProjectsModal && projectsModal) {
        closeProjectsModal.addEventListener('click', () => {
            projectsModal.classList.remove('active');
        });
        window.addEventListener('click', (e) => {
            if (e.target === projectsModal) projectsModal.classList.remove('active');
        });
    }

    // === Completed Projects Modal Logic ===
    const completedProjectsModal = document.getElementById('completedProjectsModal');
    const closeCompletedProjectsModal = document.getElementById('closeCompletedProjectsModal');
    
    if(closeCompletedProjectsModal && completedProjectsModal) {
        closeCompletedProjectsModal.addEventListener('click', () => {
            completedProjectsModal.classList.remove('active');
        });
        window.addEventListener('click', (e) => {
            if (e.target === completedProjectsModal) completedProjectsModal.classList.remove('active');
        });
    }

    window.openCompletedProjectsModal = function() {
        if (completedProjectsModal) {
            completedProjectsModal.classList.add('active');
            renderProjectsContent();
        }
    };

    window.openProjectsTab = function(tabId) {
        const panes = document.querySelectorAll('.projects-pane');
        const tabBtns = document.querySelectorAll('.projects-tab-btn');
        panes.forEach(p => p.style.display = 'none');
        tabBtns.forEach(b => b.classList.remove('active'));
        
        const activePane = document.getElementById(`ptab-${tabId}`);
        const activeBtn = document.querySelector(`.projects-tab-btn[data-tab="${tabId}"]`);
        if(activePane) activePane.style.display = 'block';
        if(activeBtn) activeBtn.classList.add('active');
        if (projectsModal) projectsModal.classList.add('active');
    };

    document.querySelectorAll('.projects-tab-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            openProjectsTab(btn.dataset.tab);
        });
    });

    // === Downloads Modal Logic ===
    const downloadsModal = document.getElementById('downloadsModal');
    const closeDownloadsModal = document.getElementById('closeDownloadsModal');
    
    if(closeDownloadsModal && downloadsModal) {
        closeDownloadsModal.addEventListener('click', () => {
            downloadsModal.classList.remove('active');
        });
        window.addEventListener('click', (e) => {
            if (e.target === downloadsModal) downloadsModal.classList.remove('active');
        });
    }

    window.openDownloadsTab = function(tabId) {
        const panes = document.querySelectorAll('.downloads-pane');
        const tabBtns = document.querySelectorAll('.downloads-tab-btn');
        panes.forEach(p => p.style.display = 'none');
        tabBtns.forEach(b => b.classList.remove('active'));
        
        const activePane = document.getElementById(`dtab-${tabId}`);
        const activeBtn = document.querySelector(`.downloads-tab-btn[data-tab="${tabId}"]`);
        if(activePane) activePane.style.display = 'block';
        if(activeBtn) activeBtn.classList.add('active');
        if (downloadsModal) downloadsModal.classList.add('active');
    };

    document.querySelectorAll('.downloads-tab-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            openDownloadsTab(btn.dataset.tab);
        });
    });

    // === About Us Modal Logic ===
    const aboutUsModal = document.getElementById('aboutUsModal');
    const closeAboutModal = document.getElementById('closeAboutModal');
    
    if(closeAboutModal && aboutUsModal) {
        closeAboutModal.addEventListener('click', () => {
            aboutUsModal.classList.remove('active');
        });
        
        window.addEventListener('click', (e) => {
            if (e.target === aboutUsModal) {
                aboutUsModal.classList.remove('active');
            }
        });
    }

    window.openAboutUsTab = function(tabId) {
        const panes = document.querySelectorAll('.about-pane');
        const tabBtns = document.querySelectorAll('.about-tab-btn');
        
        panes.forEach(pane => pane.style.display = 'none');
        tabBtns.forEach(btn => btn.classList.remove('active'));
        
        const activePane = document.getElementById(`tab-${tabId}`);
        const activeBtn = document.querySelector(`.about-tab-btn[data-tab="${tabId}"]`);
        
        if(activePane) activePane.style.display = 'block';
        if(activeBtn) activeBtn.classList.add('active');
        
        if (aboutUsModal) {
            aboutUsModal.classList.add('active');
        }
    };
    
    document.querySelectorAll('.about-tab-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            openAboutUsTab(btn.dataset.tab);
        });
    });

    // === JSON Translations Logic ===
    let activeLanguage = localStorage.getItem('selectedLanguage') || 'en';
    window.setLanguage = setLanguage;

    function setLanguage(lang) {
        if (typeof translationsData === 'undefined' || !translationsData[lang]) return;

        activeLanguage = lang;
        localStorage.setItem('selectedLanguage', lang);

        document.querySelectorAll('#langSwitcher a').forEach(a => {
            if (a.getAttribute('data-lang') === lang) {
                a.classList.add('active');
            } else {
                a.classList.remove('active');
            }
        });

        const vocab = translationsData[lang];

        document.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            if (vocab[key]) {
                el.innerText = vocab[key];
            }
        });

        document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
            const key = el.getAttribute('data-i18n-placeholder');
            if (vocab[key]) {
                el.setAttribute('placeholder', vocab[key]);
            }
        });

        // Update dynamic content when language changes
        try {
            if (typeof applySiteSettings === 'function') {
                applySiteSettings();
            }
        } catch (e) {
            console.error("Error applying site settings:", e);
        }
        try {
            if (typeof renderProjectsContent === 'function') {
                renderProjectsContent();
            }
        } catch (e) {
            console.error("Error rendering projects content:", e);
        }
        try {
            if (typeof populateDynamicData === 'function') {
                populateDynamicData(lang);
            }
        } catch (e) {
            console.error("Error populating dynamic data:", e);
        }
        try {
            if (typeof renderRtiOfficersList === 'function' && window.globalRtiOfficersList) {
                renderRtiOfficersList(window.globalRtiOfficersList);
            }
        } catch (e) {
            console.error("Error rendering RTI officers:", e);
        }
    }
 
    // Load translations dynamically from JSON
    fetch('translations.json?v=16')
        .then(res => res.json())
        .then(data => {
            try {
                if (typeof translationsData !== 'undefined') {
                    for (let lang in data) {
                        if (translationsData[lang]) {
                            Object.assign(translationsData[lang], data[lang]);
                        } else {
                            translationsData[lang] = data[lang];
                        }
                    }
                }
            } catch (e) {
                console.error("Error merging translations JSON:", e);
            }
            setLanguage(activeLanguage);
        })
        .catch(err => {
            console.warn("Could not fetch translations.json, using fallback translationsData", err);
            setLanguage(activeLanguage);
        });

    const langLinks = document.querySelectorAll('#langSwitcher a[data-lang]');
    langLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const selectedLang = link.getAttribute('data-lang');
            setLanguage(selectedLang);
        });
    });

    // === Global Search Bar Logic ===
    const searchInputs = document.querySelectorAll('.search-bar input');
    const searchBtns = document.querySelectorAll('.search-bar button');

    function executeSearch(query) {
        query = query.toLowerCase().trim();
        if (!query) return;

        const divisionKeywords = {
            "head": "head-office", "office": "head-office",
            "kurunegala": "kurunegala", "kuliyapitiya": "kuliyapitiya",
            "maho": "maho", "ridigama": "ridigama", "wariyapola": "wariyapola",
            "puttalam": "puttalam", "wennappuwa": "wennappuwa"
        };

        for (let key in divisionKeywords) {
            if (query.includes(key)) {
                window.location.href = `division.html?id=${divisionKeywords[key]}`;
                return;
            }
        }

        if (query.includes("member") || query.includes("login") || query.includes("portal")) {
            alert("Please use the 'Members Login' button at the top right corner to access the portal.");
            return;
        }
        if (query.includes("division") || query.includes("divisions")) {
            window.location.href = "index.html";
            return;
        }

        let currentPath = window.location.pathname.toLowerCase();
        let isHome = currentPath.endsWith('index.html') || currentPath.endsWith('/') || !currentPath.includes('.html');

        const goToHomeAndScroll = (hash) => {
            if (isHome) {
                const el = document.querySelector(hash);
                if (el) { 
                    el.scrollIntoView({ behavior: 'smooth' }); 
                    return; 
                }
            }
            window.location.href = `index.html${hash}`;
        };

        if (query.includes("vision") || query.includes("mission") || query.includes("about")) {
            goToHomeAndScroll("#vision");
        } else if (query.includes("news") || query.includes("latest")) {
            goToHomeAndScroll("#news");
        } else if (query.includes("announcement") || query.includes("event") || query.includes("exam") || query.includes("vacancy") || query.includes("training") || query.includes("course")) {
            if (isHome) { window.scrollTo({ top: 500, behavior: 'smooth' }); } 
            else { window.location.href = "index.html"; }
        } else if (query.includes("download") || query.includes("format") || query.includes("circular") || query.includes("rate") || query.includes("right to information")) {
            alert("Please navigate to the 'Downloads' section in the top menu bar.");
        } else if (query.includes("contact") || query.includes("address") || query.includes("phone") || query.includes("email") || query.includes("location") || query.includes("map")) {
            goToHomeAndScroll("#contact");
        } else if (query.includes("services") || query.includes("service") || query.includes("investigation") || query.includes("engineering") || query.includes("construction") || query.includes("maintenance")) {
            if (isHome) { 
                openServicesTab('investigations'); 
            } else { 
                window.location.href = "index.html?open=services"; 
            }
        } else if (query.includes("procurement") || query.includes("tender")) {
            if (isHome) {
                openServicesTab('engineering'); // Bid docs & procurement are in engineering services tab
            } else {
                window.location.href = "index.html?open=services";
            }
        } else {
            alert(`No exact match found for "${query}". Try searching for a specific division (e.g. 'Kurunegala'), 'members', 'news', or 'contact'.`);
        }
    }

    searchBtns.forEach((btn, index) => {
        btn.addEventListener('click', () => {
            if (searchInputs[index]) executeSearch(searchInputs[index].value);
        });
    });

    searchInputs.forEach((input) => {
        input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                executeSearch(input.value);
            }
        });
    });

    // === Services Modal Logic ===
    const servicesModal = document.getElementById('servicesModal');
    const closeServicesModal = document.getElementById('closeServicesModal');
    
    if(closeServicesModal && servicesModal) {
        closeServicesModal.addEventListener('click', () => {
            servicesModal.classList.remove('active');
        });
        window.addEventListener('click', (e) => {
            if (e.target === servicesModal) servicesModal.classList.remove('active');
        });
    }

    window.openServicesTab = function(tabId) {
        const panes = document.querySelectorAll('.services-pane');
        const tabBtns = document.querySelectorAll('.services-tab-btn');
        panes.forEach(p => p.style.display = 'none');
        tabBtns.forEach(b => b.classList.remove('active'));
        
        const activePane = document.getElementById(`stab-${tabId}`);
        const activeBtn = document.querySelector(`.services-tab-btn[data-tab="${tabId}"]`);
        if(activePane) activePane.style.display = 'block';
        if(activeBtn) activeBtn.classList.add('active');
        if (servicesModal) servicesModal.classList.add('active');
    };

    document.querySelectorAll('.services-tab-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            openServicesTab(btn.dataset.tab);
        });
    });

    // === Check URL params to open modals on load ===
    const urlParams = new URLSearchParams(window.location.search);
    const openParam = urlParams.get('open');
    if (openParam === 'services' && typeof openServicesTab === 'function') {
        openServicesTab('investigations');
    }

    // === Premium Email Link Helper (Event Delegation) ===
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a[href^="mailto:"]');
        if (!link) return;
        
        e.preventDefault();
        const email = link.getAttribute('href').replace('mailto:', '');
        
        // Remove existing email popup if open
        const existingPopup = document.getElementById('emailHelperPopup');
        if (existingPopup) existingPopup.remove();
        
        // Create popup menu
        const popup = document.createElement('div');
        popup.id = 'emailHelperPopup';
        popup.style.cssText = `
            position: absolute;
            background: white;
            border: 1px solid #cbd5e1;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            border-radius: 8px;
            padding: 6px 0;
            z-index: 2500;
            min-width: 220px;
            font-size: 0.85rem;
            display: flex;
            flex-direction: column;
            font-family: sans-serif;
        `;
        
        // Position the popup near the link
        const rect = link.getBoundingClientRect();
        popup.style.top = `${window.scrollY + rect.bottom + 5}px`;
        popup.style.left = `${window.scrollX + rect.left}px`;
        
        // Options HTML
        popup.innerHTML = `
            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=${encodeURIComponent(email)}" target="_blank" style="padding: 10px 15px; color: #1e293b; display: flex; align-items: center; gap: 10px; text-decoration: none; transition: 0.2s;"><i class="fab fa-google" style="color: #ea4335; font-size: 1rem;"></i> Open in Gmail</a>
            <a href="https://compose.mail.yahoo.com/?to=${encodeURIComponent(email)}" target="_blank" style="padding: 10px 15px; color: #1e293b; display: flex; align-items: center; gap: 10px; text-decoration: none; transition: 0.2s;"><i class="fab fa-yahoo" style="color: #6001d2; font-size: 1rem;"></i> Open in Yahoo Mail</a>
            <a href="#" id="popupCopyBtn" style="padding: 10px 15px; color: #1e293b; display: flex; align-items: center; gap: 10px; text-decoration: none; transition: 0.2s;"><i class="fas fa-copy" style="color: #64748b; font-size: 1rem;"></i> Copy Email Address</a>
            <a href="mailto:${email}" style="padding: 10px 15px; color: #1e293b; display: flex; align-items: center; gap: 10px; border-top: 1px solid #e2e8f0; text-decoration: none; transition: 0.2s;"><i class="fas fa-envelope" style="color: #1d4ed8; font-size: 1rem;"></i> Use Default Mail App</a>
        `;
        
        document.body.appendChild(popup);
        
        // Hover styles for options
        const popupLinks = popup.querySelectorAll('a');
        popupLinks.forEach(pLink => {
            pLink.addEventListener('mouseenter', () => pLink.style.background = '#f1f5f9');
            pLink.addEventListener('mouseleave', () => pLink.style.background = 'transparent');
        });
        
        // Copy action
        const copyBtn = popup.querySelector('#popupCopyBtn');
        copyBtn.addEventListener('click', function(eBtn) {
            eBtn.preventDefault();
            navigator.clipboard.writeText(email).then(() => {
                copyBtn.innerHTML = '<i class="fas fa-check" style="color: #10b981; font-size: 1rem;"></i> Address Copied!';
                setTimeout(() => {
                    popup.remove();
                }, 1000);
            });
        });
        
        // Close popup on click outside
        const closeHandler = function(eWindow) {
            if (!popup.contains(eWindow.target) && eWindow.target !== link && !link.contains(eWindow.target)) {
                popup.remove();
                document.removeEventListener('click', closeHandler);
            }
        };
        setTimeout(() => {
            document.addEventListener('click', closeHandler);
        }, 50);
    });

    // === Dynamic CMS Loading ===
    let siteSettings = {};
    let globalProjects = [];

    function fetchDownloads() {
        const rateBooksList = document.getElementById('rate_books-list');
        const typePlansList = document.getElementById('type_plans-list');
        const progressReportsList = document.getElementById('progress_reports-list');
        const rtiList = document.getElementById('rti-list');

        fetch('manage_downloads.php')
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                const renderCategory = (listEl, catName) => {
                    if (!listEl) return;
                    let filtered = data.downloads.filter(d => d.category === catName);

                    if (filtered.length > 0) {
                        listEl.innerHTML = filtered.map(d => `
                            <div class="download-item">
                                <div class="download-info">
                                    <div class="icon-box"><i class="fas ${d.icon_class || 'fa-file-alt'}"></i></div>
                                    <div class="dl-text">
                                        <strong>${d.title}</strong>
                                        <p>${d.description || d.desc || ''}</p>
                                    </div>
                                </div>
                                <a href="${d.file_url}" class="dl-btn" style="text-decoration:none;" download>
                                    <i class="fas fa-cloud-download-alt"></i> Download
                                </a>
                            </div>
                        `).join('');
                    } else {
                        listEl.innerHTML = '<p style="padding:10px; color:#64748b;">No files available in this category.</p>';
                    }
                };

                renderCategory(rateBooksList, 'rate_books');
                renderCategory(typePlansList, 'type_plans');
                renderCategory(progressReportsList, 'progress_reports');
                renderCategory(rtiList, 'rti');
            }
        })
        .catch(err => console.error("Downloads load failed:", err));
    }

    function fetchRtiOfficers() {
        const container = document.getElementById('rti-officers-container');
        if (!container) return;

        fetch('manage_rti_officers.php')
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                renderRtiOfficersList(data.officers);
            }
        })
        .catch(err => console.error("Error loading RTI officers:", err));
    }

    window.globalRtiOfficersList = [];
    function renderRtiOfficersList(officers) {
        const container = document.getElementById('rti-officers-container');
        if (!container || !officers) return;
        
        window.globalRtiOfficersList = officers;
        const lang = activeLanguage;

        if (officers.length === 0) {
            container.innerHTML = '<p style="padding:10px; color:#64748b; font-style:italic; grid-column: 1 / -1;">No RTI officers details available at the moment.</p>';
            return;
        }

        container.innerHTML = officers.map(o => {
            const name = o['name_' + lang] || o.name_en;
            const designation = o['designation_' + lang] || o.designation_en;
            const address = o['address_' + lang] || o.address_en;
            
            let roleLabel = '';
            if (o.role_type === 'designated') {
                roleLabel = (typeof translationsData !== 'undefined' && translationsData[lang] && translationsData[lang]['lbl_rti_designated'])
                    ? translationsData[lang]['lbl_rti_designated']
                    : (lang === 'si' ? 'නම් කළ නිලධාරියා' : (lang === 'ta' ? 'குறிக்கப்பட்ட அதிகாரி' : 'Designated Officer'));
            } else {
                roleLabel = (typeof translationsData !== 'undefined' && translationsData[lang] && translationsData[lang]['lbl_rti_information'])
                    ? translationsData[lang]['lbl_rti_information']
                    : (lang === 'si' ? 'තොරතුරු නිලධාරි' : (lang === 'ta' ? 'தகவல் அதிகாரி' : 'Information Officer'));
            }

            return `
                <div class="officer-card" style="padding: 20px; text-align: left; background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(10px); border-radius: 12px; border: 1px solid var(--border-glass);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; flex-wrap: wrap; gap: 8px;">
                        <span style="background: ${o.role_type === 'designated' ? 'var(--accent-gold)' : 'var(--primary-blue)'}; color: ${o.role_type === 'designated' ? 'var(--portal-dark)' : 'white'}; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">
                            ${roleLabel}
                        </span>
                    </div>
                    <h4 style="font-size: 1.15rem; color: var(--portal-blue); font-weight: 700; margin-bottom: 5px;">${name}</h4>
                    <p style="font-size: 0.85rem; color: #475569; font-weight: 600; text-transform: uppercase; margin-bottom: 15px; letter-spacing: 0.5px;">${designation}</p>
                    
                    <div style="display: flex; flex-direction: column; gap: 8px; font-size: 0.9rem; color: #334155;">
                        <div><i class="fas fa-phone-alt" style="color: var(--accent-gold); width: 20px;"></i> ${o.phone}</div>
                        <div><i class="fas fa-envelope" style="color: var(--accent-gold); width: 20px;"></i> <a href="mailto:${o.email}" style="color: var(--primary-light); text-decoration: none;">${o.email}</a></div>
                        ${address ? `<div><i class="fas fa-map-marker-alt" style="color: var(--accent-gold); width: 20px;"></i> ${address}</div>` : ''}
                    </div>
                </div>
            `;
        }).join('');
    }

    function fetchStaff() {
        const staffBody = document.getElementById('aboutStaffTableBody');
        if (!staffBody) return;

        fetch('manage_officers.php')
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success' && data.officers.length > 0) {
                // Order by id (ascending) to maintain matching order as seeded
                const sortedOfficers = [...data.officers].sort((a, b) => parseInt(a.id) - parseInt(b.id));
                let index = 1;
                staffBody.innerHTML = sortedOfficers.map(o => `
                    <tr>
                        <td>${index++}</td>
                        <td><strong>${o.name}</strong></td>
                        <td>${o.title}</td>
                        <td>${o.division || 'Head Office'}</td>
                        <td>
                            ${o.email ? `<a href="mailto:${o.email}"><i class="far fa-envelope"></i> ${o.email}</a>` : 'N/A'}
                        </td>
                    </tr>
                `).join('');
            }
        })
        .catch(err => console.error("Staff load failed:", err));
    }

    let globalAchievements = [];
    function fetchAchievements() {
        fetch('manage_achievements.php')
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                globalAchievements = data.achievements;
                renderAchievements();
            }
        })
        .catch(err => console.error("Error loading achievements:", err));
    }

    function renderAchievements() {
        const container = document.getElementById('achievementsListContainer');
        if (!container) return;
        const lang = activeLanguage;

        if (globalAchievements.length === 0) {
            container.innerHTML = '<p style="padding:15px; color:#64748b; font-style:italic;">No achievements available at the moment.</p>';
            return;
        }

        container.innerHTML = globalAchievements.map(a => {
            const title = a['title_' + lang] || a.title_en;
            const desc = a['description_' + lang] || a.description_en;
            const icon = a.icon_class || 'fa-trophy';
            return `
                <div class="achievement-highlight-box" style="margin-top: 0;">
                    <i class="fas ${icon} highlight-trophy-icon"></i>
                    <div>
                        <h4 style="color: var(--primary-blue); font-weight: 700; margin-bottom: 5px; font-size: 1.2rem; text-align: left;">${title}</h4>
                        <p style="font-size: 1.05rem; line-height: 1.7; color: #475569; margin: 0; font-style: italic; text-align: justify !important;">${desc}</p>
                    </div>
                </div>
            `;
        }).join('');
    }

    function loadSiteSettings() {
        fetch('manage_settings.php?increment=1')
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                siteSettings = data.settings;
                applySiteSettings();
            }
        })
        .catch(err => console.error("Error loading settings:", err));

        fetchProjects();
        fetchDownloads();
        fetchStaff();
        fetchAnnouncements();
        fetchNews();
        fetchCourses();
        fetchLinks();
        fetchAchievements();
        fetchRtiOfficers();
    }

    function applySiteSettings() {
        const lang = activeLanguage;
        // About Us Modal fields
        const overviewEl = document.getElementById('aboutOverviewText');
        const objectivesEl = document.getElementById('aboutObjectivesText');

        if (overviewEl && siteSettings.about_overview) overviewEl.innerText = siteSettings.about_overview[lang] || siteSettings.about_overview.en;
        if (objectivesEl && siteSettings.about_objectives) objectivesEl.innerText = siteSettings.about_objectives[lang] || siteSettings.about_objectives.en;
        renderAchievements();

        // Footer fields
        const addrEl = document.getElementById('footerContactAddress');
        const phoneEl = document.getElementById('footerContactPhone');
        const emailEl = document.getElementById('footerContactEmail');
        const mapEl = document.getElementById('footerContactMap');

        if (addrEl && siteSettings.contact_address) addrEl.innerHTML = `<i class="fas fa-map-marker-alt"></i> ` + (siteSettings.contact_address[lang] || siteSettings.contact_address.en);
        if (phoneEl && siteSettings.contact_phone) phoneEl.innerHTML = `<i class="fas fa-phone"></i> ` + (siteSettings.contact_phone[lang] || siteSettings.contact_phone.en);
        if (emailEl && siteSettings.contact_email) emailEl.innerHTML = `<i class="fas fa-envelope"></i> ` + (siteSettings.contact_email[lang] || siteSettings.contact_email.en);
        if (mapEl && siteSettings.contact_map_url) mapEl.src = siteSettings.contact_map_url[lang] || siteSettings.contact_map_url.en;

        // News Bar Ticker
        const newsBarTextEl = document.getElementById('newsBarText');
        if (newsBarTextEl && siteSettings.news_bar) {
            newsBarTextEl.innerHTML = siteSettings.news_bar[lang] || siteSettings.news_bar.en;
        }

        // RTI Application Form Download Link
        const rtiDownloadContainer = document.getElementById('rti-application-download-container');
        const rtiDownloadLink = document.getElementById('rti-application-download-link');
        if (rtiDownloadContainer && rtiDownloadLink && siteSettings.rti_application_form) {
            const currentFileUrl = siteSettings.rti_application_form[lang] || siteSettings.rti_application_form.en;
            if (currentFileUrl && currentFileUrl !== '#') {
                rtiDownloadLink.href = currentFileUrl;
                rtiDownloadContainer.style.display = 'block';
            } else {
                rtiDownloadContainer.style.display = 'none';
            }
        }

        // Home page banner logic (single image overrides slider - disabled in favor of dynamic slider)

        // Dynamic Services Modal population
        const populateServiceList = (elId, rawText) => {
            const listEl = document.getElementById(elId);
            if (!listEl) return;
            if (!rawText) {
                listEl.innerHTML = '';
                return;
            }
            const lines = rawText.split('\n').map(l => l.trim()).filter(l => l.length > 0);
            listEl.innerHTML = lines.map(line => `
                <li><i class="fas fa-check-circle" style="color:var(--primary-light);"></i> <span>${line}</span></li>
            `).join('');
        };

        populateServiceList('servicesInvestigationsList', siteSettings.service_inv_list ? (siteSettings.service_inv_list[lang] || siteSettings.service_inv_list.en) : '');
        populateServiceList('servicesEngineeringList', siteSettings.service_eng_list ? (siteSettings.service_eng_list[lang] || siteSettings.service_eng_list.en) : '');
        populateServiceList('servicesConstructionList', siteSettings.service_const_list ? (siteSettings.service_const_list[lang] || siteSettings.service_const_list.en) : '');
        populateServiceList('servicesOperationList', siteSettings.service_op_list ? (siteSettings.service_op_list[lang] || siteSettings.service_op_list.en) : '');
        populateServiceList('servicesInstitutionalList', siteSettings.service_inst_list ? (siteSettings.service_inst_list[lang] || siteSettings.service_inst_list.en) : '');

        const engDescEl = document.getElementById('servicesEngineeringDesc');
        if (engDescEl && siteSettings.service_eng_desc) {
            engDescEl.innerText = siteSettings.service_eng_desc[lang] || siteSettings.service_eng_desc.en;
        }

        const constDescEl = document.getElementById('servicesConstructionDesc');
        if (constDescEl && siteSettings.service_const_desc) {
            constDescEl.innerText = siteSettings.service_const_desc[lang] || siteSettings.service_const_desc.en;
        }

        // Visitor Counter formatting and display
        const visitorCountEl = document.getElementById('visitorCountBadge');
        if (visitorCountEl && siteSettings.visitor_count) {
            const countStr = siteSettings.visitor_count.en || '0';
            const paddedCount = countStr.padStart(6, '0');
            const formattedCount = paddedCount.split('').join(' ');
            visitorCountEl.innerText = formattedCount;
        }
    }



    // === Procurement Notices Modal Logic ===
    const procurementsModal = document.getElementById('procurementsModal');
    const closeProcurementsModal = document.getElementById('closeProcurementsModal');
    const procurementsList = document.getElementById('procurementsList');

    window.openProcurementsModal = function() {
        if (procurementsModal) procurementsModal.classList.add('active');
        fetchProcurements();
    };

    if (closeProcurementsModal && procurementsModal) {
        closeProcurementsModal.addEventListener('click', () => procurementsModal.classList.remove('active'));
        window.addEventListener('click', (e) => {
            if (e.target === procurementsModal) procurementsModal.classList.remove('active');
        });
    }

    function fetchProcurements() {
        if (!procurementsList) return;
        procurementsList.innerHTML = '<p style="padding:20px; text-align:center; color:#64748b;">Loading procurement notices...</p>';

        fetch('manage_procurements.php')
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success' && data.procurements.length > 0) {
                procurementsList.innerHTML = data.procurements.map(p => `
                    <div class="download-item">
                        <div class="download-info">
                            <div class="icon-box"><i class="fas fa-file-pdf"></i></div>
                            <div class="dl-text">
                                <strong>${p.title}</strong>
                                <p>Published on: ${p.publish_date} | Status: <span style="font-weight:600; color:${p.status === 'active' ? '#10b981' : '#ef4444'};">${p.status.toUpperCase()}</span></p>
                            </div>
                        </div>
                        <a href="${p.file_url}" class="dl-btn" target="_blank" style="text-decoration:none;">
                            <i class="fas fa-cloud-download-alt"></i> View Notice
                        </a>
                    </div>
                `).join('');
            } else {
                procurementsList.innerHTML = '<p style="padding:20px; text-align:center; color:#64748b;">No active procurement notices available.</p>';
            }
        })
        .catch(err => {
            console.error("Tenders load failed:", err);
            procurementsList.innerHTML = '<p style="padding:20px; text-align:center; color:#dc2626;">Failed to load notices. Please try again.</p>';
        });
    }

    // === Gallery Modal Logic ===
    const galleryModal = document.getElementById('galleryModal');
    const closeGalleryModal = document.getElementById('closeGalleryModal');
    const galleryGrid = document.getElementById('galleryGrid');

    window.openGalleryModal = function() {
        if (galleryModal) galleryModal.classList.add('active');
        fetchGallery();
    };

    if (closeGalleryModal && galleryModal) {
        closeGalleryModal.addEventListener('click', () => galleryModal.classList.remove('active'));
        window.addEventListener('click', (e) => {
            if (e.target === galleryModal) galleryModal.classList.remove('active');
        });
    }

    function fetchGallery() {
        if (!galleryGrid) return;
        galleryGrid.innerHTML = '<p style="padding:20px; text-align:center; color:#64748b; grid-column: 1 / -1;">Loading gallery...</p>';

        fetch('manage_gallery.php')
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success' && data.gallery.length > 0) {
                galleryGrid.innerHTML = data.gallery.map(g => `
                    <div class="officer-card" style="padding: 15px;">
                        <div style="width:100%; height:180px; overflow:hidden; border-radius:12px; margin-bottom:15px; border: 1px solid var(--border-glass);">
                            <img src="${g.image_url}" alt="${g.title}" style="width:100%; height:100%; object-fit:cover; border-radius:12px; border:none;">
                        </div>
                        <h4 style="font-size:1.1rem; margin-bottom:5px; text-align:left; color:var(--portal-blue);">${g.title}</h4>
                        <p style="font-size:0.85rem; color:#64748b; text-align:left; line-height:1.4;">${g.description}</p>
                    </div>
                `).join('');
            } else {
                galleryGrid.innerHTML = '<p style="padding:20px; text-align:center; color:#64748b; grid-column: 1 / -1;">No photos available in gallery.</p>';
            }
        })
        .catch(err => {
            console.error("Gallery load failed:", err);
            galleryGrid.innerHTML = '<p style="padding:20px; text-align:center; color:#dc2626; grid-column: 1 / -1;">Failed to load gallery.</p>';
        });
    }

    // === Dynamic Projects Integration ===
    function fetchProjects() {
        fetch('manage_projects.php')
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                globalProjects = data.projects;
                renderProjectsContent();
            }
        })
        .catch(err => console.error("Projects load failed:", err));
    }

    function renderProjectsContent() {
        const lang = activeLanguage;
        
        const summaryPane = document.getElementById('ptab-summary');
        const keyPane = document.getElementById('ptab-key-projects');
        const completedContainer = document.getElementById('completedProjectsListContainer');

        const getProjectImagesHtml = (imageUrl) => {
            if (!imageUrl) return '';
            let images = [];
            if (imageUrl.startsWith('[')) {
                try {
                    images = JSON.parse(imageUrl);
                } catch (e) {
                    images = [imageUrl];
                }
            } else if (imageUrl.includes(',')) {
                images = imageUrl.split(',');
            } else {
                images = [imageUrl];
            }
            images = images.filter(img => img.trim() !== '');
            if (images.length === 0) return '';
            
            if (images.length === 1) {
                return `<img src="${images[0]}" style="width: 120px; height: 90px; object-fit: cover; border-radius: 8px; border:1px solid #ddd; cursor: pointer;" onclick="window.open('${images[0]}', '_blank')" alt="">`;
            }
            
            // Render multiple images in a neat 2x2 thumbnail grid within the same visual boundary
            return `
                <div style="display: grid; grid-template-columns: repeat(2, 60px); gap: 6px; width: 126px;">
                    ${images.map(img => `<img src="${img}" style="width: 60px; height: 42px; object-fit: cover; border-radius: 4px; border:1px solid #ddd; cursor: pointer;" onclick="window.open('${img}', '_blank')" alt="">`).join('')}
                </div>
            `;
        };

        const getProjectGalleryHtml = (p) => {
            const parseProjectImages = (imgField) => {
                if (!imgField || imgField === 'NULL' || imgField === '') return [];
                try {
                    if (imgField.trim().startsWith('[')) {
                        const parsed = JSON.parse(imgField);
                        if (Array.isArray(parsed)) return parsed;
                    }
                } catch (e) {
                    console.error("Error parsing images JSON", e);
                }
                return [imgField];
            };

            const beforeImages = parseProjectImages(p.image_before);
            const afterImages = parseProjectImages(p.image_after);
            const hasBefore = beforeImages.length > 0;
            const hasAfter = afterImages.length > 0;
            let galleryType = p.gallery_type || 'none';
            
            if (galleryType === 'none' && (hasBefore || hasAfter)) {
                galleryType = 'renovation';
            }
            
            if (galleryType === 'none') return '';
            
            const beforeText = lang === 'si' ? 'ප්‍රතිසංස්කරණයට පෙර' : (lang === 'ta' ? 'புதுப்பிப்பதற்கு முன்' : 'Before Renovation');
            const afterText = lang === 'si' ? 'ප්‍රතිසංස්කරණයට පසු' : (lang === 'ta' ? 'புதுப்பித்த பின்' : 'After Renovation');
            const eventText = lang === 'si' ? 'ඡායාරූප' : (lang === 'ta' ? 'புகைப்படங்கள்' : 'Photos');

            if (galleryType === 'renovation' && (hasBefore || hasAfter)) {
                return `
                    <div class="${hasBefore && hasAfter ? 'before-after-grid' : ''}" style="margin-top: 12px; border-top: 1px dashed #e2e8f0; padding-top: 10px; width: 100%;">
                        ${hasBefore ? `
                            <div>
                                <span style="font-size: 0.7rem; font-weight: 700; color: rgb(239, 68, 68); text-transform: uppercase; display: block; margin-bottom: 5px;">${beforeText}</span>
                                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 6px;">
                                    ${beforeImages.map(img => `<img src="${img}" style="width: 100%; height: 70px; object-fit: cover; border-radius: 6px; border: 1px solid #e2e8f0; cursor: pointer;" onclick="window.open('${img}', '_blank')" alt="">`).join('')}
                                </div>
                            </div>
                        ` : ''}
                        ${hasAfter ? `
                            <div>
                                <span style="font-size: 0.7rem; font-weight: 700; color: rgb(34, 197, 94); text-transform: uppercase; display: block; margin-bottom: 5px;">${afterText}</span>
                                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 6px;">
                                    ${afterImages.map(img => `<img src="${img}" style="width: 100%; height: 70px; object-fit: cover; border-radius: 6px; border: 1px solid #e2e8f0; cursor: pointer;" onclick="window.open('${img}', '_blank')" alt="">`).join('')}
                                </div>
                            </div>
                        ` : ''}
                    </div>
                `;
            } else if (galleryType === 'event' && hasBefore) {
                return `
                    <div style="margin-top: 12px; border-top: 1px dashed #e2e8f0; padding-top: 10px; width: 100%;">
                        <span style="font-size: 0.7rem; font-weight: 700; color: rgb(59, 130, 246); text-transform: uppercase; display: block; margin-bottom: 5px;">${eventText}</span>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 6px;">
                            ${beforeImages.map(img => `<img src="${img}" style="width: 100%; height: 70px; object-fit: cover; border-radius: 6px; border: 1px solid #e2e8f0; cursor: pointer;" onclick="window.open('${img}', '_blank')" alt="">`).join('')}
                        </div>
                    </div>
                `;
            }
            return '';
        };

        // Summary Projects
        const summaryProjects = globalProjects.filter(p => p.category === 'summary');
        if (summaryPane) {
            summaryPane.innerHTML = `
                <h2 class="content-title">Project Summary</h2>
                ${summaryProjects.length > 0 ? summaryProjects.map(p => `
                    <div style="background:rgba(255,255,255,0.5); padding:15px; border-radius:10px; margin-bottom:15px; border:1px solid var(--border-glass);">
                        <h3 style="color:var(--portal-blue); font-weight:600; margin-bottom:5px;">${p['title_' + lang] || p.title_en}</h3>
                        <p>${p['description_' + lang] || p.description_en}</p>
                        ${p.financial_details ? `<strong style="color:var(--accent-gold); display:block; margin-top:5px;">${p.financial_details}</strong>` : ''}
                    </div>
                `).join('') : '<p>Total project counts and financial summaries for the current year.</p>'}
            `;
        }

        // Key Projects
        const keyProjects = globalProjects.filter(p => p.category === 'key');
        if (keyPane) {
            keyPane.innerHTML = `
                <h2 class="content-title">Key Ongoing Projects</h2>
                <div class="officers-grid" style="grid-template-columns: 1fr; gap: 20px;">
                    ${keyProjects.length > 0 ? keyProjects.map(p => `
                        <div class="download-item" style="align-items: flex-start; gap: 20px; flex-direction: row; text-align: left; padding:15px;">
                            ${getProjectImagesHtml(p.image_url)}
                            <div class="dl-text" style="flex:1;">
                                <strong style="color:var(--portal-blue);">${p['title_' + lang] || p.title_en}</strong>
                                <p style="margin: 5px 0; line-height:1.4;">${p['description_' + lang] || p.description_en}</p>
                                ${p.financial_details ? `<span style="font-weight: 600; color: var(--accent-gold); font-size:0.9rem;">${p.financial_details}</span>` : ''}
                                ${getProjectGalleryHtml(p)}
                            </div>
                        </div>
                    `).join('') : '<p>Major infrastructure and building projects currently in progress.</p>'}
                </div>
            `;
        }

        // Completed Projects
        const completedProjects = globalProjects.filter(p => p.category === 'completed');
        if (completedContainer) {
            completedContainer.innerHTML = completedProjects.length > 0 ? completedProjects.map(p => `
                <div class="download-item" style="align-items: flex-start; gap: 20px; flex-direction: row; text-align: left; padding:15px; margin-bottom: 15px; background: white; border: 1px solid rgba(18, 35, 64, 0.08); border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    ${getProjectImagesHtml(p.image_url)}
                    <div class="dl-text" style="flex:1;">
                        <strong style="color:var(--portal-blue); font-size:1.15rem; display:block; margin-bottom:5px;">${p['title_' + lang] || p.title_en}</strong>
                        <p style="margin: 5px 0; line-height:1.5; color:#475569;">${p['description_' + lang] || p.description_en}</p>
                        ${p.financial_details ? `<span style="font-weight: 600; color: var(--accent-gold); font-size:0.9rem; display:block; margin-top:5px;">${p.financial_details}</span>` : ''}
                        ${getProjectGalleryHtml(p)}
                    </div>
                </div>
            `).join('') : '<p style="color:#64748b; font-style:italic;">No completed projects available at the moment.</p>';
        }
    }

    // === CMS Announcements, News, Courses, Links Loaders ===
    let globalAnnouncements = [];
    function fetchAnnouncements() {
        fetch('manage_announcements.php')
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                globalAnnouncements = data.announcements;
                const activeTab = document.querySelector('#announcementTabs .tab-btn.active')?.getAttribute('data-tab') || 'internal';
                renderAnnouncements(activeTab);
            }
        })
        .catch(err => console.error("Error fetching announcements:", err));
    }
    function renderAnnouncements(category) {
        const list = document.getElementById('announcementsList');
        if (!list) return;
        const filtered = globalAnnouncements.filter(a => a.category === category);
        if (filtered.length > 0) {
            list.innerHTML = filtered.map(a => `
                <li>
                    <a href="${a.url || '#'}">
                        <i class="fas fa-caret-right"></i> ${a.title}
                        ${a.badge ? `<span class="badge">${a.badge}</span>` : ''}
                    </a>
                </li>
            `).join('');
        } else {
            list.innerHTML = '<li style="color:#64748b; font-style:italic; padding-left:10px; list-style:none;">No announcements available.</li>';
        }
    }

    let globalNews = [];
    function fetchNews() {
        fetch('manage_news.php')
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                // Filter out news older than 3 months from the public website
                const threeMonthsAgo = new Date();
                threeMonthsAgo.setMonth(threeMonthsAgo.getMonth() - 3);
                threeMonthsAgo.setHours(0, 0, 0, 0);

                globalNews = data.news.filter(n => {
                    if (!n.news_date) return false;
                    const parts = n.news_date.split('-');
                    const newsDate = new Date(parts[0], parts[1] - 1, parts[2]);
                    return newsDate >= threeMonthsAgo;
                });

                const activeTab = document.querySelector('#newsTabs .tab-btn.active')?.getAttribute('data-tab') || 'dept-news';
                renderNews(activeTab);
            }
        })
        .catch(err => console.error("Error fetching news:", err));
    }
    function renderNews(category) {
        const list = document.getElementById('newsList');
        if (!list) return;
        const filtered = globalNews.filter(n => n.category === category);
        if (filtered.length > 0) {
            list.innerHTML = filtered.map(n => `
                <div class="news-card">
                    ${n.image_url ? `<img src="${n.image_url}" alt="News Image" loading="lazy">` : ''}
                    <div class="news-info">
                        <h4>${n.title}</h4>
                        <span class="news-date"><i class="far fa-calendar-alt"></i> ${n.news_date}</span>
                        <p>${n.content}</p>
                        <a href="#" class="read-more" onclick="openNewsModal(${n.id}); return false;">View more »</a>
                    </div>
                </div>
            `).join('');
        } else {
            list.innerHTML = '<div style="color:#64748b; padding:20px; text-align:center; font-style:italic;">No news articles available.</div>';
        }
    }

    // === News Details Modal ===
    const newsDetailsModal = document.getElementById('newsDetailsModal');
    const closeNewsDetailsModal = document.getElementById('closeNewsDetailsModal');
    
    if (closeNewsDetailsModal && newsDetailsModal) {
        closeNewsDetailsModal.addEventListener('click', () => {
            newsDetailsModal.classList.remove('active');
        });
        window.addEventListener('click', (e) => {
            if (e.target === newsDetailsModal) newsDetailsModal.classList.remove('active');
        });
    }

    window.openNewsModal = function(id) {
        const n = globalNews.find(item => item.id == id);
        if (!n) return;

        const titleEl = document.getElementById('newsModalTitle');
        const catEl = document.getElementById('newsModalCategory');
        const dateEl = document.getElementById('newsModalDate');
        const contentEl = document.getElementById('newsModalContent');
        const imgContainer = document.getElementById('newsModalImageContainer');
        const imgEl = document.getElementById('newsModalImage');

        // Before/After Elements
        const baContainer = document.getElementById('newsModalBeforeAfterContainer');
        const beforeWrapper = document.getElementById('newsModalBeforeWrapper');
        const afterWrapper = document.getElementById('newsModalAfterWrapper');
        const beforeImagesEl = document.getElementById('newsModalBeforeImages');
        const afterImagesEl = document.getElementById('newsModalAfterImages');

        if (titleEl) titleEl.innerText = n.title;
        if (catEl) catEl.innerText = n.category === 'dept-news' ? 'Department News' : 'Provincial News';
        if (dateEl) dateEl.innerHTML = `<i class="far fa-calendar-alt" style="color:var(--accent-gold); margin-right:5px;"></i> ${n.news_date}`;
        if (contentEl) contentEl.innerText = n.content;

        if (imgEl && imgContainer) {
            if (n.image_url) {
                imgEl.src = n.image_url;
                imgContainer.style.display = 'block';
            } else {
                imgContainer.style.display = 'none';
            }
        }

        // Parse helper
        function parseImages(imgField) {
            if (!imgField || imgField === 'NULL' || imgField === '') return [];
            try {
                if (imgField.trim().startsWith('[')) {
                    const parsed = JSON.parse(imgField);
                    if (Array.isArray(parsed)) return parsed;
                }
            } catch (e) {
                console.error("Error parsing images JSON", e);
            }
            return [imgField];
        }

        // Handle Photos logic based on gallery_type
        const beforeImages = parseImages(n.image_before);
        const afterImages = parseImages(n.image_after);
        const hasBefore = beforeImages.length > 0;
        const hasAfter = afterImages.length > 0;
        
        let galleryType = n.gallery_type || 'none';
        if (galleryType === 'none' && (hasBefore || hasAfter)) {
            galleryType = 'renovation';
        }

        if (baContainer && beforeWrapper && afterWrapper && beforeImagesEl && afterImagesEl) {
            if (galleryType === 'renovation' && (hasBefore || hasAfter)) {
                baContainer.style.display = 'grid';
                
                if (hasBefore && hasAfter) {
                    baContainer.style.gridTemplateColumns = '1fr 1fr';
                    beforeWrapper.style.display = 'flex';
                    afterWrapper.style.display = 'flex';
                } else if (hasBefore) {
                    baContainer.style.gridTemplateColumns = '1fr';
                    beforeWrapper.style.display = 'flex';
                    afterWrapper.style.display = 'none';
                } else {
                    baContainer.style.gridTemplateColumns = '1fr';
                    beforeWrapper.style.display = 'none';
                    afterWrapper.style.display = 'flex';
                }

                // Restore Labels to Before/After Renovation with translation support
                const beforeLabel = beforeWrapper.querySelector('span');
                const afterLabel = afterWrapper.querySelector('span');
                
                const beforeText = (typeof translationsData !== 'undefined' && translationsData[activeLanguage] && translationsData[activeLanguage]['news_before']) 
                    ? translationsData[activeLanguage]['news_before'] 
                    : (activeLanguage === 'si' ? 'ප්‍රතිසංස්කරණයට පෙර' : (activeLanguage === 'ta' ? 'புதுப்பிப்பதற்கு முன்' : 'Before Renovation'));
                
                const afterText = (typeof translationsData !== 'undefined' && translationsData[activeLanguage] && translationsData[activeLanguage]['news_after']) 
                    ? translationsData[activeLanguage]['news_after'] 
                    : (activeLanguage === 'si' ? 'ප්‍රතිසංස්කරණයට පසු' : (activeLanguage === 'ta' ? 'புதுப்பித்த பின்' : 'After Renovation'));

                if (beforeLabel) {
                    beforeLabel.innerText = beforeText;
                    beforeLabel.style.background = 'rgba(239, 68, 68, 0.1)';
                    beforeLabel.style.color = 'rgb(239, 68, 68)';
                    beforeLabel.style.border = '1px solid rgba(239, 68, 68, 0.2)';
                }
                if (afterLabel) {
                    afterLabel.innerText = afterText;
                    afterLabel.style.background = 'rgba(34, 197, 94, 0.1)';
                    afterLabel.style.color = 'rgb(34, 197, 94)';
                    afterLabel.style.border = '1px solid rgba(34, 197, 94, 0.2)';
                }

                // Populate Before images
                if (hasBefore) {
                    beforeImagesEl.style.gridTemplateColumns = beforeImages.length > 1 ? '1fr 1fr' : '1fr';
                    beforeImagesEl.innerHTML = beforeImages.map(imgSrc => `
                        <div style="border-radius:10px; overflow:hidden; border:1px solid var(--border-gray); aspect-ratio: 16 / 9; width: 100%; cursor:pointer;" onclick="window.open('${imgSrc}', '_blank')">
                            <img src="${imgSrc}" style="width:100%; height:100%; object-fit:cover; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        </div>
                    `).join('');
                } else {
                    beforeImagesEl.innerHTML = '';
                }

                // Populate After images
                if (hasAfter) {
                    afterImagesEl.style.gridTemplateColumns = afterImages.length > 1 ? '1fr 1fr' : '1fr';
                    afterImagesEl.innerHTML = afterImages.map(imgSrc => `
                        <div style="border-radius:10px; overflow:hidden; border:1px solid var(--border-gray); aspect-ratio: 16 / 9; width: 100%; cursor:pointer;" onclick="window.open('${imgSrc}', '_blank')">
                            <img src="${imgSrc}" style="width:100%; height:100%; object-fit:cover; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        </div>
                    `).join('');
                } else {
                    afterImagesEl.innerHTML = '';
                }
            } else if (galleryType === 'event' && hasBefore) {
                baContainer.style.display = 'grid';
                baContainer.style.gridTemplateColumns = '1fr';
                beforeWrapper.style.display = 'flex';
                afterWrapper.style.display = 'none';

                // Set Label to Event Photos
                const beforeLabel = beforeWrapper.querySelector('span');
                const eventText = activeLanguage === 'si' ? 'සිදුවීම් ඡායාරූප' : (activeLanguage === 'ta' ? 'நிகழ்வு புகைப்படங்கள்' : 'Event Photos');
                
                if (beforeLabel) {
                    beforeLabel.innerText = eventText;
                    beforeLabel.style.background = 'rgba(59, 130, 246, 0.1)';
                    beforeLabel.style.color = 'rgb(59, 130, 246)';
                    beforeLabel.style.border = '1px solid rgba(59, 130, 246, 0.2)';
                }

                // Populate Event images (stored in image_before)
                beforeImagesEl.style.gridTemplateColumns = beforeImages.length > 1 ? '1fr 1fr' : '1fr';
                beforeImagesEl.innerHTML = beforeImages.map(imgSrc => `
                    <div style="border-radius:10px; overflow:hidden; border:1px solid var(--border-gray); aspect-ratio: 16 / 9; width: 100%; cursor:pointer;" onclick="window.open('${imgSrc}', '_blank')">
                        <img src="${imgSrc}" style="width:100%; height:100%; object-fit:cover; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    </div>
                `).join('');
            } else {
                baContainer.style.display = 'none';
                beforeImagesEl.innerHTML = '';
                afterImagesEl.innerHTML = '';
            }
        }

        if (newsDetailsModal) {
            newsDetailsModal.classList.add('active');
        }
    };

    let globalCourses = [];
    function fetchCourses() {
        fetch('manage_courses.php')
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                globalCourses = data.courses;
                const activeTab = document.querySelector('#coursesTabs .tab-btn.active')?.getAttribute('data-tab') || 'upcoming';
                renderCourses(activeTab);
            }
        })
        .catch(err => console.error("Error fetching courses:", err));
    }
    function renderCourses(category) {
        const list = document.getElementById('coursesList');
        if (!list) return;
        const filtered = globalCourses.filter(c => c.category === category);
        if (filtered.length > 0) {
            list.innerHTML = filtered.map(c => `
                <li>
                    <div class="course-item" onclick="if('${c.url}' !== '#') window.open('${c.url}', '_blank');" style="cursor: ${c.url !== '#' ? 'pointer' : 'default'};">
                        <div class="course-icon"><i class="fas ${c.icon_class || 'fa-graduation-cap'}"></i></div>
                        <div class="course-info">
                            <strong>${c.title}</strong>
                            <span><i class="far fa-calendar-alt"></i> ${c.event_date} | ${c.location}</span>
                        </div>
                    </div>
                </li>
            `).join('');
        } else {
            list.innerHTML = '<li style="color:#64748b; padding:20px; text-align:center; font-style:italic; list-style:none;">No courses or events available.</li>';
        }
    }

    let globalLinks = [];
    function fetchLinks() {
        fetch('manage_links.php')
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                globalLinks = data.links;
                const activeTab = document.querySelector('#linksTabs .tab-btn.active')?.getAttribute('data-tab') || 'govt-links';
                renderLinks(activeTab);
            }
        })
        .catch(err => console.error("Error fetching links:", err));
    }
    function renderLinks(category) {
        const list = document.getElementById('linksList');
        if (!list) return;
        const filtered = globalLinks.filter(l => l.category === category);
        if (filtered.length > 0) {
            list.innerHTML = filtered.map(l => `
                <li style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                    ${l.image_url ? `<img src="${l.image_url}" alt="Icon" loading="lazy" style="width: 25px; height: 25px; object-fit: contain;" onerror="this.style.display='none'">` : '<i class="fas fa-external-link-alt" style="color:var(--portal-light-blue);"></i>'}
                    <a href="${l.url}" target="_blank" style="text-decoration:none; color:var(--text-dark); font-weight:500;">${l.title}</a>
                </li>
            `).join('');
        } else {
            list.innerHTML = '<li style="color:#64748b; padding:10px; font-style:italic; list-style:none;">No links configured.</li>';
        }
    }

    // Load initial settings
    loadSiteSettings();

    // === Star Rating for Feedback ===
    const stars = document.querySelectorAll('.fb-star');
    stars.forEach(star => {
        star.addEventListener('mouseover', function() {
            const val = parseInt(this.dataset.val);
            stars.forEach(s => {
                s.style.color = parseInt(s.dataset.val) <= val ? '#f59e0b' : '#cbd5e1';
            });
        });
        star.addEventListener('mouseout', function() {
            const selected = parseInt(document.getElementById('fbRating')?.value || 0);
            stars.forEach(s => {
                s.style.color = parseInt(s.dataset.val) <= selected ? '#f59e0b' : '#cbd5e1';
            });
        });
        star.addEventListener('click', function() {
            const val = this.dataset.val;
            document.getElementById('fbRating').value = val;
            stars.forEach(s => {
                s.style.color = parseInt(s.dataset.val) <= parseInt(val) ? '#f59e0b' : '#cbd5e1';
            });
        });
    });

});

// === Feedback Form Submit ===
function submitFeedback(e) {
    e.preventDefault();
    const name    = document.getElementById('fbName').value.trim();
    const email   = document.getElementById('fbEmail').value.trim();
    const rating  = document.getElementById('fbRating').value;
    const message = document.getElementById('fbMessage').value.trim();
    const msgBox  = document.getElementById('fbMsg');

    if (!name || !message) return;

    const formData = new FormData();
    formData.append('action', 'add');
    formData.append('name', name);
    formData.append('email', email);
    formData.append('rating', rating);
    formData.append('message', message);

    fetch('manage_feedback.php', { method: 'POST', body: formData })
        .then(r => r.json())
        .then(data => {
            msgBox.style.display = 'block';
            if (data.status === 'success') {
                msgBox.style.background = '#dcfce7';
                msgBox.style.color = '#166534';
                msgBox.innerHTML = '<i class="fas fa-check-circle"></i> ස්තූතියි! ඔබේ යෝජනාව ලැබිණි.';
                document.getElementById('feedbackForm').reset();
                document.querySelectorAll('.fb-star').forEach(s => s.style.color = '#cbd5e1');
                document.getElementById('fbRating').value = 0;
            } else {
                msgBox.style.background = '#fee2e2';
                msgBox.style.color = '#991b1b';
                msgBox.innerHTML = '<i class="fas fa-exclamation-circle"></i> ' + (data.message || 'Error sending feedback.');
            }
            setTimeout(() => { msgBox.style.display = 'none'; }, 5000);
        })
        .catch(() => {
            msgBox.style.display = 'block';
            msgBox.style.background = '#fef9c3';
            msgBox.style.color = '#854d0e';
            msgBox.innerHTML = '<i class="fas fa-info-circle"></i> ඔබේ feedback ලැබිණි. ස්තූතියි!';
            document.getElementById('feedbackForm').reset();
            document.querySelectorAll('.fb-star').forEach(s => s.style.color = '#cbd5e1');
            document.getElementById('fbRating').value = 0;
            setTimeout(() => { msgBox.style.display = 'none'; }, 5000);
        });
}

