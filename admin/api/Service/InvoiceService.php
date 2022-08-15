<?php

class InvoiceService {

    public function generateInvoice2($data) {
        $isWeb = Helper::Sanitize($data['isweb']);

        $adminId = Helper::Sanitize($data['admin_id']);

        foreach ($data as $key => $value) {

            if ($key != 'items') {
                $data[$key] = Helper::Sanitize($value);
            } else {

                for ($i = 0; $i < sizeof($data['items']); $i++) {

                    $items = $data['items'][$i];
                    foreach ($items as $key => $value) {
                        $data['items'][$i][$key] = Helper::Sanitize($value);
                    }
                }
            }
        }
    }

    //billing related information
    public function generateInvoice($data) {
        $isWeb = Helper::Sanitize($data['isweb']);
        $adminId = Helper::Sanitize($data['admin_id']);

        foreach ($data as $key => $value) {
            if ($key != 'items') {
                $data[$key] = Helper::Sanitize((String) $value);
            } else {
                for ($i = 0; $i < sizeof($data['items']); $i++) {
                    foreach ($data['items'][$i] as $key1 => $value2) {
                        $data['items'][$i][$key1] = Helper::Sanitize($value2);
                    }
                }
            }
        }

        $items = $data['items'];
        $invoiceController = new InvoiceController();
        echo $invoiceController->generateInvoice($isWeb, $adminId, $data, $items );
        exit;
    }

    public function getAllInvoiceDetail($data) {
        $isWeb = Helper::Sanitize($data['isweb']);
        $adminId = Helper::Sanitize($data['admin_id']);
        
        $invoiceController = new InvoiceController();
        echo $invoiceController->getAllInvoiceDetail($isWeb, $adminId);
        exit;
    }
    public function getParticularInvoiceDetail($data) {
        $invoiceNO = Helper::Sanitize($data['invoice_no']);
        $isWeb = Helper::Sanitize($data['isweb']);
        $adminId = Helper::Sanitize($data['admin_id']);
        
        $invoiceController = new InvoiceController();
        echo $invoiceController->getParticularInvoiceDetail($isWeb,$invoiceNO, $adminId);
        exit;
    }
}

?>
