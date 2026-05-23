<?php

namespace App\Controllers;

use App\Models\OfficeModel;
use App\Models\RiskdmModel;
use App\Models\RiskhtModel;
use App\Models\personModel;
use App\Models\NewDMModel;
use App\Models\NewHTModel;
use App\Models\NewdmhtModel;
use App\Models\HomeModel;
Use App\Models\OldDmModel;
use App\Models\OldHtModel;
use App\Models\DmckdModel;
use App\Models\OsmModel;
use App\Models\ScreenDMModel;
use App\Models\ScreenHTModel;
use App\Models\ScreenCKDModel;
use App\Models\ScreenCVDModel;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;   
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use CodeIgniter\HTTP\Response;

class ImportDataController extends BaseController
{
    private $OfficeModel;
    private $RiskdmModel;
    private $RiskhtModel;
    private $personModel;
    private $Officename;
    private $NewDmModel;
    private $NewHTModel;
    private $NewdmhtModel;
    private $HomeModel;
    private $OldDmModel;
    private $OldHtModel;
    private $dmckdModel;
    private $ScreenDMModel;
    private $ScreenHTModel;
    private $ScreenCKDModel;
    private $ScreenCVDModel;
    protected $response;
    protected $OsmModel;

    public function __construct()
    {
        helper('form');
        $this->OfficeModel = new OfficeModel();
        $this->RiskdmModel = new RiskdmModel();
        $this->RiskhtModel = new RiskhtModel();
        $this->personModel = new personModel();
        $this->NewDmModel = new NewDMModel();
        $this->NewHTModel = new NewHTModel();
        $this->NewdmhtModel = new NewdmhtModel();
        $this->HomeModel = new HomeModel();
        $this->OldDmModel = new OldDmModel();
        $this->OldHtModel = new OldHtModel();
        $this->dmckdModel = new DmckdModel();
        $this->OsmModel = new OsmModel();
        $this->ScreenDMModel = new ScreenDMModel();
        $this->ScreenHTModel = new ScreenHTModel();
        $this->ScreenCKDModel = new ScreenCKDModel();
        $this->ScreenCVDModel = new ScreenCVDModel();
    }
    /**
     * Render a view and automatically inject username + role.
     */
    protected function renderWithUser(string $view, array $extra = [])
    {
        // avoid static analysis error on $this->request->user by copying to a generic object
        /** @var object $req */
        $req = $this->request;
        $userData = $req->user ?? (object) ['fname' => '', 'role' => ''];

        $data = array_merge($extra, [
            'username'  => $userData->fname,
            'user_role' => $userData->role,
        ]);

        return view($view, $data);
    }

    public function importHdc()
    {
        return $this->renderWithUser('importdata/importfromhdc');
    }

    public function import43file()
    {
        return $this->renderWithUser('importdata/importfrom43file');
    }

    public function importNewPatient()
    {
        return $this->renderWithUser('importdata/importNewchronic');
    }
    public function importOldPatient()
    {
        return $this->renderWithUser('importdata/importOldchronic');
    }
    public function importOSM()
    {
        return $this->renderWithUser('importdata/importOsm.php');
    }
    /**
     * Generic spreadsheet importer.
     *
     * @param string   $inputName name of the file input field
     * @param callable $mapRow    maps a row array to an associative record or null to skip
     * @param object   $model     model instance that implements bulkInsert()
     * @return \CodeIgniter\HTTP\Response
     */
    /**
     * Generic spreadsheet importer.
     *
     * @param string   $inputName name of the file input field
     * @param callable $mapRow    maps a row array to an associative record or null to skip
     * @param object   $model     model instance that implements bulkInsert()
     * @return \CodeIgniter\HTTP\Response
     */
    protected function importSpreadsheet(string $inputName, callable $mapRow, $model)
    {
        // allow up to 10MB here to match the front‑end limit (previously 4MB)
        if (! $this->validate([
            $inputName => 'uploaded['.$inputName.']|max_size['.$inputName.',10240]|ext_in['.$inputName.',xlsx,xls,csv]'
        ])) {
            // provide a more expressive message so the UI can display it if needed
            $errors = $this->validator->getErrors();
            $msg = $errors ? implode(', ', $errors) : 'Invalid or missing file';
            return $this->response->setStatusCode(400)
                                  ->setJSON(['status' => 'error', 'msg' => $msg]);
        }

        $file = $this->request->getFile($inputName);
        $uploadPath = ROOTPATH . 'writable/uploads/excels/';
        if (! is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        $path = $this->uploadFile($uploadPath, $file);
        if (empty($path) || ! file_exists($path)) {
            return $this->response->setStatusCode(500)
                                  ->setJSON(['status' => 'error', 'msg' => 'Failed to save uploaded file']);
        }

        try {
            $sheet = $this->loadSpreadsheet($path);
        } catch (\Throwable $e) {
            return $this->response->setJSON(['status' => 'error', 'msg' => 'Failed to read spreadsheet: ' . $e->getMessage()]);
        }

        unlink($path);

        $rows = [];
        foreach ($sheet as $i => $row) {
            if ($i <= 1) {
                continue;
            }
            $mapped = $mapRow($row);
            if ($mapped !== null) {
                $rows[] = $mapped;
            }
        }

        if ($rows && $model->bulkInsert($rows)) {
            return $this->response->setJSON(['status' => 'success', 'msg' => 'นำเข้าข้อมูลสำเร็จ', 'records' => count($rows)]);
        }

        return $this->response->setStatusCode(409)
                              ->setJSON(['status' => 'error', 'msg' => 'ไม่มีข้อมูลใหม่หรือมีอยู่แล้ว']);
    }
    public function importDMrisk()
    {
        return $this->importSpreadsheet('excelFile', function ($val) {
            if ($this->RiskdmModel->getperByhcodepid(['hospcode' => $val[0], 'pid' => $val[3]])) {
                return null;
            }

            return [
                'hospcode'    => $val[0],
                'pid'         => $val[3],
                'sex'         => $val[6],
                'birth'       => date('Y-m-d', strtotime($val[7])),
                'hid'         => $val[8],
                'vhid'        => $val[10],
                'discharge'   => $val[12],
                'typearea'    => $val[13],
                'date_screen' => date('Y-m-d', strtotime($val[14])),
                'bstest'      => $val[15],
                'bslevel'     => $val[16],
                'result'      => $val[17],
            ];
        }, $this->RiskdmModel);
    }
    //นำเข้า ผู้มีความเสี่ยงความดัน
    public function importHTrisk()
    {
        return $this->importSpreadsheet('excelFile2', function ($val) {
            if ($this->RiskhtModel->getperByhcodepid(['hospcode' => $val[0], 'pid' => $val[3]])) {
                return null;
            }
            return [
                'hospcode'    => $val[0],
                'pid'         => $val[3],
                'sex'         => $val[6],
                'birth'       => date('Y-m-d', strtotime($val[7])),
                'hid'         => $val[8],
                'vhid'        => $val[10],
                'discharge'   => $val[12],
                'typearea'    => $val[13],
                'date_screen' => date('Y-m-d', strtotime($val[14])),
                'sbp'         => $val[15],
                'dbp'         => $val[16],
                'result'      => $val[17],
            ];
        }, $this->RiskhtModel);
    }
     //นำเข้า ผู้ป่วยเบาหวานรายใหม่
    public function importnewDM()
    {
        return $this->importSpreadsheet('excelFile', function ($val) {
            if ($this->NewDmModel->getperByhcodepid(['hospcode' => $val[0], 'pid' => $val[3],'year_dx'=>date('Y', strtotime($val[34]))])) {
                return null;
            }
            return [
                'hospcode'      => $val[0],
                'pid'           => $val[3],
                'vhid'          => $val[10],
                'mix_dx'        => $val[15],
                'type_dx'       => $val[16],
                'date_dx'       => date('Y-m-d', strtotime($val[17])),
                'hosp_dx'       => $val[18],
                'ld_hba1c'      => date('Y-m-d', strtotime($val[19])),
                'rs_hba1c'      => $val[20],
                'ih_hba1c'      => $val[21],
                'ld_fpg1'       => date('Y-m-d', strtotime($val[22])),
                'rs_fpg1'       => $val[23],
                'ih_fpg1'       => $val[24],
                'ld_fpg2'       => date('Y-m-d', strtotime($val[25])),
                'rs_fpg2'       => $val[26],
                'ih_fpg2'       => $val[27],
                'ld_retina'     => date('Y-m-d', strtotime($val[28])),
                'rs_retina'     => $val[29],
                'ih_retina'     => $val[30],
                'ld_foot'       => date('Y-m-d', strtotime($val[31])),
                'rs_foot'       => $val[32],
                'ih_foot'       => $val[33],
                'min_date_dx_dm'=> date('Y-m-d', strtotime($val[34])),
                'year_dx'       => date('Y', strtotime($val[34])),
            ];
        }, $this->NewDmModel);
    }
    //นำเข้า ผู้ป่วยความดันรายใหม่
    public function importnewHT()
    {
        return $this->importSpreadsheet('excelFile2', function ($val) {
            if ($this->NewHTModel->getperByhcodepid(['hospcode' => $val[0], 'pid' => $val[3],'year_dx'=>date('Y', strtotime($val[27]))])) {
                return null;
            }
            return [
                'hospcode'    => $val[0],
                'pid'         => $val[3],
                'hid'         => $val[8],
                'vhid'        => $val[10],
                'discharge'   => $val[12],
                'typearea'    => $val[13],
                'source_tb'   => $val[14],
                'mix_dx'      => $val[15],  
                'type_dx'     => $val[16],
                'date_dx'     => date('Y-m-d', strtotime($val[17])),
                'hosp_dx'     => $val[18],
                'ld_bp1'      => date('Y-m-d', strtotime($val[19])),
                'ih_bp1'      => $val[20],   
                'rs_bps1'     => $val[21],
                'rs_bpd1'     => $val[22],
                'ld_bp2'      => date('Y-m-d', strtotime($val[23])),
                'ih_bp2'      => $val[24],   
                'rs_bps2'     => $val[25],
                'rs_bpd2'     => $val[26],
                'min_date_dx_ht' => date('Y-m-d', strtotime($val[27])),
                'year_dx'    => date('Y', strtotime($val[27]))
            ];
        }, $this->NewHTModel);
    }
    //นำเข้าเบาหวาน+ความดันรายใหม่
    public function importnewDMHT()
    {
        return $this->importSpreadsheet('excelFile3', function ($val) {
            if ($this->NewdmhtModel->getperByhcodepid(['hospcode' => $val[0], 'pid' => $val[3],'year_dx'=>date('Y', strtotime($val[44]))])) {
                return null;
            }
            return [
                'hospcode'      => $val[0],
                'pid'           => $val[3],
                'vhid'          => $val[10],
                'mix_dx'        => $val[15],
                'type_dx'       => $val[16],
                'date_dx'       => $val[17],
                'hosp_dx'       => $val[18],
                'ld_hba1c'      => date('Y-m-d', strtotime($val[20])),
                'rs_hba1c'      => $val[21],
                'ih_hba1c'      => $val[22],
                'ld_fpg1'       => date('Y-m-d', strtotime($val[23])),
                'rs_fpg1'       => $val[24],
                'ih_fpg1'       => $val[25],
                'ld_fpg2'       => date('Y-m-d', strtotime($val[26])),
                'rs_fpg2'       => $val[27],
                'ih_fpg2'       => $val[28],
                'ld_retina'     => date('Y-m-d', strtotime($val[29])),
                'rs_retina'     => $val[30],
                'ih_retina'     => $val[31],
                'ld_foot'       => date('Y-m-d', strtotime($val[32])),
                'rs_foot'       => $val[33],
                'ih_foot'       => $val[34],
                'ld_bp1'      => date('Y-m-d', strtotime($val[35])),
                'ih_bp1'      => $val[36],   
                'rs_bps1'     => $val[37],
                'rs_bpd1'     => $val[38],
                'ld_bp2'      => date('Y-m-d', strtotime($val[39])),
                'ih_bp2'      => $val[40],   
                'rs_bps2'     => $val[41],
                'rs_bpd2'     => $val[42],
                'min_date_dx_dm'=> date('Y-m-d', strtotime($val[43])),
                'min_date_dx_ht' => date('Y-m-d', strtotime($val[44])),
                'year_dx'       => date('Y', strtotime($val[44])),
            ];
        }, $this->NewdmhtModel);
    }
    public function importoldDM()
    {
        return $this->importSpreadsheet('excelFile', function ($val) {
            if ($this->OldDmModel->getperByhcodepid(['hospcode' => $val[0], 'pid' => $val[3],'year_dx'=>date('Y', strtotime($val[35]))])) {
                return null;
            }
            return [
                'hospcode'      => $val[0],
                'pid'           => $val[3],
                'vhid'          => $val[10],
                'mix_dx'        => $val[15],
                'type_dx'       => $val[16],
                'date_dx'       => date('Y-m-d', strtotime($val[17])),
                'hosp_dx'       => $val[18],
                'ld_hba1c'      => date('Y-m-d', strtotime($val[20])),
                'rs_hba1c'      => $val[21],
                'ih_hba1c'      => $val[22],
                'ld_fpg1'       => date('Y-m-d', strtotime($val[23])),
                'rs_fpg1'       => $val[24],
                'ih_fpg1'       => $val[25],
                'ld_fpg2'       => date('Y-m-d', strtotime($val[26])),
                'rs_fpg2'       => $val[27],
                'ih_fpg2'       => $val[28],
                'ld_retina'     => date('Y-m-d', strtotime($val[29])),
                'rs_retina'     => $val[30],
                'ih_retina'     => $val[31],
                'ld_foot'       => date('Y-m-d', strtotime($val[32])),
                'rs_foot'       => $val[33],
                'ih_foot'       => $val[34],
                'min_date_dx_dm'=> date('Y-m-d', strtotime($val[35])),
                'year_dx'       => date('Y', strtotime($val[35])),
            ];
        }, $this->OldDmModel);
    }
    //นำเข้า ผู้ป่วยความดันรายใหม่
    public function importoldHT()
    {
        return $this->importSpreadsheet('excelFile2', function ($val) {
            if ($this->OldHtModel->getperByhcodepid(['hospcode' => $val[0], 'pid' => $val[3],'year_dx'=>date('Y', strtotime($val[28]))])) {
                return null;
            }
            return [
                'hospcode'    => $val[0],
                'pid'         => $val[3],
                'hid'         => $val[8],
                'vhid'        => $val[10],
                'discharge'   => $val[12],
                'typearea'    => $val[13],
                'source_tb'   => $val[14],
                'mix_dx'      => $val[15],  
                'type_dx'     => $val[16],
                'date_dx'     => date('Y-m-d', strtotime($val[17])),
                'hosp_dx'     => $val[18],
                'ld_bp1'      => date('Y-m-d', strtotime($val[20])),
                'ih_bp1'      => $val[21],   
                'rs_bps1'     => $val[22],
                'rs_bpd1'     => $val[23],
                'ld_bp2'      => date('Y-m-d', strtotime($val[24])),
                'ih_bp2'      => $val[25],   
                'rs_bps2'     => $val[26],
                'rs_bpd2'     => $val[27],
                'min_date_dx_ht' => date('Y-m-d', strtotime($val[28])),
                'year_dx'    => date('Y', strtotime($val[28]))
            ];
        }, $this->OldHtModel);
    }
    //นำเข้าผู้ป่วยโรคไตจากเบาหวาน
    public function importdmCKD()
    {
        return $this->importSpreadsheet('excelFile4', function ($val) {
            if ($this->dmckdModel->getperByhcodepid(['hospcode' => $val[0], 'pid' => $val[3]])) {
                return null;
            }
            return [
                'hospcode'    => $val[0],
                'pid'         => $val[3],
                'hid'         => $val[8],
                'vhid'        => $val[10],
                'discharge'   => $val[12],
                'group_diag'  => $val[14],
                'group_date'  => $val[15],
                'group_hos_dx'=> $val[16],
                'min_date_dx' => date('Y-m-d', strtotime($val[17])),
            ];
        }, $this->dmckdModel);
    }
    //นำเข้า อสม.
    public function importDataOsm()
    {
        return $this->importSpreadsheet('excelFile3', function ($val) {
            if ($this->OsmModel->getperByhcodepid(['cid' => $val[0]])) {
                return null;
            }
            return [
                'cid'    => $val[0],
                'prename'  => trim($val[1]),
                'fname' => $val[2],
                'lname' => $val[3],
                'birth'  => date('Y-m-d', strtotime($val[9])),
                'osm_year' => $val[11],
                'hcode'  => $val[16],
                'acc_number'  => $val[19],
                'bank'  => $val[20],
                'tel'=> $val[22],
            ];
        }, $this->OsmModel);
    }
    //นำเข้า Person.txt ประชากร 
    public function importPersonData()
    {
        $validationRule = [
            'textFile' => [
                'label' => 'Text File',
                'rules' => 'uploaded[textFile]|max_size[textFile,2048]|ext_in[textFile,txt,csv,xlsx,xls]',
            ],
        ];
        
        if (! $this->validate($validationRule)) {
            session()->setFlashdata('error', $this->validator->getErrors() ? implode(', ', $this->validator->getErrors()) : 'กรุณาเลือกไฟล์ข้อมูล');
            return redirect()->to(base_url('public/importData/importDatafrom43file'));
        }
        
        $file = $this->request->getFile('textFile');
        
        // สร้างโฟลเดอร์สำหรับเก็บไฟล์ถ้ายังไม่มี
        $uploadPath = ROOTPATH.'writable/uploads/excels/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        
        // บันทึกไฟล์
        $fileName = $this->uploadFile($uploadPath, $file);
        $arr_file = explode('.', $fileName);
        $extension = strtolower(end($arr_file));
        // อ่านข้อมูลจากไฟล์
        $data = [];
        if ($extension === 'xlsx' || $extension === 'xls') {
            try {
                $data = $this->loadSpreadsheet($fileName);
            } catch (\Throwable $e) {
                unlink($fileName);
                return $this->response->setJSON(['status' => 'error', 'msg' => 'Failed to read spreadsheet: ' . $e->getMessage()]);
            }
        } else {
            // สำหรับไฟล์ CSV หรือ TXT
            $handle = fopen($fileName, "r");
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    $data[] = explode('|', trim($line));
                }
                fclose($handle);
            }
        }
        
        // ประมวลผลข้อมูล
        $personData = [];
        $count = 0;
        
        foreach($data as $idx => $row){
            // ข้ามบรรทัดแรกที่เป็นหัวตาราง (ถ้ามี)
            if($idx > 0 && count($row) >= 10){
                // ตรวจสอบว่ามีข้อมูล CID หรือไม่
                if(!empty($row[1])){
                    // ตรวจสอบว่ามีข้อมูลในระบบแล้วหรือไม่
                    $result = $this->personModel->getPersonByCid($row[1]);
                    if(!$result){
                        // แปลงรูปแบบวันที่เกิด
                        $birth = '';
                        if(!empty($row[9])){
                            $birthStr = trim($row[9]);
                            if(strlen($birthStr) >= 8){
                                $birth = substr($birthStr, 0, 4) . '-' . substr($birthStr, 4, 2) . '-' . substr($birthStr, 6, 2);
                            }
                        }
                        
                        // เตรียมข้อมูลสำหรับบันทึก
                        $personData[] = [
                            'hospcode' => $row[0] ?? '',
                            'cid' => $row[1],
                            'pid' => $row[2] ?? '',
                            'hid' => $row[3] ?? '',
                            'prename' => $row[4] ?? '',
                            'fname' => $row[5] ?? '',
                            'lname' => $row[6] ?? '',
                            'hn' => $row[7] ?? '',
                            'sex' => $row[8] ?? '',
                            'birth' => $birth,
                            'mstatus' => $row[10] ?? '',
                            'typearea' => isset($row[29]) ? $row[29] : '',
                            'd_update' => date('Y-m-d H:i:s')
                        ];
                        
                        $count++;
                        
                        // บันทึกข้อมูลทุก 100 รายการเพื่อลดการใช้หน่วยความจำ
                        if($count % 100 == 0){
                            $this->personModel->BulkInsert($personData);
                            $personData = [];
                        }
                    }
                }
            }
        }
        
        // บันทึกข้อมูลที่เหลือ
        if(count($personData) > 0){
            $this->personModel->BulkInsert($personData);
        }
        
        // ลบไฟล์หลังจากนำเข้าข้อมูลเสร็จ
        if(file_exists($fileName)){
            unlink($fileName);
        }
        
        if($count > 0){
            return $this->response->setJSON(['status'=>'success','msg'=>'นำเข้าข้อมูลสำเร็จ','reccord'=>$count]);
        }else{
            return $this->response->setJSON(['status'=>'error','msg'=>'มีข้อมูลในฐานแล้ว..ไม่สามารถนำเข้าข้อมูลได้อีก']);
        }
        
        return redirect()->to(base_url('public/importData/importDatafrom43file'));
    }
    public function importHomeData()
    {
        $validationRule = [
            'textFile' => [
                'label' => 'Text File',
                'rules' => 'uploaded[textFile]|max_size[textFile,2048]|ext_in[textFile,txt,csv,xlsx,xls]',
            ],
        ];
        
        if (! $this->validate($validationRule)) {
            session()->setFlashdata('error', $this->validator->getErrors() ? implode(', ', $this->validator->getErrors()) : 'กรุณาเลือกไฟล์ข้อมูล');
            return redirect()->to(base_url('public/importData/importDatafrom43file'));
        }
        
        $file = $this->request->getFile('textFile');
        
        // สร้างโฟลเดอร์สำหรับเก็บไฟล์ถ้ายังไม่มี
        $uploadPath = ROOTPATH.'writable/uploads/excels/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        
        // บันทึกไฟล์
        $fileName = $this->uploadFile($uploadPath, $file);
        $arr_file = explode('.', $fileName);
        $extension = strtolower(end($arr_file));
        // อ่านข้อมูลจากไฟล์
        $data = [];
        if ($extension === 'xlsx' || $extension === 'xls') {
            try {
                $data = $this->loadSpreadsheet($fileName);
            } catch (\Throwable $e) {
                unlink($fileName);
                return $this->response->setJSON(['status' => 'error', 'msg' => 'Failed to read spreadsheet: ' . $e->getMessage()]);
            }
        } else {
            // สำหรับไฟล์ CSV หรือ TXT
            $handle = fopen($fileName, "r");
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    $data[] = explode('|', trim($line));
                }
                fclose($handle);
            }
        }
        
        // ประมวลผลข้อมูล
        $homeData = [];
        $count = 0;
        
         foreach($data as $idx => $row){
            // ข้ามบรรทัดแรกที่เป็นหัวตาราง (ถ้ามี)
            if($idx > 0 && count($row) >= 38){
                // ตรวจสอบว่ามีข้อมูล CID หรือไม่
                if(!empty($row[1])){
                    // ตรวจสอบว่ามีข้อมูลในระบบแล้วหรือไม่
                    $result = $this->HomeModel->getHomeByhid($row[0],$row[1]);
                    if(!$result){
                                               
                        // เตรียมข้อมูลสำหรับบันทึก
                        $homeData[] = [
                            'hospcode' => $row[0] ?? '',
                            'hid' => $row[1],
                            'village' => $row[11],
                            'tambon' => $row[12],
                            'ampur' => $row[13],
                            'changwat' => $row[14],
                            'latitude' => $row[16] ?? '',
                            'longitude' => $row[17] ?? '',
                            'nfamily' => $row[18] ?? '',
                            'd_update' => $row[37] ?? date('Y-m-d H:i:s')
                        ];
                        
                        $count++;
                        
                        // บันทึกข้อมูลทุก 100 รายการเพื่อลดการใช้หน่วยความจำ
                        if($count % 100 == 0){
                            $this->HomeModel->BulkInsert($homeData);
                            $homeData = [];
                        }
                    }
                }
            }
        }
        
        // บันทึกข้อมูลที่เหลือ
        if(count($homeData) > 0){
            $this->HomeModel->BulkInsert($homeData);
        }
        
        // ลบไฟล์หลังจากนำเข้าข้อมูลเสร็จ
        if(file_exists($fileName)){
            unlink($fileName);
        }
        
        if($count > 0){
            return $this->response->setJSON(['status'=>'success','msg'=>'นำเข้าข้อมูลสำเร็จ','reccord'=>$count]);
        }else{
            return $this->response->setJSON(['status'=>'error','msg'=>'มีข้อมูลในฐานแล้ว..ไม่สามารถนำเข้าข้อมูลได้อีก']);
        }
        
        return redirect()->to(base_url('public/importData/importDatafrom43file'));
    }
/**
     * Read a spreadsheet file on disk and return it as a row array.
     *
     * @throws \Throwable when loading fails
     */
    protected function loadSpreadsheet(string $path): array
    {
        $ext  = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        switch ($ext) {
            case 'csv':
                $reader = new Csv();
                break;
            case 'xls':
                $reader = new Xls();
                break;
            default:
                $reader = new Xlsx();
        }

        $spreadsheet = $reader->load($path);
        return $spreadsheet->getActiveSheet()->toArray();
    }

    public function uploadFile($path, $image) {
        if (!is_dir($path)) {
            mkdir($path, 0777, TRUE);
        }
        if ($image->isValid() && ! $image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move($path, $newName);
            $cleanPath = rtrim($path, '/\\') . DIRECTORY_SEPARATOR;
            return $cleanPath . $newName;
        }
        return "";
    }

    public function importScreen()
    {
        return $this->renderWithUser('importdata/importScreen');
    }
    public function importScreen_dm ()
    {
        return $this->importSpreadsheet('excelFile', function ($val) {
            if ($this->ScreenDMModel->getperByhcodepid(['hospcode' => $val[0], 'pid' => $val[2]])) {
                return null;
            }

            return [
                'hospcode'    => $val[0],
                'pid'         => $val[2],
                'check_vhid'  => $val[10],
                'typearea'    => $val[13],
                'date_screen' => date('Y-m-d', strtotime($val[14])),
                'bstest'      => $val[15],
                'bslevel'     => $val[16],
                'hosp_screen' => $val[17],
                'hosp_input'  => $val[18],
                'risk'        => $val[20],
                'result'      => $val[21]
            ];
        },$this->ScreenDMModel);
    }
    public function importScreen_ht ()
    {
        return $this->importSpreadsheet('excelFile2', function ($val) {
            if ($this->ScreenHTModel->getperByhcodepid(['hospcode' => $val[0], 'pid' => $val[3]])) {
                return null;
            }

            return [
                'hospcode'    => $val[0],
                'pid'         => $val[2],
                'check_vhid'  => $val[10],
                'typearea'    => $val[12],
                'date_screen' => date('Y-m-d', strtotime($val[13])),
                'sbp'         => $val[14],
                'dbp'         => $val[15],
                'hosp_screen' => $val[16],
                'hosp_input'  => $val[17],
                'risk'        => $val[19],
                'result'      => $val[20]
            ];
        },$this->ScreenHTModel);    
    }

}