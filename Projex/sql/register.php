<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chame";

// Veritabanına bağlanma
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantı kontrolü
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => "Bağlantı hatası: " . $conn->connect_error]));
}

function check_password_strength($password)
{
    $pattern = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/'; // En az 8 karakter, bir harf ve bir rakam içermeli
    return preg_match($pattern, $password);
}

// Formdan gelen verileri işleme
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $errors = []; // Hataları toplamak için bir dizi oluşturduk

    // Şifre Gücü Kontrolü
    if (!check_password_strength($password)) {
        $errors['password'] = 'Şifreniz en az 8 karakter, bir harf ve bir rakam içermelidir.';
    }
    // Kullanıcı adı kontrolü
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    if (!$stmt) {
        die(json_encode(['success' => false, 'message' => 'Kullanıcı adı sorgusu hazırlanırken hata oluştu.']));
        
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $errors['username'] = 'Bu kullanıcı adı zaten kullanılıyor.';
    }

    // E-posta kontrolü
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    if (!$stmt) {
        die(json_encode(['success' => false, 'message' => 'E-posta sorgusu hazırlanırken hata oluştu.']));
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $errors['email'] = 'Bu e-posta adresi zaten kullanılıyor.';
    }

    // Eğer hatalar varsa JSON olarak dön
    if (!empty($errors)) {
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit();
    }

    // Hatalar yoksa kullanıcıyı veritabanına ekle
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if (!$stmt) {
        die(json_encode(['success' => false, 'message' => 'Kullanıcı ekleme sorgusu hazırlanırken hata oluştu.']));
    }
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'errors' => ['database' => 'Kayıt sırasında bir hata oluştu.']]);
    }

    $stmt->close(); // Prepared statement'ı kapat
}

$conn->close(); // Veritabanı bağlantısını kapat
?>
