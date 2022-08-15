<?php

class CompanyController {
    
    //working
    //this method return companydetail along with registration detail.
    public function getCompanyBasicDetail($isWeb, $adminId) {
        $error = '';
        
        if (strlen($adminId) == 0) {
            $error.='Please Specify Admin Id';
        }
        
        if (strlen($error) != 0) {
            return Helper::getStandardData(0, $error, 1);
        }
        $companyModel = new CompanyModel();
        
        $profileModel = new ProfileModel();
        $adminProfileRS = $profileModel->getAdminProfile($adminId);
        $adminProfileRow = mysqli_fetch_assoc($adminProfileRS);
        $companyId = $adminProfileRow['company_id'];
        
        $companyRS = $companyModel->getCompanyDetail($companyId);
        
        if (!$companyRS) {
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        } else if (mysqli_num_rows($companyRS) == 0) {
            return Helper::getStandardData(0, "Company detail not found", 1);
        } else {
            $companyRow = mysqli_fetch_assoc($companyRS);
            $companyRegId = $companyRow['company_reg_id'];
            
            $companyRegRS = $companyModel->getCompanyRegByRegId($companyRegId);
            
            $companyRegRow = mysqli_fetch_assoc($companyRegRS);
            $companyFullDetail = array("company_detail" => $companyRow, "company_registration_detail" => $companyRegRow);
            return Helper::getStandardData(1, '', 1, $companyFullDetail);
        }
        
    }
    
    
    
    //working
    public function updateCompanyProfile($isWeb,$companyName,$companyAddress,$companyLogoUrl,
                $companyState,$companyCountry, $companyGSTIN,$companyTinNo,$companyPanNo,$adminId){
        $error = '';
        
        if (strlen($companyName)  === 0) {
            $error.='Please Specify Correct Information';
        }
        if (strlen($companyGSTIN)  === 0) {
            $error.='Please Specify Correct Information';
        }
        if (strlen($companyTinNo)  === 0) {
            $error.='Please Specify Correct Information';
        }
        if ($companyLogoUrl=="fail"){
            $error.='Please upload a valid Image format';
        }
        if (strlen($companyAddress)  === 0) {
            $error.='Please Specify Correct Information';
        }
        
        if (strlen($error) != 0) {
            return Helper::getStandardData(0, $error, 1);
        }
        $profileModel = new ProfileModel();
        $resultSet = $profileModel->getAdminProfile($adminId);
        $resultRow = mysqli_fetch_assoc($resultSet);
        $companyId = $resultRow['company_id'];
        
        $companyModel = new CompanyModel();
        $companyRegRs = $companyModel->getCompanyDetail($companyId);
        $companyRegRow = mysqli_fetch_assoc($companyRegRs);
        $companyRegId = $companyRegRow['company_reg_id'];
        
        $companyRS = $companyModel->updateCompanyProfile($companyId, $companyName, $companyLogoUrl, $companyAddress, $companyState,
            $companyCountry, $companyRegId, $adminId);
        

        //first insert company registration detail
        $registrationRS = $companyModel->updateCompanyRegistrationDetail($companyRegId, $companyGSTIN, $companyTinNo, $companyPanNo, $adminId);
        
        
        if (!$companyRS && !$registrationRS) {
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
                    
        } else {
            return Helper::getStandardData(1, 'Company Detail Updated', 1);
        }
                }
}
