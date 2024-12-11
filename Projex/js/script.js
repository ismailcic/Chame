// Şifrenin görünürlüğünü değiştirme fonksiyonu
function togglePasswordVisibility() {
  var passwordField = document.getElementById("password");
  var toggleIcon = document.getElementById("toggleIcon");
  if (passwordField.type === "password") {
      passwordField.type = "text";
      toggleIcon.classList.remove("fa-eye");
      toggleIcon.classList.add("fa-eye-slash");
  } else {
      passwordField.type = "password";
      toggleIcon.classList.remove("fa-eye-slash");
      toggleIcon.classList.add("fa-eye");
  }
}

// Form gönderildiğinde çalışacak fonksiyon
document.getElementById('loginForm').addEventListener('submit', function(e) {
  e.preventDefault(); // Sayfanın yeniden yüklenmesini engeller

  var email = document.getElementById('email').value;
  var password = document.getElementById('password').value;

  console.log("E-posta: " + email); // Konsola e-posta yazdır
  console.log("Şifre: " + password); // Konsola şifre yazdır

  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'sql/login.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  xhr.onreadystatechange = function() {
      if (xhr.readyState === 4) {
          console.log("HTTP Durum Kodu: " + xhr.status); // Konsola HTTP durum kodunu yazdır
          if (xhr.status === 200) {
              var response = JSON.parse(xhr.responseText);
              console.log("Yanıt: ", response); // Konsola yanıtı yazdır
              if (response.success) {
                  document.getElementById('result').textContent = response.message;
                  // Yönlendirme işlemi
                  setTimeout(() => {
                      window.location.href = response.redirect;
                  }, 1000);
              } else {
                  // Kullanıcıya düzgün hata mesajını göster
                  document.getElementById('result').textContent = response.message;
              }
          } else {
              document.getElementById('result').textContent = "Bir hata oluştu. Lütfen tekrar deneyin.";
          }
      }
  };

  xhr.send('email=' + encodeURIComponent(email) + '&password=' + encodeURIComponent(password));
});
