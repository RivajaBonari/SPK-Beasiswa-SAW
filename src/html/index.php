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
      <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div>
          <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="./index.php" class="text-nowrap logo-img">
              <img src="../assets/images/logos/logo1.png" alt="" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
              <i class="ti ti-x fs-6"></i>
            </div>
          </div>
          <!-- Sidebar navigation-->
          <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
              <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Home</span>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="./index.php" aria-expanded="false">
                  <i class="ti ti-atom"></i>
                  <span class="hide-menu">Dashboard</span>
                </a>
              </li>
              <!-- ---------------------------------- -->
              <!-- Dashboard -->
              <!-- ---------------------------------- -->

              <li class="sidebar-item">
              <a class="sidebar-link" href="./ui-card.php" aria-expanded="false">
                <i class="ti ti-cards"></i>
                <span class="hide-menu">Card</span>
              </a>
            </li>


              <li>
                <span class="sidebar-divider lg"></span>
              </li>
              <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Apps</span>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link justify-content-between" target="_blank"
                  href="https://bootstrapdemos.adminmart.com/modernize/dist/main/app-invoice.html" aria-expanded="false">
                  <div class="d-flex align-items-center gap-3">
                    <span class="d-flex">
                      <i class="ti ti-file-text"></i>
                    </span>
                    <span class="hide-menu">Invoice</span>
                  </div>
                  <span class="hide-menu badge text-bg-secondary fs-1 py-1">Pro</span>
                </a>
              </li>


              <li>
                <span class="sidebar-divider lg"></span>
              </li>
              <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Auth</span>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="../backend/authLogout.php" aria-expanded="false">
                  <i class="ti ti-login"></i>
                  <span class="hide-menu">Logout</span>
                </a>
              </li>
            </ul>
          </nav>
          <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
      </aside>
      <!--  Sidebar End -->
      <!--  Main wrapper -->
      <div class="body-wrapper">
        <!--  Header Start -->
        <header class="app-header">
          <nav class="navbar navbar-expand-lg navbar-light">
            <ul class="navbar-nav">
              <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler " id="headerCollapse" href="javascript:void(0)">
                  <i class="ti ti-menu-2"></i>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link " href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="ti ti-bell"></i>
                  <div class="notification bg-primary rounded-circle"></div>
                </a>
                <div class="dropdown-menu dropdown-menu-animate-up" aria-labelledby="drop1">
                  <div class="message-body">
                    <a href="javascript:void(0)" class="dropdown-item">
                      Item 1
                    </a>
                    <a href="javascript:void(0)" class="dropdown-item">
                      Item 2
                    </a>
                  </div>
                </div>
              </li>
            </ul>
            <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
              <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">

                <a href="#"
                  class="btn btn-primary">Halo <?= $_SESSION['username']; ?> !</a>

                <li class="nav-item dropdown">
                  <a class="nav-link " href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                  </a>
                  <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                    <div class="message-body">
                      <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                        <i class="ti ti-user fs-6"></i>
                        <p class="mb-0 fs-3">My Profile</p>
                      </a>
                      <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                        <i class="ti ti-mail fs-6"></i>
                        <p class="mb-0 fs-3">My Account</p>
                      </a>
                      <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                        <i class="ti ti-list-check fs-6"></i>
                        <p class="mb-0 fs-3">My Task</p>
                      </a>
                      <a href="../backend/authLogout.php" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </nav>
        </header>
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

            <div class="py-6 px-6 text-center">
              <p class="mb-0 fs-4">Design and Developed by <a href="https://github.com/RivajaBonari" target="_blank"
                  class="pe-1 text-primary text-decoration-underline">AdminMart.com</a></p>
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

  </html>