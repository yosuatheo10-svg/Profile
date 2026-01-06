<?php
// --- NYALAKAN LAPORAN ERROR ---
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Path ini SUDAH BENAR sesuai struktur folder (folder data -> file data.php)
require 'data/data.php'; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profil Pengguna (PHP Separated Data)</title>
  
  <link rel="stylesheet" href="css/profile.css">
  
</head>
<body>

<div class="header">
  <div class="header-top">
    <img id="headerAvatar" class="avatar" src="https://via.placeholder.com/60" style="object-fit:cover;" alt="Avatar" />
    <h3 id="headerUsername">Player49677961</h3>
  </div>

  <div class="tabs">
    <?php 
      // Render Tabs menggunakan data dari $tabs (di data.php)
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
      <img id="preview" src="https://via.placeholder.com/100" alt="Preview" />
      <div class="camera-icon">📷</div>
    </label>
    <input type="file" id="photo" accept="image/*" />
  </div>

  <h2>Informasi Akun</h2>

  <div class="form-group">
    <label>Username</label>
    <input type="text" id="username" placeholder="Masukkan username" />
  </div>

  <div class="form-group">
    <label>Provinsi</label>
    <select id="provinsi">
      <option>Pilih Provinsi</option>
      <?php 
        // Render Provinsi menggunakan data dari $daftar_provinsi (di data.php)
        foreach($daftar_provinsi as $prov): 
      ?>
        <option value="<?= $prov ?>"><?= $prov ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <button class="save-btn" id="saveBtn">Simpan Perubahan</button>
</div>

<div class="content" id="notif">
  <h2>Riwayat Notifikasi</h2>
  <div class="box" id="notifEmpty">
    Tidak ada riwayat Notifikasi
  </div>
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

<script>
  // --- ELEMENT SELECTORS ---
  const preview = document.getElementById('preview');
  const headerAvatar = document.getElementById('headerAvatar');
  const usernameInput = document.getElementById('username');
  const provinsiSelect = document.getElementById('provinsi');
  const headerUsername = document.getElementById('headerUsername');
  const saveBtn = document.getElementById('saveBtn');

  let tempPhotoData = null; 

  // 1. FUNGSI PREVIEW FOTO
  document.getElementById('photo').addEventListener('change', e => {
    const file = e.target.files[0];
    if (!file) return;
    
    const reader = new FileReader();
    reader.onload = () => {
      preview.src = reader.result;
      tempPhotoData = reader.result; 
    };
    reader.readAsDataURL(file);
  });

  // 2. LOAD DATA
  window.addEventListener('load', () => {
    const savedUsername = localStorage.getItem('username');
    const savedProvinsi = localStorage.getItem('provinsi');
    const savedPhoto = localStorage.getItem('photo');

    if (savedUsername) {
      usernameInput.value = savedUsername;
      headerUsername.textContent = savedUsername;
    }
    
    if (savedProvinsi) {
      provinsiSelect.value = savedProvinsi;
    }

    if (savedPhoto) {
      preview.src = savedPhoto;
      headerAvatar.src = savedPhoto;
    }
  });

  // 3. TOMBOL SIMPAN
  saveBtn.addEventListener('click', () => {
    const newUsername = usernameInput.value.trim();
    const newProvinsi = provinsiSelect.value;

    // Validasi input
    if (!newUsername) {
      alert('Username tidak boleh kosong');
      return;
    }
    if (newProvinsi === 'Pilih Provinsi') {
      alert('Silakan pilih provinsi');
      return;
    }

    // Konfirmasi dialog
    const isConfirmed = confirm("Apakah Anda yakin ingin menyimpan perubahan profil ini?");

    if (isConfirmed) {
      localStorage.setItem('username', newUsername);
      localStorage.setItem('provinsi', newProvinsi);

      if (tempPhotoData) {
        localStorage.setItem('photo', tempPhotoData);
        headerAvatar.src = tempPhotoData;
      } else {
        const existingPhoto = localStorage.getItem('photo');
        if(existingPhoto) headerAvatar.src = existingPhoto;
      }

      headerUsername.textContent = newUsername;
      alert('Perubahan berhasil disimpan dan Profil diperbarui!');
      
    } else {
      console.log("Perubahan dibatalkan oleh pengguna.");
    }
  });
  
  // 4. INTERAKSI TABS
  const tabs = document.querySelectorAll('.tab');
  const contents = document.querySelectorAll('.content');

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      contents.forEach(c => c.style.display = 'none');
      
      const targetContent = document.getElementById(tab.dataset.tab);
      targetContent.style.display = 'flex';
    });
  });

  // 5. LOGIKA SIMULASI & NOTIFIKASI
  const simulasiBeliBtn = document.getElementById('simulasiBeli');
  const tambahBarangBtn = document.getElementById('tambahBarang');
  const notifEmpty = document.getElementById('notifEmpty');
  const notifListContainer = document.getElementById('notifListContainer');
  const logList = document.getElementById('logList');
  const barangList = document.getElementById('barangList');

  function getTime() {
    const now = new Date();
    return now.toLocaleTimeString('id-ID'); 
  }

  function addNotification(message) {
    if (notifEmpty) notifEmpty.style.display = 'none';
    if (notifListContainer) {
        notifListContainer.style.display = 'block';
        const div = document.createElement('div');
        div.className = 'notif-item'; 
        div.innerHTML = `<div>${message}</div><div class="timestamp">${getTime()}</div>`;
        notifListContainer.prepend(div);
    }
  }

  if (simulasiBeliBtn) {
      simulasiBeliBtn.addEventListener('click', () => {
        const items = ['Martabak Manis', 'Terang Bulan Keju', 'Martabak Telur', 'Soda Gembira'];
        const randomItem = items[Math.floor(Math.random() * items.length)];
        
        document.getElementById('emptyLogText').style.display = 'none';
        logList.style.display = 'block';
        const li = document.createElement('li');
        li.className = 'list-item';
        li.innerHTML = `<span>Membeli <b>${randomItem}</b></span> <span class="timestamp">${getTime()}</span>`;
        logList.prepend(li);
        addNotification(`Pembelian berhasil: Kamu baru saja membeli <b>${randomItem}</b>.`);
        alert('Barang berhasil dibeli! Cek tab Notifikasi.');
      });
  }

  if (tambahBarangBtn) {
      tambahBarangBtn.addEventListener('click', () => {
        const barangBaru = 'Menu Spesial ' + Math.floor(Math.random() * 100);
        document.getElementById('emptyBarangText').style.display = 'none';
        barangList.style.display = 'block';
        const li = document.createElement('li');
        li.className = 'list-item';
        li.innerHTML = `<span>Menambahkan <b>${barangBaru}</b></span> <span class="timestamp">${getTime()}</span>`;
        barangList.prepend(li);
        addNotification(`Update Stok: Kamu berhasil menambahkan <b>${barangBaru}</b> ke etalase.`);
        alert('Barang berhasil ditambah! Cek tab Notifikasi.');
      });
  }
</script>

</body>
</html>