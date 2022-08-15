<?php

class AppointmentModel extends Database {
    
    public function getDaywiseSchedule() {
        $sql = "SELECT * FROM `appointment_schedule`";
        return parent::executeQuery($sql);
    }
    public function getAllAppointments(){
        $sql="SELECT * FROM `appointment` order by pref_date ASC";
        return parent::executeQuery($sql);
    }
    public function confirmAppointment($appId,$aptdate){
        $sql="UPDATE appointment SET  is_confirmed='1',pref_date='$aptdate' WHERE appointment_id='$appId';";
        return parent::executeQuery($sql);
    }
    public function addAppointment($customerName,$customerMobile,$customerEmail,$customerService,
                $customerAppointmentDate,$customerQuery,$customerTimeSlot,$customerFile){
        $sql="INSERT INTO `appointment` (`appointment_id`, `name`, `mobile`, `email`, `service_name`, "
                . "`details`, `file_url`, `pref_date`, `pref_time`, `is_confirmed`) VALUES "
                . "(NULL, '$customerName', '$customerMobile', '$customerEmail', '$customerService', "
                . "'$customerQuery',"
                . " '$customerFile', '$customerAppointmentDate', '$customerTimeSlot', '0');";
        return parent::executeQuery($sql);
    }
}
