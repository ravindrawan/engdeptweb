/**
 * Members Portal - Centralized Data Store
 * This file acts as the "database" for the engineering department portal.
 * In a real-world scenario, this would be replaced by a backend API.
 */

const portalDatabase = {
    users: [
        { username: 'admin', password: 'admin123', name: 'System Administrator', role: 'admin' },
        { username: 'kasun', password: '2025', name: 'Kasun', role: 'user' },
        { username: 'officer', password: 'password123', name: 'General Officer', role: 'staff' }
    ],
    officers: [
        { id: 1, name: "Eng. A. Kumara", title: "Provincial Director", phone: "+94 37 222 4501", category: "executive", division: "Head Office" },
        { id: 2, name: "Mr. S. Perera", title: "Chief Assistant", phone: "+94 37 222 4505", category: "admin", division: "Head Office" },
        { id: 3, name: "Eng. C. Bandara", title: "Divisional Engineer", phone: "+94 37 223 1015", category: "executive", division: "Kurunegala" },
        { id: 4, name: "Eng. R. Silva", title: "Assistant Director", phone: "+94 37 222 4502", category: "executive", division: "Kuliyapitiya" },
        { id: 5, name: "Mrs. N. Jayawardena", title: "Technical Officer", phone: "+94 37 222 4510", category: "technical", division: "Maho" }
    ],
    downloads: [
        { id: 1, title: "Leave Application", desc: "Standard form for all leave types.", category: "forms", icon: "fa-file-alt" },
        { id: 2, title: "Procurement Guidelines", desc: "NWP provincial procurement procedures.", category: "circulars", icon: "fa-gavel" },
        { id: 3, title: "Design Rates 2026", desc: "Latest engineering rates for estimation.", category: "rates", icon: "fa-calculator" },
        { id: 4, title: "RTI Request Form", desc: "Form to request information under RTI Act.", category: "rti", icon: "fa-info-circle" },
        { id: 5, title: "Progress Report Template", desc: "Standard monthly progress reporting format.", category: "reports", icon: "fa-chart-line" }
    ],
    news: [
        { id: 1, title: "New Engineering Complex Inauguration", date: "2026-04-20", text: "Initiation of the new administrative complex incorporating modern architectural concepts in Kurunegala.", image: "slider3.jpg" },
        { id: 2, title: "Rural Road Development", date: "2026-04-10", text: "Completion of phase 1 for the North Western province rural road development project.", image: "logo2.jpg" }
    ]
};

// Function to initialize storage from this "database" if not already set
function syncWithPortalDatabase() {
    if (!localStorage.getItem('portalUsers')) {
        localStorage.setItem('portalUsers', JSON.stringify(portalDatabase.users));
    }
    if (!localStorage.getItem('portalOfficers')) {
        localStorage.setItem('portalOfficers', JSON.stringify(portalDatabase.officers));
    }
    if (!localStorage.getItem('portalDownloads')) {
        localStorage.setItem('portalDownloads', JSON.stringify(portalDatabase.downloads));
    }
    console.log("Portal Database Synchronized.");
}
