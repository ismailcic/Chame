<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // Kullanıcı oturumu açık değilse giriş sayfasına yönlendir
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Media - Ana Sayfa</title>
    <link rel="stylesheet" href="css/main.css">
    <script defer src="js/main.js"></script>
</head>
<body>
    <nav>
        <img src="img/logo.png" alt="Logo" class="logo">
        <ul>
            <li><a href="#home">Ana Sayfa</a></li>
            <li><a href="#profile">Profil</a></li>
            <li><a href="#messages">Mesajlar</a></li>
            <li><a href="#friends">Arkadaşlar</a></li>
            <li><a href="#settings">Ayarlar</a></li>
        </ul>
        <button onclick="logout()">Çıkış Yap</button>
    </nav>
    <div class="content">
        <div class="posts">
            <h2>Gönderiler</h2>
            <div class="post">
                <h3>Kullanıcı Adı: <?php echo htmlspecialchars($_SESSION['username']); ?></h3>
                <p>Bu bir örnek gönderidir. Yeni bir sosyal medya platformuna hoş geldiniz!</p>
                <span>Reklam alanı</span>
            </div>
            <!-- Diğer Gönderiler -->
        </div>
        <div class="sidebar">
            <h2>Reklamlar</h2>
            <p>Reklam 1</p>
            <p>Reklam 2</p>
            <h2>Mesajlar</h2>
            <div id="messageList">
                <p>Mesaj 1</p>
                <p>Mesaj 2</p>
            </div>
            <input type="text" id="messageInput" placeholder="Mesaj yaz...">
            <button id="sendMessageButton">Gönder</button>
            <h2>Arkadaşlar</h2>
            <div id="friendRequestList">
                <p>Arkadaş 1</p>
                <p>Arkadaş 2</p>
            </div>
        </div>
    </div>
</body>
<style>/* Genel Ayarlar */
body {
    font-family: 'Helvetica Neue', Arial, sans-serif;
    background-color: #f0f2f5;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #007bff;
}

.login-form {
    background-color: #fff;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.login-form img.logo {
    width: 100px;
    margin-bottom: 20px;
}

.login-form h2 {
    margin-bottom: 30px;
}

.input-group {
    position: relative;
    margin-bottom: 30px;
}

.input-group input {
    width: 100%;
    padding: 10px;
    border: none;
    border-bottom: 1px solid #ccc;
    background: transparent;
}

.input-group .highlight {
    position: absolute;
    height: 50%;
    width: 100%;
    top: 25%;
    left: 0;
    pointer-events: none;
    opacity: 0.5;
    background-color: #007bff;
}

.input-group .bar {
    position: relative;
    display: block;
    width: 100%;
}

.input-group input:focus ~ .highlight {
    transition: all 0.3s;
    opacity: 1;
}

.input-group input:focus ~ .bar {
    transform: scaleX(1);
}

.btn {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #0056b3;
}

nav {
    background-color: #007bff;
    padding: 10px;
    color: #fff;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

nav img.logo {
    width: 50px;
}

nav ul {
    list-style-type: none;
    padding: 0;
    display: flex;
}

nav ul li {
    margin-right: 20px;
}

nav ul li a {
    color: #fff;
    text-decoration: none;
}

nav button {
    background-color: #ff4b5c;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

nav button:hover {
    background-color: #d43f3a;
}

.content {
    padding: 20px;
    display: flex;
    justify-content: space-between;
    flex: 1;
}

.posts, .sidebar {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    width: 48%;
}

.posts .post {
    margin-bottom: 20px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}

.posts .post h3 {
    margin: 0;
    font-size: 18px;
}

.posts .post p {
    margin: 10px 0;
    font-size: 14px;
}

.sidebar {
    margin-left: 20px;
}

.sidebar h3 {
    margin-top: 0;
    font-size: 16px;
}

.sidebar ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.sidebar ul li {
    margin-bottom: 10px;
    font-size: 14px;
}

footer {
    background-color: #007bff;
    padding: 10px;
    color: #fff;
    text-align: center;
}


</style>
</html>
