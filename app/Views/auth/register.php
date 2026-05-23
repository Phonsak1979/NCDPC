
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
        
        <div class="card auth-card">
            
            <div class="card-header auth-header text-center">
                <div>
                    <img src="<?= base_url('dist/img/favicon.png') ?>" alt="LTC Logo" class="auth-logo">
                    <h3 class="d-inline-block align-middle mb-0">NCDs</h3>
                </div>
                <span>ระบบบริหารจัดการโรค NCds</span>
            </div>

            <div class="card-body p-4 p-md-5">

                <form id="registerForm">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="hname" class="form-label">ชื่อหน่วยงาน (ค้นหาที่นี่)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-hospital"></i></span>
                                <input type="text" class="form-control" 
                                       id="hname" name="hname" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="hcode" class="form-label">รหัสหน่วยงาน (อัตโนมัติ)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-hashtag"></i></span>
                                <input type="text" class="form-control" 
                                       id="hcode" name="hcode" readonly required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="usertype" class="form-label">ประเภท USER (ค้นหา)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                <input type="text" class="form-control" 
                                       id="usertype" name="usertype" required>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="usercode" class="form-label">รหัส USER (อัตโนมัติ)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-hashtag"></i></span>
                                <input type="text" class="form-control" 
                                    id="usercode" name="usercode" readonly required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="fname" class="form-label">ชื่อ-สกุล</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                            <input type="text" class="form-control" 
                                   id="fname" name="fname" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-id-card-clip"></i></span>
                            <input type="text" class="form-control" 
                                   id="username" name="username" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" class="form-control" 
                                   id="email" name="email" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" class="form-control" 
                                   id="password" name="password" required>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-user-plus"></i> ลงทะเบียน
                        </button>
                    </div>

                </form>

                <hr class="my-4">

                <div class="text-center">
                    <p>มีบัญชีอยู่แล้ว? 
                        <a href="<?= base_url('public/login') ?>">เข้าสู่ระบบที่นี่</a>
                    </p>
                </div>

            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {

    // --- (A) Autocomplete ---
    // เมื่อพิมพ์ในช่อง #hname
    $("#hname").autocomplete({
        source: "<?= base_url('public/api/search/office') ?>", // ยิงไป API ที่เราสร้าง
        minLength: 2, // เริ่มค้นหาเมื่อพิมพ์ 2 ตัวอักษร
        
        // เมื่อผู้ใช้เลือกรายการ
        select: function(event, ui) {
            event.preventDefault(); // หยุดพฤติกรรมปกติ
            $("#hname").val(ui.item.value); // ใส่ชื่อในช่อง hname
            $("#hcode").val(ui.item.hcode); // ใส่รหัสในช่อง hcode
        }
    });
    // เมื่อพิมพ์ในช่อง #usertype
    $("#usertype").autocomplete({
        source: "<?= base_url('public/api/search/usertype') ?>", // ยิงไป API ที่เราสร้าง
        minLength: 2, // เริ่มค้นหาเมื่อพิมพ์ 1 ตัวอักษร
        
        // เมื่อผู้ใช้เลือกรายการ
        select: function(event, ui) {
            event.preventDefault(); // หยุดพฤติกรรมปกติ
            $("#usertype").val(ui.item.value); // ใส่ชื่อในช่อง usertype
            $("#usercode").val(ui.item.allow); // ใส่รหัสในช่อง usercode
        }
    }); 

    // --- (B) Form Submission (AJAX + SweetAlert) ---
    // เมื่อฟอร์ม register ถูก submit
    $("#registerForm").on('submit', function(e) {
        e.preventDefault(); // หยุดการ submit ฟอร์มแบบเดิม
        var usercode = $("#usercode").val();
        if(usercode == ''){ swal.fire('เตือน','โปรดเลือกประเภทผู้ใช้','warning')}
        // 1. แสดง Loading
        Swal.fire({
            title: 'กำลังสมัครสมาชิก...',
            text: 'กรุณารอสักครู่',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // 2. ส่งข้อมูลด้วย AJAX
        $.ajax({
            url: "<?= base_url('public/api/register') ?>", // ยิงไปที่ API
            type: "POST",
            data: $(this).serialize(), // ดึงข้อมูลทั้งฟอร์ม
            dataType: "json",

            // 3. ถ้าสำเร็จ (API ตอบกลับ 201 Created)
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'สมัครสมาชิกสำเร็จ!',
                    text: response.message,
                }).then(() => {
                    // ส่งไปหน้า Login
                    window.location.href = "<?= base_url('public/login') ?>";
                });
            },

            // 4. ถ้าล้มเหลว (API ตอบกลับ 400 Validation errors)
            error: function(xhr) {
                //var errorMsg = "ข้อมูลไม่ถูกต้อง";
                var errorMsg = xhr.responseJSON.message;
                // ดึงข้อความ error ที่ Model ส่งกลับมา
                if (xhr.responseJSON && xhr.responseJSON.messages) {
                    // รวม error ทุกตัวมาแสดง
                    errorMsg = Object.values(xhr.responseJSON.messages).join('\n');
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'สมัครไม่สำเร็จ',
                    // ใช้ html เพื่อแสดง error หลายบรรทัด
                    html: errorMsg.replace(/\n/g, '<br>') 
                });
            }
        });
    });

});
</script>
<?= $this->endSection() ?>