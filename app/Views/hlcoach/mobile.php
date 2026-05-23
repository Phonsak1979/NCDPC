<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
	<title>SMM HL-Coach</title>
	<meta name="description" content="The small framework with powerful features">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" type="image/x-icon" href="<?=base_url('/images/smmicon.ico');?>">
   <!-- Latest compiled and minified CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!--<script src="assets/instascan.min.js"></script>-->
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
  --primary-color: #f307d7;
  --secondary-color: #cb4ae2;
  --text-color: #0a1c2f;
  --background-color: #d6ebd7;
}

body {
  font-family: 'Mitr', sans-serif;
  background: var(--background-color);
  padding-bottom: 60px;
  font-size: 16px;
  line-height: 1.6;
}

.header-section {
  background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
  padding: 1.5rem 1rem;
  border-radius: 0 0 25px 25px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
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
  box-shadow: 0 2px 10px rgba(0,0,0,0.2);
}

.header-text {
  text-align: center;
  color: white;
}

.header-text h2 {
  font-size: 1.8rem;
  margin: 0;
  text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
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
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  transition: transform 0.3s ease;
}

.menu-card:hover {
  transform: translateY(-5px);
  background-color:rgb(161, 230, 59);
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

#nav {
  background: var(--primary-color);
  padding: 0.8rem;
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
}

.nav-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 1rem;
}

.user-info {
  color: white;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.logout-btn {
  background: rgba(255,255,255,0.2);
  color: white;
  border: none;
  padding: 0.5rem 1.5rem;
  border-radius: 25px;
  font-size: 0.9rem;
  transition: all 0.3s ease;
}

.logout-btn:hover {
  background: rgba(255,255,255,0.3);
}

@media (max-width: 768px) {
  .header-text h2 { font-size: 1.5rem; }
  .header-text h3 { font-size: 1rem; }
  .menu-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 480px) {
  .menu-grid { grid-template-columns: repeat(2, 1fr); }
  .header-logo { width: 50px; height: 50px; }
}
</style>
<div class="container-fluid p-0">
    <div class="header-section">
        <div class="header-content">
            <img src="<?=base_url('images/digital_hl.png')?>" class="header-logo" alt="HL Logo">
            <div class="header-text">
                <h2>Health Literacy Coach</h2>
                <h4>นักจัดการความรอบรู้ด้านสุขภาพ</h4>
            </div>
            <img src="<?=base_url('images/service.jpg')?>" class="header-logo" alt="NCDs Logo">
        </div>
    </div>
    <div class="menu-grid">
        <a href="<?=base_url('public/visit_ptbed')?>" class="menu-card">
            <img src="<?=base_url('images/ncds.png')?>" alt="กลุ่มเสี่ยง">
            <div class="card-body">
                <div class="h6">กลุ่มเสี่ยงเบาหวาน/ความดัน</div>
            </div>
        </a>

         <a href="<?=base_url('public/visit_ptbed')?>" class="menu-card">
            <img src="<?=base_url('images/low_carb.png')?>" alt="คำนวณคาร์บ">
            <div class="card-body">
                <div class="h6">คำนวนคาร์บ</div>
            </div>
        </a>

         <a href="<?=base_url('public/visit_ptbed')?>" class="menu-card">
            <img src="<?=base_url('images/exercise.png')?>" alt="กิจกรรมสร้างสุขภาพ">
            <div class="card-body">
                <div class="h6">ส่งภาพกิจกรรมสุขภาพ</div>
            </div>
        </a>

        <a href="<?= base_url('public/HealthLiteracy'); ?>" class="menu-card">
            <img src="<?=base_url('images/advertising.png')?>" alt="คลังข้อมูล">
            <div class="card-body">
                <div class="h6">คลังความรู้ <br/> สำหรับ HL-Coach</div>
            </div>
        </a>
    </div>

    <div id="nav">
        <div class="nav-container">
            <div class="user-info">
                <i class="fa fa-user"></i>
                <span><?= esc($user->fname);?><br><?= esc($office->hname);?></span>
            </div>
            <a href="<?=base_url('public/logout')?>" class="logout-btn">
                <i class="fa fa-sign-out"></i> ออกจากระบบ
            </a>
        </div>
    </div>
</div>
</body>
</html>
<script>
   $(document).ready(function() {
        $('.logout-btn').on('click', function(e) {
            e.preventDefault();                          
            localStorage.removeItem('jwt_token');
            window.location.replace("<?= base_url('public/login') ?>");                         
        });
    });
        // 2. ปุ่ม Logout
</script>