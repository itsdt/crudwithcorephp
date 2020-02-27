<?php
include_once 'db.php';
$nameErr = $emailErr = $phoneErr = $genderErr = $websiteErr = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'updateData') {
    extract($_POST);
            

    if (empty($name)) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($name);
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed";
        }
    }

    if (empty($email)) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }
    if (empty($phone_no)) {
        $phoneErr = "Phone No is required";
    } else {
        $phone_no = test_input($phone_no);
        if (!filter_var($phone_no, FILTER_SANITIZE_NUMBER_INT)) {
            $phoneErr = "Invalid phone format";
        }
    }

    if (empty($website)) {
        $websiteErr = "URL is required";
    } else {
        $website = test_input($website);
        if (!filter_var($website, FILTER_VALIDATE_URL)) {
            $websiteErr = "Invalid URL";
        }
    }

    if (empty($address)) {
        $address = "";
    } else {
        $address = test_input($address);
    }

    if (empty($gender)) {
        $genderErr = "Gender is required";
    } else {
        $gender = test_input($gender);
    }

    if (empty($nameErr) && empty($emailErr) && empty($phoneErr) && empty($genderErr) && empty($websiteErr)) {
        $hobbies = $_POST['hobbie'];
        $hobbiesImplode = implode(",", $hobbies);

       
        $data = [$name, $email, $phone_no, $hobbiesImplode, $gender, $website, $address];
        $db->update($id, $data);
        header('Location:index.php');
    }
    else 
    {
        $hobby = ($_POST['hobbie']) ? : $_POST['hobbies'];
    $hobbies = implode(",", $hobby);

    }
} else {
    $oneRecord = $db->selectOne($_GET['id']);
    if (empty($oneRecord) || empty($_GET['id'])) {
        header('Location:index.php');
        die;
    }
    extract($oneRecord);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <!-- <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script> -->
    <link async rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <style>
        .common {
            width: 30%;
        }

        .error {
            color: #FF0000;
        }
    </style>
</head>

<body>
    <?php
    ?>
    <div class="container">
        <h2>Details Form Example</h2>
        <center><h3 style="color:red;">* field required</h3></center>
        <form id="form" method="post" action="<?php echo $_SERVER['PHP_SELF'] . "?id=", $_GET['id']; ?>">
            <input type="hidden" name="action" value="updateData">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group">
                <label for="name">Name <span style="color:red;font-size:20px;">*</span></label>
                <input type="text" class="form-control common" placeholder="Enter Your Name" name="name" value="<?php echo $name; ?>">
                <span class="error"> <?php echo $nameErr; ?></span>
            </div>

            <div class="form-group">
                <label for="email">Email<span style="color:red;font-size:20px;">*</span></label>
                <input type="text" class="form-control common" id="email" placeholder="Enter Email" name="email" value="<?php echo $email; ?>">
                <span class="error"> <?php echo $emailErr; ?></span>
            </div>

            <div class="form-group">
                <label for="phone">Phone No<span style="color:red;font-size:20px;">*</span></label>
                <input type="text" class="form-control common" name="phone_no" placeholder="Enter Mobile Number" value="<?php echo $phone_no; ?>">
                <span class="error"> <?php echo $phoneErr; ?></span>
            </div>

            <div class="form-group">
                <label for="hobbies">Hobbies<span style="color:red;font-size:20px;">*</span> </label>
                <?php $hobbiesExploded = explode(',', $hobbies); ?>
                <div class="form-check-inline">
                    <input type="checkbox" class="form-check-input" id="hobbie" name="hobbie[]" value="Dancing" <?php echo in_array('Dancing', $hobbiesExploded) ? 'checked' : ''; ?>>dancing
                </div>
                <div class="form-check-inline">

                    <input type="checkbox" class="form-check-input" id="hobbie" name="hobbie[]" value="Singing" <?php echo in_array('Singing', $hobbiesExploded) ? 'checked' : ''; ?>>singing

                </div>
                <div class="form-check-inline">
                    <input type="checkbox" class="form-check-input" id="hobbie" name="hobbie[]" value="Reading" <?php echo in_array('Reading', $hobbiesExploded) ? 'checked' : ''; ?>>reading
                </div>
                <div class="form-check-inline">
                    <input type="checkbox" class="form-check-input" id="hobbie" name="hobbie[]" value="Travelling" <?php echo in_array('Travelling', $hobbiesExploded) ? 'checked' : ''; ?>>Travelling
                </div>
                <div class="form-check-inline">
                    <input type="checkbox" class="form-check-input" id="hobbie" name="hobbie[]" value="Playing" <?php echo in_array('Playing', $hobbiesExploded) ? 'checked' : ''; ?>>playing
                </div>
                <div class="form-check-inline">
                    <input type="checkbox" class="form-check-input" id="hobbie" name="hobbie[]" value="Writing" <?php echo in_array('Writing', $hobbiesExploded) ? 'checked' : ''; ?>>writing
                </div>
                <div class="form-check-inline">
                    <input type="checkbox" class="form-check-input" id="hobbie" name="hobbie[]" value="Walking" <?php echo in_array('Walking', $hobbiesExploded) ? 'checked' : ''; ?>>Walking
                </div>
            </div>

            <div class="form-group">
                <label for="gender">Gender<span style="color:red;font-size:20px;">*</span></label>
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="gender" <?php if (isset($gender) && $gender == "male") echo "checked"; ?> value="male" checked>male
                    </label>
                </div>
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="gender" <?php if (isset($gender) && $gender == "female") echo "checked"; ?> value="female">Female
                    </label>
                </div>
                <span class="error"> <?php echo $genderErr; ?></span></span>
            </div>

            <div class="form-group">
                <label for="website">Website<span style="color:red;font-size:20px;">*</span></label>
                <input type="text" class="form-control common" placeholder="Enter Your Website" name="website" value="<?php echo $website; ?>">
                <span class="error"><?php echo $websiteErr; ?></span>
            </div>

            <div class="form-group">
                <label for="address">Address<span style="color:red;font-size:20px;">*</span></label>
                <textarea class="form-control common" name="address" placeholder="Enter Your Address" rows="5" cols="40"><?php echo isset($address) ? $address : ''; ?></textarea>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary container" onclick="check()">Submit</button>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-primary container" onclick="window.location.href=window.location.href;">Reset form</button>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-primary container" onClick="document.location.href='index.php'">List</button>
                </div>
                <!-- <div class="col-md-3">
                    <button type="button" class="btn btn-primary container" onClick="document.location.href='DatabaseFormUpdate1.php'">Update</button>
                </div> -->

            </div>
        </form>
        <br><br>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script>
        function check(){
            console.log(1);
            return false;
        var email=$('#email').val();

        $.ajax({
            url:"demo.php",
            type:'POST',
            data:{emailx:email},
            success:function(data){
            },
            
        });
        }
        </script>
</body>

</html>