<?php
use CodeIgniter\I18n\Time;
use App\Models\StoppageFareMasterModel;
use App\Models\StoppageMasterModel;
use App\Models\ConfigurationModel;
use App\Models\TblcMasterModel;
use App\Models\ClassModel;
use App\Models\AdminUserModel;
use App\Models\SessionYearModel;
use App\Models\SectionModel;
use App\Models\DeptModel;
use App\Models\StudentModel;
use App\Models\StudentDetailsModel;
use App\Models\ItemMasterModel;
use App\Models\StudentPersonalDetailsModel;

if (!function_exists('stoppage_fee_by_id')) {
    function stoppage_fee_by_id($id)
    {
        $stoppageFareMasterModel = new StoppageFareMasterModel();
        $stoppageData = $stoppageFareMasterModel->stoppage_fee_by_id($id);

        if (!empty($stoppageData)) {
            return $stoppageData->stoppage_fare;
        } else {
            return 0;
        }
    }
}

if (!function_exists('item_name_by_id')) {
    function item_name_by_id($id)
    {
        $itemMasterModel = new ItemMasterModel();
        $itemDetails = $itemMasterModel->find($id);

        if (!empty($itemDetails)) {
            return $itemDetails['item_name'] ?? '';
        } else {
            return '';
        }
    }
}

if (!function_exists('stoppage_name_by_id')) {
    function stoppage_name_by_id($id)
    {
        $stoppageMasterModel = new StoppageMasterModel();
        $stoppageDetails = $stoppageMasterModel->find($id);

        if (!empty($stoppageDetails)) {
            return $stoppageDetails['stoppage_name'];
        } else {
            return '';
        }
    }
}

if ( ! function_exists('pr'))
{
    function pr($arr,$e=1)
    {
        echo "<pre>";
        print_r($arr);
        echo die();
    }
}

function convert_number_to_words($number) {
    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' and paise ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        100000             => 'Lakh',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );
   
    if (!is_numeric($number)) {
        return false;
    }
   
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }
   
    $string = $fraction = null;
   
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
    
    //echo $number;die();
   
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
            
        case $number < 100000:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(100000, floor(log($number, 100000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100000 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }
   
    if (null !== $fraction && is_numeric($fraction) && $fraction != '00') {
        $string .= $decimal;
        // $words = array();
        // foreach (str_split((string) $fraction) as $number) {
            // $words[] = $dictionary[$number];
        // }
        // $string .= implode(' ', $words);
        $string .= convert_number_to_words(intval($fraction));
    }
   
    return $string;
}

if (!function_exists('age_round')) {
    function age_round($dob, $currentDate = null)
    {
        $birth = Time::parse($dob);
        $current = $currentDate ? Time::parse($currentDate) : Time::now();

        $years  = $current->getYear() - $birth->getYear();
        $months = $current->getMonth() - $birth->getMonth();
        $days   = $current->getDay() - $birth->getDay();

        // Adjust for incomplete month
        if ($days < 0) {
            $months--;
        }

        if ($months < 0) {
            $years--;
            $months += 12;
        }

        // Return only completed full years
        return $years;
    }

}

if (!function_exists('age_full_details')) {
    function age_full_details($dob, $currentDate = null)
    {
        $birth = Time::parse($dob);
        $current = $currentDate ? Time::parse($currentDate) : Time::now();

        $years  = $current->getYear() - $birth->getYear();
        $months = $current->getMonth() - $birth->getMonth();
        $days   = $current->getDay() - $birth->getDay();

        // Adjust day and month differences
        if ($days < 0) {
            $months--;
            $prevMonthDays = (int) (new DateTime($current->format('Y-m-01')))
                            ->modify('-1 day')
                            ->format('d');
            $days += $prevMonthDays;
        }

        if ($months < 0) {
            $years--;
            $months += 12;
        }

        return [
            'years'  => $years,
            'months' => $months,
            'days'   => $days,
            'text'   => "{$years} years {$months} months {$days} days"
        ];
    }
}

if (!function_exists('get_config_value_by_key')) {
    function get_config_value_by_key($key) {
        $configurationModel = new ConfigurationModel();
        $config_data = $configurationModel->get_configuration_by_key($key);
        
        return $config_data ?? 0;
        
        // if(!empty($config_data)){
        //     return $config_data['configuration_value'];
        // }else{
        //     return 0;
        // }
    }
}

if (!function_exists('get_tblc_item_name_by_id')) {
    function get_tblc_item_name_by_id($id) {
        // Check if ID is valid
        if (empty($id) || !is_numeric($id)) {
            return ''; // return empty if ID not provided or invalid
        }
        
        $tblcMasterModel = new TblcMasterModel();
        $tblcData = $tblcMasterModel->where('id', $id)->first();
        
        if(!empty($tblcData)){
            return $tblcData['item_name'];
        }else{
            return '';
        }
    }
}

if (!function_exists('get_class_name_by_id')) {
    function get_class_name_by_id($id) {
        // Check if ID is valid
        if (empty($id) || !is_numeric($id)) {
            return ''; // return empty if ID not provided or invalid
        }
        
        $classModel = new ClassModel();
        $classData = $classModel->where('id', $id)->first();
        
        if(!empty($classData)){
            return $classData['class_name'];
        }else{
            return '';
        }
    }
}

if (!function_exists('get_user_full_name_by_id')) {
    function get_user_full_name_by_id($id) {
        // Check if ID is valid
        if (empty($id) || !is_numeric($id)) {
            return ''; // return empty if ID not provided or invalid
        }
        
        $adminUserModel = new AdminUserModel();
        $adminUserData = $adminUserModel->where('id', $id)->first();
        
        if(!empty($adminUserData)){
            $getFullName = $adminUserData['first_name'].' '.$adminUserData['last_name'];
            
            return $getFullName;
        }else{
            return '';
        }
    }
}

if (!function_exists('session_name_by_id')) {
    function session_name_by_id($session_id) {
        $sessionYearModel = new SessionYearModel();
        $session_data = $sessionYearModel->getSessionYearName($session_id);
        
        if(!empty($session_data)){
            return $session_data['session_name'] ?? '';
        }else{
            return '';
        }
    }
}

if (!function_exists('section_name_by_id')) {
    function section_name_by_id($section_id) {
        $sectionModel = new SectionModel();
        $section = $sectionModel
            ->select('section_name')
            ->where('id', $section_id)
            ->first();

        $sectionName = $section['section_name'] ?? '';

        if( $sectionName != '' ){
            return $sectionName;
        }else{
            return '';
        }
    }
}

if (!function_exists('dept_name_by_id')) {
    function dept_name_by_id($dept_id) {
        $deptModel = new DeptModel();
        $dept = $deptModel
            ->select('name')
            ->where('id', $dept_id)
            ->first();

        $deptName = $dept['name'] ?? '';

        if( $deptName != '' ){
            return $deptName;
        }else{
            return '';
        }
    }
}

if (!function_exists('student_id_by_code')) {
    function student_id_by_code($student_code) {
        $studentModel = new StudentModel();
        $student = $studentModel
            ->select('id')
            ->where('code', $student_code)
            ->where('session_year_id', session()->get('session_year_id'))
            ->first();

        $studentId = $student['id'] ?? '';

        if( $studentId != '' ){
            return $studentId;
        }else{
            return '';
        }
    }
}

if (!function_exists('student_name_by_code')) {
    function student_name_by_code($student_code) {
        $studentDetailsModel = new StudentDetailsModel();
        $student = $studentDetailsModel
            ->select('first_name')
            ->where('code', $student_code)
            ->where('session_year_id', session()->get('session_year_id'))
            ->first();

        $studentName = $student['first_name'] ?? '';

        if( $studentName != '' ){
            return $studentName;
        }else{
            return '';
        }
    }
}

if (!function_exists('student_academic_status_by_id')) {
    function student_academic_status_by_id($student_id) {
        $studentDetailsModel = new StudentDetailsModel();
        $student = $studentDetailsModel
            ->select('academic_status')
            ->where('student_id', $student_id)
            ->where('session_year_id', session()->get('session_year_id'))
            ->first();

        $student_academic_status = $student['academic_status'] ?? '';

        if( $student_academic_status != '' ){
            return $student_academic_status;
        }else{
            return '';
        }
    }
}

if (!function_exists('student_section_by_student_code')) {
    function student_section_by_student_code($student_code) {
        $studentDetailsModel = new StudentDetailsModel();
        $student = $studentDetailsModel
            ->select('section_id')
            ->where('code', $student_code)
            ->where('session_year_id', session()->get('session_year_id'))
            ->first();

        $section_id = $student['section_id'] ?? '';

        if( $section_id != '' ){
            return $section_id;
        }else{
            return '';
        }
    }
}

if (!function_exists('student_code_by_id')) {
    function student_code_by_id($student_id) {
        $studentModel = new StudentModel();
        $student = $studentModel
            ->select('code')
            ->where('id', $student_id)
            ->first();

        $studentCode = $student['code'] ?? '';

        if( $studentCode != '' ){
            return $studentCode;
        }else{
            return '';
        }
    }
}

if (!function_exists('student_form_no_by_student_id')) {
    function student_form_no_by_student_id($student_id) {
        $studentDetailsModel = new StudentDetailsModel();
        $student = $studentDetailsModel
            ->select('form_no')
            ->where('student_id', $student_id)
            ->first();

        $studentFormNo = $student['form_no'] ?? '';

        if( $studentFormNo != '' ){
            return $studentFormNo;
        }else{
            return '';
        }
    }
}

if (!function_exists('student_student_id_by_form_no')) {
    function student_student_id_by_form_no($form_no) {
        $studentDetailsModel = new StudentDetailsModel();
        $student = $studentDetailsModel
            ->select('student_id')
            ->where('form_no', $form_no)
            ->first();

        $studentId = $student['student_id'] ?? '';

        if( $studentId != '' ){
            return $studentId;
        }else{
            return '';
        }
    }
}

if (!function_exists('session_stoppage_fee_by_id')) {
    function session_stoppage_fee_by_id($id, $session_year_id) {
        $stoppageFareMasterModel = new StoppageFareMasterModel();
        $stoppage_data = $stoppageFareMasterModel->session_stoppage_fee_by_id($id,$session_year_id);
        if(!empty($stoppage_data)){
            return $stoppage_data['stoppage_fare'] ?? 0;
        }else{
            return 0;
        }
    }
}

if (!function_exists('class_id_by_student_code')) {
    function class_id_by_student_code($student_code) {
        $studentDetailsModel = new StudentDetailsModel();
        $student = $studentDetailsModel
            ->select('class_id')
            ->where('code', $student_code)
            ->where('session_year_id', session()->get('session_year_id'))
            ->first();

        $classId = $student['class_id'] ?? '';

        if( $classId != '' ){
            return $classId;
        }else{
            return '';
        }
    }
}

if (!function_exists('second_language_by_student_id')) {
    function second_language_by_student_id($student_id) {
        $studentPersonalDetailsModel = new StudentPersonalDetailsModel();
        $student = $studentPersonalDetailsModel
            ->select('second_language')
            ->where('student_id', $student_id)
            ->first();

        $language = $student['second_language'] ?? 'Bengali';

        return $language;
    }
}

if (!function_exists('student_user_id_by_code')) {
    function student_user_id_by_code($student_code) {
        $adminUserModel = new AdminUserModel();
        $student = $adminUserModel
            ->select('id')
            ->where('code', $student_code)
            ->first();

        $studentUserId = $student['id'] ?? '';

        if( $studentUserId != '' ){
            return $studentUserId;
        }else{
            return '';
        }
    }
}

if (!function_exists('month_name')) {
    function month_name($month_id, $short = false)
    {
        $months = [
            1 => ['January', 'Jan'],
            2 => ['February', 'Feb'],
            3 => ['March', 'Mar'],
            4 => ['April', 'Apr'],
            5 => ['May', 'May'],
            6 => ['June', 'Jun'],
            7 => ['July', 'Jul'],
            8 => ['August', 'Aug'],
            9 => ['September', 'Sep'],
            10 => ['October', 'Oct'],
            11 => ['November', 'Nov'],
            12 => ['December', 'Dec']
        ];

        return isset($months[$month_id])
            ? ($short ? $months[$month_id][1] : $months[$month_id][0])
            : '';
    }
}

if (!function_exists('get_birthday_content')) {
    function get_birthday_content($name)
    {
        $month = date('m');

        $messages = [
            '01' => ['title' => 'Happy Birthday '.$name.' ❄️', 'msg' => 'Wishing you a fresh start this new year!', 'bgimg' => '/public/img/birthday/january.jpeg'],
            '02' => ['title' => 'Happy Birthday '.$name.' ❤️', 'msg' => 'May your day be filled with love and joy!', 'bgimg' => '/public/img/birthday/february.jpeg'],
            '03' => ['title' => 'Happy Birthday '.$name.' 🌸', 'msg' => 'May your life bloom with happiness!', 'bgimg' => '/public/img/birthday/march.jpeg'],
            '04' => ['title' => 'Happy Birthday '.$name.' 🌿', 'msg' => 'Wishing you positivity and growth!', 'bgimg' => '/public/img/birthday/april.jpeg'],
            
            // '04' => ['title' => 'Happy Birthday '.$name.' 🌿', 'msg' => 'Wishing you positivity and growth!', 'bgimg' => '/public/img/birthday/january.jpeg'],
            // '04' => ['title' => 'Happy Birthday '.$name.' 🌿', 'msg' => 'Wishing you positivity and growth!', 'bgimg' => '/public/img/birthday/february.jpeg'],
            // '04' => ['title' => 'Happy Birthday '.$name.' 🌿', 'msg' => 'Wishing you positivity and growth!', 'bgimg' => '/public/img/birthday/march.jpeg'],
            // '04' => ['title' => 'Happy Birthday '.$name.' 🌿', 'msg' => 'Wishing you positivity and growth!', 'bgimg' => '/public/img/birthday/april.jpeg'],
            // '04' => ['title' => 'Happy Birthday '.$name.' 🌿', 'msg' => 'Wishing you positivity and growth!', 'bgimg' => '/public/img/birthday/may.jpeg'],
            // '04' => ['title' => 'Happy Birthday '.$name.' 🌿', 'msg' => 'Wishing you positivity and growth!', 'bgimg' => '/public/img/birthday/june.jpeg'],
            // '04' => ['title' => 'Happy Birthday '.$name.' 🌿', 'msg' => 'Wishing you positivity and growth!', 'bgimg' => '/public/img/birthday/july.jpeg'],
            // '04' => ['title' => 'Happy Birthday '.$name.' 🌿', 'msg' => 'Wishing you positivity and growth!', 'bgimg' => '/public/img/birthday/august.jpeg'],
            // '04' => ['title' => 'Happy Birthday '.$name.' 🌿', 'msg' => 'Wishing you positivity and growth!', 'bgimg' => '/public/img/birthday/september.jpeg'],
            // '04' => ['title' => 'Happy Birthday '.$name.' 🌿', 'msg' => 'Wishing you positivity and growth!', 'bgimg' => '/public/img/birthday/october.jpeg'],
            // '04' => ['title' => 'Happy Birthday '.$name.' 🌿', 'msg' => 'Wishing you positivity and growth!', 'bgimg' => '/public/img/birthday/november.jpeg'],
            // '04' => ['title' => 'Happy Birthday '.$name.' 🌿', 'msg' => 'Wishing you positivity and growth!', 'bgimg' => '/public/img/birthday/december.jpeg'],



            '05' => ['title' => 'Happy Birthday '.$name.' ☀️', 'msg' => 'Shine bright and stay happy!', 'bgimg' => '/public/img/birthday/may.jpeg'],
            '06' => ['title' => 'Happy Birthday '.$name.' 🌧️', 'msg' => 'Stay refreshed and joyful!', 'bgimg' => '/public/img/birthday/june.jpeg'],
            '07' => ['title' => 'Happy Birthday '.$name.' 🌼', 'msg' => 'Keep growing and shining!', 'bgimg' => '/public/img/birthday/july.jpeg'],
            '08' => ['title' => 'Happy Birthday '.$name.' 🎉', 'msg' => 'Celebrate your day with pride!', 'bgimg' => '/public/img/birthday/august.jpeg'],
            '09' => ['title' => 'Happy Birthday '.$name.' 🍂', 'msg' => 'Wishing you peace and success!', 'bgimg' => '/public/img/birthday/september.jpeg'],
            '10' => ['title' => 'Happy Birthday '.$name.' 🎃', 'msg' => 'Enjoy your special day!', 'bgimg' => '/public/img/birthday/october.jpeg'],
            '11' => ['title' => 'Happy Birthday '.$name.' 🍁', 'msg' => 'Stay warm and successful!', 'bgimg' => '/public/img/birthday/november.jpeg'],
            '12' => ['title' => 'Happy Birthday '.$name.' 🎄', 'msg' => 'Have a magical birthday!', 'bgimg' => '/public/img/birthday/december.jpeg'],
        ];

        return $messages[$month];
    }
}