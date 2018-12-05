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
    $advName = getValue("advName", "");
    $advDesc = getValue("advDesc", "");
    $camID = getValue("camID", "");
    $userID = getSessionValue("user","")["userID"];
    
    if ($advName != "" && $advDesc != "" && $camID != "" & $userID != "")
    {
        $stmt = $conn->prepare("INSERT INTO ADVENTURE(ADV_NAME, ADV_DESC, CAM_ID, USER_ID) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $advName, $advDesc, $camID, $userID);
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
    $camID = getValue("camID", "");
    $userID = getSessionValue("user","")["userID"];
    if($userID != "")
    {
        if($camID != "")
        {
            $stmt = $conn->prepare("SELECT ADV_ID, ADV_NAME, ADV_DESC FROM ADVENTURE WHERE CAM_ID = ? AND USER_ID = ?");
            $stmt->bind_param("ii", $camID, $userID);
            $stmt->execute();
            $stmt->bind_result($advID,$advName,$advDesc);
            $rows = array();
            while($stmt->fetch())
            {
                $row = array("AdventureID"=>$advID, "AdventureName"=>htmlspecialchars($advName,ENT_QUOTES), "AdventureDescription"=>htmlspecialchars($advDesc,ENT_QUOTES), "CampaignID"=>$camID);
                $rows[] = $row;
            }
    
            return $rows;
        }
        else
        {
            return array("error"=>"camID required");
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
        $stmt = $conn->prepare("SELECT ADV_ID, ADV_NAME,ADV_DESC, CAM_ID FROM ADVENTURE WHERE USER_ID = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $stmt->bind_result($advID,$advName,$advDesc,$camID);
        
        
        $rows = array();
        while($stmt->fetch())
        {
            $row = array("AdventureID"=>$advID, "AdventureName"=>htmlspecialchars($advName,ENT_QUOTES), "AdventureDescription"=>htmlspecialchars($advDesc,ENT_QUOTES), "CampaignID"=>$camID);
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
    $advID = getValue("advID", "");
    $advName = getValue("advName", "");
    $advDesc = getValue("advDesc", "");
    $camID = getValue("camID", "");
    $userID = getSessionValue("user","")["userID"];
    
    if ($advID != "" && $advName != "" && $advDesc != "" && $camID != "" && $userID != "")
    {
        $stmt = $conn->prepare("UPDATE ADVENTURE SET ADV_NAME = ?, ADV_DESC = ?, CAM_ID = ? WHERE ADV_ID = ? && USER_ID = ?");
        $stmt->bind_param("ssiii", $advName, $advDesc, $camID, $advID, $userID);
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
    $advID = getValue("advID", "");
    $userID = getSessionValue("user","")["userID"];

    if ($advID != "" && $userID != "")
    {
        $stmt = $conn->prepare("DELETE FROM ADVENTURE WHERE ADV_ID = ? AND USER_ID = ?");
        $stmt->bind_param("ii", $advID, $userID);
        $stmt->execute();
        return read($conn);
    }
    else 
    {
        return array("error"=>"All fields are required");    
    }
}



?>
