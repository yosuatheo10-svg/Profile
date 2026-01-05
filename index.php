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
  <div class="box">Tidak ada riwayat Notifikasi</div>
</div>

<div class="content" id="log">
  <h2>Riwayat Log Pembelian</h2>
  <div class="box">Tidak ada riwayat Log Pembelian</div>
</div>

<div class="content" id="barang">
  <h2>Riwayat Barang Jualan</h2>
  <div class="box">Tidak ada riwayat Barang Jualan</div>
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
</script>

</body>
</html>