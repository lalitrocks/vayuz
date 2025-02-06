<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <title><?= $title ?></title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <!-- CSS Files -->
    <link rel="shortcut icon" href="<?= SERVER_URL ?>assets/images/favicon.png" type="image/x-icon">

    <link rel="stylesheet" href="<?= SERVER_URL ?>assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href='<?= SERVER_URL . 'assets/css/admin/plugins.min.css' ?>' />
    <link rel="stylesheet" href="<?= SERVER_URL ?>assets/fontawesome/css/all.css">
    <link rel="stylesheet" href="<?= SERVER_URL ?>assets/css/admin/main.css">

    <link rel="stylesheet" href='<?= SERVER_URL . 'assets/css/admin/kaiadmin.min.css' ?>' />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= SERVER_URL ?>assets/js/admin/jquery-3.7.1.min.js"></script>

    <script>
        const jwtToken = localStorage.getItem('jwt_token');
        const role = localStorage.getItem('user_role');



        function restrictedContent() {
            $.ajax({
                headers: {
                    'Authorization': 'Bearer ' + jwtToken // Include the JWT token
                },
                method: "GET",
                url: window.location.protocol + "//" + window.location.hostname + "/lalit_vayuz/api/admin_access_page",
                contentType: 'application/json', // Specifies that you're sending JSON
            }).done(function(res) {
                res = JSON.parse(res);
                console.log(res);
                
                if (res.status == 404) {
                    window.location.href = window.location.protocol + "//" + window.location.hostname + "/lalit_vayuz/admin/profile/";
                } else if (res.status == 500) {
                    logout();
                }
            })

        }

         function get_logged_in_userdetail() {
            $.ajax({
                headers: {
                    'Authorization': 'Bearer ' + jwtToken // Include the JWT token
                },
                method: "GET",
                url: window.location.protocol + "//" + window.location.hostname + "/lalit_vayuz/api/get_logged_in_userdetail",
                contentType: 'application/json', // Specifies that you're sending JSON
            }).done(function(res) {
                res = JSON.parse(res);
                if (res.status == 200) {
                    initalize(res.data);

                } else{
                   logout();
                }
            })
        }
        var base64data;
    </script>



</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">
                    <a href="<?= SERVER_URL ?>admin" class="logo text-white">
                        Dashboard
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>
                </div>
                <!-- End Logo Header -->
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item hidden-when-not-admin <?= $this->uri->segment(2) == 'users' ? 'active' : '' ?>    ">
                            <a href="<?= SERVER_URL ?>admin/users">
                                <i class="fas fa-home"></i>
                                <p>Users</p>
                            </a>

                        </li>
                        <li class="nav-item  <?= $this->uri->segment(2) == 'profile' ? 'active' : '' ?>    ">
                            <a href="<?= SERVER_URL ?>admin/profile">
                                <i class="fas fa-home"></i>
                                <p>Profile</p>
                            </a>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->


        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <div class="logo-header" data-background-color="dark">
                        <a href="index.html" class="logo">
                            <img src="assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand"
                                height="20" />
                        </a>
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar">
                                <i class="gg-menu-right"></i>
                            </button>
                            <button class="btn btn-toggle sidenav-toggler">
                                <i class="gg-menu-left"></i>
                            </button>
                        </div>
                        <button class="topbar-toggler more">
                            <i class="gg-more-vertical-alt"></i>
                        </button>
                    </div>
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header -->
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <nav
                            class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-search pe-1">
                                        <i class="fa fa-search search-icon"></i>
                                    </button>
                                </div>
                                <input type="text" placeholder="Search " class="form-control" />
                            </div>
                        </nav>

                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#"
                                    role="button" aria-expanded="false" aria-haspopup="true">
                                    <i class="fa fa-search"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-search animated fadeIn">
                                    <form class="navbar-left navbar-form nav-search">
                                        <div class="input-group">
                                            <input type="text" placeholder="Search ..." class="form-control" />
                                        </div>
                                    </form>
                                </ul>
                            </li>

                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                                    aria-expanded="false">
                                    <div class="avatar-sm">
                                        <img src="<?= SERVER_URL ?>assets/images/usericon.png" alt="..."
                                            style="width: 40px;height: 40px;" />
                                    </div>
                                    <span class="profile-username">
                                        <span class="op-7">Hi,</span>
                                        <span class="fw-bold user-name"></span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-user animated fadeIn">
                                    <div class="dropdown-user-scroll scrollbar-outer">
                                        <li>
                                            <div class="user-box">
                                                <div class="avatar-lg">
                                                    <img src="<?= SERVER_URL ?>assets/images/usericon.png" alt="image profile"
                                                        class="avatar-img rounded" />
                                                </div>
                                                <div class="u-text">
                                                    <h4 class="user-name"></h4>
                                                    <!-- <p class="text-muted">{{ $Is_logged()['email'] }}</p> -->
                                                    <!-- <a 
                                                        class="btn btn-xs btn-secondary btn-sm">View Profile</a> -->
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item " href="<?= SERVER_URL ?>admin/dashboard">Dashboard</a>
                                            <a class="dropdown-item" href="<?= SERVER_URL ?>admin/profile">Profile</a>
                                            <a class="dropdown-item" onclick="logout()">Logout</a>
                                        </li>
                                    </div>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- End Navbar -->
            </div>

            <div class="container h-100 overflow-visible">

                <?php $this->load->view('admin/' . $page) ?>
            </div>

        </div>

    </div>

    <script>
        if (role !== 'admin') {
            $('.hidden-when-not-admin').remove();
        }
    </script>
    <script src="<?= SERVER_URL ?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= SERVER_URL ?>assets/js/admin/popper.min.js"></script>
    <script src="<?= SERVER_URL ?>assets/js/admin/kaiadmin.js"></script>
    <script src="<?= SERVER_URL ?>assets/js/admin/jquery.scrollbar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.js"></script>

    <script src="<?= SERVER_URL ?>assets/js/ajax.js"></script>
    <script src="<?= SERVER_URL ?>assets/js/admin/main.js"></script>


</body>

</html>