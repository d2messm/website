<?php

class AssociateService {

    public function addAssociate($data, $files = '') {
        $isWeb = Helper::Sanitize(Helper::getIndex($data, 'isweb'));
        $adminId = Helper::Sanitize(Helper::getIndex($data, 'admin_id'));
        $userName = Helper::Sanitize(Helper::getIndex($data, 'user_name'));
        $password = Helper::Sanitize(Helper::getIndex($data, 'password'));
        $name = Helper::Sanitize(Helper::getIndex($data, 'name'));
        $mobile = Helper::Sanitize(Helper::getIndex($data, 'mobile'));
        $email = Helper::Sanitize(Helper::getIndex($data, 'email'));
        $isCompany = Helper::Sanitize(Helper::getIndex($data, 'is_company'));
        $address = Helper::Sanitize(Helper::getIndex($data, 'address'));
        $gender = Helper::Sanitize(Helper::getIndex($data, 'gender'));
        $dob = Helper::Sanitize(Helper::getIndex($data, 'dob'));
        $rights = Helper::Sanitize(Helper::getIndex($data, 'rights'));
        $companyName = Helper::Sanitize(Helper::getIndex($data, 'company_name'));
        $companyAddress = Helper::Sanitize(Helper::getIndex($data, 'company_address'));
        $companyPhone = Helper::Sanitize(Helper::getIndex($data, 'company_phone'));
        $companyState = Helper::Sanitize(Helper::getIndex($data, 'company_state'));
        $companyCountry = Helper::Sanitize(Helper::getIndex($data, 'company_country'));
        $tinNO = Helper::Sanitize(Helper::getIndex($data, 'tin_no'));
        $gstin = Helper::Sanitize(Helper::getIndex($data, 'gstin'));
        $panNO = Helper::Sanitize(Helper::getIndex($data, 'pan_no'));
        $docIds = '';
        $docNames = '';
        $documentImageURL = '';
        $companyLogoURL = '';
        if ($files != '') {
            $companyLogoURL = $this->uploadLogo($files);
            for ($i = 1; $i <= Constant::$MAX_NO_OF_IMAGE_TO_BE_UPDATED; $i++) {

                if (isset($files['document_' . $i])) {

                    $valid = Helper::validateProductfile($files['document_' . $i]);
                    if ($valid == '') {

                        if (strlen($documentImageURL) != 0) {
                            $docIds.=Constant::$HASH_SEPERATOR;
                            $docNames.=Constant::$HASH_SEPERATOR;
                            $documentImageURL .= Constant::$HASH_SEPERATOR;
                        }
                        $docIds .= Helper::Sanitize(Helper::getIndex($data, 'doc_no_' . $i));
                        $docNames .=Helper::Sanitize(Helper::getIndex($data, 'doc_name_' . $i));
                        $documentImageURL .= Helper::uploadFile($files['document_' . $i], Constant::$DOCUMENT_IMG_DIR_ASSOCIATE);
                    } else {
                        echo Helper::getStandardData(0, 'Product Image ' . $i . ' Failed To Upload ', 1);
                        exit;
                    }
                }
            }

            $docIds = rtrim($docIds, " # ");
            $docNames = rtrim($docNames, " # ");
            
        }


        $associateController = new AssociateController();
        echo $associateController->addAssociate($isWeb, $adminId, $userName, $password, $name, $mobile, $email, $isCompany, $address, $gender, $dob, $rights, $companyName, $companyLogoURL, $companyAddress, $companyPhone, $companyState, $companyCountry, $tinNO, $gstin, $panNO, $docIds, $docNames, $documentImageURL);
        exit;
    }

    private function uploadLogo($files) {
        $companyLogoURL=''; 
        if (isset($files['company_logo_url'])) {
            $valid = Helper::validateProductfile($files['company_logo_url']);
            if ($valid == '') {
                if (strlen($companyLogoURL) != 0) 
                    $companyLogoURL .= Constant::$HASH_SEPERATOR;
                    $companyLogoURL .= Helper::uploadFile($files['company_logo_url'], Constant::$DOCUMENT_IMG_LOGO);
                    return $companyLogoURL;

                } else {
                    echo Helper::getStandardData(0, ' Failed To Upload Company Logo', 1);
                    exit;
                }
            
        }
        
    }

    public function getAllRights($data) {
        $isWeb = Helper::Sanitize(Helper::getIndex($data, 'isweb'));
        $adminId = Helper::Sanitize(Helper::getIndex($data, 'admin_id'));
        $associateController = new AssociateController();
        echo $associateController->getAllRights($isWeb, $adminId);
        exit;
    }

    public function getAllAssociateProfile($data) {
        $isWeb = Helper::Sanitize(Helper::getIndex($data, 'isweb'));
        $adminId = Helper::Sanitize(Helper::getIndex($data, 'admin_id'));
        $associateController = new AssociateController();
        echo $associateController->getAllAssociateProfile($isWeb, $adminId);
        exit;
    }
    
    public function updateParticularAssociate($data, $files = '') {

        $isWeb = Helper::Sanitize(Helper::getIndex($data, 'isweb'));
        $assoicateId = Helper::Sanitize(Helper::getIndex($data, 'associate_id'));
        $adminId = Helper::Sanitize(Helper::getIndex($data, 'admin_id'));
        $userName = Helper::Sanitize(Helper::getIndex($data, 'user_name'));
      //  $password = Helper::Sanitize(Helper::getIndex($data, 'password'));
        $name = Helper::Sanitize(Helper::getIndex($data, 'name'));
        $mobile = Helper::Sanitize(Helper::getIndex($data, 'mobile'));
        $email = Helper::Sanitize(Helper::getIndex($data, 'email'));
        $isCompany = Helper::Sanitize(Helper::getIndex($data, 'is_company'));
        $address = Helper::Sanitize(Helper::getIndex($data, 'address'));
        $gender = Helper::Sanitize(Helper::getIndex($data, 'gender'));
        $dob = Helper::Sanitize(Helper::getIndex($data, 'dob'));
        $rights = Helper::Sanitize(Helper::getIndex($data, 'rights'));
        $companyName = Helper::Sanitize(Helper::getIndex($data, 'company_name'));
        $companyAddress = Helper::Sanitize(Helper::getIndex($data, 'company_address'));
        $companyPhone = Helper::Sanitize(Helper::getIndex($data, 'company_phone'));
        $companyState = Helper::Sanitize(Helper::getIndex($data, 'company_state'));
        $companyCountry = Helper::Sanitize(Helper::getIndex($data, 'company_country'));
        $tinNO = Helper::Sanitize(Helper::getIndex($data, 'tin_no'));
        $gstin = Helper::Sanitize(Helper::getIndex($data, 'gstin'));
        $panNO = Helper::Sanitize(Helper::getIndex($data, 'pan_no'));
        $docIds = '';
        $docNames = '';
        $documentImageURL = '';
        $companyLogoURL = '';
        if ($files != '') {
            $companyLogoURL = $this->uploadLogo($files);
            for ($i = 1; $i <= Constant::$MAX_NO_OF_DOC_TO_BE_UPDATED; $i++) {

                if (isset($files['document_' . $i])) {

                    $valid = Helper::validateProductfile($files['document_' . $i]);
                    if ($valid == '') {

                        if (strlen($documentImageURL) != 0) {
                            $docIds.=Constant::$HASH_SEPERATOR;
                            $docNames.=Constant::$HASH_SEPERATOR;
                            $documentImageURL .= Constant::$HASH_SEPERATOR;
                        }
                        $docIds .= Helper::Sanitize(Helper::getIndex($data, 'doc_no_' . $i));
                        $docNames .=Helper::Sanitize(Helper::getIndex($data, 'doc_name_' . $i));
                        $documentImageURL .= Helper::uploadFile($files['document_' . $i], Constant::$DOCUMENT_IMG_LOGO);
                    } else {
                        echo Helper::getStandardData(0, 'Product Image ' . $i . ' Failed To Upload ', 1);
                        exit;
                    }
                }
            }

            $docIds = rtrim($docIds, " # ");
            $docNames = rtrim($docNames, " # ");
            
        }


        $associateController = new AssociateController();
        echo $associateController->updateParticularAssociate($isWeb, $assoicateId,$adminId, $userName, $name, $mobile, $email, $isCompany, $address, $gender, $dob, $rights, $companyName, $companyLogoURL, $companyAddress, $companyPhone, $companyState, $companyCountry, $tinNO, $gstin, $panNO, $docIds, $docNames, $documentImageURL);
        exit;
    }


}
