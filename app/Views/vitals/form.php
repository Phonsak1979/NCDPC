<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" type="image/x-icon" href="<?=base_url('/images/smmicon.ico');?>">
   <!-- Latest compiled and minified CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!--<script src="assets/instascan.min.js"></script>-->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>	
    <!-- This is what you need -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
    <!--.......................-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
	  <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@300&display=swap" rel="stylesheet">
<title>บันทึกข้อมูลสุขภาพ</title>
<meta name="csrf-token" content="<?= csrf_hash() ?>">
<style>
:root {
  --teal:       #0d9488;
  --teal-light: #ccfbf1;
  --teal-dark:  #0f766e;
  --blue:       #2563eb;
  --blue-light: #dbeafe;
  --orange:     #ea580c;
  --orange-light:#ffedd5;
  --red:        #dc2626;
  --red-light:  #fee2e2;
  --amber:      #d97706;
  --amber-light:#fef3c7;
  --green:      #16a34a;
  --green-light:#dcfce7;
  --bg:         #f0fdf8;
  --surface:    #ffffff;
  --border:     #d1fae5;
  --text:       #134e4a;
  --muted:      #5eead4;
  --muted-text: #6b7280;
  --primary-color: #f307d7;
  --secondary-color: #cb4ae2;
  --text-color: #0a1c2f;
  --background-color: #d6ebd7;
}
* { box-sizing: border-box; margin: 0; padding: 0; }
body {
  font-family: 'Sarabun', 'Noto Sans Thai', system-ui, sans-serif;
  background: var(--bg);
  color: var(--text);
  min-height: 100vh;
  padding: 2rem 1rem 4rem;
}
.page-wrap { max-width: 680px; margin: 0 auto; }

/* ─── Page header ─── */
.page-header {
  text-align: center;
  margin-bottom: 2rem;
}
.page-header h1 {
  font-size: 22px;
  font-weight: 700;
  color: var(--teal-dark);
  letter-spacing: -0.3px;
}
.page-header p {
  font-size: 13px;
  color: var(--muted-text);
  margin-top: 4px;
}
.header-section {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    padding: 1.5rem 1rem;
    border-radius: 0 0 25px 25px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
}

.header-content {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
}

.header-logo {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

.header-text {
    text-align: center;
    color: white;
}

.header-text h2 {
    font-size: 1.8rem;
    margin: 0;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
}

.header-text h3 {
    font-size: 1.2rem;
    margin: 0.5rem 0 0;
    opacity: 0.9;
}
/* ─── Section card ─── */
.card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 18px;
  padding: 1.5rem;
  margin-bottom: 1.25rem;
}
.card-header {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 1.25rem;
  padding-bottom: 0.875rem;
  border-bottom: 1px solid #f0fdf8;
}
.card-icon {
  width: 36px; height: 36px;
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: 18px; flex-shrink: 0;
}
.icon-bmi    { background: var(--teal-light); }
.icon-bp     { background: var(--blue-light); }
.icon-sugar  { background: var(--orange-light); }
.card-header h2 {
  font-size: 15px;
  font-weight: 700;
  color: var(--text);
}
.card-header span {
  font-size: 12px;
  color: var(--muted-text);
  font-weight: 400;
}

/* ─── Form grid ─── */
.form-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 14px;
}
.form-grid.cols-3 { grid-template-columns: 1fr 1fr 1fr; }
.form-grid.full   { grid-template-columns: 1fr; }

#nav {
  background: var(--primary-color);
  padding: 0.8rem;
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
}

.nav-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 1rem;
}

.user-info {
  color: white;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.logout-btn {
  background: rgba(255,255,255,0.2);
  color: white;
  border: none;
  padding: 0.5rem 1.5rem;
  border-radius: 25px;
  font-size: 0.9rem;
  transition: all 0.3s ease;
}

.logout-btn:hover {
  background: rgba(255,255,255,0.3);
}

@media (max-width: 480px) {
  .form-grid, .form-grid.cols-3 { grid-template-columns: 1fr; }
}

.field { display: flex; flex-direction: column; gap: 5px; }
.field label {
  font-size: 12px;
  font-weight: 600;
  color: var(--muted-text);
  text-transform: uppercase;
  letter-spacing: 0.4px;
}
.field input, .field select {
  padding: 11px 14px;
  border: 1.5px solid #e5e7eb;
  border-radius: 10px;
  font-size: 15px;
  font-family: inherit;
  color: var(--text);
  background: #fafafa;
  transition: border-color 0.15s, background 0.15s;
  outline: none;
  width: 100%;
}
.field input:focus, .field select:focus {
  border-color: var(--teal);
  background: #fff;
}
.field .unit {
  font-size: 11px;
  color: var(--muted-text);
  margin-top: 2px;
}

/* ─── BMI result box ─── */
.bmi-result {
  margin-top: 1.25rem;
  padding: 14px 18px;
  border-radius: 12px;
  background: #f0fdf8;
  border: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  flex-wrap: wrap;
}
.bmi-val {
  font-size: 32px;
  font-weight: 700;
  color: var(--teal-dark);
  line-height: 1;
}
.bmi-val span {
  font-size: 13px;
  font-weight: 400;
  color: var(--muted-text);
  margin-left: 4px;
}
.bmi-badge {
  padding: 5px 14px;
  border-radius: 99px;
  font-size: 13px;
  font-weight: 600;
}
.bmi-badge.underweight { background: var(--blue-light);   color: var(--blue); }
.bmi-badge.normal      { background: var(--green-light);  color: var(--green); }
.bmi-badge.overweight  { background: var(--amber-light);  color: var(--amber); }
.bmi-badge.obese1      { background: var(--orange-light); color: var(--orange); }
.bmi-badge.obese2      { background: var(--red-light);    color: var(--red); }
.bmi-empty {
  font-size: 14px;
  color: var(--muted-text);
  font-style: italic;
}

/* ─── Status indicator strips ─── */
.status-strip {
  margin-top: 1rem;
  padding: 10px 14px;
  border-radius: 10px;
  font-size: 13px;
  font-weight: 500;
  display: none;
  align-items: center;
  gap: 8px;
}
.status-strip.show { display: flex; }
.status-dot {
  width: 8px; height: 8px;
  border-radius: 50%;
  flex-shrink: 0;
}
.strip-normal   { background: var(--green-light);  color: var(--green); }
.strip-elevated { background: var(--amber-light);  color: var(--amber); }
.strip-stage1   { background: var(--orange-light); color: var(--orange); }
.strip-stage2   { background: var(--red-light);    color: var(--red); }
.strip-crisis   { background: #fce7f3;             color: #9d174d; }
.strip-prediabetes { background: var(--amber-light);  color: var(--amber); }
.strip-diabetes    { background: var(--red-light);    color: var(--red); }
.strip-normal .status-dot    { background: var(--green); }
.strip-elevated .status-dot  { background: var(--amber); }
.strip-stage1 .status-dot    { background: var(--orange); }
.strip-stage2 .status-dot    { background: var(--red); }
.strip-crisis .status-dot    { background: #9d174d; }
.strip-prediabetes .status-dot { background: var(--amber); }
.strip-diabetes .status-dot    { background: var(--red); }

/* ─── Date row ─── */
.date-row {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 18px;
  padding: 1.25rem 1.5rem;
  margin-bottom: 1.25rem;
}

/* ─── Note ─── */
.note-field {
  width: 100%;
  padding: 11px 14px;
  border: 1.5px solid #e5e7eb;
  border-radius: 10px;
  font-size: 14px;
  font-family: inherit;
  color: var(--text);
  background: #fafafa;
  resize: vertical;
  min-height: 72px;
  outline: none;
  transition: border-color 0.15s;
}
.note-field:focus { border-color: var(--teal); background: #fff; }

/* ─── Submit button ─── */
.submit-wrap { text-align: center; margin-top: 0.5rem; }
.btn-submit {
  padding: 14px 48px;
  background: var(--teal);
  color: #fff;
  border: none;
  border-radius: 12px;
  font-size: 15px;
  font-weight: 700;
  font-family: inherit;
  cursor: pointer;
  transition: background 0.15s, transform 0.1s;
  letter-spacing: 0.2px;
}
.btn-submit:hover  { background: var(--teal-dark); }
.btn-submit:active { transform: scale(0.98); }
.btn-submit.loading { opacity: 0.6; cursor: wait; pointer-events: none; }

/* ─── Toast ─── */
.toast {
  position: fixed;
  bottom: 2rem;
  left: 50%;
  transform: translateX(-50%) translateY(120%);
  background: #fff;
  border: 1px solid var(--border);
  border-radius: 12px;
  padding: 12px 20px;
  font-size: 14px;
  font-weight: 500;
  box-shadow: 0 4px 24px rgba(0,0,0,0.10);
  transition: transform 0.3s ease;
  z-index: 999;
  min-width: 240px;
  text-align: center;
  white-space: nowrap;
}
.toast.show { transform: translateX(-50%) translateY(0); }
.toast.success { border-color: #86efac; color: var(--green); }
.toast.error   { border-color: #fca5a5; color: var(--red); }
@media (max-width: 480px) {
    .menu-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .header-logo {
        width: 50px;
        height: 50px;
    }
}
</style>
</head>
<body>
<div class="page-wrap">
  <div class="header-section">
        <div class="header-content">
            <img src="<?=base_url('images/ltc_logo.png')?>" class="header-logo" alt="LTC Logo">
            <div class="header-text">
                <h2>บันทึกข้อมูลสุขภาพ</h2>
                <h4><?= $riskname ?></h4>
                <input type="hidden" id="hospcode" value="<?= esc($hospcode) ?>" name="hospcode">
                <input type="hidden" id="pid" value="<?= esc($pid) ?>" name="pid">
            </div>
            <img src="<?=base_url('images/pcc.jpg')?>" class="header-logo" alt="PCC Logo">
        </div>
  </div>
  <!-- วันที่บันทึก -->
  <div class="date-row">
    <div class="field">
      <label>วันที่และเวลาบันทึก</label>
      <input type="datetime-local" id="recorded_at">
    </div>
  </div>

  <!-- ─── น้ำหนัก / ส่วนสูง / BMI ─── -->
  <div class="card">
    <div class="card-header">
      <div class="card-icon icon-bmi">⚖️</div>
      <div>
        <h2>น้ำหนักและส่วนสูง</h2>
        <span>คำนวณ BMI อัตโนมัติ</span>
      </div>
    </div>
    <div class="form-grid">
      <div class="field">
        <label>น้ำหนัก</label>
        <input type="number" id="weight" placeholder="เช่น 65.0" step="0.1" min="1" max="300" oninput="calcBmi()">
        <span class="unit">กิโลกรัม (kg)</span>
      </div>
      <div class="field">
        <label>ส่วนสูง</label>
        <input type="number" id="height" placeholder="เช่น 165.0" step="0.1" min="50" max="250" oninput="calcBmi()">
        <span class="unit">เซนติเมตร (cm)</span>
      </div>
    </div>
    <div class="bmi-result" id="bmi-result">
      <span class="bmi-empty">กรอกน้ำหนักและส่วนสูงเพื่อคำนวณ BMI</span>
    </div>
  </div>

  <!-- ─── ความดันโลหิต ─── -->
  <div class="card">
    <div class="card-header">
      <div class="card-icon icon-bp">🩺</div>
      <div>
        <h2>ความดันโลหิต</h2>
        <span>Systolic / Diastolic (มม.ปรอท)</span>
      </div>
    </div>
    <div class="form-grid">
      <div class="field">
        <label>ความดันตัวบน (Systolic)</label>
        <input type="number" id="bp_systolic" placeholder="เช่น 120" min="60" max="250" oninput="evalBp()">
        <span class="unit">มม.ปรอท</span>
      </div>
      <div class="field">
        <label>ความดันตัวล่าง (Diastolic)</label>
        <input type="number" id="bp_diastolic" placeholder="เช่น 80" min="40" max="150" oninput="evalBp()">
        <span class="unit">มม.ปรอท</span>
      </div>
    </div>
    <div class="status-strip" id="bp-strip">
      <div class="status-dot"></div>
      <span id="bp-text"></span>
    </div>
  </div>

  <!-- ─── ระดับน้ำตาลในเลือด ─── -->
  <div class="card">
    <div class="card-header">
      <div class="card-icon icon-sugar">🩸</div>
      <div>
        <h2>ระดับน้ำตาลในเลือด</h2>
        <span>Blood Glucose (มก./ดล.)</span>
      </div>
    </div>
    <div class="form-grid">
      <div class="field">
        <label>ประเภทการตรวจ</label>
        <select id="sugar_type" onchange="evalSugar()">
          <option value="fasting">อดอาหาร (Fasting)</option>
          <option value="2h_postprandial">หลังอาหาร 2 ชม. (2h PP)</option>
          <option value="random">ไม่อดอาหาร (Random)</option>
          <option value="other">ไม่ได้ตรวจ</option>
        </select>
      </div>
      <div class="field">
        <label>ระดับน้ำตาล</label>
        <input type="number" id="blood_sugar" placeholder="เช่น 95" step="0.1" min="0" max="800" oninput="evalSugar()">
        <span class="unit">มก./ดล. (mg/dL)</span>
      </div>
    </div>
    <div class="status-strip" id="sugar-strip">
      <div class="status-dot"></div>
      <span id="sugar-text"></span>
    </div>
  </div>

  <!-- ─── หมายเหตุ ─── -->
  <div class="card">
    <div class="card-header">
      <div class="card-icon" style="background:#f3f4f6">📝</div>
      <div><h2>หมายเหตุ</h2><span>บันทึกเพิ่มเติม (ถ้ามี)</span></div>
    </div>
    <textarea class="note-field" id="note" placeholder="เช่น วัดหลังพักผ่อน, รับประทานยาแล้ว ..."></textarea>
  </div>
    <input type="hidden" id="hcoachname" value="<?= esc($hcoachname) ?>" name="hcoachname">
  <div class="submit-wrap">
    <button class="btn-submit" id="btn-save" onclick="saveSurvey()">บันทึกข้อมูล</button>
  </div>

</div>
<div class="toast" id="toast"></div>
<div id="nav">
        <div class="nav-container">
            <div class="user-info">
                <i class="fa fa-user"><?= esc($hcoachname) ?></i>
            </div>
            <a href="<?=base_url('public/mobile/riskList')?>" class="logout-btn">
                <i class="fa fa-sign-out"></i> กลับ
            </a>
        </div>
    </div>
<script>
const CSRF_TOKEN = '<?= csrf_token() ?>';
let   csrfHash   = '<?= csrf_hash() ?>';

// ─── ตั้งค่าวันที่เริ่มต้น ───────────────────────────────────────
(function() {
  const now = new Date();
  now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
  document.getElementById('recorded_at').value = now.toISOString().slice(0,16);
})();

// ─── BMI ────────────────────────────────────────────────────────
const bmiLabels = {
  underweight: { th: 'น้ำหนักต่ำกว่าเกณฑ์', cls: 'underweight' },
  normal:      { th: 'น้ำหนักปกติ',          cls: 'normal' },
  overweight:  { th: 'น้ำหนักเกิน',          cls: 'overweight' },
  obese1:      { th: 'อ้วนระดับ 1',           cls: 'obese1' },
  obese2:      { th: 'อ้วนระดับ 2 ขึ้นไป',   cls: 'obese2' },
};

function calcBmi() {
  const w = parseFloat(document.getElementById('weight').value);
  const h = parseFloat(document.getElementById('height').value);
  const box = document.getElementById('bmi-result');
  if (!w || !h || w <= 0 || h <= 0) {
    box.innerHTML = '<span class="bmi-empty">กรอกน้ำหนักและส่วนสูงเพื่อคำนวณ BMI</span>';
    return;
  }
  const hm  = h / 100;
  const bmi = (w / (hm * hm)).toFixed(1);
  let level;
  if (bmi < 18.5)      level = 'underweight';
  else if (bmi < 23.0) level = 'normal';
  else if (bmi < 25.0) level = 'overweight';
  else if (bmi < 30.0) level = 'obese1';
  else                 level = 'obese2';
  const lbl = bmiLabels[level];
  box.innerHTML = `
    <div>
      <div class="bmi-val">${bmi}<span>kg/m²</span></div>
    </div>
    <span class="bmi-badge ${lbl.cls}">${lbl.th}</span>`;
}

// ─── ความดันโลหิต ────────────────────────────────────────────────
const bpLevels = {
  normal:   { cls: 'strip-normal',   th: 'ความดันโลหิตปกติ (< 120/80)' },
  elevated: { cls: 'strip-elevated', th: 'ความดันสูงกว่าปกติเล็กน้อย (120–129/<80)' },
  stage1:   { cls: 'strip-stage1',   th: 'ความดันสูงระยะที่ 1 (130–139 / 80–89)' },
  stage2:   { cls: 'strip-stage2',   th: 'ความดันสูงระยะที่ 2 (≥140 / ≥90)' },
  crisis:   { cls: 'strip-crisis',   th: 'ความดันวิกฤต — ควรพบแพทย์ทันที (≥180 / ≥120)' },
};

function evalBp() {
  const s = parseInt(document.getElementById('bp_systolic').value);
  const d = parseInt(document.getElementById('bp_diastolic').value);
  const strip = document.getElementById('bp-strip');
  if (!s || !d) { strip.className = 'status-strip'; return; }
  let level;
  if (s >= 180 || d >= 120) level = 'crisis';
  else if (s >= 140 || d >= 90) level = 'stage2';
  else if (s >= 130 || d >= 80) level = 'stage1';
  else if (s >= 120 && d < 80)  level = 'elevated';
  else level = 'normal';
  const lbl = bpLevels[level];
  strip.className = 'status-strip show ' + lbl.cls;
  document.getElementById('bp-text').textContent = lbl.th;
}

// ─── ระดับน้ำตาล ──────────────────────────────────────────────────
const sugarLevels = {
  noncheck:     {cls: 'strip-noncheck',     th: 'ไม่ได้ตรวจ' },
  normal:      { cls: 'strip-normal',      th: 'ระดับน้ำตาลปกติ' },
  prediabetes: { cls: 'strip-prediabetes', th: 'ก่อนเป็นเบาหวาน (Pre-diabetes)' },
  diabetes:    { cls: 'strip-diabetes',    th: 'ระดับน้ำตาลสูง — ควรปรึกษาแพทย์' },
};

function evalSugar() {
  const v    = parseFloat(document.getElementById('blood_sugar').value);
  const type = document.getElementById('sugar_type').value;
  const strip = document.getElementById('sugar-strip');
  if (!v) { strip.className = 'status-strip'; return; }
  let level;
  if (type === 'fasting') {
    level = v >= 126 ? 'diabetes' : v >= 100 ? 'prediabetes' : 'normal';
  } else if (type === '2h_postprandial') {
    level = v >= 200 ? 'diabetes' : v >= 140 ? 'prediabetes' : 'normal';
  } else if (type === 'other') {
    level = v === 0 ? 'noncheck' : v >= 50 ? 'normal' : 'prediabetes';
  } else {
    level = v >= 200 ? 'diabetes' : 'normal';
  }
  const lbl = sugarLevels[level];
  strip.className = 'status-strip show ' + lbl.cls;
  document.getElementById('sugar-text').textContent = lbl.th;
}

// ─── บันทึก (AJAX) ────────────────────────────────────────────────
async function saveSurvey() {
  const btn = document.getElementById('btn-save');
  const hospcode = document.getElementById('hospcode').value;
  const pid = document.getElementById('pid').value;
  const payload = {
    hospcode:     hospcode,
    pid:          pid,
    weight:       parseFloat(document.getElementById('weight').value)       || null,
    height:       parseFloat(document.getElementById('height').value)       || null,
    bp_systolic:  parseInt(document.getElementById('bp_systolic').value)    || null,
    bp_diastolic: parseInt(document.getElementById('bp_diastolic').value)   || null,
    blood_sugar:  parseFloat(document.getElementById('blood_sugar').value)  || null,
    sugar_type:   document.getElementById('sugar_type').value,
    note:         document.getElementById('note').value.trim() || null,
    recorded_at:  document.getElementById('recorded_at').value,
  };

  // simple client-side check
  const missing = [];
  if (!payload.weight)       missing.push('น้ำหนัก');
  if (!payload.height)       missing.push('ส่วนสูง');
  if (!payload.bp_systolic)  missing.push('ความดันตัวบน');
  if (!payload.bp_diastolic) missing.push('ความดันตัวล่าง');
  if (!payload.blood_sugar)  missing.push('ระดับน้ำตาล');
  if (missing.length) {
    showToast('กรุณากรอก: ' + missing.join(', '), 'error');
    return;
  }

  btn.classList.add('loading');
  btn.textContent = 'กำลังบันทึก...';

  try {
    // patient_id อยู่ใน URL /vitals/{id}/save
    const res = await fetch('<?= base_url('public/vitals/save/') ?>'+hospcode+'/'+pid, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        [CSRF_TOKEN]: csrfHash,
      },
      body: JSON.stringify(payload),
    });
    const data = await res.json();
    if (data.csrf_hash) csrfHash = data.csrf_hash;

    if (data.success) {
      showToast('บันทึกข้อมูลเรียบร้อยแล้ว ✓', 'success');
      btn.textContent = 'บันทึกข้อมูล';
    } else {
      const errMsg = data.errors
        ? Object.values(data.errors).join(', ')
        : (data.message || 'เกิดข้อผิดพลาด');
      showToast(errMsg, 'error');
      btn.textContent = 'บันทึกข้อมูล';
    }
  } catch (e) {
    showToast('ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้'+e.message, 'error');
    btn.textContent = 'บันทึกข้อมูล';
  }
  btn.classList.remove('loading');
}

// ─── Toast notification ───────────────────────────────────────────
function showToast(msg, type = 'success') {
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.className   = `toast ${type} show`;
  setTimeout(() => { t.className = `toast ${type}`; }, 3500);
}
</script>
</body>
</html>
