<?php
$msg = "First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg, 70);

// send email
// org nummber

mail($_GET["contact_email"], $_GET[], $msg);
header('Location: ' . "https://www.rasts.se/");
