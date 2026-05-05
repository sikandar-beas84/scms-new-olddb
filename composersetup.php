<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 🔐 SECURITY KEY (change this)
if (!isset($_GET['key']) || $_GET['key'] !== 'mysecret123') {
    die('Access Denied');
}

// --- OPTION A: Hardcoded (Easiest for a quick test) ---
$host     = "localhost"; 
$port     = "5432"; // Default PostgreSQL port
$dbname   = "scmschakdaha_memorial";
$user     = "scmschakdaha_school";
$password = "p3N}W^2#CRPGtunK";

// --- OPTION B: Load from CI4 Config (Optional) ---
/*
require_once __DIR__ . '/../app/Config/Database.php';
$dbConfig = new \Config\Database();
$host     = $dbConfig->default['hostname'];
$dbname   = $dbConfig->default['database'];
$user     = $dbConfig->default['username'];
$password = $dbConfig->default['password'];
$port     = $dbConfig->default['port'] ?? '5432';
*/

$connectionString = "host=$host port=$port dbname=$dbname user=$user password=$password";

echo "<h2>PostgreSQL Connection Test</h2>";
echo "Attempting to connect to <b>$dbname</b> at <b>$host</b>...<br><br>";

$dbconn = pg_connect($connectionString);

if($dbconn) {
    echo "<b style='color:green'>✅ Success!</b> Connected to PostgreSQL.";
    
    // Check version
    $version = pg_version($dbconn);
    echo "<br>Server Version: " . $version['server'];


	// 1. Randomly ekta student-er fee record select kora
	// 'student_fee_structure' table theke 'id' ebong 'student_code' nichhi
	$query = "SELECT id, student_code, admission_fee FROM student_fee_structure ORDER BY RANDOM() LIMIT 1";
	$result = pg_query($dbconn, $query);

	if ($row = pg_fetch_assoc($result)) {
	    $feeId = $row['id'];
	    $sCode = $row['student_code'];
	    
	    // 2. Random Value Generate (Ekhane amra total payment amount r status update korbo)
	    $randomAmount = rand(20000, 80000); 
	    $randomStatus = rand(1, 2); // 1 = Paid, 2 = Pending (Apnar logic onujayi change korun)
	    $transactionId = "TXN" . strtoupper(bin2hex(random_bytes(4)));

	    // 3. Database Update logic
	    // Ekhane 'payment_amount', 'ad_payment_status', ebong 'transaction_no' update kora hochche
	    $updateQuery = "UPDATE student_fee_structure 
	                    SET payment_amount = $randomAmount, 
	                        ad_payment_status = $randomStatus,
	                        transaction_no = '$transactionId',
	                        created_at = NOW() 
	                    WHERE id = $feeId";
	    
	    $updateResult = pg_query($dbconn, $updateQuery);
	    // $updateResult = true;

	    if ($updateResult) {
	        echo "<div style='border:1px solid #ccc; padding:15px; background:#f9f9f9;'>";
	        echo "✅ <b style='color:green'>Success!</b> Record Updated.<br><br>";
	        echo "<b>Student Code:</b> $sCode<br>";
	        echo "<b>Record ID:</b> $feeId<br>";
	        echo "<b>New Amount:</b> ₹$randomAmount<br>";
	        echo "<b>Status:</b> " . ($randomStatus == 1 ? "Paid" : "Partially Paid/Pending") . "<br>";
	        echo "<b>Transaction No:</b> $transactionId";
	        echo "</div>";
	    } else {
	        echo "❌ Update Failed: " . pg_last_error($dbconn);
	    }
	} else {
	    echo "No fee records found in student_fee_structure.";
	}


	/*// 1. Student Details table theke randomly ekta row select kora
	// PostgreSQL-e RANDOM() function use hoy
	$query = "SELECT id, first_name as name FROM student_details ORDER BY RANDOM() LIMIT 1";
	$result = pg_query($dbconn, $query);

	if ($row = pg_fetch_assoc($result)) {
	    $studentId = $row['id'];
	    $studentName = $row['name'];
	    
	    // 2. Random ekta value generate kora (Jemon: random fees ba status)
	    $randomValue = rand(1000, 5000); 
	    
	    // 3. Database Update kora (Ekhane 'fees' column dore nichchi, apni column name change kore neben)
	    // $updateQuery = "UPDATE student_details SET fees = $randomValue WHERE id = $studentId";
	    // $updateResult = pg_query($dbconn, $updateQuery);

	    $updateResult = true;

	    if ($updateResult) {
	        echo "✅ Success!<br>";
	        echo "Student Name: <b>$studentName</b> (ID: $studentId)<br>";
	        echo "New Random Value set: <b>$randomValue</b>";
	    } else {
	        echo "❌ Update Failed: " . pg_last_error($dbconn);
	    }
	} else {
	    echo "No students found in the table.";
	}*/

pg_close($dbconn);

} else {
    echo "<b style='color:red'>❌ Error:</b> Could not connect to the database.<br>";
    echo "Check if the <b>php-pgsql</b> extension is enabled in your cPanel/Server.";
}