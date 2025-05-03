<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SPK Beasiswa</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/logo1.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
  <style>
    .brand-logo {
      padding: 20px;
      border-bottom: 1px solid #e0e0e0;
      background-color: #ffffff;
    }

    .brand-logo .logo-img img {
      height: 30px;
      width: auto;
      object-fit: contain;
      transform: scale(1.5);
      /* Perbesar tampilannya */
      transform-origin: left center;
      /* Supaya pembesaran dari kiri */
    }
  </style>
</head>

<body>
  <!-- untuk autentikasi supaya wajib login untuk mengakses web nya -->
  <?php
  session_start();
  if (!isset($_SESSION['login'])) {
    header("location:../html/authentication-login.php");
    exit;
  }
  ?>
  <!-- untuk autentikasi supaya wajib login untuk mengakses web nya -->

  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">

    <!-- Sidebar Start -->
    <?php
    include('sidebar.php');
    ?>
    <!--  Sidebar End -->

    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <?php
      include('header.php');
      ?>

      <?php
      include("../backend/config.php");

      // Konfigurasi pagination
      $perPage = 5;
      $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
      $start = ($page - 1) * $perPage;

      // Proses sorting nilai_akhir
      $sort = isset($_GET['sort']) && in_array(strtolower($_GET['sort']), ['asc', 'desc']) ? $_GET['sort'] : 'desc';

      // Hitung total data
      $totalQuery = $conn->query("SELECT COUNT(*) AS total FROM perangkingan");
      $totalData = $totalQuery->fetch_assoc()['total'];
      $totalPages = ceil($totalData / $perPage);

      // Ambil data dengan sorting dan pagination
      $sql = "SELECT * FROM perangkingan ORDER BY nilai_akhir $sort LIMIT $start, $perPage";
      $exe = $conn->query($sql);
      ?>

      <!-- Header End -->
      <div class="body-wrapper-inner">
        <div class="container-fluid">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <!-- Tombol Tambah Data di kiri -->
            <div>
              <form action="../backend/proses_perangkingan.php" method="POST">
                <button type="submit" class="btn btn-primary">
                  <i class="ti ti-loader"></i>
                  <span>Proses Data</span>
                </button>
              </form>
            </div>

            <!-- Tombol Sort di kanan -->
            <div class="dropdown">
              <a href="javascript:void(0)" class="btn btn-outline-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ti ti-sort-descending"></i> Urutkan
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li>
                  <a class="dropdown-item d-flex align-items-center gap-2" href="?sort=asc">
                    <i class="ti ti-arrow-up"></i> Nilai Akhir Naik
                  </a>
                </li>
                <li>
                  <a class="dropdown-item d-flex align-items-center gap-2" href="?sort=desc">
                    <i class="ti ti-arrow-down"></i> Nilai Akhir Turun
                  </a>
                </li>
              </ul>
            </div>
          </div>


          <!-- Tabel Perangkingan -->
          <table class="table text-nowrap mb-0 align-middle">
            <thead class="text-dark fs-4">
              <tr>
                <th>
                  <h6 class="fs-4 fw-semibold mb-0">ID Pendaftaran</h6>
                </th>
                <th>
                  <h6 class="fs-4 fw-semibold mb-0">IPK</h6>
                </th>
                <th>
                  <h6 class="fs-4 fw-semibold mb-0">Penghasilan Ortu</h6>
                </th>
                <th>
                  <h6 class="fs-4 fw-semibold mb-0">Tanggungan</h6>
                </th>
                <th>
                  <h6 class="fs-4 fw-semibold mb-0">Organisasi</h6>
                </th>
                <th>
                  <h6 class="fs-4 fw-semibold mb-0">Nilai Akhir</h6>
                </th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php while ($data = $exe->fetch_assoc()) { ?>
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <img src="../assets/images/profile/user-2.jpg" class="rounded-circle" width="40" height="40">
                      <div class="ms-3">
                        <h6 class="fs-4 fw-semibold mb-0">#<?= $data['id_pendaftaran']; ?></h6>
                        <span class="fw-normal">Ranking ID: <?= $data['id_perangkingan']; ?></span>
                      </div>
                    </div>
                  </td>
                  <td>
                    <p class="mb-0 fw-normal"><?= number_format($data['ipk_normalisasi'], 4) ?></p>
                  </td>
                  <td>
                    <p class="mb-0 fw-normal"><?= number_format($data['penghasilan_ortu_normalisasi'], 4) ?></p>
                  </td>
                  <td>
                    <p class="mb-0 fw-normal"><?= number_format($data['tanggungan_normalisasi'], 4) ?></p>
                  </td>
                  <td>
                    <p class="mb-0 fw-normal"><?= number_format($data['organisasi_normalisasi'], 4) ?></p>
                  </td>
                  <td>
                    <p class="mb-0 fw-semibold"><?= number_format($data['nilai_akhir'], 4) ?></p>
                  </td>
                  <td>
                    <div class="dropdown dropstart">
                      <a href="javascript:void(0)" class="text-muted" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ti ti-dots fs-5"></i>
                      </a>
                      <ul class="dropdown-menu">
                        <li>
                          <a class="dropdown-item d-flex align-items-center gap-3" href="detailHasil.php?id=<?= $data['id_perangkingan']; ?>">
                            <i class="fs-4 ti ti-eye"></i>Lihat Detail
                          </a>
                        </li>
                        <li>
                          <a class="dropdown-item d-flex align-items-center gap-3" href="../aksi/deletePerangkingan.php?id=<?= $data['id_perangkingan']; ?>" onclick="return confirm('Yakin dihapus?')">
                            <i class="fs-4 ti ti-trash"></i>Hapus
                          </a>
                        </li>
                      </ul>
                    </div>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>

          <!-- Navigasi Pagination -->
          <?php if ($totalPages > 1): ?>
            <nav class="mt-3">
              <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                  <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?= $i; ?>&sort=<?= $sort; ?>"><?= $i; ?></a>
                  </li>
                <?php endfor; ?>
              </ul>
            </nav>
          <?php endif; ?>

          <?php include('footer.php'); ?>
        </div>
      </div>
    </div>
  </div>
  </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../assets/js/dashboard.js"></script>
  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>
<script>
  $(document).ready(function() {
    $('.btn-edit').click(function() {
      const npm = $(this).data('npm');
      const nama = $(this).data('nama');
      const gender = $(this).data('gender');
      const telepon = $(this).data('telepon');
      const alamat = $(this).data('alamat');

      $('#edit_npm').val(npm);
      $('#edit_nama_mahasiswa').val(nama);
      $('#edit_gender').val(gender);
      $('#edit_telepon').val(telepon);
      $('#edit_alamat').val(alamat);
    });
  });
</script>


</html>