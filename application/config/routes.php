<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
//views Login
$route['default_controller'] = 'Home/login';
$route['404_override'] = 'Home/error';
$route['translate_uri_dashes'] = FALSE;
$route['api/login']['POST'] = 'Login/login_user';
$route['api/logout']['POST'] = 'Login/logout';
$route['api/load_page']['GET']= 'Home/load_page';
$route['api/recovery_email']['POST']= 'Login/recovery_email';
$route['api/recovery']['POST']= 'Login/recovery';
$route['api/new_password']['POST']= 'Login/new_password';
/* $route['login']['GET']= 'Login/index'; */

//views admin OT 
$route['newOrder']['GET']='Orders/newOrder'; //view load create new order
$route['api/createOrder']['POST']='Orders/createOrder'; //controller action create new order
$route['adminImages']['GET'] ='Images/adminImages/$1';
$route['stagesOrder']['GET'] ='Orders/stagesOrder';
$route['newUpdateOrder']['GET']='Orders/newUpdateOrder';
$route['api/updateOrder']['POST']='Orders/updateOrder';
$route['api/changeStateOrder']['POST']='Orders/changeStateOrder';
$route['api/changeLocationOrder']['POST']='Orders/changeLocationOrder';
$route['adminOrders']['GET']='Orders/adminOrders';
$route['api/getOrders']['GET']='Orders/getOrders';
$route['api/getOrdersTest']['GET']='Orders/getOrdersTest';
$route['api/getFieldsOrder']['GET']='Orders/getFieldsOrder';
$route['api/getHistoryStatesByOrder/(:num)']['GET'] = 'Orders/getHistoryStatesByOrder/$1';
$route['api/getLocations']['GET']='Orders/getLocations';

//view counter
$route['counterOrders']['GET']='Counter/counterOrders';
$route['counterSeller']['GET']='Counter/counterSeller';

////view seller

$route['ordersApproved']['GET']='Seller/ordersApproved';
$route['ordersWapprobation']['GET']='Seller/ordersWapprobation';

//views admin resources
$route['adminComponent']['GET']='Component/adminComponent';
$route['adminBrand']['GET']='Brand/adminBrand';
$route['adminSubtask']['GET']='Subtask/adminSubtask';
$route['adminLocation']['GET']='Location/adminLocation';

/*api admin enterprise*/
$route['api/enterprise']['GET']= 'Enterprise/index';
$route['api/get_enterprises']['GET']= 'Enterprise/list';
$route['api/create_enterprise']['POST']= 'Enterprise/create';
$route['api/update_enterprise']['POST']= 'Enterprise/update';
$route['api/des_hab_enterprise']['POST']= 'Enterprise/des_hab';

/*api admin user*/
$route['api/user']['GET']= 'User/index';
$route['api/get_users']['GET']= 'User/list';
$route['api/create_user']['POST']= 'User/create';
$route['api/update_user']['POST']= 'User/update';
$route['api/des_hab_user']['POST']= 'User/des_hab';

/*api admin client*/
$route['api/client']['GET']= 'Client/index';
$route['api/get_clients']['GET']= 'Client/list';
$route['api/create_client']['POST']= 'Client/create';
$route['api/update_client']['POST']= 'Client/update';
$route['api/des_hab_client']['POST']= 'Client/des_hab';


//api admin resources 
//(Location)
$route['api/createLocation']['POST']='Location/createLocation';
$route['api/editLocation']['POST']='Location/editLocation';
$route['api/changeStateLocation']['POST']='Location/changeState';
$route['api/getLocation']['GET']='Location/getLocation';
//(Substask)
$route['api/createSubtask']['POST']='Subtask/createSubtask';
$route['api/editSubtask']['POST']='Subtask/editSubtask';
$route['api/changeStateSubtask']['POST']='Subtask/changeState';
$route['api/getSubtask']['GET']='Subtask/getSubtask';
//(Component)
$route['api/createComponent']['POST']='Component/createComponent';
$route['api/editComponent']['POST']='Component/editComponent';
$route['api/changeStateComponent']['POST']='Component/changeState';
$route['api/getComponent']['GET']='Component/getComponent';
//(Brand)
$route['api/createBrand']['POST']='Brand/createBrand';
$route['api/editBrand']['POST']='Brand/editBrand';
$route['api/changeStateBrand']['POST']='Brand/changeState';
$route['api/getBrand']['GET']='Brand/getBrand';


//api admin images OT

$route['api/addImage']['POST']  = 'Images/addImage';
$route['api/upImage/(:num)']['POST']  = 'Images/upImage/$1';
$route['api/getImagesByOrder/(:num)']['GET']  = 'Images/getImagesByOrder/$1';
$route['api/editImage/(:num)']['POST']  = 'Images/editImage/$1';
$route['api/upMultiplesImage/(:num)']['POST']  = 'Images/upMultiplesImage/$1';
$route['api/deleteImage/(:num)']['POST']  = 'Images/deleteImage/$1';


//api counter
$route['api/counterOrders']['GET'] = 'Counter/getData';


//api evaluation 
$route['api/getEvaluationByOrder/(:num)']['GET'] = 'Evaluation/getEvaluationByOrder/$1';
$route['api/editEvaluation/(:num)']['POST'] = 'Evaluation/editEvaluation/$1';
$route['api/getSubstacksEvaluationByOrder/(:num)']['GET'] = 'Evaluation/getSubstacksByOrder/$1';

//api hydraulicTEST
$route['api/getHydraulicTestByOrder/(:num)']['GET'] = 'HydraulicTest/getHydraulicTestByOrder/$1';
$route['api/editHydraulicTest/(:num)']['POST'] = 'HydraulicTest/editHydraulicTest/$1';
$route['api/editInfoHt/(:num)']['POST'] = 'HydraulicTest/editInfoHt/$1';
$route['api/get_info_ht/(:num)']['GET'] = 'HydraulicTest/get_info_ht/$1';
$route['api/editPdf/(:num)']['POST'] = 'HydraulicTest/editPdf/$1';
$route['api/getPdf/(:num)']['GET'] = 'HydraulicTest/getPdf/$1';
$route['api/deletePdf/(:num)']['POST'] = 'HydraulicTest/deletePdf/$1';
$route['api/save_config/(:num)']['POST'] = 'HydraulicTest/save_config/$1';

//api technical report 
$route['adminTechnicalReports']['GET'] = 'TechnicalReport/adminTechnicalReports';
$route['api/getTechnicalReportApprove']['GET']  = 'TechnicalReport/getTechnicalReportApprove';
$route['api/getTechnicalReportByOrder/(:num)']['GET'] = 'TechnicalReport/getTechnicalReportByOrder/$1';
$route['api/getImagesByTechnicalReport']['POST']  = 'TechnicalReport/getImagesByTechnicalReport';
$route['api/editTechnicalReport']['POST']  = 'TechnicalReport/editTechnicalReport';
$route['api/getPdfTechnicalReport']['POST']  = 'TechnicalReport/getPdfTechnicalReport';


//api aprobation 
$route['api/getAprobationByOrder/(:num)']['GET'] = 'Aprobation/getAprobationByOrder/$1';
$route['api/editAprobation/(:num)']['POST'] = 'Aprobation/editAprobation/$1';
$route['api/editOC/(:num)']['POST'] = 'Aprobation/editOC/$1';
$route['api/getOC/(:num)']['GET'] = 'Aprobation/getOC/$1';
$route['api/deleteOC/(:num)']['POST'] = 'Aprobation/deleteOC/$1';

//api reparation 
$route['api/getReparationByOrder/(:num)']['GET'] = 'Reparation/getReparationByOrder/$1';
$route['api/getSubstacksReparationByOrder/(:num)']['GET'] = 'Reparation/getSubstacksByOrder/$1';
$route['api/editReparation']['POST']  = 'Reparation/editReparation';
$route['api/CalculateDateReparation']['POST']  = 'Reparation/calculateReparation';


//api notes
$route['api/getNotesByOrder/(:num)']['GET'] = 'Notes/getNotesByOrder/$1';
$route['api/createNote']['POST'] = 'Notes/createNote';
$route['api/updateNote']['POST'] = 'Notes/updateNote';
$route['api/deleteNote']['POST'] = 'Notes/deleteNote';


/*------------------------------- Routes To Seller------------------------------------ */
//api Seller 
$route['api/getApproveTechnicalReport']['GET'] = 'Seller/getApproveTechnicalReport';
$route['api/getOrdersQuotation']['GET'] = 'Seller/getOrdersQuotation';
$route['api/changeState']['POST'] = 'Seller/changeState';
$route['api/OCseller/(:num)']['POST'] = 'Seller/editOC/$1';
/*------------------------------- End Routes Seller------------------------------------ */



/*------------------------------- Routes To Client------------------------------------ */
/*Admin Counter*/
$route['counterOrdersByClient']['GET']='Counter/counterOrdersByClient';
$route['api/counterOrdersByClient']['GET'] = 'Counter/getDataByClient';

/*Admin Orders*/
$route['adminOrdersByClient']['GET']= 'OrdersClient/adminOrders';
$route['adminOrdersByClientView']['GET']= 'OrdersClient/adminOrdersView';
$route['api/getOrdersByClient']['GET'] = 'OrdersClient/getOrders';

/*Admin Orders Approve*/
$route['adminOrdersApproveByClient']['GET'] = 'OrdersClient/adminOrdersApprove';
$route['adminOrdersApproveByClientView']['GET'] = 'OrdersClient/adminOrdersApproveView';
$route['api/getOrdersApproveByClient']['GET'] = 'OrdersClient/getOrdersApprove';
$route['api/approveByClient/(:num)']['POST'] = 'OrdersClient/approve/$1';
/*------------------------------- End Routes Client------------------------------------ */

//api Technical master 
/*------------------------------- Routes To Technical Master------------------------------------ */

$route['api/getHydraulicTestEnable']['GET'] = 'TechnicalMaster/getHydraulicTestEnable';
$route['api/getEvaluationEnable']['GET']='TechnicalMaster/getEvaluationEnable';

//view Technical master 
$route['adminHydraulicTest']['GET'] = 'TechnicalMaster/adminHydraulicTest';
$route['hydraylicTestForm']['GET']='TechnicalMaster/hydraylicTestForm/$1';
$route['hydraylicTestFormView']['GET']='TechnicalMaster/hydraylicTestFormView/$1';
$route['counterMaster']['GET']='TechnicalMaster/counterMaster';
$route['adminEvaluation']['GET']='TechnicalMaster/adminEvaluation'; 
$route['editEvaluation']['GET']='TechnicalMaster/editEvaluation/$1';//modo edicion evaluation 
$route['viewEvaluation']['GET']='TechnicalMaster/viewEvaluation/$1';// modo lectura evaluation 


/*Admin technical Report*/
$route['tmAdminstechnicalReport']['GET'] = 'TechnicalMaster/adminTechnicalReport';
$route['api/tmGetTechnicalReport']['GET'] = 'TechnicalMaster/getTechnicalReports';

$route['subtasksEvaluationList']['GET'] = 'TechnicalMaster/adminSubstasksEvaluation';
$route['tmAdminViewTechnicalReport/(:num)']['GET'] = 'TechnicalMaster/adminViewTechnicalReport/$1';
$route['api/tmDetailsTechnicalReport/(:num)']['GET'] = 'TechnicalMaster/DetailsTechnicalReport/$1';
$route['api/tmEditTechnicalReport']['POST'] = 'TechnicalMaster/EditTechnicalReport';



/*Admin reparations*/
$route['tmAdminReparation']['GET'] = 'TechnicalMaster/adminReparation';
$route['api/tmGetReparation']['GET'] = 'TechnicalMaster/getReparations';
$route['api/tmApproveReparation']['POST'] = 'TechnicalMaster/approveReparation';


$route['api/create/substakEvaluation']['POST'] = 'TechnicalMaster/createSubstakEvaluation';
$route['api/update/substakEvaluation']['POST'] = 'TechnicalMaster/updateSubstakEvaluation';
$route['api/tmGetSubstaksEvaluation/(:num)']['GET'] = 'TechnicalMaster/getSubstaksEvaluation/$1';
$route['api/des_hab/substakEvaluation']['POST']='TechnicalMaster/desHabSubstakEvaluation';

$route['tmAdminSubstasks/reparation/index']['GET'] = 'TechnicalMaster/adminSubstasksReparation';
$route['api/tmGetSubstaksReparation/(:num)']['GET'] = 'TechnicalMaster/getSubstaksReparation/$1';

/*Admin Substaks*/
$route['api/update/substakReparation']['POST'] = 'TechnicalMaster/updateSubstakReparation';
$route['api/create/substakReparation']['POST'] = 'TechnicalMaster/createSubstakReparation';
$route['api/des_hab/substakReparation']['POST'] = 'TechnicalMaster/desHabSubstakReparation';
$route['api/getSubstaksByEvaluation']['POST'] = 'TechnicalMaster/getSubstakByEvaluation';
$route['api/getSubstaksByReparation']['POST'] = 'TechnicalMaster/getSubstakByReparation';


$route['api/chronometer/HydraylicTest']['POST'] = 'TechnicalMaster/chronometerHydraulicTest';
$route['api/chronometer/evaluation']['POST'] = 'TechnicalMaster/chronometerEvaluation';

$route['api/chronometer']['POST'] = 'TechnicalMaster/chronometer';

/*------------------------------- End Routes Technical Master------------------------------------ */


/*------------------------------- Routes To Technical Assitant------------------------------------ */
$route['atAdminSubstaksReparation']['GET'] = 'TechnicalAssistant/adminSubstaksReparation';
$route['api/atGetSubstaksReparation']['GET'] = 'TechnicalAssistant/getSubstaksReparation';
$route['api/atApproveSubstakReparation']['POST'] = 'TechnicalAssistant/approveSubstakReparation';


$route['atAdminSubstaksEvaluation']['GET'] = 'TechnicalAssistant/adminSubstaksEvaluation';
$route['api/atGetSubstaksEvaluation']['GET'] = 'TechnicalAssistant/getSubstaksEvaluation';
$route['api/atApproveSubstakEvaluation']['POST'] = 'TechnicalAssistant/approveSubstakEvaluation';


$route['api/counterAssistant']['GET'] = 'TechnicalAssistant/getCounterData';

/*------------------------------- End Routes Technical Assitant------------------------------------ */
$route['projector']['GET']='Monitor/viewProjector';
$route['api/projector/kpiQuotation']['GET']='Monitor/chartQuotation';
$route['api/projector/kpiProduction']['GET']='Monitor/chartProduction';
$route['api/projector/Production']['GET']='Monitor/getProduction';
$route['api/projector/getOrders']['GET']='Monitor/getOrders';
$route['api/projector/getQuotation']['GET']='Monitor/getQuotation';

/*------------------------------- Kpi module ------------------------------------ */

$route['module_kpi/menu_kpi']['GET']='Kpi/menuKpi';
$route['module_kpi/kpiQuotation']['GET']='Kpi/kpiQuotation';
$route['module_kpi/kpiProduction']['GET']='Kpi/kpiProduction';
$route['module_kpi/kpi/avgQuotation']['POST']='Kpi/periodFilterQuotation';
$route['module_kpi/kpi/avgProduction']['POST']='Kpi/periodFilterProduction';
$route['module_kpi/kpi/orders']['POST']='Kpi/getOrders';
$route['module_kpi/kpi/report']['POST']='Kpi/generateReport';

$route['module_kpi/kpi/clean']['POST']='Kpi/clean';
$route['module_kpi/kpi/convertImage']['POST']='Kpi/convertImage';
$route['module_kpi/kpi/getYears']['GET']='Kpi/getYears';


/*------------------------------- Technical Information ------------------------------------ */
$route['module_technical/info/technical']['GET']='Techinformation/viewInfoTech';
$route['module_technical/info/technical/getTechnical']['GET']='Techinformation/getTechnical';
$route['module_technical/info/technical/getAssistent']['GET']='Techinformation/getAssistent';
$route['module_technical/info/technical/getOrdersWorked']['POST']='Techinformation/getOrdersWorked';
$route['module_technical/info/technical/getOrdersWorkedAT']['POST']='Techinformation/getOrdersWorkedAT';
$route['module_technical/info/technical/selectTech']['POST']='Techinformation/selectTech';
$route['module_technical/info/technical/getInfoEvaluation']['POST']='Techinformation/getInfoEvaluation';
$route['module_technical/info/technical/getInfoTr']['POST']='Techinformation/getInfoTr';
$route['module_technical/info/technical/getInfoHt']['POST']='Techinformation/getInfoHt';
$route['module_technical/info/technical/getInfoRep']['POST']='Techinformation/getInfoRep';
$route['adminClients']['GET']='Seller/adminClients';
$route['api/ordersEnterprise']['POST']='Seller/ordersEnterprise';
$route['api/orders_all']['GET']='Seller/ordersAllEnterprise';
/*---- nuevos------*/
$route['api/autoincrementID']['GET']='Orders/autoincrementID';
$route['stagesOrderSeller']['GET']='Seller/stagesOrderSeller';
$route['api/exportOT']['POST']='Export/generateExport';
$route['api/record/getRecordKpi']['GET']='External/index';

// routes library 
//view
$route['adminLibrary']['GET']='Library/adminLibrary';
$route['api/createTag']['POST']='Library/create_tag';
$route['api/get_tags']['GET']='Library/get_tags';
$route['api/delete_tags']['POST']='Library/delete_tags';
$route['api/create_document']['POST']='Library/create_document';
$route['api/get_document']['GET']='Library/get_document';
$route['api/edit_document/(:num)']['POST']='Library/documentUpload/$1';
$route['api/edit_document2/(:num)']['POST']='Library/documentUpload2/$1';
$route['viewDocument']['GET']='Library/view_document'; 
$route['api/edit_tag']['POST']='Library/edit_tag';
$route['api/update_tags']['POST']='Library/update_tags';
$route['api/edit_documents']['POST']='Library/edit_documents';
$route['api/get_tags']['GET']='Library/get_tags';
$route['searchDocumentation']['GET']='Library/searchDocumentation';
$route['api/change_state_document']['POST']='Library/change_state_documents';
$route['api/get_document_active']['GET']='Library/get_document_active';
$route['api/access_user']['GET']='Library/access_user';

//notifications
$route['api/get_notifications']['GET']='Notifications/get_notifications';
$route['api/change_notification/(:num)']['POST']='Notifications/change_notification/$1';

//notification seller
$route['api/get_user_notifications']['GET']='Notifications/get_user_notifications';

// notification_technical
$route['api/getNotificationsTechnical']['GET']='NotificationTechnical/getNotifications';
$route['api/createNotificationTechnical']['POST']='NotificationTechnical/createNotification';

$route['api/getNotificationByTechnical']['GET']='NotificationTechnical/getNotificationByTechnical';
$route['api/changeState']['POST']='NotificationTechnical/changeState';

$route['api/technicalMaster/getOrderById/(:num)']['GET']='TechnicalMaster/orderById/$1';
$route['api/stageOrderTechnical']['GET']='TechnicalMaster/stagesOrderTechnicals';


























