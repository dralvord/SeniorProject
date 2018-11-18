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
    $pcName = getValue("pcName", "");
    $pcLevel = getValue("pcLevel", "");
    $pcRace = getValue ("pcRace","");
    $pcClass = getValue ("pcClass","");
    $pcAlign = getValue ("pcAlign","");
    $pcAC = getValue ("pcAC","");
    $pcHP = getValue ("pcHP","");
    $pcSpeed = getValue ("pcSpeed","");
    $pcSTR = getValue ("pcSTR","");
    $pcDEX = getValue ("pcDEX","");
    $pcCON = getValue ("pcCON","");
    $pcINT = getValue ("pcINT","");
    $pcWIS = getValue ("pcWIS","");
    $pcCHA = getValue ("pcCHA","");
    $pcLanguages = getValue ("pcLanguages","");
    $pcSkills = getValue ("pcSkills","");
    $pcProfBonus = getValue ("pcProfBonus","");
    $pcSaveThrows = getValue("pcSaveThrows","");
    $pcAbilities = getValue ("pcAbilities","");
    $pcActions = getValue ("pcActions","");
    $pcBio = getValue ("pcBio","");
    $camID = getValue("camID", "");
    //$user = getValue("UserID", "");
    
    if ($pcName != "" && $pcLevel != "" && $pcRace != "" && $pcClass != "" && $pcAlign != "" && $pcAC != "" && $pcHP != "" && $pcSpeed != "" && $pcSTR != ""  && $pcDEX != "" && $pcCON != "" && $pcINT != "" && $pcWIS != "" && $pcCHA != ""  &&$pcBio != "" && $camID !="" /*&& $user != ""*/)
    { //Checks to make sure all essential values are not null
        
        $stmt = $conn->prepare("INSERT INTO PC(PC_NAME, PC_LEVEL, PC_RACE, PC_CLASS, PC_ALIGN, PC_AC, PC_HP, PC_SPEED, PC_STR, PC_DEX, PC_CON, PC_INT, PC_WIS, PC_CHA, PC_LANGUAGES, PC_SKILLS, PC_PROFBONUS, PC_SAVETHROWS, PC_ABILITIES, PC_ACTIONS ,PC_BIO, CAM_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sisssssssssssssssssssi", $pcName, $pcLevel, $pcRace, $pcClass, $pcAlign, $pcAC, $pcHP, $pcSpeed, $pcSTR, $pcDEX, $pcCON, $pcINT, $pcWIS, $pcCHA, $pcLanguages, $pcSkills, $pcProfBonus, $pcSaveThrows, $pcAbilities, $pcActions, $pcBio, $camID);
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
    //$user = getValue("UserID", "");
    //if($user != "")
    //{
    if($camID != "")
    {
        $stmt = $conn->prepare("SELECT * FROM PC WHERE CAM_ID = ? ORDER BY PC_NAME");
        $stmt->bind_param("i", $camID);
        $stmt->execute();
        $stmt->bind_result($pcID,$pcName,$pcLevel,$pcRace,$pcClass,$pcAlign,$pcAC,$pcHP,$pcSpeed,$pcSTR,$pcDEX,$pcCON,$pcINT,$pcWIS,$pcCHA,$pcLanguages,$pcSkills,$pcProfBonus,$pcSaveThrows,$pcAbilities,$pcActions,$pcBio,$camID);
        
        
        $rows = array();
        while($stmt->fetch())
        {
            $pcStats = createStats($pcName,$pcLevel,$pcRace,$pcClass,$pcAlign,$pcAC,$pcHP,$pcSpeed,$pcSTR,$pcDEX,$pcCON,$pcINT,$pcWIS,$pcCHA,$pcLanguages,$pcSkills,$pcProfBonus,$pcSaveThrows,$pcAbilities,$pcActions,$pcBio);
            $row = array("PCID"=>$pcID, "PCName"=>$pcName, "PCLevel"=>$pcLevel, "PCRace"=>$pcRace, "PCClass"=>$pcClass, "PCAlign"=>$pcAlign, "PCAC"=>$pcAC, "PCHP"=>$pcHP, "PCSpeed"=>$pcSpeed, "PCSTR"=>$pcSTR, "PCDEX"=>$pcDEX, "PCCON"=>$pcCON,"PCINT"=>$pcINT, "PCWIS"=>$pcWIS, "PCCHA"=>$pcCHA, "PCLanguages"=>$pcLanguages, "PCSkills"=>$pcSkills,"PCProfBonus"=>$pcProfBonus, "PCSaveThrows"=>$pcSaveThrows, "PCAbilities"=>$pcAbilities, "PCActions"=>$pcActions, "PCBio"=>$pcBio, "CampaignID"=>$camID, "PCStats"=>$pcStats);
            $rows[] = $row;
        }
    
        
        return $rows;
    }
    else{
        return array("error"=>"camID required");
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
        $stmt = $conn->prepare("SELECT * FROM PC");
        $stmt->execute();
        $stmt->bind_result($pcID,$pcName,$pcLevel,$pcRace,$pcClass,$pcAlign,$pcAC,$pcHP,$pcSpeed,$pcSTR,$pcDEX,$pcCON,$pcINT,$pcWIS,$pcCHA,$pcLanguages,$pcSkills,$pcProfBonus,$pcSaveThrows,$pcAbilities,$pcActions,$pcBio,$camID);
        
        
        $rows = array();
        while($stmt->fetch())
        {
            $pcStats = createStats($pcName,$pcLevel,$pcRace,$pcClass,$pcAlign,$pcAC,$pcHP,$pcSpeed,$pcSTR,$pcDEX,$pcCON,$pcINT,$pcWIS,$pcCHA,$pcLanguages,$pcSkills,$pcProfBonus,$pcSaveThrows,$pcAbilities,$pcActions,$pcBio);
            $row = array("PCID"=>$pcID, "PCName"=>$pcName, "PCLevel"=>$pcLevel, "PCRace"=>$pcRace, "PCClass"=>$pcClass, "PCAlign"=>$pcAlign, "PCAC"=>$pcAC, "PCHP"=>$pcHP, "PCSpeed"=>$pcSpeed, "PCSTR"=>$pcSTR, "PCDEX"=>$pcDEX, "PCCON"=>$pcCON,"PCINT"=>$pcINT, "PCWIS"=>$pcWIS, "PCCHA"=>$pcCHA, "PCLanguages"=>$pcLanguages, "PCSkills"=>$pcSkills,"PCProfBonus"=>$pcProfBonus, "PCSaveThrows"=>$pcSaveThrows, "PCAbilities"=>$pcAbilities, "PCActions"=>$pcActions, "PCBio"=>$pcBio, "CampaignID"=>$camID, "PCStats"=>$pcStats);
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
    $pcID = getValue("pcID", "");
    $pcName = getValue("pcName", "");
    $pcLevel = getValue("pcLevel", "");
    $pcRace = getValue ("pcRace","");
    $pcClass = getValue ("pcClass","");
    $pcAlign = getValue ("pcAlign","");
    $pcAC = getValue ("pcAC","");
    $pcHP = getValue ("pcHP","");
    $pcSpeed = getValue ("pcSpeed","");
    $pcSTR = getValue ("pcSTR","");
    $pcDEX = getValue ("pcDEX","");
    $pcCON = getValue ("pcCON","");
    $pcINT = getValue ("pcINT","");
    $pcWIS = getValue ("pcWIS","");
    $pcCHA = getValue ("pcCHA","");
    $pcLanguages = getValue ("pcLanguages","");
    $pcSkills = getValue ("pcSkills","");
    $pcProfBonus = getValue ("pcProfBonus","");
    $pcSaveThrows = getValue("pcSaveThrows","");
    $pcAbilities = getValue ("pcAbilities","");
    $pcActions = getValue ("pcActions","");
    $pcBio = getValue ("pcBio","");
    $camID = getValue("camID", "");
    //$user = getValue("UserID", "");
    
    if ($pcID != "")
    {
        /* This depends on what my model contains. If it holds all of the current monster values and the updated then I don't need to do this
        if($monName != "")
        {
            $stmt = $conn->prepare("UPDATE MONSTER SET MON_NAME = ? WHERE MON_ID = ?");
            $stmt->bind_param("si", $monName, $monID);
            $stmt->execute();
        }
        */
        
        $stmt = $conn->prepare("UPDATE PC SET PC_NAME = ?, PC_LEVEL = ?, PC_RACE = ?, PC_CLASS = ?, PC_ALIGN = ?, PC_AC = ?, PC_HP = ?, PC_SPEED = ?, PC_STR = ?, PC_DEX = ?, PC_CON = ?, PC_INT = ?, PC_WIS = ?, PC_CHA = ?, PC_LANGUAGES = ?, PC_SKILLS = ?, PC_PROFBONUS = ?, PC_SAVETHROWS = ?, PC_ABILITIES = ?, PC_ACTIONS = ?, PC_BIO = ?, CAM_ID = ? WHERE PC_ID = ?");
        $stmt->bind_param("sisssssssssssssssssssii", $pcName, $pcLevel, $pcRace, $pcClass, $pcAlign, $pcAC, $pcHP, $pcSpeed, $pcSTR, $pcDEX, $pcCON, $pcINT, $pcWIS, $pcCHA, $pcLanguages, $pcSkills, $pcProfBonus, $pcSaveThrows, $pcAbilities, $pcActions, $pcBio, $camID, $pcID);
        $stmt->execute();
        return read($conn);
    }
    else 
    {
        return array("error"=>"PC ID required");    
    }
}

function delete($conn)
{
    $pcID = getValue("pcID", "");

    if ($pcID != "")
    {
        $stmt = $conn->prepare("DELETE FROM PC WHERE PC_ID = ?");
        $stmt->bind_param("i", $pcID);
        $stmt->execute();
        return read($conn);
    }
    else 
    {
        return array("error"=>"PC ID required");    
    }
}

function createStats($pcName,$pcLevel,$pcRace,$pcClass,$pcAlign,$pcAC,$pcHP,$pcSpeed,$pcSTR,$pcDEX,$pcCON,$pcINT,$pcWIS,$pcCHA,$pcLanguages,$pcSkills,$pcProfBonus,$pcSaveThrows,$pcAbilities,$pcActions,$pcBio)
{
    $stats = "PC Name: " . $pcName . "\n" .
             "PC Level: " . $pcLevel . "\n" .
             "PC Race: " . $pcRace . "\n" . 
             "PC Class: " . $pcClass . "\n" .
             "PC Align: " . $pcAlign . "\n" .
             "PC AC: " . $pcAC . "\n" . 
             "PC HP: " . $pcHP . "\n" .
             "PC Speed: " . $pcSpeed . "\n" .
             "PC STR: " . $pcSTR . "\n" .
             "PC DEX: " . $pcDEX . "\n" .
             "PC CON: " . $pcCON . "\n" .
             "PC INT: " . $pcINT . "\n" .
             "PC WIS: " . $pcWIS . "\n" .
             "PC CHA: " . $pcCHA . "\n" .
             "PC Languages: " . $pcLanguages . "\n" . 
             "PC Skills: " . $pcSkills . "\n" . 
             "PC ProfBonus: " . $pcProfBonus . "\n" . 
             "PC SaveThrows: " . $pcSaveThrows . "\n" . 
             "PC Abilities: " . $pcAbilities . "\n" . 
             "PC Actions: " . $pcActions . "\n" . 
             "PC Bio: " . $pcBio . "\n";
    return $stats;
}



?>
