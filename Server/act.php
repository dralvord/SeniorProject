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
    $actName = getValue("actName", "");
    $actStory = getValue("actStory", "");
    $advID = getValue("advID", "");
    //$user = getValue("UserID", "");
    
    if ($actName != "" && $actStory != "" && $advID != ""/*&& $user != ""*/)
    {
        $stmt = $conn->prepare("INSERT INTO ACT(ACT_NAME, ACT_STORY, ADV_ID) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $actName, $actStory, $advID);
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
    $advID = getValue("advID","");
    //$user = getValue("UserID", "");
    //if($user != "")
    //{
    if($advID != "")
    {
        $stmt = $conn->prepare("SELECT * FROM ACT WHERE ADV_ID = ?");
        $stmt->bind_param("i", $advID);
        $stmt->execute();
        $stmt->bind_result($actID,$actName,$actStory,$advID);
        
        
        $rows = array();
        while($stmt->fetch())
        {
            $row = array("ActID"=>$actID, "ActName"=>$actName, "ActStory"=>$actStory, "AdventureID"=>$advID);
            $rows[] = $row;
        }

        
        return $rows;
    }
    else
    {
        return array("error"=>"advID required");    
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
        $stmt = $conn->prepare("SELECT * FROM ACT");
        $stmt->execute();
        $stmt->bind_result($actID,$actName,$actStory,$advID);
        
        
        $rows = array();
        while($stmt->fetch())
        {
            $row = array("ActID"=>$actID, "ActName"=>$actName, "ActStory"=>$actStory, "AdventureID"=>$advID);
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
    $actID = getValue("actID", "");
    $actName = getValue("actName", "");
    $actStory = getValue("actStory", "");
    $advID = getValue("advID", "");
    
    if ($actID != "" && $actName != "" && $actStory != "" && $advID != "")
    {
        $stmt = $conn->prepare("UPDATE ACT SET ACT_NAME = ?, ACT_STORY = ?, ADV_ID = ? WHERE ACT_ID = ?");
        $stmt->bind_param("ssii", $actName, $actStory, $advID, $actID);
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
    $actID = getValue("actID", "");

    if ($actID != "")
    {
        $stmt = $conn->prepare("DELETE FROM ACT WHERE ACT_ID = ?");
        $stmt->bind_param("i", $actID);
        $stmt->execute();
        return read($conn);
    }
    else 
    {
        return array("error"=>"All fields are required");    
    }
}



?>
