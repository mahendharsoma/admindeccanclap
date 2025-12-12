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
$routes->setDefaultController('Login_Control');
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

// Login Route
$routes->get('/', 'Login_Control::index', ['filter' => 'dashboardGuard']);
$routes->post('/', 'Login_Control::index');
$routes->get('login', 'Login_Control::index', ['filter' => 'dashboardGuard']);
$routes->post('login', 'Login_Control::index');

$routes->get('logout', 'Login_Control::logout');

$routes->get('dashboard', 'Dashboard_Control::index', ['filter' => 'authGuard']);

// These are unique routes is for all users 
$routes->post('ajax_get_delete_user_details', 'User_Management_Control::ajax_get_delete_user_details', ['filter' => 'authGuard']);
$routes->post('ajax_delete_user', 'User_Management_Control::ajax_delete_user', ['filter' => 'authGuard']);
$routes->post('ajax_get_user_status_details/(:any)', 'User_Management_Control::ajax_get_user_status_details/$1', ['filter' => 'authGuard']);
$routes->post('ajax_status_update_user', 'User_Management_Control::ajax_status_update_user', ['filter' => 'authGuard']);

// Super Admin management routes
$routes->get('super_admins', 'User_Management_Control::super_admins', ['filter' => 'authGuard']);
$routes->post('ajax_add_super_admin', 'User_Management_Control::ajax_add_super_admin', ['filter' => 'authGuard']);
$routes->post('ajax_get_edit_super_admin_details', 'User_Management_Control::ajax_get_edit_super_admin_details', ['filter' => 'authGuard']);
$routes->post('ajax_update_super_admin', 'User_Management_Control::ajax_update_super_admin', ['filter' => 'authGuard']);

// Admins Routes
$routes->get('admins', 'User_Management_Control::index', ['filter' => 'authGuard']);
$routes->post('ajax_add_admin', 'User_Management_Control::ajax_add_admin', ['filter' => 'authGuard']);
$routes->post('ajax_get_edit_admin_details', 'User_Management_Control::ajax_get_edit_admin_details', ['filter' => 'authGuard']);
$routes->post('ajax_update_admin', 'User_Management_Control::ajax_update_admin', ['filter' => 'authGuard']);

// Inside Sales Executive routes
$routes->get('inside_sales_executives', 'Inside_Sales_Executive_Control::index', ['filter' => 'authGuard']);
$routes->get('inside_sales_executives/(:any)', 'Inside_Sales_Executive_Control::index/$1', ['filter' => 'authGuard']);
$routes->get('inside_sales_executives/(:any)/(:any)', 'Inside_Sales_Executive_Control::index/$1/$2', ['filter' => 'authGuard']);
$routes->post('ajax_add_inside_sales_executive', 'Inside_Sales_Executive_Control::ajax_add_inside_sales_executive', ['filter' => 'authGuard']);
$routes->post('ajax_get_edit_inside_sales_executive_details', 'Inside_Sales_Executive_Control::ajax_get_edit_inside_sales_executive_details', ['filter' => 'authGuard']);
$routes->post('ajax_update_inside_sales_executive', 'Inside_Sales_Executive_Control::ajax_update_inside_sales_executive', ['filter' => 'authGuard']);

// Field Sales Executive routes
$routes->get('field_sales_executives', 'Field_Sales_Executive_Control::index', ['filter' => 'authGuard']);
$routes->get('field_sales_executives/(:any)', 'Field_Sales_Executive_Control::index/$1', ['filter' => 'authGuard']);
$routes->get('field_sales_executives/(:any)/(:any)', 'Field_Sales_Executive_Control::index/$1/$2', ['filter' => 'authGuard']);
$routes->post('ajax_add_field_sales_executive', 'Field_Sales_Executive_Control::ajax_add_field_sales_executive', ['filter' => 'authGuard']);
$routes->post('ajax_get_edit_field_sales_executive_details', 'Field_Sales_Executive_Control::ajax_get_edit_field_sales_executive_details', ['filter' => 'authGuard']);
$routes->post('ajax_update_field_sales_executive', 'Field_Sales_Executive_Control::ajax_update_field_sales_executive', ['filter' => 'authGuard']);

// Sales Manager routes
$routes->get('sales_managers', 'Sales_Manager_Control::index', ['filter' => 'authGuard']);
$routes->get('sales_managers/(:any)', 'Sales_Manager_Control::index/$1', ['filter' => 'authGuard']);
$routes->post('ajax_add_sales_manager', 'Sales_Manager_Control::ajax_add_sales_manager', ['filter' => 'authGuard']);
$routes->post('ajax_get_edit_sales_manager_details', 'Sales_Manager_Control::ajax_get_edit_sales_manager_details', ['filter' => 'authGuard']);
$routes->post('ajax_update_sales_manager', 'Sales_Manager_Control::ajax_update_sales_manager', ['filter' => 'authGuard']);

// Follow-Up Executive routes
$routes->get('follow_up_executives', 'Follow_Up_Executives_Control::index', ['filter' => 'authGuard']);
$routes->get('follow_up_executives/(:any)', 'Follow_Up_Executives_Control::index/$1', ['filter' => 'authGuard']);
$routes->post('ajax_add_follow_up_executive', 'Follow_Up_Executives_Control::ajax_add_follow_up_executive', ['filter' => 'authGuard']);
$routes->post('ajax_get_edit_follow_up_executive_details', 'Follow_Up_Executives_Control::ajax_get_edit_follow_up_executive_details', ['filter' => 'authGuard']);
$routes->post('ajax_update_follow_up_executive', 'Follow_Up_Executives_Control::ajax_update_follow_up_executive', ['filter' => 'authGuard']);

// Vendor Manager routes
$routes->get('vendor_managers', 'Vendor_Managers_Control::index', ['filter' => 'authGuard']);
$routes->get('vendor_managers/(:any)', 'Vendor_Managers_Control::index/$1', ['filter' => 'authGuard']);
$routes->post('ajax_add_vendor_manager', 'Vendor_Managers_Control::ajax_add_vendor_manager', ['filter' => 'authGuard']);
$routes->post('ajax_get_edit_vendor_manager_details', 'Vendor_Managers_Control::ajax_get_edit_vendor_manager_details', ['filter' => 'authGuard']);
$routes->post('ajax_update_vendor_manager', 'Vendor_Managers_Control::ajax_update_vendor_manager', ['filter' => 'authGuard']);

// Vendor routes
$routes->get('vendors', 'Vendors_Control::index', ['filter' => 'authGuard']);
$routes->get('vendors/(:any)', 'Vendors_Control::index/$1', ['filter' => 'authGuard']);
$routes->get('vendors/(:any)/(:any)', 'Vendors_Control::index/$1/$2', ['filter' => 'authGuard']);
$routes->post('ajax_add_vendor', 'Vendors_Control::ajax_add_vendor', ['filter' => 'authGuard']);
$routes->post('ajax_get_edit_vendor_details', 'Vendors_Control::ajax_get_edit_vendor_details', ['filter' => 'authGuard']);
$routes->post('ajax_update_vendor', 'Vendors_Control::ajax_update_vendor', ['filter' => 'authGuard']);

// Accounts Executive routes
$routes->get('accounts_executives', 'Accounts_Executives_Control::index', ['filter' => 'authGuard']);
$routes->get('accounts_executives/(:any)', 'Accounts_Executives_Control::index/$1', ['filter' => 'authGuard']);
$routes->post('ajax_add_accounts_executive', 'Accounts_Executives_Control::ajax_add_accounts_executive', ['filter' => 'authGuard']);
$routes->post('ajax_get_edit_accounts_executive_details', 'Accounts_Executives_Control::ajax_get_edit_accounts_executive_details', ['filter' => 'authGuard']);
$routes->post('ajax_update_accounts_executive', 'Accounts_Executives_Control::ajax_update_accounts_executive', ['filter' => 'authGuard']);

$routes->get('leads', 'Leads_Control::index', ['filter' => 'authGuard']);

$routes->get('add_leads', 'Leads_Control::add_leads', ['filter' => 'authGuard']);

$routes->get('followups_leads', 'Leads_Control::followups_leads', ['filter' => 'authGuard']);

$routes->get('lead_sources', 'Leads_Control::lead_sources', ['filter' => 'authGuard']);


$routes->get('audio_call', 'Call_Control::index', ['filter' => 'authGuard']);

$routes->get('all_leads_calls', 'Call_Control::all_leads_calls', ['filter' => 'authGuard']);

$routes->get('call_history', 'Call_Control::call_history', ['filter' => 'authGuard']);
/////////////////// Services /////////////////
$routes->get('services', 'Services_Control::index', ['filter' => 'authGuard']);
$routes->post('ajax_add_service', 'Services_Control::ajax_add_service', ['filter' => 'authGuard']);
$routes->post('ajax_edit_service', 'Services_Control::ajax_edit_service', ['filter' => 'authGuard']);
$routes->post('ajax_update_service', 'Services_Control::ajax_update_service', ['filter' => 'authGuard']);
$routes->post('ajax_delete_service', 'Services_Control::ajax_delete_service', ['filter' => 'authGuard']);
/////////////////// Products /////////////////
$routes->get('products', 'Products_Control::index', ['filter' => 'authGuard']);
$routes->get('products/(:any)', 'Products_Control::index/$1', ['filter' => 'authGuard']);
$routes->post('ajax_add_product', 'Products_Control::ajax_add_product', ['filter' => 'authGuard']);
$routes->post('ajax_edit_product', 'Products_Control::ajax_edit_product', ['filter' => 'authGuard']);
$routes->post('ajax_update_product', 'Products_Control::ajax_update_product', ['filter' => 'authGuard']);
$routes->post('ajax_delete_product', 'Products_Control::ajax_delete_product', ['filter' => 'authGuard']);
/////////////////// Items /////////////////
$routes->get('items', 'Items_Control::index', ['filter' => 'authGuard']);
$routes->get('items/(:any)', 'Items_Control::index/$1', ['filter' => 'authGuard']);
$routes->post('ajax_add_item', 'Items_Control::ajax_add_item', ['filter' => 'authGuard']);
$routes->post('ajax_edit_item', 'Items_Control::ajax_edit_item', ['filter' => 'authGuard']);
$routes->post('ajax_update_item', 'Items_Control::ajax_update_item', ['filter' => 'authGuard']);
$routes->post('ajax_delete_item', 'Items_Control::ajax_delete_item', ['filter' => 'authGuard']);

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