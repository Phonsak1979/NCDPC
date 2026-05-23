<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('title') ?>
ข้อมูลหน่วยงาน
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="main-panel">
    <div class="content-wrapper">

        <div class="row page-title-header">
            <div class="col-12">
                <div class="page-header">
                    <h4 class="page-title">ข้อมูลหน่วยงานของคุณ</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <?php if ($office): ?>

                        <h4 class="card-title">ดึงข้อมูลสำเร็จ: JWT -> DATABASE </h4>
                        <p class="card-description">
                            นี่คือข้อมูลของหน่วยงาน (hcode: <code><?= esc($user->hcode) ?></code>) ที่ผูกกับบัญชีของคุณ
                        </p>

                        <h1 class="text-primary mt-4">
                            <i class="mdi mdi-hospital-building"></i>
                            <?= esc($office->hname) ?>
                        </h1>

                        <hr>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>ประเภทหน่วยงาน:</strong> <?= esc($office->htype) ?>
                            </li>
                            <li class="list-group-item">
                                <strong>อัปเดตล่าสุด:</strong> <?= esc($office->d_update) ?>
                            </li>
                        </ul>

                        <?php else: ?>
                        <div class="alert alert-danger" role="alert">
                            <h4 class="alert-heading">เกิดข้อผิดพลาด!</h4>
                            <p>
                                ไม่พบข้อมูลหน่วยงานสำหรับรหัส <code><?= esc($user->hcode) ?></code>
                                ในฐานข้อมูล `ltc_office`
                            </p>
                            <hr>
                            <p class="mb-0">
                                (hcode นี้ถูกดึงมาจาก JWT Token ของคุณ)
                            </p>
                        </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $this->include('layouts/footers') ?>
</div>

    <?= $this->endSection() ?>


    <?= $this->section('scripts') ?>
    <script>
    $(document).ready(function() {
       
    });
    </script>
    <?= $this->endSection() ?>