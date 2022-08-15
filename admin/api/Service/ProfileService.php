<?php

/*
 * This file will responsible for updation of admin profile,
 * Admin can also update Client and Supplier Detail
 */

class ProfileService {
    //working
    public function getAdminProfile($data) {
        $adminId = Helper::Sanitize($data['admin_id']);
        $isWeb = Helper::Sanitize($data['isweb']);
        $profileController = new ProfileController();
        echo $profileController->getAdminProfile($adminId, $isWeb);
        exit;
    }
    //working
    public function updateAdminPassword($data) {
        $adminId = Helper::Sanitize($data['admin_id']);
        $isWeb = Helper::Sanitize($data['isweb']);
        $currPass = Helper::Sanitize($data['curr_pass']);
        $newPass = Helper::Sanitize($data['new_pass']);

        $profileController = new ProfileController();
        echo $profileController->updateAdminPassword($adminId, $isWeb, $currPass, $newPass);
        exit;
    }
    //working
    public function updateProfile($data) {
        $adminId = Helper::Sanitize($data['admin_id']);
        $adminName = Helper::Sanitize($data['admin_name']);
        $adminPhone = Helper::Sanitize($data['admin_phone']);
        $adminEmail = Helper::Sanitize($data['admin_email']);
        $adminType = Helper::Sanitize($data['admin_type']);
        $current_password = Helper::Sanitize($data['current_password']);
        $admin_username = Helper::Sanitize($data['admin_username']);
        $isWeb = Helper::Sanitize($data['isweb']);
        $profileController = new ProfileController();
        echo $profileController->updateProfile($adminId, $adminName, $adminPhone, $adminEmail, $adminType, $admin_username, $current_password, $isWeb);
        exit;
    }

    public function getAdminRights($data) {
        $adminId = Helper::Sanitize($data['admin_id']);
        $profileController = new ProfileController();
        echo $profileController->getAdminRights($adminId);
        exit;
    }

    public function getAllAdminRights($data) {
        $isWeb = Helper::Sanitize($data['isweb']);

        $profileController = new ProfileController();
        echo $profileController->getAllAdminRights($isWeb);
        exit;
    }

    
    
    
    
    
//    public function addEmployee($data){
//        $adminId = Helper::Sanitize($data['admin_id']);
//        $isWeb = Helper::Sanitize($data['isweb']);
//        $empName = Helper::Sanitize($data['emp_name']);
//        $empMobile = Helper::Sanitize($data['emp_mobile']);
//        $empEmail = Helper::Sanitize($data['emp_email']);
//        $empUsername = Helper::Sanitize($data['emp_username']);
//        $empPassword = Helper::Sanitize($data['emp_password']);
//        $empRight = Helper::Sanitize($data['ids']);
//        $adminType = "2";
//        $profileController = new ProfileController();
//        echo $profileController->addEmployee($adminId,$isWeb,$empName,$empMobile,$empEmail,$empUsername,$empPassword,$empRight,$adminType);
//        exit;
//    }
//    public function getEmpProfile($data) {
//        $adminId = Helper::Sanitize($data['admin_id']);
//        $isWeb = Helper::Sanitize($data['isweb']);
//
//        $profileController = new ProfileController();
//        echo $profileController->getEmpProfile($adminId,$isWeb);
//        exit;
//    }
//
//    public function getAllEmpProfile($data) {
//        $adminId = Helper::Sanitize($data['admin_id']);
//        $adminType = Helper::Sanitize($data['admin_type']);
//        $isWeb = Helper::Sanitize($data['isweb']);
//
//        $profileController = new ProfileController();
//        echo $profileController->getAllEmpProfile($adminId,$isWeb, $adminType);
//        exit;
//    }
//    
//    public function updateEmpProfile($data) {
//        $adminId = Helper::Sanitize($data['admin_id']);
//        $isWeb = Helper::Sanitize($data['isweb']);
//        $empId = Helper::Sanitize($data['emp_admin_id']);
//        $empName = Helper::Sanitize($data['emp_name']);
//        $empMobile = Helper::Sanitize($data['emp_mobile']);
//        $empEmail = Helper::Sanitize($data['emp_email']);
//        $empUsername = Helper::Sanitize($data['emp_username']);
////        $empPassword = Helper::Sanitize($data['emp_password']);
//        $empRights = Helper::Sanitize($data['ids']);
////        var_dump($data);
//        $profileController = new ProfileController();
//        echo $profileController->updateEmpProfile($adminId,$isWeb,$empId,$empName,$empMobile,$empEmail,$empUsername,$empRights);
//        exit;
//    }
//    
//    public function removeEmpProfile($data) {
//        $adminId = Helper::Sanitize($data['admin_id']);
//        $empadminId = Helper::Sanitize($data['emp_admin_id']);
////        $adminType = Helper::Sanitize($data['admin_type']);
//        $isWeb = Helper::Sanitize($data['isweb']);
//        $profileController = new ProfileController();
//        echo $profileController->removeEmpProfile($adminId,$empadminId,$isWeb);
//        exit;
//
//    }
//    public function addCustomerProfile($data, $files = '') {
//        $isWeb = Helper::Sanitize($data['isweb']);
//        $adminId = Helper::Sanitize($data['admin_id']);
//        
//        //customer personal profile
//        $customerName = Helper::Sanitize($data['customer_name']);
//        $customerEmail = Helper::Sanitize($data['customer_email']);
//        $customerPhone = Helper::Sanitize($data['customer_phone']);
//        
//        // company
////        if (isset($data['company_id']))
////            $companyId = Helper::Sanitize($data['company_id']);
////        else
////            $companyId = null;
//        $companyName = Helper::Sanitize($data['company_name']);
//        $companyLogo = $files['company_logo'];
//        $companyAddress = Helper::Sanitize($data['company_address']);
//        $companyState = Helper::Sanitize($data['company_state']);
//        $companyCountry = Helper::Sanitize($data['company_country']);
//        
//        //company registration
////        if (isset($data['company_reg_id']))
////            $companyRegId = Helper::Sanitize($data['company_reg_id']);
////        else
////            $companyRegId = null;
//        $gstin = Helper::Sanitize($data['gstin']);
//        $tinNo = Helper::Sanitize($data['tin_no']);
//        $panNo = Helper::Sanitize($data['pan_no']);
//        
//        $profileController = new ProfileController();
//        echo $profileController->addCustomerProfile($isWeb, $adminId, $customerName, $customerEmail, $customerPhone, 
//                 $companyName, $companyLogo, $companyAddress, $companyState, $companyCountry,
//                 $gstin, $tinNo, $panNo);
//        exit;
//    }
//    
//    public function getAllCustomerDetail($data) {
//        $isWeb = Helper::Sanitize($data['isweb']);
//        
//        $profileController = new ProfileController();
//        echo $profileController->getAllCustomerDetail($isWeb);
//        exit;
//    }
//    
//    public function getCustomerProfile($data){
//        $isWeb = Helper::Sanitize($data['isweb']);
//        $customerId = Helper::Sanitize($data['customer_id']);
//        $profileController = new ProfileController();
//        echo $profileController->getCustomerProfile($customerId);
//        exit;
//    }
//
//    
//    public function getAllSupplierDetail($data) {
//        $isWeb = Helper::Sanitize($data['isweb']);
//        
//        $profileController = new ProfileController();
//        echo $profileController->getAllSupplierDetail($isWeb);
//        exit;
//    }
//    
//    public function getSupplierProfile($data){
//        $supplierId = Helper::Sanitize($data['supplier_id']);
//        $profileController = new ProfileController();
//        echo $profileController->getSupplierProfile($supplierId);
//        exit;
//    }
//    
//    public function addSupplierProfile($data) {
//        $isWeb = Helper::Sanitize($data['isweb']);
//        
//        $profileController = new ProfileController();
//        echo $profileController->addSupplierProfile($data, $isWeb);
//        exit;
//    }
//
//    public function updateCustomerProfile($data, $files = array('company_logo'=>'')) {
//        $isWeb = Helper::Sanitize($data['isweb']);
//        $adminId = Helper::Sanitize($data['admin_id']);
//        
//        
//        $profileController = new ProfileController();
//        echo $profileController->updateCustomerProfile ($isWeb, $adminId, $data);
//        exit;
//    }
//
//    public function updateSupplierProfile($data) {
//        $adminId = Helper::Sanitize($data['admin_id']);
//        $supplierId = Helper::Sanitize($data['supplier_id']);
//        $supplierName = Helper::Sanitize($data['supplier_name']);
//        $supplierPhone = Helper::Sanitize($data['supplier_phone']);
//        $supplierEmail  = Helper::Sanitize($data['supplier_email']);
//        $profileController = new ProfileController();
//        echo $profileController->updateSupplierProfile($adminId,$supplierId,$supplierName,$supplierPhone,$supplierEmail);
//        exit;
//    }
}

?>
