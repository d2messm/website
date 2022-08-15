<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PackageModel
 *
 * @author The Shadow
 */
class PackageModel extends Database {
    public function addPackage( $adminId, $PkgName, $pkgType, $pkgCategory, $pkgActivities, $pkgDays, $pkgNights, $pkgMonth,
            $pkgImageURL, $placeName, $meal, $hotel, $pkgDesc, $image){
    $sql ="INSERT INTO `package`(pkg_name,pkg_type,pkg_category,pkg_activities,pkg_days,places_name,places_desc,"
            . "places_image,places_meal,places_hotel,addedby,pkg_images,pkg_month)values('$PkgName','$pkgType','$pkgCategory','$pkgActivities','$pkgDays',"
            . "'$placeName','$pkgDesc','$image','$meal','$hotel','$adminId','$pkgImageURL','$pkgMonth');";
    
    return parent::executeQuery($sql); 
    }
    public function getAllPackage(){
        $sql = "SELECT * FROM `package`";
        return parent::executeQuery($sql);
    }
}
