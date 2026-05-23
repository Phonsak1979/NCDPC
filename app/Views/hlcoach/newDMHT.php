<?= $this->extend('layouts/main_layout'); ?>
<?= $this->section('styles');?>
<style>

</style>
<?= $this->endsection(); ?>
<?= $this->section('title') ?>
NCDs Dashboard
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row page-title-header">
            <div class="col-12">
                <div class="page-header">
                    <h4 class="page-title">ผู้ป่วยโรคเบาหวาน+ความดันโลหิตสูง รายใหม่ในปี <?= date('Y'); ?></h4>
                    <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
                        <ul class="quick-links ml-auto">
                            <li><a href="<?= Base_url('public/dashboard'); ?>">Dashboard</a></li>
                            <li><a href="<?= Base_url('public/newcaseData/newDm_page'); ?>">DM รายใหม่</a></li>
                            <li><a href="<?= Base_url('public/newcaseData/newHt_page'); ?>">HT รายใหม่</a></li>
                            <li><a href="<?= Base_url('public/newcaseData/newDmHt_page'); ?>">DM+HT รายใหม่</a></li>
                            <li><a href="<?= Base_url('public/setting/office-page'); ?>">Remission</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="d-flex">
                                    <div class="wrapper">
                                        <h2 class="mb-3 font-weight-semibold"><?= ceil($newDMHT) ?></h2>
                                        <h3 class="mb-3 font-weight-medium text-primary">ผู้ป่วย DM+HT</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mt-md-0 mt-4">
                                <div class="d-flex">
                                    <div class="wrapper">
                                        <canvas class="mb-0" id="chart-hba1c"></canvas> 
                                        <!--<h3 class="mb-0 font-weight-semibold"></h3>-->
                                        <h5 class="mb-0 font-weight-medium text-primary">HbA1C</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mt-md-0 mt-4">
                                <div class="d-flex">
                                    <div class="wrapper">
                                        <canvas class="mb-0" id="chart-fpg1"></canvas>     
                                        <h5 class="mb-0 font-weight-medium text-primary">FPG_1</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mt-md-0 mt-4">
                                <div class="d-flex">
                                    <div class="wrapper">
                                        <canvas class="mb-0" id="chart-fpg2"></canvas> 
                                        <h5 class="mb-0 font-weight-medium text-primary">FPG_2</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card table-responsive">
                    <div class="card-body">
                        <div class="col-12">
                            <div class="col-12 d-flex justify-content-around">
                                <label for="selehcode">หน่วยบริการ :</label>
                                <select id="selehcode" class="form-control col-6">
                                    <option value="">ทั้งหมด</option>
                                    <?php if(!empty($seleoffice)):foreach($seleoffice as $off): ?>
                                    <option value="<?= $off['hcode'] ?>"><?= $off['hname'] ?></option>
                                    <?php endforeach;endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card table-responsive">
                 <table id="tb_newCase" class="table table-striped">
                    
                 </table>                           
            </div>
        </div>
    </div>
</div>

<?= $this->endsection(); ?>
<?= $this->section('scripts') ?>
<script>
    $(document).ready(function(){
  
        render_Chart_hba1c();
        render_Chart_fpg1();
        //render_Chart_fpg2();

        $('#selehcode').on('change',function(e){
             e.preventDefault();
             get_newCaseDm();
             return false;                                
        });                                      
    });
function get_newCaseDm()
{
    const hcode = $('#selehcode').val();
    $('#tb_newCase').dataTable({
        destroy: true,
        paging: false,
        searching: false,
        ajax:{
           url: '<?= base_url('public/newcaseData/fecth_dmht_newcase/') ?>'+hcode,
           dataSrc: 'newdmhtresult'
        },
        columns:[
            {title: 'ลำดับ' ,data: null, render: function(data, type, row, meta){
                    return meta.row + 1;
                }
            },
            {title: 'ชื่อ-นามสกุล',data: 'pname'},
            {title: 'เพศ' ,data: function(data){
                 return (data.sex == 1) ? 'ชาย':'หญิง' ;                       
            }},
            {title: 'อายุ',data: 'age'},
            {title: 'หมู่บ้าน',data: 'villname'},
            {title: 'วันที่วินิจฉัย HT',data: 'min_date_dx_ht'},
            {title: 'BP1',data: function(data){
                return data.rs_bps1+'/'+data.rs_bpd1 ;
            }},
            {title: 'BP2',data: function(data){
                return data.rs_bps2+'/'+data.rs_bpd2 ;
            }},
            {title: 'วันที่วินิจฉัย DM',data: 'min_date_dx_dm'},
            {title: 'Hba1C',data: 'rs_hba1c'},
            {title: 'fpg1' , data: 'rs_fpg1'},
            {title: 'fpg2' , data: 'rs_fpg2'},
            {title: 'retina' , data: 'rs_retina'},
            {title: 'foot' , data: 'rs_foot'},
        ],
        layout: {
        topStart: {
            buttons: ['excel', 'print']
        }
    }                               
    });

}
function render_Chart_hba1c() {
    fetch('<?=base_url('public/get_Chart_hba1c') ?>')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('chart-hba1c').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: data.riskhb,
                    datasets: [{
                        label: 'HbA1C',
                        data: data.counts,
                        backgroundColor: [
                            '#eb6817',
                            '#9BD0F5'
                        ],
                        hoverOffset: 4
                    }],
                }
            });
        });
}
function render_Chart_fpg1() {
    fetch('<?=base_url('public/get_chart_fpg') ?>')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('chart-fpg1').getContext('2d');
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
            const ctx2 = document.getElementById('chart-fpg2').getContext('2d');
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
function render_Chart_fpg2() {
    fetch('<?=base_url('public/get_chart_fpg') ?>')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('chart-fpg2').getContext('2d');
            new Chart(ctx, {
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
</script>
<?= $this->endsection(); ?>