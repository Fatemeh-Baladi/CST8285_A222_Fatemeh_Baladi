<!-- Student Name: Fatemeh Baladi
Course: CST 8285 313
Assignment 02
Professor Alemeseged Legesse
 -->

 <?php
// Include employeeDAO file
require_once('./dao/employeeDAO.php');


// Define variables and initialize with empty values
$number = $text = $date = $image = "";
$number_err = $text_err = $date_err = $image_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    // Validate number
    $input_number = trim($_POST["number"]);
    if (empty($input_number)) {
        $number_err = "Please enter the number.";
    } elseif (!ctype_digit($input_number)) {
        $number_err = "Please enter a valid number.";
    } else {
        $number = $input_number;
    }
    // Validate text
    $input_text = trim($_POST["text"]);
    if (empty($input_text)) {
        $text_err = "Please enter a text.";
    } elseif (!filter_var($input_text, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $text_err = "Please enter a valid text.";
    } else {
        $text = $input_text;
    }

    // Validate date
    $input_date = trim($_POST["date"]);
    if (empty($input_date)) {
        $date_err = "Please enter a date.";
    } elseif(!filter_var($input_date, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-3]?[0-9].[0-3]?[0-9].(?:[0-9]{2})?[0-9]{2}$/")))){
            $date_err = "Please enter a valid date.";
    }else {
        $date = $input_date;
    }

    // Validate image
    $input_image = trim($_POST["image"]);
    if(empty($input_image)){
        $image_err = "Please upload the image.";     
    } else{
        $image = $input_image;
    }
    // Check input errors before inserting in database


    if (empty($number_err) && empty($text_err) && empty($date_err) && empty($image_err)) {
        $employeeDAO = new employeeDAO();
        $employee = new Employee(0, $number, $text, $date, $image);
        $addResult = $employeeDAO->addEmployee($employee);
        echo '<br><h6 style="text-align:center">' . $addResult . '</h6>';
        header("refresh:2; url=index.php");
        // Close connection
        $employeeDAO->getMysqli()->close();
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    .wrapper {
        width: 600px;
        margin: 0 auto;
    }
    </style>



</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add records to the database.</p>

                    <!--the following form action, will send the submitted form data to the page itself ($_SERVER["PHP_SELF"]), instead of jumping to a different page.-->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Number</label>
                            <input type="text" name="number"
                                class="form-control <?php echo (!empty($number_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $number; ?>">
                            <span class="invalid-feedback"><?php echo $number_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Text</label>
                            <textarea name="text"
                                class="form-control <?php echo (!empty($text_err)) ? 'is-invalid' : ''; ?>"><?php echo $text; ?></textarea>
                            <span class="invalid-feedback"><?php echo $text_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Date</label>
                            <input type="text" name="date"
                                class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $date; ?>">
                            <span class="invalid-feedback"><?php echo $date_err; ?></span>
                        </div>

                        
                        <?php
                        if(isset($_POST['name'])){
                            $img=$_FILES['image']['name'];
                            $img_loc=$_FILES['image']['tmp_name'];
                            $img_folder="imgs/";
                            if(move_uploaded_file($img_loc,$$img_folder.$img)){
                                
                                
                            }
                        }
                        ?>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image" accept="image/*"
                                class="form-group <?php echo (!empty($image_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $image; ?>">

                            <?php

                            $images = scandir('imgs');
                            print_r($image);
                            $images_array = array_values(array_diff($images, array (".", "..")));

                            ?> 

                            


                            <!-- <div class="col-md-12">
                            <img src="image/<IMAGE_PATH>" class="img-fluid img-thumbnail"> -->
                            <!-- </div> -->

                            <input type="submit" class="btn btn-primary" value="Submit">
                            <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
        <? include 'footer.php'; ?>
    </div>
</body>


</html>