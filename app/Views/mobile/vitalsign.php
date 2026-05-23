<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Literay FOR CG</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="mobile-web-app-capable" content="yes">
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
    --primary-color: #c407f3;
    --secondary-color: #f324db;
    --text-color: #2c3e50;
    --background-color: #f5f7fa;
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

#nav {
    background: var(--primary-color);
    padding: 0.8rem;
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
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
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: none;
    padding: 0.5rem 1.5rem;
    border-radius: 25px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.logout-btn:hover {
    background: rgba(255, 255, 255, 0.3);
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

.video-container {
    position: relative;
    padding-bottom: 56.25%;
    /* อัตราส่วน 16:9 */
    height: 0;
    overflow: hidden;
}

.video-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.menu-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    gap: 12px;
    padding: 1rem 0;
}

.menu-card {
    background: var(--color-bg, #fff);
    border: 0.5px solid #e0e0e0;
    border-radius: 12px;
    padding: 1.25rem 1rem;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.15s, transform 0.15s;
    text-decoration: none;
    display: block;
    color: inherit;
}

.menu-card:hover {
    border-color: #aaa;
    transform: translateY(-2px);
}

.menu-card img {
    border-radius: 50%;
    background: #f0f4ff;
    padding: 8px;
    margin-bottom: 10px;
}

.menu-card .pname {
    font-size: 14px;
    font-weight: 500;
    margin: 0 0 6px;
}

.menu-card .risktype {
    display: inline-block;
    font-size: 11px;
    padding: 3px 10px;
    border-radius: 99px;
    background: #fef3cd;
    color: #7a4f00;
}
.menu-card.risk-dm {
  background-color: #0a0af0;
  border-color: #007fe6;
}
.menu-card.risk-ht {
  background-color: #11ee8a;
  border-color: #27bb31;
}

.menu-card.risk-dm .pname {
  color: #fff;
}

.menu-card.risk-dm .risktype {
  background: rgba(255,255,255,0.3);
  color: #fff;
}
</style>
<div class="container-fluid p-0">
    <div class="header-section">
        <div class="header-content">
            <img src="<?=base_url('images/ltc_logo.png')?>" class="header-logo" alt="LTC Logo">
            <div class="header-text">
                <h2>ข้อมูลส่วนตัว</h2>
                <h3>ข้อมูลสุขภาพและความเสี่ยงของผู้ป่วย</h3>
            </div>
            <img src="<?=base_url('images/pcc.jpg')?>" class="header-logo" alt="PCC Logo">
        </div>
    </div>
