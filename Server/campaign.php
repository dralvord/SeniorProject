
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
    //$user = getValue("UserID", "");
    
    if ($camName != "" && $camDesc != "" /*&& $user != ""*/)
    {
        $stmt = $conn->prepare("INSERT INTO CAMPAIGN(CAM_NAME, CAM_DESC) VALUES (?, ?)");
        $stmt->bind_param("ss", $camName, $camDesc);
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
    //$user = getValue("UserID", "");
    //if($user != "")
    //{
        $stmt = $conn->prepare("SELECT * FROM CAMPAIGN");
        $stmt->execute();
        $stmt->bind_result($camID,$camName,$camDesc);
        
        
        $rows = array();
        while($stmt->fetch())
        {
            $row = array("CampaignID"=>$camID, "CampaignName"=>$camName, "CampaignDescription"=>$camDesc);
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
    $camID = getValue("camID", "");
    $camName = getValue("camName", "");
    $camDesc = getValue("camDesc", "");
    
    if ($camID != "" && $camName != "" && $camDesc != "")
    {
        $stmt = $conn->prepare("UPDATE CAMPAIGN SET CAM_NAME = ?, CAM_DESC = ? WHERE CAM_ID = ?");
        $stmt->bind_param("ssi", $camName, $camDesc, $camID);
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

    if ($camID != "")
    {
        $stmt = $conn->prepare("DELETE FROM CAMPAIGN WHERE CAM_ID = ?");
        $stmt->bind_param("i", $camID);
        $stmt->execute();
        return read($conn);
    }
    else 
    {
        return array("error"=>"All fields are required");    
    }
}



?>
