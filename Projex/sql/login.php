<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chame";

// Veritabanına bağlanma
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => "Bağlantı hatası: " . $conn->connect_error]));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $input_password = $_POST["password"];

    $sql = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $sql->bind_param("s", $email);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($input_password, $row["password"])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            echo json_encode(['success' => true, 'message' => "Giriş başarılı!", 'redirect' => 'sql/main.php']);
        } else {
            echo json_encode(['success' => false, 'message' => "Hatalı kullanıcı adı veya şifre."]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => "Hatalı kullanıcı adı veya şifre."]);
    }
}
$conn->close();
?>
