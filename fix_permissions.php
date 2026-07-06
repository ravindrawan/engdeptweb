<?php
header('Content-Type: text/plain');

$dir = 'uploads';

// Step 1: Check if root directory is writable by trying to create a temp folder
$temp_dir = 'uploads_temp_test_' . time();
if (@mkdir($temp_dir, 0777, true)) {
    echo "Info: Parent directory is WRITABLE. PHP can create new folders.\n";
    @rmdir($temp_dir);
    
    // Since root is writable, we can do the folder replacement trick!
    $new_dir = 'uploads_new';
    if (!file_exists($new_dir)) {
        if (@mkdir($new_dir, 0777, true)) {
            echo "Success: Created new writable '$new_dir' directory.\n";
            @chmod($new_dir, 0777);
        } else {
            echo "Error: Failed to create '$new_dir' directory.\n";
            exit;
        }
    }
    
    // Copy all files from old uploads to uploads_new
    if (file_exists($dir) && is_dir($dir)) {
        $files = scandir($dir);
        $copied_count = 0;
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;
            $src = $dir . '/' . $file;
            $dest = $new_dir . '/' . $file;
            if (is_file($src)) {
                if (@copy($src, $dest)) {
                    $copied_count++;
                } else {
                    echo "Warning: Failed to copy '$file' from old uploads.\n";
                }
            }
        }
        echo "Info: Copied $copied_count files to new uploads directory.\n";
        
        // Rename old uploads to uploads_backup
        $backup_dir = 'uploads_backup_' . time();
        if (@rename($dir, $backup_dir)) {
            echo "Success: Renamed old '$dir' to '$backup_dir'.\n";
        } else {
            echo "Error: Failed to rename old '$dir' directory. (Try renaming or deleting the 'uploads' folder manually via FTP/FileZilla and run this script again)\n";
            // If we can't rename, we have to stop
            exit;
        }
    }
    
    // Rename uploads_new to uploads
    if (@rename($new_dir, $dir)) {
        echo "Success: Activated new PHP-owned '$dir' directory.\n";
    } else {
        echo "Error: Failed to rename '$new_dir' to '$dir'.\n";
    }
    
} else {
    echo "Error: Parent directory is NOT writable by PHP. PHP cannot create new folders in the root directory.\n";
    echo "Please use FTP (FileZilla) or contact your host to change 'uploads' folder permission to chmod 777.\n";
}

// Check final writability of uploads/
if (file_exists($dir)) {
    @chmod($dir, 0777);
    $test_file = $dir . '/test.txt';
    if (@file_put_contents($test_file, 'test')) {
        echo "Success: Able to write a file to '$dir/' directory!\n";
        @unlink($test_file);
    } else {
        echo "Error: Still unable to write to '$dir/' directory.\n";
    }
}
?>
