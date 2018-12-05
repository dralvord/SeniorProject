
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

else // list all supported commands
{
  echo
  "
  ";
}

function create($conn)
{
    $camName = getValue("camName", "");
    $camDesc = getValue("camDesc", "");
    $userID = getSessionValue("user","")["userID"];
    if ($camName != "" && $camDesc != "" && $userID != "")
    {
        $stmt = $conn->prepare("INSERT INTO CAMPAIGN(CAM_NAME, CAM_DESC,USER_ID) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $camName, $camDesc, $userID);
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
    $userID = getSessionValue("user","")["userID"];
    if($userID != "")
    {
        $stmt = $conn->prepare("SELECT CAM_ID, CAM_NAME, CAM_DESC FROM CAMPAIGN WHERE USER_ID = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $stmt->bind_result($camID,$camName,$camDesc);
        
        
        $rows = array();
        while($stmt->fetch())
        {
            $row = array("CampaignID"=>$camID, "CampaignName"=>htmlspecialchars($camName,ENT_QUOTES), "CampaignDescription"=>htmlspecialchars($camDesc,ENT_QUOTES));
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
    $camID = getValue("camID", "");
    $camName = getValue("camName", "");
    $camDesc = getValue("camDesc", "");
    $userID = getSessionValue("user","")["userID"];
    
    if ($camID != "" && $camName != "" && $camDesc != "" & $userID != "")
    {
        $stmt = $conn->prepare("UPDATE CAMPAIGN SET CAM_NAME = ?, CAM_DESC = ? WHERE CAM_ID = ? AND USER_ID = ?");
        $stmt->bind_param("ssii", $camName, $camDesc, $camID, $userID);
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
    $camID = getValue("camID", "");
    $userID = getSessionValue("user","")["userID"];

    if ($camID != "" && $userID != "")
    {
        $stmt = $conn->prepare("DELETE FROM CAMPAIGN WHERE CAM_ID = ? AND USER_ID = ?");
        $stmt->bind_param("ii", $camID, $userID);
        $stmt->execute();
        return read($conn);
    }
    else 
    {
        return array("error"=>"All fields are required");    
    }
}



?>
