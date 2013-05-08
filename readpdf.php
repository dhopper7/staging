<?php
include 'readpdfCode.php';

$result = pdf2text ('sample.pdf');
echo $result;