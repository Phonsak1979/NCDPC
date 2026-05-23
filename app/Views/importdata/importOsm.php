<?= $this->extend('layouts/main_layout') ?>
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
<?= $this->section('content'); ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row page-title-header">
            <div class="col-12">
                <div class="page-header">
                    <h4 class="page-title">อาสมัครในเขตรับผิดชอบ</h4>
                    <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
                        <ul class="tabs quick-links ml-auto">
                            <li><a href="#" rel="#tab_osm" class="tab">อสม.</a></li>
                        </ul>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="tab_contents_container">
                    <div class="tab_contents tab_contents_active" id="tab_osm">
                        <div class="col-md-12 grid-margin">
                            <div class="card">
                                <div class="card-header bg-primary text-default">
                                    นำเข้าไฟล์ <b>ข้อมูล อสม.</b> ที่ดาวน์โหลดจาก Thaiphc 
                                </div>

                                <div class="card-body">
                                    <form class="import-form" data-route="importDataOsm" data-input="excelFile3">
                                        <div class="file-upload-wrapper">
                                            <div class="file-upload-area" id="osmDropArea">
                                                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                                <h5 class="mt-3 mb-2">ลากไฟล์มาวางที่นี่</h5>
                                                <p class="text-muted mb-3">หรือคลิกเพื่อเลือกไฟล์ Excel (.csv/.xls/.xlsx)</p>
                                                <input type="file" class="import-file-input" name="excelFile3"
                                                    accept=".csv,.xls,.xlsx" required>
                                            </div>
                                            <div class="file-preview mt-3" id="osmPreview">
                                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                                    <i class="fas fa-file-check text-success me-3" style="font-size: 1.5rem;"></i>
                                                    <div>
                                                        <p class="mb-0 fw-bold" id="osmName"></p>
                                                        <small class="text-muted" id="osmSize"></small>
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
<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    get_tb_osm();
$('.tab').on('click', function(e) {
            e.preventDefault();
            var activeTabId = $(this).attr('rel');
            $('.tab').removeClass('active');
            $(this).addClass('active');
            $('.tab_contents').hide().removeClass('tab_contents_active');
            $(activeTabId).show().addClass('tab_contents_active');

            // load data for the newly active pane if necessary
            if (activeTabId === '#tab_osm') {
                get_tb_osm();
            } else if (activeTabId === '#tab_hcoach') {
                get_tb_hcoach();
            }
        });

        // activate first tab on load
        $('.tab').first().trigger('click');


    $('.import-form').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData($(this)[0]);
        var route = $(this).data('route');
        var inputName = $(this).data('input');
        var fileInput = $(this).find('input[name="' + inputName + '"]')[0];

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
                        window.location.href = "<?= base_url('public/importData/importOSM') ?>";
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
    setupFileUpload('osmDropArea', 'excelFile3', 'osmPreview', 'osmName', 'osmSize');
        // you can enable the following line if you add a second import tab
        // setupFileUpload('hcDropArea', 'excelFile2', 'hcPreview', 'hcName', 'hcSize');
    // helper to initialize tables with the same column layout
    function initDataTable(selector, url) {
        return $(selector).DataTable({
            destroy: true,
            processing: false,
            serverSide: false,
            searching: false,
            paging: true,
            ajax: {
                url: url,
                dataSrc: ''
            },
            columns: [
                {
                    title: 'ลำดับ',
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    },
                    width: 10
                },
                { title: 'เลขบัตร ปชช.', data: 'cid',
                    'render': function(data, type, row) {
                    return data.substr(0, 5) + data
                        .substr(6, 4).replace(/./g, '*') + data.substr(10, 2) + data
                        .substr(12, 1).replace(/./g, '*');
                    }
                },
                { title: 'ชื่อ-นามสกุล', data: function(data){ 
                     return data.prename+data.fname+' '+data.lname; 
                    },
                },
                { title: 'วดป.เกิด', data: 'birth' },
                { title: 'หน่วยบริการ', data: 'hcode' },
                { title: 'ปีที่เป็น อสม.', data: 'osm_year' },
                { title: 'เบอร์โทรศัพท์', data: 'tel' }
            ]
        });
    }

    function get_tb_osm() {
        return initDataTable('#tb_osm', '<?= base_url('public/setting/get_osm') ?>');
    }

    function get_tb_hcoach() {
        return initDataTable('#tb_hcoach', '<?= base_url('public/setting/get_hcoach') ?>');
    }
});
</script>
<?= $this->endsection(); ?>