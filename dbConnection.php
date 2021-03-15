    <?php

    $host = "HOST_NAME";
    $sql_db = "YOUR_DB";
    $table = "photo";
    $user = "master";
    $pwd = "master1234";
    $conn = @mysqli_connect(
        $host,
        $user,
        $pwd,
        $sql_db
    );

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    //echo "Connected successfully!";
	
	?>