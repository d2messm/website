<?php
class Admin extends Database{
    //sample modify later
    public function productInfoModel() {
        $sql = "select * from product order by rand()";
        return parent::executeQuery($sql);
    }
}
