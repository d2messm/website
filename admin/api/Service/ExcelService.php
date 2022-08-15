<?php
class ExcelService{
    public function uploadExcel($data,$files){
        $target_dir = "tempuploads/";
        $file=$files['file'];
        $target_file = $target_dir . basename($files["file"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $excelController=new ExcelController();
        echo $excelController->ValidateFile($target_file,$target_dir,$uploadOk,$imageFileType,$file);
    }
    public function uploadExcelRecords($dataPost){
        set_time_limit(300);
        $excelController=new ExcelController();
        echo $excelController->UploadExcelRecords($dataPost);
        exit;
    }
}