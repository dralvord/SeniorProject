<?php
require_once "functions.php";
require_once 'dblogin.php';

session_start();
header("Access-Control-Allow-Origin: *");

// Create connection
$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$cmd = getValue("cmd", "");
if ($cmd == "create")
{
    $response = create($conn);
    header('Content-type: application/json');
    echo json_encode($response);
}
else if ($cmd == "read")
{
    $response = read($conn);
    header('Content-type: application/json');
    echo json_encode($response);
}
else if ($cmd == "update")
{
    $response = update($conn);
    header('Content-type: application/json');
    echo json_encode($response);
}
else if ($cmd == "delete")
{
    $response = delete($conn);
    header('Content-type: application/json');
    echo json_encode($response);
}
else if ($cmd == "readAll")
{
    $response = readAll($conn);
    header('Content-type: application/json');
    echo json_encode($response);
}

else // list all supported commands
{
  echo
  "
  ";
}

function create($conn)
{
    $monID = getValue("monID", "");
    $encID = getValue("encID", "");
    //$user = getValue("UserID", "");
    
    if ($encID != "" && $monID != ""/*&& $user != ""*/)
    {
        $stmt = $conn->prepare("INSERT INTO ENCMON(MON_ID, ENC_ID) VALUES (?, ?)");
        $stmt->bind_param("ii", $monID, $encID);
        $stmt->execute();
        return read($conn);
    }
    else 
    {
        return array("error"=>"All fields are required");    
    }
}

function read($conn)
{
    $encID = getValue("encID", "");
    //$user = getValue("UserID", "");
    //if($user != "")
    //{
    if($encID != "")
    {
        $stmt = $conn->prepare("SELECT * FROM ENCMON WHERE ENC_ID = ?");
        $stmt->bind_param("i", $encID);
        $stmt->execute();
        $stmt->bind_result($encMonID,$monID,$encID);
        
        
        $rows = array();
        while($stmt->fetch())
        {
            $row = array("EncMonID"=>$encMonID, "MonID"=>$monID, "EncID"=>$encID);
            $rows[] = $row;
        }
    
        
        return $rows;
    }
    else{
        return array("error"=>"encID required");
    }
    //}
    //else {
    //    return array("error"=>"User does not exist");
    //}
    
}

function readAll($conn)
{
    //$user = getValue("UserID", "");
    //if($user != "")
    //{
        $stmt = $conn->prepare("SELECT * FROM ENCMON");
        $stmt->execute();
        $stmt->bind_result($encMonID,$monID,$encID);
        
        
        $rows = array();
        while($stmt->fetch())
        {
            $row = array("EncMonID"=>$encMonID, "MonID"=>$monID, "EncID"=>$encID);
            $rows[] = $row;
        }
    
        
    return $rows;
    //}
    //else {
    //    return array("error"=>"User does not exist");
    //}
    
}


function update($conn)
{
    $encMonID = getValue("encMonID", "");
    $monID = getValue("monID", "");
    $encID = getValue("encID", "");

    if ($encMonID != "" && $encID != "" && $monID != "" )
    {
        $stmt = $conn->prepare("UPDATE ENCMON SET MON_ID = ?, ENC_ID = ? WHERE ENCMON_ID = ?");
        $stmt->bind_param("iii", $encID, $monID, $encMonID);
        $stmt->execute();
        return read($conn);
    }
    else 
    {
        return array("error"=>"All fields are required");    
    }
}

function delete($conn)
{
    $encMonID = getValue("encMonID", "");

    if ($encMonID != "")
    {
        $stmt = $conn->prepare("DELETE FROM ENCMON WHERE ENCMON_ID = ?");
        $stmt->bind_param("i", $encMonID);
        $stmt->execute();
        return read($conn);
    }
    else 
    {
        return array("error"=>"All fields are required");    
    }
}



?>
