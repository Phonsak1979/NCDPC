<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="NCDs Prevention Center Admin Dashboard">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
    <title><?= $this->renderSection('title') ?> | NCDs Prevention Center | Admin</title>
    
    <link rel="stylesheet" href="<?= base_url('assets/staradmin/vendors/iconfonts/mdi/css/materialdesignicons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/staradmin/vendors/iconfonts/ionicons/dist/css/ionicons.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/staradmin/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/staradmin/vendors/css/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/staradmin/vendors/css/vendor.bundle.addons.css') ?>">
    <?= $this->renderSection('plugin_css') ?>
    <link rel="stylesheet" href="<?= base_url('assets/staradmin/css/shared/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/staradmin/css/demo_1/style.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/icon/themify-icons/themify-icons.css') ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/icon/font-awesome/css/font-awesome.min.css') ?>">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/icon/icofont/css/icofont.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/icon/feather/css/feather.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('dist/img/favicon.png') ?>" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>-->
    <link href="https://fonts.googleapis.com/css2?family=Anuphan:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!--dataTable-->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.6/css/buttons.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/searchbuilder/1.8.4/css/searchBuilder.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.6.3/css/dataTables.dateTime.min.css">
    
    <style>
        body { font-family: 'Anuphan', sans-serif; }
        label,span,p,a,i,u,h1,h2,h3,h4,h5,h6 {
          font-family: 'Anuphan', sans-serif !important;
        }
    </style>

    <script>
        const token = localStorage.getItem('jwt_token');
        if (!token) {
            // 1. ถ้าไม่มี Token, แจ้งเตือน (แบบดั้งเดิม) และ Redirect ทันที
            alert('ไม่พบการยืนยันตัวตน กรุณา Login เพื่อเข้าสู่ระบบ');
            // 2. ส่งกลับไปหน้า Login
            window.location.replace("<?= base_url('public/login') ?>");
        }
        // (ถ้ามี Token, สคริปต์นี้จะไม่ทำงาน และเบราว์เซอร์จะโหลดหน้าเว็บต่อ)
    </script>
    </head>
  <body>
    <div class="container-scroller">
      <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
          <a class="navbar-brand brand-logo" href="<?= base_url('public/dashboard') ?>">
            <img src="<?= base_url('dist/img/favicon.png') ?>" class="img-logo" alt="logo" style="object-fit: cover;height: 100%;width: auto;" />
            <span>&nbsp;NCDs | Admin</span>
          </a>
          <a class="navbar-brand brand-logo-mini" href="<?= base_url('public/dashboard') ?>">
            <img src="<?= base_url('dist/img/favicon.png') ?>" alt="logo" /></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center bg-facebook">
            <h4 class="mb-1 font-weight-bold text-light">SMART NCDs Prevention Center  &nbsp; <?php if(isset($office)) echo $office->hname; ?> </h4>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown d-none d-xl-inline-block user-dropdown">
                    <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                        <img class="img-xs rounded-circle" src="<?= base_url('assets/staradmin/images/faces/face8.jpg') ?>" alt="Profile image">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                        <div class="dropdown-header text-center">
                            <img class="img-md rounded-circle" src="<?= base_url('assets/staradmin/images/faces/face8.jpg') ?>" alt="Profile image">
                            <p class="mb-1 mt-3 font-weight-semibold" id="navProfileName">Loading...</p>
                            <p class="font-weight-light text-muted mb-0" id="navProfileEmail">Loading...</p>
                        </div>
                        <a class="dropdown-item">ข้อมูลผู้ใช้ <span class="badge badge-pill badge-danger">1</span><i class="dropdown-item-icon ti-dashboard"></i></a>
                        <a class="dropdown-item" href="#" id="logoutButton">ออกจากระบบ<i class="dropdown-item-icon ti-power-off"></i></a>
                    </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas"><span class="mdi mdi-menu"></span></button>
        </div>
      </nav>
      <div class="container-fluid page-body-wrapper pl-0">
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
                <a href="#" class="nav-link">
                    <div class="profile-image">
                        <img class="img-xs rounded-circle" src="<?= base_url('assets/staradmin/images/faces/face8.jpg') ?>" alt="profile image">
                        <div class="dot-indicator bg-success"></div>
                    </div>
                    <div class="text-wrapper">
                        <p class="profile-name" id="sidebarProfileName">Loading...</p>
                        <p class="designation" id="sidebarProfileRole">Loading...</p>
                    </div>
                </a>
            </li>
            <li class="nav-item nav-category">Main Menu</li>
            <li class="nav-item <?= (isset($page) && $page === 'dashboard') ? 'active' : '' ?>">
              <a class="nav-link" href="<?= base_url('public/dashboard') ?>">
                <i class="menu-icon typcn typcn-document-text"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="menu-icon typcn typcn-coffee"></i>
                <span class="menu-title">บริหารจัดการ NCDs </span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('public/fetchData/riskDm_HL') ?>">กลุ่มเสี่ยง DM </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('public/fetchData/riskHT_HL') ?>">กลุ่มเสี่ยง HT</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('public/newcaseData/newDm_page') ?>">ผู้ป่วย DM/HT </a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item <?= (isset($page) && $page === 'inproject-page')?'active':''?>">
              <a class="nav-link" href="<?= base_url('public/inproject/inproject') ?>">
                <i class="menu-icon typcn typcn-document-text"></i>
                <span class="menu-title">โครงการปรับพฤติกรรม</span>
              </a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-basic4" aria-expanded="false" aria-controls="ui-basic">
                <i class="menu-icon typcn typcn-coffee"></i>
                <span class="menu-title">เป้าหมายการคัดกรอง  </span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="ui-basic4">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('public/screenData/screen_dm_page') ?>">คัดกรอง DM </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('public/screenData/screen_ht_page') ?>">คัดกรอง HT</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('public/screenData/screen_ckd_page') ?>">คัดกรอง CKD </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('public/screenData/screen_cvd_page') ?>">คัดกรอง CVD </a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item <?= (isset($page) && $page === 'office-page') ? 'active' : '' ?>">
              <a class="nav-link btn" href="<?= base_url('public/hcoach/hl-page') ?>">
                <i class="menu-icon typcn typcn-home-outline"></i>
                <span class="menu-title" id="logoutButton">HL-Coach</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-basic2" aria-expanded="false" aria-controls="ui-basic">
                <i class="menu-icon typcn typcn-coffee"></i>
                <span class="menu-title">นำเข้าข้อมูล </span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="ui-basic2">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('public/importData/importHdc') ?>">ข้อมูลจาก HDC</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('public/importData/import43file') ?>">ข้อมูลจาก 43 แฟ้ม</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('public/importData/importNewPatient');?>">ข้อมูลผู้ป่วยรายใหม่ในปี HDC</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('public/importData/importScreen');?>">ข้อมูลคัดกรองในปีจาก HDC</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('public/importData/importOldPatient');?>">ทะเบียนผู้ป่วยรายเก่า HDC</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-basic3" aria-expanded="false" aria-controls="ui-basic3">
                <i class="menu-icon typcn typcn-coffee"></i>
                <span class="menu-title">ตั้งค่าระบบ </span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="ui-basic3">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('public/office-page') ?>">ข้อมูลหน่วยงาน</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('public/register') ?>">สมัครใช้งาน</a>
                  </li>
                   <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('public/setting/offices') ?>">หน่วยบริการ</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('public/setting/tumbons') ?>">ตำบล/หมู่บ้าน</a>
                   </li>
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('public/importData/importOSM') ?>">อสม./HL-coach</a>
                   </li>
                </ul>
              </div>
            </li>
           <li class="nav-item <?= (isset($page) && $page === 'office-page') ? 'active' : '' ?>">
              <a class="nav-link btn" onclick="logout();">
                <i class="menu-icon typcn typcn-home-outline"></i>
                <span class="menu-title" id="logoutButton">ออกจากระบบ</span>
              </a>
            </li>
          </ul>
        </nav>
        <?= $this->renderSection('content') ?>

      </div>
      </div>
    <script src="<?= base_url('assets/staradmin/vendors/js/vendor.bundle.base.js') ?>"></script>
    <script src="<?= base_url('assets/staradmin/vendors/js/vendor.bundle.addons.js') ?>"></script>
    <?= $this->renderSection('plugin_js') ?>
    <script src="<?= base_url('assets/staradmin/js/shared/off-canvas.js') ?>"></script>
    <script src="<?= base_url('assets/staradmin/js/shared/misc.js') ?>"></script>
    <?= $this->renderSection('scripts') ?>
    <script src="<?= base_url('assets/staradmin/js/shared/jquery.cookie.js') ?>" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <!-- dataTable-->
    <script src="https://cdn.datatables.net/2.3.6/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.dataTables.js"></script>
    <script src="https://cdn.datatables.net/searchbuilder/1.8.4/js/dataTables.searchBuilder.js"></script>
    <script src="https://cdn.datatables.net/searchbuilder/1.8.4/js/searchBuilder.dataTables.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.6.3/js/dataTables.dateTime.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
    <script>
        $(document).ready(function() {
            // (เราไม่ต้องเช็ค if !token ที่นี่แล้ว เพราะ <head> ตรวจไปแล้ว)
            
            // 1. ดึง Token (ที่รู้ว่ามีอยู่)
            const token = localStorage.getItem('jwt_token');

            // 2. ยิง AJAX เพื่อ "ยืนยัน" Token และดึงข้อมูล
            $.ajax({
                url: "<?= base_url('public/api/profile') ?>",
                type: "GET",
                headers: { "Authorization": "Bearer " + token },
                success: function(response) {
                    // (เหมือนเดิม) อัปเดตข้อมูลโปรไฟล์
                    const profileName = response.user.fname || response.user.username;
                    $('#navProfileName').text(profileName);
                    $('#navProfileEmail').text(response.user.email);
                    $('#sidebarProfileName').text(profileName);
                    $('#sidebarProfileRole').text(response.user.role);
                },
                error: function(xhr) {
                    // 3. (สำคัญ) Token หมดอายุ หรือ ไม่ถูกต้อง
                    localStorage.removeItem('jwt_token'); 

                    Swal.fire({
                        icon: 'error',
                        title: 'เซสชันหมดอายุ',
                        text: 'Token ของคุณหมดอายุหรือไม่ถูกต้อง กรุณา Login ใหม่อีกครั้ง',
                        showConfirmButton: true,
                        allowOutsideClick: false
                    }).then(() => {
                        window.location.replace("<?= base_url('public/login') ?>");
                    });
                }
            });

            // 4. (เหมือนเดิม) ปุ่ม Logout
            $('#logoutButton').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'ต้องการ Sign Out?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'ใช่, Sign Out',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        localStorage.removeItem('jwt_token');
                        window.location.replace("<?= base_url('public/login') ?>");
                    }
                })
            });
        });
    function logout()
    {
       Swal.fire({
                    title: 'ต้องการ Sign Out?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'ใช่, Sign Out',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        localStorage.removeItem('jwt_token');
                        window.location.replace("<?= base_url('public/login') ?>");
                    }
                })
    }
    </script>
  </body>
</html>