<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "site";
$route['404_override'] = '';

$route['user/Page'] = "user/index";
$route['user/Page/(:num)'] = "user/index/$1";
$route['user/new'] = "user/add_new";
$route['user/(:num)/edit'] = "user/edit/$1";
$route['user/(:num)/delete'] = "user/delete/$1";

$route['account/Page'] = "account/index";
$route['account/Page/(:num)'] = "account/index/$1";
$route['account/new'] = "account/add_new";
$route['account/(:num)/edit'] = "account/edit/$1";
$route['account/(:num)/delete'] = "account/delete/$1";


$route['employee/Page'] = "employee/index";
$route['employee/Page/(:num)'] = "employee/index/$1";
$route['employee/new'] = "employee/edit";
$route['employee/(:num)/edit'] = "employee/edit/$1";
$route['employee/(:num)/delete'] = "employee/delete/$1";
$route['employee/(:any)/info'] = "employee/info/$1";

$route['project/Page'] = "project/index";
$route['project/Page/(:num)'] = "project/index/$1";
$route['project/new'] = "project/edit";
$route['project/(:num)/edit'] = "project/edit/$1";
$route['project/(:num)/delete'] = "project/delete/$1";
$route['project/(:any)/info'] = "project/info/$1";

$route['deduction_category/Page'] = "deduction_category/index";
$route['deduction_category/Page/(:num)'] = "deduction_category/index/$1";
$route['deduction_category/new'] = "deduction_category/edit";
$route['deduction_category/print'] = "deduction_category/print_pdf";
$route['deduction_category/(:num)/edit'] = "deduction_category/edit/$1";
$route['deduction_category/(:num)/delete'] = "deduction_category/delete/$1";
$route['deduction_category/(:any)/info'] = "deduction_category/info/$1";

$route['employment_status/Page'] = "employment_status/index";
$route['employment_status/Page/(:num)'] = "employment_status/index/$1";
$route['employment_status/new'] = "employment_status/edit";
$route['employment_status/print'] = "employment_status/print_pdf";
$route['employment_status/(:num)/edit'] = "employment_status/edit/$1";
$route['employment_status/(:num)/delete'] = "employment_status/delete/$1";
$route['employment_status/(:any)/info'] = "employment_status/info/$1";

$route['deduction/Page'] = "deduction/index";
$route['deduction/Page/(:num)'] = "deduction/index/$1";
$route['deduction/new'] = "deduction/edit";
$route['deduction/(:num)/edit'] = "deduction/edit/$1";
$route['deduction/(:num)/delete'] = "deduction/delete/$1";
$route['deduction/(:any)/info'] = "deduction/info/$1";


$route['philhealth_premium_contribution_matrix/Page'] = "philhealth_premium_contribution_matrix/index";
$route['philhealth_premium_contribution_matrix/Page/(:num)'] = "philhealth_premium_contribution_matrix/index/$1";
$route['philhealth_premium_contribution_matrix/new'] = "philhealth_premium_contribution_matrix/edit";
$route['philhealth_premium_contribution_matrix/(:num)/edit'] = "philhealth_premium_contribution_matrix/edit/$1";
$route['philhealth_premium_contribution_matrix/(:num)/delete'] = "philhealth_premium_contribution_matrix/delete/$1";
$route['philhealth_premium_contribution_matrix/(:any)/info'] = "philhealth_premium_contribution_matrix/info/$1";
$route['philhealth_premium_contribution_matrix/print'] = "philhealth_premium_contribution_matrix/print_pdf";

$route['sss_premium_contribution_matrix/Page'] = "sss_premium_contribution_matrix/index";
$route['sss_premium_contribution_matrix/Page/(:num)'] = "sss_premium_contribution_matrix/index/$1";
$route['sss_premium_contribution_matrix/new'] = "sss_premium_contribution_matrix/edit";
$route['sss_premium_contribution_matrix/(:num)/edit'] = "sss_premium_contribution_matrix/edit/$1";
$route['sss_premium_contribution_matrix/(:num)/delete'] = "sss_premium_contribution_matrix/delete/$1";
$route['sss_premium_contribution_matrix/(:any)/info'] = "sss_premium_contribution_matrix/info/$1";
$route['sss_premium_contribution_matrix/print'] = "sss_premium_contribution_matrix/print_pdf";

$route['pagibig_premium_contribution_matrix/Page'] = "pagibig_premium_contribution_matrix/index";
$route['pagibig_premium_contribution_matrix/Page/(:num)'] = "pagibig_premium_contribution_matrix/index/$1";
$route['pagibig_premium_contribution_matrix/new'] = "pagibig_premium_contribution_matrix/edit";
$route['pagibig_premium_contribution_matrix/(:num)/edit'] = "pagibig_premium_contribution_matrix/edit/$1";
$route['pagibig_premium_contribution_matrix/(:num)/delete'] = "pagibig_premium_contribution_matrix/delete/$1";
$route['pagibig_premium_contribution_matrix/(:any)/info'] = "pagibig_premium_contribution_matrix/info/$1";
$route['pagibig_premium_contribution_matrix/print'] = "pagibig_premium_contribution_matrix/print_pdf";



$route['manning_list/Page'] = "manning_list/index";
$route['manning_list/Page/(:num)'] = "manning_list/index/$1";
$route['manning_list/new'] = "manning_list/edit";
$route['manning_list/(:num)/edit'] = "manning_list/edit/$1";
$route['manning_list/(:num)/view'] = "manning_list/view/$1";
$route['manning_list/(:num)/print_profile'] = "manning_list/print_profile_pdf/$1";
$route['manning_list/(:num)/delete'] = "manning_list/delete/$1";
$route['manning_list/(:any)/info'] = "manning_list/info/$1";
$route['manning_list/print'] = "manning_list/print_pdf";
$route['manning_list/export_pdf_excel'] = "manning_list/export_pdf_excel";

$route['position/Page'] = "position/index";
$route['position/Page/(:num)'] = "position/index/$1";
$route['position/new'] = "position/add_new";
$route['position/(:num)/edit'] = "position/edit/$1";
$route['position/(:num)/delete'] = "position/delete/$1";
$route['position/(:any)/info'] = "position/info/$1";

$route['rate/Page'] = "rate/index";
$route['rate/Page/(:num)'] = "rate/index/$1";
$route['rate/new'] = "rate/add_new";
$route['rate/(:num)/edit'] = "rate/edit/$1";
$route['rate/(:num)/delete'] = "rate/delete/$1";
$route['rate/(:any)/info'] = "rate/info/$1";

$route['project/(:num)/detail'] = "project_detail/index/$1";
$route['project/(:num)/detail/Page'] = "project_detail/index/$1";
$route['project/(:num)/new'] = "project_detail/edit/$1";
$route['project/(:num)/(:num)/edit'] = "project_detail/edit/$1/$2";

$route['project_employee/(:num)/detail'] = "project_employee/index/$1";
$route['project_employee/(:num)/Page'] = "project_employee/index/$1";
$route['project_employee/(:num)/new'] = "project_employee/edit/$1";
$route['project_employee/(:num)/(:num)/edit'] = "project_employee/edit/$1/$2";
$route['project_employee/(:num)/delete'] = "project_employee/delete/$1";

$route['project_employee/(:num)/(:num)/special_addjustment_personnel'] = "project_employee/special_addjustment_personnel/$1/$2";
$route['project_employee/(:num)/(:num)/add_personnel'] = "project_employee/add_personnel/$1/$2";


$route['projectPositionRate/(:num)/new'] = "project_position_rate/edit/$1";
$route['projectPositionRate/(:num)/(:num)/edit'] = "project_position_rate/edit/$1/$2";
$route['projectPositionRate/(:num)/delete'] = "project_position_rate/delete/$1";

$route['projectBillingInfo/(:num)'] = "project_billing_info/index/$1";
$route['projectBillingInfo/(:num)/index'] = "project_billing_info/index/$1";
$route['projectBillingInfo/(:num)/new'] = "project_billing_info/edit/$1";
$route['projectBillingInfo/(:num)/(:num)/edit'] = "project_billing_info/edit/$1/$2";
$route['projectBillingInfo/(:num)/delete'] = "project_billing_info/delete/$1";

$route['projectBillingTrans/(:num)/(:num)/summary'] = "project_billing_detail/show/$1/$2";
$route['projectBillingTrans/(:num)/(:num)/summary/Page/(:num)'] = "project_billing_detail/show/$1/$2/$3";
$route['projectBillingTrans/(:num)/(:num)/summary/Page'] = "project_billing_detail/show/$1/$2";

$route['projectBillingTrans/(:num)/edit'] = "project_billing_detail/edit/$1";
$route['projectBillingTrans/(:num)/(:num)/download'] = "project_billing_detail/download/$1/$2";
$route['projectBillingTrans/(:num)/(:num)/invoice'] = "project_billing_detail/invoice/$1/$2";
$route['projectBillingTrans/(:num)/(:num)/invoice2'] = "project_billing_detail/invoice2/$1/$2";
$route['projectBillingTrans/(:num)/(:num)/invoice3'] = "project_billing_detail/invoice3/$1/$2";
$route['projectBillingTrans/(:num)/(:num)/delete'] = "project_billing_detail/delete/$1/$2";

$route['projectBillingTrans/(:num)/invoice_by_rate'] = "project_billing_detail/invoice_by_rate/$1";
$route['projectBillingTrans/(:num)/invoice_by_position'] = "project_billing_detail/invoice_by_position/$1";
// $route['projectBillingTrans/(:num)/invoice3'] = "project_billing_detail/invoice3/$1/$2";

$route['dtr/(:num)/download'] = "dtr/download_dtr/$1";

$route['combine_billing/Page'] = "combine_billing/index";
$route['combine_billing/Page/(:num)'] = "combine_billing/index/$1";
$route['combine_billing/new'] = "combine_billing/edit";
$route['combine_billing/(:num)/edit'] = "combine_billing/edit/$1";
$route['combine_billing/(:num)/delete'] = "combine_billing/delete/$1";

$route['combine_billing/(:num)/update_cpb'] = "combine_billing/update_cpb/$1";
$route['combine_project_billing/(:num)/delete'] = "combine_project_billing/delete/$1";

$route['manning_payroll/Page'] = "manning_payroll/index";
$route['manning_payroll/Page/(:num)'] = "manning_payroll/index/$1";

$route['manning_payroll/search/(:num)'] = "manning_payroll/search/$1";
$route['manning_payroll/(:num)/delete'] = "manning_payroll/delete/$1";
$route['manning_payroll/(:num)/edit_earning'] = "manning_payroll/edit_earning/$1";


$route['case/Page'] = "case_emp/index";
$route['case/Page/(:num)'] = "case_emp/index/$1";
$route['case/new'] = "case_emp/edit";
$route['case/(:num)/edit'] = "case_emp/edit/$1";
$route['case/(:num)/delete'] = "case_emp/delete/$1";
$route['case/(:any)/info'] = "case_emp/info/$1";

$route['case_category/Page'] = "case_category/index";
$route['case_category/Page/(:num)'] = "case_category/index/$1";
$route['case_category/new'] = "case_category/edit";
$route['case_category/print'] = "case_category/print_pdf";
$route['case_category/(:num)/edit'] = "case_category/edit/$1";
$route['case_category/(:num)/delete'] = "case_category/delete/$1";
$route['case_category/(:any)/info'] = "case_category/info/$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */