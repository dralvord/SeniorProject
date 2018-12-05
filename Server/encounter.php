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
    $userID = getSessionValue("user","")["userID"];
    
    if ($encName != "" && $encDesc != "" && $actID != ""&& $userID != "")
    {
        $stmt = $conn->prepare("INSERT INTO ENCOUNTER(ENC_NAME, ENC_DESC, ACT_ID, USER_ID) VALUES (?, ?,?, ?)");
        $stmt->bind_param("ssii", $encName, $encDesc, $actID, $userID);
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
    $userID = getSessionValue("user","")["userID"];
    if($userID != "")
    {
        if($actID != "")
        {
            $stmt = $conn->prepare("SELECT ENC_ID, ENC_NAME, ENC_DESC, ACT_ID FROM ENCOUNTER WHERE ACT_ID = ? AND USER_ID = ?");
            $stmt->bind_param("ii", $actID, $userID);
            $stmt->execute();
            $stmt->bind_result($encID,$encName,$encDesc,$actID);
            
            $rows = array();
            while($stmt->fetch())
            {
                $row = array("EncID"=>$encID, "EncName"=>htmlspecialchars($encName,ENT_QUOTES), "EncDesc"=>htmlspecialchars($encDesc,ENT_QUOTES), "ActID"=>$actID);
                $rows[] = $row;
            }
    
            return $rows;
        }
        else
        {
            return array("error"=>"actID required");
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
        $stmt = $conn->prepare("SELECT ENC_ID, ENC_NAME, ENC_DESC, ACT_ID FROM ENCOUNTER WHERE USER_ID = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $stmt->bind_result($encID,$encName,$encDesc,$actID);
        
        
        $rows = array();
        while($stmt->fetch())
        {
            $row = array("EncID"=>$encID, "EncName"=>htmlspecialchars($encName,ENT_QUOTES), "EncDesc"=>htmlspecialchars($encDesc,ENT_QUOTES), "ActID"=>$actID);
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
    $encID = getValue("encID", "");
    $encName = getValue("encName", "");
    $encDesc = getValue("encDesc", "");
    $actID = getValue("actID", "");
    $userID = getSessionValue("user","")["userID"];
    
    
    if ($encID != "" && $encName != "" && $encDesc != "" && $actID != "" && $userID != "")
    {
        $stmt = $conn->prepare("UPDATE ENCOUNTER SET ENC_NAME = ?, ENC_DESC = ?, ACT_ID = ? WHERE ENC_ID = ? AND USER_ID = ?");
        $stmt->bind_param("ssiii", $encName, $encDesc, $actID, $encID, $userID);
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
    $userID = getSessionValue("user","")["userID"];

    if ($encID != "" && $userID != "")
    {
        $stmt = $conn->prepare("DELETE FROM ENCOUNTER WHERE ENC_ID = ? && USER_ID = ?");
        $stmt->bind_param("ii", $encID, $userID);
        $stmt->execute();
        return read($conn);
    }
    else 
    {
        return array("error"=>"All fields are required");    
    }
}



?>
