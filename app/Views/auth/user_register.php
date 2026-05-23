<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('style') ?>
<style>
.modal.show {
    display: block;
}

#div.show {
    display: block;
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
div.dt-buttons > .my-custom-class {
    background-color: #007bff; /* Primary blue color */
    color: white;
    /* Other styles */
}
</style>
<?= $this->endsection() ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">ข้อมูลผู้ใช้งาน</h4>
                <p class="card-description">รายชื่อผู้ใช้งานที่ลงทะเบียนแล้ว</p>
                    <table id="userTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อ-นามสกุล</th>
                                <th>email</th>
                                <th>username</th>
                                <th>การอนุญาต</th>
                                <th></th>
                                <th>การจัดการ</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($registedData as $key => $value): ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= $value['fname'] ?></td>
                                <td><?= $value['email'] ?></td>
                                <td><?= $value['username'] ?></td>
                                <td><?= $value['permis'] ?></td>
                                <td><?= $value['cg_id'] ?> </td>
                                <td><button class="btn btn-sm btn-primary" id="btn-editUser" data-id="<?= $value['id'] ?>" OnClick="editUser(this)"><i class="fas fa-edit"></i> แก้ไข</button>
                                    <button class="btn btn-sm btn-danger" id="btn_delUser" data-id="<?= $value['id'] ?>"><i class="fas fa-trash"></i> ลบ</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Table for Caregiver -->
                    <!-- แสดงข้อมูล caregiver ที่มี hoscode เหมือนกับ userHcode -->
                    <?php if (!empty($cgAll)): ?>
                    <h4 class="mt-4">ข้อมูลผู้ดูแล (Caregiver)</h4>
                    <table id="caregiverTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อ-นามสกุล</th>
                                <th>ตำแหน่ง</th>
                                <th>username</th>
                                <th>PASSWORD</th>
                                <th>ใช้งานโปรแกรม</th>
                                <th>แก้ไขรหัสผ่าน</th>
                                <!-- เพิ่มคอลัมน์สำหรับ hoscode -->
                                <!-- คอลัมน์นี้สามารถซ่อนได้ถ้าไม่ต้องการให้แสดง -->
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($cgAll as $key => $value): ?>
                            <!-- ตรวจสอบว่า hoscode ตรงกับ userHcode หรือไม่ -->
                            <?php if ($value['hoscode'] == $user->hcode): ?>
                            <!-- หากตรงกันให้แสดงข้อมูล caregiver -->
                            <!-- แสดงเฉพาะข้อมูล caregiver ที่มี hoscode เหมือนกับ userHcode -->
                            <!-- หากไม่ตรงกันจะไม่แสดงในตารางนี้ -->
                            <!-- เนื่องจากเราต้องการแค่แสดง caregiver ที่มี hoscode เหมือนกับ userHcode -->
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= $value['cgname'] ?></td>
                                <td><?= $value['tumnang'] ?></td>
                                <td><?= $value['idcard'] ?></td>
                                <td><?= $value['tel'] ?></td> <!-- แสดง hoscode -->
                                <td><label class="switch">
                                    <input type="checkbox" <?= $value['addusers'] == 1 ? 'checked' : '' ?> 
                                      class="toggle-user" data-id="<?= $value['cgid'] ?>" onChange="changeStatus(this)">
                                    <span class="slider round"></span>
                                </td>
                                <td>
                                    <button id="btn-editPass" class="btn btn-primary btn-sm" data-id ="<?= $value['cgid'] ?>" onClick="editPass(this)" <?= $value['addusers'] == 0 ? 'disabled' : ''?>>แก้ไข</button>
                                </td>
                                <!-- เพิ่มคอลัมน์สำหรับ hoscode -->
                                <!-- คอลัมน์นี้สามารถซ่อนได้ถ้าไม่ต้องการให้แสดง -->
                            </tr>
                            <?php endif; ?> 
                            <?php endforeach; ?>
                        </tbody>    
                    </table>
                    <?php else: ?>
                        <p class="mt-4">ไม่มีข้อมูลผู้ดูแล (Caregiver) ที่ลงทะเบียนในหน่วยบริการนี้</p>
                    <?php endif; ?>
            </div>  
        </div>
    </div>
    <div class="modal" id="userModal">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">ข้อมูลผู้ใช้</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button> 
               </div>
               <div class="modal-body">
                  <div id="user_result"></div>      
               </div>
               <div class="modal-footer">
                   <div class="d-flex justify-content-between w-100">
                        <button type="button" id="btnSaveeditUser" class="btn btn-primary">บันทึก</button>
                        <button type="button" id="btnCloseUser" class="btn btn-danger" data-bs-dismiss="modal">ปิด</button>
                    </div>     
               </div>
            </div>
         </div>               
    </div>
    <div class="modal" id="modal-editpass">
        <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">แก้ไขรหัสผ่านใหม่</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
               <input type="hidden" name = "txtidcard" id="txtidcard">
               <input type="text" name="new-pass" id="new-pass" class="form-control">
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-between w-100">
                    <button type="button" id="btnSaveeditPass" class="btn btn-primary">บันทึก</button>
                    <button type="button" id="btnClose" class="btn btn-danger" data-bs-dismiss="modal">ปิด</button>
                </div>
            </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('#userTable').DataTable({
        fixedHeader: true,
        searching: false,
        paging: false,
        buttons: [
            {
                text: 'เพิ่มผู้ใช้งาน',
                className: 'my-custom-class',
                action: function ( e, dt, node, config ) {
                    // กำหนดการทำงานเมื่อคลิกปุ่ม "เพิ่มผู้ใช้งาน"
                    alert('คลิกปุ่มเพิ่มผู้ใช้งาน');
                    // คุณสามารถเปลี่ยนเป็นการเปิด modal หรือหน้าใหม่สำหรับการเพิ่มผู้ใช้งานได้ตามต้องการ
                }
            }
        ]
    });

    $('#caregiverTable').DataTable({
        fixedHeader: true,
        searching: false,
        paging: false,
    });
    /*$('#btn-editPass').on('click',function(e){
         e.preventDefault();
         var idcard = $(this).getAttribute('data-id');
         $('#modal-editpass').modal('show');  
         $('#txtidcard').val(idcard);           
    });
    */
    $('#btnSaveeditPass').on('click',function(e){
        e.preventDefault();
        const txtpassword = $('#new-pass').val();
        const txtidcard = $('#txtidcard').val();
        $.ajax({
            url: '<?= base_url('public/editPass') ?>',
            type: 'post',
            data : {
                idcard: txtidcard,
                pass: txtpassword
            },
            dataType: 'json',
            success: function(response){
                $('#modal-editpass').modal('hide');
                swal.fire(response.status,response.msg);
                location.reload();
            }
        });
    });

    $('#btnSaveeditUser').on('click',function(e){
          e.preventDefault();
          //var form = document.querySelector("#userEditProfile");
          //var formData = new FormData(form);
          /*$id = $this->request->getPost('txtid');
          $hoscode = $this->request->getPost('txtoffice');
        $orgcode = $this->request->getPost('txtorgcode');
        $email = $this->request->getPost('txtEmail');
        $fname = $this->request->getPost('txtfname');
        $username = $this->request->getPost('txtusername');
        $permis = $this->request->getPost('txtpermis');
        $password = $this->request->getPost('txtnewpassword');
        */
          let id = $('#txtid').val();
          let hoscode = $('#txtoffice').val();
          let orgcode = $('#txtorgcode').val();
          let email = $('#txtEmail').val();
          let fname = $('#txtfname').val();
          let username = $('#txtusername').val();
          let permis = $('#txtpermis').val();
          let password = $('#txtnewpassword').val();
          $.ajax({
             url: '<?= base_url('public/saveeditUserProfile') ?>',
             type: 'post',   
             data: {
                txtid : id,
                txtoffice : hoscode,
                txtorgcode : orgcode,
                txtEmail : email,
                txtfname : fname,
                txtusername : username,
                txtpermis : permis,
                txtnewpassword : password
             },
             dataType: 'json',
             success: function(response){
                swal.fire(response.status,response.msg,response.status);
                $('#userModal').modal('hide');
                
             },
             error: function(xhr, status, error) {
                swal.fire({
                    title: 'ผิดพลาด',
                    text: 'เกิดข้อผิดพลาดในการบันทึกข้อมูล'+xhr.responseText,
                    icon: 'error',
                    confirmButtonText: 'ตกลง'
                });
                console.error('เกิดข้อผิดพลาดในการบันทึกข้อมูล');
            }     
          });

    });

});
function editUser(element)
{
         const  id = element.getAttribute('data-id');
         $.ajax({
           url: "<?= base_url('public/getUserProfile') ?>",
           type: "post",
           data: {
              id : id
           },
           dataType: "json",
           success: function(response){
                $("#userModal").modal("show");
                let $html = "";
                response.forEach(function(item) {
                    $html += '<form id="userEditProfile" enctype="multipart/form-data" >';
                    $html  += '<input type="hidden" id="txtid" name="txtid" value="'+item.id+'">'; 
                    $html += '<label class="form-label" for="txtfname">ชื่อ-นามสกุล :</label>';
                    $html += '<input type="text" class="form-control" id="txtfname" name="txtfname" value="'+item.fname+'">';
                    $html += '<label class="form-label" for="txtEmail">Email :</label>';
                    $html += '<input type="text" class="form-control" id="txtEmail" name="txtEmail" value="'+item.email+'">';
                    $html += '<label class="form-label" for="txtoffice">หน่วยงาน :</label>';
                    $html += '<select class="form-control" id="txtoffice" name="txtoffice">';
                             <?php foreach($officeAll as $office): ?>
                               $html += '<option value="<?= $office['hcode'] ?>" ' + ("<?= $office['hcode'] ?>" == item.hcode ? "selected" : "") + '><?= $office['hname'] ?></option>';
                             <?php endforeach; ?>
                    $html += '</select>';
                    $html += '<label class="form-label" for="txtorgcode">ศูนย์ดูแล ผส. :</label>';
                    $html += '<select class="form-control" id="txtorgcode" name="txtorgcode">';
                    $html += '<option value="">โปรดเลือกศูนย์ดูแล ผส...</option>';
                             <?php foreach($officeAll as $office2): ?>
                               $html += '<option value="<?= $office2['hcode'] ?>" ' + ("<?= $office2['hcode'] ?>" == item.orgcode ? "selected" : "") + '><?= $office2['hname'] ?></option>';
                             <?php endforeach; ?>
                    $html += '</select>';
                    $html += '<label class="form-label" for="txtpermis">การอนุญาต :</label>';
                    $html += '<select class="form-control" id="txtpermis" name="txtpermis">';
                             <?php foreach ($permisAll as $item): ?>
                                 $html += '<option value="<?= $item['allow'] ?>" ' + ("<?= $item['allow'] ?>" == item.permis ? "selected" : "") + '><?= $item['usertypename'] ?></option>';
                             <?php endforeach; ?>
                    $html += '</select>';
                    $html += '<label class="form-label" for="txtusername">Username :</label>';
                    $html += '<input type="text" class="form-control" id="txtusername" name="txtusername" value="'+item.username+'">';
                    $html += '<label class="form-label" for="txtnewpassword">Password ใหม่ <span class="text-danger">(ถ้าไม่ต้องการแก้ไขให้ปล่อยว่างไว้)</span></label>';
                    $html += '<input type="text" class="form-control" id="txtnewpassword" name="txtnewpassword">';
                    $html += '</form>';            
                });
                $("#user_result").html($html);        
           },
            error: function(xhr, status, error) {
                console.error("เกิดข้อผิดพลาดในการดึงข้อมูล:", error);
            }

         });               
}
function editPass(element)
{
    let idcard = element.getAttribute('data-id');
         $('#modal-editpass').modal('show');  
         $('#txtidcard').val(idcard);   
}
function changeStatus(element) {
    let isChecked = element.checked ? 1 : 0;
    let id = element.getAttribute('data-id');
    if(isChecked == 1 ){
        $('#btn-editPass').prop('disabled',false);
    } else {
        $('#btn-editPass').prop('disabled',true);
    }
    //alert('CGID: ' + id + ', Active: ' + isChecked);                     
    $.ajax({
        url: '<?= base_url('public/userTogger') ?>',
        type: 'post',
        data: {
            cgid: id,
            active: isChecked
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                Swal.fire('สำเร็จ!', response.msg, 'success');
            } else {
                Swal.fire('ข้อผิดพลาด!', response.msg, 'error');
            }
            // รีโหลดตารางหลังจากอัปเดตสถานะ
        },
        error: function(xhr, status, error) {
            console.error(error);
            Swal.fire('ข้อผิดพลาด!', 'ไม่สามารถอัปเดตสถานะได้'+xhr.responseText, 'error');
        }
    });
}
</script>
<?= $this->endSection() ?>
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            

                            

                            

                            

                            

                            

                            

                            

                            

                            

                            

                            

                            

                            

                            

                            

                            

                            

                            

                            

                            

                            

                            

                            

                        