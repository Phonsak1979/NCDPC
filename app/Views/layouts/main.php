<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>NCDs Prevention Center</title>

    <link rel="icon" href="<?= base_url('dist/img/favicon.png') ?>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" 
          crossorigin="anonymous">
    
    <link rel="stylesheet" 
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
          integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" 
          crossorigin="anonymous" 
          referrerpolicy="no-referrer" />

    <link rel="stylesheet" 
          href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <link rel="stylesheet" 
          href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anuphan:wght@300;400;500;600;700&display=swap" 
          rel="stylesheet">
          
    <?= $this->renderSection('head_scripts') ?>

    <style>
        /* 1. ใช้ฟอนต์ Anuphan ทั่วทั้งเว็บ */
        body {
            font-family: 'Anuphan', sans-serif !important;
            background-color: #f0f8ff; /* AliceBlue */
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        input {
            font-family: 'Anuphan', sans-serif !important;
        }

        /* 2. การ์ดฟอร์ม */
        .auth-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
        }

        /* 3. หัวการ์ด (สีน้ำเงิน) */
        .auth-header {
            background-color: #0d6efd; /* Bootstrap Primary Blue */
            color: white;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
            padding: 1.5rem;
        }

        /* 4. สไตล์สำหรับ Logo */
        .auth-logo {
            max-height: 45px; /* ปรับขนาดโลโก้ (ที่มาจาก favicon) */
            margin-right: 12px;
        }

        /* 5. สไตล์สำหรับ icon ในช่อง input (สีน้ำเงิน) */
        .input-group-text {
            background-color: #0d6efd;
            color: white;
            border: 1px solid #0d6efd;
        }

        /* 6. Style สำหรับ jQuery UI Autocomplete (ให้เข้ากับ Bootstrap) */
        .ui-autocomplete {
            z-index: 1056; 
            font-family: 'Anuphan', sans-serif;
        }
        .ui-menu-item-wrapper {
            padding: 8px 12px;
        }
    </style>
</head>
<body>

    <main class="container">
        <?= $this->renderSection('content') ?>
    </main>

    <<!-- jQuery Core (required by jQuery UI) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> 
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.14.1/jquery-ui.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>