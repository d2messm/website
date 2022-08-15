<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProfileModal
 *
 * @author Akash Kumar
 */
class ProfileModel extends Database {

    public function updateProfile($adminId, $adminName, $adminPhone, $adminEmail, $adminType, $admin_username) {
        $updateSql = "UPDATE `admin` SET `admin_name`='$adminName',`admin_phone`='$adminPhone',`username`='$admin_username', `admin_email`='$adminEmail', `admin_type`='$adminType' WHERE `admin_id`='$adminId';";
        return parent::executeQuery($updateSql);
    }

    public function updateEmpProfile($empId, $empName, $empMobile, $empEmail, $empUsername, $adminRights) {
        $updateSql = "UPDATE `admin` SET `admin_name`='$empName', `admin_phone`='$empMobile', `admin_email`='$empEmail',`username`='$empUsername',`admin_rights`='$adminRights' WHERE `admin_id`='$empId';";
//        echo $updateSql;
        return parent::executeQuery($updateSql);
    }
    //working
    public function getAdminProfile($adminId) {
        $profile = "SELECT * FROM `admin` WHERE `admin_id`='$adminId' LIMIT 1;";
        return parent::executeQuery($profile);
    }

    public function updateAdminPassword($adminId, $current_password, $newPassword) {
        $sql = "UPDATE `admin` SET `password`='$newPassword' WHERE `password`='$current_password' AND `admin_id`='$adminId'";
        return parent::executeQuery($sql);
    }

    public function getAllEmpProfile($currentAdminId) {
        $profile = "SELECT * FROM `admin` WHERE `admin_id`!='$currentAdminId';";
        return parent::executeQuery($profile);
    }

    public function addCustomerDetail($customerName, $customerEmail, $customerPhone, $customerAddress, $isACompany, $companyId, $companyRegId, $adminId) {
        $sql = "INSERT INTO "
                . "`customer`"
                . "(`customer_id`, `customer_name`, `customer_email`, `customer_phone`, `customer_address`, `is_a_company`, `company_id`, `company_reg_id`, `addedby`, `timestamp`) "
                . "VALUES "
                . "(NULL, '$customerName', '$customerEmail', '$customerPhone', '$customerAddress', '$isACompany', '$companyId', '$companyRegId', '$adminId', now());";
        return parent::executeQuery($sql);
    }

    public function getAllCustomerDetail() {
        $sql = "SELECT * FROM `customer`";
        return parent::executeQuery($sql);
    }

    public function getCustomerProfile($customerId) {
        $sql = "SELECT * FROM `customer` WHERE `customer_id` = $customerId";
        return parent::executeQuery($sql);
    }

    public function getSupplierProfile($supplierId) {
        $sql = "SELECT * FROM supplier WHERE `supplier_id` = '$supplierId' LIMIT 1";
        return parent::executeQuery($sql);
    }

    public function searchSupplier($supplierName, $supplierPhone, $supplierEmail) {
        $sql = "SELECT * FROM supplier WHERE `supplier_name` = '$supplierName' AND `supplier_phone`='$supplierPhone' AND `supplier_email`='$supplierEmail' LIMIT 1";
        return parent::executeQuery($sql);
    }

    public function addSupplier($supplierName, $supplierPhone, $supplierEmail, $adminId) {
        $sql = "INSERT INTO `supplier` "
                . "(`supplier_id`, `supplier_name`, `supplier_phone`, `supplier_email`, `company_id`, `company_reg_id`, `addedby`, `timestamp`)"
                . " VALUES "
                . "(NULL, '$supplierName', '$supplierPhone', '$supplierEmail', '0', '0', '$adminId', now());";
        return parent::executeQuery($sql);
    }

    public function updateCustomerProfile($data, $whereCondition) {
        return parent::updateQuery($data, "customer", $whereCondition);
    }

    public function updateSupplierProfile($adminId, $supplierId, $supplierName, $supplierPhone, $supplierEmail) {
        $sql = "UPDATE `supplier` SET `supplier_name`='$supplierName',`supplier_email`='$supplierEmail',`supplier_phone`='$supplierPhone',`addedby`='$adminId' WHERE `supplier_id`='$supplierId'";
        return parent::executeQuery($sql);
    }

    public function getAdminRights($adminId) {
        $sql = "SELECT `page_name`, `icon`, `Display_name`,`extra_icon` FROM `user_rights` WHERE `id` IN ($adminId);";
        return parent::executeQuery($sql);
    }

    public function getAllAdminRights() {
        $sql = "SELECT * FROM `user_rights`;";
        return parent::executeQuery($sql);
    }

    public function getAdminRightsIDAlloted($adminId) {
        $sql = "SELECT user_right from `user_login` where user_id='$adminId';";
        return parent::executeQuery($sql);
    }

    public function getEmpProfile($adminType) {
        $sql = "SELECT * FROM `admin` WHERE `admin_type`>'$adminType'";
        return parent::executeQuery($sql);
    }

    public function removeEmpProfile($empadminId) {
        $sql = "DELETE FROM `admin` WHERE `admin_id`='$empadminId'";
        return parent::executeQuery($sql);
    }

    public function getAllSupplierDetail() {
        $sql = "SELECT * FROM `supplier`";
        return parent::executeQuery($sql);
    }

    public function lastInsertId() {
        return parent::lastInsertedId();
    }

    public function addEmployee($empName, $empMobile, $empEmail, $empUsername, $empPassword, $empRight, $adminType) {
        $sql = "INSERT INTO `admin` (`admin_name`,`admin_phone`,`admin_email`,`admin_rights`,`username`,`password`,`admin_type`)"
                . "VALUES"
                . "('$empName','$empMobile','$empEmail','$empRight','$empUsername','$empPassword', '$adminType');";
        return parent::executeQuery($sql);
    }

}
