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
    $actID = getValue("actID", "");
    $npcID = getValue("npcID", "");
    //$user = getValue("UserID", "");
    
    if ($actID != "" && $npcID != ""/*&& $user != ""*/)
    {
        $stmt = $conn->prepare("INSERT INTO ACTNPC(ACT_ID, NPC_ID) VALUES (?, ?)");
        $stmt->bind_param("ii", $actID, $npcID);
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
    $actID = getValue("actID","");
    //$user = getValue("UserID", "");
    //if($user != "")
    //{
    if($actID != "")
    {
        $stmt = $conn->prepare("SELECT * FROM ACTNPC WHERE ACT_ID = ?");
        $stmt->bind_param("i", $actID);
        $stmt->execute();
        $stmt->bind_result($actNPCID,$actID,$npcID);
        
        
        $rows = array();
        while($stmt->fetch())
        {
            $row = array("ActNpcID"=>$actNPCID, "ActID"=>$actID, "NPCID"=>$npcID);
            $rows[] = $row;
        }
    
        
        return $rows;
    }
    else{
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
        $stmt = $conn->prepare("SELECT * FROM ACTNPC");
        $stmt->execute();
        $stmt->bind_result($actNPCID,$actID,$npcID);
        
        
        $rows = array();
        while($stmt->fetch())
        {
            $row = array("ActNpcID"=>$actNPCID, "ActID"=>$actID, "NPCID"=>$npcID);
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
    $actNPCID = getValue("actNPCID", "");
    $actID = getValue("actID", "");
    $npcID = getValue("npcID", "");

    if ($actNPCID != "" && $actID != "" && $npcID != "" )
    {
        $stmt = $conn->prepare("UPDATE ACTNPC SET ACT_ID = ?, NPC_ID = ? WHERE ACTNPC_ID = ?");
        $stmt->bind_param("iii", $actID, $npcID, $actNPCID);
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
    $npcID = getValue("npcID", "");
    $actID = getValue("actID", "");

    if ($npcID != "" && $actID != "")
    {
        $stmt = $conn->prepare("DELETE FROM ACTNPC WHERE NPC_ID = ? AND ACT_ID = ?");
        $stmt->bind_param("ii", $npcID, $actID);
        $stmt->execute();
        return read($conn);
    }
    else 
    {
        return array("error"=>"All fields are required");    
    }
}



?>
