<?php

class ProfileController {
    //working
    public function updateProfile($adminId, $adminName, $adminPhone, $adminEmail, $adminType, $admin_username, $current_password, $isWeb) {
        $error = '';

        if ((strlen($adminPhone) < 6) || (strlen($adminPhone) > 15)) {
            $error .= 'The Phone Number doesnot seems valid.';
        }

        if (!Helper::isValidEmail($adminEmail)) {
            $error .= 'The Email is not valid.';
        }

        if ($adminId == "") {
            $error .= 'Does not received the admin identity';
        }
        if ($admin_username === "") {
            $error .= 'Please Provide Username';
        }

        if (strlen($error) != 0) {
            Helper::sendData(0, $error, 1);
            exit;
        }

        $cur_password = Hash::make($current_password);

        $loginRegisterModel = new LoginRegisterModel();
        $loginRs = $loginRegisterModel->authenticateUserByAdminId($adminId, $cur_password);

        if (!$loginRs) {
            return Helper::getStandardData(0, $loginRs, 1);
        } else if (mysqli_num_rows($loginRs) == 0) {
            return Helper::getStandardData(0, "Incorrect Password", 1);
        }

        $profileModel = new ProfileModel();
        $resultSet = $profileModel->updateProfile($adminId, $adminName, $adminPhone, $adminEmail, $adminType, $admin_username);

        if ($resultSet == false) {
            return Helper::getStandardData(0, "Failed to update profile at this moment.", 1);
        } else {

            //fetch admin id and set session
            $profileRS = $profileModel->getAdminProfile($adminId);

            if ($isWeb == "1") {

                if ($profileRS && (mysqli_num_rows($profileRS) == 1 )) {
                    $row = mysqli_fetch_assoc($profileRS);
                    return Helper::getStandardData(1, "Profile Updated Successfully", 1);
                }

                return Helper::getStandardData(1, "Profile Updated Successfully", 1);
            } else {
                if ($profileRS && (mysqli_num_rows($profileRS) == 1 )) {
                    $row = mysqli_fetch_assoc($profileRS);
                    return Helper::getStandardData(1, "Profile Updated Successfully.", 1, $row);
                }

                return Helper::getStandardData(1, "Profile Updated Successfully.", 1);
            }
        }
    }
    
    //working
    public function getAdminProfile($adminId, $isWeb) {
        $error = '';
        if (strlen($adminId) == 0) {
            $error .= 'Invalid Admin ID';
            exit;
        }
        $profileModel = new ProfileModel();
        $resultSet = $profileModel->getAdminProfile($adminId);
        if (mysqli_num_rows($resultSet) == 0) {
            return Helper::getStandardData(1, 'Admin Data not found.', 1);
        } else {
            $row = mysqli_fetch_assoc($resultSet);
            if ($isWeb == "1") {
                return Helper::getStandardData(1, '', 1, $row);
            } else {
                return Helper::getStandardData(1, '', 1, $row);
            }
        }
    }
    
    //working
//    function to get Admin Rights
    public function getAdminRights($adminId) {
        if ($adminId == "") {
            return Helper::getStandardData(0, "Inavlid Request", 0);
        }
        $profileModel = new ProfileModel();

        $adminRightsIDAllotedSQL = $profileModel->getAdminRightsIDAlloted($adminId);
        $adminRightsIDAllotedRow = mysqli_fetch_assoc($adminRightsIDAllotedSQL);
        $adminIds = str_replace('#', ',', $adminRightsIDAllotedRow['user_right']);
        $getAdminRights = $profileModel->getAdminRights($adminIds);
        if ($getAdminRights) {
            $adminRights = array();
            while ($row = mysqli_fetch_assoc($getAdminRights)) {
                array_push($adminRights, $row);
            }
            return Helper::getStandardData(1, '', 1, $adminRights);
        } else {
            return Helper::getStandardData(0, "Profile Updation Fail..", 1);
        }
    }
    
    //working
    public function getAllAdminRights($isWeb) {
        $profileModel = new ProfileModel();

        $resultSet = $profileModel->getAllAdminRights();

        if (!$resultSet) {
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        } else if (mysqli_num_rows($resultSet) == 0) {
            return Helper::getStandardData(0, 'There is NO User Rights', 1);
        } else {
            $rightsArr = array();
            while (($row = mysqli_fetch_assoc($resultSet)) != null) {
                $rightsArr[] = $row;
            }

            return Helper::getStandardData(1, '', 1, $rightsArr);
        }
    }


    

    public function getAllCustomerDetail($isWeb) {

        $profileModel = new ProfileModel();
        $resultSet = $profileModel->getAllCustomerDetail();

        if (!$resultSet) {
            return Helper::getStandardData(0, "Failed to getCustomer Detail.", 1);
        } else if (mysqli_num_rows($resultSet) == 0) {
            return Helper::getStandardData(0, "There is No Customer Detail.", 1);
        } else {
            $customerArr = array();

            $companyModel = new CompanyModel();
            while (( $customerRow = mysqli_fetch_assoc($resultSet) ) != null) {


                if (isset($customerRow['company_id']) && $customerRow['company_id'] > 0) {
                    $companyRS = $companyModel->getCompanyDetail($customerRow['company_id']);
                    $customerRow['company_name'] = mysqli_fetch_assoc($companyRS)['company_name'];
                }

                if (isset($customerRow['company_reg_id']) && $customerRow['company_reg_id'] > 0) {
                    $companyRegRS = $companyModel->getCompanyRegByRegId($customerRow['company_reg_id']);
                    $customerRow['gstin'] = mysqli_fetch_assoc($companyRegRS)['gstin'];
                }

                $customerArr[] = $customerRow;
            }
            return Helper::getStandardData(1, '', 1, $customerArr);
        }
    }

    public function addCustomerProfile($isWeb, $adminId, $customerName, $customerEmail, $customerPhone, $companyName, $companyLogo = null, $companyAddress = null, $companyState = null, $companyCountry = null, $gstin = null, $tinNo = null, $panNo = null) {
        $error = "";
        if (strlen($customerName) == 0) {
            $error .= "Please Specify Customer Name";
        }

        if (strlen($error) != 0) {
            return Helper::getStandardData(0, $error, 1);
        }

        //company registration
        $companyModel = new CompanyModel();
        if ($gstin != null || $tinNo != null || $panNo != null) {
            //insert
            $regResultSet = $companyModel->addCompanyRegistrationDetail($gstin, $tinNo, $panNo, $adminId);

            if ($regResultSet)
                $companyRegId = $companyModel->lastInsertId();
        }


        //company profile
        $companyLogoUrl = Helper::uploadFile($companyLogo, Constant::$COMPANY_IMG_DIR);
        if (strlen($companyName) != 0) {
            //insert
            $companyResultSet = $companyModel->addCompanyDetail($companyName, $companyLogoUrl, $companyAddress, $companyState, $companyCountry, $companyRegId, $adminId);

            if ($companyResultSet) {
                $companyId = $companyModel->lastInsertId();
            }
        }


        //customer profile
        $profileModel = new ProfileModel();
        if ($companyId == null) {
            $isACompany = 0;
        } else {
            $isACompany = 1;
        }
        $profileResultSet = $profileModel->addCustomerDetail($customerName, $customerEmail, $customerPhone, $isACompany, $companyId, $companyRegId, $adminId);

        if (!$profileResultSet) {
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        } else {
            return Helper::getStandardData(1, "Customer Profile Added Successfully", 1, $profileModel->lastInsertId());
        }
    }

    public function getCustomerProfile($customerId) {
        $error = '';
        if (strlen('$customerId') == 0) {
            $error .= 'Invalid Customers ID';
        }


        if (strlen($error) != 0) {
            return Helper::getStandardData(0, $error, 1);
        }

        $profileModel = new ProfileModel();
        $customerProfileRS = $profileModel->getCustomerProfile($customerId);

        if (mysqli_num_rows($customerProfileRS) == 0) {
            Helper::getStandardData(0, 'Customer does not exist', 1);
        } else {
            $row = mysqli_fetch_assoc($customerProfileRS);
        }
        return Helper::getStandardData(1, '', 1, $row);
    }

    public function updateCustomerProfile($isWeb, $adminId, $data) {
        $error = "";

        $customerId = $_POST['customer_id'];

        if (!isset($data['admin_id']) || (strlen($data['admin_id']) == 0)) {
            $error .= "Please Specify Admin Id";
        }

        if (!isset($data['customer_id'])) {
            $error .= "Please Specify Customer Id";
        }

        if (!isset($data['customer_name']) || strlen($data['customer_name']) == 0) {
            $error .= "Please Specify Customer Name";
        }

        if (strlen($error) != 0) {
            return Helper::getStandardData(0, $error, 1);
        }

        $data['addedby'] = $data['admin_id'];
        unset($data['admin_id']);
        unset($data['sname']);
        unset($data['fname']);
        unset($data['customer_id']);
        unset($data['isweb']);
        unset($data['tval']);



        $profileModel = new ProfileModel();
        $profileResultSet = $profileModel->updateCustomerProfile($data, array("customer_id" => $customerId));

        if (!$profileResultSet) {
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        } else {
            return Helper::getStandardData(1, "Customer Profile Updated Successfully", 1, $profileModel->lastInsertId());
        }
    }

    public function getSupplierProfile($supplierId) {
        $error = '';

        if (strlen($supplierId) == 0) {
            $error .= 'Invalid supplierId.';
        }

        if (strlen($error) != 0) {
            Helper::getStandardData(0, $error, 1);
        }

        $profileModel = new ProfileModel();
        $supplierRS = $profileModel->getSupplierProfile($supplierId);

        if (mysqli_num_rows($supplierRS) == 0) {
            return Helper::getStandardData(0, 'No Result Found', 1);
        } else {
            $supplierDetail = mysqli_fetch_assoc($supplierRS);
            return Helper::getStandardData(1, '', 1, $supplierDetail);
        }
    }

    public function addSupplierProfile($data, $isWeb) {
        $error = '';

        if (!isset($data['admin_id']) || strlen($data['admin_id']) == 0) {
            $error .= 'Please Specify Admin Id ';
        }
        if (!isset($data['supplier_name']) || strlen($data['supplier_name']) == 0) {
            $error .= 'Please Specify Supplier Name';
        }

        if (strlen($error) != 0) {
            return Helper::getStandardData(0, $error, 1);
        }

        $supplierName = $data['supplier_name'];
        $supplierPhone = $data['supplier_phone'];
        $supplierEmail = $data['supplier_email'];
        $adminId = $data['admin_id'];

        $profileModel = new ProfileModel();

        //check if supplier already exist
        $supplierRs = $profileModel->searchSupplier($supplierName, $supplierPhone, $supplierEmail);

        if (mysqli_num_rows($supplierRs) > 0) {
            return Helper::getStandardData(0, "This Supplier Already Exist", 1);
        }

        $resultSet = $profileModel->addSupplier($supplierName, $supplierPhone, $supplierEmail, $adminId);

        if (!$resultSet) {
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        } else {
            return Helper::getStandardData(1, 'Supplier Profile Added Successfuly', 1, $profileModel->lastInsertId());
        }
    }

    public function getAllSupplierDetail($isWeb) {
        $profileModel = new ProfileModel();
        $resultSet = $profileModel->getAllSupplierDetail();

        if (!$resultSet) {
            return Helper::getStandardData(0, "Failed to get Supplier Detail.", 1);
        } else if (mysqli_num_rows($resultSet) == 0) {
            return Helper::getStandardData(0, "There is No Supplier Detail.", 1);
        } else {
            $supplierArr = array();

            $companyModel = new CompanyModel();
            while (( $supplierRow = mysqli_fetch_assoc($resultSet) ) != null) {
                if (isset($supplierRow['company_id']) && $supplierRow['company_id'] > 0) {
                    $companyRS = $companyModel->getCompanyDetail($supplierRow['company_id']);
                    $supplierRow['company_name'] = mysqli_fetch_assoc($companyRS)['company_name'];
                }

                if (isset($supplierRow['company_reg_id']) && $supplierRow['company_reg_id'] > 0) {
                    $companyRegRS = $companyModel->getCompanyRegByRegId($supplierRow['company_reg_id']);
                    $supplierRow['gstin'] = mysqli_fetch_assoc($companyRegRS)['gstin'];
                }

                $supplierArr[] = $supplierRow;
            }
            return Helper::getStandardData(1, '', 1, $supplierArr);
        }
    }

    public function updateSupplierProfile($adminId, $supplierId, $supplierName, $supplierPhone, $supplierEmail) {
        $error = '';
        if ($supplierId == "") {
            $error .= 'Does not received the supplier identity';
        }

        if (strlen($error) != 0) {
            Helper::sendData(0, $error, 1);
            exit;
        }
        $profileModel = new ProfileModel();
        $updateCustomerRS = $profileModel->updateSupplierProfile($adminId, $supplierId, $supplierName, $supplierPhone, $supplierEmail);
        if ($updateCustomerRS) {
            return Helper::getStandardData(0, 'Profile Update successfully.', 1);
        } else {
            return Helper::getStandardData(0, "Profile Updation Fail..", 1);
        }
    }
//    function to add Employee
    public function addEmployee($adminId, $isWeb, $empName, $empMobile, $empEmail, $empUsername, $empPassword, $empRight, $adminType) {

        $error = '';
        if ($adminId == "") {
            $error .= 'Does not received the admin identity';
        }
        if (strlen($empName) == 0) {
            $error .= 'Plz enter Your username';
        }
        if (strlen($empUsername) == 0) {
            $error .= 'Enter emp username';
        }
        if (strlen($empPassword) == 0) {
            $error .= 'Please Specify Emp Password';
        }

        if (strlen($error) != 0) {
            return Helper::getStandardData(0, $error, 1);
        }

        $empPassword = Hash::make($empPassword);

        $profileModel = new ProfileModel();
        $ResultSet = $profileModel->addEmployee($empName, $empMobile, $empEmail, $empUsername, $empPassword, $empRight, $adminType);
        if (!$ResultSet)
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        else
            return Helper::getStandardData(1, "", 1);
    }

//    function to update Employee Profile...
    public function updateEmpProfile($adminId, $isWeb, $empId, $empName, $empMobile, $empEmail, $empUsername, $adminRights) {
        $error = '';
        if ($adminId == "") {
            $error .= 'Does not received the admin identity';
        }
        if ($empId == "") {
            $error .= 'Does not received the Emp Id';
        }
        if (strlen($empName) == 0) {
            $error .= 'Plz enter Your username';
        }
        if (strlen($empUsername) == 0) {
            $error .= 'Enter emp username';
        }
        if (strlen($adminRights) == 0) {
            $error .= 'Please Select Atleast One Rights';
        }
        $profileModel = new ProfileModel();
        $ResultSet = $profileModel->updateEmpProfile($empId, $empName, $empMobile, $empEmail, $empUsername, $adminRights);
//        var_dump($ResultSet);
        if (!$ResultSet)
            return Helper::getStandardData(0, "fail", 1);
        else
            return Helper::getStandardData(1, "", 1);
    }

//    function to fetch Employee detail...
    public function getEmpProfile($adminId, $isWeb) {
        $error = '';
        if (strlen($adminId) == 0) {
            $error .= 'Invalid Admin ID';
        }

        if (strlen($error) != 0) {
            return Helper::getStandardData(0, $error, 1);
        }

        $profileModel = new ProfileModel();
        $adminRS = $profileModel->getAdminProfile($adminId);

        $adminType = mysqli_fetch_assoc($adminRS)['admin_type'];

        $resultSet = $profileModel->getEmpProfile($adminType);
        if (mysqli_num_rows($resultSet) == 0) {
            return Helper::getStandardData(1, 'No Data not found.', 1);
        } else {
            $adminArr = array();
            while (($row = mysqli_fetch_assoc($resultSet)) != null) {
                $adminArr[] = $row;
            }

            return Helper::getStandardData(1, '', 1, $adminArr);
        }
    }

    public function getAllEmpProfile($adminId, $isWeb, $adminType) {
        $error = '';
        if (strlen($adminId) == 0) {
            $error .= 'Invalid Admin ID';
        }

        if (strlen($adminType) == 0 || $adminType > 1) {
            $error .= 'Current Admin does not have the right to see other admin detail';
        }

        if (strlen($error) != 0) {
            return Helper::getStandardData(0, $error, 1);
        }


        $profileModel = new ProfileModel();
        $adminRS = $profileModel->getAdminProfile($adminId);

        $adminType = mysqli_fetch_assoc($adminRS)['admin_type'];

        $resultSet = $profileModel->getAllEmpProfile($adminId);
        if (mysqli_num_rows($resultSet) == 0) {
            return Helper::getStandardData(1, 'No Data not found.', 1);
        } else {
            $adminArr = array();
            while (($row = mysqli_fetch_assoc($resultSet)) != null) {
                $adminArr[] = $row;
            }
            if ($isWeb == "1")
                return Helper::getStandardData(1, '', 1, $adminArr);

            $rightsRS = $profileModel->getAllAdminRights();
            $rightsArr = array();
            while (($row = mysqli_fetch_assoc($rightsRS)) != null) {
                $rightsArr[] = $row;
            }

            return Helper::getStandardData(1, '', 1, array('admin_detail' => $adminArr, "rights_detail" => $rightsArr));
        }
    }

    public function removeEmpProfile($adminId, $empadminId, $isWeb) {
        $error = '';
        if (strlen($adminId) == 0) {
            $error .= 'Invalid Admin ID';
        }
        if (strlen($adminId) == 0) {
            $error .= 'Invalid Emp Id';
        }
        if (strlen($error) != 0) {
            return Helper::getStandardData(0, $error, 1);
        }

        $profileModel = new ProfileModel();
        $resultSet = $profileModel->removeEmpProfile($empadminId);
        if (!$resultSet) {
            return Helper::getStandardData(0, "fail", 1);
        } else {
            return Helper::getStandardData(1, "", 1);
        }
    }
    //working
    public function updateAdminPassword($adminId, $isWeb, $currPass, $newPass) {
        $error = '';
        if (strlen($adminId) == 0) {
            $error .= 'Invalid Admin Id';
        }
        if (strlen($currPass) == 0) {
            $error .= 'Please Specify Current Password correct';
        }
        if (strlen($newPass) == 0) {
            $error .= 'Please Spicify New Password';
        }
        if (strlen($error) != 0) {
            return Helper::getStandardData(0, $error, 1);
        }

        $current_password = Hash::make($currPass);
        $newPassword = Hash::make($newPass);

        $loginRegisterModel = new LoginRegisterModel();
        $loginRs = $loginRegisterModel->authenticateUserByAdminId($adminId, $current_password);

        if (!$loginRs) {
            return Helper::getStandardData(0, $loginRs, 1);
        } else if (mysqli_num_rows($loginRs) == 0) {
            return Helper::getStandardData(0, "Incorrect Old Password", 1);
        }


        $profileModel = new ProfileModel();
        $resultSet = $profileModel->updateAdminPassword($adminId, $current_password, $newPassword);

        if ($resultSet == false) {
            return Helper::getStandardData(0, "Failed to update password at this moment.", 1);
        } else {

            //fetch admin id and set session
            $profileRS = $profileModel->getAdminProfile($adminId);

            if ($isWeb == "1") {

                if ($profileRS && (mysqli_num_rows($profileRS) == 1 )) {
                    $row = mysqli_fetch_assoc($profileRS);
                    return Helper::getStandardData(1, "Password Updated Successfully", 1);
                }

                return Helper::getStandardData(1, "Password Updated Successfully", 1);
            } else {
                if ($profileRS && (mysqli_num_rows($profileRS) == 1 )) {
                    $row = mysqli_fetch_assoc($profileRS);
                    return Helper::getStandardData(1, "Password Updated Successfully.", 1, $row);
                }

                return Helper::getStandardData(1, "Password Updated Successfully.", 1);
            }
        }
    }

}
