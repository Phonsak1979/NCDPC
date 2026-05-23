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
                    <h4 class="page-title">ผู้ป่วยเบาหวาน รายใหม่ในปี <?= date('Y'); ?></h4>
                    <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
                        <ul class="quick-links ml-auto">
                            <li><a href="<?= Base_url('public/dashboard'); ?>">Dashboard</a></li>
                            <li><a href="<?= Base_url('public/newcaseData/newDm_page'); ?>">DM รายใหม่</a></li>
                            <li><a href="<?= Base_url('public/newcaseData/newHt_page'); ?>">HT รายใหม่</a></li>
                            <li><a href="<?= Base_url('public/newcaseData/newDmHt_page'); ?>">ผู้ป่วย DM+HT </a></li>
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
                                        <h3 class="mb-0 font-weight-semibold"><?= $newDM ?></h3>
                                        <h5 class="mb-0 font-weight-medium text-primary">ผู้ป่วย DM รายใหม่</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mt-md-0 mt-4">
                                <div class="d-flex">
                                    <div class="wrapper">
                                        <h3 class="mb-0 font-weight-semibold"><?= $oldDM ?></h3>
                                        <h5 class="mb-0 font-weight-medium text-primary">ผู้ป่วย DM รายเก่า</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mt-md-0 mt-4">
                                <div class="d-flex">
                                    <div class="wrapper">
                                        <h3 class="mb-0 font-weight-semibold"><?= $newDMHT ?></h3>
                                        <h5 class="mb-0 font-weight-medium text-primary">ผู้ป่วย DM+HT รายเก่า</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mt-md-0 mt-4">
                                <div class="d-flex">
                                    <div class="wrapper">
                                        <h3 class="mb-0 font-weight-semibold">0</h3>
                                        <h5 class="mb-0 font-weight-medium text-primary">Remission DM</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card table-responsive">
                    <div class="card-body">
                        <div class="col-12 d-flex justify-content-between">
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
    $(function(){
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
           url: '<?= base_url('public/newcaseData/fecth_dm_newcase/') ?>'+hcode,
           dataSrc: 'newdmresult'
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
            {title: 'วินิจฉัย',data: 'mix_dx'},
            {title: 'หน่วยบริการ',data: 'hosp_dx'},
            {title: 'วันที่วินิจฉัย',data: function(data){
                return '<p>'+data.date_dx+'</p>';
            }},
            {title: 'hba1c',data: 'rs_hba1c'},
            {title: 'fpg1',data: 'rs_fpg1'},
            {title: 'fpg2',data: 'rs_fpg2'},
            {title: 'retina',data: 'rs_retina'},
            {title: 'foot',data: 'rs_foot'},
        ],
         layout: {
            topStart: {
                buttons: ['excel', 'print']
            }
        }                               
    });

}
</script>
<?= $this->endsection(); ?>