<?= $this->extend('layouts/main_layout'); ?>
<?= $this->section('styles'); ?>
<style>
    /* modern upload area styles (same as other import pages) */
    .file-upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 40px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background-color: #f8f9fa;
    }

    .file-upload-area:hover {
        border-color: #0d6efd;
        background-color: #e7f1ff;
    }

    .file-upload-area.drag-over {
        border-color: #0d6efd;
        background-color: #e7f1ff;
        box-shadow: 0 0 10px rgba(13, 110, 253, 0.2);
    }

    .upload-icon {
        font-size: 3rem;
        color: #0d6efd;
        opacity: 0.7;
    }

    .import-file-input {
        display: none;
    }

    .file-upload-wrapper {
        position: relative;
    }

    .file-preview {
        display: none;
    }

    button[type="submit"] {
        padding: 12px 24px;
        font-weight: 600;
        letter-spacing: 0.5px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    button[type="submit"]:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }

    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 8px 8px 0 0;
        padding: 20px;
    }

    .card {
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .card-body {
        padding: 30px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #333;
    }

    .tabs.quick-links li a.tab {
        padding: 10px 18px;
        border-radius: 6px;
        transition: all 0.3s ease;
        border-bottom: 3px solid transparent;
    }

    .tabs.quick-links li a.tab:hover {
        background-color: #f0f0f0;
        color: #0d6efd;
    }

    .tabs.quick-links li a.tab.active {
        background-color: #0d6efd;
        color: white;
        border-bottom-color: #0d6efd;
    }
</style>
<?= $this->endsection(); ?>
<?= $this->section('content') ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row page-title-header">
            <div class="col-12">
                <div class="page-header">
                    <h4 class="page-title">นำเข้าข้อมูลผู้ป่วยรายใหม่</h4>
                    <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
                        <ul class="tabs quick-links ml-auto">
                            <li><a href="#" rel="#dm_chronic" class="tab active">ผู้ป่วย DM ใหม่</a></li>
                            <li><a href="#" rel="#ht_chronic" class="tab">ผู้ป่วย HT ใหม่</a></li>
                        </ul>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="tab_contents_container">
                    <div class="tab_contents tab_contents_active" id="dm_chronic">
                        <div class="col-md-12 grid-margin">
                            <div class="card">
                                <div class="card-header bg-primary text-body">
                                    นำเข้าไฟล์ <b>ผู้ป่วยโรคเบาหวานรายใหม่</b> ที่ดาวน์โหลดจาก DataExchange HDC หลังจากแตก
                                    zip ไฟล์เรียบร้อยแล้ว
                                </div>

                                <div class="card-body">
                                    <form class="import-form" data-route="importnewDM" data-input="excelFile">
                                        <div class="file-upload-wrapper">
                                            <div class="file-upload-area" id="dmNewDropArea">
                                                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                                <h5 class="mt-3 mb-2">ลากไฟล์มาวางที่นี่</h5>
                                                <p class="text-muted mb-3">หรือคลิกเพื่อเลือกไฟล์ Excel (.csv/.xls/.xlsx)</p>
                                                <input type="file" class="import-file-input" name="excelFile"
                                                    accept=".csv,.xls,.xlsx" required>
                                            </div>
                                            <div class="file-preview mt-3" id="dmNewPreview">
                                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                                    <i class="fas fa-file-check text-success me-3" style="font-size: 1.5rem;"></i>
                                                    <div>
                                                        <p class="mb-0 fw-bold" id="dmNewName"></p>
                                                        <small class="text-muted" id="dmNewSize"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100 mt-4"><i class="fas fa-upload me-2"></i>นำเข้าข้อมูล</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab_contents" id="ht_chronic">
                        <div class="col-md-12 grid-margin">
                            <div class="card">
                                <div class="card-header bg-success">
                                    นำเข้าไฟล์ <b>ผู้ป่วยโรคความดันโลหิตสูงรายใหม่</b> ที่ดาวน์โหลดจาก DataExchange HDC
                                    หลังจากแตก zip ไฟล์เรียบร้อยแล้ว
                                </div>

                                <div class="card-body">
                                    <form class="import-form" data-route="importnewHT" data-input="excelFile2">
                                        <div class="file-upload-wrapper">
                                            <div class="file-upload-area" id="htNewDropArea">
                                                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                                <h5 class="mt-3 mb-2">ลากไฟล์มาวางที่นี่</h5>
                                                <p class="text-muted mb-3">หรือคลิกเพื่อเลือกไฟล์ Excel (.csv/.xls/.xlsx)</p>
                                                <input type="file" class="import-file-input" name="excelFile2"
                                                    accept=".csv,.xls,.xlsx" required>
                                            </div>
                                            <div class="file-preview mt-3" id="htNewPreview">
                                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                                    <i class="fas fa-file-check text-success me-3" style="font-size: 1.5rem;"></i>
                                                    <div>
                                                        <p class="mb-0 fw-bold" id="htNewName"></p>
                                                        <small class="text-muted" id="htNewSize"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100 mt-4"><i class="fas fa-upload me-2"></i>นำเข้าข้อมูล</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> <!--end HT-->
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endsection(); ?>
<?=  $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('#ht_chronic').hide();
    $('.tab').click(function(e) {
        e.preventDefault();
        var activeTabId = $(this).attr('rel');
        $('.tab_contents').hide().removeClass('tab_contents_active');
        $(activeTabId).show().addClass('tab_contents_active');
        $('.tab').removeClass('active');
        $(this).addClass('active');
    });

    // Generic submission
    $('.import-form').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        var route = $(this).data('route');
        var inputName = $(this).data('input');
        var fileInput = $(this).find('input[name="' + inputName + '"]')[0];
        console.log(formData);
        if (!fileInput.files.length) {
            Swal.fire('ข้อผิดพลาด', 'กรุณาเลือกไฟล์', 'error');
            return;
        }

        Swal.fire({
            title: 'กำลังนำเข้าข้อมูล...',
            text: 'กรุณารอสักครู่',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        $.ajax({
            url: "<?= base_url('public/importData/') ?>" + route,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'นำเข้าข้อมูลสำเร็จ!',
                        text: res.msg + " " + (res.records || res.reccord || 0) + " ราย",
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = "<?= base_url('public/importData/importNewPatient') ?>";
                    });
                } else {
                    Swal.fire('ข้อผิดพลาด', res.msg, 'warning');
                }
            },
            error: function(xhr) {
                Swal.fire('ข้อผิดพลาด', 'เกิดปัญหาในการนำเข้าข้อมูล', 'error');
            }
        });
    });

    function formatBytes(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const dm = 2;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }

    function setupFileUpload(areaId, inputName, previewId, nameField, sizeField) {
        const dropArea = document.getElementById(areaId);
        const fileInput = dropArea.querySelector('input[type="file"]');
        const preview = document.getElementById(previewId);
        const nameEl = document.getElementById(nameField);
        const sizeEl = document.getElementById(sizeField);

        const validExtensions = ['csv', 'xls', 'xlsx'];
        const maxSize = 10 * 1024 * 1024;

        function handleFiles(files) {
            const file = files[0];
            const ext = file.name.split('.').pop().toLowerCase();
            if (!validExtensions.includes(ext)) {
                Swal.fire('Invalid', 'ไฟล์ต้องเป็น .csv, .xls หรือ .xlsx เท่านั้น', 'error');
                fileInput.value = '';
                return;
            }
            if (file.size > maxSize) {
                Swal.fire('Invalid', 'ขนาดไฟล์ต้องไม่เกิน 10MB', 'error');
                fileInput.value = '';
                return;
            }
            nameEl.textContent = file.name;
            sizeEl.textContent = formatBytes(file.size);
            preview.style.display = 'block';
        }

        dropArea.addEventListener('click', () => fileInput.click());
        dropArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropArea.classList.add('drag-over');
        });
        dropArea.addEventListener('dragleave', () => {
            dropArea.classList.remove('drag-over');
        });
        dropArea.addEventListener('drop', (e) => {
            e.preventDefault();
            dropArea.classList.remove('drag-over');
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                handleFiles(e.dataTransfer.files);
            }
        });

        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length) {
                handleFiles(e.target.files);
            }
        });
    }

    setupFileUpload('dmNewDropArea', 'excelFile', 'dmNewPreview', 'dmNewName', 'dmNewSize');
    setupFileUpload('htNewDropArea', 'excelFile2', 'htNewPreview', 'htNewName', 'htNewSize');
});
</script>
<?= $this->endsection(); ?>