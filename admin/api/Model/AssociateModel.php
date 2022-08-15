<?php

class AssociateModel extends Database{
    
    public function lastInsertedId() {
         return parent::lastInsertedId();
    }
    public function addAssociate($name, $mobile, 
            $email, $isCompany, $companyId, $address, $gender, $dob, $adminId, 
            $userId, $docIds,$docNames,$documentImageURL){
        $sql = "INSERT INTO `associate_partner`(ref_user_id,name,mobile,email,is_company,ref_company_id,document_no,document_name,"
                . "document_url,address,gender,dob,added_by) values('$userId','$name','$mobile','$email','$isCompany','$companyId','$docIds',"
                . "'$docNames','$documentImageURL','$address','$gender','$dob','$adminId');";
        return parent::executeQuery($sql);
            }
    public function addCompany($companyName,$companyLogoURL,$companyAddress,
                $companyPhone,$companyState,$companyCountry,$tinNO,$gstin,$panNO,$adminId){
        $sql = "INSERT INTO `company`(company_name,company_logo_url,company_address,company_phone,company_state,"
                . "company_country,gstin,tin_no,pan_no,added_by) values('$companyName','$companyLogoURL','$companyAddress',"
                . "'$companyPhone','$companyState','$companyCountry','$tinNO','$gstin','$panNO','$adminId');";
        return parent::executeQuery($sql);
                }
                
    public function addNewUserLogin($userName, $password, $userType, $userRight){
        $sql="INSERT INTO `user_login`(user_name,user_password,user_type,user_right)values('$userName',"
                . "'$password','$userType','$userRight');";
        return parent::executeQuery($sql);
    }
    public function getAllAssociateProfile($adminId){
        $sql="SELECT * FROM `associate_partner` WHERE `added_by`='$adminId'";
        return parent::executeQuery($sql);
    }
    
    public function getUserRights($userId){
        $sql="SELECT user_name,user_right FROM `user_login` WHERE `user_id`='$userId'";
        return parent::executeQuery($sql);
    }
    public function getParticularCompanyProfile($companyId){
        $sql="SELECT * FROM `company` WHERE `company_id`='$companyId'";
        return parent::executeQuery($sql);
    }
    
    public function getDocumentUrl($associateId){
        $sql="SELECT document_no,document_name,document_url,ref_company_id FROM `associate_partner` WHERE `ref_user_id`='$associateId'";
        return parent::executeQuery($sql);
        
    }
    
    public function updateUserLogin($userId,$userName, $userType, $rights){
        $sql="UPDATE `user_login` SET `user_name`='$userName',`user_right`='$rights',`user_type`='$userType' WHERE `user_id`='$userId'";
        
        return parent::executeQuery($sql);
    }
    
    public function updateAssociate($associateId,$name, $mobile, $email, $isCompany, $address,
            $gender, $dob, $adminId, $docIds, $docNames, $documentImageURL){
        $sql="UPDATE `associate_partner` SET `name`='$name',`mobile`='$mobile',`email`='$email',`is_company`='$isCompany',"
                . "`document_no`='$docIds',`document_name`='$docNames',`document_url`='$documentImageURL',`address`='$address',"
                . "`gender`='$gender',`dob`='$dob',`added_by`='$adminId' WHERE `ref_user_id`='$associateId'";
        
        return parent::executeQuery($sql);
    }
    
    public function updateCompany($companyId,$companyName, $companyLogoURL, $companyAddress, 
            $companyPhone, $companyState, $companyCountry, $tinNO, $gstin, $panNO, $adminId){
            $sql="UPDATE `company` SET `company_name`='$companyName',`company_logo_url`='$companyLogoURL',`company_address`='$companyAddress',"
                    . "`company_phone`='$companyPhone',`company_state`='$companyState',`company_country`='$companyCountry',`gstin`='$gstin',"
                    . "`tin_no`='$tinNO',`pan_no`='$panNO',`added_by`='$adminId' WHERE `company_id`='$companyId'";
            return parent::executeQuery($sql);
    }
    
    public function getLogoUrl($refCompanyId){
        
        $sql= "SELECT company_logo_url FROM `company` WHERE `company_id`='$refCompanyId'";
        return parent::executeQuery($sql);
    }
    
    public function lastInsertId() {
        return parent::lastInsertedId();
    }
}
