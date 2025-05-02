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


        </div>

        <?php
        include('footer.php');
        ?>
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