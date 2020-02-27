<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "user";
$password = "password";
$dbname = "myDBo";
$table = 'detail';
$createtable = false;
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

class Database
{  
    public $conn;
    public function __construct()
    {

global $servername,$dbname,$username,$password;
       try {
    $this->conn = new PDO("mysql:host=$servername;dbname=$dbname",$username, $password);
    // set the PDO error mode to exception
    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    }
    catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
    }


    function insert($data)
    {
        try {
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $collum = ['name', 'email', 'phone_no', 'hobbies', 'gender', 'website', 'address'];
            $collum = implode(",", $collum);
            $sql = "INSERT INTO detail ($collum)
        VALUES (?,?,?,?,?,?,?)";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute($data);

            echo "New record created successfully";
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }

    
    }
    function selectOne($searchId = null)
    {
        try {
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $where = "";
            if ($searchId != null) {
                $where = "WHERE id = $searchId";
            }
            $stmt = $this->conn->query("SELECT * FROM detail $where;");
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            die;
        }
    }
    function select($searchId = null)
    { 
         try {
               $where = "";
            if ($searchId != null) {
                if(is_numeric($searchId)){
                $where = "WHERE id = $searchId";
                }
                else {
                $where = "WHERE name='".$searchId."'";
                }
            }
             $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = isset($_GET['per-page']) && $_GET['per-page'] <= 50 ? (int)$_GET['per-page'] : 5;
//positioning
$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;
//query
$articles = $this->conn->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM detail LIMIT {$start},{$perPage}");
$articles->execute();
$articles = $articles->fetchAll(PDO::FETCH_ASSOC);
//pages
$total = $this->conn->query("SELECT FOUND_ROWS() as total")->fetch()['total'];
$pages = ceil($total / $perPage);
         echo "<br>";
            echo "<div class='container-fluid'>";
            echo "<table class='table table-striped' style='width:100%' >
                        <thead class='thead-dark'>
                            <tr>
                                <th scope='col'>Index</th>
                                <th scope='col'>Name</th>
                                <th scope='col'>Email</th>
                                <th scope='col'>Phone</th>
                                <th scope='col'>Hobbie</th>
                                <th scope='col'>Gender</th>
                                <th scope='col'>Website</th>
                                <th scope='col'>Address</th>
                                <th scope='col'></th>
                                <th scope='col'></th>
                            </tr>
                        </thead>";
				foreach ($articles as $article){
				echo "<div class='article'><p class='lead'>";
						echo "<tr>";
                echo "<td>", $article['id'], "</td>";
                echo "<td>", $article['name'], "</td>";
                echo "<td>", $article['email'], "</td>";
                echo "<td>", $article['phone_no'], "</td>";
                echo "<td>", $article['hobbies'], "</td>";
                echo "<td>", $article['gender'], "</td>";
                echo "<td>", $article['website'], "</td>";
                echo "<td>", $article['address'], "</td>";
                echo "<td> <form method='POST' action='index.php'>
                    <input type='hidden' name='action' value='delete' />
                    <input type='hidden'id='deleteID' name='deleteID' value=", $article['id'], " />
                    <button type='submit' class='btn btn-danger container' onclick='check()'  >delete</button></form></td>";
                echo "<td> <form method='GET' action='update.php'>
                        <input type='hidden' name='id' value=", $article['id'], " />
                    <button type='submit' class='btn btn-success '>Update</button></form></td>";
                echo "</tr>";
				} 
                echo "</table>";
            echo "</div>";
            echo "</div>";
			
        echo "<div style='margin-left: 500px;'>";

						for ($x=1; $x <= $pages; $x++){
						                        echo "<ul style='float:left;text-align: center' class='pagination'><li><a href='?page= $x &per-page= $perPage'>&nbsp$x&nbsp&nbsp&nbsp</a></li></ul>";
						}
	        echo"<div>";
	       
    
    }
    catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            die;
        }
}
    function validEmail($email)
    {
        global $table;
        try {
            
            $where = "WHERE email = '$email'";
            $stmt = $this->conn->query("SELECT * FROM $table $where;");
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            die;
        }
    }

    function update($id, $data)
    {
        global $table;
        
        // set the PDO error mode to exception
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $column = ['name', 'email', 'phone_no', 'hobbies', 'gender', 'website', 'address'];
        $finalArray = array_combine($column, $data);
        // print_r($finalArray);
        // die;

        $sqlData = [];
        foreach ($finalArray as $col => $val) {
            $sqlData[] = "$col='$val'";
        }
        
        $sql = "UPDATE $table SET " . implode(',', $sqlData) . "  WHERE id = $id";
        try {
            $stmt = $this->conn->exec($sql);
        } catch (PDOException $e) {
            echo '<br>Error found at line #' . $e->getLine() . ' at file ' . $e->getFile();
            echo $sql . "<br>" . $e->getMessage();
            die;
        }
        header('Location:index.php');
        die;
    }
    function check($sql)
    {
             $this->conn->query($sql);
            echo " done";
    }

    function delete($dID)
    {  
         try {
            $sql = "DELETE FROM detail WHERE id = $dID";
            

             $this->conn->query($sql);
            //echo "Record deleted successfully";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        
    }
}
$db = new Database();
