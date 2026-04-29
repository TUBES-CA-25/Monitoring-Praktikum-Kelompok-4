<?php
/**
 * Debug Tambah Asisten
 * Trigger actual form submission to see what fails
 */

session_start();

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h2>🔍 Debug: Form Submission Received</h2>";
    echo "<pre>";
    echo "POST Data: " . json_encode($_POST, JSON_PRETTY_PRINT) . "\n\n";
    echo "FILES Data: " . json_encode($_FILES, JSON_PRETTY_PRINT) . "\n\n";
    
    // Check required fields
    $required = ['username', 'stambuk', 'nama_asisten', 'angkatan', 'status', 'jenis_kelamin'];
    echo "Required Fields Check:\n";
    foreach ($required as $field) {
        $value = $_POST[$field] ?? 'MISSING';
        $status = empty($value) ? '❌ EMPTY' : '✓ OK (' . htmlspecialchars($value) . ')';
        echo "  $field: $status\n";
    }
    
    echo "</pre>";
    exit;
}

// Show form for testing
?>

<h2>🧪 Test Tambah Asisten Form</h2>

<form method="POST" enctype="multipart/form-data">
    <h3>Data Login</h3>
    <input type="email" name="username" placeholder="Username" value="test@gmail.com" required><br>
    <input type="password" name="password" placeholder="Password" value="test123"><br>
    
    <h3>Data Asisten</h3>
    <input type="text" name="stambuk" placeholder="Stambuk" value="TEST-001" required><br>
    <input type="text" name="nama_asisten" placeholder="Nama Asisten" value="Test Asisten" required><br>
    <input type="text" name="angkatan" placeholder="Angkatan" value="2023" required><br>
    
    <label>Status:</label>
    <select name="status" required>
        <option value="">--Pilih--</option>
        <option value="Asisten" selected>Asisten</option>
        <option value="Calon Asisten">Calon Asisten</option>
    </select><br>
    
    <label>Jenis Kelamin:</label>
    <select name="jenis_kelamin" required>
        <option value="">--Pilih--</option>
        <option value="Pria" selected>Pria</option>
        <option value="Wanita">Wanita</option>
    </select><br>
    
    <label>Foto Profil:</label>
    <input type="file" name="photo_profil" accept="image/*"><br>
    
    <label>Foto TTD:</label>
    <input type="file" name="photo_path" accept="image/*"><br>
    
    <button type="submit">Submit untuk Debug</button>
</form>
