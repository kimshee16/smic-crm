<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'userlogincontroller';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Page routes
$route['dashboard'] = 'dashboardcontroller/index';
$route['customerinfo'] = 'customerinfocontroller/index';
$route['payments'] = 'paymentscontroller/index';
$route['requireddocuments'] = 'requireddocumentscontroller/index';

// Userlogin routes
$route['logintypical'] = 'userlogincontroller/logintypical';
$route['signout'] = 'userlogincontroller/signout';
$route['forgotpassword'] = 'userlogincontroller/forgotpassword';
$route['forgotpasswordsend'] = 'userlogincontroller/forgotpasswordsend';
$route['privacypolicy'] = 'userlogincontroller/privacypolicy';

// Client Information
$route['editclientinfo/(:any)'] = 'customerinfocontroller/editclientinfo/$1';
$route['editclientinfo2/(:any)/(:any)'] = 'customerinfocontroller/editclientinfo2/$1/$2';
$route['editclientinfo2/(:any)'] = 'customerinfocontroller/editclientinfo2/$1';
$route['savefirebasefile'] = 'customerinfocontroller/savefirebasefile';
$route['create_student_gdrive_folder'] = 'customerinfocontroller/create_student_gdrive_folder';
$route['upload_student_gdrive_file'] = 'customerinfocontroller/upload_student_gdrive_file';
$route['send_po_link_email'] = 'customerinfocontroller/send_po_link_email';
$route['assignofficer'] = 'customerinfocontroller/assignofficer';
$route['enterclientinfo/(:any)'] = 'customerinfocontroller/enterclientinfo/$1';
$route['resetphoto/(:any)'] = 'customerinfocontroller/resetphoto/$1';
$route['deactivateclient/(:any)'] = 'customerinfocontroller/deactivateclient/$1';
$route['saveresult'] = 'customerinfocontroller/saveresult';
$route['updateresult'] = 'customerinfocontroller/updateresult';
$route['editfile'] = 'customerinfocontroller/editfile';
$route['editfirebasefile'] = 'customerinfocontroller/editfirebasefile';
$route['editgsdfile'] = 'customerinfocontroller/editfirebasefile';
$route['clientmonitoring'] = 'customerinfocontroller/clientmonitoring';
$route['deletefile'] = 'customerinfocontroller/deletefile';
$route['deletefirebasefile'] = 'customerinfocontroller/deletefirebasefile';
$route['deletegsdfile'] = 'customerinfocontroller/deletefirebasefile';

// Interview
$route['saveinterview'] = 'Interviewcontroller/do_upload';

// Fee
$route['savefee'] = 'Feecontroller/do_upload';

// Offer Letter
$route['saveofferletter'] = 'Offercontroller/do_upload';

// Payment routes
$route['newpayment'] = 'paymentscontroller/newpayment';
$route['editpayment/(:any)'] = 'paymentscontroller/editpayment/$1';
$route['savepayment'] = 'Receiptscontroller/do_upload';
$route['archivepayment/(:any)'] = 'paymentscontroller/archivepayment/$1';
$route['editpayment/(:any)'] = 'paymentscontroller/editpayment/$1';
$route['viewpayment_commission/(:any)'] = 'paymentscontroller/viewpayment_commission/$1';
$route['viewpayment_invoice/(:any)'] = 'paymentscontroller/viewpayment_invoice/$1';
$route['viewpayment_paymentreceipt/(:any)'] = 'paymentscontroller/viewpayment_paymentreceipt/$1';
$route['viewpayment_acknowledgementreceipt/(:any)'] = 'paymentscontroller/viewpayment_acknowledgementreceipt/$1';
$route['new_payment_getclientdetails/(:any)'] = 'paymentscontroller/new_payment_getclientdetails/$1';
$route['savenewpayment'] = 'Newpaymentscontroller/do_upload';

// School and Program routes
$route['schools'] = 'schoolsprogramscontroller/schools';
$route['programs'] = 'schoolsprogramscontroller/programs';
$route['newschool'] = 'schoolsprogramscontroller/newschool';
$route['saveschool'] = 'schoolsprogramscontroller/saveschool';
$route['newprogram'] = 'schoolsprogramscontroller/newprogram';
$route['saveprogram'] = 'schoolsprogramscontroller/saveprogram';
$route['editschool/(:any)'] = 'schoolsprogramscontroller/editschool/$1';
$route['updateschool'] = 'schoolsprogramscontroller/updateschool';
$route['editprogram/(:any)'] = 'schoolsprogramscontroller/editprogram/$1';
$route['updateprogram'] = 'schoolsprogramscontroller/updateprogram';
$route['deleteschool/(:any)'] = 'schoolsprogramscontroller/deleteschool/$1';
$route['deleteprogram/(:any)'] = 'schoolsprogramscontroller/deleteprogram/$1';

// Applications routes
$route['applications'] = 'applicationscontroller/index';
$route['newapplication/(:any)'] = 'applicationscontroller/newapplication/$1';
$route['getprogramfromschool/(:any)'] = 'applicationscontroller/getprogramfromschool/$1';
$route['saveapplication'] = 'Vevocontroller/do_upload';
$route['editapplication/(:any)'] = 'applicationscontroller/editapplication/$1';
$route['updateapplication'] = 'applicationscontroller/updateapplication';
$route['deleteapplication/(:any)'] = 'applicationscontroller/deleteapplication/$1';
$route['deleteapplicationfromcinfo/(:any)/(:any)'] = 'applicationscontroller/deleteapplicationfromcinfo/$1/$2';

// Forms routes
$route['clientform'] = 'formscontroller/clientform';
$route['saveclientform'] = 'formscontroller/saveclientform';
$route['do_upload'] = 'formscontroller/do_upload';
$route['success'] = 'formscontroller/success';
$route['programoptionform/(:any)'] = 'formscontroller/programoptionform/$1';
$route['po_link_preview/(:any)/(:any)'] = 'formscontroller/po_link_preview/$1/$2';
$route['accept_po_link'] = 'formscontroller/accept_po_link';
$route['reject_po_link'] = 'formscontroller/reject_po_link';
$route['sendemail'] = 'formscontroller/sendemail';
$route['checkexistingemail/(:any)'] = 'formscontroller/checkexistingemail/$1';

// Admin maintenance routes
$route['adminmaintenance'] = 'adminmaintenancecontroller/index';
$route['adminmaintenance/(:any)'] = 'adminmaintenancecontroller/index/$1';
$route['newregion'] = 'adminmaintenancecontroller/newregion';
$route['saveregion'] = 'adminmaintenancecontroller/saveregion';
$route['newofficer'] = 'adminmaintenancecontroller/newofficer';
$route['saveofficer'] = 'adminmaintenancecontroller/saveofficer';
$route['newassignment'] = 'adminmaintenancecontroller/newassignment';
$route['saveassignment'] = 'adminmaintenancecontroller/saveassignment';
$route['saveemailcontent'] = 'adminmaintenancecontroller/saveemailcontent';
$route['saveparameters'] = 'adminmaintenancecontroller/saveparameters';
$route['updatepriviledge'] = 'adminmaintenancecontroller/updatepriviledge';
$route['newevent'] = 'eventscontroller/newevent';
$route['editofficer/(:any)'] = 'adminmaintenancecontroller/editofficer/$1';
$route['updateofficerphoto'] = 'adminmaintenancecontroller/updateofficerphoto';
$route['editregion/(:any)'] = 'adminmaintenancecontroller/editregion/$1';
$route['updateregion'] = 'adminmaintenancecontroller/updateregion';
$route['editassignment/(:any)'] = 'adminmaintenancecontroller/editassignment/$1';
$route['updateassignment'] = 'adminmaintenancecontroller/updateassignment';
$route['editevent/(:any)'] = 'eventscontroller/editevent/$1';
$route['deactivateofficer/(:any)'] = 'adminmaintenancecontroller/deactivateofficer/$1';
$route['deactivateassignment/(:any)'] = 'adminmaintenancecontroller/deactivateassignment/$1';
$route['deleteregion/(:any)'] = 'adminmaintenancecontroller/deleteregion/$1';
$route['deleteevent/(:any)'] = 'adminmaintenancecontroller/deleteevent/$1';
$route['newoffice'] = 'adminmaintenancecontroller/newoffice';
$route['saveoffice'] = 'adminmaintenancecontroller/saveoffice';
$route['editoffice/(:any)'] = 'adminmaintenancecontroller/editoffice/$1';
$route['updateoffice'] = 'adminmaintenancecontroller/updateoffice';
$route['deleteoffice/(:any)'] = 'adminmaintenancecontroller/deleteoffice/$1';

// Scholarship routes
$route['scholarships'] = 'scholarshipcontroller/index';
$route['newscholarshipfile'] = 'scholarshipcontroller/newscholarshipfile';
$route['savescholarshipfile'] = 'scholarshipcontroller/savescholarshipfile';
$route['newscholarshipallocation'] = 'scholarshipcontroller/newscholarshipallocation';
$route['savescholarshipallocation'] = 'scholarshipcontroller/savescholarshipallocation';
$route['deactivateschofile/(:any)'] = 'scholarshipcontroller/deactivateschofile/$1';
$route['deactivateschoallo/(:any)'] = 'scholarshipcontroller/deactivateschoallo/$1';
$route['editscholarshipfile/(:any)'] = 'scholarshipcontroller/editscholarshipfile/$1';
$route['updatescholarshipfile'] = 'scholarshipcontroller/updatescholarshipfile';

// Visa routes
$route['newvisaapplication/(:any)'] = 'visacontroller/newvisaapplication/$1';
$route['newvisaeoi/(:any)'] = 'visacontroller/newvisaeoi/$1';
$route['newvisaaccount/(:any)'] = 'visacontroller/newvisaaccount/$1';
$route['savevisaapplication'] = 'visacontroller/savevisaapplication';
$route['savevisaeoi'] = 'visacontroller/savevisaeoi';
$route['savevisaaccount'] = 'visacontroller/savevisaaccount';
$route['editvisaapplication/(:any)'] = 'visacontroller/editvisaapplication/$1';
$route['editvisaeoi/(:any)'] = 'visacontroller/editvisaeoi/$1';
$route['editvisaaccount/(:any)/(:any)'] = 'visacontroller/editvisaaccount/$1/$2';
$route['updatevisaapplication'] = 'visacontroller/updatevisaapplication';
$route['updatevisaeoi'] = 'visacontroller/updatevisaeoi';
$route['updatevisaaccount'] = 'visacontroller/updatevisaaccount';
$route['deletevisaapplication/(:any)/(:any)'] = 'visacontroller/deletevisaapplication/$1/$2';
$route['deletevisaeoi/(:any)/(:any)'] = 'visacontroller/deletevisaeoi/$1/$2';
$route['deletevisaaccount/(:any)/(:any)'] = 'visacontroller/deletevisaaccount/$1/$2';

// Reports routes
$route['reports'] = 'reportscontroller/index';
$route['generatereportdefault'] = 'reportscontroller/generatereportdefault';
$route['student_application_report'] = 'reportscontroller/student_application_report';
$route['visa_application_report'] = 'reportscontroller/visa_application_report';
$route['visa_eoi'] = 'reportscontroller/visa_eoi';
$route['visa_account'] = 'reportscontroller/visa_account';
$route['payment_report/(:any)'] = 'reportscontroller/payment_report/$1';

// Inquiries routes
$route['inquiries'] = 'inquiriescontroller/index';
$route['deleteinquiry/(:any)'] = 'inquiriescontroller/deleteinquiry/$1';
$route['transferinquirytoclient/(:any)'] = 'inquiriescontroller/transferinquirytoclient/$1';
$route['getsingleinquiry/(:any)'] = 'inquiriescontroller/getsingleinquiry/$1';
$route['transferinquirytoclientfromdashboard/(:any)'] = 'inquiriescontroller/transferinquirytoclientfromdashboard/$1';

// Program Options routes
$route['newprogramoption/(:any)'] = 'programoptionscontroller/newprogramoption/$1';
$route['saveprogramoptions'] = 'programoptionscontroller/do_upload';
$route['editprogramoptions/(:any)'] = 'programoptionscontroller/editprogramoption/$1';
$route['updateprogramoptions'] = 'programoptionscontroller/updateprogramoptions';
$route['newprogramoptiondetails/(:any)'] = 'programoptionscontroller/newprogramoptiondetails/$1';
$route['saveprogramoptiondetails'] = 'programoptionscontroller/saveprogramoptiondetails';
$route['editprogramoptiondetails/(:any)'] = 'programoptionscontroller/editprogramoptiondetails/$1';
$route['updateprogramoptiondetails'] = 'programoptionscontroller/updateprogramoptiondetails';
$route['acceptpo'] = 'programoptionscontroller/acceptpo';
$route['rejectpo/(:any)'] = 'programoptionscontroller/rejectpo/$1';
$route['posuccess'] = 'programoptionscontroller/posuccess';
$route['saveclientfeedback'] = 'programoptionscontroller/saveclientfeedback';
$route['deletepo/(:any)/(:any)'] = 'programoptionscontroller/deletepo/$1/$2';
$route['newpotemplate/(:any)'] = 'programoptionscontroller/newpotemplate/$1';
$route['programoptionsdetailsnew/(:any)'] = 'programoptionscontroller/programoptionsdetailsnew/$1';
$route['saveprogramoptionsdetailsnew'] = 'programoptionscontroller/saveprogramoptionsdetailsnew';
$route['getscholarshopfromschool/(:any)'] = 'programoptionscontroller/getscholarshopfromschool/$1';
$route['getprogramdetails/(:any)'] = 'programoptionscontroller/getprogramdetails/$1';
$route['getprogramdetails/(:any)'] = 'programoptionscontroller/getprogramdetails/$1';
$route['deleteprogramoptiondetailnew/(:any)/(:any)'] = 'programoptionscontroller/deleteprogramoptiondetailnew/$1/$2';


// Required documents routes
$route['adddocuments'] = 'requireddocumentscontroller/adddocuments';
$route['updatedocuments'] = 'requireddocumentscontroller/updatedocuments';
$route['getdocuments/(:any)'] = 'requireddocumentscontroller/getdocuments/$1';
$route['deletedocuments/(:any)'] = 'requireddocumentscontroller/deletedocuments/$1';

// Messages routes
$route['messages'] = 'messagescontroller/index';
$route['getconversation/(:any)'] = 'messagescontroller/getconversation/$1';
$route['updatethreads/(:any)'] = 'messagescontroller/updatethreads/$1';
$route['savefilechat'] = 'messagescontroller/savefilechat';
$route['savetextchat'] = 'messagescontroller/savetextchat';
$route['createthread'] = 'messagescontroller/createthread';
$route['savetoclientdocuments'] = 'messagescontroller/savetoclientdocuments';

// Client routes
$route['clientlogin'] = 'clientlogincontroller/index';
$route['clientloginpo'] = 'clientlogincontroller/clientloginpo';
$route['clientlogintypical'] = 'clientlogincontroller/clientlogintypical';
$route['clientsignout'] = 'clientlogincontroller/clientsignout';
$route['clientforgotpassword'] = 'clientlogincontroller/clientforgotpassword';
$route['clientforgotpasswordsend'] = 'clientlogincontroller/clientforgotpasswordsend';

// Dashboard routes
$route['archivetasklist/(:any)'] = 'dashboardcontroller/archivetasklist/$1';
$route['donetasklist/(:any)'] = 'dashboardcontroller/donetasklist/$1';
$route['completetodaystask'] = 'dashboardcontroller/completetodaystask';
$route['markasread'] = 'dashboardcontroller/markasread';

$route['programoptionform2/(:any)'] = 'formscontroller/programoptionform2/$1';

$route['newprogramoptiondetailwithoutdependent/(:any)'] = 'programoptionscontroller/newprogramoptiondetailwithoutdependent/$1';
$route['saveprogramoptiondetailwithoutdependent'] = 'programoptionscontroller/saveprogramoptiondetailwithoutdependent';
$route['deleteprogramoptiondetailwithoutdependent/(:any)/(:any)'] = 'programoptionscontroller/deleteprogramoptiondetailwithoutdependent/$1/$2';
$route['newprogramoptiondetailwithdependent/(:any)'] = 'programoptionscontroller/newprogramoptiondetailwithdependent/$1';
$route['saveprogramoptiondetailwithdependent'] = 'programoptionscontroller/saveprogramoptiondetailwithdependent';
$route['deleteprogramoptiondetailwithdependent/(:any)/(:any)'] = 'programoptionscontroller/deleteprogramoptiondetailwithdependent/$1/$2';
$route['newprogramoptiondetaileipwithoutdependent/(:any)'] = 'programoptionscontroller/newprogramoptiondetaileipwithoutdependent/$1';
$route['saveprogramoptiondetaileipwithoutdependent'] = 'programoptionscontroller/saveprogramoptiondetaileipwithoutdependent';
$route['deleteprogramoptiondetaileipwithoutdependent/(:any)/(:any)'] = 'programoptionscontroller/deleteprogramoptiondetaileipwithoutdependent/$1/$2';
$route['newprogramoptiondetaileipwithdependent/(:any)'] = 'programoptionscontroller/newprogramoptiondetaileipwithdependent/$1';
$route['saveprogramoptiondetaileipwithdependent'] = 'programoptionscontroller/saveprogramoptiondetaileipwithdependent';
$route['deleteprogramoptiondetaileipwithdependent/(:any)/(:any)'] = 'programoptionscontroller/deleteprogramoptiondetaileipwithdependent/$1/$2';
$route['profile/(:any)'] = 'customerinfocontroller/profile/$1';
