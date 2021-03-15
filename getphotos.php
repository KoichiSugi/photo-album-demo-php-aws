<!DOCTYPE html>
<html lang="en">
<!-- 
Allows users to search for a photo based on title, keywords, or date ranges (a date range must include a
‘from’ date and a ‘to’ date). It will display all the photos found along with their meta-data. For
example, you should be able to search for photos with the keyword “cat” taken anytime in March
this year -->

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
    <!-- <script src="getphotos.js"></script> -->
</head>

<body>
    <h1>Get Photos page</h1>

    <fieldset>
        <legend>Enter Search KeyWords(separated by a semicolon): </legend>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            Photo Titile: <input type="text" id="ptitle" name="ptitle"><br><br>
            KeyWords(separated by a semicolon): <br>
            <input type="text" id="key" name="key"><br><br>
            Date from: <input type="date" id="dateFrom" name="dateFrom"><br><br>
            Date to: <input type="date" id="dateTo" name="dateTo"><br><br>
            <input type="submit" name="submit" value="Submit">
        </form>
    </fieldset>

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
    echo "Connected successfully";

    function format_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    function date_range_checker($dataFrom, $dataTo)
    {
        if ($dataFrom > $dataTo) {
            return true;
        }
    }

    $dateRangeFlag = false;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST["ptitle"])) {
            $ptitle = format_input($_POST["ptitle"]);
        }
        if (!empty($_POST["key"])) {
            $key = format_input($_POST["key"]);
        }
        if (!empty($_POST["dateFrom"])) {
            $dateFrom = format_input($_POST["dateFrom"]);
        }
        if (!empty($_POST["dateTo"])) {
            $dateTo = format_input($_POST["dateTo"]);
        }
        if (!empty($_POST["dateFrom"]) && !empty($_POST["dateTo"])) {
            $dateRangeFlag = date_range_checker($dateFrom, $dataTo);
        }
    }

    echo "<h2>Your Input:</h2>";
    echo "Photo Title: " . $ptitle;
    echo "<br>";
    echo "Date from:  " . $dateFrom;
    echo "<br>";
    echo "Date to:  " . $dateTo;
    echo "<br>";
    echo "KeyWord:  " . $key;
    echo "<br>";


    //if (!$dateRangeFlag) {
        //execute query without date
    //}
        if($dateRangeFlag){echo "True"; }else echo "fasle";
        if($ptitle != '' || $key != '' || $dateRangeFlag){

            $query = "Select * from photo where ";
            $single = true;
            
            if( $ptitle != '' ){
                $query .= "photoTitle LIKE '%".$ptitle."%' ";
                $single = false;
            }

            if($key != ''){
                if(!$single){
                    $query .= "and ";
                }
                $query .= "keywords LIKE '%".$key."%' ";
                $single = false;
            }

            if($dateRangeFlag){
                if(!$single){ $query .= " and ";}
                $query .= "dateOfPhoto between '".$dateFrom."' and '".$dateTo."'";
            }

            $query .= ";";
        }



    
    
    //$query = "select * from photo where keywords like '%$key%' or keywords like '% $key%,';";
   // $query = "SELECT * FROM photo WHERE ".'dateOfPhoto'." between '".$dateFrom."' and '".$dateTo."';";
    //$query = "SELECT refToPhotoObjs3 FROM photo WHERE $dateOfPhoto between '$dataFrom' and '$dataTo'";
    $result = mysqli_query($conn, $query);

        echo $query;








    try {
        if (mysqli_num_rows(!$result > 0)) {
            echo 'No Result';
        }
        
    
        //$test[] = mysqli_fetch_row($result);
        $i = 0;
        echo "testing";
       
        // while (sizeof($test < $i)) {
        //     echo $test[$i];
        //     $i++;
        // }
        echo $urlToObject['refToPhotoObjS3'];
        //echo "size is ".sizeof($urlToObject);
        echo "<br>";
        echo mysqli_num_rows($result);
    } catch (mysqli_sql_exception $e) {
        var_dump($e);
        exit;
    }
    //mysqli_free_result($result);
    ?>
    <br>
    <pre> 
    <?php 
        print_r($urlToObject);
    ?>
    </pre>
    <?php 
        while($row = mysqli_fetch_assoc($result)){?>
                <img src=<?php echo "$row[refToPhotoObjS3]" ?> alt="fetched image" width="1366px" height="768px" />
                <dir id="photo">
                </dir>

        <?php }
    
    ?>
    

</body>

</html>