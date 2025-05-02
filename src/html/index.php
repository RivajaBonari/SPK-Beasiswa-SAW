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
        <!--  Header End -->
        <div class="body-wrapper-inner">
          <div class="container-fluid">
            <!--  Row 1 -->
            <div class="row">
              <div class="col-lg-8 d-flex align-items-strech">
                <div class="card w-100">
                  <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                      <div class="mb-3 mb-sm-0">
                        <h5 class="card-title fw-semibold">Sales Overview</h5>
                      </div>
                      <div>
                        <select class="form-select">
                          <option value="1">March 2025</option>
                          <option value="2">April 2025</option>
                          <option value="3">May 2025</option>
                          <option value="4">June 2025</option>
                        </select>
                      </div>
                    </div>
                    <div id="chart"></div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="row">
                  <div class="col-lg-12">
                    <!-- Yearly Breakup -->
                    <div class="card overflow-hidden">
                      <div class="card-body p-4">
                        <h5 class="card-title mb-9 fw-semibold">Yearly Breakup</h5>
                        <div class="row align-items-center">
                          <div class="col-7">
                            <h4 class="fw-semibold mb-3">$36,358</h4>
                            <div class="d-flex align-items-center mb-3">
                              <span
                                class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                                <i class="ti ti-arrow-up-left text-success"></i>
                              </span>
                              <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                              <p class="fs-3 mb-0">last year</p>
                            </div>
                            <div class="d-flex align-items-center">
                              <div class="me-4">
                                <span class="round-8 bg-primary rounded-circle me-2 d-inline-block"></span>
                                <span class="fs-2">2025</span>
                              </div>
                              <div>
                                <span class="round-8 bg-light-primary rounded-circle me-2 d-inline-block"></span>
                                <span class="fs-2">2024</span>
                              </div>
                            </div>
                          </div>
                          <div class="col-5">
                            <div class="d-flex justify-content-center">
                              <div id="breakup"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <!-- Monthly Earnings -->
                    <div class="card">
                      <div class="card-body">
                        <div class="row alig n-items-start">
                          <div class="col-8">
                            <h5 class="card-title mb-9 fw-semibold"> Monthly Earnings </h5>
                            <h4 class="fw-semibold mb-3">$6,820</h4>
                            <div class="d-flex align-items-center pb-1">
                              <span
                                class="me-2 rounded-circle bg-light-danger round-20 d-flex align-items-center justify-content-center">
                                <i class="ti ti-arrow-down-right text-danger"></i>
                              </span>
                              <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                              <p class="fs-3 mb-0">last year</p>
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="d-flex justify-content-end">
                              <div
                                class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                <i class="ti ti-currency-dollar fs-6"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div id="earning"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <?php
            include('footer.php');
            ?>
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

  </html>