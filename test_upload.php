<?php
/**
 * Test Upload Script
 * Untuk debug folder permissions dan upload functionality
 */

echo "<h2>Upload Directory Diagnostics</h2>";

$dirs = [
    'public/img/uploads' => 'Profile Photos',
    'public/img/signature' => 'Signatures'
];

foreach ($dirs as $dir => $label) {
    echo "<h3>$label ($dir)</h3>";
    echo "<pre>";
    
    $fullPath = dirname(__DIR__) . '/' . str_replace('/', DIRECTORY_SEPARATOR, $dir);
    
    echo "Path: $fullPath\n";
    echo "Exists: " . (file_exists($fullPath) ? 'YES' : 'NO') . "\n";
    
    if (file_exists($fullPath)) {
        echo "Is Dir: " . (is_dir($fullPath) ? 'YES' : 'NO') . "\n";
        echo "Is Writable: " . (is_writable($fullPath) ? 'YES' : 'NO') . "\n";
        echo "Permissions: " . substr(sprintf('%o', fileperms($fullPath)), -3) . "\n";
        
        // Get owner info
        if (function_exists('posix_getpwuid')) {
            $owner = posix_getpwuid(fileowner($fullPath));
            echo "Owner: {$owner['name']} (UID: {$owner['uid']})\n";
        }
        
        // List files
        $files = scandir($fullPath);
        echo "Files count: " . (count($files) - 2) . "\n";
        
        if (count($files) <= 12) {
            echo "Files:\n";
            foreach ($files as $f) {
                if ($f !== '.' && $f !== '..') {
                    echo "  - $f\n";
                }
            }
        }
    }
    
    echo "</pre>";
}

echo "<h3>PHP Upload Info</h3>";
echo "<pre>";
echo "upload_tmp_dir: " . ini_get('upload_tmp_dir') . "\n";
echo "upload_max_filesize: " . ini_get('upload_max_filesize') . "\n";
echo "post_max_size: " . ini_get('post_max_size') . "\n";
echo "Current PHP user: " . get_current_user() . "\n";
echo "</pre>";

echo "<h3>Test Form</h3>";
echo '<form method="POST" enctype="multipart/form-data">
    <input type="file" name="test_file" accept="image/*" required>
    <button type="submit" name="test_upload">Test Upload</button>
</form>';

if (isset($_POST['test_upload']) && isset($_FILES['test_file'])) {
    echo "<h3>Upload Test Result</h3>";
    echo "<pre>";
    
    $file = $_FILES['test_file'];
    echo "File name: " . $file['name'] . "\n";
    echo "File size: " . $file['size'] . " bytes\n";
    echo "File error: " . $file['error'] . "\n";
    echo "Tmp path: " . $file['tmp_name'] . "\n";
    
    $uploadDir = dirname(__DIR__) . '/public/img/uploads';
    $newPath = $uploadDir . '/' . 'test_' . time() . '_' . basename($file['name']);
    
    if (move_uploaded_file($file['tmp_name'], $newPath)) {
        echo "Upload Result: SUCCESS ✓\n";
        echo "Saved to: $newPath\n";
        // Delete after test
        unlink($newPath);
        echo "Cleaned up test file\n";
    } else {
        echo "Upload Result: FAILED ✗\n";
        echo "Target dir: $uploadDir\n";
        echo "Target writable: " . (is_writable($uploadDir) ? 'YES' : 'NO') . "\n";
    }
    
    echo "</pre>";
}
?>
