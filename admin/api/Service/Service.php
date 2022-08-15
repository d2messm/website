<?php

Class Service {

    public function addService($data, $files = '') {
        $isWeb = Helper::Sanitize($data['isweb']);
        $parentId = Helper::Sanitize($data['parent_id']);
        $serviceName = Helper::Sanitize($data['service_name']);
        $punchline = Helper::Sanitize(Helper::getIndex($data, 'punchline'));
        $addedby = Helper::Sanitize($data['admin_id']);
        $status = 1;

        $thumbnail_url = '';
        if ($files != '') {
            $thumbnail_url = Helper::uploadFile($files['thumbnail_image'], Constant::$SERVICE_IMG_DIR);
        }

        $serviceController = new ServiceController();
        echo $serviceController->addService($parentId, $serviceName, $punchline, $thumbnail_url, $addedby, $isWeb, $status);
        exit;
    }

    public function updateServiceDescription($data) {
        $isWeb = Helper::Sanitize(Helper::getIndex($data, 'isweb'));
        $serviceId = Helper::Sanitize(Helper::getIndex($data, 'service_id'));
        $serviceDescription = Helper::Sanitize(Helper::getIndex($data, 'service_description'));


        $serviceController = new ServiceController();
        echo $serviceController->updateServiceDescription($serviceId, $serviceDescription, $isWeb);
        exit;
    }

    public function getServiceDescription($data) {
        $isWeb = Helper::Sanitize(Helper::getIndex($data, 'isweb'));
        $serviceId = Helper::Sanitize(Helper::getIndex($data, 'service_id'));

        $serviceController = new ServiceController();
        echo $serviceController->getServiceDescription($serviceId, $isWeb);
        exit;
    }

    public function getAllServiceName($data) {
        $isWeb = Helper::Sanitize(Helper::getIndex($data, 'isweb'));

        $serviceController = new ServiceController();
        echo $serviceController->getAllServiceName($isWeb);
        exit;
    }

    public function removeService($data) {
        $serviceId = intval($data['service_id']);
        $serviceController = new ServiceController();
        echo $serviceController->removeService($serviceId);
        exit;
    }

}
