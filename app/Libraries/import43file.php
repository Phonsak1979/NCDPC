<?php
namespace App\Libraries;

class import43file
{
    private $db;
    private array $map = [
        'SCREENDM' => [
            'table' => 'screened_dm',
            'columns' => [
                'HOSPCODE'=>'hoscode','PID'=>'pid',
                'CHECK_VHID'=>'check_vhid','TYPEAREA'=>'typearea',
                'DATE_SCREEN'=>'date_screen','BSTEST'=>'bstest',
                'BSLEVEL'=>'bslevel','HOSP_SCREEN'=>'hosp_screen',
                'HOSP_INPUT'=>'hosp_input','RISK'=>'risk',
                'RESULT'=>'result'
                ],
                'unique' => ['hoscode','pid'],
        ],
        'SCREENHT' => [
            'table' => 'screened_ht',
            'columns' => [
                'HOSPCODE'=>'hoscode','PID'=>'pid',
                'CHECK_VHID'=>'check_vhid','TYPEAREA'=>'typearea',
                'DATE_SCREEN'=>'date_screen','BPS'=>'bps',
                'BPD'=>'bpd','HOSP_SCREEN'=>'hosp_screen',
                'HOSP_INPUT'=>'hosp_input','RISK'=>'risk',
                'RESULT'=>'result'
                ],
                'unique' => ['hoscode','pid'],
        ],  
        'SCREENCKD' => [
            'table' => 'screened_ckd',
            'columns' => [
                'HOSPCODE'=>'hoscode','PID'=>'pid',
                'CHECK_VHID'=>'check_vhid','TYPEAREA'=>'typearea',
                'DATE_SCREEN'=>'date_screen','GFR'=>'gfr',
                'PROTEINURIA'=>'proteinuria','HOSP_SCREEN'=>'hosp_screen',
                'HOSP_INPUT'=>'hosp_input','RISK'=>'risk',
                'RESULT'=>'result'
                ],
                'unique' => ['hoscode','pid'],
        ],
        'SCREENCVD' => [
            'table' => 'screened_cvd',
            'columns' => [
                'HOSPCODE'=>'hoscode','PID'=>'pid',
                'CHECK_VHID'=>'check_vhid','TYPEAREA'=>'typearea',
                'DATE_SCREEN'=>'date_screen','RISK_SCORE'=>'risk_score',
                'RISK_LEVEL'=>'risk_level','HOSP_SCREEN'=>'hosp_screen',
                'HOSP_INPUT'=>'hosp_input','RISK'=>'risk',
                'RESULT'=>'result'
                ],
                'unique' => ['hoscode','pid'],
        ],
    ];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function importFile(string $filePath): array
    {
        $ext = pathinfo($filePath, PATHINFO_EXTENSION);
        if ($ext === 'csv') {
            $this->importCSV($filePath);
        } elseif ($ext === 'xlsx') {
            $this->importXLSX($filePath);
        } else {
            throw new \Exception("Unsupported file type: $ext");
        }

        return ['status'=>'success','message'=>"File imported successfully: $filePath"];    

    }
    public function importCSV(string $filePath): array
    {
        $handle = fopen($filePath, 'r');
        if ($handle === false) {
            throw new \Exception("Cannot open file: $filePath");
        }

        $header = fgetcsv($handle);
        if ($header === false) {
            fclose($handle);
            throw new \Exception("Cannot read header from file: $filePath");
        }

        // Determine file type based on header
        $fileType = null;
        foreach ($this->map as $type => $config) {
            if (count(array_intersect($header, array_keys($config['columns']))) >= 5) {
                $fileType = $type;
                break;
            }
        }
        if ($fileType === null) {
            fclose($handle);
            throw new \Exception("Unknown file format: $filePath");
        }

        $config = $this->map[$fileType];
        $table = $config['table'];
        $columnsMap = $config['columns'];
        $uniqueKeys = $config['unique'] ?? [];

        // Prepare insert data
        $dataToInsert = [];
        while (($row = fgetcsv($handle)) !== false) {
            $rowData = array_combine($header, $row);
            if ($rowData === false) continue;

            // Map columns
            $mappedData = [];
            foreach ($columnsMap as $csvCol => $dbCol) {
                if (isset($rowData[$csvCol])) {
                    $mappedData[$dbCol] = trim($rowData[$csvCol]);
                }
            }
            if (empty($mappedData)) continue;

            // Check for uniqueness
            if (!empty($uniqueKeys)) {
                $where = [];
                foreach ($uniqueKeys as $key) {
                    if (isset($mappedData[$key])) {
                        $where[$key] = $mappedData[$key];
                    }
                }
                if (!empty($where)) {
                    // Check if record exists
                    $exists = $this->db->table($table)->where($where)->countAllResults() > 0;
                    if ($exists) continue; // Skip duplicate
                }
            }

            // Add to insert batch
            $dataToInsert[] = $mappedData;
        }

        fclose($handle);

        // Insert into database
        if (!empty($dataToInsert)) {
            foreach (array_chunk($dataToInsert, 100) as $chunk) {
                $this->db->table($table)->insertBatch($chunk);
            }
        }

        return ['status'=>'success','message'=>"File imported successfully: $filePath"];    
    }
    public function importXLSX(string $filePath): array
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        if (empty($rows)) {
            throw new \Exception("No data found in file: $filePath");
        }

        // Determine file type based on header
        $header = array_map('strtoupper', $rows[0]);
        $fileType = null;
        foreach ($this->map as $type => $config) {
            if (count(array_intersect($header, array_keys($config['columns']))) >= 5) {
                $fileType = $type;
                break;
            }
        }
        if ($fileType === null) {
            throw new \Exception("Unknown file format: $filePath");
        }

        // Process rows
        return $this->importFromRows($fileType, array_slice($rows, 1));
    }
    public function importFromRows(string $fileType, array $rows): array
    {
        $config = $this->map[$fileType];
        $table = $config['table'];
        $columnsMap = $config['columns'];
        $uniqueKeys = $config['unique'] ?? [];
        $dataToInsert = [];

        foreach ($rows as $row) {
            $rowData = array_combine(array_map('strtoupper', array_keys($columnsMap)), $row);
            if ($rowData === false) continue;

            // Map columns
            $mappedData = [];
            foreach ($columnsMap as $csvCol => $dbCol) {
                if (isset($rowData[$csvCol])) {
                    $mappedData[$dbCol] = trim($rowData[$csvCol]);
                }
            }
            if (empty($mappedData)) continue;

            // Check for uniqueness
            if (!empty($uniqueKeys)) {
                $where = [];
                foreach ($uniqueKeys as $key) {
                    if (isset($mappedData[$key])) {
                        $where[$key] = $mappedData[$key];
                    }
                }
                if (!empty($where)) {
                    // Check if record exists
                    $exists = $this->db->table($table)->where($where)->countAllResults() > 0;
                    if ($exists) continue; // Skip duplicate
                }
            }

            // Add to insert batch
            $dataToInsert[] = $mappedData;
        }   
        // Insert into database
        if (!empty($dataToInsert)) {    
            foreach (array_chunk($dataToInsert, 100) as $chunk) {
                $this->db->table($table)->insertBatch($chunk);
            }
        }  
        return ['status'=>'success','message'=>"File imported successfully with $fileType format"];
    } 
}