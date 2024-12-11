document.getElementById("username").addEventListener("input", validateUsername);
document.getElementById("password").addEventListener("input", validatePassword);
document.getElementById("confirmPassword").addEventListener("input", validateConfirmPassword);
document.getElementById("email").addEventListener("input", validateEmail);

function validateUsername() {
    const username = document.getElementById("username").value;
    const usernameError = document.getElementById("usernameError");
    if (username.length < 3) {
        usernameError.textContent = "Kullanıcı adınız en az 3 harf olmalıdır.";
    } else {
        usernameError.textContent = "";
    }
}

function validatePassword() {
    const password = document.getElementById("password").value;
    const passwordError = document.getElementById("passwordError");
    const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
    if (!passwordPattern.test(password)) {
        passwordError.textContent = "Şifreniz en az 8 karakter, bir harf ve bir rakam içermelidir.";
    } else {
        passwordError.textContent = "";
    }
}

function validateConfirmPassword() {
    const confirmPassword = document.getElementById("confirmPassword").value;
    const password = document.getElementById("password").value;
    const confirmPasswordError = document.getElementById("confirmPasswordError");
    if (password !== confirmPassword) {
        confirmPasswordError.textContent = "Şifreler uyuşmuyor.";
    } else {
        confirmPasswordError.textContent = "";
    }
}

function validateEmail() {
    const email = document.getElementById("email").value;
    const emailError = document.getElementById("emailError");
    const emailPattern = /^[a-zA-Z0-9._%+-]+@(gmail\.com|hotmail\.com|yahoo\.com|outlook\.com|yandex\.com)$/;
    if (!emailPattern.test(email)) {
        emailError.textContent = "Geçerli bir e-posta adresi giriniz.";
    } else {
        emailError.textContent = "";
    }
}

document.getElementById("registerForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Formun otomatik gönderimini engelle

    // Form verilerini kontrol et
    validateUsername();
    validatePassword();
    validateConfirmPassword();
    validateEmail();

    const errorMessage = document.getElementById("errorMessage");
    const successMessage = document.getElementById("successMessage");

    // Eğer hatalar varsa form gönderilmez
    if (
        document.querySelectorAll(".error-message:empty").length !==
        document.querySelectorAll(".error-message").length
    ) {
        errorMessage.textContent = "Lütfen tüm hataları düzeltin.";
    } else {
        // Eğer hatalar yoksa formu gönder ve kullanıcıyı yönlendir
        const formData = new FormData(document.getElementById("registerForm"));

        fetch("sql/register.php", {
            method: "POST",
            body: formData,
        })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                successMessage.textContent = "Kayıt başarılı! Yönlendiriliyorsunuz...";
                setTimeout(() => {
                    window.location.href = "index.html";
                }, 1500);
            } else {
                // Hata mesajlarını ilgili input alanlarının altına ekleyelim
                if (data.errors) {
                    for (const [key, value] of Object.entries(data.errors)) {
                        document.getElementById(`${key}Error`).textContent = value;
                    }
                }
                errorMessage.textContent = "Kayıt sırasında bir hata oluştu.";
            }
        })
        .catch((error) => {
            errorMessage.textContent = "Bir hata oluştu. Lütfen tekrar deneyin.";
        });
    }
});
