<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('title') ?>
LTC MEDIA
<?= $this->endSection() ?>
<?= $this->section('style') ?>
<style>
.datatable td {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap; /* Prevents wrapping, forcing overflow */
}
.wrap-column {
    white-space: normal;
    word-break: break-word;
}
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row page-title-header">
            <div class="col-12">
                <div class="page-header">
                    <h4 class="page-title">บริหารจัดการคลังความรู้สำหรับนักบริบาล(CG)
                        <?= esc($user->hcode).":".esc($office->hname) ?></h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <form id="frmHliteracy" enctype="multipart/form-data">
                            <input type="hidden" id="id" name="id">
                            <div class="form-group">
                            <label for="txtName" class="" >ชื่อเรื่อง</label>
                            <input type="text" class="form-control" id="txtName" name="txtName">
                            </div>
                            <div class="form-group">
                            <label for="txtdescript" class="" >คำอธิบาย</label>
                            <input type="text" class="form-control" id="txtdescript" name="txtdescript">
                            </div>
                            <div class="form-group">
                            <label for="txturl" class="" >ID วีดีโอ Youtube</label>
                            <input type="text" class="form-control" id="txturl" name="txturl">
                            </div>
                            <div class="form-group">
                            <label for="txtIcon" class="" >รูปภาพ</label>
                            <input type="file" class="form-control" id="txtIcon" name="txtIcon[]">
                            </div>
                            <div class="form-group">
                             <button type="submit" class="btn btn-primary form-control">บันทึก</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-12 grid-margin">
            <table id="tb_video" class="table table-striped">
            </table>
          </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
    <script>
        $(document).ready(function () {
            $('#tb_video').DataTable({
                "processing": true,
                'pageing': true,
                'lengthChange': false,
                'searching': true,
                'autoWidth': false,
                'responsive': true,
                'ordering': true,
                "ajax": {
                    "url":'<?= base_url('public/setting/getHliteracy') ?>',
                    "dataSrc": ""
                },
                "columns": [
                        {title: "ลำดับ", data: "id"},
                        {title: "ชื่อเรื่อง", data: "name"},
                        {title: "คำอธิบาย", data: "descript"},
                        {title: "ICON ", data: "str_img"},
                        {title: "Action", data: "id",
                            render: function (data, type, row) {
                                return '<button class="btn btn-sm btn-danger" id="btnDelete" data-id="'+data+'">ลบ</button>';
                            }
                        },
                    ]
            });

            $('#frmHliteracy').on('submit', function (e) {
                e.preventDefault();

                var $form       = $(this);
                var $submitBtn  = $form.find('[type="submit"]');
                var formData    = new FormData(this);

                // ✅ Prevent duplicate submissions
                if ($submitBtn.prop('disabled')) return;

                // ✅ Show loading state
                $submitBtn.prop('disabled', true).text('กำลังบันทึก...');

                $.ajax({
                    url: '<?= base_url('public/setting/addHliteracy') ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function (response) {
                        // ✅ Validate server response
                        if (response.status === 'success') {
                            swal.fire(response.status, response.message, 'success');
                            $('#tb_video').DataTable().ajax.reload();
                            $form[0].reset(); // ✅ Clear form after success

                            // Optional: show success message
                            // alert(response.message);
                        } else {
                            // ✅ Handle server-side errors
                            alert(response.message || 'เกิดข้อผิดพลาด กรุณาลองใหม่');
                        }
                    },

                    // ✅ Handle network/server errors
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        alert('ไม่สามารถเชื่อมต่อได้ กรุณาลองใหม่อีกครั้ง');
                    },

                    // ✅ Always restore button regardless of outcome
                    complete: function () {
                        $submitBtn.prop('disabled', false).text('บันทึก');
                    }
                });
            });
            $(document).on('click', '#btnDelete', function (e) {
                e.preventDefault();
                var id = $(this).attr('data-id');
                alert(id);
                $.ajax({
                    url: '<?= base_url('public/setting/deleteHealthlit') ?>',
                    type: 'POST',
                    data: {id: id},
                    success: function(response) {
                        $('#tb_video').DataTable().ajax.reload();
                    }
                });
               
            });         
        });
    </script>
<?= $this->endSection() ?>