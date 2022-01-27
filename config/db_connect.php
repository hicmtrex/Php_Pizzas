<?php
//connect to database   host,username,password,database name
$conn = mysqli_connect("localhost", "root", "", "hicm_pizza");

// check connection

if (!$conn) {
    echo "Connection error:" . mysqli_connect_error();
}
