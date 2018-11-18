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
    $encName = getValue("encName", "");
    $encDesc = getValue("encDesc", "");
    $actID = getValue("actID", "");
    //$user = getValue("UserID", "");
    
    if ($encName != "" && $encDesc != "" && $actID != ""/*&& $user != ""*/)
    {
        $stmt = $conn->prepare("INSERT INTO ENCOUNTER(ENC_NAME, ENC_DESC, ACT_ID) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $encName, $encDesc, $actID);
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
    $actID = getValue("actID", "");
    //$user = getValue("UserID", "");
    //if($user != "")
    //{
    if($actID != "")
    {
        $stmt = $conn->prepare("SELECT * FROM ENCOUNTER WHERE ACT_ID = ?");
        $stmt->bind_param("i", $actID);
        $stmt->execute();
        $stmt->bind_result($encID,$encName,$encDesc,$actID);
        
        
        $rows = array();
        while($stmt->fetch())
        {
            $row = array("EncID"=>$encID, "EncName"=>$encName, "EncDesc"=>$encDesc, "ActID"=>$actID);
            $rows[] = $row;
        }
    
        return $rows;
    }
    else
    {
        return array("error"=>"actID required");
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
        $stmt = $conn->prepare("SELECT * FROM ENCOUNTER");
        $stmt->execute();
        $stmt->bind_result($encID,$encName,$encDesc,$actID);
        
        
        $rows = array();
        while($stmt->fetch())
        {
            $row = array("EncID"=>$encID, "EncName"=>$encName, "EncDesc"=>$encDesc, "ActID"=>$actID);
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
    $encID = getValue("encID", "");
    $encName = getValue("encName", "");
    $encDesc = getValue("encDesc", "");
    $actID = getValue("actID", "");
    
    if ($encID != "" && $encName != "" && $encDesc != "" && $actID != "")
    {
        $stmt = $conn->prepare("UPDATE ENCOUNTER SET ENC_NAME = ?, ENC_DESC = ?, ACT_ID = ? WHERE ENC_ID = ?");
        $stmt->bind_param("ssii", $encName, $encDesc, $actID, $encID);
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
    $encID = getValue("encID", "");

    if ($encID != "")
    {
        $stmt = $conn->prepare("DELETE FROM ENCOUNTER WHERE ENC_ID = ?");
        $stmt->bind_param("i", $encID);
        $stmt->execute();
        return read($conn);
    }
    else 
    {
        return array("error"=>"All fields are required");    
    }
}



?>
