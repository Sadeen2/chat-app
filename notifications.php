<?php
session_start();
$myid = $_SESSION['userid'];
error_reporting(0);
$conn = mysqli_connect("localhost", "root", "12345678", "ms2");
//$rec=$_SESSION['receiver'];


$q="select notification from messages where receiver='$myid' and notification=1;";
$c=mysqli_query($conn,$q);
$count=0;

while($x=mysqli_fetch_assoc($c)){
    if($x['notification']==1)$count++;
}

echo $count;

