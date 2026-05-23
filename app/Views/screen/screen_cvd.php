<?= $this->extend('layouts/main_layout'); ?>
<?= $this->section('styles');?>
<?= $this->endsection(); ?>
<?= $this->section('content'); ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row page-title-header">
            <div class="col-12">
                <div class="page-header">
                    <h4 class="page-title">คัดกรองโรคหัวใจและหลอดเลือด (CVD)</h4>
                    <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
                        <ul class="tabs quick-links ml-auto">
                            <li><a href="#" rel="#screened_cvd" class="tab">คัดกรองปีปัจจุบัน</a></li>
                            <li><a href="#" rel="#non_screened_cvd" class="tab">ยังไม่ได้คัดกรอง</a></li>
                        </ul>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div id="dm_risk" class="tab-content">
                            <h4 class="card-title">กลุ่มเสี่ยงรายบุคคล</h4>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                        
                                </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endsection(); ?>
<?= $this->section('scripts'); ?>
<?= $this->endsection(); ?>
</body>
</html>