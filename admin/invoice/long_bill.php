<?php

require('fpdf181/fpdf.php');
class PDF extends FPDF {

    function __construct($orientation = 'p', $unit = 'mm', $size = 'A4') {
        parent::__construct($orientation, $unit, $size);
    }

    function fancyTable($products) {
        $this->SetFillColor(255, 255, 255);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');

        for ($i = 0; $i < sizeof($products); $i++) {
            $singleProduct = $products[$i];
            $this->Cell(5, 7, ($i + 1), "T", 0, 'L', true);
            $this->Cell($GLOBALS['itemWidth'] - 5, 7, $singleProduct->product_name, "T", 0, 'L', true);
            $this->Cell($GLOBALS['othersWidth'], 7, $singleProduct->product_quantity, "T", 0, 'C', true);

            if ($GLOBALS['is_rate'] == "true")
                $this->Cell($GLOBALS['othersWidth'], 7, round($singleProduct->unit_rate, $GLOBALS['decimalValue']), "T", 0, 'C', true);

            if ($GLOBALS['is_discount'] == "true")
                $this->Cell($GLOBALS['othersWidth'], 7, round( $singleProduct->discount, $GLOBALS['decimalValue']), "T", 0, 'C', true);

            if ($GLOBALS['is_tax_value'] == "true")
                $this->Cell($GLOBALS['othersWidth'], 7, round($singleProduct->cost_without_tax, $GLOBALS['decimalValue']), "T", 0, 'C', true);

            if ($GLOBALS['is_gst'] == "true") {

                if ($GLOBALS['instate'] == "1") {
                    $this->Cell($GLOBALS['othersWidth'], 7, round( $singleProduct->cgst, $GLOBALS['decimalValue']) . '%', "T", 0, 'C', true);
                    $this->Cell($GLOBALS['othersWidth'], 7, round( $singleProduct->sgst, $GLOBALS['decimalValue']) . '%', "T", 0, 'C', true);
                }
                if ($GLOBALS['outstate'] == "1")
                    $this->Cell($GLOBALS['othersWidth'], 7, round( $singleProduct->igst, $GLOBALS['decimalValue'] ) . '%', "T", 0, 'C', true);
            }

            if ($GLOBALS['is_cess'] == "true")
                $this->Cell($GLOBALS['othersWidth'], 7, round( $singleProduct->cess, $GLOBALS['decimalValue'] ) . '%', "T", 0, 'C', true);

            $this->Cell($GLOBALS['totalAmountWidth'], 7, round( $singleProduct->total_product_amount, $GLOBALS['decimalValue']), "T", 1, 'C', true);
        }
    }

}

// get details
$decimalValue = 2;  //upto two decimal point

$adminCompanyName = isset($_POST['company_name']) ? $_POST['company_name'] : "Bulwark Software Research pvt. ltd.";
$adminCompanyGSTIN = isset($_POST['company_gstin']) ? strtoupper($_POST['company_gstin']) : "22AAAAA0000A1Z5";
$adminCompanyState = isset($_POST['company_state']) ? $_POST['company_state'] : "UP";
$adminCompanyPan = isset($_POST['company_pan']) ? $_POST['company_pan'] : "7294V937JSK493";

$invoiceDate = $_POST['invoice_date'];
$invoiceNo = $_POST['invoice_no'];

$customerName = $_POST['customer_name'];
$customerAddress = $_POST['customer_address'];
$shippingAddArr = explode(", ", $customerAddress);
$shippingAdd1 = $shippingAddArr[0];
$shippingAdd2 = (sizeof($shippingAddArr) > 1) ? $shippingAddArr[1] : '';
$shippingAdd3 = '';
for ($i = 2; $i < sizeof($shippingAddArr); $i++) {
    $shippingAdd3 .= $shippingAddArr[$i];
}

$customerGSTIN = isset($_POST['customer_gstin']) ? strtoupper($_POST['customer_gstin']) : "";
$dueDate = $_POST['due_date'];

$products = json_decode($_POST['products']);
$totalAmount_without_tax = $_POST['total_amount_without_tax'];
$totalTax = $_POST['total_tax'];
$otherCharges = isset($_POST['other_charges']) ? $_POST['other_charges'] : 0 ;
$invoiceTotal = $_POST['invoice_total'];
$paidAmount =  isset($_POST['paid_amount']) ? $_POST['paid_amount'] : 0 ;
$dueAmount = $_POST['due_amount'];
$is_gst = $_POST['is_gst'];
$is_cess = $_POST['is_cess'];
$is_discount = $_POST['is_discount'];
$is_tax_value = $_POST['is_tax_value'];
$is_rate = $_POST['is_rate'];

$instate = $_POST['instate'];
$outstate = $_POST['outstate'];


$otherChargesDesc = isset($_POST['other_charges_desc']) ? $_POST['other_charges_desc'] : '';
$comment = isset($_POST['comment']) ? $_POST['comment'] : "*$*Thank You Visit Again *$*";

//end of getting details
//calculate headers
//header count other than SNo, and Item and Total
// SNo + Item = 30% of the width

$headerCount = 0;
//for quantity
$headerCount++;

if ($is_rate == "true")
    $headerCount++;
if ($is_discount == "true")
    $headerCount++;
if ($is_tax_value == "true")
    $headerCount++;
if ($is_gst == "true") {
    if ($instate == "1") {
        $headerCount += 2;  //cgst & sgst
    }
    if ($outstate == "1"){
        $headerCount += 1;  // igst    
    }
}

if ($is_cess == "true")
    $headerCount ++;



//width of A4 is 210x297 mm
$pageWidth = 190 ; 

$itemWidth = $pageWidth * 0.30;
$totalAmountWidth = $pageWidth * 0.12;
$remainingWidth = $pageWidth * 0.58;

$othersWidth = $remainingWidth / $headerCount;


// end calculating headers


$pdf = new PDF('p', 'mm', 'A4');

$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 14);
//row1
//$pdf->Cell(6, 7, '', 0, 0);   //for company logo
$pdf->Cell(136, 7, '' . $adminCompanyName, 0, 0, "");
$pdf->Cell(0, 7, '', 0, 1, "C");

//row 2
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(130, 6, 'GSTIN: ' . $adminCompanyGSTIN, 0, 0, "");
$pdf->Cell(0, 6, 'Invoice Date: ' . date("F j, Y", strtotime($invoiceDate)), 0, 1, "");

//row 3
$pdf->Cell(130, 6, 'STATE: ' . $adminCompanyState, 0, 0, "");
$pdf->Cell(0, 6, 'Invoice NO: ' . $invoiceNo, 0, 1, "");

//row 4
$pdf->Cell(130, 6, 'PAN NO: ' . $adminCompanyPan, 0, 0, "");
$pdf->Cell(0, 6, 'Ref No: ', 0, 1, " ");

$pdf->Cell(190, 6, '', 0, 1, "");

$pdf->Cell(190, 6, '----------------------------------------------------------Tax Invoice------------------------------------------------------------', 0, 1, "C");

$pdf->Cell(190, 6, '', 0, 1, "");

$pdf->SetFont('Arial', 'B', 12);
//row1
$pdf->Cell(120, 7, 'Customer Name', 0, 0, "");
$pdf->Cell(0, 7, 'Billing/Shipping Address', 0, 1, "C");

//row 2
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(130, 6, $customerName, 0, 0, "");
$pdf->Cell(0, 6, '' . $shippingAdd1, 0, 1, "");

//row 3
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(130, 6, 'Customer GSTIN', 0, 0, "");
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 6, '' . $shippingAdd2, 0, 1, "");

//row 4
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(130, 6, $customerGSTIN, 0, 0, "");
$pdf->Cell(0, 6, $shippingAdd3, 0, 1, " ");



$pdf->SetLineWidth(.5);

$pdf->Cell(190, 6, '', 'B', 1, "");

$pdf->Cell(190, 6, '', 0, 1, "");
$pdf->Cell(130, 6, '', 0, 0, "");
$pdf->Cell(0, 6, 'Due Date: ' . date("F j, Y", strtotime($dueDate)), 0, 1, "");

$pdf->Cell(190, 6, '', 'B', 1, "");

$pdf->SetFillColor(220, 230, 240);
$pdf->SetFont('Arial', '', '10');

$pdf->Cell($itemWidth, 14, '  Items', 'B', 0, "", 'L', FALSE);
$pdf->Cell($othersWidth, 14, 'Qty', 'B', 0, "C", 'L', false);
if ($is_rate == "true") {
//    $pdf->Cell(18, 14, 'Rate', 'B', 0, "C", 'L', false);
    $pdf->Cell($othersWidth, 14, 'Rate', 'B', 0, "C", 'L', false);
}

if ($is_discount == 'true') {
//    $pdf->Cell(15, 14, 'Discount', 'B', 0, "C", 'L', false);
    $pdf->Cell($othersWidth, 14, 'Discount', 'B', 0, "C", 'L', false);
}

if ($is_tax_value == "true") {
//    $pdf->Cell(20, 14, 'Tax-Value.', 'B', 0, "C", 'L', false);
    $pdf->Cell($othersWidth, 14, 'Taxable', 'B', 0, "C", 'L', false);
}

if ($is_gst == "true") {
    if ($instate == "1") {
//    $pdf->Cell(19.5, 14, 'CGST', 'B', 0, "C", 'L', false);
        $pdf->Cell($othersWidth, 14, 'CGST', 'B', 0, "C", 'L', false);
        $pdf->Cell($othersWidth, 14, 'SGST', 'B', 0, "C", 'L', false);
    }
    if ($outstate == "1")
        $pdf->Cell($othersWidth, 14, 'IGST', 'B', 0, "C", 'L', false);
}

if ($is_cess == "true")
    $pdf->Cell($othersWidth, 14, 'CESS', 'B', 0, "C", 'L', false);

$pdf->Cell($totalAmountWidth, 14, 'Total', 'B', 0, "C", 'L', false);

$pdf->Ln();

$pdf->fancyTable($products);

$pdf->SetFillColor(255, 255, 255);
$pdf->SetLineWidth(0.1);




$pdf->Cell(190, 7, '', 'T', 1, "", 'L', false);
$pdf->Cell(190, 7, '', '', 1, "", 'L', false);
//$pdf->Cell(190, 7, '', '', 1, "", 'L', false);
//$pdf->Cell(190, 7, '', '', 1, "", 'L', false);
//$pdf->Cell(190, 7, '', '', 1, "", 'L', false);
//$pdf->Cell(190, 7, '', '', 1, "", 'L', false);


$pdf->SetFillColor(220, 230, 240);
$pdf->SetFont('Arial', '', '12');
$pdf->Cell(55, 10, '', 'B', 0, "C", 'L', false);
$pdf->Cell(10, 10, '', 'B', 0, "C", 'L', false);
$pdf->Cell(13, 10, '', 'B', 0, "C", 'L', false);
$pdf->Cell(15, 10, '', 'B', 0, "C", 'L', false);
$pdf->Cell(33, 10, '', 'B', 0, "C", 'L', false);
$pdf->Cell(39, 10, 'Taxable Amount ', '', 0, "R", 'L', false);
$pdf->SetFont('Arial', '', '12');
$pdf->Cell(25, 10, number_format((float) $totalAmount_without_tax, $decimalValue), '', 1, "R", 'L', false);


$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Arial', '', '12');
$pdf->Cell(126, 7, '', '', 0, "", 'L', false);

$pdf->SetFillColor(220, 230, 240);
$pdf->SetFont('Arial', '', '12');
$pdf->Cell(39, 7, 'Total Tax', '', 0, "R", 'L', false);
$pdf->Cell(25, 7, number_format((float) $totalTax, $decimalValue), '', 1, "R", 'L', false);


if ($otherCharges != 0) {
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetFont('Arial', '', '12');
    $pdf->Cell(126, 7, '', '', 0, "", 'L', false);

    $pdf->SetFillColor(220, 230, 240);
    $pdf->SetFont('Arial', '', '12');
    $pdf->Cell(39, 7, 'Other Charges', '', 0, "R", 'L', false);
    $pdf->Cell(25, 7, number_format((float) $otherCharges, $decimalValue), '', 1, "R", 'L', false);
}

$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Arial', '', '10');
$pdf->Cell(126, 7, '', '', 0, "", 'L', false);

$pdf->SetFillColor(220, 230, 240);
$pdf->SetFont('Arial', 'B', '12');
$pdf->Cell(39, 7, 'Invoice Total', '', 0, "R", 'L', false);
$pdf->Cell(25, 7, number_format((float) $invoiceTotal, $decimalValue), '', 1, "R", 'L', false);

$pdf->SetFont('Arial', '', '12');
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(126, 7, '', '', 0, "", 'L', false);

$pdf->SetFillColor(220, 230, 240);
$pdf->SetFont('Arial', '', '12');
$pdf->Cell(39, 7, 'Paid Amount', '', 0, "R", 'L', false);
$pdf->Cell(25, 7, number_format((float) $paidAmount, $decimalValue), '', 1, "R", 'L', false);

$pdf->SetFillColor(255, 255, 255);

$pdf->Cell(126, 7, '', '', 0, "", 'L', false);
$pdf->SetFillColor(220, 230, 240);
$pdf->SetFont('Arial', 'B', '12');
$pdf->Cell(39, 7, 'Due Amount', '', 0, "R", 'L', false);
$pdf->Cell(25, 7, number_format((float) $dueAmount, $decimalValue), '', 1, "R", 'L', false);

$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Arial', '', '12');

$pdf->Cell(190, 10, 'Total Amount(In words): ' . getIndianCurrency(ceil((float) $invoiceTotal)), '', 1, "R", 'L', false);


$pdf->Cell(190, 23, '', '0', 1, "", 'L', false);

$pdf->Cell(120, 5, '', '0', 0, "R", 'L', false);
$pdf->Cell(70, 5, $adminCompanyName, 'T', 1, "C", 'L', false);
$pdf->Cell(120, 6, '', 'B', 0, "R", 'L', false);
$pdf->Cell(70, 6, '(Authorised Signatory)', 'B', 1, "C", 'L', false);


$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 6, $otherChargesDesc, '', 1, "L");

$pdf->Cell(0, 4, '', '', 1, "C");

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 6, "*$*Thank You Visit Again *$*", '', 1, "C");
$pdf->SetFont('Arial', '', 8);






$pdf->Output();

function getIndianCurrency($number) {
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
        } else
            $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? ucwords($Rupees) . 'Rupees ' : ''); // . $paise ;
}

?>
