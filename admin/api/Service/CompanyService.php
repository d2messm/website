<?php

class CompanyService {

//    //working
    public function updateCompanyProfile($data, $files = '') {
        $isWeb = Helper::Sanitize($data['isweb']);

        $companyName = Helper::Sanitize($data['company_name']);

        $companyAddress = Helper::Sanitize($data['company_address']);
        $companyState = Helper::Sanitize($data['company_state']);
        $companyCountry = Helper::Sanitize($data['company_country']);
        $companyLogoUrl = '';
        if (isset($files['company_logo'])) {
            if(Helper::validateLogo($files['company_logo'])==TRUE){
                $companyLogoUrl = Helper::uploadFile($files['company_logo'], Constant::$COMPANY_IMG_DIR);
            } else {
                $companyLogoUrl = "fail";
            }
        }
        $companyGSTIN = Helper::Sanitize($data['company_gstn']);
        $companyTinNo = Helper::Sanitize($data['company_tin']);
        $companyPanNo = Helper::Sanitize($data['company_pan']);

        $adminId = Helper::Sanitize($data['admin_id']);

        $companyController = new CompanyController();
        echo $companyController->updateCompanyProfile($isWeb, $companyName, $companyAddress, $companyLogoUrl, $companyState, $companyCountry, $companyGSTIN, $companyTinNo, $companyPanNo, $adminId);
        exit;
    }

    //working
    //get company basic detail along with state
    public function getCompanyBasicDetail($data) {
        $isWeb = Helper::Sanitize($data['isweb']);
        $adminId = Helper::Sanitize($data['admin_id']);
        $companyController = new CompanyController();
        echo $companyController->getCompanyBasicDetail($isWeb, $adminId);
        exit;
    }

}
