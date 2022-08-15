<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ServiceModel extends Database {

    public function searchServiceByName($serviceName) {
        $sql = "SELECT * FROM `service` WHERE `service_name`='$serviceName' and status=1 LIMIT 1";
        return parent::executeQuery($sql);
    }

    public function addService($parentId, $serviceName, $punchline, $thumbnail_url, $addedby, $status) {
        $sql = "INSERT INTO "
                . "`service`"
                . "(`service_id`, `parent_id`, `service_name`, `punchline`, `thumbnail_url`, `added_by`, `timestamp`, `status`)"
                . " VALUES"
                . "(NULL, '$parentId', '$serviceName', '$punchline', '$thumbnail_url', $addedby, now(), $status);";
        return parent::executeQuery($sql);
    }

    public function updateServiceDescription($serviceId, $serviceDescription) {
        $sql = "INSERT INTO `service_description`(`service_id`, `service_description`,`timestamp`)
                VALUES('$serviceId', '$serviceDescription', now())
                ON DUPLICATE KEY UPDATE 
                service_description = '$serviceDescription',
                timestamp = now();";
        return parent::executeQuery($sql);
    }

    public function getServiceDescription($serviceId) {
        $sql = "SELECT `service_id`, IFNULL(`service_description`, '') as service_description , `timestamp` FROM `service_description` WHERE `service_id`='$serviceId' LIMIT 1";
        return parent::executeQuery($sql);
    }

    public function getAllServiceName() {
        $sql = "SELECT `service_id`, `service_name`, `punchline`, `thumbnail_url`, `status` FROM `service`";
        return parent::executeQuery($sql);
    }

    public function removeService($serviceId) {
        $sql = "DELETE FROM `service` WHERE `service_id`='$serviceId' or `parent_id`='$serviceId';";
        return parent::executeQuery($sql);
    }

    public function lastInsertId() {
        return parent::lastInsertedId();
    }

}
