<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        
        <div class="card auth-card">
            
            <div class="card-header auth-header text-center">
                <div>
                    <img src="<?= base_url('dist/img/favicon.png') ?>" alt="LTC Logo" class="auth-logo">
                    
                    <h3 class="d-inline-block align-middle mb-0">NCDs</h3>
                </div>
                <span class="fs-4 fw-bold">Promotion & Prevention Center</span>
            </div>

            <div class="card-body p-4 p-md-5">

                <form id="loginForm">
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                            <input type="text" class="form-control form-control" 
                                   id="email" name="login" placeholder="Please Enter Email" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" class="form-control form-control" 
                                   id="password" name="password" placeholder="Please Enter Password" required>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-right-to-bracket"></i> Login
                        </button>
                    </div>

                </form>

                <hr class="my-4">

            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    
    // เมื่อฟอร์ม login ถูก submit
    $("#loginForm").on('submit', function(e) {
        e.preventDefault(); // หยุดการ submit ฟอร์มแบบเดิม

        // 1. แสดง Loading
        Swal.fire({
            title: 'กำลังเข้าสู่ระบบ...',
            text: 'กรุณารอสักครู่',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // 2. ส่งข้อมูลด้วย AJAX
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: "<?= base_url('public/api/login') ?>", // ยิงไปที่ API
            type: "post",
            data: formData, // ดึงข้อมูลทั้งฟอร์ม (email, password)
            processData: false,
            contentType: false,
            dataType: "json",
            
            // 3. ถ้าสำเร็จ (API ตอบกลับ 200 OK)
            success: function(response) {
                
                // (สำคัญมาก) เก็บ Token ไว้ใน localStorage
                localStorage.setItem('jwt_token', response.token);

                Swal.fire({
                    icon: 'success',
                    title: 'เข้าสู่ระบบสำเร็จ!',
                    text: response.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                     // ตัวอย่าง: พาไปหน้า Dashboard
                    window.location.href = "<?= base_url('public/dashboard') ?>"; 
                    
                    // (สำหรับทดสอบ) แจ้งเตือนว่าได้ Token แล้ว
                    //Swal.fire('รับ Token สำเร็จ!', 'Token ถูกเก็บใน localStorage เรียบร้อย', 'info');
                });
            },

            // 4. ถ้าล้มเหลว (API ตอบกลับ 401, 400, 500)
            error: function(xhr, status, error) {
                var errorMsg = "อีเมลหรือรหัสผ่านไม่ถูกต้อง"; // ค่าเริ่มต้น
                
                // พยายามดึงข้อความ Error จาก API
                if (xhr.responseJSON && xhr.responseJSON.messages) {
                    errorMsg = xhr.responseJSON.messages.error || Object.values(xhr.responseJSON.messages).join(', ');
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'เข้าสู่ระบบไม่สำเร็จ',
                    text: errorMsg
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>