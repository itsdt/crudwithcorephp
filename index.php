<?php
include_once 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'delete') {
    $db->delete($_POST['deleteID']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'update') {
    //$update = $db->update($_POST['updateID']);
    $_SESSION["updateID"] =  $_POST['updateID'];
    header('Location:update.php');
    die;
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <!-- <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script> -->
    <link async rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <title>Form data input</title>
</head>

<body>
    <div class='container'>
        <ht>
         <form name="serachForm" method='POST' action='index.php'>
        <br>
        
       
            
<button type="button" class="a-flex btn btn-success" style="display=inline" onClick="document.location.href='insert.php'">Insert</button>

  
          <div style="float: right;">
<input type='hidden' name='action' value='search' />
            <input id="selectID" type='text' name='searchID'placeholder="Find Data" value='' />
  <button type='submit' class='btn btn-success '>Search</button>         
</div>        
</form>

    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'search') {
        $db->select($_POST['searchID']);
    } else {
        $db->select();
    }
    ?>
    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>

</html>