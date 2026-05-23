<div class="container-fluid py-4 animate__animated animate__fadeIn" style="max-width: 500px; background: #fdfdfd;">
    
    <div class="text-center mb-4">
        <div class="display-1 text-success mb-2"><i class="fas fa-check-circle"></i></div>
        <h4 class="fw-bold">ประเมินเรียบร้อยแล้ว</h4>
        <p class="text-muted">ผลการวิเคราะห์ความฉลาดทางสุขภาพของ คุณสมชาย</p>
        
        <div style="width: 200px; margin: 0 auto;">
            <canvas id="gaugeChart"></canvas>
            <h2 class="fw-bold mt-minus-2" id="finalScoreText" style="color: <?= $color ?>;"><?= $score ?></h2>
            <span class="badge" style="background-color: <?= $color ?>;"><?= $level_name ?></span>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body">
            <h6 class="fw-bold mb-3"><i class="fas fa-chart-pie me-2"></i>วิเคราะห์ทักษะ 4 ด้าน</h6>
            <canvas id="radarChart"></canvas>
        </div>
    </div>

    <div class="alert shadow-sm border-0 rounded-4 mb-4" style="background-color: <?= $color ?>20; border-left: 5px solid <?= $color ?>;">
        <h6 class="fw-bold"><i class="fas fa-lightbulb me-2"></i>คำแนะนำในการโค้ช:</h6>
        <p class="small mb-0 text-dark"><?= $coach_instruction ?></p>
    </div>

    <h6 class="fw-bold mb-3">สื่อที่แนะนำให้ใช้สอนครั้งนี้:</h6>
    <div class="d-flex gap-2 overflow-auto pb-3">
        <?php foreach($recommended_media as $media): ?>
        <div class="card border-0 shadow-sm rounded-4 flex-shrink-0" style="width: 140px;">
            <img src="<?= $media['thumb'] ?>" class="card-img-top rounded-top-4">
            <div class="p-2">
                <small class="d-block text-truncate fw-bold"><?= $media['title'] ?></small>
                <a href="<?= $media['url'] ?>" class="btn btn-sm btn-primary w-100 mt-1 rounded-pill">เปิดดู</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="d-grid gap-2 mt-3">
        <button class="btn btn-outline-primary rounded-pill shadow-sm" onclick="window.print()"><i class="fas fa-print me-2"></i>พิมพ์สรุปผล (PDF)</button>
        <a href="<?= base_url('coach/dashboard') ?>" class="btn btn-link text-muted">กลับไปหน้าหลัก</a>
    </div>
</div>