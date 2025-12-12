<?php

use Picqer\Barcode\BarcodeGeneratorPNG;

function get_current_datetime_for_db()
{
    return date('Y-m-d H:i:s');
}

// Below method will encode the values.
function deccan_encode($str)
{
    return strtr(base64_encode(addslashes(gzcompress(serialize($str),9))), '+/=', '-_~');
}

// Below method will decode the encoded values which was encoded by "itek_encode" method.
function raos_decode($encoded_str)
{
    return unserialize(gzuncompress(stripslashes(base64_decode(strtr($encoded_str, '-_~', '+/=')))));
}

function get_decoded_value($encoded_str)
{
    if ($encoded_str == -1 || empty($encoded_str))
    {
        return false;
    }
    $decoded_str = raos_decode($encoded_str);
    if (empty($decoded_str))
    {
        return false;
    }

    return $decoded_str;
}

function compare_dates_yyyymmdd($date_a, $date_b)
{
    $millis_a = strtotime($date_a);
    $millis_b = strtotime($date_b);
    $comparision = $millis_a - $millis_b;
    return $comparision;
}

function add_days($date, $days)
{
    $time = strtotime($date);
    $time = $time + (86400*$days);
    $new_date = date('Y-m-d',$time);
    return $new_date;
}

function convert_to_user_date($date)
{
    $time = strtotime($date);
    $new_date = date('d M Y',$time);
    return $new_date;
}

function convert_to_system_date($date)
{
    $time = strtotime($date);
    $new_date = date('Y-m-d',$time);
    return $new_date;
}

// barcode generation
if (!function_exists('generate_barcode')) {
    function generate_barcode($code, $type = BarcodeGeneratorPNG::TYPE_CODE_128, $outputPath = null, $width = 2, $height = 30)
    {
        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($code, $type, $width, $height);

        if ($outputPath) {
            // Ensure the directory exists
            $directory = dirname($outputPath);
            if (!is_dir($directory)) {
                mkdir($directory, 0777, true); // Create the directory with full permissions
            }

            // Save the barcode image
            file_put_contents($outputPath, $barcode);
        } else {
            // Output the barcode directly to the browser
            header('Content-Type: image/png');
            echo $barcode;
        }
    }
}

// Unit of Measure
function unit_of_measure()
{
    return array("PCS"=>"PCS","MTRS"=>"MTRS");
}

// Mto Job Type
function get_job_type()
{
    return array("1"=>"In Side","2"=>"Out Side");
}

// Mto Service Type
function get_service_type()
{
    return array("1"=>"General Service","2"=>"Minor Repair","3"=>"Major Repair");
}

// Lubricants
function lubricants()
{
    return array("1"=>"5W30","2"=>"15W40","3"=>"20W40","4"=>"80W90","5"=>"DOT4","6"=>"DOT3","7"=>"HP-140","8"=>"HP/S-90","9"=>"TQ Power Steering Oil","10"=>"Toyota Coolant(Red Coolant)","11"=>"M&M Coolant (Green Coolant)","12"=>"Hydraulic Oil");
}

function get_months_of_year()
{
    return array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");
}

function standard_classes()
{
    return array("100"=>"General","1"=>"Class 1","2"=>"Class 2","3"=>"Class 3","4"=>"Class 4","5"=>"Class 5","6"=>"Class 6","7"=>"Class 7","8"=>"Class 8","9"=>"Class 9","10"=>"Class 10");
}

function get_payment_options()
{
    return array(PAYMENT_OPTIONS_CASH =>ucfirst(PAYMENT_OPTIONS_CASH), PAYMENT_OPTIONS_CHEQUE=>ucfirst(PAYMENT_OPTIONS_CHEQUE), PAYMENT_OPTIONS_PARENT_DEPOSIT=>ucfirst(str_replace('_',' ',PAYMENT_OPTIONS_PARENT_DEPOSIT)), "swipe"=>PAYMENT_OPTIONS_SWIPE);
}

function get_rent_payment_options()
{
    return array(PAYMENT_OPTIONS_CASH =>ucfirst(PAYMENT_OPTIONS_CASH), PAYMENT_OPTIONS_BANK=>ucfirst(PAYMENT_OPTIONS_BANK));
}

function generate_receipt()
{
    return rand(1000,9999);
}

function genders()
{
   return array("1"=>"Unisex","2"=>"Boys","3"=>"Girls"); 
}

function uniform_type()
{
  return array("1"=>"Shirts","2"=>"Pants","3"=>"Girls Frocks","4"=>"Ties","5"=>"Belts"); 
}
function status()
{
  return array("Active"=>"Active","Inactive"=>"Inactive"); 
}

function get_otp_status_options()
{
    return array(OTP_APPROVED =>OTP_APPROVED, OTP_PENDING => OTP_PENDING, OTP_REJECTED =>OTP_REJECTED);
}

function getGUID(){
    if (function_exists('com_create_guid')){
        return str_replace(array('{','}'),array('',''),com_create_guid());
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12);
        return $uuid;
    }
}

function convertNumberToWord($num = false)
{
    $num = str_replace(array(',', ' '), '' , trim($num));
    if(! $num) {
        return false;
    }
    $num = (int) $num;
    $words = array();
    $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
        'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
    );
    $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
    $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
        'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
        'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
    );
    $num_length = strlen($num);
    $levels = (int) (($num_length + 2) / 3);
    $max_length = $levels * 3;
    $num = substr('00' . $num, -$max_length);
    $num_levels = str_split($num, 3);
    for ($i = 0; $i < count($num_levels); $i++) {
        $levels--;
        $hundreds = (int) ($num_levels[$i] / 100);
        $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
        $tens = (int) ($num_levels[$i] % 100);
        $singles = '';
        if ( $tens < 20 ) {
            $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
        } else {
            $tens = (int)($tens / 10);
            $tens = ' ' . $list2[$tens] . ' ';
            $singles = (int) ($num_levels[$i] % 10);
            $singles = ' ' . $list1[$singles] . ' ';
        }
        $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
    } //end for loop
    $commas = count($words);
    if ($commas > 1) {
        $commas = $commas - 1;
    }
    return implode(' ', $words);
}

function year_difference($date, $compare_date = NULL)
{
    if (empty($compare_date))
    {
        $compare_date = date('Y-m-d');
    }

    $diff = abs(strtotime($compare_date) - strtotime($date));

    $years = floor($diff / (365*60*60*24));

    return $years;
}

function get_attendance_type_list()
{
    return array(STAFF_ATTENDANCE_TYPE_PRESENT, STAFF_ATTENDANCE_TYPE_ABSENT, STAFF_ATTENDANCE_TYPE_LEAVE, STAFF_ATTENDANCE_TYPE_LATE, STAFF_ATTENDANCE_TYPE_HALF, STAFF_ATTENDANCE_TYPE_PERMISSION);
}

function get_expense_type_list()
{
    return array(FINANCE_EXPENSE_TYPE_ADVANCE, FINANCE_EXPENSE_TYPE_CASH, FINANCE_EXPENSE_TYPE_SALARY);
}