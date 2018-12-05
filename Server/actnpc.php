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
    $userID = getSessionValue("user","")["userID"];
    
     
    if ($actID != "" && $npcID && $userID != "")
    {
        $stmt = $conn->prepare("INSERT INTO ACTNPC(ACT_ID, NPC_ID, USER_ID) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $actID, $npcID, $userID);
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
    $userID = getSessionValue("user","")["userID"];
    if($userID != "")
    {
        if($actID != "")
        {
            $stmt = $conn->prepare("SELECT ACTNPC_ID, ACT_ID, NPC_ID FROM ACTNPC WHERE ACT_ID = ? AND USER_ID = ?");
            $stmt->bind_param("ii", $actID, $userID);
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
        $stmt = $conn->prepare("SELECT ACTNPC_ID, ACT_ID, NPC_ID FROM ACTNPC WHERE USER_ID = ?");
        $stmt->bind_param("i", $userID);
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
    else {
        return array("error"=>"User does not exist");
    }
    
}

function update($conn)
{
    $actNPCID = getValue("actNPCID", "");
    $actID = getValue("actID", "");
    $npcID = getValue("npcID", "");
    $userID = getSessionValue("user","")["userID"];
    

    if ($actNPCID != "" && $actID != "" && $npcID != "" && $userID != "")
    {
        $stmt = $conn->prepare("UPDATE ACTNPC SET ACT_ID = ?, NPC_ID = ? WHERE ACTNPC_ID = ? AND USER_ID = ?");
        $stmt->bind_param("iiii", $actID, $npcID, $actNPCID, $userID);
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
    $userID = getSessionValue("user","")["userID"];

    if ($npcID != "" && $actID != "" && $userID != "")
    {
        $stmt = $conn->prepare("DELETE FROM ACTNPC WHERE NPC_ID = ? AND ACT_ID = ? AND USER_ID = ?");
        $stmt->bind_param("iii", $npcID, $actID, $userID);
        $stmt->execute();
        return read($conn);
    }
    else 
    {
        return array("error"=>"All fields are required");    
    }
}



?>
