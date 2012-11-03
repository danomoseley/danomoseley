<?php
error_reporting(-1);
require_once 'lib/snappy/src/autoload.php';

use Knp\Snappy\Pdf;

$snappy = new Pdf('/usr/bin/wkhtmltopdf');

if (isset($_GET['downloadToken'])) {
        setcookie("downloadToken", $_GET['downloadToken'], 0, '/', '.danomoseley.com');
}

$snappy->setOption('margin-top', 5);
$snappy->setOption('margin-bottom', 5);
$snappy->setOption('margin-right', 5);
$snappy->setOption('margin-left', 5);

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="Dan Moseley Resume '.date("Y").'.pdf"');
$pdf = $snappy->getOutput('http://localhost/?pdf');
header("Content-length: " . strlen($pdf));

echo $pdf;
?>
