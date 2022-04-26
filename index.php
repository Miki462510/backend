<!DOCTYPE html>
<html>
<head>
    <title>gpdp</title>
</head>
<body>
<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
require("./connesssione.php");
$page=@$_GET["page"] ?? 0;
$size=@$_GET["size"] ?? 20;
$pezzi;
$query="select count(id) as tot from employees";
if ($result =$mysqli->query($query)) {
     while($row=$result->fetch_assoc()){
        $pezzi=$row["tot"];
    }
};

        switch($_SERVER['REQUEST_METHOD']){

            case 'GET':
                if(isset($_GET["page"])){
                    $page=$_GET["page"];
                  }
              
                  if(isset($_GET["size"])){
                    $size=$_GET["size"];
                  }
              
                  $limitA=$page*$size;
                  $totPagine=ceil($pezzi/$size);
                  $inizio= "http://localhost:8080?page=".$page."&size=".$size;
                  $indi=$totPagine-1;
                  $ultima = "http://localhost:8080?page=" . "?page=" . $indi . "&size=" . $size;

                  $query="select * from employees ORDER BY id LIMIT ".$limitA.",".$size."";
                  if($result=$mysqli->query($query)){
                    while($row=$result->fetch_assoc()){
                      $emparray[] = $row;
                    }
                  }
              
                  $prima=$page-1;
                  $prossima=$page+1;
              
                  if($page==0){
                    $tmpLinks=array(
                      "inizio" => array("href" => $inizio),
                      "ultima" => array("href" => $ultima),
                      "prossima" => array("href" => "http://localhost:8080?page=" . "?page=" . $prossima . "&size=" . $size)
                    );
                  }else if($page==$totTmp){
                    $tmpLinks=array(
                      "first" => array("href" => $inizio),
                      "last" => array("href" => $ultima),
                      "prima" => array("href" => "http://localhost:8080?page=" . "?page=" . $prima . "&size=" . $size)
                    );
              
                  }else if($page>0 && $page<$totTmp){
                    $tmpLinks=array(
                      "first" => array("href" => $inizio),
                      "last" => array("href" => $ultima),
                      "prossima" => array("href" => "http://localhost:8080?page=" . "?page=" . $prossima . "&size=" . $size),
                      "prima" => array("href" => "http://localhost:8080?page=" . "?page=" . $prima . "&size=" . $size)
                    );
                  }
              
                  $tmp=array(
                    "size" => $size,
                    "pezzi" => $pezzi,
                    "tot_Pagina" => $totPagina,
                    "number" => $page
                  );
                  $data = json_encode($array, JSON_UNESCAPED_SLASHES);
    
                 
                  echo $data;
              

                break;
            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);

                 $query="INSERT INTO employees (id, birth_date, first_name, last_name, gender, hire_date)
                 VALUES ('0',
                ".$mysqli->real_escape_string($data['birth_date']).", 
                ".$mysqli->real_escape_string($data['first_name']).", 
                ".$mysqli->real_escape_string($data['last_name']).",
                ".$mysqli->real_escape_string($data['gender']).",
                ".$mysqli->real_escape_string($data['hire_date']).")";

                $mysqli->query($query);
                break;
            case 'PUT':
                $data = json_decode(file_get_contents('php://input'), true);

                $query="UPDATE employees
                SET birth_date = ".$mysqli->real_escape_string($data['birth_date']).",
                  first_name = ".$mysqli->real_escape_string($data['first_name']).", 
                  last_name = ".$mysqli->real_escape_string($data['last_name']).", 
                  gender = ".$mysqli->real_escape_string($data['gender']).", 
                  hire_date = ".$mysqli->real_escape_string($data['hire_date'])."
                WHERE employees.id = ".$mysqli->real_escape_string($data['id'])."";
            
                $mysqli->query($query);          
                break;
            case 'DELETE':
                if(!empty($_GET["id"])){
                    $id=$mysqli->real_escape_string($_GET["id"]);
                
                    $query="DELETE FROM employees WHERE employees.id = ".$id."";
                
                    $mysqli->query($query);
                    }
                break;
            default:
                header("HTTP/1.1 400 NOT FOUND");
                $mysqli->close()
                or die ("<br>Chiusura connessione fallita " . $mysqli->error . " ". $mysqli->errno);
                break;
            ;

        }

?>
</body>
</html>