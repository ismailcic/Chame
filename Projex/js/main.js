// Gönderi yükleme fonksiyonu
function loadPosts() {
  const postsContainer = document.querySelector('.posts');
  // Burada AJAX veya Fetch kullanarak gönderileri sunucudan çekebilirsiniz.
  // Örnek gönderi ekleyelim
  const examplePost = `
      <div class="post">
          <h3>Kullanıcı Adı: <span>Örnek Kullanıcı</span></h3>
          <p>Bu bir örnek gönderidir. Yeni bir sosyal medya platformuna hoş geldiniz!</p>
          <span>Reklam alanı</span>
      </div>
  `;
  postsContainer.innerHTML += examplePost; // Örnek gönderiyi ekle
}

// Mesaj gönderme fonksiyonu
function sendMessage() {
  const messageInput = document.getElementById('messageInput');
  const messageList = document.getElementById('messageList');
  const messageText = messageInput.value;
  
  if (messageText.trim() !== '') {
      const newMessage = document.createElement('div');
      newMessage.className = 'message';
      newMessage.innerText = messageText;
      messageList.appendChild(newMessage);
      messageInput.value = ''; // Mesaj kutusunu temizle
  }
}

// Arkadaşlık isteğini yönetme fonksiyonu
function manageFriendRequests() {
  const friendRequestList = document.getElementById('friendRequestList');
  const exampleRequest = `
      <div class="friend-request">
          <span>Örnek Kullanıcı'dan arkadaşlık isteği</span>
          <button onclick="acceptFriendRequest(this)">Kabul Et</button>
          <button onclick="declineFriendRequest(this)">Reddet</button>
      </div>
  `;
  friendRequestList.innerHTML += exampleRequest; // Örnek arkadaşlık isteğini ekle
}

// Arkadaşlık isteğini kabul etme fonksiyonu
function acceptFriendRequest(button) {
  const requestDiv = button.parentElement;
  requestDiv.innerHTML = 'Arkadaşlık isteği kabul edildi!';
}

// Arkadaşlık isteğini reddetme fonksiyonu
function declineFriendRequest(button) {
  const requestDiv = button.parentElement;
  requestDiv.innerHTML = 'Arkadaşlık isteği reddedildi!';
}

// Çıkış yapma fonksiyonu
function logout() {
  window.location.href = 'index.html';
}

// Sayfa yüklendiğinde fonksiyonları başlatma
document.addEventListener('DOMContentLoaded', function() {
  loadPosts();
  manageFriendRequests();

  // Mesaj gönderme olayını dinle
  document.getElementById('sendMessageButton').addEventListener('click', sendMessage);
});
