<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PackageController
 *
 * @author The Shadow
 */
class PackageController {

    public function addPackage($isWeb, $adminId, $PkgName, $pkgType, $pkgCategory, $pkgActivities, $pkgDays, $pkgNights, $pkgMonth, $pkgImageURL, $placeName, $meal, $hotel, $pkgDesc, $image) {

        $error = '';
        if (strlen($PkgName) == 0){
            $error.="Invalid Package Name";
            return false;
        }
        if(strlen($error)!=0){
            return Helper::getStandardData(0, $error, 1);
        }
        $packageModel = new PackageModel();
        $packageRS = $packageModel->addPackage( $adminId, $PkgName, $pkgType, $pkgCategory, $pkgActivities, $pkgDays, $pkgNights, $pkgMonth, $pkgImageURL, $placeName, $meal, $hotel, $pkgDesc, $image);
        if (!$packageRS) {
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        } else {
            return Helper::getStandardData(1, "Package Add Successfully", 1);
        }
    }
    
    public function getAllPackage($isWeb){
        $packageModel = new PackageModel();
        $packageRs = $packageModel->getAllPackage();
        if(!$packageRs){
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        }else{
            $pkgArr =array();
            while(($packageRow = mysqli_fetch_all ($packageRs))!=null){
                $pkgArr[]=$packageRow;
            }
            
            return Helper::getStandardData (1, "", 1,$pkgArr);  
        }
         
    }
}







