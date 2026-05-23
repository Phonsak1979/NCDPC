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
                    <h4 class="page-title">บริหารจัดการกลุ่มเสี่ยงเบาหวาน</h4>
                    <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
                        <ul class="tabs quick-links ml-auto">
                            <li><a href="#" rel="#dm_risk" class="tab">กลุ่มเสี่ยง DM รายบุคคล</a></li>
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
                                        <table class="table table-striped" id="tableRiskDM">

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
<div class="modal fade" id="modal-hl" tabindex="-1" aria-labelledby="modal-hl-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-hl-label">เลือก Health Literacy Coach</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="hl-detail-content">
                    <select id="selehcoach" class="form-control">
                        
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endsection(); ?>
<?= $this->section('scripts');?>
<script>
$(document).ready(function() {
    get_risk_dm2();
    var hcode = $('#selehcode').val();
    //render_Chart_fpg1(hcode);
    $('#selehcode').on('change', function(e) {
        get_risk_dm2();
        get_village_by_hcode();
        //render_Chart_fpg1($(this).val());
    });
    $('#villselect').on('change', function(e) {
        get_risk_dm2();
    });

     $('#riskselect').on('change', function(e) {
        get_risk_dm2();
        //render_Chart_selected($(this).val());
    });
   
});

function get_risk_dm2() {
    
    $('#tableRiskDM').dataTable({
        destroy: true,
        processing: false,
        serverSide: false,
        fixedHeader: true,
        responsive: false,
        pageLength: 10,
        paging: true,
        searching: true,
        ajax: {
            url: '<?= base_url('public/fetchRisk/fecth_dm_risk') ?>',
            dataSrc: 'riskdmresult'
        },
        columns: [{
                title: 'ลำดับ',
                data: null,
                render: function(data, type, row, meta) {
                    return meta.row + 1;
                }
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
                title: 'ผลคัดกรอง',
                data: 'bslevel'
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
                title: 'อยู่ในโครงการ',
                data: function(data) {
                    return (data.inprojected == '1') ?
                        '<input type="checkbox" checked class="checkbox-wrapper-56">' :
                        '<input type="checkbox" class="checkbox-wrapper-56">';
                }
            },
            {
                title: 'เลือกเข้าโครงการ',
                data : function(data){
                    return '<button data-id="' + data.rid + '" onClick="selected_case(' + data.rid + ')" class="btn btn-primary">เลือก</button>';
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
function get_village_by_hcode() {
    const hcode = $('#selehcode').val();
    $.ajax({
        url: '<?= base_url('public/fetchRisk/get_village_by_hcode/') ?>'+hcode,
        type: 'POST',
        dataType: 'json',
        success: function(res) {
            console.log(res);
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
function selected_case(id) {
    //const id = $(this).attr('data-id');
    $.ajax({
        url: '<?= base_url('public/fetchRisk/save_selected_dm') ?>',
        type: 'POST',
        data: {
            rid: id
        },
        dataType: 'json',
        success: function(res) {
            swal.fire(res.status, res.msg, res.status);
            $('#tableRiskDM').DataTable().ajax.reload(null,false);
        },
        error: function(xhr, status, error) {
            console.error(error + ':' + xhr.responseText);
            if (status = 500) {
                swal.fire('warning', 'เกิดข้อผิดพลาดในการส่งข้อมูล', "warning");
                return false;
            }
        }
    });
}

function changeStatus(checkbox) {
    let isChecked = checkbox.checked ? 1 : 0;
    let id = checkbox.getAttribute('data-id');
    //alert(isChecked);
    $.ajax({
        url: '<?= base_url('public/update-Send-Status') ?>',
        type: 'post',
        data: {
            id: id,
            send: isChecked
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                //Swal.fire('สำเร็จ', response.msg, 'success');
                $('#tableselectedDM').DataTable().ajax.reload();
            } else {
                Swal.fire('ข้อผิดพลาด', response.msg, 'error');
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
            Swal.fire('ข้อผิดพลาด', 'ไม่สามารถอัปเดตสถานะได้', 'error');
        }
    });
}   

function render_Chart_fpg1(hcode) {
    //const hcode = $('#selehcode').val();
    fetch('<?=base_url('public/get_chart_fpg/') ?>'+hcode)
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('chart-riskDm').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: data.riskfpg1,
                    datasets: [{
                        label: 'FPG_1',
                        data: data.counts1,
                        backgroundColor: [
                            '#eb6817',
                            '#9BD0F5',
                            '#f2f20d'
                        ],
                        hoverOffset: 4
                    }],
                }
            });
            const ctx2 = document.getElementById('chart-riskDm2').getContext('2d');
            new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: data.riskfpg2,
                    datasets: [{
                        label: 'FPG_2',
                        data: data.counts2,
                        backgroundColor: [
                            '#eb6817',
                            '#9BD0F5',
                            '#f2f20d'
                        ],
                        hoverOffset: 4
                    }],
                }
            });
        });
}
function render_Chart_selected(hcode) {
    fetch('<?=base_url('public/get_chart_fpg/') ?>'+hcode)
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('chart-Selected1').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: data.riskfpg1,
                    datasets: [{
                        label: 'FPG_1',
                        data: data.counts1,
                        backgroundColor: [
                            '#eb6817',
                            '#f2f20d'
                        ],
                        hoverOffset: 4
                    }],
                }
            });
            const ctx2 = document.getElementById('chart-Selected2').getContext('2d');
            new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: data.riskfpg2,
                    datasets: [{
                        label: 'FPG_2',
                        data: data.counts2,
                        backgroundColor: [
                            '#eb6817',
                            '#f2f20d'
                        ],
                        hoverOffset: 4
                    }],
                }
            });
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