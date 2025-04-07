<?php
$conn=mysqli_connect("localhost","root","12345678");
$q="create database ms2;";
mysqli_query($conn, $q);

$conn2=mysqli_connect("localhost","root","12345678","ms2");
$q2="create table users(
userid varchar(15) primary key,
username varchar(20),
passcode varchar(20)
);";
mysqli_query($conn2, $q2);


$q3="create table messages(
mnum int primary key auto_increment,
sender varchar(15),
foreign key(sender) references users(userid),
receiver varchar(15),
foreign key(receiver) references users(userid),
mss varchar(2000),
mday varchar(10),
mtime varchar(10),
mdate date,
notification bit default 0

);";
mysqli_query($conn2, $q3);


$q4="insert into users values('123','Sadeen Hashem','12345');";
mysqli_query($conn2, $q4);

$q5="insert into users values('456','Hala Mohammad','54321');";
mysqli_query($conn2, $q5);

$q6="insert into users values('789','Ahmad Saad','321');";
mysqli_query($conn2, $q6);

$q7="insert into users values('111','Sara Asaad','123');";
mysqli_query($conn2, $q7);

$q8="insert into users values('222','Hamza Sami','543');";
mysqli_query($conn2, $q8);

$q9="insert into users values('333','Yara Jaser','345');";
mysqli_query($conn2, $q9);

$q10="insert into users values('444','Rami Waleed','54321');";
mysqli_query($conn2, $q10);



