<?php
class Constant{
    public static $IS_LOGGER_ON=0;
    public static $IS_ERROR_ON=0;
    public static $LOGIN_PAGE="login.php";
    public static $INPUT_KEY="bsrnetwork@grnoida9876543210hari";//32 bit
    public static $BLOCKSIZE= 128;
    public static $SESSION_TIME_EXTEND= 1800;
    public static $TOKEN="";
    public static $EXCEL_ARRAY=array("xls", "xlsx", "csv", "ods");
    public static $PRODUCT_IMG_DIR = "../UI/assets/img/product/";
    public static $APPOINTMENT_IMG_DIR = "../UI/assets/img/appointment/";
    public static $SERVICE_IMG_DIR = "../UI/assets/img/service/";
    public static $COMPANY_IMG_DIR = "../UI/assets/img/company/";
    public static $MAX_FILE_SIZE = 500000;  // ~ 500 KB
    public static $MAX_LOGO_SIZE = 500000;  // ~ 500 KB
    public static $PRODUCT_IMG_URL_SEPERATOR = ' # ';   // space#space
    public static $MAX_NO_OF_IMAGE_TO_BE_UPDATED = '5';
    public static $ASSOCIATE_USERTYPE = 3;
    public static $EMPLOYEE_USERTYPE = 2;
    public static $DOCUMENT_IMG_DIR_EMPLOYEE = "../assets/documents/Employee/";
    public static $DOCUMENT_IMG_DIR_ASSOCIATE = "../UI/assets/documents/AssociatePartner/";
    public static $DOCUMENT_IMG_DIR_PACKAGE = "../UI/assets/documents/PackageImage/";
    public static $DOCUMENT_IMG_LOGO = "../UI/assets/documents/logo/";
    public static $HASH_SEPERATOR = '#';   // space#space
    public static $MAX_NO_OF_DOC_TO_BE_UPDATED = '5';
    public static $OFFER_IMG_DIR ="../assets/company/offers/";
    public static $EVENT_IMG_DIR ="../assets/company/events/";
}
?>