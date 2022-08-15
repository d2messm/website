<?php

class InvoiceController {

    public function generateInvoice($isWeb, $adminId, $data, $items) {
        $error = '';
        //sleep(10);
        if (strlen($adminId) == 0) {
            $error .= 'Please Specify Admin Id';
        }

        if (strlen($data['invoice_date']) == 0) {
            $error .= 'Please Specify Invoice Date';
        }

        if (!isset($data['customer_id']) && !isset($data['customer_name'])) {
            $error .= 'Please Specify the Customer ';
        }

        if (strlen($data['total_amount_without_tax']) == 0) {
            $error .= 'Missing Taxable Amount(Amount on which tax will be added)';
        }

        if (strlen($data['total_tax']) == 0) {
            $error .= 'Specify Total Tax';
        }

        if (strlen($data['invoice_total']) == 0) {
            $error .= 'Please Mention Invoice Total';
        }

        if (strlen($data['paid_amount']) == 0) {
            $error .= 'Missing Paid Amount';
        }


        if (strlen($error) != 0) {
            return Helper::getStandardData(0, $error, 1);
        }

        $this->makeHashSeperated($data, $items);

        unset($data['isweb']);
        unset($data['tval']);
        unset($data['sname']);
        unset($data['fname']);
        $data['addedby'] = $data['admin_id'];
        unset($data['admin_id']);


        //->Customer
        //->Selling (stock)
        //->
        //put data in selling
        $sellPurchaseModel = new SellPurchaseModel();
        $sellingRS = $sellPurchaseModel->addPurchaseByQry($data['product_id'], $data['product_quantity'], $data['unit_of_measurement'], $data['unit_rate'], $data['discount'], $data['cost_without_tax'], $data['cgst'], $data['sgst'], $data['igst'], $data['cess'], $data['total_product_amount'], $data['addedby']);

        $sellingId;
        if (!$sellingRS) {
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        } else {
            $sellingId = $sellPurchaseModel->lastInsertId();
        }


        $customerId = isset($data['customer_id']) ? $data['customer_id'] : '';
        //insert customer data for new customer
        if (!isset($data['customer_id']) || $data['customer_id'] == '') {
            //new customer
            $profileModel = new ProfileModel();
            $this->getCustomerDetail($data);
            $profileRS = $profileModel->addCustomerDetail($data['customer_name'], $data['customer_email'], $data['customer_phone'], $data['customer_address'], $data['is_a_company'], $data['company_id'], $data['company_reg_id'], $data['addedby']);
            if (!$profileRS) {
                // make fail safe, customer insertion does not matter the most
            } else {
                $customerId = $profileModel->lastInsertId();
            }
        }

        // TODO we have run these three operations in transaction, so that we can roll back if anything goes wrong
        //update stock
        $stockModel = new StockModel();
        for ($i = 0; $i < sizeof($items); $i++) {

            $stockModel->reduceAvailableStock($items[$i]['product_id'], $items[$i]['product_quantity']);
        }

        //now insert data into invoice table
        $invoiceModel = new InvoiceModel();
        $invoiceRs = $invoiceModel->addInvoice($sellingId, $data['invoice_date'], $customerId, $data['total_amount_without_tax'], $data['total_tax'], $data['invoice_total'], $data['paid_amount'], $data['due_amount'], $data['due_date'], $data['addedby'], $data['other_charges'], $data['other_charges_desc']);

        if (!$invoiceRs) {
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        } else {

            //get admin company details to print on bill
            $profileModel = new ProfileModel();
            $adminProfileRS = $profileModel->getAdminProfile($adminId);
            $adminProfile = mysqli_fetch_assoc($adminProfileRS);

            $companyModel = new CompanyModel();
            $companyDetailRS = $companyModel->getCompanyDetail($adminProfile['company_id']);
            $companyDetail = mysqli_fetch_assoc($companyDetailRS);

            $companyRegRS = $companyModel->getCompanyRegByRegId($companyDetail['company_reg_id']);
            $companyReg = mysqli_fetch_assoc($companyRegRS);

            $data = array('customer_id' => $customerId, 'selling_id' => $sellingId, 'invoice_no' => $invoiceModel->lastInsertId(),
                'company_name' => $companyDetail['company_name'], 'company_state' => $companyDetail['company_state'],
                'company_gstin' => $companyReg['gstin'], 'company_pan' => $companyReg['pan_no']);
            return Helper::getStandardData(1, "Sales Invoice(Bill) is successfully generated.", 1, $data);
        }
    }

    private function makeHashSeperated(&$data, &$items) {

        for ($i = 0; $i < sizeof($items); $i++) {
            $productArr = $items[$i];

            foreach ($productArr as $key => $value) {
                if (isset($data[$key])) {
                    $data[$key] = $data[$key] . '#' . $productArr[$key];
                } else {
                    $data[$key] = $productArr[$key];
                }
            }
        }
    }

    private function unHash($hashSeperateData) {
        $arr = array();

        $arr = explode('#', $hashSeperateData);

        return $arr;
    }

    private function getCustomerDetail(&$data) {
        $data['customer_email'] = isset($data['customer_email']) ? ($data['customer_email']) : '';
        $data['customer_phone'] = isset($data['customer_phone']) ? ($data['customer_phone']) : '';
        $data['customer_address'] = isset($data['customer_address']) ? ($data['customer_address']) : '';
        $data['is_a_company'] = isset($data['is_a_company']) ? ($data['is_a_company']) : '';
        $data['company_id'] = isset($data['company_id']) ? ($data['company_id']) : '';
        $data['company_reg_id'] = isset($data['company_reg_id']) ? ($data['company_reg_id']) : '';
    }

    //this method is for invoice detail only
    public static function getSellingDetail($sellingId) {
        $error = '';

        if (strlen($sellingId) == 0) {
            $error .= 'Invalid Selling Identity.';
        }

        if (strlen($error) != 0) {
            Helper::getStandardData(0, $error, 1);
        }

        $invoiceModel = new InvoiceModel();
        $sellingRS = $invoiceModel->getSellingDetail($sellingId);

        if (mysqli_num_rows($sellingRS) == 0) {
            Helper::getStandardData(0, 'No Selling Record', 1);
        } else {
            $row = mysqli_fetch_assoc($sellingRS);
            return $row;
        }
    }

    public static function getCompanyDetail($companyId) {
        $error = '';

        if (strlen($companyId) == 0) {
            $error .= 'Invalid Company Detail.';
        }

        if (strlen($error) != 0) {
            Helper::getStandardData(0, $error, 1);
        }

        $invoiceModel = new InvoiceModel();
        $companyRS = $invoiceModel->getCompanyDetail($companyId);

        if (mysqli_num_rows($companyRS) == 0) {
            Helper::getStandardData(0, 'No Record Found', 1);
        } else {
            $row = mysqli_fetch_assoc($companyRS);
            return $row;
        }
    }

    public static function getCompanyRegDetail($companyRegId) {
        $error = '';

        if (strlen($companyRegId) == 0) {
            $error .= 'Invalid Company Detail.';
        }

        if (strlen($error) != 0) {
            Helper::getStandardData(0, $error, 1);
        }

        $invoiceModel = new InvoiceModel();
        $companyRegRS = $invoiceModel->getCompanyRegDetail($companyRegId);

        if (mysqli_num_rows($companyRegRS) == 0) {
            Helper::getStandardData(0, 'No Record Found', 1);
        } else {
            $row = mysqli_fetch_assoc($companyRegRS);
            return $row;
        }
    }

    public function getAllInvoiceDetail($isWeb, $adminId) {
        $error = '';

        if (strlen($adminId) == 0) {
            $error .= 'Admin ID Not Found';
        }

        if (strlen($error) != 0) {
            return Helper::getStandardData(0, $error, 1);
        }

        $invoiceModel = new InvoiceModel();
        $resultSet = $invoiceModel->getAllInvoiceDetail();

        if (!$resultSet) {
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        } else if (mysqli_num_rows($resultSet) == 0) {
            return Helper::getStandardData(0, 'There is No Invoice detail.', 1);
        } else {
            $invoiceArr = array();
            $profileModel = new ProfileModel();

            while (($row = mysqli_fetch_assoc($resultSet)) != null) {

                $profileRS = $profileModel->getCustomerProfile($row['customer_id']);
                $profileRow = mysqli_fetch_assoc($profileRS);

                $row['customer_name'] = $profileRow['customer_name'];
                $row['customer_phone'] = $profileRow['customer_phone'];
                $row['customer_email'] = $profileRow['customer_email'];

                $invoiceArr[] = $row;
            }

            return Helper::getStandardData(1, '', 1, $invoiceArr);
        }
    }

    public function getParticularInvoiceDetail($isWeb, $invoiceNO, $adminId) {
        $error = '';

        if (strlen($adminId) == 0) {
            $error .= 'Admin ID Not Found';
        }
        if (strlen($invoiceNO) == 0) {
            $error .= 'Invalid Invoice NO.';
        }
        if (strlen($error) != 0) {
            return Helper::getStandardData(0, $error, 1);
        }
        $invoiceModel = new InvoiceModel();

        $resultSet = $invoiceModel->getParticularInvoiceDetail($invoiceNO);
        if (!$resultSet) {
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        } else if (mysqli_num_rows($resultSet) == 0) {
            return Helper::getStandardData(0, 'There is No Invoice detail.', 1);
        } else {
            $invoiceArr = array();
            //to fetch customer information
            $profileModel = new ProfileModel();
            //to fetch selling information hash seperated
            $invoiceModel = new InvoiceModel();
            //to get Product basic detail.
            $productModel = new ProductModel();
            //to get company full detail 
            $companyModel = new CompanyModel();
            // to get company id of admin 
            $profileModel = new ProfileModel();

            $adminResultSet = $profileModel->getAdminProfile($adminId);
            $Adminrow = mysqli_fetch_assoc($adminResultSet);

            $Admin_companyRs = $companyModel->getCompanyDetail($Adminrow['company_id']);
            $Admin_companyRow = mysqli_fetch_assoc($Admin_companyRs);
            $Admin_companyRegRs = $companyModel->getCompanyRegByRegId($Admin_companyRow['company_reg_id']);
            $Admin_companyRegRow = mysqli_fetch_assoc($Admin_companyRegRs);
            $Admin_companyFullDetail = array("company_detail" => $Admin_companyRow, "company_registration_detail" => $Admin_companyRegRow);


            $invoiceRow = mysqli_fetch_assoc($resultSet);
            $profileRS = $profileModel->getCustomerProfile($invoiceRow['customer_id']);
            $profileRow = mysqli_fetch_assoc($profileRS);

            $invoiceRow['customer_name'] = $profileRow['customer_name'];
            $invoiceRow['customer_phone'] = $profileRow['customer_phone'];
            $invoiceRow['customer_email'] = $profileRow['customer_email'];
            $invoiceRow['customer_address'] = $profileRow['customer_address'];
            $invoiceRow['customer_company_id'] = $profileRow['company_id'];
            $invoiceRow['customer_company_reg_id'] = $profileRow['company_reg_id'];

            //getting customer company full detail.
            $c_companyRs = $companyModel->getCompanyDetail($invoiceRow['customer_company_id']);
            $c_companyRow = mysqli_fetch_assoc($c_companyRs);
            $c_companyRegRs = $companyModel->getCompanyRegByRegId($invoiceRow['customer_company_reg_id']);
            $c_companyRegRow = mysqli_fetch_assoc($c_companyRegRs);
            $c_companyFullDetail = array("company_detail" => $c_companyRow, "company_registration_detail" => $c_companyRegRow);


            //getting selling detail and store in array item
            $sellingRS = $invoiceModel->getSellingDetail($invoiceRow['selling_id']);
            $sellingRow = mysqli_fetch_assoc($sellingRS);

            $product_id = $this->unHash($sellingRow['product_id']);
            $product_quantity = $this->unHash($sellingRow['product_quantity']);
            $unitOfMeasurement = $this->unHash($sellingRow['unit_of_measurement']);
            $unit_rate = $this->unHash($sellingRow['unit_rate']);
            $dis = $this->unHash($sellingRow['discount']);
            $cost_without_tax = $this->unHash($sellingRow['cost_without_tax']);
            $arr_cgst = $this->unHash($sellingRow['cgst']);
            $arr_igst = $this->unHash($sellingRow['igst']);
            $arr_sgst = $this->unHash($sellingRow['sgst']);
            $arr_cess = $this->unHash($sellingRow['cess']);

            $total_product_amount = $this->unHash($sellingRow['total_product_amount']);

            $item = array();

            for ($i = 0; $i < sizeof($product_id); $i++) {

                $productId = $product_id[$i];
                $productQty = $product_quantity[$i];
                $unitOfMeasurement = $unitOfMeasurement[$i];
                $unitRate = $unit_rate[$i];
                $discount = $dis[$i];
                $costWithOutTax = $cost_without_tax[$i];
                $cgst = $arr_cgst[$i];
                $sgst = $arr_sgst[$i];
                $igst = $arr_igst[$i];
                $cess = $arr_cess[$i];
                $totalProductAmount = $total_product_amount[$i];

                $resultSet = $productModel->getSpecificProduct($productId);
                $product_Row = mysqli_fetch_assoc($resultSet);
                $productName = $product_Row['product_name'];
                $productHsn = $product_Row['hsn'];


                $item[] = array('product_id' => $productId, 'product_name' => $productName, 'product_quantity' => $productQty, 'unit_of_measurement' => $unitOfMeasurement,
                    'unit_rate' => $unitRate, 'discount' => $discount, 'cost_without_tax' => $costWithOutTax, 'cgst' => $cgst,
                    'sgst' => $sgst, 'igst' => $igst, 'cess' => $cess, 'hsn' => $productHsn, 'total_product_amount' => $totalProductAmount);
            }

            $invoiceRow['item'] = $item;
            $invoiceRow['c_companyFullDetail'] = $c_companyFullDetail;
            $invoiceRow['admin_companyFullDetail'] = $Admin_companyFullDetail;
            $invoiceArr[] = $invoiceRow;


            return Helper::getStandardData(1, '', 1, $invoiceArr);
        }
    }

}

?>