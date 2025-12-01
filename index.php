<?php
session_start();

// Jika user sudah login, langsung redirect ke dashboard
if (!empty($_SESSION['user_logged_in'])) {
    header("Location: user/index_user.php");
    exit;
}

include('config/koneksi.php');
?> 
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kos Pisang Ijo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; background-color: #f9fafb; }
    .navbar { box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
    .navbar-brand img { height: 40px; margin-right: 10px; }
    header { background: linear-gradient(135deg, #00b894, #00997a); color: white; padding: 60px 0; text-align: center; }
    header h1 { font-weight: 600; font-size: 42px; }
    .filter-box { background: #fff; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 20px; margin-top: -40px; position: relative; z-index: 5; }
    .kamar-card { border: none; border-radius: 12px; box-shadow: 0 3px 10px rgba(0,0,0,0.08); transition: 0.3s; overflow: hidden; }
    .kamar-card img { height: 200px; object-fit: cover; width: 100%; }
    .map-container { border-radius: 10px; overflow: hidden; height: 100%; }
    .facility-box { background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 3px 10px rgba(0,0,0,0.08); transition: 0.3s; }
    .facility-box:hover { transform: translateY(-5px); box-shadow: 0 8px 18px rgba(0,0,0,0.12); }
    .whatsapp-btn { background: #25d366; border: none; padding: 6px 12px; color: white; border-radius: 6px; text-decoration: none; font-size: 14px; }
    footer { background: #00997a; color: white; padding: 40px 20px 20px 20px; }
    footer h6 { font-weight: 600; margin-bottom: 15px; }
    footer a { color: white; text-decoration: none; }
    .carousel-control-prev-icon,
    .carousel-control-next-icon { background-color: rgba(0,0,0,0.5); border-radius: 50%; }
    .pagination-circle .page-item .page-link { border-radius: 50%; width: 36px; height: 36px; line-height: 34px; text-align: center; margin: 0 3px; }
    .pagination-circle .page-item.active .page-link { background-color: #ff7b6b; border-color: #ff7b6b; color: white; }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg bg-white">
  <div class="container d-flex align-items-center">
    <a class="navbar-brand d-flex align-items-center fw-bold text-success" href="index.php">
      <img src="assets/logo.png" alt="Logo">
      <span>Kos Pisang Ijo</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link active" href="#beranda">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="#fasilitas">Fasilitas</a></li>
        <li class="nav-item"><a class="nav-link" href="#kamar">Kamar</a></li>
        <li class="nav-item"><a class="nav-link" href="pemilik.php">Pemilik Properti</a></li>
        <li class="nav-item">
          <a class="btn btn-success text-white px-3 py-1 rounded ms-2" href="login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-outline-success px-3 py-1 rounded ms-2" href="registrasi.php">Register</a>
        </li>
      </ul>
    </div>
</di>
</nav>

<!-- HEADER -->
<header id="beranda">
  <h1>Hunian Nyaman & Aman</h1>
  <p>Tempat tinggal ideal untuk putri dengan fasilitas lengkap di Jakarta Selatan</p>
</header>

<!-- FILTER -->
<div class="container filter-box mt-4">
  <form class="row g-3 align-items-center" method="GET" action="">
    <div class="col-md-4">
      <label class="form-label">Lokasi</label>
      <input type="text" name="lokasi" class="form-control" placeholder="Masukkan lokasi..." value="<?= isset($_GET['lokasi']) ? $_GET['lokasi'] : '' ?>">
    </div>
    <div class="col-md-4">
      <label class="form-label">Budget per Bulan</label>
      <select name="budget" class="form-select">
        <option value="">Semua Budget</option>
        <option value="1000000" <?= (isset($_GET['budget']) && $_GET['budget']=='1000000')?'selected':'' ?>>Rp 1-2 Juta</option>
        <option value="2000000" <?= (isset($_GET['budget']) && $_GET['budget']=='2000000')?'selected':'' ?>>Rp 2-3 Juta</option>
        <option value="3000000" <?= (isset($_GET['budget']) && $_GET['budget']=='3000000')?'selected':'' ?>>Rp 3 Juta+</option>
      </select>
    </div>
    <div class="col-md-4 d-grid">
      <label class="form-label text-white">.</label>
      <button type="submit" class="btn btn-success">Cari Hunian</button>
    </div>
  </form>
</div>

<!-- KAMAR LIST (CAROUSEL) -->
<div class="container my-5" id="kamar">
  <div class="row">
    <div class="col-lg-8">
      <h3 class="mb-4 text-success fw-semibold">Kamar Tersedia</h3>

      <div id="kamarCarousel" class="carousel slide" data-bs-ride="false">
        <div class="carousel-inner">
        <?php
        $lokasi = isset($_GET['lokasi']) ? mysqli_real_escape_string($koneksi, $_GET['lokasi']) : '';
        $budget = isset($_GET['budget']) ? (int)$_GET['budget'] : 0;

        $query = "SELECT * FROM kamar WHERE status IN ('Tersedia','Kosong')";
        if (!empty($lokasi)) $query .= " AND lokasi LIKE '%$lokasi%'";
        if ($budget == 1000000) $query .= " AND harga BETWEEN 1000000 AND 2000000";
        if ($budget == 2000000) $query .= " AND harga BETWEEN 2000000 AND 3000000";
        if ($budget == 3000000) $query .= " AND harga >= 3000000";

        $result = mysqli_query($koneksi, $query);

        $kamarChunks = [];
        $temp = [];
        $perSlide = 2;
        if ($result && mysqli_num_rows($result) > 0) {
          $count = 0;
          while ($row = mysqli_fetch_assoc($result)) {
            $fotoPath = "admin/uploads/" . $row['foto'];
            if (!file_exists($fotoPath) || empty($row['foto'])) $fotoPath = "admin/uploads/noimage.png";

            $nomorWA = "6281289812695";
            $pesan = urlencode("Halo, saya ingin menanyakan kamar {$row['nama_kamar']} di {$row['lokasi']} - Kos Pisang Ijo.");

            $temp[] = "
               <div class='col-md-6'>
                <div class='card kamar-card'>
                  <img src='{$fotoPath}' alt='{$row['nama_kamar']}'>
                  <div class='card-body'>
                    <h5 class='fw-semibold'>{$row['nama_kamar']}</h5>
                    <p class='mb-1 text-muted'>Lokasi: {$row['lokasi']}</p>
                    <p class='mb-1 text-muted'>Status: {$row['status']}</p>
                    <p class='fw-bold text-success'>Rp " . number_format($row['harga'],0,',','.') . " /bulan</p>
                    <p class='small mb-1'><b>Fasilitas Kamar:</b> {$row['fasilitas']}</p>
                    <p class='small'>{$row['deskripsi']}</p>
                    <a href='https://wa.me/{$nomorWA}?text={$pesan}' target='_blank' class='whatsapp-btn'>Hubungi via WhatsApp</a>
                  </div>
                </div>
              </div>";
            $count++;
            if ($count % $perSlide == 0) {
              $kamarChunks[] = $temp;
              $temp = [];
            }
          }
          if (!empty($temp)) $kamarChunks[] = $temp;

          $active = "active";
          foreach ($kamarChunks as $chunk) {
            echo "<div class='carousel-item {$active}'><div class='row'>";
            foreach ($chunk as $item) echo $item;
            echo "</div></div>";
            $active = "";
          }
        } else {
          echo "<p class='text-muted'>Kamar tidak ditemukan.</p>";
        }
        ?>
        </div>

        <div class="d-flex justify-content-center mt-3">
          <nav>
            <ul class="pagination pagination-circle">
            <?php
            $totalPages = count($kamarChunks);
            for ($i=1; $i <= $totalPages; $i++) {
              $activeClass = ($i==1)?'active':'';
              echo "<li class='page-item {$activeClass}'><a class='page-link' href='#' data-bs-slide-to='".($i-1)."' data-bs-target='#kamarCarousel'>{$i}</a></li>";
            }
            ?>
            </ul>
          </nav>
        </div>

      </div>
    </div>

    <div class="col-lg-4">
      <h5 class="text-success fw-semibold mb-3">Lokasi Kos</h5>
      <div class="map-container" style="height:100%;">
        <iframe src="https://www.google.com/maps?q=Jakarta+Selatan,+Indonesia&output=embed" width="100%" height="100%" style="border:0;"></iframe>
      </div>
    </div>
  </div>
</div>

<!-- FASILITAS -->
<div class="container my-5" id="fasilitas">
  <h3 class="text-center text-success fw-semibold mb-4">Fasilitas Kos</h3>
  <div class="row text-center g-3 justify-content-center">
    <div class="col-6 col-md-2"><div class="facility-box">🌐 WiFi</div></div>
    <div class="col-6 col-md-2"><div class="facility-box">🧹 Kebersihan Harian</div></div>
    <div class="col-6 col-md-2"><div class="facility-box">🧺 Laundry</div></div>
    <div class="col-6 col-md-2"><div class="facility-box">🛵 Area Parkir</div></div>
    <div class="col-6 col-md-2"><div class="facility-box">🔒 Keamanan 24 Jam</div></div>
    <div class="col-6 col-md-2"><div class="facility-box">🍽️ Dapur Bersama</div></div>
  </div>
</div>

<!-- FOOTER -->
<footer>
  <div class="container">
    <div class="row text-white">
      <div class="col-md-4 mb-3">
        <h6>Kontak</h6>
        <p class="mb-1">📍 Jl. Mawar No. 12, Mampang, Jakarta Selatan</p>
        <p class="mb-1">📞 0812-8981-2695</p>
        <p class="mb-1">✉️ info@kospisangijo.com</p>
      </div>
      <div class="col-md-4 mb-3">
        <h6>Jelajahi</h6>
        <ul class="list-unstyled mb-0">
          <li><a href="#kamar">Semua Hunian</a></li>
          <li><a href="#beranda">Semua Lokasi</a></li>
          <li><a href="#fasilitas">Fasilitas</a></li>
          <li><a href="pemilik.php">Pemilik Properti</a></li>
        </ul>
      </div>
      <div class="col-md-4 mb-3">
        <h6>Tempat Terdekat</h6>
        <ul class="list-unstyled mb-0">
          <li>📍 MRT Blok M - 10 menit</li>
          <li>📍 Pasaraya Blok M - 5 menit</li>
          <li>📍 UI Salemba - 20 menit</li>
          <li>📍 BINUS Blok M - 15 menit</li>
          <li>📍 RS Fatmawati - 10 menit</li>
        </ul>
      </div>
    </div>
    <hr class="border-top border-light">
    <p class="text-center mb-0 text-white">© <?= date('Y'); ?> Intan Tri Yulianti. Semua hak dilindungi.</p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
