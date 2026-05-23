<?= $this->extend('layouts/main_layout'); ?>
<?= $this->section('styles');?>
<?= $this->endsection(); ?>
<?= $this->section('content'); ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row page-title-header">
            <div class="col-12">
                <div class="page-header">
                    <h4 class="page-title">คัดกรองเบาหวาน (DM)</h4>
                    <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
                        <ul class="tabs quick-links ml-auto">
                            <li><a href="#" rel="#screened_dm" class="tab active">คัดกรองปีปัจจุบัน</a></li>
                            <li><a href="#" rel="#non_screened_dm" class="tab">ยังไม่ได้คัดกรอง</a></li>
                        </ul>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="row">
            <div class="tab_contents_container">
                <div id="screened_dm" class="tab_contents tab_contents_active">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">บุคคลที่ผ่านการตรวจสุขภาพแล้วปีนี้</h3>
                            <br>
                            <div class="col-12 d-flex justify-content-between">
                                <div class="col-md-6 d-flex justify-content-between">
                                    <label for="selehcode" class="form-label">หน่วยบริการ :</label>
                                    <select id="selehcode" class="form-control">
                                        <option value="0">ทั้งหมด</option>
                                        <?php if(!empty($seleoffice)):foreach($seleoffice as $off): ?>
                                        <option value="<?= $off['hcode'] ?>"><?= $off['hname'] ?></option>
                                        <?php endforeach;endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-4 d-flex justify-content-center">
                                    <label for="chart-riskDm" class="form-label">หมู่บ้าน</label>
                                    <select id="villselect" class="form-control">
                                        <option value="">ทั้งหมด</option>
                                    </select>
                                </div>
                                <div class="col-md-2 d-flex justify-content-end">
                                    <button id="export_screen_dm" class="btn btn-success">ค้นหา</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="screen_dm_table">

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="non_screened_dm" class="tab_contents">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">บุคคลที่ยังไม่ได้รับการตรวจสุขภาพ</h3>
                            <br>
                            <div class="col-12 d-flex justify-content-between">
                                <div class="col-md-6 d-flex justify-content-between">
                                    <label for="selehcode2" class="form-label">หน่วยบริการ :</label>
                                    <select id="selehcode2" class="form-control">
                                        <option value="0">ทั้งหมด</option>
                                        <?php if(!empty($seleoffice)):foreach($seleoffice as $off): ?>
                                        <option value="<?= $off['hcode'] ?>"><?= $off['hname'] ?></option>
                                        <?php endforeach;endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-4 d-flex justify-content-center">
                                    <label for="chart-riskDm" class="form-label">หมู่บ้าน</label>
                                    <select id="villselect2" class="form-control">
                                        <option value="">ทั้งหมด</option>
                                    </select>
                                </div>
                                <div class="col-md-2 d-flex justify-content-end">
                                    <button id="export_non_screen_dm" class="btn btn-success">ค้นหา</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div>
                                <div class="table-responsive">
                                    <table class="table table-hover" id="non_screen_dm_table">

                                    </table>
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
<?= $this->section('scripts'); ?>
<script>
$(document).ready(function() {
    // Tab click event
    $('#non_screened_dm').hide();
    $('.tab').click(function(e) {
        e.preventDefault();
        var activeTabId = $(this).attr('rel');
        $('.tab_contents').hide().removeClass('tab_contents_active');
        $(activeTabId).show().addClass('tab_contents_active');
        $('.tab').removeClass('active');
        $(this).addClass('active');
    });
    $('#selehcode').on('change', function() {
        get_village_by_hcode();
    });
    $('#export_screen_dm').on('click', function(e) {
        e.preventDefault();
        render_screen_dm_table();
    });
    $('#selehcode2').on('change', function() {
        get_village_by_hcode2();
    });
    $('#export_non_screen_dm').on('click', function(e) {
        e.preventDefault();
        render_non_screen_dm_table();
    });
});

function render_screen_dm_table() {
    const hcode = $('#selehcode').val();
    const villcode = $('#villselect').val();

    $('#screen_dm_table').DataTable({
        "destroy": true,
        "serching": true,
        "pageLength": 15,
        "paging": true,
        "processing": false,
        "serverSide": false,
        "ajax": {
            "url": "<?= base_url('public/screenData/fecth_screen_dm/') ?>"+hcode+'/'+villcode,
            'dataSrc': ""
        },
        "columns": [{
                title: 'ลำดับ',
                data: null,
                render: function(data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                'title': 'ชื่อ-สกุล',
                'data': 'name'
            },
            {
                'title': 'อายุ',
                'data': 'age'
            },
            {
                    'title': 'หมู่บ้าน',
                    'data': 'check_vhid',
            },
            {
                'title': 'Type',
                'data': 'typearea'
            },
            {
                'title': 'วันที่คัดกรอง',
                'data': 'date_screen'
            },
            {
                'title': 'ระดับน้ำตาลในเลือด',
                'data': 'bslevel'
            },
            {
                'title': 'ความเสี่ยง',
                'data': 'risk'
            },
            {
                'title': 'ผลการคัดกรอง',
                'data': 'result'
            },
            {
                'title': 'หน่วยคัดกรอง',
                'data': 'hosp_screen'
            },
            {
                'title': 'หน่วยบันทึก',
                'data': 'hosp_input'
            }
        ],
        "order": [
            [4, "desc"]
        ],
        "lengthMenu": [
            [10, 25, 50],
            [10, 25, 50]
        ],
        "language": {
            "search": "ค้นหา:",
            "lengthMenu": "แสดง _MENU_ รายการ",
            "info": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
            "paginate": {
                "first": "หน้าแรก",
                "last": "หน้าสุดท้าย",
                "next": "ถัดไป",
                "previous": "ก่อนหน้า"
            },
            "processing": "กำลังโหลด..."
        }
    });
}

function render_non_screen_dm_table(data) {
    const hcode = $('#selehcode2').val();
    const villcode = $('#villselect2').val();

    $('#non_screen_dm_table').DataTable({
        "destroy": true,
        "serching": true,
        "pageLength": 15,
        "paging": true,
        "processing": false,
        "serverSide": false,
        "ajax": {
            "url": "<?= base_url('public/screenData/fecth_non_screen_dm') ?>"+hcode+'/'+villcode,
            'dataSrc': ""
        },
        "columns": [{
                title: 'ลำดับ',
                data: null,
                render: function(data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                'title': 'ชื่อ-สกุล',
                'data': 'name'
            },
            {
                'title': 'อายุ',
                'data': 'age'
            },
            {
                'title': 'Type',
                'data': 'typearea'
            },
        ],
        "lengthMenu": [
            [10, 25, 50],
            [10, 25, 50]
        ],
        "language": {
            "search": "ค้นหา:",
            "lengthMenu": "แสดง _MENU_ รายการ",
            "info": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
            "paginate": {
                "first": "หน้าแรก",
                "last": "หน้าสุดท้าย",
                "next": "ถัดไป",
                "previous": "ก่อนหน้า"
            },
            "processing": "กำลังโหลด..."
        }
    });
}

function get_village_by_hcode() {
    const hcode = $('#selehcode').val();
    $.ajax({
        url: '<?= base_url('public/fetchRisk/get_village_by_hcode/') ?>' + hcode,
        type: 'POST',
        dataType: 'json',
        success: function(res) {
            console.log(res);
            $villselect = '<option value="">ทั้งหมด</option>';
            $.each(res, function(index, item) {
                $villselect += '<option value="' + item.villcode + '">' + item.villname +
                    '</option>';
            });
            $('#villselect').html($villselect);
        },
        error: function(xhr, status, error) {
            console.error(error + ':' + xhr.responseText);
            if (status = 500) {
                swal.fire('warning', 'มีปัญหาในการส่งข้อมูลรายนี', "warning");
                return false;
            }
        }
    });
}
function get_village_by_hcode2() {
    const hcode = $('#selehcode2').val();
    $.ajax({
        url: '<?= base_url('public/fetchRisk/get_village_by_hcode/') ?>' + hcode,
        type: 'POST',
        dataType: 'json',
        success: function(res) {
            console.log(res);
            $villselect = '<option value="">ทั้งหมด</option>';
            $.each(res, function(index, item) {
                $villselect += '<option value="' + item.villcode + '">' + item.villname +
                    '</option>';
            });
            $('#villselect2').html($villselect);
        },
        error: function(xhr, status, error) {
            console.error(error + ':' + xhr.responseText);
            if (status = 500) {
                swal.fire('warning', 'มีปัญหาในการส่งข้อมูลรายนี', "warning");
                return false;
            }
        }
    });
}

function dateThai(date, format = 'full') {
    const d = new Date(date);

    // ตั้งค่า Options ตามความต้องการ
    const options = {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    };

    // ใช้ 'th-TH' เพื่อดึง Format ไทย (พ.ศ. จะถูกคำนวณให้อัตโนมัติ)
    return new Intl.DateTimeFormat('th-TH', options).format(d);
}
</script>

<?= $this->endsection(); ?>
</body>

</html>