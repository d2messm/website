<?php

class AssociateController {

    public function addAssociate($isWeb, $adminId, $userName, $password, $name, $mobile, $email, $isCompany, $address, $gender, $dob, $rights, $companyName, $companyLogoURL, $companyAddress, $companyPhone, $companyState, $companyCountry, $tinNO, $gstin, $panNO, $docIds, $docNames, $documentImageURL) {

//        $error = $this->validateAssociate( $adminId, $userName, $password, $name, $mobile, $email, $isCompany,
//                $address, $gender, $dob, $rights, $companyName, $companyLogoURL, $companyAddress, 
//                $companyPhone, $companyState, $companyCountry, $tinNO, $gstin, $panNO,$docIds,$docNames,$documentImageURL);
//        
//        if (strlen($error) != 0) {
//            return Helper::getStandardData(0, $error, 1);
//        }
        $userType = Constant::$ASSOCIATE_USERTYPE;
        $password = Hash::make($password);
        $associateModel = new AssociateModel();
        //inserting new userlogin
        $userLoginRS = $associateModel->addNewUserLogin($userName, $password, $userType, $rights);
        if (!$userLoginRS) {
            return Helper::getStandardData(0, "Failed Query Server. Enter Correct and Unique Username", 1);
        } else {
            $userId = $associateModel->lastInsertedId();
        }
        if ($isCompany != 0) {
            //inserting new company
            $companyRs = $associateModel->addCompany($companyName, $companyLogoURL, $companyAddress, $companyPhone, $companyState, $companyCountry, $tinNO, $gstin, $panNO, $adminId);
            if (!$companyRs) {
                return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
            } else {
                $companyId = $associateModel->lastInsertedId();
            }
        } else {
            $companyId = 0;
        }
        $associateRS = $associateModel->addAssociate($name, $mobile, $email, $isCompany, $companyId, $address, $gender, $dob, $adminId, $userId, $docIds, $docNames, $documentImageURL);
        if (!$associateRS) {
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        } else {
            return Helper::getStandardData(1, "Associate Partner has been successfully Added", 1);
        }
    }

    private function validateAssociate($isWeb, $adminId, $userName, $password, $name, $mobile, $email, $isCompany, $address, $gender, $dob, $rights, $companyName, $companyLogoURL, $companyAddress, $companyPhone, $companyState, $companyCountry, $tinNO, $gstin, $panNO, $docIds, $docNames, $documentImageURL) {
        $error = '';
        if (strlen($adminId) == 0) {
            $error.="Invalid Admin ";
            return false;
        }
        if (strlen($userName) == 0) {
            $error.="Invalid Username ";
            return false;
        }
        if (strlen($password) < 5) {
            $error.="Invalid password length ";
            return false;
        }
        if (strlen($name) == 0) {
            $error.="Invalid Associater Name ";
            return false;
        }
        if (strlen($mobile) == 0) {
            $error.="Invalid Mobile ";
            return false;
        }
        if (strlen($email) == 0) {
            $error.="Invalid Email ";
            return false;
        }

        if (strlen($address) == 0) {
            $error.="Invalid Address";
            return false;
        }
        if (strlen($gender) == 0) {
            $error.="Please Mention Gender of Associate Partner";
            return false;
        }
        if (strlen($status) == 0) {
            $error.="Please Mention Status of Current Associate Partner";
            return false;
        }
        if (strlen($rights) == 0) {
            $error.="Please Mention Right of Associate partner";
            return false;
        }
        if ($isCompany != 1) {
            return $error;
        } else {
            if (strlen($identificationNO) == 0) {
                $error.="Invalid Identification ";
                return false;
            }
            if (strlen($docName) == 0) {
                $error.="Invalid Document";
                return false;
            }
            if (strlen($companyName) == 0) {
                $error.="Please Mention Company Name";
                return false;
            }
            if (strlen($companyAddress) == 0) {
                $error.="Please Mention Company Address";
                return false;
            }
            return $error;
        }
    }

    function getAllRights($isWeb, $adminId) {
        $error = '';
        if (strlen($adminId) == 0) {
            $error.='Invalid Admin';
            return false;
        }
        if (strlen($error) != 0) {
            return Helper::getStandardData(0, $error, 1);
        }
        $loginRegisterModel = new LoginRegisterModel();
        $userRightsRs = $loginRegisterModel->getAllUserRights();
        if (!$userRightsRs) {
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        } else if (mysqli_num_rows($userRightsRs) == 0) {
            return Helper::getStandardData(0, "NO Right Found", 1);
        }
        $userRights = array();

        while (($row = mysqli_fetch_assoc($userRightsRs)) != null) {
            $userRights[] = $row;
        }
        return Helper::getStandardData(1, "successfully Rights Fetched", 1, $userRights);
    }

    function getAllAssociateProfile($isWeb, $adminId) {
        $error = '';
        if (strlen($adminId) == 0) {
            $error.='Invalid Admin';
            return false;
        }
        if (strlen($error) != 0) {
            return Helper::getStandardData(0, $error, 1);
        }
        $associateModel = new AssociateModel();
        $associateRS = $associateModel->getAllAssociateProfile($adminId);
        if (!$associateRS) {
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        } else if (mysqli_num_rows($associateRS) == 0) {
            return Helper::getStandardData(0, "NO Data Found", 1);
        }
        $associateProfile = array();

        while (($row = mysqli_fetch_assoc($associateRS)) != null) {
            $userRightsRs=$associateModel->getUserRights($row['ref_user_id']);
                if(!$userRightsRs){
                    return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
                }
                $userRightsRow= mysqli_fetch_assoc($userRightsRs);
                $row['username'] = $userRightsRow['user_name'];
                $row['user_right'] = $userRightsRow['user_right'];
                
            if ($row['is_company'] == 1) {
                $companyRs = $associateModel->getParticularCompanyProfile($row['ref_company_id']);
                if (!$companyRs) {
                    return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
                }
                $crow = mysqli_fetch_assoc($companyRs);
                $row['company_data'] = $crow;
                $associateProfile[] = $row;
            } else {
                
                $row['company_data'] = "NA";
                $associateProfile[] = $row;
            }
        }
        return Helper::getStandardData(1, "successfully Data Fetched", 1, $associateProfile);
    }

    public function updateParticularAssociate($isWeb, $associateId, $adminId, $userName, $name, $mobile, $email, $isCompany, $address, $gender, $dob, $rights, $companyName, $companyLogoURL, $companyAddress, $companyPhone, $companyState, $companyCountry, $tinNO, $gstin, $panNO, $docIds, $docNames, $documentImageURL) {

        //      $error = '';
//        $error = $this->validateAssociate( $adminId, $userName, $password, $name, $mobile, $email, $isCompany,
//                $address, $gender, $dob, $rights, $companyName, $companyLogoURL, $companyAddress, 
//                $companyPhone, $companyState, $companyCountry, $tinNO, $gstin, $panNO,$docIds,$docNames,$documentImageURL);
        $associateModel = new AssociateModel();
        $documentRS = $associateModel->getDocumentUrl($associateId);

        $documentRow = mysqli_fetch_assoc($documentRS);
        if ((strlen($docIds) && strlen($docNames) && strlen($documentImageURL)) == 0) {
            $documentRS = $associateModel->getDocumentUrl($associateId);
            $documentRow = mysqli_fetch_assoc($documentRS);
            $docIds = $documentRow['document_no'];
            $docNames = $documentRow['document_name'];
            $documentImageURL = $documentRow['document_url'];
        }
                    $refCompanyId = $documentRow['ref_company_id'];

        if (strlen($companyLogoURL) == 0) {
            if ($refCompanyId != 0) {
                $logoRs = $associateModel->getLogoUrl($refCompanyId);
                $logoRow = mysqli_fetch_assoc($logoRs);
                $companyLogoURL = $logoRow['company_logo_url'];
            }
        }
//        if (strlen($error) != 0) {
//            return Helper::getStandardData(0, $error, 1);
//        }

        $associateRS = $associateModel->updateAssociate($associateId, $name, $mobile, $email, $isCompany, $address, $gender, $dob, $adminId, $docIds, $docNames, $documentImageURL);
        if (!$associateRS) {
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        } else if ($isCompany != 0) {
            $companyRs = $associateModel->updateCompany($refCompanyId, $companyName, $companyLogoURL, $companyAddress, $companyPhone, $companyState, $companyCountry, $tinNO, $gstin, $panNO, $adminId);
            if (!$companyRs) {
                return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
            }
        }
        $userType = Constant::$ASSOCIATE_USERTYPE;
        $password = Hash::make($password);
        //inserting new userlogin
        $userLoginRS = $associateModel->updateUserLogin($associateId, $userName, $userType, $rights);
        if (!$userLoginRS) {
            return Helper::getStandardData(0, "Failed Query Server. Enter Correct and Unique Username", 1);
        }
        return Helper::getStandardData(1, "Profile Update Successfully", 1);
    }

}
