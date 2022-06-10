<?php
// Include employeeDAO file
require_once('./dao/employeeDAO.php');
 
// Define variables and initialize with empty values
$number = $text = $date = $image = "";
$number_err = $text_err = $date_err = $image_err = "";
$employeeDAO = new employeeDAO(); 

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate number
    $input_number = trim($_POST["number"]);
    if(empty($input_number)){
        $number_err = "Please enter a number.";
    } elseif(!ctype_digit($input_number)){
        $number_err = "Please enter a valid number.";
    } else{
        $number = $input_number;
    }

    $input_text = trim($_POST["text"]);
    if(empty($input_text)){
        $text_err = "Please enter a text.";
    } elseif(!filter_var($input_text, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $text_err = "Please enter a valid text.";
    } else{
        $text = $input_text;
    }
    
    // Validate address address
    $input_date = trim($_POST["date"]);
    if(empty($input_date)){
        $date_err = "Please enter a date.";     
    } else{
        $date = $input_date;
    }
    
        // // Validate image
    $input_image = trim($_POST["image"]);
    if(empty($input_image)){
        $image_err = "Please upload the image.";     
    } else{
        $image = $input_image;
    }
    
    // Check input errors before inserting in database
    if(empty($number_err) && empty($text_err) && empty($date_err) && empty($image_err)){   
        $employee = new Employee($id, $number, $text, $date, $image);
        $result = $employeeDAO->updateEmployee($employee);
        echo '<br><h6 style="text-align:center">' . $result . '</h6>';   
        header( "refresh:2; url=index.php" ); 
        // Close connection
        $employeeDAO->getMysqli()->close();
    }

} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        $employee = $employeeDAO->getEmployee($id);
                
        if($employee){
            // Retrieve individual field value
            $number = $employee->getNumber();
            $text = $employee->getText();
            $date = $employee->getDate();
            $image = $employee->getImage();
        } else{
            // URL doesn't contain valid id. Redirect to error page
            header("location: error.php");
            exit();
        }
    } else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
    // Close connection
    $employeeDAO->getMysqli()->close();
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
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
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the employee record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Number</label>
                            <input type="text" name="number" class="form-control <?php echo (!empty($number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $number; ?>">
                            <span class="invalid-feedback"><?php echo $number_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Text</label>
                            <textarea name="text" class="form-control <?php echo (!empty($text_err)) ? 'is-invalid' : ''; ?>"><?php echo $text; ?></textarea>
                            <span class="invalid-feedback"><?php echo $text_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Date</label>
                            <textarea name="date" class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>"><?php echo $date; ?></textarea>
                            <span class="invalid-feedback"><?php echo $date_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name = "image" accept="image/*" class="form-group <?php echo (!empty($image_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $image; ?>">
                            <!-- <div class="col-md-12">
                            <img src="image/<IMAGE_PATH>" class="img-fluid img-thumbnail"> -->
                        </div> 
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>