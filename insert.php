<?php
include_once 'db.php';

$nameErr = $emailErr = $phoneErr = $genderErr = $websiteErr = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    } 

    if ($email != "")
     {
    
    if (!empty($result)) {
    $emailErr = "Email already exist";
    }
        }
    else {
        $email = test_input($email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($phone)) {
        $phoneErr = "Phone No is required";
    } else {
        $phone = test_input($phone);
        if (!filter_var($phone, FILTER_SANITIZE_NUMBER_INT)) {
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

    if (
        empty($nameErr) && empty($emailErr) && empty($phoneErr) && empty($genderErr) && empty($websiteErr)
    ) {
        $hobbies = $_POST['hobbie'];
        $hobbiesImplode = implode(",", $hobbies);
        // $hobbieExplode = explode(",", $hobbiesImplode);
        // $hobbies = $hobbieExplode[0];
        // $l = sizeof($hobbieExplode);
        // for ($i = 1; $i < $l; $i++) {
        //     $hobbies = $hobbies . "," . $hobbieExplode[$i];
        // }
        $data = [$name, $email, $phone, $hobbiesImplode, $gender, $website, $address];
        $insert = $db->insert($data);
        header('Location:index.php');
    }
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
        <form id="form" method="post" action=" <?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="name"style="font-size:20px;">Name<span style="color:red">*</span> </label>
              <input type="text" class="form-control common" placeholder="Enter Your Name" name="name" value="<?php if(isset($_POST['name'])){echo $_POST['name'];} ?>">
                <span class="error"> <?php echo $nameErr; ?></span>
            </div>

            <div class="form-group">
                <label for="email">Emai<span style="color:red">*</span></label>
                <input type="text" class="form-control common" id="email" placeholder="Enter Email" name="email" value="<?php if(isset($_POST['email'])){echo $_POST['email'];}?>">
                <span class="error"> <?php echo $emailErr; ?></span>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number<span style="color:red">*</span></label>
                <input type="text" class="form-control common" name="phone" placeholder="Enter Mobile Number" value="<?php if(isset($_POST['phone'])){echo $_POST['phone'];}?>">
                <span class="error"> <?php echo $phoneErr; ?></span>
            </div>

            <div class="form-group">
                <label for="hobbies">Hobbie<span style="color:red">*</span> </label>
                <div class="form-check-inline">

                    <input type="checkbox" class="form-check-input" id="hobbie" name="hobbie[]" value="Dancing" <?php if (isset($hobbie[0]) ) echo "checked"; ?> >dancing
                </div>
                <div class="form-check-inline">

                    <input type="checkbox" class="form-check-input" id="hobbie" name="hobbie[]" value="Singing"<?php if (isset($hobbie[1]) ) echo "checked"; ?>>singing

                </div>
                <div class="form-check-inline">
                    <input type="checkbox" class="form-check-input" id="hobbie" name="hobbie[]" value="Reading"<?php if (isset($hobbie[2]) ) echo "checked"; ?>>reading
                </div>
                <div class="form-check-inline">
                    <input type="checkbox" class="form-check-input" id="hobbie" name="hobbie[]" value="Travelling"<?php if (isset($hobbie[3]) ) echo "checked"; ?>>travelling
                </div>
                <div class="form-check-inline">
                    <input type="checkbox" class="form-check-input" id="hobbie" name="hobbie[]" value="Playing"<?php if (isset($hobbie[4]) ) echo "checked"; ?>>playing
                </div>
                <div class="form-check-inline">
                    <input type="checkbox" class="form-check-input" id="hobbie" name="hobbie[]" value="Writing"<?php if (isset($hobbie[5]) ) echo "checked"; ?>>writing
                </div>
                <div class="form-check-inline">
                    <input type="checkbox" class="form-check-input" id="hobbie" name="hobbie[]" value="Walking"<?php if (isset($hobbie[6]) ) echo "checked"; ?>>Walking
                </div>
            </div>

            <div class="form-group">
                <label for="gender">Gende<span style="color:red">*</span></label>
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
                <label for="website">Website<span style="color:red">*</span></label>
                <input type="text" class="form-control common" placeholder="Enter Your Website" name="website" value="<?php if(isset($_POST['website'])){echo $_POST['website'];}?>">
                <span class="error"><?php echo $websiteErr; ?></span>
            </div>

            <div class="form-group">
                <label for="address">Address<span style="color:red">*</span></label>
                <textarea class="form-control common" name="address" placeholder="Enter Your Address" rows="5" cols="40"><?php echo isset($address) ? $address : ''; ?></textarea>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary container">Submit</button>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-primary container" onclick="window.location.href=window.location.href;">Reset form</button>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-primary container" onClick="document.location.href='index.php'">List</button>
                </div>
                

            </div>
        </form>
        <br><br>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>

</html>