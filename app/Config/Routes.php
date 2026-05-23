<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Admin::loginPage');
$routes->get('login', 'Admin::loginPage');
$routes->get('mobile-page', 'mobileController::index',['as' => 'mobile-page']);

$routes->get('register', 'Admin::registerPage',['filter' => 'jwtweb']);
$routes->get('dashboard', 'Admin::dashboard',['filter' => 'jwtweb']);
//$routes->get('profiles/(:any)', 'Admin::profile/$1');
$routes->group('setting/',['filter' => 'jwtweb'], static function ($routes) {
    $routes->get('tumbons','Admin::tumbons');
    $routes->get('offices','Admin::offices');
    $routes->get('get_office','Admin::get_Office');
    $routes->get('get_office_by_code','Admin::get_office_by_code');
    $routes->get('get_tumbon','Admin::get_tumbon');
    $routes->get('get_village','Admin::get_village');
    $routes->post('addOffice','Admin::addOffice');
    $routes->post('editOffice','Admin::editOffice');
    $routes->post('deleteOffice','Admin::deleteOffice');
    $routes->get('get_osm','Admin::get_osm');
});

// API สำหรับ Autocomplete (ต้องอยู่นอกกลุ่ม 'jwt')
$routes->get('api/search/office', 'Api\Data::searchOffice');
$routes->get('api/search/usertype', 'Api\Data::searchusertype');

// API Routes
$routes->post('api/login', 'Api\Auth::login');
$routes->post('api/register', 'Api\Auth::register'); // <-- เพิ่มบรรทัดนี้
// ...

// สร้างกลุ่ม API ที่ต้องผ่านการยืนยันตัวตน (ใช้ Filter 'jwt')
$routes->group('api', ['filter' => 'jwt'], static function ($routes) {
    // ตัวอย่าง Route ที่ถูกป้องกัน
    $routes->get('profile', 'Api\Profile::index');
    $routes->get('data', 'Api\Data::getProtectedData');
   
});

// สร้างกลุ่ม public ที่ต้องผ่านการยืนยันตัวตน (ใช้ Filter 'jwtweb')
$routes->group('/', ['filter' => 'jwtweb'], static function ($routes) {
    
    // Route ที่ CI เห็นคือ 'profile-page'
    $routes->get('profile-page', 'Admin::profile', ['as' => 'profile-page']);
    // (เพิ่ม) นี่คือ Route ใหม่สำหรับหน้า Office
    $routes->get('office-page', 'Admin::office', ['as' => 'office-page']);

});

$routes->get('getChart_data','Admin::getChart_data',['filter' => 'jwtweb']);
$routes->get('getChart_All','Admin::getChart_All',['filter' => 'jwtweb']);
$routes->get('get_data_chartInproj','Admin::get_data_chartInproj',['filter' => 'jwtweb']);
$routes->get('get_Chart_hba1c','NewcaseController::get_Chart_hba1c',['filter' => 'jwtweb']);
$routes->get('get_chart_fpg/(:num)','NewcaseController::get_chart_fpg/$1',['filter' => 'jwtweb']);
$routes->get('get_risk_Chart_bf','Admin::get_risk_Chart_bf',['filter' => 'jwtweb']);
$routes->get('get_risk_Chart_af','Admin::get_risk_Chart_af',['filter' => 'jwtweb']);
$routes->get('getChart_patient','Admin::getChart_patient',['filter' => 'jwtweb']);
$routes->get('getChart_newcase','Admin::getChart_newcase',['filter' => 'jwtweb']);
$routes->get('getChart_ckd','Admin::getChart_ckd',['filter' => 'jwtweb']);
$routes->get('getChart_healthLit','Admin::getChart_healthLit',['filter' => 'jwtweb']);
$routes->get('getChart_result','Admin::getChart_result',['filter' => 'jwtweb']);

$routes->group('importData/',['filter'=>'jwtweb'],static function ($routes) {
    $routes->get('importHdc','ImportDataController::importHdc');
    $routes->get('import43file','ImportDataController::import43file');
    $routes->get('importNewPatient','ImportDataController::importNewPatient');
    $routes->get('importScreen','ImportDataController::importScreen');
    $routes->get('importOldPatient','ImportDataController::importOldPatient');
    $routes->get('importOSM','ImportDataController::importOSM');
    $routes->match(['get','post'],'importDMrisk','ImportDataController::importDMrisk');
    $routes->match(['get','post'],'importHTrisk','ImportDataController::importHTrisk');
    $routes->match(['get','post'],'importnewDM','ImportDataController::importnewDM');
    $routes->match(['get','post'],'importnewHT','ImportDataController::importnewHT');
    $routes->match(['get','post'],'importnewDMHT','ImportDataController::importnewDMHT');
    $routes->match(['get','post'],'importoldDM','ImportDataController::importoldDM');
    $routes->match(['get','post'],'importoldHT','ImportDataController::importoldHT');
    $routes->match(['get','post'],'importoldDMHT','ImportDataController::importoldDMHT');
    $routes->match(['get','post'],'importDataOsm','ImportDataController::importDataOsm');
    $routes->match(['get','post'],'importPersonData','ImportDataController::importPersonData');
    $routes->match(['get','post'],'importHomeData','ImportDataController::importHomeData');
    $routes->match(['get','post'],'importdmCKD','ImportDataController::importdmCKD');

    $routes->match(['get','post'],'importScreenDm','ImportDataController::importScreen_dm');
    $routes->match(['get','post'],'importScreenHt','ImportDataController::importScreen_ht');
    $routes->match(['get','post'],'importScreenCvd','ImportDataController::importScreen_cvd');
    $routes->match(['get','post'],'importScreenCkd','ImportDataController::importScreen_ckd');
});

$routes->group('fetchData/',['filter'=>'jwtweb'],static function ($routes) {
    $routes->get('riskDm_HL','HlController::riskDm_HL');
    $routes->get('riskHT_HL','HlController::riskHT_HL');
       
});
$routes->group('newcaseData/',['filter'=>'jwtweb'],static function ($routes) {
    $routes->get('newDm_page','NewcaseController::newDm_page');
    $routes->get('newHt_page','NewcaseController::newHt_page');
    $routes->get('newDmHt_page','NewcaseController::newDmHt_page');
    $routes->get('oldDm_page','NewcaseController::oldDm_page');
    $routes->get('oldHt_page','NewcaseController::oldHt_page');
    $routes->get('oldDmHt_page','NewcaseController::oldDmHt_page');
    $routes->get('fecth_dm_newcase/(:num)','NewcaseController::fecth_dm_newcase/$1');
    $routes->get('fecth_ht_newcase/(:num)','NewcaseController::fecth_ht_newcase/$1');
    $routes->get('fecth_dmht_newcase/(:num)','NewcaseController::fecth_dmht_newcase/$1');
    $routes->get('fecth_dm_oldcase/(:num)','NewcaseController::fecth_dm_oldcase/$1');
    $routes->get('fecth_ht_oldcase/(:num)','NewcaseController::fecth_ht_oldcase/$1');
    $routes->get('fecth_dmht_oldcase/(:num)','NewcaseController::fecth_dmht_oldcase/$1');
});

$routes->group('fetchRisk/',['filter'=>'jwtweb'],static function ($routes) {
    $routes->match(['get','post'],'fecth_dm_risk','HlController::fecth_dm_risk');
    $routes->match(['get','post'],'selected_dm_risk','HlController::selected_dm_risk');
    $routes->match(['get','post'],'fecth_selected_dm/(:num)','HlController::fecth_selected_dm/$1');
    $routes->match(['get','post'],'save_selected_dm','HlController::save_selected_dm');
    $routes->match(['get','post'],'del_selected_dm','HlController::del_selected_dm');
    $routes->match(['get','post'],'fecth_ht_risk','HlController::fecth_ht_risk');
    $routes->match(['get','post'],'selected_ht_risk','HlController::selected_ht_risk');
    $routes->match(['get','post'],'fecth_selected_ht/(:num)','HlController::fecth_selected_ht/$1');
    $routes->match(['get','post'],'save_selected_ht','HlController::save_selected_ht');
    $routes->match(['get','post'],'del_selected_ht','HlController::del_selected_ht');
    $routes->get('get_hcoach','HlController::get_hcoach');
    $routes->post('get_village_by_hcode/(:num)','HlController::get_village_by_hcode/$1');
});
$routes->group('screenData/',['filter'=>'jwtweb'],static function ($routes) {
    $routes->get('screen_dm_page','ScreenController::screenDM');
    $routes->get('screen_ht_page','ScreenController::screenHT');
    $routes->get('screen_ckd_page','ScreenController::screenCKD');
    $routes->get('screen_cvd_page','ScreenController::screenCVD');
    $routes->match(['get','post'],'fecth_screen_dm/(:segment)/(:segment)','ScreenController::fetch_screen_dm/$1/$2');
    $routes->match(['get','post'],'fecth_non_screen_dm/(:segment)/(:segment)','ScreenController::fetch_non_screen_dm/$1/$2');
    $routes->match(['get','post'],'fecth_screen_ht','ScreenController::fetch_screen_ht');
    $routes->match(['get','post'],'fecth_screen_ckd','ScreenController::fetch_screen_ckd');
    $routes->match(['get','post'],'fecth_screen_cvd','ScreenController::fetch_screen_cvd');
});

$routes->group('hcoach/',['filter' => 'jwtweb'], static function ($routes) {
    $routes->get('hl-page','HlController::hl_page');
    $routes->post('hcoach-Data','HlController::hcoachData');
    $routes->get('update-Send-Status','HlController::update_Send_Status');
    $routes->post('save-hcoach','HlController::save_hcoach');
    $routes->get('fetch-hcoach','HlController::fetch_hcoach');
    $routes->get('get-hcoach/(:num)','HlController::get_hcoach_by_id/$1');
    $routes->post('get_hcoach_by_hcode/(:num)','HlController::get_hcoach_by_hcode/$1');
    $routes->post('update-hcoach/(:num)','HlController::update_hcoach/$1');
    $routes->post('delete-hcoach/(:num)','HlController::delete_hcoach/$1');
    $routes->post('save-hcoach-to-risk','HlController::save_hcoach_to_risk');
}); 

$routes->group('inproject/',['filter'=>'jwtweb'],static function($routes){
    $routes->get('inproject','HealthLiteracy::inproject');
});

//mobile
$routes->group('mobile/',static function ($routes) {
    $routes->get('riskList','mobileController::riskList');
    $routes->get('mobile-menu/(:num)/(:segment)/(:num)','mobileController::riskList_menu/$1/$2/$3');
    $routes->get('HealthLit-page','mobileController::healthLiteracy');
    $routes->get('video-page','mobileController::viewVideo');
    $routes->get('hl_survay/(:num)','mobileController::hl_survay/$1');
});
$routes->get('mb-login','mobileController::login');
$routes->get('mb-logout','mobileController::logout');
$routes->post('mb-login-process','mobileController::login_process');

$routes->get('o-login','mobileController::risk_login');
$routes->post('o-login-process','mobileController::risk_login_process');

$routes->get('media','mobileController::healthLiteracy');
$routes->get('viewVideo/(:segment)','mobileController::viewVideo/$1');

$routes->get('health-literacy','HealthLiteracy::index');
$routes->get('health-literacy/survey/(:num)/(:segment)','HealthLiteracy::survey/$1/$2');
$routes->post('health-literacy/save/(:num)/(:segment)','HealthLiteracy::save/$1/$2');
$routes->get('health-literacy/result/(:num)','HealthLiteracy::result/$1');
$routes->get('vitals/(:num)/(:segment)','Vitals::index/$1/$2');
$routes->post('vitals/save/(:num)/(:segment)','Vitals::save/$1/$2');
$routes->get('vitals/(:num)/history','Vitals::history/$1');
$routes->get('nubcarb','Nubcarb::index');
$routes->post('nubcarb/save','Nubcarb::save');
$routes->get('nubcarb/result/(:num)','Nubcarb::result/$1');
$routes->get('nubcarb/history/(:num)','Nubcarb::history/$1');


