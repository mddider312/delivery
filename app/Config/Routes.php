<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// Home 
$routes->get('/', 'Home::login');
$routes->get('login', 'Home::login');
$routes->post('postLogin', 'Home::postLogin');
$routes->get('logout', 'Home::logout');
$routes->get('profile', 'Home::profile', ['filter' => 'authGuard']);
$routes->get('privacy_policy', 'Home::privacy_policy');

// Dashboard
$routes->get('dashboard', 'DashboardController::index', ['filter' => 'authGuard']);

// Shipments
$routes->get('shipment', 'ShipmentController::index', ['filter' => 'authGuard']); 
$routes->get('shipment_add', 'ShipmentController::add_form', ['filter' => 'authGuard']); 
$routes->post('save_shipment', 'ShipmentController::save_add', ['filter' => 'authGuard']); 
$routes->get('update_shipment/(:num)', 'ShipmentController::update_form/$1', ['filter' => 'authGuard']); 
$routes->put('save_update_shipment/(:num)', 'ShipmentController::save_update/$1', ['filter' => 'authGuard']); 
$routes->get('delete_shipment/(:num)', 'ShipmentController::delete_shipment/$1', ['filter' => 'authGuard']);

// Pickup
$routes->get('pickup', 'ShipmentController::pickup', ['filter' => 'authGuard']); 
$routes->get('pickup_add', 'ShipmentController::add_pickup_form', ['filter' => 'authGuard']); 
$routes->post('save_pickup', 'ShipmentController::save_add', ['filter' => 'authGuard']); 
$routes->get('update_pickup/(:num)', 'ShipmentController::update_pickup_form/$1', ['filter' => 'authGuard']); 
$routes->put('save_update_pickup/(:num)', 'ShipmentController::save_update_pickup/$1', ['filter' => 'authGuard']); 
$routes->get('delete_pickup/(:num)', 'ShipmentController::delete_pickup/$1', ['filter' => 'authGuard']);

// Appid
$routes->get('appid', 'AppIdController::index', ['filter' => 'authGuard']); 
$routes->get('appid_add', 'AppIdController::add_form', ['filter' => 'authGuard']); 
$routes->post('save_appid', 'AppIdController::save_add', ['filter' => 'authGuard']); 
$routes->get('update_appid/(:num)', 'AppIdController::update_form/$1', ['filter' => 'authGuard']); 
$routes->put('save_update_appid/(:num)', 'AppIdController::save_update/$1', ['filter' => 'authGuard']); 
$routes->get('delete_appid/(:num)', 'AppIdController::delete_appid/$1', ['filter' => 'authGuard']);
$routes->get('delete_appid_area/(:num)/(:num)', 'AppIdController::delete_appid_area/$1/$2', ['filter' => 'authGuard']);

// Staffs
$routes->get('staff', 'StaffController::index', ['filter' => 'authGuard']);
$routes->get('staff_add', 'StaffController::add_form', ['filter' => 'authGuard']); 
$routes->post('save_staff', 'StaffController::save_add', ['filter' => 'authGuard']); 
$routes->get('update_staff/(:num)', 'StaffController::update_form/$1', ['filter' => 'authGuard']); 
$routes->put('save_update_staff/(:num)', 'StaffController::save_update/$1', ['filter' => 'authGuard']); 
$routes->get('delete_staff/(:num)', 'StaffController::delete_staff/$1', ['filter' => 'authGuard']); 

// Announcements
$routes->get('announcement', 'AnnouncementController::index', ['filter' => 'authGuard']);
$routes->get('announcement_add', 'AnnouncementController::add_form', ['filter' => 'authGuard']); 
$routes->post('save_announcement', 'AnnouncementController::save_add', ['filter' => 'authGuard']); 
$routes->get('update_announcement/(:num)', 'AnnouncementController::update_form/$1', ['filter' => 'authGuard']); 
$routes->post('save_update_announcement/(:num)', 'AnnouncementController::save_update/$1', ['filter' => 'authGuard']); 
$routes->get('delete_announcement/(:num)', 'AnnouncementController::delete_announcement/$1', ['filter' => 'authGuard']);
$routes->get('delete_announcement_photo/(:num)', 'AnnouncementController::delete_announcement_photo/$1', ['filter' => 'authGuard']);

// Commission Types
$routes->get('commission_type', 'CommissionController::commission_type', ['filter' => 'authGuard']);
$routes->put('update_commission_type', 'CommissionController::update_commission_type', ['filter' => 'authGuard']);
$routes->get('delete_commission_type/(:num)', 'CommissionController::delete_commission_type/$1', ['filter' => 'authGuard']);

// Product
/*
$routes->get('product', 'ProductController::index', ['filter' => 'authGuard']);
$routes->get('product_add', 'ProductController::add_form', ['filter' => 'authGuard']); 
$routes->post('save_product', 'ProductController::save_add', ['filter' => 'authGuard']); 
$routes->get('update_product/(:num)', 'ProductController::update_form/$1', ['filter' => 'authGuard']); 
$routes->put('save_update_product/(:num)', 'ProductController::save_update/$1', ['filter' => 'authGuard']); 
$routes->get('delete_product/(:num)', 'ProductController::delete_product/$1', ['filter' => 'authGuard']);
$routes->get('view_product/(:num)', 'ProductController::view_product/$1', ['filter' => 'authGuard']);
$routes->get('delete_transaction_product/(:num)/(:num)', 'ProductController::delete_transaction_product/$1/$2', ['filter' => 'authGuard']);
*/
/* /////////////////////////// Unused /////////////////////////////////////////
// Language
$routes->get('/lang/{locale}', 'Language::index', ['filter' => 'authGuard']);

$routes->get('index-2', 'Home::show_index_2', ['filter' => 'authGuard']);

// Vertical Layout Pages Routes
$routes->get('layouts-compact-sidebar', 'Home::show_layouts_compact_sidebar', ['filter' => 'authGuard']);
$routes->get('layouts-icon-sidebar', 'Home::show_layouts_icon_sidebar', ['filter' => 'authGuard']);
$routes->get('layouts-boxed', 'Home::show_layouts_boxed', ['filter' => 'authGuard']);
$routes->get('layouts-preloader', 'Home::show_layouts_preloader', ['filter' => 'authGuard']);

// Horizontal Layout Pages Routes
$routes->get('layouts-horizontal', 'Home::show_layouts_horizontal', ['filter' => 'authGuard']);
$routes->get('layouts-hori-topbarlight', 'Home::show_layouts_hori_topbarlight', ['filter' => 'authGuard']);
$routes->get('layouts-hori-boxed', 'Home::show_layouts_hori_boxed', ['filter' => 'authGuard']);
$routes->get('layouts-hori-preloader', 'Home::show_layouts_hori_preloader', ['filter' => 'authGuard']);

// Calender
$routes->get('calendar', 'Home::show_calendar', ['filter' => 'authGuard']);

// Email
$routes->get('email-inbox', 'Home::show_email_inbox', ['filter' => 'authGuard']);
$routes->get('email-read', 'Home::show_email_read', ['filter' => 'authGuard']);

// Tasks
$routes->get('tasks-list', 'Home::show_tasks_list', ['filter' => 'authGuard']);
$routes->get('tasks-kanban', 'Home::show_tasks_kanban', ['filter' => 'authGuard']);
$routes->get('tasks-create', 'Home::show_tasks_create', ['filter' => 'authGuard']);

// Pages
$routes->get('pages-register', 'Home::show_pages_register', ['filter' => 'authGuard']);
$routes->get('pages-recoverpw', 'Home::show_pages_recoverpw', ['filter' => 'authGuard']);
$routes->get('pages-lock-screen', 'Home::show_pages_lock_screen', ['filter' => 'authGuard']);
$routes->get('pages-starter', 'Home::show_pages_starter', ['filter' => 'authGuard']);
$routes->get('pages-invoice', 'Home::show_pages_invoice', ['filter' => 'authGuard']);
$routes->get('pages-profile', 'Home::show_pages_profile', ['filter' => 'authGuard']);
$routes->get('pages-maintenance', 'Home::show_pages_maintenance', ['filter' => 'authGuard']);
$routes->get('pages-comingsoon', 'Home::show_pages_comingsoon', ['filter' => 'authGuard']);
$routes->get('pages-timeline', 'Home::show_pages_timeline', ['filter' => 'authGuard']);
$routes->get('pages-faqs', 'Home::show_pages_faqs', ['filter' => 'authGuard']);
$routes->get('pages-pricing', 'Home::show_pages_pricing', ['filter' => 'authGuard']);
$routes->get('pages-404', 'Home::show_pages_404', ['filter' => 'authGuard']);
$routes->get('pages-500', 'Home::show_pages_500', ['filter' => 'authGuard']);

// UI Elements
$routes->get('ui-alerts', 'Home::show_ui_alerts', ['filter' => 'authGuard']);
$routes->get('ui-buttons', 'Home::show_ui_buttons', ['filter' => 'authGuard']);
$routes->get('ui-cards', 'Home::show_ui_cards', ['filter' => 'authGuard']);
$routes->get('ui-carousel', 'Home::show_ui_carousel', ['filter' => 'authGuard']);
$routes->get('ui-dropdowns', 'Home::show_ui_dropdowns', ['filter' => 'authGuard']);
$routes->get('ui-grid', 'Home::show_ui_grid', ['filter' => 'authGuard']);
$routes->get('ui-images', 'Home::show_ui_images', ['filter' => 'authGuard']);
$routes->get('ui-lightbox', 'Home::show_ui_lightbox', ['filter' => 'authGuard']);
$routes->get('ui-modals', 'Home::show_ui_modals', ['filter' => 'authGuard']);
$routes->get('ui-rangeslider', 'Home::show_ui_rangeslider', ['filter' => 'authGuard']);
$routes->get('ui-session-timeout', 'Home::show_ui_session_timeout', ['filter' => 'authGuard']);
$routes->get('ui-progressbars', 'Home::show_ui_progressbars', ['filter' => 'authGuard']);
$routes->get('ui-sweet-alert', 'Home::show_ui_sweet_alert', ['filter' => 'authGuard']);
$routes->get('ui-tabs-accordions', 'Home::show_ui_tabs_accordions', ['filter' => 'authGuard']);
$routes->get('ui-typography', 'Home::show_ui_typography', ['filter' => 'authGuard']);
$routes->get('ui-video', 'Home::show_ui_video', ['filter' => 'authGuard']);
$routes->get('ui-general', 'Home::show_ui_general', ['filter' => 'authGuard']);
$routes->get('ui-colors', 'Home::show_ui_colors', ['filter' => 'authGuard']);
$routes->get('ui-rating', 'Home::show_ui_rating', ['filter' => 'authGuard']);

// Forms
$routes->get('form-elements', 'Home::show_form_elements', ['filter' => 'authGuard']);
$routes->get('form-validation', 'Home::show_form_validation', ['filter' => 'authGuard']);
$routes->get('form-advanced', 'Home::show_form_advanced', ['filter' => 'authGuard']);
$routes->get('form-editors', 'Home::show_form_editors', ['filter' => 'authGuard']);
$routes->get('form-uploads', 'Home::show_form_uploads', ['filter' => 'authGuard']);
$routes->get('form-xeditable', 'Home::show_form_xeditable', ['filter' => 'authGuard']);
$routes->get('form-repeater', 'Home::show_form_repeater', ['filter' => 'authGuard']);
$routes->get('form-wizard', 'Home::show_form_wizard', ['filter' => 'authGuard']);
$routes->get('form-mask', 'Home::show_form_mask', ['filter' => 'authGuard']);

// Tables
$routes->get('tables-basic', 'Home::show_tables_basic', ['filter' => 'authGuard']);
$routes->get('tables-datatable', 'Home::show_tables_datatable', ['filter' => 'authGuard']);
$routes->get('tables-responsive', 'Home::show_tables_responsive', ['filter' => 'authGuard']);
$routes->get('tables-editable', 'Home::show_tables_editable', ['filter' => 'authGuard']);

// Charts
$routes->get('charts-apex', 'Home::show_charts_apex', ['filter' => 'authGuard']);
$routes->get('charts-chartjs', 'Home::show_charts_chartjs', ['filter' => 'authGuard']);
$routes->get('charts-flot', 'Home::show_charts_flot', ['filter' => 'authGuard']);
$routes->get('charts-knob', 'Home::show_charts_knob', ['filter' => 'authGuard']);
$routes->get('charts-sparkline', 'Home::show_charts_sparkline', ['filter' => 'authGuard']);

// Icons
$routes->get('icons-boxicons', 'Home::show_icons_boxicons', ['filter' => 'authGuard']);
$routes->get('icons-materialdesign', 'Home::show_icons_materialdesign', ['filter' => 'authGuard']);
$routes->get('icons-dripicons', 'Home::show_icons_dripicons', ['filter' => 'authGuard']);
$routes->get('icons-fontawesome', 'Home::show_icons_fontawesome', ['filter' => 'authGuard']);

// Maps
$routes->get('maps-google', 'Home::show_maps_google', ['filter' => 'authGuard']);
$routes->get('maps-vector', 'Home::show_maps_vector', ['filter' => 'authGuard']);
*/

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
