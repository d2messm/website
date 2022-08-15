<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ServiceController {

    public function addService($parentId, $serviceName, $punchline, $thumbnail_url, $addedby, $isWeb, $status) {
        $error = '';
        if (strlen($parentId) == 0) {
            $error .= 'Please Specify Parent Category Name ';
        }

        if (strlen($serviceName) == 0) {
            $error .= 'Please Specify Category Name ';
        }

        if (strlen($addedby) == 0) {
            $error .= 'Please Specify Admin';
        }

        if (strlen($punchline) == 0) {
            $error .= 'Punch Line would look nice on Service ';
        }

        if (strlen($thumbnail_url) == 0) {
            $error .= 'Thumbnail is Required ';
        }

        if (strlen($error) != 0) {
            return Helper::getStandardData(0, $error, 1);
        }
        $serviceName = ucwords($serviceName);

        $serviceModel = new ServiceModel();

        $categoryRS = $serviceModel->searchServiceByName($serviceName);
        // var_dump($categoryRS);
        if (mysqli_num_rows($categoryRS) > 0) {
            return Helper::getStandardData(0, "Service Name Already Exist", 1);
        }

        $resultSet = $serviceModel->addService($parentId, $serviceName, $punchline, $thumbnail_url, $addedby, $status);

        if (!$resultSet)
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        else {
            return Helper::getStandardData(1, "Successfully Added", 1, $serviceModel->lastInsertId());
        }
    }

    public function updateServiceDescription($serviceId, $serviceDescription, $isWeb) {

        if (strlen($serviceId) == 0)
            return Helper::getStandardData(1, 'Please Specify Service Id', 1);

        $serviceModel = new ServiceModel();
        $resultSet = $serviceModel->updateServiceDescription($serviceId, $serviceDescription);

        if (!$resultSet) {
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        } else {
            return Helper::getStandardData(1, 'Service Description Successfully Updated', 1);
        }
    }

    public function getServiceDescription($serviceId, $isWeb) {

        if (strlen($serviceId) == 0)
            return Helper::getStandardData(1, 'Please Specify Service Id', 1);

        $serviceModel = new ServiceModel();
        $resultSet = $serviceModel->getServiceDescription($serviceId);

        if (!$resultSet) {
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        } else {

            $service = mysqli_fetch_assoc($resultSet);
            if ($service != null)
                $service['service_description'] = Helper::UnSanitize($service['service_description']);
            return Helper::getStandardData(1, '', 1, $service);
        }
    }

    public function getAllServiceName($isWeb) {

        $serviceModel = new ServiceModel();

        $resultSet = $serviceModel->getAllServiceName();

        if (!$resultSet) {
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        } else if (mysqli_num_rows($resultSet) == 0) {
            return Helper::getStandardData(0, 'There is No Service Yet', 1);
        } else {
            $serviceArr = array();

            while (($row = mysqli_fetch_assoc($resultSet)) != null) {
                $serviceArr[] = $row;
            }

            return Helper::getStandardData(1, '', 1, $serviceArr);
        }
    }

    public function removeService($serviceId) {
        $serviceModel = new ServiceModel();
        if ($serviceModel->removeService($serviceId))
            return Helper::getStandardData(1, "Sucessfully Removed Catgory", 1);
        else
            return Helper::getStandardData(0, "Failed to update product", 1);
    }

}
