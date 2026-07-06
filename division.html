<?php
/**
 * Database Setup Script
 * Visit this page once to create the database and tables automatically.
 */

// Try multiple password defaults to support different developer environments
$db_host = 'localhost';
$db_user = 'root';
$passwords = ['Ravi@2025', '', 'root'];
$conn = null;

foreach ($passwords as $test_pass) {
    $conn = @new mysqli($db_host, $db_user, $test_pass);
    if (!$conn->connect_error) {
        $db_pass = $test_pass;
        break;
    }
}

if ($conn->connect_error) {
    die("<h2 style='color:red;'>Connection Failed: " . $conn->connect_error . "</h2><p>Please make sure your MySQL server (XAMPP/WampServer) is running and user credentials are correct.</p>");
}

echo "<h2>Setting up NWP Engineering Portal Database...</h2>";

// 2. Create Database
$sql = "CREATE DATABASE IF NOT EXISTS nwp_engineering_portal";
if ($conn->query($sql) === TRUE) {
    echo "<p style='color:green;'>✓ Database 'nwp_engineering_portal' created successfully.</p>";
} else {
    die("<p style='color:red;'>Error creating database: " . $conn->error . "</p>");
}

// 3. Select Database
$conn->select_db('nwp_engineering_portal');
$conn->set_charset("utf8mb4");

// Ensure uploads directory is created and has correct permissions
$upload_dir = 'uploads';
if (!file_exists($upload_dir)) {
    if (@mkdir($upload_dir, 0777, true)) {
        echo "<p style='color:green;'>✓ Created '$upload_dir' folder successfully.</p>";
    } else {
        echo "<p style='color:red;'>✗ Failed to create '$upload_dir' folder.</p>";
    }
}
@chmod($upload_dir, 0777);

// Reset option to recreate and re-seed tables in UTF-8
if (isset($_GET['reset']) && $_GET['reset'] === '1') {
    echo "<p style='color:orange;'>Resetting database tables...</p>";
    $tables = [
        'rti_officers', 'slider_photos', 'achievements', 'important_links', 'courses_events', 
        'announcements', 'gallery', 'news', 'projects', 'procurements', 
        'division_info', 'site_sections', 'downloads', 'officers', 'users'
    ];
    foreach ($tables as $tbl) {
        if ($conn->query("DROP TABLE IF EXISTS `$tbl`")) {
            echo "<p style='color:green;'>✓ Table '$tbl' dropped successfully.</p>";
        } else {
            echo "<p style='color:red;'>✗ Error dropping table '$tbl': " . $conn->error . "</p>";
        }
    }
}

// 4. Create Users Table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    role ENUM('admin', 'user', 'staff') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
$conn->query($sql);

// 5. Create Officers Table
$sql = "CREATE TABLE IF NOT EXISTS officers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    title VARCHAR(100),
    phone VARCHAR(20),
    category ENUM('executive', 'admin', 'technical', 'div', 'hq') NOT NULL,
    division VARCHAR(50),
    email VARCHAR(100) DEFAULT NULL,
    photo_url VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
if ($conn->query($sql) === TRUE) {
    echo "<p style='color:green;'>✓ Table 'officers' created/verified successfully.</p>";
} else {
    echo "<p style='color:red;'>✗ Error creating Table 'officers': " . $conn->error . "</p>";
}

// Check if email column exists, otherwise add it and migrate emails from photo_url
$res = $conn->query("SHOW COLUMNS FROM officers LIKE 'email'");
if ($res && $res->num_rows == 0) {
    if ($conn->query("ALTER TABLE officers ADD COLUMN email VARCHAR(100) DEFAULT NULL AFTER division") === TRUE) {
        echo "<p style='color:green;'>✓ Added 'email' column to 'officers' table.</p>";
    } else {
        echo "<p style='color:red;'>✗ Error adding 'email' column to 'officers': " . $conn->error . "</p>";
    }
    // Migrate existing email data from photo_url column
    $conn->query("UPDATE officers SET email = photo_url WHERE email IS NULL AND photo_url LIKE '%@%'");
    $conn->query("UPDATE officers SET photo_url = NULL WHERE photo_url LIKE '%@%'");
}

// Ensure category enum column supports 'hq'
$conn->query("ALTER TABLE officers MODIFY COLUMN category ENUM('executive', 'admin', 'technical', 'div', 'hq') NOT NULL");

// Seed Officers/Staff if empty or has only dummy records (<= 2 entries)
$res_off = $conn->query("SELECT COUNT(*) as count FROM officers");
if ($res_off) {
    $row_off = $res_off->fetch_assoc();
    if ($row_off['count'] <= 2) {
        // Truncate to replace dummy data with actual staff
        $conn->query("TRUNCATE TABLE officers");
        $officers_seed = [
            ['T H M D C E Peiris', 'Provincial Director', '+94 37 222 4510', 'executive', 'Head Office', 'peirishmd@yahoo.com'],
            ['E M S B Ekanayake', 'Additional director', '+94 37 222 4511', 'executive', 'Head Office', 'emsbeke@gmail.com'],
            ['S D D Rajapakshe', 'Chief Accountant', '+94 37 222 4512', 'admin', 'Head Office', 'damayanthiacc@gmail.com'],
            ['W M H D K Wickramasinghe', 'Chief Engineer (Education)', '+94 37 222 4513', 'technical', 'Head Office', 'devikawickramasinghe@gmail.com'],
            ['D M B Dissanayake', 'Chief Engineer (Structural Design & O)', '+94 37 222 4514', 'technical', 'Head Office', 'buddhika84@gmail.com'],
            ['R A N A Bandara', 'Chief Engineer (Health)', '+94 37 222 4515', 'technical', 'Head Office', 'nalakkaarjuna1983@gmail.com'],
            ['K G N Gallage', 'Divisional Engineer', '+94 37 222 4516', 'div', 'Maho', 'eng.nishangallage@gmail.com'],
            ['R P M Weerasena', 'Divisional Engineer', '+94 37 222 4517', 'div', 'Puttalam', 'engprasadnwp@gmail.com'],
            ['G A K M Bandara', 'Divisional Engineer', '+94 37 222 4518', 'div', 'Kurunegala', 'kasunmrt@yahoo.com'],
            ['J A A L Jayasinghe', 'Divisional Engineer', '+94 37 222 4519', 'div', 'Kuliyapitiya', 'ayeshmantha132@gmail.com'],
            ['W M I P Thilakarathna', 'Divisional Engineer', '+94 37 222 4520', 'div', 'Rideegama', 'ipthilakarathna@gmail.com'],
            ['M A N Dilrukshika', 'Divisional Engineer', '+94 37 222 4521', 'div', 'Wariyapola', 'nilminitcp@gmail.com']
        ];
        
        $seeded_count = 0;
        foreach ($officers_seed as $o) {
            $stmt = $conn->prepare("INSERT INTO officers (name, title, phone, category, division, email) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $o[0], $o[1], $o[2], $o[3], $o[4], $o[5]);
            if ($stmt->execute()) {
                $seeded_count++;
            }
            $stmt->close();
        }
        echo "<p style='color:green;'>✓ Seeded $seeded_count key staff members into 'officers' table.</p>";
    }
}


// 6. Create Downloads Table
$sql = "CREATE TABLE IF NOT EXISTS downloads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    category VARCHAR(50),
    file_url VARCHAR(255) DEFAULT '#',
    icon_class VARCHAR(50) DEFAULT 'fa-file-alt'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
$conn->query($sql);

// 7. Create Site Sections (Settings) Table
$sql = "CREATE TABLE IF NOT EXISTS site_sections (
    id INT AUTO_INCREMENT PRIMARY KEY,
    section_key VARCHAR(50) UNIQUE NOT NULL,
    content_en TEXT,
    content_si TEXT,
    content_ta TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
if ($conn->query($sql) === TRUE) {
    echo "<p style='color:green;'>✓ Table 'site_sections' created successfully.</p>";
}

// 8. Create Divisions Table
$sql = "CREATE TABLE IF NOT EXISTS division_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(50) UNIQUE NOT NULL,
    name_en VARCHAR(100) NOT NULL,
    name_si VARCHAR(100),
    name_ta VARCHAR(100),
    location_en VARCHAR(100),
    location_si VARCHAR(100),
    location_ta VARCHAR(100),
    address_en TEXT,
    address_si TEXT,
    address_ta TEXT,
    phone VARCHAR(50),
    fax VARCHAR(50),
    email VARCHAR(100),
    banner_url VARCHAR(255) DEFAULT NULL,
    logo_url VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
if ($conn->query($sql) === TRUE) {
    echo "<p style='color:green;'>✓ Table 'division_info' created successfully.</p>";
}

// Check if logo_url column exists, otherwise add it
$res = $conn->query("SHOW COLUMNS FROM division_info LIKE 'logo_url'");
if ($res && $res->num_rows == 0) {
    if ($conn->query("ALTER TABLE division_info ADD COLUMN logo_url VARCHAR(255) DEFAULT NULL AFTER banner_url") === TRUE) {
        echo "<p style='color:green;'>✓ Added 'logo_url' column to 'division_info' table.</p>";
    } else {
        echo "<p style='color:red;'>✗ Error adding 'logo_url' column to 'division_info': " . $conn->error . "</p>";
    }
}

// 9. Create Procurements Table
$sql = "CREATE TABLE IF NOT EXISTS procurements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    publish_date DATE NOT NULL,
    file_url VARCHAR(255) DEFAULT '#',
    status ENUM('active', 'expired') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
if ($conn->query($sql) === TRUE) {
    echo "<p style='color:green;'>✓ Table 'procurements' created successfully.</p>";
}

// 10. Create Projects Table
$sql = "CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category ENUM('summary', 'key', 'completed') NOT NULL,
    title_en VARCHAR(255) NOT NULL,
    title_si VARCHAR(255),
    title_ta VARCHAR(255),
    description_en TEXT,
    description_si TEXT,
    description_ta TEXT,
    image_url TEXT DEFAULT NULL,
    image_before TEXT DEFAULT NULL,
    image_after TEXT DEFAULT NULL,
    financial_details VARCHAR(100) DEFAULT NULL,
    gallery_type VARCHAR(20) DEFAULT 'none'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
if ($conn->query($sql) === TRUE) {
    echo "<p style='color:green;'>✓ Table 'projects' created successfully.</p>";
}

// 11. Create Gallery Table
$sql = "CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    description TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
if ($conn->query($sql) === TRUE) {
    echo "<p style='color:green;'>✓ Table 'gallery' created successfully.</p>";
}

// 12. Create Announcements Table
$sql = "CREATE TABLE IF NOT EXISTS announcements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category ENUM('internal', 'outside') NOT NULL,
    title VARCHAR(255) NOT NULL,
    url VARCHAR(255) DEFAULT '#',
    badge VARCHAR(20) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
if ($conn->query($sql) === TRUE) {
    echo "<p style='color:green;'>✓ Table 'announcements' created successfully.</p>";
}

// 13. Create News Table
$sql = "CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category ENUM('dept-news', 'prov-news') NOT NULL,
    title VARCHAR(255) NOT NULL,
    news_date DATE NOT NULL,
    content TEXT NOT NULL,
    image_url VARCHAR(255) DEFAULT NULL,
    image_before TEXT DEFAULT NULL,
    image_after TEXT DEFAULT NULL,
    url VARCHAR(255) DEFAULT '#',
    gallery_type VARCHAR(20) DEFAULT 'none'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
if ($conn->query($sql) === TRUE) {
    echo "<p style='color:green;'>✓ Table 'news' created successfully.</p>";
}

// Dynamically add/modify columns if they are missing or need type expansion
$res = $conn->query("SHOW COLUMNS FROM news LIKE 'image_before'");
if ($res->num_rows == 0) {
    $conn->query("ALTER TABLE news ADD COLUMN image_before TEXT DEFAULT NULL AFTER image_url");
} else {
    $row = $res->fetch_assoc();
    if (stripos($row['Type'], 'varchar') !== false) {
        $conn->query("ALTER TABLE news MODIFY COLUMN image_before TEXT DEFAULT NULL");
    }
}
$res = $conn->query("SHOW COLUMNS FROM news LIKE 'image_after'");
if ($res->num_rows == 0) {
    $conn->query("ALTER TABLE news ADD COLUMN image_after TEXT DEFAULT NULL AFTER image_before");
} else {
    $row = $res->fetch_assoc();
    if (stripos($row['Type'], 'varchar') !== false) {
        $conn->query("ALTER TABLE news MODIFY COLUMN image_after TEXT DEFAULT NULL");
    }
}
$res = $conn->query("SHOW COLUMNS FROM news LIKE 'gallery_type'");
if ($res->num_rows == 0) {
    if ($conn->query("ALTER TABLE news ADD COLUMN gallery_type VARCHAR(20) DEFAULT 'none' AFTER url") === TRUE) {
        echo "<p style='color:green;'>✓ Added 'gallery_type' column to 'news' table.</p>";
    } else {
        echo "<p style='color:red;'>✗ Error adding 'gallery_type' column to 'news': " . $conn->error . "</p>";
    }
    // Migrate existing rows with images: if they have before or after images, set type to 'renovation'
    $conn->query("UPDATE news SET gallery_type = 'renovation' WHERE (image_before IS NOT NULL AND image_before != '') OR (image_after IS NOT NULL AND image_after != '')");
}

// Modify projects.image_url column to TEXT type if it's VARCHAR
$res = $conn->query("SHOW COLUMNS FROM projects LIKE 'image_url'");
if ($res && $res->num_rows > 0) {
    $row = $res->fetch_assoc();
    if (stripos($row['Type'], 'varchar') !== false) {
        $conn->query("ALTER TABLE projects MODIFY COLUMN image_url TEXT DEFAULT NULL");
    }
}
$res = $conn->query("SHOW COLUMNS FROM projects LIKE 'gallery_type'");
if ($res->num_rows == 0) {
    if ($conn->query("ALTER TABLE projects ADD COLUMN image_before TEXT DEFAULT NULL AFTER image_url") === TRUE &&
        $conn->query("ALTER TABLE projects ADD COLUMN image_after TEXT DEFAULT NULL AFTER image_before") === TRUE &&
        $conn->query("ALTER TABLE projects ADD COLUMN gallery_type VARCHAR(20) DEFAULT 'none' AFTER financial_details") === TRUE) {
        echo "<p style='color:green;'>✓ Added 'image_before', 'image_after', and 'gallery_type' columns to 'projects' table.</p>";
    } else {
        echo "<p style='color:red;'>✗ Error adding columns to 'projects': " . $conn->error . "</p>";
    }
}

// 14. Create Courses & Events Table
$sql = "CREATE TABLE IF NOT EXISTS courses_events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category ENUM('upcoming', 'completed') NOT NULL,
    title VARCHAR(255) NOT NULL,
    event_date DATE NOT NULL,
    location VARCHAR(255) NOT NULL,
    icon_class VARCHAR(50) DEFAULT 'fa-graduation-cap',
    url VARCHAR(255) DEFAULT '#'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
if ($conn->query($sql) === TRUE) {
    echo "<p style='color:green;'>✓ Table 'courses_events' created successfully.</p>";
}

// 15. Create Important Links Table
$sql = "CREATE TABLE IF NOT EXISTS important_links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category ENUM('govt-links', 'tech-links') NOT NULL,
    title VARCHAR(255) NOT NULL,
    url VARCHAR(255) NOT NULL,
    image_url VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
if ($conn->query($sql) === TRUE) {
    echo "<p style='color:green;'>✓ Table 'important_links' created successfully.</p>";
}

// 16. Create Achievements Table
$sql = "CREATE TABLE IF NOT EXISTS achievements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title_en VARCHAR(255) NOT NULL,
    title_si VARCHAR(255),
    title_ta VARCHAR(255),
    description_en TEXT,
    description_si TEXT,
    description_ta TEXT,
    icon_class VARCHAR(50) DEFAULT 'fa-trophy',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
if ($conn->query($sql) === TRUE) {
    echo "<p style='color:green;'>✓ Table 'achievements' created/verified successfully.</p>";
}

// 17. Create Homepage Slider Photos Table
$sql = "CREATE TABLE IF NOT EXISTS slider_photos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_url VARCHAR(255) NOT NULL,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
if ($conn->query($sql) === TRUE) {
    echo "<p style='color:green;'>✓ Table 'slider_photos' created successfully.</p>";
}

// 18. Create RTI Officers Table
$sql = "CREATE TABLE IF NOT EXISTS rti_officers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_type ENUM('designated', 'information') NOT NULL,
    name_en VARCHAR(150) NOT NULL,
    name_si VARCHAR(150) DEFAULT NULL,
    name_ta VARCHAR(150) DEFAULT NULL,
    designation_en VARCHAR(150) DEFAULT NULL,
    designation_si VARCHAR(150) DEFAULT NULL,
    designation_ta VARCHAR(150) DEFAULT NULL,
    phone VARCHAR(50) DEFAULT NULL,
    email VARCHAR(100) DEFAULT NULL,
    address_en VARCHAR(255) DEFAULT NULL,
    address_si VARCHAR(255) DEFAULT NULL,
    address_ta VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
if ($conn->query($sql) === TRUE) {
    echo "<p style='color:green;'>✓ Table 'rti_officers' created/verified successfully.</p>";
}





// --- SEEDING DATA ---

// Seed Users
$users = [
    ['admin', 'admin123', 'System Administrator', 'admin'],
    ['kasun', '2025', 'Kasun', 'user'],
    ['officer', 'password123', 'General Officer', 'staff']
];
foreach ($users as $u) {
    $stmt = $conn->prepare("INSERT IGNORE INTO users (username, password, full_name, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $u[0], $u[1], $u[2], $u[3]);
    $stmt->execute();
    $stmt->close();
}

// Seed Officers (Executive/HQ & divisional)
$officers = [
    ['T H M D C E Peiris', 'Provincial Director', 'peirishmd@yahoo.com', 'executive', 'Head Office', '+94 37 222 4501'],
    ['E M S B Ekanayake', 'Additional director', 'emsbeke@gmail.com', 'executive', 'Head Office', '+94 37 222 4502'],
    ['S D D Rajapakshe', 'Chief Accountant', 'damayanthiacc@gmail.com', 'admin', 'Head Office', '+94 37 222 4503'],
    ['W M H D K Wickramasinghe', 'Chief Engineer (Education)', 'devikawickramasinghe@gmail.com', 'executive', 'Head Office', '+94 37 222 4504'],
    ['D M B Dissanayake', 'Chief Engineer (Structural Design & O)', 'buddhika84@gmail.com', 'executive', 'Head Office', '+94 37 222 4505'],
    ['R A N A Bandara', 'Chief Engineer (Health)', 'nalakkaarjuna1983@gmail.com', 'executive', 'Head Office', '+94 37 222 4506'],
    
    ['G A K M Bandara', 'Divisional Engineer', 'kasunmrt@yahoo.com', 'div', 'Kurunegala', '+94 37 223 1011'],
    ['J A A L Jayasinghe', 'Divisional Engineer', 'ayeshmantha132@gmail.com', 'div', 'Kuliyapitiya', '+94 37 228 1245'],
    ['K G N Gallage', 'Divisional Engineer', 'eng.nishangallage@gmail.com', 'div', 'Maho', '+94 37 227 5005'],
    ['W M I P Thilakarathna', 'Divisional Engineer', 'ipthilakarathna@gmail.com', 'div', 'Ridigama', '+94 37 225 1105'],
    ['M A N Dilrukshika', 'Divisional Engineer', 'nilminitcp@gmail.com', 'div', 'Wariyapola', '+94 37 226 8005'],
    ['R P M Weerasena', 'Divisional Engineer', 'engprasadnwp@gmail.com', 'div', 'Puttalam', '+94 32 226 5220'],
    ['PRW Hewawitharana', 'Divisional Engineer', 'weneng1@yahoo.com', 'div', 'Wennappuwa', '+94 31 225 5587']
];
$res = $conn->query("SELECT COUNT(*) as count FROM officers");
$row = $res->fetch_assoc();
if ($row['count'] == 0) {
    foreach ($officers as $o) {
        $stmt = $conn->prepare("INSERT INTO officers (name, title, phone, category, division, email) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $o[0], $o[1], $o[5], $o[3], $o[4], $o[2]);
        $stmt->execute();
        $stmt->close();
    }
}

// Seed Site Sections (Settings, About, Contact)
$sections = [
    [
        'about_overview',
        'The NWP Engineering Department is a multidisciplinary consultancy body committed to delivering efficient, sustainable, and innovative engineering solutions for government building projects.',
        'වයඹ පළාත් ඉංජිනේරු දෙපාර්තමේන්තුව යනු රජයේ ගොඩනැගිලි ව්‍යාපෘති සඳහා කාර්යක්ෂම, තිරසාර සහ නව්‍ය ඉංජිනේරු විසඳුම් ලබා දීමට කැපවී සිටින බහුවිධ උපදේශක ආයතනයකි.',
        'வடமேல் மாகாண பொறியியல் திணைக்களம் என்பது அரச கட்டிடத் திட்டங்களுக்கு කාර්යක්ෂම, நிலையான மற்றும் නවமையான பொறியியல் தீர்வுகளை வழங்குவதில் அர்ப்பணிக்கப்பட்ட பன்முக ஆலோசனை அமைப்பாகும்.'
    ],
    [
        'about_objectives',
        'Provincial Engineering Department as a provincial organization aims primarily to conduct a general business of consultancy management and specialty service for the investigations survey study, planning and consulting of building projects undertakings.',
        'පළාත් ඉංජිනේරු දෙපාර්තමේන්තුව පළාත් මට්ටමේ සංවිධානයක් ලෙස මූලික වශයෙන් අරමුණු කරන්නේ ගොඩනැගිලි ව්‍යාපෘතිවල සමීක්ෂණ අධ්‍යයනය, සැලසුම් කිරීම සහ උපදේශනය සඳහා පොදු උපදේශන කළමනාකරණ ව්‍යාපාරයක් පැවැත්වීමයි.',
        'மாகாண பொறியியல் திணைக்களம் ஒரு மாகாண அமைப்பாக முக்கியமாக கட்டிடத் திட்டங்களின் ஆய்வு ஆய்வு, திட்டமிடல் மற்றும் ஆலோசனைக்கான பொதுவான ஆலோசனை மேலாண்மை வணிகத்தை நடத்துவதை நோக்கமாகக் கொண்டுள்ளது.'
    ],
    [
        'about_achievements',
        'Decades of excellence in provincial construction and service delivery across the Wayamba province.',
        'වයඹ පළාත පුරා දශක ගණනාවක විශිෂ්ට පළාත් ඉදිකිරීම් සහ සේවා සැපයීමේ නියැලී සිටී.',
        'வடமேல் மாகாணம் முழுவதும் தசாப்த காலங்களாக மாகாண கட்டுமான மற்றும் சேவை வழங்கலில் சிறந்து விளங்குகிறது.'
    ],
    [
        'contact_address',
        'Department of Engineering, NWP, Kurunegala',
        'ඉංජිනේරු දෙපාර්තමේන්තුව, වයඹ පළාත, කුරුණෑගල',
        'பொறியியல் திணைக்களம், வடமேல் மாகாணம், குருநாகல்'
    ],
    [
        'contact_phone',
        '+94 37 222 0000',
        '+94 37 222 0000',
        '+94 37 222 0000'
    ],
    [
        'contact_email',
        'info@nwpeng.gov.lk',
        'info@nwpeng.gov.lk',
        'info@nwpeng.gov.lk'
    ],
    [
        'contact_map_url',
        'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126490.13327670732!2d80.28841443690623!3d7.494747385966427!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae33a1e944b419b%3A0xe542385cc820b924!2sKurunegala!5e0!3m2!1sen!2slk!4v1714207907572!5m2!1sen!2slk',
        'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126490.13327670732!2d80.28841443690623!3d7.494747385966427!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae33a1e944b419b%3A0xe542385cc820b924!2sKurunegala!5e0!3m2!1sen!2slk!4v1714207907572!5m2!1sen!2slk',
        'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126490.13327670732!2d80.28841443690623!3d7.494747385966427!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae33a1e944b419b%3A0xe542385cc820b924!2sKurunegala!5e0!3m2!1sen!2slk!4v1714207907572!5m2!1sen!2slk',
        'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126490.13327670732!2d80.28841443690623!3d7.494747385966427!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae33a1e944b419b%3A0xe542385cc820b924!2sKurunegala!5e0!3m2!1sen!2slk!4v1714207907572!5m2!1sen!2slk'
    ],
    [
        'news_bar',
        'Welcome to the Official Web Portal of the North Western Province Engineering Department - Providing modern technical advice and sustainable development through architectural and engineering design.',
        'වයඹ පළාත් ඉංජිනේරු දෙපාර්තමේන්තුවේ නිල වෙබ් ද්වාරය වෙත සාදරයෙන් පිළිගනිමු - වාස්තු විද්‍යාත්මක හා ඉංජිනේරු සැලසුම් තුළින් නවීන තාක්ෂණික උපදෙස් සහ තිරසාර සංවර්ධනයක් සැලසීම.',
        'வடமேல் மாகாண பொறியியல் திணைக்களத்தின் அதிகாரப்பூர்வ இணையத்தளத்திற்கு உங்களை அன்புடன் வரவேற்கின்றோம் - கட்டிடக்கலை மற்றும் பொறியியல் வடிவமைப்பு மூலம் நவீன தொழில்நுட்ப ஆலோசனைகளையும் நிலையான அபிவிருத்தியையும் வழங்குதல்.'
    ],
    [
        'service_inv_list',
        "Site investigations & Topographic Surveys\nFoundation investigations\nEconomic and Sociological Surveys\nEvaluation of engineering surveys, formulation of projects, preparation of layouts, design and cost estimates\nEconomic and Financial analysis",
        "ස්ථානීය විමර්ශන සහ භූ විෂමතා සමීක්ෂණ\nඅත්තිවාරම් විමර්ශන\nආර්ථික හා සමාජ විද්‍යාත්මක සමීක්ෂණ\nඉංජිනේරු සමීක්ෂණ ඇගයීම, ව්‍යාපෘති සැකසීම, සැලසුම් සකස් කිරීම, සැලසුම්කරණය සහ පිරිවැය ඇස්තමේන්තු කිරීම\nආර්ථික හා මූල්‍ය විශ්ලේෂණය",
        "தள விசாரணைகள் மற்றும் நிலப்பரப்பு ஆய்வுகள்\nஅஸ்திவார விசாரணைகள்\nபொருளாதார மற்றும் சமூகவியல் ஆய்வுகள்\nபொறியியல் ஆய்வுகளின் மதிப்பீடு, திட்டங்களை உருவாக்குதல், தளவமைப்புகளை தயாரித்தல், வடிவமைப்பு மற்றும் செலவு மதிப்பீடுகள்\nபொருளாதார மற்றும் நிதி பகுப்பாய்வு"
    ],
    [
        'service_eng_list',
        "Detailed designs for architectural and structural designs\nQuantity surveying, preparation of cost analysis and Total Cost estimates\nSpecifications for Civil Works\nBid Documents\nProcurement Procedures",
        "වාස්තු විද්‍යාත්මක සහ ව්‍යුහාත්මක සැලසුම් සඳහා සවිස්තරාත්මක සැලසුම්\nප්‍රමාණ සමීක්ෂණ, පිරිවැය විශ්ලේෂණය සහ මුළු පිරිවැය ඇස්තමේන්තු සකස් කිරීම\nසිවිල් වැඩ සඳහා පිරිවිතරයන්\nලංසු ලේඛන\nප්‍රසම්පාදන ක්‍රියා පටිපාටි",
        "கட்டிடக்கலை மற்றும் கட்டமைப்பு வடிவமைப்புகளுக்கான விரிவான வடிவமைப்புகள்\nஅளவு அளவீடு, செலவு பகுப்பாய்வு தயாரித்தல் மற்றும் மொத்த செலவு மதிப்பீடுகள்\nசிவில் பணிகளுக்கான விவரக்குறிப்புகள்\nஏல ஆவணங்கள்\nகொள்முதல் நடைமுறைகள்"
    ],
    [
        'service_eng_desc',
        "PED engineers and architects also have experience and proven ability in loan administration, contract and force-account work implementation, preparation of bid documents, specifications, bid evaluation, procurement of goods and services, project implementation, monitoring, quality control and general construction supervision.",
        "පී.ඊ.ඩී. ඉංජිනේරුවන් සහ ගෘහ නිර්මාණ ශිල්පීන්ට ණය පරිපාලනය, කොන්ත්‍රාත් ක්‍රියාත්මක කිරීම, ලංසු ලේඛන සකස් කිරීම, පිරිවිතරයන්, ලංසු ඇගයීම, භාණ්ඩ හා සේවා ප්‍රසම්පාදනය, ව්‍යාපෘති ක්‍රියාත්මක කිරීම, අධීක්ෂණය, තත්ත්ව පාලනය සහ පොදු ඉදිකිරීම් අධීක්ෂණය පිළිබඳ පළපුරුද්ද සහ ඔප්පු කරන ලද හැකියාව ඇත.",
        "கடன் நிர்வாகம், ஒப்பந்தம் மற்றும் பணிகளை செயல்படுத்துதல், ஏல ஆவணங்கள் தயாரித்தல், விவரக்குறிப்புகள், ஏல மதிப்பீடு, பொருட்கள் மற்றும் சேவைகளைக் கொள்முதல் செய்தல், திட்ட அமலாக்கம், கண்காணிப்பு, தரக் கட்டுப்பாடு மற்றும் பொதுவான கட்டுமான மேற்பார்வை ஆகியவற்றில் PED பொறியாளர்கள் மற்றும் கட்டிடக் கலைஞர்கள் அனுபவமும் நிரூபிக்கப்பட்ட திறனும் கொண்டுள்ளனர்."
    ],
    [
        'service_const_list',
        "Construction Planning and Scheduling\nQuality Control\nContract Administration and Supervision\nProject Progress monitoring and Evaluation",
        "ඉදිකිරීම් සැලසුම් කිරීම සහ කාලසටහන්ගත කිරීම\nතත්ත්ව පාලනය\nකොන්ත්‍රාත් පරිපාලනය සහ අධීක්ෂණය\nව්‍යාපෘති ප්‍රගතිය නිරීක්ෂණය සහ ඇගයීම",
        "கட்டுமான திட்டமிடல் மற்றும் அட்டவணைப்படுத்தல்\nதர கட்டுப்பாடு\nஒப்பந்த நிர்வாகம் மற்றும் மேற்பார்வை\nதிட்ட முன்னேற்றத்தை கண்காணித்தல் மற்றும் மதிப்பீடு செய்தல்"
    ],
    [
        'service_const_desc',
        "PED is proud of its expertise in the management of a wide range of development projects which include the construction of multi storeyed buildings. Most of these were implemented with funding assistance from IDA, IBRD, ADB, IFAD, and JBIC.",
        "බහු මහල් ගොඩනැගිලි ඉදිකිරීම ඇතුළත් පුළුල් පරාසයක සංවර්ධන ව්‍යාපෘති කළමනාකරණය පිළිබඳ සිය විශේෂඥභාවය පිළිබඳව පී.ඊ.ඩී. ආඩම්බර වේ. මෙයින් බොහොමයක් IDA, IBRD, ADB, IFAD සහ JBIC වෙතින් මූල්‍ය ආධාර ඇතිව ක්‍රියාත්මක කරන ලදී.",
        "பல மாடி கட்டிடங்களை நிர்மாணிப்பது உள்ளிட்ட பரந்த அளவிலான அபிவிருத்தி திட்டங்களை நிர்வகிப்பதில் PED தனது நிபுணத்துவத்தைப் பற்றி பெருமிதம் கொள்கிறது. இவற்றில் பெரும்பாலானவை IDA, IBRD, ADB, IFAD மற்றும் JBIC ஆகியவற்றின் நிதி உதவியுடன் செயல்படுத்தப்பட்டன."
    ],
    [
        'service_op_list',
        "Repair and maintenance of government buildings",
        "රජයේ ගොඩනැගිලි අලුත්වැඩියා කිරීම සහ නඩත්තු කිරීම",
        "அரசு கட்டிடங்களை பழுதுபார்த்தல் மற்றும் பராமரித்தல்"
    ],
    [
        'service_inst_list',
        "Training and development of Technical staff annually\nTraining and development of supporting staff annually",
        "තාක්ෂණික කාර්ය මණ්ඩලය වාර්ෂිකව පුහුණු කිරීම සහ සංවර්ධනය කිරීම\nසහායක කාර්ය මණ්ඩලය වාර්ෂිකව පුහුණු කිරීම සහ සංවර්ධනය කිරීම",
        "தொழில்நுட்ப ஊழியர்களின் வருடாந்திர பயிற்சி மற்றும் மேம்பாடு\nஉதவி ஊழியர்களின் வருடாந்திர பயிற்சி மற்றும் மேம்பாடு"
    ]
];
foreach ($sections as $sec) {
    $stmt = $conn->prepare("INSERT INTO site_sections (section_key, content_en, content_si, content_ta) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE content_en = VALUES(content_en), content_si = VALUES(content_si), content_ta = VALUES(content_ta)");
    $stmt->bind_param("ssss", $sec[0], $sec[1], $sec[2], $sec[3]);
    $stmt->execute();
    $stmt->close();
}

// Ensure home_banner_url row exists without overwriting if already set
$conn->query("INSERT IGNORE INTO site_sections (section_key, content_en, content_si, content_ta) VALUES ('home_banner_url', '', '', '')");
$conn->query("INSERT IGNORE INTO site_sections (section_key, content_en, content_si, content_ta) VALUES ('rti_application_form', '#', '#', '#')");
$conn->query("INSERT IGNORE INTO site_sections (section_key, content_en, content_si, content_ta) VALUES ('visitor_count', '1458', '1458', '1458')");

// Seed Division Info
$divisions = [
    [
        'head-office',
        'Head Office', 'ප්‍රධාන කාර්යාලය', 'தலைமையகம்',
        'Kurunegala', 'කුරුණෑගල', 'குருநாகல்',
        'Department of Engineering, NWP, Dambulla Road, Kurunegala.',
        'ඉංජිනේරු දෙපාර්තමේන්තුව, වයඹ පළාත, දඹුල්ල පාර, කුරුණෑගල.',
        'பொறியியல் திணைக்களம், வடமேல் மாகாணம், தம்புள்ளை வீதி, குருநாகல்.',
        '+94 37 222 4501', '+94 37 222 4502', 'director@nwpeng.gov.lk'
    ],
    [
        'kurunegala',
        'Kurunegala Division', 'කුරුණෑගල අංශය', 'குருநாகல் பிரிவு',
        'Kurunegala', 'කුරුණෑගල', 'குருநாகல்',
        'Kurunegala Engineering Division, North Western Province, Kurunegala.',
        'කුරුණෑගල ඉංජිනේරු අංශය, වයඹ පළාත, කුරුණෑගල.',
        'குருநாகல் பொறியியல் பிரிவு, வடமேல் மாகாணம், குருநாகல்.',
        '+94 37 223 1011', '+94 37 223 1012', 'kurunegala@nwpeng.gov.lk'
    ],
    [
        'kuliyapitiya',
        'Kuliyapitiya Division', 'කුලියාපිටිය අංශය', 'குளியாப்பிட்டி பிரிவு',
        'Kuliyapitiya', 'කුලියාපිටිය', 'குளியாப்பிட்டி',
        'Kuliyapitiya Engineering Division, Madampe Road, Kuliyapitiya.',
        'කුලියාපිටිය ඉංජිනේරු අංශය, මාදම්පේ පාර, කුලියාපිටිය.',
        'குளியாப்பிட்டி பொறியியல் பிரிவு, மாதம்பை வீதி, குளியாப்பிட்டி.',
        '+94 37 228 1240', '+94 37 228 1241', 'kuliyapitiya@nwpeng.gov.lk'
    ],
    [
        'maho',
        'Maho Division', 'මහව අංශය', 'மாகோ பிரிவு',
        'Maho', 'මහව', 'மாகோ',
        'Maho Engineering Division, Station Road, Maho.',
        'මහව ඉංජිනේරු අංශය, දුම්රියපොළ පාර, මහව.',
        'மாகோ பொறியியல் பிரிவு, புகையிரத நிலைய வீதி, மாகோ.',
        '+94 37 227 5001', '+94 37 227 5002', 'maho@nwpeng.gov.lk'
    ],
    [
        'ridigama',
        'Ridigama Division', 'රිදීගම අංශය', 'ரிதிகம பிரிவு',
        'Ridigama', 'රිදීගම', 'ரிதிகம',
        'Ridigama Engineering Division, Kandy Road, Ridigama.',
        'රිදීගම ඉංජිනේරු අංශය, නුවර පාර, රිදීගම.',
        'ரிதிகம பொறியியல் பிரிவு, கண்டி வீதி, ரிதிகம.',
        '+94 37 225 1100', '+94 37 225 1101', 'ridigama@nwpeng.gov.lk'
    ],
    [
        'wariyapola',
        'Wariyapola Division', 'වාරියපොළ අංශය', 'வாரியப்பொல பிரிவு',
        'Wariyapola', 'වාරියපොළ', 'வாரியப்பொல',
        'Wariyapola Engineering Division, Chilaw Road, Wariyapola.',
        'වාරියපොළ ඉංජිනේරු අංශය, හලාවත පාර, වාරියපොළ.',
        'வாரியப்பொல பொறியியல் பிரிவு, சிலாபம் வீதி, வாரியப்பொல.',
        '+94 37 226 8000', '+94 37 226 8001', 'wariyapola@nwpeng.gov.lk'
    ],
    [
        'puttalam',
        'Puttalam Division', 'පුත්තලම අංශය', 'புத்தளம் பிரிவு',
        'Puttalam', 'පුත්තලම', 'புத்தளம்',
        'Puttalam Engineering Division, Colombo Road, Puttalam.',
        'පුත්තලම ඉංජිනේරු අංශය, කොළඹ පාර, පුත්තලම.',
        'புத்தளம் பொறியியல் பிரிவு, கொழும்பு வீதி, புத்தளம்.',
        '+94 32 226 5214', '+94 32 226 5215', 'puttalam@nwpeng.gov.lk'
    ],
    [
        'wennappuwa',
        'Wennappuwa Division', 'වෙන්නප්පුව අංශය', 'வென்னப்புவ பிரிவு',
        'Wennappuwa', 'වෙන්නප්පුව', 'வென்னப்புவ',
        'Wennappuwa Engineering Division, Negombo Road, Wennappuwa.',
        'වෙන්නප්පුව ඉංජිනේරු අංශය, මීගමු පාර, වෙන්නප්පුව.',
        'வென்னப்புவ பொறியியல் பிரிவு, நீர்கொழும்பு வீதி, வென்னப்புவ.',
        '+94 32 225 3000', '+94 32 225 3001', 'wennappuwa@nwpeng.gov.lk'
    ]
];
$res = $conn->query("SELECT COUNT(*) as count FROM division_info");
$row = $res->fetch_assoc();
if ($row['count'] == 0) {
    foreach ($divisions as $d) {
        $stmt = $conn->prepare("INSERT INTO division_info (slug, name_en, name_si, name_ta, location_en, location_si, location_ta, address_en, address_si, address_ta, phone, fax, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssssss", $d[0], $d[1], $d[2], $d[3], $d[4], $d[5], $d[6], $d[7], $d[8], $d[9], $d[10], $d[11], $d[12]);
        $stmt->execute();
        $stmt->close();
    }
}

// Seed Projects
$projects = [
    ['summary', 'Project Count Summary', 'ව්‍යාපෘති ගණන් සාරාංශය', 'திட்ட எண்ணிக்கை சுருக்கம்', 'Total civil engineering projects active under the current financial year.', 'වත්මන් මුදල් වර්ෂය යටතේ ක්‍රියාත්මක වන මුළු සිවිල් ඉංජිනේරු ව්‍යාපෘති.', 'நடப்பு நிதியாண்டின் கீழ் செயல்படும் சிவில் பொறியியல் திட்டங்கள்.', null, '120 Active Projects'],
    ['key', 'New Engineering Complex Inauguration', 'නව ඉංජිනේරු සංකීර්ණය විවෘත කිරීම', 'புதிய பொறியியல் வளாகத் திறப்பு விழா', 'Initiation of the new administrative complex incorporating modern architectural concepts in Kurunegala.', 'කුරුණෑගල නවීන වාස්තු විද්‍යාත්මක සංකල්ප ඇතුළත් නව පරිපාලන සංකීර්ණය ආරම්භ කිරීම.', 'குருநாகலில் நவீன கட்டடக்கலை கருத்துக்களை உள்ளடக்கிய புதிய நிர்வாக வளாகத்தை தொடங்குதல்.', 'slider3.jpg', 'Est. LKR 450 Million'],
    ['completed', 'Rural Road Development Phase 1', 'ග්‍රාමීය මාර්ග සංවර්ධනය පියවර 1', 'கிராமப்புற சாலை மேம்பாடு கட்டம் 1', 'Completion of phase 1 for the North Western province rural road development project.', 'වයඹ පළාත් ග්‍රාමීය මාර්ග සංවර්ධන ව්‍යාපෘතියේ පළමු අදියර නිම කිරීම.', 'வடமேல் மாகாண கிராமப்புற சாலை மேம்பாட்டு திட்டத்தின் முதலாம் கட்டம் நிறைவடைந்தது.', 'logo2.jpg', 'Completed - LKR 120M']
];
$res = $conn->query("SELECT COUNT(*) as count FROM projects");
$row = $res->fetch_assoc();
if ($row['count'] == 0) {
    foreach ($projects as $p) {
        $stmt = $conn->prepare("INSERT INTO projects (category, title_en, title_si, title_ta, description_en, description_si, description_ta, image_url, financial_details) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $p[0], $p[1], $p[2], $p[3], $p[4], $p[5], $p[6], $p[7], $p[8]);
        $stmt->execute();
        $stmt->close();
    }
}

// Seed Procurements
$procurements = [
    ['Supply of Office Computers & Equipment 2026', '2026-05-15', '#', 'active'],
    ['Construction of Chief Secretariat Library Building', '2026-05-10', '#', 'active'],
    ['Provincial Road Maintenance Materials Tender', '2026-04-28', '#', 'expired']
];
$res = $conn->query("SELECT COUNT(*) as count FROM procurements");
$row = $res->fetch_assoc();
if ($row['count'] == 0) {
    foreach ($procurements as $pr) {
        $stmt = $conn->prepare("INSERT INTO procurements (title, publish_date, file_url, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $pr[0], $pr[1], $pr[2], $pr[3]);
        $stmt->execute();
        $stmt->close();
    }
}

// Seed Gallery
$gallery = [
    ['Provincial Building Design Mockup', 'slider1.jpg', 'The 3D mockup of the provincial administration complex designed by the architectural unit.'],
    ['Road Rehabilitation Site Inspection', 'slider4.jpg', 'Site inspection by chief divisional engineer during road laying in Rideegama.'],
    ['Staff Training Workshop', 'slider5.jpg', 'Annual CPD workshop conducted for the technical officers at the head office training hall.']
];
$res = $conn->query("SELECT COUNT(*) as count FROM gallery");
$row = $res->fetch_assoc();
if ($row['count'] == 0) {
    foreach ($gallery as $g) {
        $stmt = $conn->prepare("INSERT INTO gallery (title, image_url, description) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $g[0], $g[1], $g[2]);
        $stmt->execute();
        $stmt->close();
    }
}

// Seed Downloads
// Clear legacy seed downloads if they contain the old categories to ensure clean migration to new 8-category structure
$check_legacy = $conn->query("SELECT COUNT(*) as count FROM downloads WHERE category = 'rates' OR category = 'reports'");
if ($check_legacy && $row_legacy = $check_legacy->fetch_assoc()) {
    if ($row_legacy['count'] > 0) {
        $conn->query("TRUNCATE TABLE downloads");
    }
}

$downloads = [
    // Public Downloads
    ['Standard Rate Book 2026', 'Provincial rate book for estimation and costing.', 'rate_books', '#', 'fa-book'],
    ['Type Plan for School Building', 'Standard blueprints for educational institutions.', 'type_plans', '#', 'fa-drafting-compass'],
    ['Annual Progress Report 2025', 'Summary of all completed works and expenditures.', 'progress_reports', '#', 'fa-chart-line'],
    ['RTI Request Form & Guidelines', 'Form to request information under RTI Act (Public).', 'rti', '#', 'fa-info-circle'],
    
    // Private (Member Only) Downloads
    ['Leave Application Form', 'Standard form for leave applications (Word/PDF).', 'forms', '#', 'fa-file-alt'],
    ['Staff Transfer Application 2026', 'Form for internal transfer requests.', 'transfers', '#', 'fa-exchange-alt'],
    ['Administrative Circular 02/2026', 'Guidelines on new office procedures.', 'circulars', '#', 'fa-file-signature'],
    ['Cost Rate Analysis Spreadsheet', 'Excel template for calculating item rate analysis.', 'rate_analysis', '#', 'fa-calculator']
];
$res = $conn->query("SELECT COUNT(*) as count FROM downloads");
$row = $res->fetch_assoc();
if ($row['count'] == 0) {
    foreach ($downloads as $d) {
        $stmt = $conn->prepare("INSERT INTO downloads (title, description, category, file_url, icon_class) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $d[0], $d[1], $d[2], $d[3], $d[4]);
        $stmt->execute();
        $stmt->close();
    }
}

// Seed Announcements
$announcements = [
    ['internal', 'Upcoming Events', 'New'],
    ['internal', 'Procurement Notice', null],
    ['internal', 'Courses', null],
    ['internal', 'Trainings', null],
    ['internal', 'Exams', null],
    ['internal', 'Vacancies', null],
    ['internal', 'Technical Training 2026', null],
    ['internal', 'Annual General Meeting', null],
    ['outside', 'National Engineering Conference 2026', 'New'],
    ['outside', 'Foreign Scholarship Opportunities', null]
];
$res = $conn->query("SELECT COUNT(*) as count FROM announcements");
$row = $res->fetch_assoc();
if ($row['count'] == 0) {
    foreach ($announcements as $an) {
        $stmt = $conn->prepare("INSERT INTO announcements (category, title, badge) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $an[0], $an[1], $an[2]);
        $stmt->execute();
        $stmt->close();
    }
}

// Seed News
$news_items = [
    ['dept-news', 'New Engineering Complex Inauguration', '2026-04-20', 'Initiation of the new administrative complex incorporating modern architectural concepts in Kurunegala.', 'slider3.jpg'],
    ['dept-news', 'Rural Road Development', '2026-04-10', 'Completion of phase 1 for the North Western province rural road development project.', 'logo2.jpg'],
    ['prov-news', 'Provincial Infrastructure Budget Released', '2026-05-01', 'Wayamba Provincial Council approved LKR 1.2 Billion for infrastructure upgrades.', 'slider1.jpg']
];
$res = $conn->query("SELECT COUNT(*) as count FROM news");
$row = $res->fetch_assoc();
if ($row['count'] == 0) {
    foreach ($news_items as $nw) {
        $stmt = $conn->prepare("INSERT INTO news (category, title, news_date, content, image_url) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nw[0], $nw[1], $nw[2], $nw[3], $nw[4]);
        $stmt->execute();
        $stmt->close();
    }
}

// Seed Courses & Events
$courses = [
    ['upcoming', 'Building Automation Systems (Online)', '2026-05-09', 'Zoom Platform', 'fa-laptop-code'],
    ['upcoming', 'CDP Process for Associate Members', '2026-12-31', 'IESL Headquarters', 'fa-users-gear'],
    ['completed', 'Project Estimation & Cost Control', '2026-02-15', 'Head Office Auditorium', 'fa-calculator']
];
$res = $conn->query("SELECT COUNT(*) as count FROM courses_events");
$row = $res->fetch_assoc();
if ($row['count'] == 0) {
    foreach ($courses as $c) {
        $stmt = $conn->prepare("INSERT INTO courses_events (category, title, event_date, location, icon_class) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $c[0], $c[1], $c[2], $c[3], $c[4]);
        $stmt->execute();
        $stmt->close();
    }
}

// Seed Important Links
$links = [
    ['govt-links', 'Chief Secretariat - NWP', '#', '1200px-Flag_of_the_North_Western_Province_(Sri_Lanka).svg.png'],
    ['govt-links', 'Ministry of Finance, Economic Stabilization & National Policies', '#', 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5f/Emblem_of_Sri_Lanka.svg/100px-Emblem_of_Sri_Lanka.svg.png'],
    ['tech-links', 'Institute for Construction Training and Development', '#', 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5f/Emblem_of_Sri_Lanka.svg/100px-Emblem_of_Sri_Lanka.svg.png'],
    ['tech-links', 'The Institution of Engineers Sri Lanka', '#', 'https://iesl.lk/images/logo/IESL_Logo_new.png']
];
$res = $conn->query("SELECT COUNT(*) as count FROM important_links");
$row = $res->fetch_assoc();
if ($row['count'] == 0) {
    foreach ($links as $l) {
        $stmt = $conn->prepare("INSERT INTO important_links (category, title, url, image_url) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $l[0], $l[1], $l[2], $l[3]);
        $stmt->execute();
        $stmt->close();
    }
}

// Seed Achievements
$achievements = [
    [
        'Decades of Construction Excellence',
        'දශක ගණනාවක ඉදිකිරීම් විශිෂ්ටත්වය',
        'தசாப்த கால கட்டுமான சிறப்பு',
        'Decades of excellence in provincial construction and service delivery across the Wayamba province.',
        'වයඹ පළාත පුරා දශක ගණනාවක විශිෂ්ට පළාත් ඉදිකිරීම් සහ සේවා සැපයීමේ නියැලී සිටී.',
        'வடமேல் மாகாணம் முழுவதும் தசாப்த காலங்களாக மாகாண கட்டுமான மற்றும் சேவை வழங்கலில் சிறந்து விளங்குகிறது.',
        'fa-trophy'
    ],
    [
        'Infrastructure Milestones',
        'යටිතල පහසුකම් සන්ධිස්ථාන',
        'உள்கட்டமைப்பு மைல்கற்கள்',
        'Successfully completed over 500 public buildings, schools, and hospitals since inception.',
        'ආරම්භයේ සිට පොදු ගොඩනැගිලි, පාසල් සහ රෝහල් 500කට අධික ප්‍රමාණයක් සාර්ථකව නිම කර ඇත.',
        'ஆரம்பத்திலிருந்து 500 க்கும் மேற்பட்ட பொது கட்டிடங்கள், பள்ளிகள் மற்றும் மருத்துவமனைகளை வெற்றிகரமாக முடித்துள்ளது.',
        'fa-building'
    ],
    [
        'ISO Quality Standards & Validation',
        'ISO තත්ත්ව ප්‍රමිතීන් සහ වලංගුකරණය',
        'ISO தரநிலைகள் மற்றும் சரிபார்ப்பு',
        'Standardized estimation rate systems implemented with digital validation and transparency.',
        'ඩිජිටල් වලංගුභාවය සහ විනිවිදභාවය සහිතව ක්‍රියාත්මක කරන ලද ප්‍රමිතිගත ඇස්තමේන්තුගත අනුපාත පද්ධති.',
        'டிஜிட்டல் சரிபார்ப்பு மற்றும் வெளிப்படைத்தன்மையுடன் தரப்படுத்தப்பட்ட மதிப்பீட்டு விகித அமைப்புகள் செயல்படுத்தப்பட்டன.',
        'fa-award'
    ]
];
$res = $conn->query("SELECT COUNT(*) as count FROM achievements");
if ($res) {
    $row = $res->fetch_assoc();
    if ($row['count'] == 0) {
        foreach ($achievements as $a) {
            $stmt = $conn->prepare("INSERT INTO achievements (title_en, title_si, title_ta, description_en, description_si, description_ta, icon_class) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $a[0], $a[1], $a[2], $a[3], $a[4], $a[5], $a[6]);
            $stmt->execute();
            $stmt->close();
        }
    }
}

// Seed Homepage Slider Photos
$default_slides = [
    ['slider1.jpg', 1],
    ['slider2.jpg', 2],
    ['slider3.jpg', 3],
    ['slider4.jpg', 4],
    ['slider5.jpg', 5]
];
$res = $conn->query("SELECT COUNT(*) as count FROM slider_photos");
if ($res) {
    $row = $res->fetch_assoc();
    if ($row['count'] == 0) {
        foreach ($default_slides as $s) {
            $stmt = $conn->prepare("INSERT INTO slider_photos (image_url, display_order) VALUES (?, ?)");
            $stmt->bind_param("si", $s[0], $s[1]);
            $stmt->execute();
            $stmt->close();
        }
        echo "<p style='color:green;'>✓ Seeded 5 default slider images into 'slider_photos' table.</p>";
    }
}

// Seed RTI Officers if empty
$res_rti = $conn->query("SELECT COUNT(*) as count FROM rti_officers");
if ($res_rti) {
    $row_rti = $res_rti->fetch_assoc();
    if ($row_rti['count'] == 0) {
        $rti_seed = [
            [
                'designated', 
                'T.H.M.D.C.E. Peiris', 'ටී.එච්.එම්.ඩී.සී.ඊ. පීරිස්', 'டி.எச்.எம்.டி.சி.ஈ. பீரிஸ்', 
                'Provincial Director', 'පළාත් අධ්‍යක්ෂ', 'மாகாண பணிப்பாளர்', 
                '+94 37 222 4510', 'peirishmd@yahoo.com', 
                'Department of Engineering, NWP, Kurunegala', 'ඉංජිනේරු දෙපාර්තමේන්තුව, වයඹ පළාත, කුරුණෑගල', 'பொறியியல் திணைக்களம், வடமேல் மாகாணம், குருநாகல்'
            ],
            [
                'information', 
                'S. Perera', 'එස්. පෙරේරා', 'எஸ். பெரேரா', 
                'Chief Assistant', 'ප්‍රධාන සහකාර', 'தலைமை உதவியாளர்', 
                '+94 37 222 4505', 'chiefassistant@nwpeng.gov.lk', 
                'Department of Engineering, NWP, Kurunegala', 'ඉංජිනේරු දෙපාර්තමේන්තුව, වයඹ පළාත, කුරුණෑගල', 'பொறியியல் திணைக்களம், வடமேல் மாகாணம், குருநாகல்'
            ]
        ];

        $seeded_rti = 0;
        foreach ($rti_seed as $r) {
            $stmt = $conn->prepare("INSERT INTO rti_officers (role_type, name_en, name_si, name_ta, designation_en, designation_si, designation_ta, phone, email, address_en, address_si, address_ta) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssssss", $r[0], $r[1], $r[2], $r[3], $r[4], $r[5], $r[6], $r[7], $r[8], $r[9], $r[10], $r[11]);
            if ($stmt->execute()) {
                $seeded_rti++;
            }
            $stmt->close();
        }
        echo "<p style='color:green;'>✓ Seeded $seeded_rti default officers into 'rti_officers' table.</p>";
    }
}

echo "<hr><h3>Setup Complete!</h3>";

echo "<p>All new tables and sample seed records have been successfully added to the database.</p>";
echo "<p>You can now go back to <a href='login.html'>Login Page</a> and try again.</p>";


$conn->close();
?>
