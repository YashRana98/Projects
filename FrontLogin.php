<?php
//grab data from post
$postType = $_POST['postType'];
$un = $_POST['ucid'];
$pwd = $_POST['pass'];
$post="postType=$postType&ucid=$un&pass=$pwd";

//do curl POST to middle
$toMid = curl_init();
curl_setopt($toMid, CURLOPT_POSTFIELDS, $post);
curl_setopt($toMid, CURLOPT_URL, "https://web.njit.edu/~yr83/betamiddle.php");
curl_setopt($toMid, CURLOPT_RETURNTRANSFER, true); 
$contents = curl_exec ($toMid);
echo $contents;
?>
