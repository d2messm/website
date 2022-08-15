<?php

class AppointmentService {

    public function requestAppointment($data) {
        
    }

    public function getDaywiseSchedule($data) {
        $isWeb = Helper::Sanitize(Helper::getIndex($data, 'isweb'));

        $aptController = new AppointmentController();
        echo $aptController->getDaywiseSchedule($isWeb);
        exit;
    }

    public function getAllPointments($data) {
        $aptController = new AppointmentController();
        echo $aptController->getAllPointments();
        exit;
    }

    public function confirmAppointment($data) {
        $appointMentId = intval($data['appointment_id']);
        $aptemail = Helper::Sanitize($data['client_email']);
        $aptdate = Helper::Sanitize($data['client_date']);
        $aptController = new AppointmentController();
        echo $aptController->confirmAppointment($appointMentId, $aptemail, $aptdate);
        exit;
    }

    public function contactUs($data) {
        $name = $data['name'];
        $mobile = $data['mobile'];
        $email = $data['email'];
        $message = $data['message'];

        $aptController = new AppointmentController();
        echo $aptController->contactUs($name, $mobile, $email, $message);
        exit;
    }
    
    public function submitAppointment($data,$files=''){
        $customerName = Helper::Sanitize($data['customer_name']);
        $customerMobile = Helper::Sanitize($data['customer_phone']);
        $customerEmail = Helper::Sanitize($data['customer_email']);
        $customerService = Helper::Sanitize($data['customer_service']);
        $customerAppointmentDate = Helper::Sanitize($data['customer_appointment_date']);
        $customerQuery = Helper::Sanitize($data['customer_query']);
        $customerTimeSlot = Helper::Sanitize($data['customer_time_slot']);
        $customerFile = '';
        if ($files != '') {
                if (isset($files['customer_file'])) {
                        $customerFile .= Helper::uploadFile($files['customer_file'], Constant::$APPOINTMENT_IMG_DIR);
                }
            
        }
        $aptController = new AppointmentController();
        echo $aptController->addAppointment($customerName,$customerMobile,$customerEmail,$customerService,
                $customerAppointmentDate,$customerQuery,$customerTimeSlot,$customerFile);
        exit;
    }

}

?>