<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?>
    โปรไฟล์ของฉัน
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="main-panel">
  <div class="content-wrapper">
    
    <div class="row page-title-header">
      <div class="col-12">
        <div class="page-header">
          <h4 class="page-title">โปรไฟล์ของฉัน (My Profile)</h4>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">ข้อมูลผู้ใช้งาน</h4>
            <ul class="list-group list-group-flush">
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <strong>ชื่อ-สกุล (fname):</strong>
                <span><?= esc($user->fname ?? 'N/A') ?></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <strong>Username:</strong>
                <span><?= esc($user->username) ?></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <strong>Email:</strong>
                <span><?= esc($user->email) ?></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <strong>รหัสหน่วยงาน (hcode):</strong>
                <span><?= esc($user->hcode) ?></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <strong>สิทธิ์ (Role):</strong>
                <span class="badge badge-primary badge-pill"><?= esc($user->role) ?></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <strong>User ID (จาก Token):</strong>
                <span><?= esc($user->user_id) ?></span>
              </li>
            </ul>

          </div>
        </div>
      </div>
      
      <div class="col-md-4 grid-margin">
        <div class="card">
            <div class="card-body text-center">
                <img class="img-lg rounded-circle mb-3" 
                     src="<?= base_url('assets/staradmin/images/faces/face8.jpg') ?>" 
                     alt="Profile image">
                <h4 class="card-title"><?= esc($user->fname ?? $user->username) ?></h4>
                <p class="text-muted"><?= esc($user->role) ?></p>
            </div>
        </div>
      </div>

    </div>

  </div>
  <footer class="footer">
    <div class="container-fluid clearfix">
      <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © สำนักงานสาธารณสุขอำเภอศรีเมืองใหม่ 2026</span>
    </div>
  </footer>
</div>
<?= $this->endSection() ?>