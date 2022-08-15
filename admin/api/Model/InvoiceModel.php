<?php

class InvoiceModel extends Database {

    public function getAdminDetail($adminId) {
        $sql = "SELECT * FROM `admin` WHERE `admin_id`='$adminId'";
        return parent::executeQuery($sql);
    }

    public function addInvoice($sellingId, $invoiceDate, $customerId, $totalAmountWithoutTax, $totalTax, $invoiceTotal, $paidAmount, $dueAmount, $dueDate, $addedby, $othercharges, $otherChargesDescription) {
        $sql = "INSERT INTO `invoice`"
                . "(`invoice_no`, `selling_id`, `invoice_date`, `customer_id`, `total_amount_without_tax`,"
                . " `total_tax`, `invoice_total`, `paid_amount`, `due_amount`, `due_date`, `addedby`, `other_charges`,`other_charges_description`,`timestamp`)"
                . " VALUES "
                . "(NULL, '$sellingId', '$invoiceDate', '$customerId', '$totalAmountWithoutTax', '$totalTax',"
                . " '$invoiceTotal', '$paidAmount', '$dueAmount', '$dueDate', '$addedby','$othercharges','$otherChargesDescription', now())";
        return parent::executeQuery($sql);
    }

    public function generateInvoice($invoiceNo) {
        $sql = "SELECT * FROM `invoice` WHERE `invoice_no`='$invoiceNo';";
        return parent::executeQuery($sql);
    }

    public function getAllInvoiceDetail() {
        $sql = "SELECT * FROM `invoice` ORDER BY `timestamp` DESC;";
        return parent::executeQuery($sql);
    }

    public function getParticularInvoiceDetail($invoiceNO) {
        $sql = "SELECT * FROM `invoice` WHERE `invoice_no` = '$invoiceNO'  ORDER BY `timestamp` DESC;";
        return parent::executeQuery($sql);
    }

    public function getSellingDetail($sellingId) {
        $sql = "SELECT * FROM `selling` WHERE `selling_id`='$sellingId';";
        return parent::executeQuery($sql);
    }

    public function getCompanyDetail($companyId) {
        $sql = "SELECT * FROM `company_detail` WHERE `company_id`='$companyId';";
        return parent::executeQuery($sql);
    }

    public function getCustomerDetail($customerId) {
        $sql = "SELECT * FROM `customer` WHERE `customer_id`='$customerId';";
        return parent::executeQuery($sql);
    }

    public function getCompanyRegDetail($companyRegId) {
        $sql = "SELECT * FROM `company_reg_no` WHERE `company_reg_id`='$companyRegId'";
        return parent::executeQuery($sql);
    }

    public function lastInsertId() {
        return parent::lastInsertedId();
    }

}

?>
