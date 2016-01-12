<?php

$db_host = "mysql.hcs.harvard.edu";
$db_username = "aab";
$db_pass = "hGAGUZU1mRCt";
$db_name = "aab";

$mysql_connection = mysql_connect("$db_host","$db_username","$db_pass", false) or die ("could not connect to mysql");
$mysql_select_db = mysql_select_db("$db_name") or die ("no database");

?>