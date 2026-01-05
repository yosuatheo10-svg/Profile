<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profil Pengguna</title>

  <!-- CSS TERPISAH -->
  <link rel="stylesheet" href="profile.css">
</head>
<body>

<div class="header">
  <div class="header-top">
  <img id="headerAvatar" class="avatar" src="https://via.placeholder.com/60" style="object-fit:cover;" />
  <h3 id="headerUsername">Player49677961</h3>
</div>

  <div class="tabs">
    <div class="tab active" data-tab="info">Informasi</div>
    <div class="tab" data-tab="notif">Notifikasi</div>
    <div class="tab" data-tab="log">Log Pembelian</div>
    <div class="tab" data-tab="barang">Barang Jualan</div>
  </div>
</div>

<div class="content" id="info" style="display:flex;">
  <div class="profile-center">
    <label for="photo">
      <img id="preview" src="https://via.placeholder.com/100" />
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
      <option>Aceh</option>
      <option>Sumatera Utara</option>
      <option>Sumatera Barat</option>
      <option>Riau</option>
      <option>Kepulauan Riau</option>
      <option>Jambi</option>
      <option>Sumatera Selatan</option>
      <option>Bangka Belitung</option>
      <option>Bengkulu</option>
      <option>Lampung</option>
      <option>DKI Jakarta</option>
      <option>Jawa Barat</option>
      <option>Jawa Tengah</option>
      <option>DI Yogyakarta</option>
      <option>Jawa Timur</option>
      <option>Banten</option>
      <option>Bali</option>
      <option>Nusa Tenggara Barat</option>
      <option>Nusa Tenggara Timur</option>
      <option>Kalimantan Barat</option>
      <option>Kalimantan Tengah</option>
      <option>Kalimantan Selatan</option>
      <option>Kalimantan Timur</option>
      <option>Kalimantan Utara</option>
      <option>Sulawesi Utara</option>
      <option>Sulawesi Tengah</option>
      <option>Sulawesi Selatan</option>
      <option>Sulawesi Tenggara</option>
      <option>Gorontalo</option>
      <option>Sulawesi Barat</option>
      <option>Maluku</option>
      <option>Maluku Utara</option>
      <option>Papua</option>
      <option>Papua Barat</option>
      <option>Papua Tengah</option>
      <option>Papua Pegunungan</option>
      <option>Papua Selatan</option>
      <option>Papua Barat Daya</option>
    </select>
  </div>

  <button class="save-btn" id="saveBtn">Simpan Perubahan</button>
</div>

<div class="content" id="notif">
  <h2>Riwayat Notifikasi</h2>
  
  <div class="box" id="notifEmpty">
    Tidak ada riwayat Notifikasi
  </div>

  <div id="notifListContainer" style="display:none; width: 100%;">
    </div>
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
  const headerAvatar = document.getElementById('headerAvatar'); // Element baru di header
  const usernameInput = document.getElementById('username');
  const provinsiSelect = document.getElementById('provinsi');
  const headerUsername = document.getElementById('headerUsername');
  const saveBtn = document.getElementById('saveBtn');

  // Variabel penampung sementara (belum disimpan)
  let tempPhotoData = null; 

  // 1. FUNGSI PREVIEW FOTO (Hanya merubah tampilan tengah)
  document.getElementById('photo').addEventListener('change', e => {
    const file = e.target.files[0];
    if (!file) return;
    
    const reader = new FileReader();
    reader.onload = () => {
      // Ubah preview tengah saja
      preview.src = reader.result;
      // Simpan data ke variabel sementara
      tempPhotoData = reader.result; 
    };
    reader.readAsDataURL(file);
  });

  // 2. LOAD DATA SAAT WEBSITE DIBUKA
  window.addEventListener('load', () => {
    const savedUsername = localStorage.getItem('username');
    const savedProvinsi = localStorage.getItem('provinsi');
    const savedPhoto = localStorage.getItem('photo');

    // Set Username
    if (savedUsername) {
      usernameInput.value = savedUsername;
      headerUsername.textContent = savedUsername;
    }
    
    // Set Provinsi
    if (savedProvinsi) {
      provinsiSelect.value = savedProvinsi;
    }

    // Set Foto (Header & Preview)
    if (savedPhoto) {
      preview.src = savedPhoto;
      headerAvatar.src = savedPhoto;
    }
  });

  // 3. TOMBOL SIMPAN (Baru simpan ke storage & update Header)
  saveBtn.addEventListener('click', () => {
    // Validasi
    const newUsername = usernameInput.value.trim();
    const newProvinsi = provinsiSelect.value;

    if (!newUsername) {
      alert('Username tidak boleh kosong');
      return;
    }
    if (newProvinsi === 'Pilih Provinsi') {
      alert('Silakan pilih provinsi');
      return;
    }

    // --- PROSES MENYIMPAN (Commit Changes) ---
    
    // a. Simpan Username & Provinsi
    localStorage.setItem('username', newUsername);
    localStorage.setItem('provinsi', newProvinsi);

    // b. Simpan Foto (Jika ada yang baru diupload)
    if (tempPhotoData) {
      localStorage.setItem('photo', tempPhotoData);
      // Update tampilan header avatar sekarang
      headerAvatar.src = tempPhotoData;
    } else {
      // Jika tidak upload baru, pastikan header sync dengan yang lama (opsional safety)
      const existingPhoto = localStorage.getItem('photo');
      if(existingPhoto) headerAvatar.src = existingPhoto;
    }

    // c. Update Teks Header Username
    headerUsername.textContent = newUsername;

    alert('Perubahan berhasil disimpan dan Profil diperbarui!');
  });
  
  // 4. INTERAKSI TABS (Tetap sama)
  const tabs = document.querySelectorAll('.tab');
  const contents = document.querySelectorAll('.content');

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      contents.forEach(c => c.style.display = 'none');
      document.getElementById(tab.dataset.tab).style.display = 'flex';
    });
  });

  // --- LOGIKA NOTIFIKASI SEMENTARA (Kode Notifikasi tetap di bawah sini) ---
  // (Copy paste kode notifikasi yang sudah diperbaiki sebelumnya di sini)
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