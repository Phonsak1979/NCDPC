<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('content'); ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row page-title-header">
            <div class="col-12">
                <div class="page-header">
                    <h4 class="page-title">หน่วยบริการในสังกัด</h4>
                    <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
                        <ul class="tabs quick-links ml-auto">
                            <li><a href="#" rel="#dm_risk" class="tab">กลุ่มเสี่ยงรายบุคคล</a></li>
                            <li><a href="#" rel="#inproj_dm_risk" class="tab">กลุ่มเป้าหมายโครงการ</a></li>
                            <li><a href="#" rel="#hl_dm" class="tab">Health literacy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="card col-12">
                        <table id="tb_office"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="officeModal" tabindex="-1" role="dialog" aria-labelledby="officeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="officeModalLabel">เพิ่มหน่วยงาน</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>รหัสหน่วยงาน (HCODE):</strong> <span id="modalHcode"><input type="text" class="form-control"
                            name="hcode" id="hcode"></span></p>
                <p><strong>ชื่อหน่วยงาน (HNAME):</strong> <span id="modalHname"><input type="text" class="form-control"
                            name="hname" id="hname"></span></p>
                <p><strong>ประเภทหน่วยงาน (HTYPE):</strong> <span id="modalHtype"><select name="htype"
                            class="form-control" id="htype">
                            <option value="">เลือกประเภทหน่วยงาน</option>
                            <option value="สสอ.">สำนักงานสาธารณสุขอำเภอ</option>
                            <option value="รพ.">โรงพยาบาล</option>
                            <option value="รพ.สต.">รพ.สต.</option>
                            <option value="อปท.">เทศบาล/อบต.</option>
                        </select></span></p>
                <p><strong>สังกัด:</strong> <span id="modalHdepart"><select name="hdepart" class="form-control"
                            id="hdepart">
                            <option value="สธ.">กระทรวงสาธารณสุข</option>
                            <option value="อบจ.">องค์การบริหารส่วนจังหวัด</option>
                            <option value="อปท.">องค์การปกครองส่วนท้องถิ่น</option>
                            <option value="อื่นๆ">อื่นๆ</option>
                        </select></span></p>
                <p><strong>รหัสตำบล(6 หลัก):</strong> <span id="modalHdepart"><input type="text" class="form-control" name="tumbon" id="tumbon"></span></p>
                <p><strong>รหัสอำเภอ(4 หลัก):</strong> <span id="modalHdepart"><input type="text" class="form-control" name="ampname" id="ampname"></span></p>
                <p><strong>รหัสจังหวัด(2 หลัก):</strong> <span id="modalHdepart"><input type="text" class="form-control" name="province" id="province"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSaveOffice" class="btn btn-primary">บันทึก</button>
                <button type="button" id="btnCloseOffice" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
    <?= $this->endsection(); ?>
    <?= $this->section('scripts') ?>
    <script>
    $(document).ready(function() {
        $('#tb_office').DataTable({
            ajax: {
                url: '<?= base_url('public/setting/get_office') ?>',
                dataSrc: '',
            },
            columns: [{
                    title: 'ลำดับ',
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    title: 'รหัส',data: 'hcode'
                },
                {
                    title: 'ชื่อหน่วยงาน' ,data: 'hname'
                },
                {
                    title: 'ประเภท' ,data: 'htype'
                },
                {
                    title: 'สังกัด' ,data: 'hdepart'
                },
                {
                    title: 'ตำบล' ,data: 'tmb_code'
                },
                {
                    title: 'อำเภอ' ,data: 'amp_code'
                },
                {
                    title: 'จังหวัด' ,data: 'chw_code'
                },
                {
                    data: 'hcode',
                    render: function(data, type, row) {
                        return '<button class="btn btn-danger btn-sm m-1"  data-id="' + data + '">ลบ</button>';
                    }
                }
            ],
            layout: {
                topStart: {
                    buttons: [{
                        text: 'เพิ่มรายการใหม่',
                        className: 'btn btn-primary my-custom-class',
                        action: function(e, dt, node, config) {
                            $.fn.addNewfunction();
                        }
                    }]
                }
            },
        });
         $.fn.addNewfunction = function() {
            swal.fire({
                title: "ต้องการเพิ่มรายการใหม่หรือไม่?",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: "ตกลง",
                cancelButtonText: "ยกเลิก"
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#officeModal').modal('show');
                }
            });
        };                                
        $('#btnSaveOffice').on('click', function() {
            let hcode = $('#hcode').val();
            let hname = $('#hname').val();
            let htype = $('#htype').val();
            let hdepart = $('#hdepart').val();
            let tumbon = $('#tumbon').val();
            let ampname = $('#ampname').val();
            let province = $('#province').val();
            $.ajax({
                url: '<?= base_url('public/setting/addOffice') ?>',
                type: "post",
                data: {
                    hcode: hcode,
                    hname: hname,
                    htype: htype,
                    hdepart: hdepart,
                    tumbon: tumbon,
                    ampname: ampname,
                    province: province
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#officeModal').modal('hide');
                        swal.fire(response.status, response.msg, response.status);
                         $('#tb_office').DataTable().ajax.reload();
                    } else {
                        swal.fire(response.status, response.msg, response.status);
                        return false;
                    }
                },
                error: function(xhr, status, error) {
                    //console.error(error);
                    swal.fire('ผิดพลาด', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล'+xhr.responseText, 'error');
                    $('#officeModal').modal('hide');
                    $('#tb_office').DataTable().ajax.reload();
                }
            });
        });
         $('#btnCloseOffice').on('click', function() {
             $('#officeModal').modal('hide');
        });
        $('#tb_office').on('click', '.btn-danger', function() {
            let hcode = $(this).data('id');
            swal.fire({
                title: "ต้องการลบข้อมูลหน่วยงานนี้หรือไม่?",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: "ตกลง",
                cancelButtonText: "ยกเลิก"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
            url: '<?= base_url('public/setting/deleteOffice') ?>',
            type: 'post',
            data: {
                hcode: hcode
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    swal.fire(response.staus,response.msg, 'success');
                    $('#tb_office').DataTable().ajax.reload();
                } else {
                    swal.fire(response.status,response.msg, 'error');
                }
            },
            error: function(xhr, status, error) {
                swal.fire('ผิดพลาด', 'เกิดข้อผิดพลาดในการลบข้อมูล', 'error');
            }
        });
                }
            });
        });
        
    });
    function editOffice(hcode) {
        $.ajax({
            url: '<?= base_url('public/setting/get_office_by_code') ?>',
            type: 'get',
            data: {
                hcode: hcode
            },
            dataType: 'json',
            success: function(response) {
                    $('#officeModal').modal('show');
                    $('#hcode').val(response.hcode);
                    $('#hname').val(response.hname);
                    $('#htype').val(response.htype);
                    $('#hdepart').val(response.hdepart);
                    $('#tumbon').val(response.tumbon);
                    $('#ampname').val(response.ampname);
                    $('#province').val(response.province);
            },
            error: function(xhr, status, error) {
                swal.fire('ผิดพลาด', 'เกิดข้อผิดพลาดในการแก้ไขข้อมูล'+xhr.responseText, 'error');
            }
        });
    }
    function deleteAct(hcode) {
        alert(hcode);
        $.ajax({
            url: '<?= base_url('public/setting/deleteOffice') ?>',
            type: 'post',
            data: {
                hcode: hcode
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    swal.fire(response.staus,response.msg, 'success');
                    $('#tb_office').DataTable().ajax.reload();
                } else {
                    swal.fire(response.status,response.msg, 'error');
                }
            },
            error: function(xhr, status, error) {
                swal.fire('ผิดพลาด', 'เกิดข้อผิดพลาดในการลบข้อมูล', 'error');
            }
        });
    }
    function deleteOffice(hcode) {
        $.ajax({
            url: '<?= base_url('public/setting/deleteOffice') ?>',
            type: 'post',
            data: {
                hcode: hcode
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    swal.fire('สำเร็จ', 'ลบข้อมูลหน่วยงานเรียบร้อย', 'success');
                    $('#tb_office').DataTable().ajax.reload();
                }
            },
            error: function(xhr, status, error) {
                swal.fire('ผิดพลาด', 'เกิดข้อผิดพลาดในการลบข้อมูล', 'error');
            }
        });
    }
    </script>
    <?= $this->endsection(); ?>