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
    <div class="avatar"></div>
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
  const preview = document.getElementById('preview');
  const usernameInput = document.getElementById('username');
  const provinsiSelect = document.getElementById('provinsi');
  const headerUsername = document.getElementById('headerUsername');

  document.getElementById('photo').addEventListener('change', e => {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = () => {
      preview.src = reader.result;
      localStorage.setItem('photo', reader.result);
    };
    reader.readAsDataURL(file);
  });

  window.addEventListener('load', () => {
    const savedUsername = localStorage.getItem('username');
    const savedProvinsi = localStorage.getItem('provinsi');
    const savedPhoto = localStorage.getItem('photo');

    if (savedUsername) {
      usernameInput.value = savedUsername;
      headerUsername.textContent = savedUsername;
    }
    if (savedProvinsi) provinsiSelect.value = savedProvinsi;
    if (savedPhoto) preview.src = savedPhoto;
  });

  usernameInput.addEventListener('input', () => {
    localStorage.setItem('username', usernameInput.value);
    headerUsername.textContent = usernameInput.value || ' ';
  });

  provinsiSelect.addEventListener('change', () => {
    localStorage.setItem('provinsi', provinsiSelect.value);
  });

  document.getElementById('saveBtn').addEventListener('click', () => {
    if (!usernameInput.value.trim()) {
      alert('Username tidak boleh kosong');
      return;
    }
    if (provinsiSelect.value === 'Pilih Provinsi') {
      alert('Silakan pilih provinsi');
      return;
    }
    alert('Perubahan berhasil disimpan');
  });

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
// --- LOGIKA NOTIFIKASI SEMENTARA (FIXED) ---

  const simulasiBeliBtn = document.getElementById('simulasiBeli');
  const tambahBarangBtn = document.getElementById('tambahBarang');
  
  // Ambil elemen berdasarkan ID baru
  const notifEmpty = document.getElementById('notifEmpty');
  const notifListContainer = document.getElementById('notifListContainer');
  
  const logList = document.getElementById('logList');
  const barangList = document.getElementById('barangList');

  // Helper: Mendapatkan Jam Sekarang
  function getTime() {
    const now = new Date();
    return now.toLocaleTimeString('id-ID'); // Format jam Indonesia
  }

  // FUNGSI UTAMA: Menambah Notifikasi
  function addNotification(message) {
    // 1. Sembunyikan kotak pesan "Tidak ada riwayat"
    if (notifEmpty) {
        notifEmpty.style.display = 'none';
    }

    // 2. Munculkan container list notifikasi
    if (notifListContainer) {
        notifListContainer.style.display = 'block';
        
        // 3. Buat elemen notifikasi baru
        const div = document.createElement('div');
        div.className = 'notif-item'; // Pastikan class ini ada di CSS (yang warna putih)
        div.innerHTML = `
          <div>${message}</div>
          <div class="timestamp">${getTime()}</div>
        `;

        // 4. Masukkan ke paling atas (prepend)
        notifListContainer.prepend(div);
    }
  }

  // FUNGSI: Simulasi Beli Barang (Log Pembelian)
  if (simulasiBeliBtn) {
      simulasiBeliBtn.addEventListener('click', () => {
        const items = ['Martabak Manis', 'Terang Bulan Keju', 'Martabak Telur', 'Soda Gembira'];
        const randomItem = items[Math.floor(Math.random() * items.length)];
        
        // UI Update di Tab Log
        document.getElementById('emptyLogText').style.display = 'none';
        logList.style.display = 'block';
        
        const li = document.createElement('li');
        li.className = 'list-item';
        li.innerHTML = `<span>Membeli <b>${randomItem}</b></span> <span class="timestamp">${getTime()}</span>`;
        logList.prepend(li);

        // TRIGGER NOTIFIKASI
        addNotification(`Pembelian berhasil: Kamu baru saja membeli <b>${randomItem}</b>.`);
        alert('Barang berhasil dibeli! Cek tab Notifikasi.');
      });
  }

  // FUNGSI: Simulasi Tambah Barang (Barang Jualan)
  if (tambahBarangBtn) {
      tambahBarangBtn.addEventListener('click', () => {
        const barangBaru = 'Menu Spesial ' + Math.floor(Math.random() * 100);
        
        // UI Update di Tab Barang
        document.getElementById('emptyBarangText').style.display = 'none';
        barangList.style.display = 'block';

        const li = document.createElement('li');
        li.className = 'list-item';
        li.innerHTML = `<span>Menambahkan <b>${barangBaru}</b></span> <span class="timestamp">${getTime()}</span>`;
        barangList.prepend(li);

        // TRIGGER NOTIFIKASI
        addNotification(`Update Stok: Kamu berhasil menambahkan <b>${barangBaru}</b> ke etalase.`);
        alert('Barang berhasil ditambah! Cek tab Notifikasi.');
      });
  }
  
</script>

</body>
</html>