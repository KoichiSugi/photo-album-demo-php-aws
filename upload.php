<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
</head>

<body>
    <?php
    ini_set('display_errors', 1);
    $parent_location = dirname(dirname(__FILE__));
    require $parent_location . '/aws2/aws-autoloader.php';
    include 'format_input.php';
    include 'dbConnection.php';
    ?>

    <?php

    use Aws\S3\S3Client;

    $s3_client = new S3Client([
        'version' => 'latest',
        'region' => 'us-east-1'
    ]);

    use Aws\S3\MultipartUploader;
    use Aws\S3\Exception\S3Exception;

    if (isset($_POST['submit']) && !empty($_POST["ptitle"]) && !empty($_POST["key"])) {

        $is_file_uploaded = move_uploaded_file(
            $_FILES["file_input"]["tmp_name"],
            dirname(__FILE__) . '/uploads/test.png'
        );
        //echo dirname(__FILE__) . '/uploads/test.png';
        if ($is_file_uploaded) {
            $ptitle = $_POST["ptitle"];
            $uploader = new MultipartUploader(
                $s3_client,
                dirname(__FILE__) . '/uploads/test.png',
                ['bucket' => 'assign1bkoichi', 'key' => $ptitle]
            );
            try {
                $result = $uploader->upload();
            } catch (S3Exception $e) {
            }
        }
    }

    //input validation
    $flag = true;
    if (isset($_POST['submit'])) {
        if (!empty($_POST["ptitle"])) {
            $ptitle = format_input($_POST["ptitle"]);
        } else {
            $flag = false;
        }
        if (!empty($_POST["key"])) {
            $key = format_input($_POST["key"]);
        } else {
            $flag = false;
        }
        if (!empty($_POST["date"])) {
            $date = format_input($_POST["date"]);
        }
        if (!empty($_POST["desc"])) {
            $desc = format_input($_POST["desc"]);
        }
        // echo $ptitle . "\n";
        // echo $key . "\n";
        // echo $date . "\n";
        // echo $desc . "\n";

        //if flag is true, update db 
        if ($flag == true) {
            $ref = 'http://d7tvo108x7ztz.cloudfront.net/';
            $ref .= $ptitle;
            echo "object address is : " . $ref;
            //write query to update db with object url
            $insert_query = "INSERT INTO `photo`(`id`, `photoTitle`, `description`, `dateOfPhoto`, `keywords`, `refToPhotoObjS3`) VALUES (0,'$ptitle','$desc','$date','$key','$ref')";
            $result = mysqli_query($conn, $insert_query);

            if (!$result)
                echo "ERROR IN QUERY";
            else
                echo "Database has been updated successfully";
        } else {
            echo "ERROR: INCOMPLETE FORM";
        }

        // if (!file_exists($_FILES["file_input"])) {
        //     $file = true;
        // } else {
        //     $file = false;
        // }
        //echo $file;

    }
    ?>



    <h1>Photo Uploader</h1>
    <fieldset>
        <form action="upload.php" method="post" enctype="multipart/form-data">

            Photo Titile: <input type="text" id="ptitle" name="ptitle"><br><br>
            Select a photo: <input type="file" name="file_input" id="file_input" /><br><br>
            Description: <input type="text" id="desc" name="desc"><br><br>
            Date: <input type="date" id="date" name="date"><br><br>
            KeyWords(separated by a semicolon): <br>
            <input type="text" id="key" name="key"><br><br>
            <!-- <button name="test" type="button" onclick="form_validation">Upload</button><br> -->
            <input type="submit" value="Upload" name="submit"><br>
        </form>
    </fieldset>
    <a href="./getphotos.php">Photo Album</a>



</body>

</html>