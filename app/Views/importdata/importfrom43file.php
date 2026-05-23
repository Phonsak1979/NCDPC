<?= $this->extend('layouts/main_layout'); ?>
<?= $this->section('styles'); ?>
<style>
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

    button[type="submit"]:active {
        transform: translateY(0);
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
                    <h4 class="page-title">นำเข้าข้อมูลจากแฟ้ม 43</h4>
                    <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
                        <ul class="tabs quick-links ml-auto">
                            <li><a href="#" rel="#person" class="tab">ประชากร</a></li>
                            <li><a href="#" rel="#home" class="tab">หลังคาเรือน</a></li>
                        </ul>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="tab_contents_container">
                    <div class="tab_contents tab_contents_active" id="person">
                        <div class="col-md-12 grid-margin">
                            <div class="card">
                                <div class="card-header bg-primary text-default">
                                    นำเข้าไฟล์ <b>ประชากร</b> จาก 43 แฟ้มมาตรฐาน person.txt
                                </div>

                                <div class="card-body">
                                    <form class="import-form" data-route="importPersonData" data-input="textFile">
                                        <div class="file-upload-wrapper">
                                            <div class="file-upload-area" id="fileDropArea">
                                                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                                <h5 class="mt-3 mb-2">ลากไฟล์มาวางที่นี่</h5>
                                                <p class="text-muted mb-3">หรือคลิกเพื่อเลือกไฟล์ (สูงสุด 2 MB)</p>
                                                <input type="file" class="import-file-input" name="textFile"
                                                    accept=".txt,.csv,.xlsx,.xls" required>
                                            </div>
                                            <div class="file-preview mt-3" id="filePreview" style="display: none;">
                                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                                    <i class="fas fa-file-check text-success me-3" style="font-size: 1.5rem;"></i>
                                                    <div>
                                                        <p class="mb-0 fw-bold" id="fileName"></p>
                                                        <small class="text-muted" id="fileSize"></small>
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
                    <div class="tab_contents" id="home">
                        <div class="col-md-12 grid-margin">
                            <div class="card">
                                <div class="card-header bg-success">
                                    นำเข้าไฟล์ <b>หลังคาเรือน</b> จาก 43 แฟ้มมาตรฐาน home.txt
                                </div>

                                <div class="card-body">
                                    <form class="import-form" data-route="importHomeData" data-input="textFile">
                                        <div class="file-upload-wrapper">
                                            <div class="file-upload-area" id="fileDropArea2">
                                                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                                <h5 class="mt-3 mb-2">ลากไฟล์มาวางที่นี่</h5>
                                                <p class="text-muted mb-3">หรือคลิกเพื่อเลือกไฟล์ (สูงสุด 2 MB)</p>
                                                <input type="file" class="import-file-input" name="textFile"
                                                    accept=".txt,.csv,.xlsx,.xls" required>
                                            </div>
                                            <div class="file-preview mt-3" id="filePreview2" style="display: none;">
                                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                                    <i class="fas fa-file-check text-success me-3" style="font-size: 1.5rem;"></i>
                                                    <div>
                                                        <p class="mb-0 fw-bold" id="fileName2"></p>
                                                        <small class="text-muted" id="fileSize2"></small>
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
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endsection(); ?>
<?=  $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Initialize: hide non-active tabs
    $('#home').hide();

    // Tab switcher
    $('.tab').click(function(e) {
        e.preventDefault();
        var activeTabId = $(this).attr('rel');

        // Hide all tabs, show clicked tab
        $('.tab_contents').hide().removeClass('tab_contents_active');
        $(activeTabId).show().addClass('tab_contents_active');

        // Update active tab styling
        $('.tab').removeClass('active');
        $(this).addClass('active');
    });

    // File upload handler for all forms
    function setupFileUpload(dropAreaId, previewId, fileNameId, fileSizeId) {
        var dropArea = $('#' + dropAreaId);
        var filePreview = $('#' + previewId);
        var fileNameEl = $('#' + fileNameId);
        var fileSizeEl = $('#' + fileSizeId);
        var fileInput = dropArea.find('.import-file-input')[0];

        // Click to browse files
        dropArea.on('click', function() {
            fileInput.click();
        });

        // Handle file selection
        $(fileInput).on('change', function() {
            if (this.files.length > 0) {
                displayFileInfo(this.files[0], filePreview, fileNameEl, fileSizeEl);
            }
        });

        // Drag and drop
        dropArea.on('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            dropArea.addClass('drag-over');
        });

        dropArea.on('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            dropArea.removeClass('drag-over');
        });

        dropArea.on('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            dropArea.removeClass('drag-over');

            var files = e.originalEvent.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                displayFileInfo(files[0], filePreview, fileNameEl, fileSizeEl);
            }
        });
    }

    // Display file information
    function displayFileInfo(file, previewEl, nameEl, sizeEl) {
        nameEl.text(file.name);
        sizeEl.text(formatFileSize(file.size));
        previewEl.show();
    }

    // Format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }

    // Setup file uploads for all forms
    setupFileUpload('fileDropArea', 'filePreview', 'fileName', 'fileSize');
    setupFileUpload('fileDropArea2', 'filePreview2', 'fileName2', 'fileSize2');

    // Unified form handler
    $('.import-form').on('submit', function(e) {
        e.preventDefault();

        var inputName = $(this).data('input');
        var fileInput = $(this).find('input[name="' + inputName + '"]')[0];

        // Validate file input exists
        if (!fileInput.files.length) {
            Swal.fire('ข้อผิดพลาด', 'กรุณาเลือกไฟล์', 'error');
            return;
        }

        var file = fileInput.files[0];
        var route = $(this).data('route');

        // Validate file size (max 2MB)
        var maxSize = 2 * 1024 * 1024; // 2MB
        if (file.size > maxSize) {
            Swal.fire('ข้อผิดพลาด', 'ไฟล์ มีขนาดใหญ่เกินไป (สูงสุด 2 MB)', 'error');
            return;
        }

        // Validate file type
        var allowedExtensions = ['txt', 'csv', 'xlsx', 'xls'];
        var fileExtension = file.name.split('.').pop().toLowerCase();
        if (allowedExtensions.indexOf(fileExtension) === -1) {
            Swal.fire('ข้อผิดพลาด', 'ไฟล์ไม่ถูกต้อง อนุญาตเฉพาะ: ' + allowedExtensions.join(', '), 'error');
            return;
        }

        // All validations passed - now show loading and send
        Swal.fire({
            title: 'กำลังนำเข้าข้อมูล...',
            text: 'กรุณารอสักครู่',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Create FormData and send
        var formData = new FormData($(this)[0]);
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
                        window.location.href = "<?= base_url('public/importData/import43file') ?>";
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
});
</script>
<?= $this->endsection(); ?>