<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('title') ?>
HL COACH
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row page-title-header">
            <div class="col-12">
                <div class="page-header">
                    <h4 class="page-title">นักจัดการความรอบรู้ด้านสุขภาพ (HL-Coach)
                        <?= esc($user->hcode).":".esc($office->hname) ?></h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-header">
                        <form id="frmHcoach" enctype="multipart/form-data">
                            <div class="form-group d-flex justify-content-between">
                                <label for="txtcid" class="col-2 mt-2">เลขบัตร ปชช.อสม.</label>
                                <input type="text" id="txtcid" class="form-control me-1" name="txtcid">
                                <button type="submit" class="btn btn-primary me-2">ค้นหา</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="col-12 d-flex justify-content-between">
                            <div class="col-5">
                                <form id="frm_hdetail" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="txtcid2">เลขบัตร ปชช.</label>
                                        <input type="text" id="txtcid2" class="form-control" name="txtcid2" require>
                                    </div>
                                    <div class="form-group">
                                        <label for="txtname">ชื่อ-นามสกุล</label>
                                        <input type="text" id="txtname" class="form-control" name="txtname" require>
                                    </div>
                                    <div class="form-group">
                                        <label for="txthcode">หน่วยบริการ</label>
                                        <input type="text" id="txthcode" class="form-control" name="txthcode" require>
                                    </div>
                                    <div class="form-group">
                                        <label for="txtdob">วันเกิด</label>
                                        <input type="text" id="txtdob" class="form-control" name="txtdob" >
                                    </div>
                                    <div class="form-group">
                                        <label for="txttel">เบอร์โทรศัพท์</label>
                                        <input type="text" id="txttel" class="form-control" name="txttel" >
                                    </div>
                                    <div class="form-group">
                                        <label for="txtaccnumber">เลขบัญชีธนาคาร</label>
                                        <input type="text" id="txtaccnumber" class="form-control" name="txtaccnumber" >
                                    </div>
                                    <div class="form-group">
                                        <label for="txtbank">ธนาคาร</label>
                                        <input type="text" id="txtbank" class="form-control" name="txtbank" >
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-submit">บันทึก</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-7">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>นักจัดการความรอบรู้ด้านสุขภาพ</h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered" id="hcoachTableBody">
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
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
     getHl_table();
    $('#frmHcoach').submit(function(e) {
        e.preventDefault();
        const frmData = new FormData($(this)[0]);
        //alert(frmData.get('txtcid')); // ตรวจสอบค่าที่ส่งไปยังเซิร์ฟเวอร์
        $.ajax({
            url: '<?= base_url('public/hcoach/hcoach-Data') ?>',
            type: 'post',
            data: frmData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status == 'success') {
                    var data = response.data;
                    $('#txtcid2').val(data.cid);
                    $('#txtname').val(data.prename+data.fname+" "+data.lname);
                    $('#txthcode').val(data.hcode);
                    $('#txtdob').val(data.birth);
                    $('#txttel').val(data.tel);
                    $('#txtaccnumber').val(data.acc_number);
                    $('#txtbank').val(data.bank);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: response.msg
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'เกิดข้อผิดพลาด: ' + xhr.status  +':'+ error
                });
            }
        });
    });
    $('#frm_hdetail').submit(function(e) {
        e.preventDefault();
        const formData = new FormData($(this)[0]);
        //alert(formData); // ตรวจสอบค่าที่ส่งไปยังเซิร์ฟเวอร์
        $.ajax({
            url: '<?= base_url('public/hcoach/save-hcoach') ?>',
            type: 'post',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'บันทึกสำเร็จ',
                        text: response.msg
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: response.msg
                    });
                }
                $('#frm_hdetail')[0].reset();
                $('#frmHcoach')[0].reset();
                getHl_table(); // รีโหลดตารางหลังจากบันทึกสำเร็จ
            },
            error: function(xhr, status, error) {
                switch (xhr.status) {
                    case 422:
                        var errors = xhr.responseJSON.errors;
                        var errorMessages = Object.values(errors).flat().join('\n');
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: errorMessages
                        });
                        break;
                    case 400:
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: xhr.responseJSON.msg
                        });
                        break;
                    case 500:
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: 'รายนี้บันทึกในฐานข้อมูลเรียบร้อยแล้ว'
                        });
                        break;
                    default:
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: 'เกิดข้อผิดพลาดที่ไม่คาดคิด: ' + xhr.status  +':'+ error
                        });
                }
            }
        });
    });
    
});
function getHl_table() {
    $('#hcoachTableBody').DataTable(
        {
            "destroy": true,
            "searching": true,
            "processing": true,
            "serverSide": true,
            "pageLength": 10,
            "ajax": {
                "url": "<?= base_url('public/hcoach/fetch-hcoach') ?>",
                "dataSrc": ""
            },
            "columns": [
                { "title": "เลขบัตร ปชช.", "data": "cid" },
                { "title": "ชื่อ-นามสกุล", "data": "hcoachname" },
                { "title": "หน่วยบริการ", "data": "hcode" },
                { "title": "เบอร์โทรศัพท์", "data": "tel" },
                { "title": "แก้ไข", "data": "id", "render": function(data, type, row) {
                    return '<button class="btn btn-sm btn-primary edit-btn" data-id="' + data + '">แก้ไข</button>';
                }},
                { "title": "ลบ", "data": "id", "render": function(data, type, row) {
                    return '<button class="btn btn-sm btn-danger delete-btn" data-id="' + data + '">ลบ</button>';
                }}
            ]
        }
    );
}
$(document).on('click', '.edit-btn', function() {
    var id = $(this).data('id');
    //alert(id); // ตรวจสอบ ID ที่ถูกส่งไปยังเซิร์ฟเวอร์
    $.ajax({
        url: '<?= base_url('public/hcoach/get-hcoach/') ?>' + id,
        type: 'get',
        success: function(response) {
            if (response.status == 'success') {
                var data = response.data;
                $('#txtcid2').val(data.cid);
                $('#txtname').val(data.hcoachname);
                $('#txthcode').val(data.hcode);
                $('#txtdob').val(data.birth);
                $('#txttel').val(data.tel); 
                $('#txtaccnumber').val(data.acc_number);
                $('#txtbank').val(data.bank);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: response.msg
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: 'เกิดข้อผิดพลาด: ' + xhr.status  +':'+ error
            });
        }
    });
});
$(document).on('click', '.delete-btn', function() {
    var id = $(this).data('id');
    Swal.fire({
        title: 'คุณแน่ใจหรือไม่?',
        text: "คุณต้องการลบข้อมูลนี้หรือไม่?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช่, ลบเลย!',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url('public/hcoach/delete-hcoach/') ?>' + id,
                type: 'post',
                success: function(response) {
                    if (response.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'ลบสำเร็จ',
                            text: response.msg
                        });
                        getHl_table(); // รีโหลดตารางหลังจากลบสำเร็จ
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: response.msg
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: 'เกิดข้อผิดพลาดที่ไม่คาดคิด: ' + xhr.status  +':'+ error
                    });
                }
            });
        }
    });
});
</script>
<?= $this->endSection() ?>
</body>

</html>
                      