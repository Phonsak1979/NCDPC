<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>แบบสอบถามความรอบรู้ด้านสุขภาพ</title>
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
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body {
    font-family: 'Sarabun', 'Noto Sans Thai', sans-serif;
    background: #f5f7fa;
    color: #1a1a2e;
    min-height: 100vh;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    padding: 2rem 1rem;
  }
  :root {
  --primary-color: #f307d7;
  --secondary-color: #cb4ae2;
  --text-color: #0a1c2f;
  --background-color: #d6ebd7;
}

  .container {
    width: 100%;
    max-width: 640px;
  }
 
  /* Header */
  .hl-header {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e8eaf0;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.25rem;
  }
  .hl-title {
    font-size: 15px;
    font-weight: 600;
    color: #1a1a2e;
    margin-bottom: 14px;
    line-height: 1.5;
  }
  .prog-track {
    height: 6px;
    background: #eef0f5;
    border-radius: 99px;
    margin-bottom: 8px;
    overflow: hidden;
  }
  .prog-bar {
    height: 100%;
    background: #1D9E75;
    border-radius: 99px;
    transition: width 0.4s ease;
  }
  .prog-info {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    color: #6b7280;
  }
 
  /* Question card */
  .step { display: none; }
  .step.active { display: block; }
 
  .q-card {
    background: #fff;
    border: 1px solid #e8eaf0;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1rem;
  }
  .q-top {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 14px;
    flex-wrap: wrap;
  }
  .q-num {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #E1F5EE;
    color: #0F6E56;
    font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .badge {
    font-size: 11px;
    font-weight: 600;
    padding: 4px 12px;
    border-radius: 99px;
  }
  .badge-access   { background: #E6F1FB; color: #185FA5; }
  .badge-understand { background: #EEEDFE; color: #534AB7; }
  .badge-apply    { background: #E1F5EE; color: #0F6E56; }
  .badge-eval     { background: #FAEEDA; color: #854F0B; }
 
  .q-text {
    font-size: 15px;
    font-weight: 600;
    color: #1a1a2e;
    line-height: 1.7;
  }
 
  /* Options */
  .opts {
    display: grid;
    gap: 10px;
    margin-top: 1.25rem;
  }
  .opt-label {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 13px 16px;
    border-radius: 12px;
    border: 1.5px solid #e8eaf0;
    background: #fafbfc;
    cursor: pointer;
    transition: border-color 0.15s, background 0.15s;
    font-size: 14px;
    color: #374151;
    line-height: 1.4;
  }
  .opt-label:hover {
    border-color: #a7d7c5;
    background: #f0faf6;
  }
  .opt-label input[type=radio] { display: none; }
  .opt-label.selected {
    border-color: #1D9E75;
    background: #E1F5EE;
    color: #085041;
  }
  .opt-dot {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px solid #d1d5db;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: border-color 0.15s, background 0.15s;
  }
  .opt-label.selected .opt-dot {
    background: #1D9E75;
    border-color: #1D9E75;
  }
  .opt-dot-inner {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #fff;
    display: none;
  }
  .opt-label.selected .opt-dot-inner { display: block; }
  .opt-val {
    font-size: 12px;
    font-weight: 600;
    min-width: 20px;
    color: #9ca3af;
  }
  .opt-label.selected .opt-val { color: #0F6E56; }
 
  /* Navigation */
  .nav-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    margin-top: 0.5rem;
  }
  .nav-btn {
    padding: 11px 24px;
    border-radius: 10px;
    border: 1.5px solid #d1d5db;
    background: transparent;
    color: #374151;
    font-size: 14px;
    font-family: inherit;
    cursor: pointer;
    transition: background 0.15s, border-color 0.15s;
    font-weight: 500;
  }
  .nav-btn:hover { background: #f3f4f6; border-color: #9ca3af; }
  .nav-btn.primary {
    background: #1D9E75;
    border-color: #1D9E75;
    color: #fff;
  }
  .nav-btn.primary:hover { background: #0F6E56; border-color: #0F6E56; }
  .nav-btn:disabled { opacity: 0.35; cursor: default; pointer-events: none; }
 
  .warn {
    font-size: 12px;
    color: #A32D2D;
    background: #FCEBEB;
    padding: 8px 14px;
    border-radius: 8px;
    display: none;
    margin-bottom: 10px;
  }
  .warn.show { display: block; }
 
  /* Summary */
  .summary {
    display: none;
    background: #fff;
    border: 1px solid #e8eaf0;
    border-radius: 16px;
    padding: 2.5rem 1.5rem;
    text-align: center;
  }
  .sum-icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: #E1F5EE;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem;
    font-size: 28px;
  }
  .sum-score {
    font-size: 56px;
    font-weight: 700;
    color: #1D9E75;
    line-height: 1;
  }
  .sum-max {
    font-size: 14px;
    color: #6b7280;
    margin-top: 6px;
    margin-bottom: 1.5rem;
  }
  .level-badge {
    display: inline-block;
    padding: 6px 18px;
    border-radius: 99px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 1.75rem;
  }
  .level-low  { background: #FCEBEB; color: #A32D2D; }
  .level-mid  { background: #FAEEDA; color: #854F0B; }
  .level-high { background: #E1F5EE; color: #0F6E56; }
 
  .sum-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
    margin-bottom: 1.75rem;
    text-align: left;
  }
  .sum-item {
    background: #f5f7fa;
    border-radius: 12px;
    padding: 14px 16px;
  }
  .sum-item-label {
    font-size: 12px;
    color: #6b7280;
    margin-bottom: 6px;
  }
  .sum-item-val {
    font-size: 22px;
    font-weight: 700;
    color: #1a1a2e;
  }
  .retry-btn {
    padding: 11px 28px;
    border-radius: 10px;
    border: 1.5px solid #d1d5db;
    background: transparent;
    color: #374151;
    font-size: 14px;
    font-family: inherit;
    cursor: pointer;
    font-weight: 500;
    transition: background 0.15s;
  }
  .retry-btn:hover { background: #f3f4f6; }
  
  .header-section {
  background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
  padding: 1.0rem 0rem;
  border-radius: 0 0 25px 25px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  margin-bottom: 0.5rem;
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
  box-shadow: 0 2px 10px rgba(0,0,0,0.2);
}

.header-text {
  text-align: center;
  color: white;
}

.header-text h2 {
  font-size: 1.8rem;
  margin: 0;
  text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
}

.header-text h3 {
  font-size: 1.2rem;
  margin: 0.5rem 0 0;
  opacity: 0.9;
}
#nav {
  background: var(--primary-color);
  padding: 0.5rem;
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
  padding: 0 0.5rem;
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

@media (max-width: 768px) {
  .header-text h2 { font-size: 1.5rem; }
  .header-text h3 { font-size: 1rem; }
  .menu-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 480px) {
  .menu-grid { grid-template-columns: repeat(2, 1fr); }
  .header-logo { width: 50px; height: 50px; }
}
</style>
</head>
<body>
<div class="container-fluid p-0">
 <div class="header-section">
        <div class="header-content">
            <img src="<?=base_url('images/digital_hl.png')?>" class="header-logo" alt="HL Logo">
            <div class="header-text">
                <h2>Health Literacy Coach</h2>
                <h4>นักจัดการความรอบรู้ด้านสุขภาพ</h4>
            </div>
            <img src="<?=base_url('images/service.jpg')?>" class="header-logo" alt="NCDs Logo">
        </div>
    </div>
  <div class="hl-header" id="header-box">
    <div class="hl-title">แบบสอบถามความรอบรู้ด้านสุขภาพ<br>โรคเบาหวานและความดันโลหิตสูง</div>
    <div class="prog-track"><div class="prog-bar" id="prog" style="width:8.33%"></div></div>
    <div class="prog-info">
      <span id="prog-label">ข้อที่ 1 จาก 12</span>
      <span id="prog-pct">8%</span>
    </div>
  </div>
 
  <div id="steps"></div>
 
  <div class="warn" id="warn">กรุณาเลือกคำตอบก่อนดำเนินการต่อ</div>
 
  <div class="nav-row" id="nav-row">
    <button class="nav-btn" id="btn-prev" onclick="go(-1)" disabled>ย้อนกลับ</button>
    <button class="nav-btn primary" id="btn-next" onclick="go(1)">ถัดไป</button>
  </div>
 
  <div class="summary" id="summary">
    <div class="sum-icon">&#10003;</div>
    <div class="sum-score" id="sum-score">0</div>
    <div class="sum-max">คะแนนรวม จาก 48 คะแนน</div>
    <div class="level-badge" id="sum-level"></div>
    <div class="sum-grid">
      <div class="sum-item">
        <div class="sum-item-label">ด้านการเข้าถึงข้อมูล</div>
        <div class="sum-item-val" id="s1">0/12</div>
      </div>
      <div class="sum-item">
        <div class="sum-item-label">ด้านความเข้าใจ</div>
        <div class="sum-item-val" id="s2">0/12</div>
      </div>
      <div class="sum-item">
        <div class="sum-item-label">ด้านการนำไปใช้</div>
        <div class="sum-item-val" id="s3">0/12</div>
      </div>
      <div class="sum-item">
        <div class="sum-item-label">ด้านการประเมิน</div>
        <div class="sum-item-val" id="s4">0/12</div>
      </div>
    </div>
    <button class="retry-btn" onclick="restart()">ทำแบบสอบถามอีกครั้ง</button>
    <button class="save-btn btn-primary" onclick="save_q()">บันทึก</button>
  </div>
 
</div>
 <div id="nav">
        <div class="nav-container">
            <div class="user-info">
                <i class="fa fa-user"></i>
                <span><?= esc($user->fname);?><br><?= esc($office->hname);?></span>
            </div>
            <a href="<?=base_url('public/mobile/riskList')?>" class="logout-btn">
                <i class="fa fa-sign-out"></i> กลับ
            </a>
        </div>
    </div>

<script>
const qs = [
  {
    badge: 'badge-access', badgeLabel: 'การเข้าถึง', dim: 1,
    text: 'ท่านสามารถค้นหาข้อมูลเกี่ยวกับการควบคุมน้ำตาลในเลือดหรือความดันโลหิตจากแหล่งที่เชื่อถือได้ ได้ง่ายเพียงใด?'
  },
  {
    badge: 'badge-access', badgeLabel: 'การเข้าถึง', dim: 1,
    text: 'ท่านสามารถเข้าถึงบริการตรวจวัดความดันโลหิตหรือน้ำตาลในเลือดที่ใกล้บ้านของท่านได้ง่ายเพียงใด?'
  },
  {
    badge: 'badge-access', badgeLabel: 'การเข้าถึง', dim: 1,
    text: 'ท่านสามารถหาข้อมูลเกี่ยวกับอาหารที่เหมาะสมสำหรับผู้ป่วยเบาหวานหรือความดันโลหิตสูงได้ง่ายเพียงใด?'
  },
  {
    badge: 'badge-understand', badgeLabel: 'ความเข้าใจ', dim: 2,
    text: 'ท่านเข้าใจคำอธิบายของแพทย์หรือพยาบาลเกี่ยวกับโรคเบาหวานหรือความดันโลหิตสูงของท่านได้ง่ายเพียงใด?'
  },
  {
    badge: 'badge-understand', badgeLabel: 'ความเข้าใจ', dim: 2,
    text: 'ท่านเข้าใจวิธีรับประทานยาควบคุมน้ำตาลหรือยาลดความดันโลหิตที่แพทย์สั่งได้ชัดเจนเพียงใด?'
  },
  {
    badge: 'badge-understand', badgeLabel: 'ความเข้าใจ', dim: 2,
    text: 'ท่านเข้าใจความหมายของค่าน้ำตาลสะสม (HbA1c) หรือค่าความดันโลหิตที่วัดได้ว่าอยู่ในระดับใดได้ง่ายเพียงใด?'
  },
  {
    badge: 'badge-apply', badgeLabel: 'การนำไปใช้', dim: 3,
    text: 'ท่านสามารถเลือกรับประทานอาหารที่เหมาะสมเพื่อควบคุมน้ำตาลในเลือดหรือความดันโลหิตในชีวิตประจำวันได้ง่ายเพียงใด?'
  },
  {
    badge: 'badge-apply', badgeLabel: 'การนำไปใช้', dim: 3,
    text: 'ท่านสามารถออกกำลังกายอย่างสม่ำเสมอตามคำแนะนำของแพทย์เพื่อควบคุมโรคได้ง่ายเพียงใด?'
  },
  {
    badge: 'badge-apply', badgeLabel: 'การนำไปใช้', dim: 3,
    text: 'ท่านสามารถรับประทานยาได้ตรงตามเวลาและปริมาณที่แพทย์กำหนดโดยไม่ลืมได้ง่ายเพียงใด?'
  },
  {
    badge: 'badge-eval', badgeLabel: 'การประเมิน', dim: 4,
    text: 'ท่านสามารถสังเกตอาการผิดปกติ เช่น น้ำตาลต่ำ หรือความดันสูงวิกฤต และตัดสินใจว่าควรพบแพทย์เมื่อใดได้ง่ายเพียงใด?'
  },
  {
    badge: 'badge-eval', badgeLabel: 'การประเมิน', dim: 4,
    text: 'ท่านสามารถประเมินว่าข้อมูลสุขภาพที่ได้รับจากสื่อออนไลน์หรือคนรอบข้างนั้นถูกต้องน่าเชื่อถือเพียงใด?'
  },
  {
    badge: 'badge-eval', badgeLabel: 'การประเมิน', dim: 4,
    text: 'ท่านสามารถตัดสินใจปรับเปลี่ยนพฤติกรรมสุขภาพของตนเอง เช่น ลดเค็ม ลดหวาน หรือเพิ่มการออกกำลังกายได้ง่ายเพียงใด?'
  }
];
 
const opts = [
  { v: 1, label: 'ยากมาก' },
  { v: 2, label: 'ยาก' },
  { v: 3, label: 'ง่าย' },
  { v: 4, label: 'ง่ายมาก' }
];
 
let cur = 0;
let answers = new Array(12).fill(null);
 
function render() {
  const container = document.getElementById('steps');
  container.innerHTML = '';
  qs.forEach((q, i) => {
    const div = document.createElement('div');
    div.className = 'step' + (i === cur ? ' active' : '');
    div.id = 'step-' + i;
    div.innerHTML = `
      <div class="q-card">
        <div class="q-top">
          <div class="q-num">${i + 1}</div>
          <span class="badge ${q.badge}">${q.badgeLabel}</span>
        </div>
        <div class="q-text">${q.text}</div>
        <div class="opts">
          ${opts.map(o => `
            <label class="opt-label${answers[i] === o.v ? ' selected' : ''}" onclick="pick(${i}, ${o.v}, this)">
              <input type="radio" name="q${i}" value="${o.v}" ${answers[i] === o.v ? 'checked' : ''}>
              <div class="opt-dot"><div class="opt-dot-inner"></div></div>
              <span class="opt-val">${o.v}</span>
              <span>${o.label}</span>
            </label>
          `).join('')}
        </div>
      </div>`;
    container.appendChild(div);
  });
  updateNav();
}
 
function pick(qi, val, el) {
  answers[qi] = val;
  document.querySelectorAll('#step-' + qi + ' .opt-label').forEach(l => l.classList.remove('selected'));
  el.classList.add('selected');
  document.getElementById('warn').classList.remove('show');
}
 
function go(dir) {
  if (dir === 1 && answers[cur] === null) {
    document.getElementById('warn').classList.add('show');
    return;
  }
  document.getElementById('warn').classList.remove('show');
  cur += dir;
  if (cur >= 12) { showSummary(); return; }
  render();
  window.scrollTo({ top: 0, behavior: 'smooth' });
}
 
function updateNav() {
  const pct = Math.round(((cur + 1) / 12) * 100);
  document.getElementById('prog').style.width = pct + '%';
  document.getElementById('prog-label').textContent = 'ข้อที่ ' + (cur + 1) + ' จาก 12';
  document.getElementById('prog-pct').textContent = pct + '%';
  document.getElementById('btn-prev').disabled = cur === 0;
  document.getElementById('btn-next').textContent = cur === 11 ? 'ส่งแบบสอบถาม' : 'ถัดไป';
}
 
function showSummary() {
  document.getElementById('steps').style.display = 'none';
  document.getElementById('warn').style.display = 'none';
  document.getElementById('nav-row').style.display = 'none';
  document.getElementById('header-box').style.display = 'none';
  const total = answers.reduce((a, b) => a + (b || 0), 0);
  const dims = [0, 0, 0, 0];
  qs.forEach((q, i) => { dims[q.dim - 1] += (answers[i] || 0); });
  document.getElementById('sum-score').textContent = total;
  document.getElementById('s1').textContent = dims[0] + '/12';
  document.getElementById('s2').textContent = dims[1] + '/12';
  document.getElementById('s3').textContent = dims[2] + '/12';
  document.getElementById('s4').textContent = dims[3] + '/12';
  const lvl = document.getElementById('sum-level');
  if (total <= 24) {
    lvl.textContent = 'ระดับต่ำ — ควรเสริมทักษะด้านสุขภาพ';
    lvl.className = 'level-badge level-low';
  } else if (total <= 36) {
    lvl.textContent = 'ระดับปานกลาง — มีทักษะพื้นฐานดี';
    lvl.className = 'level-badge level-mid';
  } else {
    lvl.textContent = 'ระดับสูง — มีความรอบรู้ด้านสุขภาพดีมาก';
    lvl.className = 'level-badge level-high';
  }
  document.getElementById('summary').style.display = 'block';
}
 
function restart() {
  cur = 0;
  answers = new Array(12).fill(null);
  document.getElementById('summary').style.display = 'none';
  document.getElementById('steps').style.display = 'block';
  document.getElementById('header-box').style.display = 'block';
  document.getElementById('nav-row').style.display = 'flex';
  document.getElementById('warn').style.display = '';
  render();
}
 
render();
</script>
</body>
</html>