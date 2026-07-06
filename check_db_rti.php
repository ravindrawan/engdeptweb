<!DOCTYPE html>
<html>
<head>
    <title>Database Status and RTI Officers Test</title>
    <style>
        body { font-family: sans-serif; padding: 20px; line-height: 1.6; max-width: 800px; margin: 0 auto; background: #f8fafc; color: #1e293b; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); margin-bottom: 20px; border: 1px solid #e2e8f0; }
        .success { color: #15803d; font-weight: bold; }
        .error { color: #b91c1c; font-weight: bold; }
        pre { background: #0f172a; color: #38bdf8; padding: 15px; border-radius: 6px; overflow-x: auto; }
    </style>
</head>
<body>
    <h1>Database & RTI Table Diagnostic Tool</h1>
    
    <div class="card">
        <h2>Connection Test</h2>
        <?php
        require_once 'db_config.php';
        if (isset($db_connection_error) && $db_connection_error !== null) {
            echo "<p class='error'>✗ Connection Failed: " . htmlspecialchars($db_connection_error) . "</p>";
            echo "<p>Please ensure MySQL (XAMPP) is running and your credentials in <code>db_config.php</code> are correct.</p>";
        } else {
            echo "<p class='success'>✓ Connected successfully to database: " . htmlspecialchars($db_name) . "</p>";
        }
        ?>
    </div>

    <div class="card">
        <h2>RTI Officers Table Check</h2>
        <?php
        if (!isset($db_connection_error) || $db_connection_error === null) {
            $result = $conn->query("SHOW TABLES LIKE 'rti_officers'");
            if ($result && $result->num_rows > 0) {
                echo "<p class='success'>✓ Table 'rti_officers' exists in database.</p>";
                
                // Show schema details
                echo "<h3>Table Structure:</h3>";
                echo "<pre>";
                $columns = $conn->query("SHOW COLUMNS FROM rti_officers");
                while ($col = $columns->fetch_assoc()) {
                    echo "Field: " . str_pad($col['Field'], 18) . " | Type: " . str_pad($col['Type'], 25) . " | Nullable: " . $col['Null'] . "\n";
                }
                echo "</pre>";

                // Show row count
                $count_res = $conn->query("SELECT COUNT(*) as cnt FROM rti_officers");
                $count = $count_res->fetch_assoc()['cnt'];
                echo "<p>Currently contains <strong>$count</strong> record(s).</p>";
                
                if ($count > 0) {
                    echo "<h3>Sample Records:</h3>";
                    echo "<pre>";
                    $rows = $conn->query("SELECT id, role_type, name_en, designation_en FROM rti_officers LIMIT 5");
                    while ($r = $rows->fetch_assoc()) {
                        print_r($r);
                    }
                    echo "</pre>";
                }
            } else {
                echo "<p class='error'>✗ Table 'rti_officers' DOES NOT exist in database.</p>";
                echo "<p>Please run <a href='db_setup.php' target='_blank'>db_setup.php</a> to set up the database tables.</p>";
            }
        }
        ?>
    </div>
</body>
</html>
