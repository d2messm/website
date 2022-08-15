<?php

class CompanyModel extends Database {
    
    //working
    public function getCompanyDetail($companyId) {
        $sql = "SELECT * FROM `company_detail` WHERE `company_id`='$companyId' LIMIT 1;";
        return parent::executeQuery($sql);
        
    }
    //working
    public function getCompanyRegByRegId($companyRegId) {
        $sql = "SELECT * FROM `company_reg_no` WHERE `company_reg_id`='$companyRegId' LIMIT 1;";
        return parent::executeQuery($sql);
    }

    //working
    public function updateCompanyProfile($companyId, $companyName, $companyLogoUrl, $companyAddress, $companyState,
            $companyCountry, $companyRegId, $adminId) {
        $sql = "UPDATE `company_detail` "
                . " SET `company_name`='$companyName', `company_logo_url`='$companyLogoUrl', `company_address`='$companyAddress',"
                . " `company_state`='$companyState', `company_country`='$companyCountry',`company_reg_id`='$companyRegId', `addedby`='$adminId' "
                    . "WHERE "
                . "`company_id`='$companyId';";
        return parent::executeQuery($sql);
    }

    //working
    public function updateCompanyRegistrationDetail($companyRegId, $gstin, $tinNo, $panNo, $adminId) {
        $sql = "UPDATE "
                . "`company_reg_no` "
                . " SET `gstin`='$gstin', `tin_no`='$tinNo', `pan_no`='$panNo', `addedby`='$adminId', `timestamp`=now() "
                . "WHERE "
                . "`company_reg_id`='$companyRegId';";
        return parent::executeQuery($sql);
        
    }
    
    public function lastInsertId() {
        return parent::lastInsertedId();
    }
    
}
