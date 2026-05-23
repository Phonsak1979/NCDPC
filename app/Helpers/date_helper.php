<?php
function date_thai_full($date) {
    if (!$date || $date == '0000-00-00') return "-";
    
    $months = [
        "", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
        "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
    ];

    $time = strtotime($date);
    $d = date('j', $time);
    $m = $months[date('n', $time)];
    $y = date('Y', $time) + 543; // บวกเป็น พ.ศ.

    return "$d $m $y";
}