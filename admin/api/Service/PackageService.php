<?php

class PackageService {
    
    public function addPackage($data, $files=''){
        $isWeb=  Helper::Sanitize($data['isweb']);
        $adminId = Helper::Sanitize($data['admin_id']);
        $PkgName= Helper::Sanitize($data['pkg_name']);
        $pkgType = Helper::Sanitize($data['pkg_type']);
        $pkgCategory = Helper::Sanitize($data['pkg_category']);
        $pkgActivities = Helper::Sanitize($data['pkg_activities']);
        $pkgDays = Helper::Sanitize($data['pkg_days']);
        $pkgNights = Helper::Sanitize($data['pkg_nights']);
        $pkgMonth = Helper::Sanitize($data['pkg_month']);
        
        $pkgImageURL = '';
        if ($files != '') {
            for ($i = 1; $i <= Constant::$MAX_NO_OF_IMAGE_TO_BE_UPDATED; $i++) {

                if (isset($files['pkg_image_' . $i])) {
                    $valid = Helper::validateProductfile($files['pkg_image_' . $i]);
                    if ($valid == '') {
                        if (strlen($pkgImageURL) != 0) {
                            $pkgImageURL .= Constant::$HASH_SEPERATOR;
                        }
                        $pkgImageURL .= Helper::uploadFile($files['pkg_image_' . $i], Constant::$DOCUMENT_IMG_DIR_PACKAGE);
                    } else {
                        echo Helper::getStandardData(0, 'Package Image ' . $i . ' Failed To Upload ', 1);
                        exit;
                    }
                }
            }
        }
//        var_dump($pkgImageURL);
        $placeName = '';
        $image = '';
        $meal = '';
        $hotel = '';
        $pkgDesc ='';
        for ($i = 1; $i <= $pkgDays; $i++) {

                if (isset($files['image_day_' . $i])) {
                    $valid = Helper::validateProductfile($files['image_day_' . $i]);
                    if ($valid == '') {
                        $image .= Helper::uploadFile($files['image_day_' . $i], Constant::$DOCUMENT_IMG_DIR_PACKAGE);
                        $image .= Constant::$HASH_SEPERATOR;
                    } 
                }else{
                    $image .= "no_image_.jpg";
                    $image .= Constant::$HASH_SEPERATOR;
                }
                $placeName .= Helper::Sanitize($data['place_name_' . $i]);
                $meal .= Helper::Sanitize($data['meal_' . $i]);
                $hotel .= Helper::Sanitize($data['hotel_name_' . $i]);
                $pkgDesc .= Helper::Sanitize($data['desc_' . $i]);
                $placeName .= Constant::$HASH_SEPERATOR;
                $meal .= Constant::$HASH_SEPERATOR;
                $hotel .= Constant::$HASH_SEPERATOR;
                $pkgDesc .= Constant::$HASH_SEPERATOR;
                
            }
            $image = rtrim($image, "#");
            $placeName = rtrim($placeName, "#");
            $meal = rtrim($meal, "#");
            $hotel = rtrim($hotel, "#");
            $pkgDesc = rtrim($pkgDesc, "#");
            
            $packageController = new PackageController();
            echo $packageController->addPackage($isWeb,$adminId,$PkgName,$pkgType,$pkgCategory,$pkgActivities,$pkgDays,$pkgNights,$pkgMonth,
                    $pkgImageURL,$placeName,$meal,$hotel,$pkgDesc,$image);
            exit;
       
    }
    
    public function getAllPackage($data){
        $isWeb=  Helper::Sanitize($data['isweb']);
        
        $packageController = new PackageController();
        echo $packageController->getAllPackage($isWeb);
        exit;
    }

}
