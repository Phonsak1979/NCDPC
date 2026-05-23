<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SMM HL</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="mobile-web-app-capable" content="yes">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
    <link rel="icon" type="image/x-icon" href="<?=base_url('/images/smmicon.ico');?>">
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <!--<script src="assets/instascan.min.js"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <!-- This is what you need -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
    <!--.......................-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@300&display=swap" rel="stylesheet">
</head>

<style>
:root {
    --primary-color: #073cf3;
    --secondary-color: #4a90e2;
    --text-color: #2c3e50;
    --background-color: #f5f7fa;
    --primary-green: #4f8c6f;
    --light-green: #e9f5ef;
    --accent-mint: #aedcc0;
    --text-dark: #334139;
    --danger-green: #eea215;
    --blue-red: #0ef6db;
    --red-blue: #df3c17;
}

body {
    font-family: 'Mitr', sans-serif;
    background: var(--background-color);
    padding-bottom: 60px;
    font-size: 16px;
    line-height: 1.6;
}

.header-section {
    background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
    padding: 1rem 1rem;
    border-radius: 0 0 25px 25px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
}

.header-content {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
}

.header-logo {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

.header-text {
    text-align: center;
    color: white;
}

.header-text h2 {
    font-size: 1.8rem;
    margin: 0;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
}

.header-text h3 {
    font-size: 1.2rem;
    margin: 0.5rem 0 0;
    opacity: 0.9;
}

.menu-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
    padding: 0 1rem;
}

.menu-card {
    background: white;
    text-decoration: none;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.menu-card:hover {
    transform: translateY(-5px);
    background-color: rgb(161, 230, 59);
}

.menu-card img {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    margin: 1.5rem auto;
    display: block;
    border: 3px solid #f0f0f0;
}

.menu-card .card-body {
    padding: 1rem;
    text-align: center;
    text-decoration: none;
    border-top: 1px solid #f0f0f0;
}

.menu-card .h6 {
    font-size: 1rem;
    color: var(--text-color);
    margin: 0;
}

.motto-banner {
    background-color: transparent;
    padding: 40px 0;
    text-align: center;
}

.card-custom {
    background: var(--light-green);
    padding: 1rem 1rem;
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.card-result {
    background: var(--light-green);
    padding: 1rem 1rem;
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}
.img-title {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}
.motto-title {
    color: var(--background-color);
    font-weight: 700;
    font-size: 2.5rem;
    position: relative;
    display: inline-block;
}

/* ตกแต่งใบไม้ข้างหัวข้อ */
.motto-title::before,
.motto-title::after {
    content: '🍃';
    font-size: 1.5rem;
    position: absolute;
    top: -10px;
}

.motto-title::before {
    left: -40px;
    transform: rotate(-20deg);
}

.motto-title::after {
    right: -40px;
    transform: rotate(40deg);
}

#nav {
    background: var(--primary-green);
    padding: 0.8rem;
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
    border-radius: 25px 25px 0 0;
}

.nav-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 1rem;
}

.btn-record {
    background: var(--primary-color);
    color: white;
    border-radius: 50px;
    padding: 15px 35px;
    font-weight: 700;
    border: none;
    box-shadow: 0 5px 15px rgba(79, 140, 111, 0.3);
}

.btn-record:hover {
    background: #3d6e56;
    color: white;
}

.btn-register {
    background: var(--red-blue);
    color: white;
    border-radius: 50px;
    padding: 15px 35px;
    font-weight: 700;
    border: none;
    box-shadow: 0 5px 15px rgba(79, 140, 111, 0.3);
}

.btn-register:hover {
    background: #3d6e56;
    color: white;
}
@media (max-width: 768px) {
    .header-text h2 {
        font-size: 1.5rem;
    }

    .header-text h3 {
        font-size: 1rem;
    }

    .menu-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 480px) {
    .menu-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .header-logo {
        width: 50px;
        height: 50px;
    }
}
</style>
</head>
<body>
    <div class="container-fluid p-0">
    <div class="header-section">
        <div class="motto-banner mb-1">
            <h1 class="motto-title mb-2">ศรีเมืองใหม่</h1>
            <h2 class="fw-bold text-danger">ลดความเสี่ยงโรค NCDs</h2>
        </div>
    </div>
    <div class="container py-5">
            <form id="frmLogin"  enctype="multipart/form-data">
                <div class="form-floating mb-3">
                    <input type="text" id="access_code" name="access_code" class="form-control rounded-pill px-4"
                        placeholder="รหัสเข้าใช้งาน" required>
                    <label class="px-4">รหัสผ่านสำหรับประชาชนทั่วไป</label>
                </div>
                <button type="submit" class="btn btn-success w-100 py-3 rounded-pill fw-bold">เข้าสู่ระบบ</button>
            </form>
        </div>
    </div>
    <div id="nav">
        <div class="nav-container">
           
        </div>
    </div>
</body>

</html>
<script>
$(document).ready(function() {
    $('#frmLogin').submit(function(event) {
        event.preventDefault();
        
        const formData = new FormData($(this)[0]);
        const accessCode = $('#access_code').val();

        if (accessCode.trim() === '') {
            Swal.fire('คำเตือน', 'กรุณากรอกรหัสเข้าใช้งาน', 'warning');
            return false;
        }

        Swal.fire({
            title: 'กรุณารอสักครู่',
            text: 'กำลังนำเข้าสู่ระบบ...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        //console.log(formData);
        $.ajax({
            url: '<?= base_url('public/mb-login-process') ?>', 
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                Swal.close(); // ปิด Loading ก่อนแสดงผลใหม่
                
                if (response.msg === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ',
                        text: response.text,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '<?= base_url('public/mobile-page'); ?>';       
                    });
                } else {
                    Swal.fire('ข้อผิดพลาด', response.text || 'เข้าระบบไม่สำเร็จ', 'error');
                }
            },
            error: function(xhr, status, error) {
                Swal.close();
                console.error(xhr.responseText); // ดู error จริงใน Console
                Swal.fire('error', 'เกิดข้อผิดพลาดในการเชื่อมต่อเครื่องแม่ข่าย'+xhr.responseText, 'error');
            }
        });
    });
    $('#btnViewResults').click(function() {
        window.location.href = '<?= base_url('public/dashboard'); ?>';
    });
    $('#btnRegister').click(function() {
        window.location.href = '<?= base_url('public/register'); ?>';
    });
}); 
</script>