<?php
require(__DIR__ . '/../../vendor/autoload.php');
// Check for empty fields
if(empty($_POST['name'])      ||
 empty($_POST['email'])     ||
 empty($_POST['phone'])     ||
 empty($_POST['message'])   ||
 !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
{
  // print_r($_POST);
  echo "No arguments Provided!";
 return false;
}


$name = strip_tags(htmlspecialchars($_POST['name']));
$email_address = strip_tags(htmlspecialchars($_POST['email']));
$phone = strip_tags(htmlspecialchars($_POST['phone']));
$message = strip_tags(htmlspecialchars($_POST['message']));

$body = "You have received a new message from generico contact form.<br>"."Here are the details:<br>" .
"Name: $name<br>Email: $email_address<br>Phone: $phone<br>Message:<br>$message";
try {
  $from = new SendGrid\Email("Tech", "tech@workcell.in");
  $subject = "Generico Contact Form:  $name";
    $to = new SendGrid\Email("Siddharth Gadia", "siddharth@letsreap.com");
  $content = new \SendGrid\Content("text/html", $body);
  $mail = new SendGrid\Mail($from, $subject, $to, $content);


  $key = trim(file_get_contents(__DIR__ . "/../../key")); 
  $sg = new \SendGrid($key);
  $response = $sg->client->mail()->send()->post($mail);
  echo "success";



} catch (\Exception $e) {
  echo $e->getMessage();
}


?>
