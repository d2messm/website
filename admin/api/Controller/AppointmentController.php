<?php

class AppointmentController
{

    public function getDaywiseSchedule($isWeb)
    {

        $aptModel = new AppointmentModel();
        $resultSet = $aptModel->getDaywiseSchedule();
        if (!$resultSet)
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        else if (mysqli_num_rows($resultSet) == 0)
            return Helper::getStandardData(0, 'There is No Entry', 1);
        else {

            $dayArr = array();
            while (($row = mysqli_fetch_assoc($resultSet)) != null) {
                $dayArr[] = $row;
            }
            return Helper::getStandardData(1, '', 1, $dayArr);
        }
    }

    public function getAllPointments()
    {
        $aptModel = new AppointmentModel();
        $resultSet = $aptModel->getAllAppointments();
        if (!$resultSet)
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        else if (mysqli_num_rows($resultSet) == 0)
            return Helper::getStandardData(1, 'There is No Entry', 1, array());
        else {

            $dayArr = array();
            while (($row = mysqli_fetch_assoc($resultSet)) != null) {
                $dayArr[] = $row;
            }
            return Helper::getStandardData(1, '', 1, $dayArr);
        }
    }

    public function confirmAppointment($appId, $aptemail, $aptdate)
    {
        $aptModel = new AppointmentModel();
        $resultSet = $aptModel->confirmAppointment($appId, $aptdate);
        include_once './Helper/mailer.php';

        if (sendMail($aptemail, 'Appointment Confirmation', ('Your Appointment with CNK has been cofirmed on ' . $aptdate . ''))) {
            $sentMail = 1;
        } else {
            $sentMail = 0;
        }
        if (!$resultSet)
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        else {
            if ($sentMail == 1)
                return Helper::getStandardData(1, 'Appointment Confimed. Mail Sent', 1);
            else
                return Helper::getStandardData(1, 'Appointment Confimed. Failed to send mail.', 1);
        }
    }

    public function contactUs($name, $mobile, $email, $message)
    {
        include_once './Helper/mailer.php';


        // Create the email for User and send them message
        $to_user = $email;
        $to_name_user = $name;
        $email_subject_user = "CNK4Pets Contact Support";    // for user
        $email_body_user = "Hey $name,

			<br><br>Thank you for showing interest in CNK4Pets. We have received your query and will get back to you very soon.
			
			
			<br><br>Team CNK4Pets
            <br><a href='www.cnk4pets.com'>cnk4pets.com</a>";

//send mail to Admin
        $email_subject_admin = "New Client Query";      // for admin
        $email_body_admin = "Hello Admin, A new user query is received via CNK4PEts Website, Respond them soon...
						<br><br>Name: $name
						<br>Email: $email
						<br>Phone: $mobile
						<br><br>Message: $message<br>";

        $to_admin = 'contact@cnk4pets.com';
        $to_name_admin = 'CNK4Pets Admin';

        if (sendMail($to_admin, $email_subject_admin, $email_body_admin)) {

            sendMail($to_user, $email_subject_user, $email_body_user);
            return Helper::getStandardData(1, 'We Have Received your query', 1);
        } else {
            return Helper::getStandardData(0, 'Failed to Connect Mail Server', 1);
        }
    }


    function addAppointment($customerName, $customerMobile, $customerEmail, $customerService,
                            $customerAppointmentDate, $customerQuery, $customerTimeSlot, $customerFile)
    {
        $error = '';

        if (strlen($customerName) == 0) {
            $error .= 'Invalid Customer Name';
        }
        if (strlen($customerMobile) == 0) {
            $error .= 'Invalid Customer Name';
        }
        if (strlen($customerEmail) == 0) {
            $error .= 'Invalid Email';
        }
        if (strlen($customerQuery) == 0) {
            $error .= 'Please Mention Query';
        }
        if (strlen($error) != 0) {
            return Helper::getStandardData(0, $error, 1);
        }

        $aptModal = new AppointmentModel();
        $aptRS = $aptModal->addAppointment($customerName, $customerMobile, $customerEmail, $customerService,
            $customerAppointmentDate, $customerQuery, $customerTimeSlot, $customerFile);
        if (!aptRS) {
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        } else {
//            $this->mailAppointment($customerName, $customerMobile, $customerEmail, $customerService, $customerQuery, $customerAppointmentDate,
//                $customerTimeSlot);
            return Helper::getStandardData(1, "Appointment Request Successfully Received", 1);

        }
    }

    private function mailAppointment($name, $mobile, $email, $service, $query, $date, $timeslot)
    {
        include_once '../Helper/mailer.php';


        // Create the email for User and send them message
        $to_user = $email;
        $to_name_user = $name;
        $email_subject_user = "CNK4Pets Contact Support";    // for user
        $email_body_user = "Hey $name,

			<br><br>Thank you for showing interest in CNK4Pets. We have received your Appointment Request and will confirm your Appointment as soon as Possible.
			
			
			<br><br>Team CNK4Pets
            <br><a href='www.cnk4pets.com'>cnk4pets.com</a>";

//send mail to Admin
        $email_subject_admin = "New Client Query";      // for admin
        $email_body_admin = "Hello Admin, A new user query is received via CNK4PEts Website, Respond them soon...
						<br><br>Name: $name
						<br>Email: $email
						<br>Phone: $mobile
						<br><br>Service: $service
						<br>Message: $query
						<br><br>Appointment Date: $date
						<br>Time: $timeslot<br>";
//
//        $to_admin = 'contact@cnk4pets.com';
//        $to_name_admin = 'CNK4Pets Admin';
        $to_admin = 'mynameisakashkumar@gmail.com';
        $to_name_admin = 'CNK4Pets Admin';

        if (sendMail($to_admin, $email_subject_admin, $email_body_admin)) {

            sendMail($to_user, $email_subject_user, $email_body_user);
            return Helper::getStandardData(1, 'We have Received Your Appoint Request. We will Respond you soon.', 1);
        } else {
            return Helper::getStandardData(0, 'Failed to Connect Mail Server', 1);
        }
    }


}
