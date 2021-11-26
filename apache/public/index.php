<pre>
<?php

// phpinfo();

$servername = "db_server";
$username = "test_user";
$password = "test_pass";
$database = "laravelproject";

// Connect to MySQL
$db_link = mysql_connect($servername, $username, $password, true);

if (mysql_select_db($database, $db_link)) {
    echo 'Connected!';

    $query = "SELECT * FROM `users`";
    $result = mysql_query($query, $db_link);

    // Create the results array
    while($info = mysql_fetch_array($result, MYSQL_ASSOC)) {
        $results[] = $info;
    }

    print_r($results);
}
?>
</pre>