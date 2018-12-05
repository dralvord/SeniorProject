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
    $userID = getSessionValue("user","")["userID"];
    
    if ($pcName != "" && $pcLevel != "" && $pcRace != "" && $pcClass != "" && $pcAlign != "" && $pcAC != "" && $pcHP != "" && $pcSpeed != "" && $pcSTR != ""  && $pcDEX != "" && $pcCON != "" && $pcINT != "" && $pcWIS != "" && $pcCHA != ""  &&$pcBio != "" && $camID !="" && $userID != "")
    { //Checks to make sure all essential values are not null
        
        $stmt = $conn->prepare("INSERT INTO PC(PC_NAME, PC_LEVEL, PC_RACE, PC_CLASS, PC_ALIGN, PC_AC, PC_HP, PC_SPEED, PC_STR, PC_DEX, PC_CON, PC_INT, PC_WIS, PC_CHA, PC_LANGUAGES, PC_SKILLS, PC_PROFBONUS, PC_SAVETHROWS, PC_ABILITIES, PC_ACTIONS ,PC_BIO, CAM_ID, USER_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssssssssssssssii", $pcName, $pcLevel, $pcRace, $pcClass, $pcAlign, $pcAC, $pcHP, $pcSpeed, $pcSTR, $pcDEX, $pcCON, $pcINT, $pcWIS, $pcCHA, $pcLanguages, $pcSkills, $pcProfBonus, $pcSaveThrows, $pcAbilities, $pcActions, $pcBio, $camID, $userID);
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
            $stmt = $conn->prepare("SELECT * FROM PC WHERE CAM_ID = ? AND USER_ID = ? ORDER BY PC_NAME");
            $stmt->bind_param("ii", $camID, $userID);
            $stmt->execute();
            $stmt->bind_result($pcID,$pcName,$pcLevel,$pcRace,$pcClass,$pcAlign,$pcAC,$pcHP,$pcSpeed,$pcSTR,$pcDEX,$pcCON,$pcINT,$pcWIS,$pcCHA,$pcLanguages,$pcSkills,$pcProfBonus,$pcSaveThrows,$pcAbilities,$pcActions,$pcBio,$camID, $userID);
        
            $rows = array();
            while($stmt->fetch())
            {
                $pcStats = createStats($pcName,$pcLevel,$pcRace,$pcClass,$pcAlign,$pcAC,$pcHP,$pcSpeed,$pcSTR,$pcDEX,$pcCON,$pcINT,$pcWIS,$pcCHA,$pcLanguages,$pcSkills,$pcProfBonus,$pcSaveThrows,$pcAbilities,$pcActions,$pcBio);
                $row = array("PCID"=>$pcID, "PCName"=>htmlspecialchars($pcName,ENT_QUOTES), "PCLevel"=>htmlspecialchars($pcLevel,ENT_QUOTES), "PCRace"=>htmlspecialchars($pcRace,ENT_QUOTES), "PCClass"=>htmlspecialchars($pcClass,ENT_QUOTES), "PCAlign"=>htmlspecialchars($pcAlign,ENT_QUOTES), "PCAC"=>htmlspecialchars($pcAC,ENT_QUOTES), "PCHP"=>htmlspecialchars($pcHP,ENT_QUOTES), "PCSpeed"=>htmlspecialchars($pcSpeed,ENT_QUOTES), "PCSTR"=>htmlspecialchars($pcSTR,ENT_QUOTES), "PCDEX"=>htmlspecialchars($pcDEX,ENT_QUOTES), "PCCON"=>htmlspecialchars($pcCON,ENT_QUOTES),"PCINT"=>htmlspecialchars($pcINT,ENT_QUOTES), "PCWIS"=>htmlspecialchars($pcWIS,ENT_QUOTES), "PCCHA"=>htmlspecialchars($pcCHA,ENT_QUOTES), "PCLanguages"=>htmlspecialchars($pcLanguages,ENT_QUOTES), "PCSkills"=>htmlspecialchars($pcSkills,ENT_QUOTES),"PCProfBonus"=>htmlspecialchars($pcProfBonus,ENT_QUOTES), "PCSaveThrows"=>htmlspecialchars($pcSaveThrows,ENT_QUOTES), "PCAbilities"=>htmlspecialchars($pcAbilities,ENT_QUOTES), "PCActions"=>htmlspecialchars($pcActions,ENT_QUOTES), "PCBio"=>htmlspecialchars($pcBio,ENT_QUOTES), "CampaignID"=>$camID, "PCStats"=>htmlspecialchars($pcStats,ENT_QUOTES));
                $rows[] = $row;
            }
            return $rows;
        }
        else{
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
        $stmt = $conn->prepare("SELECT * FROM PC WHERE USER_ID = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $stmt->bind_result($pcID,$pcName,$pcLevel,$pcRace,$pcClass,$pcAlign,$pcAC,$pcHP,$pcSpeed,$pcSTR,$pcDEX,$pcCON,$pcINT,$pcWIS,$pcCHA,$pcLanguages,$pcSkills,$pcProfBonus,$pcSaveThrows,$pcAbilities,$pcActions,$pcBio,$camID, $userID);
        
        
        $rows = array();
        while($stmt->fetch())
        {
            $pcStats = createStats($pcName,$pcLevel,$pcRace,$pcClass,$pcAlign,$pcAC,$pcHP,$pcSpeed,$pcSTR,$pcDEX,$pcCON,$pcINT,$pcWIS,$pcCHA,$pcLanguages,$pcSkills,$pcProfBonus,$pcSaveThrows,$pcAbilities,$pcActions,$pcBio);
            $row = array("PCID"=>$pcID, "PCName"=>htmlspecialchars($pcName,ENT_QUOTES), "PCLevel"=>htmlspecialchars($pcLevel,ENT_QUOTES), "PCRace"=>htmlspecialchars($pcRace,ENT_QUOTES), "PCClass"=>htmlspecialchars($pcClass,ENT_QUOTES), "PCAlign"=>htmlspecialchars($pcAlign,ENT_QUOTES), "PCAC"=>htmlspecialchars($pcAC,ENT_QUOTES), "PCHP"=>htmlspecialchars($pcHP,ENT_QUOTES), "PCSpeed"=>htmlspecialchars($pcSpeed,ENT_QUOTES), "PCSTR"=>htmlspecialchars($pcSTR,ENT_QUOTES), "PCDEX"=>htmlspecialchars($pcDEX,ENT_QUOTES), "PCCON"=>htmlspecialchars($pcCON,ENT_QUOTES),"PCINT"=>htmlspecialchars($pcINT,ENT_QUOTES), "PCWIS"=>htmlspecialchars($pcWIS,ENT_QUOTES), "PCCHA"=>htmlspecialchars($pcCHA,ENT_QUOTES), "PCLanguages"=>htmlspecialchars($pcLanguages,ENT_QUOTES), "PCSkills"=>htmlspecialchars($pcSkills,ENT_QUOTES),"PCProfBonus"=>htmlspecialchars($pcProfBonus,ENT_QUOTES), "PCSaveThrows"=>htmlspecialchars($pcSaveThrows,ENT_QUOTES), "PCAbilities"=>htmlspecialchars($pcAbilities,ENT_QUOTES), "PCActions"=>htmlspecialchars($pcActions,ENT_QUOTES), "PCBio"=>htmlspecialchars($pcBio,ENT_QUOTES), "CampaignID"=>$camID, "PCStats"=>htmlspecialchars($pcStats,ENT_QUOTES));
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
    $userID = getSessionValue("user","")["userID"];
    
    if ($pcID != "")
    {
        $stmt = $conn->prepare("UPDATE PC SET PC_NAME = ?, PC_LEVEL = ?, PC_RACE = ?, PC_CLASS = ?, PC_ALIGN = ?, PC_AC = ?, PC_HP = ?, PC_SPEED = ?, PC_STR = ?, PC_DEX = ?, PC_CON = ?, PC_INT = ?, PC_WIS = ?, PC_CHA = ?, PC_LANGUAGES = ?, PC_SKILLS = ?, PC_PROFBONUS = ?, PC_SAVETHROWS = ?, PC_ABILITIES = ?, PC_ACTIONS = ?, PC_BIO = ?, CAM_ID = ? WHERE PC_ID = ? AND USER_ID = ?");
        $stmt->bind_param("sssssssssssssssssssssiii", $pcName, $pcLevel, $pcRace, $pcClass, $pcAlign, $pcAC, $pcHP, $pcSpeed, $pcSTR, $pcDEX, $pcCON, $pcINT, $pcWIS, $pcCHA, $pcLanguages, $pcSkills, $pcProfBonus, $pcSaveThrows, $pcAbilities, $pcActions, $pcBio, $camID, $pcID, $userID);
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
    $camID = getValue("camID", "");
    $userID = getSessionValue("user","")["userID"];
    
    if ($pcID != "" && $userID != "")
    {
        $stmt = $conn->prepare("DELETE FROM PC WHERE PC_ID = ? AND USER_ID = ?");
        $stmt->bind_param("ii", $pcID, $userID);
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
    $stats = "<strong><u>PC Name:</strong></u> " . $pcName . "\n" .
             "<strong><u>PC Level:</strong></u> " . $pcLevel . "\n" .
             "<strong><u>PC Race:</strong></u> " . $pcRace . "\n" . 
             "<strong><u>PC Class:</strong></u> " . $pcClass . "\n" .
             "<strong><u>PC Align:</strong></u> " . $pcAlign . "\n" .
             "<strong><u>PC AC:</strong></u> " . $pcAC . "\n" . 
             "<strong><u>PC HP:</strong></u> " . $pcHP . "\n" .
             "<strong><u>PC Speed:</strong></u> " . $pcSpeed . "\n" .
             "<strong><u>PC STR:</strong></u> " . $pcSTR . "\n" .
             "<strong><u>PC DEX:</strong></u> " . $pcDEX . "\n" .
             "<strong><u>PC CON:</strong></u> " . $pcCON . "\n" .
             "<strong><u>PC INT:</strong></u> " . $pcINT . "\n" .
             "<strong><u>PC WIS:</strong></u> " . $pcWIS . "\n" .
             "<strong><u>PC CHA:</strong></u> " . $pcCHA . "\n" .
             "<strong><u>PC Languages:</strong></u> " . $pcLanguages . "\n" . 
             "<strong><u>PC Skills:</strong></u> " . $pcSkills . "\n" . 
             "<strong><u>PC ProfBonus:</strong></u> " . $pcProfBonus . "\n" . 
             "<strong><u>PC SaveThrows:</strong></u> " . $pcSaveThrows . "\n" . 
             "<strong><u>PC Abilities:</strong></u> " . $pcAbilities . "\n\n" . 
             "<strong><u>PC Actions:</strong></u> " . $pcActions . "\n\n" . 
             "<strong><u>PC Bio:</strong></u> " . $pcBio . "\n";
    return $stats;
}



?>
