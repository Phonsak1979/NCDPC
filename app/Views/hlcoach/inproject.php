<?= $this->extend('layouts/main_layout'); ?>
<?= $this->section('styles');?>
<style>
.checkbox-wrapper-56 *,
.checkbox-wrapper-56 ::after,
.checkbox-wrapper-56 ::before {
    box-sizing: border-box;
}

.checkbox-wrapper-56 .container input {
    opacity: 1;
    -webkit-appearance: none;
    cursor: pointer;
    height: 50px;
    width: 50px;
    box-shadow: -10px -10px 15px rgba(255, 255, 255, 0.5),
        10px 10px 15px rgba(0, 0, 70, 0.12);
    border-radius: 50%;
    border: 8px solid #ececec;
    outline: none;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: .5s;
}

.checkbox-wrapper-56 .container {
    display: flex;
    justify-content: center;
    align-items: center;
}

.checkbox-wrapper-56 .container input::after {
    transition: .5s;
    font-family: monospace;
    content: '';
    color: #7a7a7a;
    font-size: 25px;
    left: 0.45em;
    top: 0.25em;
    width: 0.25em;
    height: 0.5em;
    border: solid #7a7a7a;
    border-width: 0 0.15em 0.15em 0;
    transform: rotate(45deg);
}

.checkbox-wrapper-56 .container input:checked {
    box-shadow: -10px -10px 15px rgba(255, 255, 255, 0.5),
        10px 10px 15px rgba(70, 70, 70, 0.12),
        inset -10px -10px 15px rgba(255, 255, 255, 0.5),
        inset 10px 10px 15px rgba(70, 70, 70, 0.12);
    transition: .5s;
}

.checkbox-wrapper-56 .container input:checked::after {
    transition: .5s;
    border: solid #15e38a;
    border-width: 0 0.15em 0.15em 0;
    transform: rotate(45deg);
}

.outer {
    position: relative;
    width: 600px;
    height: 400px;
}

canvas {
    position: absolute;
}

.percent {
    position: absolute;
    left: 50%;
    transform: translate(-50%, 0);
    font-size: 80px;
    bottom: 0;
}

.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}
/* The slider */
.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
}

input:checked+.slider {
    background-color: #2196F3;
}

input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
}

input:checked+.slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}
div.dt-buttons>.my-custom-class {
    background-color: #007bff;
    /* Primary blue color */
    color: white;
    /* Other styles */
}
</style>

<?= $this->endsection(); ?>
<?= $this->section('content'); ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row page-title-header">
            <div class="col-12">
                <div class="page-header">
                    <h4 class="page-title">โครงการปรับเปลี่ยนพฤติกรรม</h4>
                    <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
                        <ul class="tabs quick-links ml-auto">
                            <li><a href="#" rel="#inproj_dm_risk" class="tab">กลุ่มเป้าหมายโครงการ</a></li>
                        </ul>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="tab_contents_container">
                    <div class="tab_contents tab_contents_active" id="dm_risk">
                        <div class="col-md-12 grid-margin">
                            <div class="card table-responsive">
                                <div class="card-body">
                                    <div class="card-header">
                                        <div class="col-12 d-flex justify-content-between">
                                            <div class="col-md-4 d-flex justify-content-between">
                                                <label for="selehcode">หน่วยบริการ :</label>
                                                <select id="selehcode" class="form-control">
                                                    <option value="0">ทั้งหมด</option>
                                                    <?php if(!empty($seleoffice)):foreach($seleoffice as $off): ?>
                                                        <option value="<?= $off['hcode'] ?>"><?= $off['hname'] ?></option>
                                                    <?php endforeach;endif; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4 d-flex justify-content-center">
                                                <label for="chart-riskDm">หมู่บ้าน</label>
                                                <select id="villselect" class="form-control">
                                                    <option value="">ทั้งหมด</option>
                                                </select>
                                            </div>   
                                            <div class="col-md-4 d-flex justify-content-between">
                                                <label for="riskselect">ความเสี่ยง :</label>
                                                <select id="riskselect" class="form-control">
                                                    <option value="">ทั้งหมด</option>
                                                    <option value="เสี่ยงสูง">เสี่ยงสูง</option>
                                                    <option value="เสี่ยงต่ำ">เสี่ยง</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped" id="tableselectedDM">

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
    <div class="modal fade" id="modal-hl" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เลือกโค้ช</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="risk_hospcode">
                    <input type="hidden" class="form-control" id="risk_id" readonly>
                    <label for="selehcoach">โค้ชสุขภาาพ</label>
                    <select id="selehcoach" class="form-control">
                        <option value="">เลือก</option>
                    </select>
                </div>  
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button type="button" onClick="save_hcoach()"
                        class="btn btn-primary btn-save">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?= $this->endsection(); ?>
<?= $this->section('scripts');?>
<script>
$(document).ready(function() {
    
    var hcode = $('#selehcode').val();
    get_selected_risk(hcode);
    //render_Chart_fpg1(hcode);
    $('#selehcode').on('change', function(e) {
        get_selected_risk(this.value);
        get_village_by_hcode();
        //render_Chart_fpg1($(this).val());
    });
    $('#villselect').on('change', function(e) {
        get_selected_risk();
    });

     $('#riskselect').on('change', function(e) {
        get_selected_risk();
        //render_Chart_selected($(this).val());
    });
   
});
function get_village_by_hcode() {
    const hcode = $('#selehcode').val();
    $.ajax({
        url: '<?= base_url('public/fetchRisk/get_village_by_hcode/') ?>'+hcode,
        type: 'POST',
        dataType: 'json',
        success: function(res) {
            //console.log(res);
            $villselect = '<option value="">ทั้งหมด</option>';
            $.each(res, function(index, item) {
                $villselect += '<option value="' + item.villcode + '">' + item.villname + '</option>';
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
function get_selected_risk(hospcode)
{
    const hcode = $('#selehcode').val();
    $('#tableselectedDM').dataTable({
        destroy: true,
        processing: false,
        fixedHeader: true,
        responsive: false,
        pageLength: 10,
        paging: true,
        searching: true,
        ajax: {
            url: '<?= base_url('public/fetchRisk/fecth_selected_dm/') ?>' + hospcode,
            dataSrc: 'riskdmresult'
        },
        columns: [{
                title: 'ลำดับ',
                data: null,
                render: function(data, type, row, meta) {
                    return meta.row + 1;
                },
                width: 5
            },
            {
                title: 'ชื่อ-นามสกุล',
                data: 'pname'
            },
            {
                title: 'เพศ',
                data: function(data) {
                    return (data.sex == 1) ? 'ชาย' : 'หญิง';
                }
            },
            {
                title: 'อายุ',
                data: 'age'
            },
            {
                title: 'หมู่บ้าน',
                data: 'villname'
            },
            {
                title: 'วันที่คัดกรอง',
                data: function(data) {
                    return dateThai(data.date_screen);
                }
            },
            {
                title: 'เสี่ยง',
                data: function(data) {
                    return (data.risktype == 'dm') ?
                        '<span class="badge badge-pill badge-danger">เบาหวาน</span>' :
                        '<span class="badge badge-pill badge-warning">ความดัน</span>';
                }
            },
            {
                title: 'ผล_1',
                data: function(data){
                    if(data.risktype == 'dm'){
                        return data.bslevel;
                    } else if(data.risktype == 'ht'){
                        return data.sbp + '/' + data.dbp;
                    } else {
                        return ''
                    }
                    return ''
                }
            },
            {
                title: 'ความเสี่ยง',
                data: function(data) {
                    return (data.result == 'เสี่ยงสูง') ?
                        '<span class="badge badge-pill badge-danger">' + data.result + '</span>' :
                        '<span class="badge badge-pill badge-warning">' + data.result + '</span>';
                }
            },
            {
                title: 'ผล_2',
                data: 'bslevel2'
            },
            {
                title: 'ความเสี่ยง_2',
                data: function(data) {
                    return (data.result2 == 'เสี่ยงสูง') ?
                        '<span class="badge badge-pill badge-danger">' + data.result2 + '</span>' :
                        '<span class="badge badge-pill badge-warning">' + data.result2 + '</span>';
                }
            },
            {
                title: 'โค้ช',
                data: null, render: function(data, type, row){
                    return '<label class="switch">'+
                            '<input type="checkbox" class="status_used" data-id="'+row.id+'" '+(row.hcoach == null ? '' : 'checked')+'>'+
                            '<span class="slider round"></span></label>';
                },
            },
            {
                title: 'การจัดการ',
                data : function(data){
                    return '<a href="#" onClick="get_for_hcoach(\'' + data.hospcode + '\', ' + data.pid + ')" class="badge badge-pill badge-primary me-2">โค้ช</a>'+
                    '<a href="#" onClick="cancle_case(' + data.id + ')" class="badge badge-pill badge-danger">ลบ</a>';
                }
            }
        ],
         layout: {
            topStart: {
                buttons: ['excel', 'print']
            }
        }
    });
}

function cancle_case(id) {
    Swal.fire({
    title: "ตรวจสอบให้แน่ใจก่อนลบ?",
    text: "เมื่อลบแล้วข้อมูลการสำรวจ HL จะลบออกไปด้วย!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน!"
    }).then((result) => {
        if (result.isConfirmed) {
        $.ajax({
                url: '<?= base_url('public/fetchRisk/del_selected_dm') ?>',
                type: 'POST',
                data: {
                    rid: id
                },
                dataType: 'json',
                success: function(res) {
                    swal.fire(res.status, res.msg, res.status);
                    $('#tableselectedDM').DataTable().ajax.reload(null,false);
                },
                error: function(xhr, status, error) {
                    console.error(error + ':' + xhr.responseText);
                    if (status = 500) {
                        swal.fire('warning', 'มีปัญหาในการลบข้อมูลรายนี', "warning");
                        return false;
                    }
                }
            });
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
function get_for_hcoach(hcode,id) {
    //alert(id);
    $.ajax({
        url: '<?= base_url('public/hcoach/get_hcoach_by_hcode/') ?>'+hcode,
        type: 'post',
        dataType: 'json',
        success: function(res) {
            console.log(res);
            $seleHcoach = '<option value="">เลือก</option>';
            if(res.length == 0){
                 $seleHcoach = '<option value="">ไม่พบโค้ชสุขภาพ</option>';
            } else {
              $.each(res, function(index, item) {
                if(item.tel == ''){
                    $seleHcoach += '<option value="">ไม่พบเบอร์โทรของโค้ช</option>';
                } else {
                     $seleHcoach += '<option value="' + item.tel + '">' + item.hcoachname + '</option>';
                }
              });
            }
            $('#risk_hospcode').val(hcode);
            $('#risk_id').val(id);
            $('#selehcoach').html($seleHcoach);
            $('#modal-hl').modal('show');
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
function save_hcoach() {
    const pid = $('#risk_id').val();
    const hcode = $('#risk_hospcode').val();
    const tel = $('#selehcoach').val();
        if(tel == ''){
            swal.fire('warning', 'กรุณาเลือกโค้ชสุขภาพ', "warning");
            return false;
        }
    
    $.ajax({
        url: '<?= base_url('public/hcoach/save-hcoach-to-risk') ?>',
        type: 'post',
        dataType: 'json',
        data: {
            pid : pid,
            hcode : hcode,
            tel: tel
        },
        success: function(res) {
            console.log(res);
            if(res.status == 'success'){
                swal.fire(res.status, res.msg, res.status);
                $('#modal-hl').modal('hide');
                $('#tableselectedDM').DataTable().ajax.reload(null,false);
            } else {
                swal.fire(res.status, res.msg, res.status);
            }
            
        },
        error: function(xhr, status, error) {
            console.error(error + ':' + xhr.responseText);
            if (status = 500) {
                swal.fire('warning', 'มีปัญหาในการส่งข้อมูลรายนี', "warning");
                return false;
            }
         }   
    });
};
</script>
<?= $this->endsection(); ?>