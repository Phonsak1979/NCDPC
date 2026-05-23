<?php

use Faker\Provider\Base;
?>
<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?>
NCDs Dashboard
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row page-title-header">
            <div class="col-12">
                <div class="page-header">
                    <h4 class="page-title">Dashboard</h4>
                    <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
                        <ul class="quick-links ml-auto">
                            <li><a href="<?= Base_url('public/dashboard'); ?>">Dashboard</a></li>
                            <li><a href="<?= Base_url('public/fetchData/riskDm_HL'); ?>">กลุ่มเสี่ยง</a></li>
                            <li><a href="<?= Base_url('public/newcaseData/newDm_page'); ?>">รายใหม่</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2 col-md-6">
                                <div class="d-flex">
                                    <div class="wrapper">
                                        <h3 class="mb-0 font-weight-semibold"><?= $population?></h3>
                                        <h5 class="mb-0 font-weight-medium text-primary">ประชากรทั้งหมด</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6 mt-md-0 mt-4">
                                <div class="d-flex">
                                    <div class="wrapper">
                                        <h3 class="mb-0 font-weight-semibold"><?= $riskNcds ?></h3>
                                        <h5 class="mb-0 font-weight-medium text-primary">กลุ่มเสี่ยง DM/HT</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6 mt-md-0 mt-4">
                                <div class="d-flex">
                                    <div class="wrapper">
                                        <h3 class="mb-0 font-weight-semibold"><?= $inproj ?></h3>
                                        <h5 class="mb-0 font-weight-medium text-primary">กลุ่มเสี่ยงเข้าโครงการฯ</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6 mt-md-0 mt-4">
                                <div class="d-flex">
                                    <div class="wrapper">
                                        <h3 class="mb-0 font-weight-semibold"><?= $newcase ?></h3>
                                        <h5 class="mb-0 font-weight-medium text-primary">ผู้ป่วยรายใหม่ในปี</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6 mt-md-0 mt-4">
                                <div class="d-flex">
                                    <div class="wrapper">
                                        <h3 class="mb-0 font-weight-semibold"><?= $chronicAll ?></h3>
                                        <h5 class="mb-0 font-weight-medium text-primary">ผู้ป่วย DM+HT ทั้งหมด</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6 mt-md-0 mt-4">
                                <div class="d-flex">
                                    <div class="wrapper">
                                        <h3 class="mb-0 font-weight-semibold"><?= $dmCkd ?></h3>
                                        <h5 class="mb-0 font-weight-medium text-primary">ผู้ป่วย CKD + DM</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-0">กลุ่มเสี่ยง NCDs แยกรายหน่วยงาน</h4>
                        <canvas class="mt-0" height="120" id="myChart"></canvas>
                        <!--<canvas class="mt-5" height="120" id="sales-statistics-overview"></canvas>-->
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body d-flex flex-column">
                        <h4 class="card-title mb-0">ผู้ป่วย DM/HT แยกรายหมู่บ้าน</h4>
                        <canvas class="my-auto mx-auto" height="120" id="patientChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body d-flex flex-column">
                        <h4 class="card-title mb-0">ผู้ป่วยรายใหม่ในปี แยกรายหน่วยงาน</h4>
                        <canvas class="my-auto mx-auto" height="120" id="newcaseChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body d-flex flex-column">
                        <h4 class="card-title mb-0">ผู้ป่วยเบาหวานมีภาวะแทรกทางไต</h4>
                        <canvas class="my-auto mx-auto" height="120" id="ckdChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">กลุ่มเสี่ยงเข้าร่วมโครงการปรับเปลี่ยนพฤติกรรม</h4>
                        <div class="aligner-wrapper">
                            <canvas id="sessionsDoughnutChart" height="120"></canvas>
                            <div class="wrapper d-flex flex-column justify-content-between absolute absolute-center">
                                <h2 class="text-center mb-0 font-weight-bold"><?= $inproj ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card col-md-3 grid-margin stretch-card">
                <h4 class="card-title">กลุ่มเสี่ยงก่อนโครงการ</h4>
                <div class="aligner-wrapper">
                    <canvas id="chartbeforProj" height="280"></canvas>
                </div>
            </div>
            <div class="card col-md-3 grid-margin stretch-card">
                <h4 class="card-title">กลุ่มเสี่ยงหลังโครงการ</h4>
                <div class="aligner-wrapper">
                    <canvas id="chartafterProj" height="280"></canvas>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body d-flex flex-column">
                        <h4 class="card-title mb-0">ระดับ health Literacy</h4>
                        <canvas class="my-auto mx-auto" height="120" id="healthLitChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body d-flex flex-column">
                        <h4 class="card-title mb-0">ผลการดำเนินงาน</h4>
                        <canvas class="my-auto mx-auto" height="120" id="resultChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="container-fluid clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright ©
                สำนักงานสาธารณสุขอำเภอศรีเมืองใหม่ 2026</span>
        </div>
    </footer>
</div>
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    loadDashboardData();
});
async function loadDashboardData() {
    try {
        const riskPromise = await fetch('<?=base_url('public/getChart_data') ?>');
        const patientPromise = await fetch('<?=base_url('public/getChart_patient') ?>');
        const riskDMPromise = await fetch('<?=base_url('public/getChart_All') ?>');
        const inprojPromise = await fetch('<?=base_url('public/get_data_chartInproj') ?>');
        const riskBeforePromise = await fetch('<?=base_url('public/get_risk_Chart_bf') ?>');
        const riskAfterPromise = await fetch('<?=base_url('public/get_risk_Chart_af') ?>');
        const newcasePromise = await fetch('<?=base_url('public/getChart_newcase') ?>');
        const dmckdPromise = await fetch('<?=base_url('public/getChart_ckd') ?>');
        const healthLitPromise = await fetch('<?=base_url('public/getChart_healthLit') ?>');
        const resultPromise = await fetch('<?=base_url('public/getChart_result') ?>');

        const [riskRes, patientRes, riskDMRes, inprojRes, riskBeforeRes, riskAfterRes, newcaseRes, dmckdRes,
            healthLitRes, resultRes
        ] = await Promise.all([
            riskPromise, patientPromise, riskDMPromise, inprojPromise, riskBeforePromise,
            riskAfterPromise, newcasePromise, dmckdPromise, healthLitPromise, resultPromise
        ]);

        const [riskData, patientData, riskDMData, inprojData, riskBeforeData, riskAfterData, newcaseData, dmckdData,
            healthLitData, resultData
        ] = await Promise.all([
            riskRes.json(),
            patientRes.json(),
            riskDMRes.json(),
            inprojRes.json(),
            riskBeforeRes.json(),
            riskAfterRes.json(),
            newcaseRes.json(),
            dmckdRes.json(),
            healthLitRes.json(),
            resultRes.json()
        ]);

        render_chartRisk(riskData);
        render_chartPatient(patientData);
        //render_pieChart(riskDMData);
        render_chartInproj(inprojData);
        render_Chart_befor(riskBeforeData);
        render_Chart_after(riskAfterData);
        render_Chart_newcase(newcaseData);
        render_Chart_dmckd(dmckdData);
        render_healthLitChart(healthLitData);
        render_resultChart(resultData);
        
    } catch (error) {
        console.error("การโหลดข้อมูลบางส่วนล้มเหลว:", error);
    }
}

function render_chartRisk(riskData) {
    const ctx = document.getElementById('myChart').getContext('2d');
    if (window.MyChart) {
        window.MyChart.destroy();
    }
    window.MyChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: riskData.labels.map(x => {
                return x.substring(0, 15)
            }),
            datasets: [{
                    label: 'กลุ่มเสี่ยง DM',
                    data: riskData.counts,
                    borderWidth: 1,
                    borderColor: '#36A2EB',
                    backgroundColor: '#9BD0F5',
                },
                {
                    label: 'กลุ่มเสี่ยง HT',
                    data: riskData.counts2,
                    borderWidth: 1,
                    borderColor: '#f117cd',
                    backgroundColor: '#f59bec',
                }
            ],
        },
        options: {
            scales: {
                x: {
                    ticks: {
                        callback: function(value, index, ticks) {
                            let labels = this.getLabelForValue(value);
                            if (labels.length > 10) {
                                return labels.substring(0, 15);
                            }
                            return labels;
                        }
                    }
                },
                y: {
                    beginAtZero: false
                }
            }
        }
    });
}

function render_chartPatient(patientData) {
    const ctx = document.getElementById('patientChart').getContext('2d');
    if (window.MyChart4) {
        window.MyChart4.destroy();
    }
    window.MyChart4 = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: patientData.labels.map(x => {
                return x.substring(0, 15)
            }),
            datasets: [{
                label: 'ผู้ป่วย DM',
                data: patientData.counts_dm,
                borderWidth: 1,
                borderColor: '#160fe2',
                backgroundColor: '#9BD0F5',
            }, {
                label: 'ผู้ป่วย HT',
                data: patientData.counts_ht,
                borderWidth: 1,
                borderColor: '#eee608',
                backgroundColor: '#f59bec',
            }],
        },
        options: {
            scales: {
                x: {
                    ticks: {
                        callback: function(value, index, ticks) {
                            let labels = this.getLabelForValue(value);
                            if (labels.length > 10) {
                                return labels.substring(0, 15);
                            }
                            return labels;
                        }
                    }
                },
                y: {
                    beginAtZero: false
                }
            }
        }
    });
}


function render_pieChart(riskDMData) {
    const ctx = document.getElementById('numOfRiskDM').getContext('2d');
    if (window.MyChart2) {
        window.MyChart2.destroy();
    }
    window.MyChart2 = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: riskDMData.riskAll,
            datasets: [{
                label: 'กลุ่มเสี่ยง',
                data: riskDMData.counts,
                backgroundColor: [
                    '#9BD0F5',
                    '#eb6817',
                ],
                borderWidth: 1,
                hoverOffset: 4
            }],
        },
        options: {
            rotation: 1 * Math.PI,
            circumference: 1 * Math.PI,
            legend: {
                display: false
            },
            tooltip: {
                enabled: false
            },
            cutoutPercentage: 95
        }
    });
}

function render_chartInproj(inprojData) {
    const ctx = document.getElementById('sessionsDoughnutChart').getContext('2d');
    if (window.MyChart3) {
        window.MyChart3.destroy();
    }
    window.MyChart3 = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: inprojData.labels.map(x => {
                return x.substring(0, 15)
            }),
            datasets: [{
                    label: 'กลุ่มเสี่ยง DM',
                    data: inprojData.counts,
                    borderWidth: 1,
                    borderColor: '#36A2EB',
                    backgroundColor: '#9BD0F5',
                },
                {
                    label: 'กลุ่มเสี่ยง HT',
                    data: inprojData.counts2,
                    borderWidth: 1,
                    borderColor: '#f117cd',
                    backgroundColor: '#f59bec',
                }
            ],
        },
        options: {
            scales: {
                x: {
                    ticks: {
                        callback: function(value, index, ticks) {
                            let label = this.getLabelForValue(value);
                            if (label.length > 10) {
                                return label.substring(0, 10) + '...';
                            }
                            return label;
                        },
                        fontSize: 6,
                        display: false
                    },
                },
                y: {
                    beginAtZero: false
                }
            }
        }
    });
}

function render_Chart_befor(riskBeforeData) {
    const ctx = document.getElementById('chartbeforProj').getContext('2d');
    if (window.MyChart5) {
        window.MyChart5.destroy();
    }
    window.MyChart5 = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: riskBeforeData.labels,
            datasets: [{
                label: 'กลุ่มเสี่ยง',
                data: riskBeforeData.counts,
                backgroundColor: [
                    '#f50f0f',
                    '#b3581f',
                ],
                borderWidth: 1,
                hoverOffset: 4
            }],
        },
    });
}

function render_Chart_after(riskAfterData) {
    const ctx = document.getElementById('chartafterProj').getContext('2d');
    if (window.MyChart6) {
        window.MyChart6.destroy();
    }
    window.MyChart6 = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: riskAfterData.labels,
            datasets: [{
                label: 'กลุ่มเสี่ยง',
                data: riskAfterData.counts,
                backgroundColor: [
                    '#f20909',
                    '#ca6222',
                ],
                borderWidth: 1,
                hoverOffset: 4
            }],
        },
    });
}

function render_Chart_newcase(newcaseData) {
    const ctx = document.getElementById('newcaseChart').getContext('2d');
    if (window.MyChart7) {
        window.MyChart7.destroy();
    }
    window.MyChart7 = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: newcaseData.labels.map(x => {
                return x.substring(0, 15)
            }),
            datasets: [{
                    label: 'ผู้ป่วย DM',
                    data: newcaseData.counts_dm,
                    borderWidth: 1,
                    borderColor: '#160fe2',
                    backgroundColor: '#9BD0F5',
                }, {
                    label: 'ผู้ป่วย HT',
                    data: newcaseData.counts_ht,
                    borderWidth: 1,
                    borderColor: '#eee608',
                    backgroundColor: '#f59bec',
                },
                {
                    label: 'ผู้ป่วย DMHT',
                    data: newcaseData.counts_dmht,
                    borderWidth: 1,
                    borderColor: '#0eec0e',
                    backgroundColor: '#125305',
                }
            ],
        },
        options: {
            scales: {
                x: {
                    ticks: {
                        callback: function(value, index, ticks) {
                            let labels = this.getLabelForValue(value);
                            if (labels.length > 10) {
                                return labels.substring(0, 15);
                            }
                            return labels;
                        }
                    }
                },
                y: {
                    beginAtZero: false
                }
            }
        }
    });
}

function render_Chart_dmckd(dmckdData) {
    const ctx = document.getElementById('ckdChart').getContext('2d');
    if (window.MyChart8) {
        window.MyChart8.destroy();
    }
    window.MyChart8 = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: dmckdData.labels.map(x => {
                return x.substring(0, 15)
            }),
            datasets: [{
                label: 'ผู้ป่วย DM',
                data: dmckdData.counts,
                borderWidth: 1,
                borderColor: '#160fe2',
                backgroundColor: '#9BD0F5',
            }],
        },
        options: {
            scales: {
                x: {
                    ticks: {
                        callback: function(value, index, ticks) {
                            let labels = this.getLabelForValue(value);
                            if (labels.length > 10) {
                                return labels.substring(0, 15);
                            }
                            return labels;
                        }
                    }
                },
                y: {
                    beginAtZero: false
                }
            }
        }
    });
}

function render_healthLitChart(healthLitData) {
    const ctx = document.getElementById('healthLitChart').getContext('2d');
    if (window.MyChart9) {
        window.MyChart9.destroy();
    }
    window.MyChart9 = new Chart(ctx, {
            type: 'radar',
            data: {
                labels: ['การเข้าถึง', 'การเข้าใจ', 'การนำไปใช้', 'การประเมิน'],
                datasets: [{
                    label: 'ระดับ health Literacy',
                    data: healthLitData.counts,
                    fill: true,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    r: {
                        Min: 0,
                        Max: 10,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }
    
function render_resultChart(resultData) {
    const ctx = document.getElementById('resultChart').getContext('2d');
    if (window.MyChart10) {
        window.MyChart10.destroy();
    }
    window.MyChart10 = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: resultData.labels.map(x => {
                return x.substring(0, 15)
            }),
            datasets: [{
                    label: 'นักจัดการสุขภาพ',
                    data: resultData.hcoachs,
                    borderWidth: 1,
                    borderColor: '#160fe2',
                    backgroundColor: '#9BD0F5',
                }, {
                    label: 'ผลรอบ2',
                    data: resultData.results,
                    borderWidth: 1,
                    borderColor: '#eee608',
                    backgroundColor: '#f59bec',
                }
            ],
        },
        options: {
            scales: {
                x: {
                    ticks: {
                        callback: function(value, index, ticks) {
                            let labels = this.getLabelForValue(value);
                            if (labels.length > 10) {
                                return labels.substring(0, 15);
                            }
                            return labels;
                        }
                    }
                },
                y: {
                    beginAtZero: false
                }
            }
        }
    });
}


</script>
<script src="<?= base_url('assets/staradmin/js/demo_1/dashboard.js') ?>"></script>
<?= $this->endSection() ?>