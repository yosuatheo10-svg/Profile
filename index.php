<?php
session_start();
require 'data/data.php';

// Cek apakah user sudah login atau belum
$isLoggedIn = isset($_SESSION['login']) && $_SESSION['login'] === true;
$currentUser = $isLoggedIn ? $_SESSION['email'] : "Tamu";
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profil Pengguna</title>
  <link rel="stylesheet" href="css/profile.css">
</head>
<body>

<div class="header">
  <div class="header-top">
    <div class="user-info">
        <img id="headerAvatar" class="avatar" src="https://via.placeholder.com/60" onerror="this.src='https://cdn-icons-png.flaticon.com/512/149/149071.png'" alt="Avatar" />
        <h3 id="headerUsername">
            <?= $isLoggedIn ? $currentUser : 'Player (Belum Login)' ?>
        </h3>
    </div>
    
    <div>
        <?php if($isLoggedIn): ?>
            <a href="data/auth.php?logout=true" class="btn-logout">Logout</a>
        <?php else: ?>
            <button class="btn-login" onclick="openAuthModal()">Login / Daftar</button>
        <?php endif; ?>
    </div>
  </div>

  <div class="tabs">
    <?php 
      $first = true;
      foreach($tabs as $key => $label): 
        $activeClass = $first ? 'active' : ''; 
        $first = false; 
    ?>
      <div class="tab <?= $activeClass ?>" data-tab="<?= $key ?>"><?= $label ?></div>
    <?php endforeach; ?>
  </div>
</div>

<div class="content active" id="info" style="display:flex;">
  <div class="profile-center">
    <label for="photo">
      <img id="preview" src="https://via.placeholder.com/100" onerror="this.src='https://cdn-icons-png.flaticon.com/512/149/149071.png'" alt="Preview" />
      <div class="camera-icon">📷</div>
    </label>
    <input type="file" id="photo" accept="image/*" />
  </div>

  <h2>Informasi Akun</h2>

  <div class="form-group">
    <label>Email Pengguna</label>
    <input type="text" id="username" value="<?= $currentUser ?>" disabled style="background-color: #eee;" />
  </div>

  <div class="form-group">
    <label>Provinsi</label>
    <select id="provinsi">
      <option>Pilih Provinsi</option>
      <?php foreach($daftar_provinsi as $prov): ?>
        <option value="<?= $prov ?>"><?= $prov ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <button class="save-btn" id="saveBtn">Simpan Perubahan</button>
</div>

<div class="content" id="notif">
  <h2>Riwayat Notifikasi</h2>
  <div class="box" id="notifEmpty">Tidak ada riwayat Notifikasi</div>
  <div id="notifListContainer" style="display:none; width: 100%;"></div>
</div>

<div class="content" id="log">
  <h2>Riwayat Log Pembelian</h2>
  <div style="margin-bottom: 20px;">
    <button class="action-btn" id="simulasiBeli">Simulasi Beli Barang</button>
  </div>
  <div class="box" id="logListContainer" style="display:block; text-align:left;">
    <p id="emptyLogText" style="text-align:center;">Tidak ada riwayat Log Pembelian</p>
    <ul id="logList" style="list-style:none; padding:0; display:none;"></ul>
  </div>
</div>

<div class="content" id="barang">
  <h2>Riwayat Barang Jualan</h2>
  <div style="margin-bottom: 20px;">
    <button class="action-btn" id="tambahBarang">Tambah Barang Baru</button>
  </div>
  <div class="box" id="barangListContainer" style="display:block; text-align:left;">
    <p id="emptyBarangText" style="text-align:center;">Tidak ada riwayat Barang Jualan</p>
    <ul id="barangList" style="list-style:none; padding:0; display:none;"></ul>
  </div>
</div>

<footer></footer>

<div id="authModal" class="modal">
  <div class="modal-content">
    
    <span class="close-btn" onclick="closeAuthModal()">&times;</span>

    <div class="auth-toggle">
        <span id="tabLogin" class="active" onclick="switchAuth('login')">MASUK</span> | 
        <span id="tabRegister" onclick="switchAuth('register')">DAFTAR</span>
    </div>

    <form id="formLogin" action="data/auth.php" method="POST">
        <h2 style="text-align:center;">Silakan Masuk</h2>
        <input type="hidden" name="action" value="login">
        
        <label>Email</label>
        <input type="email" name="email" class="input-line" placeholder="Masukkan email..." required>
        
        <label>Password</label>
        <input type="password" name="password" class="input-line" placeholder="Masukkan password..." required>
        
        <button type="submit" class="modal-submit-btn">Masuk Sekarang</button>
    </form>

    <form id="formRegister" action="data/auth.php" method="POST" style="display:none;">
        <h2 style="text-align:center;">Buat Akun Baru</h2>
        <input type="hidden" name="action" value="register">
        
        <label>Email Baru</label>
        <input type="email" name="email" class="input-line" placeholder="Email untuk mendaftar..." required>
        
        <label>Password Baru</label>
        <input type="password" name="password" class="input-line" placeholder="Buat password..." required>
        
        <button type="submit" class="modal-submit-btn" style="background-color: #28a745;">Daftar Sekarang</button>
    </form>

  </div>
</div>

<script>
  // --- 1. ELEMENT SELECTORS ---
  const preview = document.getElementById('preview');
  const headerAvatar = document.getElementById('headerAvatar');
  const provinsiSelect = document.getElementById('provinsi');
  const saveBtn = document.getElementById('saveBtn');
  const authModal = document.getElementById('authModal');

  // --- 2. FUNGSI MODAL (Dibuat Global agar onclick pasti jalan) ---
  window.openAuthModal = function() {
    if(authModal) {
        authModal.style.display = 'flex'; // Menggunakan flex agar ke tengah
    } else {
        console.error("Error: Modal tidak ditemukan (Check ID HTML)");
    }
  }

  window.closeAuthModal = function() {
    if(authModal) authModal.style.display = 'none';
  }

  // Tutup modal jika user klik di area gelap (luar kotak putih)
  window.onclick = function(event) {
    if (event.target == authModal) {
        authModal.style.display = "none";
    }
  }

  // --- 3. LOGIKA POPUP OTOMATIS (Jika belum login) ---
  // Variabel PHP diterjemahkan ke JS
  const isUserLoggedIn = <?= $isLoggedIn ? 'true' : 'false' ?>;
  
  // Opsional: Buka popup otomatis jika belum login
  // if (!isUserLoggedIn) { setTimeout(openAuthModal, 500); }

  // --- 4. FUNGSI GANTI TAB LOGIN <-> DAFTAR ---
  window.switchAuth = function(mode) {
      const formLogin = document.getElementById('formLogin');
      const formRegister = document.getElementById('formRegister');
      const tabLogin = document.getElementById('tabLogin');
      const tabRegister = document.getElementById('tabRegister');

      if (mode === 'login') {
          formLogin.style.display = 'block';
          formRegister.style.display = 'none';
          tabLogin.classList.add('active');
          tabRegister.classList.remove('active');
      } else {
          formLogin.style.display = 'none';
          formRegister.style.display = 'block';
          tabLogin.classList.remove('active');
          tabRegister.classList.add('active');
      }
  }

  // --- 5. LOGIKA PREVIEW FOTO & DATA LAINNYA ---
  window.addEventListener('load', () => {
    const savedProvinsi = localStorage.getItem('provinsi');
    const savedPhoto = localStorage.getItem('photo');
    if (savedProvinsi && provinsiSelect) provinsiSelect.value = savedProvinsi;
    if (savedPhoto) {
      if(preview) preview.src = savedPhoto;
      if(headerAvatar) headerAvatar.src = savedPhoto;
    }
  });

  if(document.getElementById('photo')) {
      document.getElementById('photo').addEventListener('change', e => {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = () => {
          if(preview) preview.src = reader.result;
          if(headerAvatar) headerAvatar.src = reader.result;
          localStorage.setItem('photo', reader.result); 
        };
        reader.readAsDataURL(file);
      });
  }

  if(saveBtn) {
      saveBtn.addEventListener('click', () => {
        const newProvinsi = provinsiSelect.value;
        if (newProvinsi === 'Pilih Provinsi') {
          alert('Silakan pilih provinsi'); return;
        }
        if (confirm("Simpan perubahan profil?")) {
          localStorage.setItem('provinsi', newProvinsi);
          alert('Profil berhasil diperbarui!');
        }
      });
  }

  // --- 6. TAB NAVIGASI ---
  const tabs = document.querySelectorAll('.tab');
  const contents = document.querySelectorAll('.content');
  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      contents.forEach(c => c.style.display = 'none');
      const targetId = tab.dataset.tab;
      const targetContent = document.getElementById(targetId);
      if(targetContent) targetContent.style.display = 'flex';
    });
  });
</script>

</body>
</html>