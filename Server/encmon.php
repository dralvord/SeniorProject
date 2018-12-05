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
    $userID = getSessionValue("user","")["userID"];
    
    if ($encID != "" && $monID != "" && $userID != "")
    {
        $stmt = $conn->prepare("INSERT INTO ENCMON(MON_ID, ENC_ID, USER_ID) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $monID, $encID, $userID);
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
    $userID = getSessionValue("user","")["userID"];
    if($userID != "")
    {
        if($encID != "")
        {
            $stmt = $conn->prepare("SELECT * FROM ENCMON WHERE ENC_ID = ? AND USER_ID = ?");
            $stmt->bind_param("ii", $encID, $userID);
            $stmt->execute();
            $stmt->bind_result($encMonID,$monID,$encID,$userID);
            
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
    }
    else {
        return array("error"=>"User does not exist");
    }
}

function readAll($conn)
{
    $userID = getSessionValue("user","")["userID"];
    if($userID != "")
    {
        $stmt = $conn->prepare("SELECT * FROM ENCMON WHERE USER_ID = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $stmt->bind_result($encMonID,$monID,$encID,$userID);
        
        
        $rows = array();
        while($stmt->fetch())
        {
            $row = array("EncMonID"=>$encMonID, "MonID"=>$monID, "EncID"=>$encID);
            $rows[] = $row;
        }
    
        
    return $rows;
    }
    else {
        return array("error"=>"User does not exist");
    }
    
}


function update($conn)
{
    $encMonID = getValue("encMonID", "");
    $monID = getValue("monID", "");
    $encID = getValue("encID", "");
    $userID = getSessionValue("user","")["userID"];

    if ($encMonID != "" && $encID != "" && $monID != "" && $userID != "")
    {
        $stmt = $conn->prepare("UPDATE ENCMON SET MON_ID = ?, ENC_ID = ? WHERE ENCMON_ID = ? AND USER_ID = ?");
        $stmt->bind_param("iiii", $monID, $encID, $encMonID, $userID);
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
    $userID = getSessionValue("user","")["userID"];

    if ($encMonID != "" && $userID != "")
    {
        $stmt = $conn->prepare("DELETE FROM ENCMON WHERE ENCMON_ID = ? AND USER_ID = ?");
        $stmt->bind_param("ii", $encMonID, $userID);
        $stmt->execute();
        return read($conn);
    }
    else 
    {
        return array("error"=>"All fields are required");    
    }
}



?>
