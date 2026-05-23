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
    box-shadow: -10px -10px 15px rgba(255,255,255,0.5),
    10px 10px 15px rgba(0,0,70,0.12);
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
    box-shadow: -10px -10px 15px rgba(255,255,255,0.5),
    10px 10px 15px rgba(70,70,70,0.12),
    inset -10px -10px 15px rgba(255,255,255,0.5),
    inset 10px 10px 15px rgba(70,70,70,0.12);
    transition: .5s;
  }

  .checkbox-wrapper-56 .container input:checked::after {
    transition: .5s;
    border: solid #15e38a;
    border-width: 0 0.15em 0.15em 0;
    transform: rotate(45deg);
  }
</style>

<?= $this->endsection(); ?>
<?= $this->section('content'); ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row page-title-header">
            <div class="col-12">
                <div class="page-header">
                    <h4 class="page-title">บริหารจัดการกลุ่มเสี่ยงโรคความดันโลหิตสูง(HT)</h4>
                    <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
                        <ul class="tabs quick-links ml-auto">
                            <li><a href="#" rel="#ht_risk" class="tab">กลุ่มเสี่ยง HT รายบุคคล</a></li>
                        </ul>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="tab_contents_container">
                    <div class="tab_contents tab_contents_active" id="ht_risk">
                        <div class="col-md-12 grid-margin">
                            <div class="card-body">
                                    <div class="card-header">
                                        <div class="col-12 d-flex justify-content-between">
                                            <div class="col-md-4 d-flex justify-content-center">
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
                                            <div class="col-md-4 d-flex justify-content-center">
                                                <label for="riskselect">ความเสี่ยง</label>
                                                <select id="riskselect" class="form-control">
                                                    <option value="">ทั้งหมด</option>
                                                    <option value="เสี่ยงสูง">เสี่ยงสูง</option>
                                                    <option value="เสี่ยงต่ำ">เสี่ยงต่ำ</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped" id="tableRiskHT">

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
<div class="modal fade" id="modalRiskHT" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">รายละเอียดความเสี่ยง</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>   
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ชื่อ-นามสกุล:</strong> <span id="detail-name"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endsection(); ?>
<?= $this->section('scripts');?>
<script>
$(document).ready(function() {
    
    get_risk_ht2();
    //render_Chart_fpg1();
    $('#selehcode').on('change', function(e) {
        get_risk_ht2();
        get_village_by_hcode();
        //render_Chart_fpg1();
    });
    $('#villselect').on('change', function(e) {
        get_risk_ht2();
        //render_Chart_fpg1();
    });
    $('#riskselect').on('change', function(e) {
        get_risk_ht2();
        //render_Chart_fpg1();
    });
                          
     $('#selehcode2').on('change', function(e) {
        get_selected_risk();
        //render_Chart_selected();
    });
      
});

function get_risk_ht2() {
    const hcode = $('#selehcode').val();
    $('#tableRiskHT').dataTable({
        destroy: true,
        processing: false,
        serverSide: false,
        fixedHeader: true,
        responsive: false,
        pageLength: 10,
        paging: true,
        searching: true,
        ajax: {
            url: '<?= base_url('public/fetchRisk/fecth_ht_risk') ?>',
            dataSrc: 'riskhtresult'
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
                data: function(data){
                    return data.sbp+'/'+data.dbp;
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
                    return '<button data-id="' + data.rid + '" onClick="selected_case(' + data.rid + ')" class="btn btn-sm btn-primary">เลือก</button>';
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

function selected_case(id) {
    //const id = $(this).attr('data-id');
    $.ajax({
        url: '<?= base_url('public/fetchRisk/save_selected_ht') ?>',
        type: 'POST',
        data: {
            rid: id
        },
        dataType: 'json',
        success: function(res) {
            swal.fire(res.status, res.msg, res.status);
            $('#tableRiskHT').DataTable().ajax.reload(null,false);
        },
        error: function(xhr, status, error) {
            console.error(error + ':' + xhr.responseText);
            if (status = 500) {
                swal.fire('warning', 'รายนี้มีในโครงการแล้ว', "warning");
                return false;
            }
        }
    });
}
function get_selected_risk()
{
    const hcode = $('#selehcode2').val();
    $('#tableselectedHT').dataTable({
        destroy: true,
        processing: false,
        fixedHeader: true,
        responsive: false,
        pageLength: 10,
        paging: true,
        searching: true,
        ajax: {
            url: '<?= base_url('public/fetchRisk/fecth_selected_ht/') ?>' + hcode,
            dataSrc: 'riskhtresult'
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
                title: 'ผล_1',
                data: function(data){
                    return data.sbp+'/'+data.dbp;
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
                data: function(data){
                    return data.sbp2+'/'+data.dbp2;
                }
            },
            {
                title: 'ความเสี่ยง2',
                data: function(data) {
                    return (data.result2 == 'เสี่ยงสูง') ?
                        '<span class="badge badge-pill badge-danger">' + data.result2 + '</span>' :
                        '<span class="badge badge-pill badge-warning">' + data.result2 + '</span>';
                }
            },
            {
                title: 'การจัดการ',
                data : function(data){
                    return '<button data-id="' + data.id + '" onClick="cancle_case(' + data.id + ')" class="btn btn-danger">ลบ</button>'+
                    '<button data-id="' + data.id + '" onClick="send_to_hcoach(' + data.id + ')" class="btn btn-primary">HL</button>';
                }
            }
        ],
         layout: {
            topStart: {
                buttons: ['excel', 'print',{
                        text: 'ลบข้อมูลทั้งหมด',
                        className: 'btn btn-primary',
                        action: function(e, dt, node, config) {
                            $.fn.addNewfunction();
                        }
                    }]
            }
        }
    });
}
function send_to_hcoach(id){
    $.ajax({
        url: '<?= base_url('public/fetchRisk/send_to_hcoach') ?>',
        type: 'POST',
        data: {
            rid: id
        },
        dataType: 'json',
        success: function(res) {            
            $("#modalRiskHT").modal('show');
        },
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
                url: '<?= base_url('public/fetchRisk/del_selected_ht') ?>',
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

function render_Chart_fpg1() {
    fetch('<?=base_url('public/get_chart_fpg') ?>')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('chart-riskHt').getContext('2d');
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
            const ctx2 = document.getElementById('chart-riskHt2').getContext('2d');
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
function render_Chart_selected() {
    fetch('<?=base_url('public/get_chart_fpg') ?>')
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
        month: (format === 'full') ? 'long' : 'short',
        day: 'numeric',
    };

    // ใช้ 'th-TH' เพื่อดึง Format ไทย (พ.ศ. จะถูกคำนวณให้อัตโนมัติ)
    return new Intl.DateTimeFormat('th-TH', options).format(d);
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

</script>
<?= $this->endsection(); ?>