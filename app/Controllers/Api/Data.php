<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\OfficeModel;
use App\Models\UsertypeModel;

class Data extends BaseController
{
    use ResponseTrait;

    /**
     * API สำหรับค้นหา hcode/hname (Autocomplete)
     * รับค่า ?term=...
     */
    public function searchOffice()
    {
        $term = $this->request->getVar('term');
        if (empty($term)) {
            return $this->fail('กรุณาระบุคำค้นหา (term)', 400);
        }

        $officeModel = new OfficeModel();

        // ค้นหาทั้ง hcode และ hname ที่มีคำว่า $term
        $data = $officeModel->like('hcode', $term)
                            ->orLike('hname', $term)
                            ->findAll(10); // จำกัดผลลัพธ์แค่ 10 รายการ

        // จัดรูปแบบข้อมูลให้ jQuery UI Autocomplete (label, value)
        $results = [];
        foreach ($data as $item) {
            $results[] = [
                'label' => "{$item->hname} ({$item->hcode})", // สิ่งที่แสดงให้ผู้ใช้เห็น
                'value' => $item->hname, // สิ่งที่ใส่ในช่อง hname
                'hcode' => $item->hcode  // ข้อมูล hcode ที่จะเอาไปใส่ในช่อง hcode
            ];
        }

        return $this->respond($results);
    }
    public function searchusertype()
    {
        $term = $this->request->getVar('term');
        if (empty($term)) {
            return $this->fail('กรุณาระบุคำค้นหา (term)', 400);
        }

        $usetype = new UsertypeModel();
        $data = $usetype->like('usertypename', $term)
                        ->findAll(10);
        $result = [];
        foreach ($data as $item) {
            $result[] = [
                'label' => "{$item['usertypename']} ({$item['allow']})",
                'value' => $item['usertypename'],
                'allow' => $item['allow']
            ];
        } 

        return $this->respond($result);
    }
}