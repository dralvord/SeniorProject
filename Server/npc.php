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
else if ($cmd == "readAct")
{
    $response = readAct($conn);
    header('Content-type: application/json');
    echo json_encode($response);
}

else if ($cmd == "npcDropdown")
{
    $response = npcDropdown($conn);
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
    $npcName = getValue("npcName", "");
    $npcLevel = getValue("npcLevel", "");
    $npcRace = getValue ("npcRace","");
    $npcClass = getValue ("npcClass","");
    $npcAlign = getValue ("npcAlign","");
    $npcAC = getValue ("npcAC","");
    $npcHP = getValue ("npcHP","");
    $npcSpeed = getValue ("npcSpeed","");
    $npcSTR = getValue ("npcSTR","");
    $npcDEX = getValue ("npcDEX","");
    $npcCON = getValue ("npcCON","");
    $npcINT = getValue ("npcINT","");
    $npcWIS = getValue ("npcWIS","");
    $npcCHA = getValue ("npcCHA","");
    $npcLanguages = getValue ("npcLanguages","");
    $npcCR = getValue ("npcCR","");
    $npcSkills = getValue ("npcSkills","");
    $npcProfBonus = getValue ("npcProfBonus","");
    $npcSaveThrows = getValue("npcSaveThrows","");
    $npcAbilities = getValue ("npcAbilities","");
    $npcActions = getValue ("npcActions","");
    $npcBio = getValue ("npcBio","");
    $camID = getValue("camID", "");
    $userID = getSessionValue("user","")["userID"];
    
    if ($npcName != "" && $npcLevel != "" && $npcRace != "" && $npcClass != "" && $npcAlign != "" && $npcAC != "" && $npcHP != "" && $npcSpeed != "" && $npcSTR != ""  && $npcDEX != "" && $npcCON != "" && $npcINT != "" && $npcWIS != "" && $npcCHA != "" && $npcLanguages != "" && $npcCR != "" && $npcSkills != "" && $npcProfBonus != "" && $npcSaveThrows != "" && $npcAbilities != "" && $npcActions != "" &&$npcBio != "" && $camID !="" && $userID != "")
    { //Checks to make sure all essential values are not null
        
        $stmt = $conn->prepare("INSERT INTO NPC(NPC_NAME, NPC_LEVEL, NPC_RACE, NPC_CLASS, NPC_ALIGN, NPC_AC, NPC_HP, NPC_SPEED, NPC_STR, NPC_DEX, NPC_CON, NPC_INT, NPC_WIS, NPC_CHA, NPC_LANGUAGES, NPC_CR, NPC_SKILLS, NPC_PROFBONUS, NPC_SAVETHROWS, NPC_ABILITIES, NPC_ACTIONS, NPC_BIO, CAM_ID, USER_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssssssssssssssii", $npcName, $npcLevel, $npcRace, $npcClass, $npcAlign, $npcAC, $npcHP, $npcSpeed, $npcSTR, $npcDEX, $npcCON, $npcINT, $npcWIS, $npcCHA, $npcLanguages, $npcCR, $npcSkills, $npcProfBonus, $npcSaveThrows, $npcAbilities, $npcActions, $npcBio, $camID, $userID);
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
            $stmt = $conn->prepare("SELECT * FROM NPC WHERE CAM_ID = ? AND USER_ID = ? ORDER BY NPC_NAME");
            $stmt->bind_param("ii", $camID,$userID);
            $stmt->execute();
            $stmt->bind_result($npcID,$npcName,$npcLevel,$npcRace,$npcClass,$npcAlign,$npcAC,$npcHP,$npcSpeed,$npcSTR,$npcDEX,$npcCON,$npcINT,$npcWIS,$npcCHA,$npcLanguages,$npcCR,$npcSkills,$npcProfBonus,$npcSaveThrows,$npcAbilities,$npcActions,$npcBio,$camID,$userID);
        
        
            $rows = array();
            while($stmt->fetch())
            {
                $npcStats = createStats($npcName,$npcLevel,$npcRace,$npcClass,$npcAlign,$npcAC,$npcHP,$npcSpeed,$npcSTR,$npcDEX,$npcCON,$npcINT,$npcWIS,$npcCHA,$npcLanguages,$npcCR,$npcSkills,$npcProfBonus,$npcSaveThrows,$npcAbilities,$npcActions,$npcBio);
                $row = array("NPCID"=>$npcID, "NPCName"=>htmlspecialchars($npcName,ENT_QUOTES), "NPCLevel"=>htmlspecialchars($npcLevel,ENT_QUOTES), "NPCRace"=>htmlspecialchars($npcRace,ENT_QUOTES), "NPCClass"=>htmlspecialchars($npcClass,ENT_QUOTES), "NPCAlign"=>htmlspecialchars($npcAlign,ENT_QUOTES), "NPCAC"=>htmlspecialchars($npcAC,ENT_QUOTES), "NPCHP"=>htmlspecialchars($npcHP,ENT_QUOTES), "NPCSpeed"=>htmlspecialchars($npcSpeed,ENT_QUOTES), "NPCSTR"=>htmlspecialchars($npcSTR,ENT_QUOTES), "NPCDEX"=>htmlspecialchars($npcDEX,ENT_QUOTES), "NPCCON"=>htmlspecialchars($npcCON,ENT_QUOTES),"NPCINT"=>htmlspecialchars($npcINT,ENT_QUOTES), "NPCWIS"=>htmlspecialchars($npcWIS,ENT_QUOTES), "NPCCHA"=>htmlspecialchars($npcCHA,ENT_QUOTES), "NPCLanguages"=>htmlspecialchars($npcLanguages,ENT_QUOTES), "NPCCR"=>htmlspecialchars($npcCR,ENT_QUOTES), "NPCSkills"=>htmlspecialchars($npcSkills,ENT_QUOTES),"NPCProfBonus"=>htmlspecialchars($npcProfBonus,ENT_QUOTES), "NPCSaveThrows"=>htmlspecialchars($npcSaveThrows,ENT_QUOTES), "NPCAbilities"=>htmlspecialchars($npcAbilities,ENT_QUOTES), "NPCActions"=>htmlspecialchars($npcActions,ENT_QUOTES), "NPCBio"=>htmlspecialchars($npcBio,ENT_QUOTES),"CampaignID"=>$camID, "NPCStats" =>htmlspecialchars($npcStats,ENT_QUOTES));
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

/*
function read($conn)
{
    $npcID = getValue("npcID", "");
    //$user = getValue("UserID", "");
    //if($user != "")
    //{
    if($npcID != "")
    {
        $stmt = $conn->prepare("SELECT * FROM NPC WHERE NPC_ID = ?");
        $stmt->bind_param("i", $npcID);
        $stmt->execute();
        $stmt->bind_result($npcID,$npcName,$npcLevel,$npcRace,$npcClass,$npcAlign,$npcAC,$npcHP,$npcSpeed,$npcSTR,$npcDEX,$npcCON,$npcINT,$npcWIS,$npcCHA,$npcLanguages,$npcCR,$npcSkills,$npcProfBonus,$npcSaveThrows,$npcAbilities,$npcActions,$npcBio,$camID);
        
        
        $rows = array();
        while($stmt->fetch())
        {
            $npcStats = createStats($npcName,$npcLevel,$npcRace,$npcClass,$npcAlign,$npcAC,$npcHP,$npcSpeed,$npcSTR,$npcDEX,$npcCON,$npcINT,$npcWIS,$npcCHA,$npcLanguages,$npcCR,$npcSkills,$npcProfBonus,$npcSaveThrows,$npcAbilities,$npcActions,$npcBio);
            $row = array("NPCID"=>$npcID, "NPCName"=>$npcName, "NPCLevel"=>$npcLevel, "NPCRace"=>$npcRace, "NPCClass"=>$npcClass, "NPCAlign"=>$npcAlign, "NPCAC"=>$npcAC, "NPCHP"=>$npcHP, "NPCSpeed"=>$npcSpeed, "NPCSTR"=>$npcSTR, "NPCDEX"=>$npcDEX, "NPCCON"=>$npcCON,"NPCINT"=>$npcINT, "NPCWIS"=>$npcWIS, "NPCCHA"=>$npcCHA, "NPCLanguages"=>$npcLanguages, "NPCCR"=>$npcCR, "NPCSkills"=>$npcSkills,"NPCProfBonus"=>$npcProfBonus, "NPCSaveThrows"=>$npcSaveThrows, "NPCAbilities"=>$npcAbilities, "NPCActions"=>$npcActions, "NPCBio"=>$npcBio,"CampaignID"=>$camID, "NPCStats" =>$npcStats);
            $rows[] = $row;
        }
    
        
        return $rows;
    }
    else{
        return array("error"=>"npcID required");
    }
    //}
    //else {
    //    return array("error"=>"User does not exist");
    //}
    
}
*/

function readAll($conn)
{
    $userID = getSessionValue("user","")["userID"];
    if($userID != "")
    {
        $stmt = $conn->prepare("SELECT * FROM NPC WHERE USER_ID = ? ORDER BY NPC_NAME");
        $stmt->bind_param("i",$userID);
        $stmt->execute();
        $stmt->bind_result($npcID,$npcName,$npcLevel,$npcRace,$npcClass,$npcAlign,$npcAC,$npcHP,$npcSpeed,$npcSTR,$npcDEX,$npcCON,$npcINT,$npcWIS,$npcCHA,$npcLanguages,$npcCR,$npcSkills,$npcProfBonus,$npcSaveThrows,$npcAbilities,$npcActions,$npcBio,$camID,$userID);
        
        
        $rows = array();
        while($stmt->fetch())
        {
            $npcStats = createStats($npcName,$npcLevel,$npcRace,$npcClass,$npcAlign,$npcAC,$npcHP,$npcSpeed,$npcSTR,$npcDEX,$npcCON,$npcINT,$npcWIS,$npcCHA,$npcLanguages,$npcCR,$npcSkills,$npcProfBonus,$npcSaveThrows,$npcAbilities,$npcActions,$npcBio);
            $row = array("NPCID"=>$npcID, "NPCName"=>htmlspecialchars($npcName,ENT_QUOTES), "NPCLevel"=>htmlspecialchars($npcLevel,ENT_QUOTES), "NPCRace"=>htmlspecialchars($npcRace,ENT_QUOTES), "NPCClass"=>htmlspecialchars($npcClass,ENT_QUOTES), "NPCAlign"=>htmlspecialchars($npcAlign,ENT_QUOTES), "NPCAC"=>htmlspecialchars($npcAC,ENT_QUOTES), "NPCHP"=>htmlspecialchars($npcHP,ENT_QUOTES), "NPCSpeed"=>htmlspecialchars($npcSpeed,ENT_QUOTES), "NPCSTR"=>htmlspecialchars($npcSTR,ENT_QUOTES), "NPCDEX"=>htmlspecialchars($npcDEX,ENT_QUOTES), "NPCCON"=>htmlspecialchars($npcCON,ENT_QUOTES),"NPCINT"=>htmlspecialchars($npcINT,ENT_QUOTES), "NPCWIS"=>htmlspecialchars($npcWIS,ENT_QUOTES), "NPCCHA"=>htmlspecialchars($npcCHA,ENT_QUOTES), "NPCLanguages"=>htmlspecialchars($npcLanguages,ENT_QUOTES), "NPCCR"=>htmlspecialchars($npcCR,ENT_QUOTES), "NPCSkills"=>htmlspecialchars($npcSkills,ENT_QUOTES),"NPCProfBonus"=>htmlspecialchars($npcProfBonus,ENT_QUOTES), "NPCSaveThrows"=>htmlspecialchars($npcSaveThrows,ENT_QUOTES), "NPCAbilities"=>htmlspecialchars($npcAbilities,ENT_QUOTES), "NPCActions"=>htmlspecialchars($npcActions,ENT_QUOTES), "NPCBio"=>htmlspecialchars($npcBio,ENT_QUOTES),"CampaignID"=>$camID, "NPCStats" =>htmlspecialchars($npcStats,ENT_QUOTES));
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
    $npcID =getValue("npcID", "");
    $npcName = getValue("npcName", "");
    $npcLevel = getValue("npcLevel", "");
    $npcRace = getValue ("npcRace","");
    $npcClass = getValue ("npcClass","");
    $npcAlign = getValue ("npcAlign","");
    $npcAC = getValue ("npcAC","");
    $npcHP = getValue ("npcHP","");
    $npcSpeed = getValue ("npcSpeed","");
    $npcSTR = getValue ("npcSTR","");
    $npcDEX = getValue ("npcDEX","");
    $npcCON = getValue ("npcCON","");
    $npcINT = getValue ("npcINT","");
    $npcWIS = getValue ("npcWIS","");
    $npcCHA = getValue ("npcCHA","");
    $npcLanguages = getValue ("npcLanguages","");
    $npcCR = getValue ("npcCR","");
    $npcSkills = getValue ("npcSkills","");
    $npcProfBonus = getValue ("npcProfBonus","");
    $npcSaveThrows = getValue("npcSaveThrows","");
    $npcAbilities = getValue ("npcAbilities","");
    $npcActions = getValue ("npcActions","");
    $npcBio = getValue ("npcBio","");
    $camID = getValue("camID", "");
    $userID = getSessionValue("user","")["userID"];
    
    if ($npcID != "" && $userID != "")
    {
        $stmt = $conn->prepare("UPDATE NPC SET NPC_NAME = ?, NPC_LEVEL = ?, NPC_RACE = ?, NPC_CLASS = ?, NPC_ALIGN = ?, NPC_AC = ?, NPC_HP = ?, NPC_SPEED = ?, NPC_STR = ?, NPC_DEX = ?, NPC_CON = ?, NPC_INT = ?, NPC_WIS = ?, NPC_CHA = ?, NPC_LANGUAGES = ?, NPC_CR = ?, NPC_SKILLS = ?, NPC_PROFBONUS = ?, NPC_SAVETHROWS = ?, NPC_ABILITIES = ?, NPC_ACTIONS = ?, NPC_BIO = ?, CAM_ID = ? WHERE NPC_ID = ? && USER_ID = ?");
        $stmt->bind_param("ssssssssssssssssssssssiii", $npcName, $npcLevel, $npcRace, $npcClass, $npcAlign, $npcAC, $npcHP, $npcSpeed, $npcSTR, $npcDEX, $npcCON, $npcINT, $npcWIS, $npcCHA, $npcLanguages, $npcCR, $npcSkills, $npcProfBonus, $npcSaveThrows, $npcAbilities, $npcActions, $npcBio, $camID, $npcID, $userID);
        $stmt->execute();
        return read($conn);
    }
    else 
    {
        return array("error"=>"NPC ID required");    
    }
}

function delete($conn)
{
    $npcID = getValue("npcID", "");
    $camID = getValue("camID", "");
    $actID = getValue("actID","");
    $userID = getSessionValue("user","")["userID"];

    if ($npcID != "" && $userID != "")
    {
        $stmt = $conn->prepare("DELETE FROM NPC WHERE NPC_ID = ? AND USER_ID = ?");
        $stmt->bind_param("ii", $npcID, $userID);
        $stmt->execute();
        if($camID != "")
        {
            return read($conn);
        }
        else if($actID != "")
        {
            return readAct($conn);
        }
    }
    else 
    {
        return array("error"=>"NPC ID required");    
    }
}

function createStats($npcName,$npcLevel,$npcRace,$npcClass,$npcAlign,$npcAC,$npcHP,$npcSpeed,$npcSTR,$npcDEX,$npcCON,$npcINT,$npcWIS,$npcCHA,$npcLanguages,$npcCR,$npcSkills,$npcProfBonus,$npcSaveThrows,$npcAbilities,$npcActions,$npcBio)
{
    $stats = "<strong><u>NPC Name:</strong></u> " . $npcName . "\n" .
             "<strong><u>NPC Level:</strong></u> " . $npcLevel . "\n" .
             "<strong><u>NPC Race:</strong></u> " . $npcRace . "\n" . 
             "<strong><u>NPC Class:</strong></u> " . $npcClass . "\n" .
             "<strong><u>NPC Align:</strong></u> " . $npcAlign . "\n" .
             "<strong><u>NPC AC:</strong></u> " . $npcAC . "\n" . 
             "<strong><u>NPC HP:</strong></u> " . $npcHP . "\n" .
             "<strong><u>NPC Speed:</strong></u> " . $npcSpeed . "\n" .
             "<strong><u>NPC STR:</strong></u> " . $npcSTR . "\n" .
             "<strong><u>NPC DEX:</strong></u> " . $npcDEX . "\n" .
             "<strong><u>NPC CON:</strong></u> " . $npcCON . "\n" .
             "<strong><u>NPC INT:</strong></u> " . $npcINT . "\n" .
             "<strong><u>NPC WIS:</strong></u> " . $npcWIS . "\n" .
             "<strong><u>NPC CHA:</strong></u> " . $npcCHA . "\n" .
             "<strong><u>NPC Languages:</strong></u> " . $npcLanguages . "\n" . 
             "<strong><u>NPC CR:</strong></u> " . $npcCR . "\n" . 
             "<strong><u>NPC Skills:</strong></u> " . $npcSkills . "\n" . 
             "<strong><u>NPC ProfBonus:</strong></u> " . $npcProfBonus . "\n" . 
             "<strong><u>NPC SaveThrows:</strong></u> " . $npcSaveThrows . "\n" . 
             "<strong><u>NPC Abilities:</strong></u> " . $npcAbilities . "\n\n" . 
             "<strong><u>NPC Actions:</strong></u> " . $npcActions . "\n\n" . 
             "<strong><u>NPC Bio:</strong></u> " . $npcBio . "\n";
    return $stats;
}

function readAct($conn)
{
    $actID = getValue("actID","");
    $userID = getSessionValue("user","")["userID"];
    if($userID != "")
    {
        if($actID != "")
        {
            $stmt = $conn->prepare("SELECT NPC_ID FROM ACTNPC WHERE ACT_ID = ? && USER_ID = ?");
            $stmt->bind_param("ii", $actID, $userID);
            $stmt->execute();
            $stmt->bind_result($npcID);
        
        
            $IDs = array();
            while($stmt->fetch())
            {
                $IDs[] = $npcID;
            }
            $stmt->close();
        
            $rows = array();
            foreach($IDs as $id)
            {
                $stmt = $conn->prepare("SELECT * FROM NPC WHERE NPC_ID = ? && USER_ID = ? ORDER BY NPC_NAME");
                $stmt->bind_param("ii", $id, $userID);
                $stmt->execute();
                $stmt->bind_result($npcID,$npcName,$npcLevel,$npcRace,$npcClass,$npcAlign,$npcAC,$npcHP,$npcSpeed,$npcSTR,$npcDEX,$npcCON,$npcINT,$npcWIS,$npcCHA,$npcLanguages,$npcCR,$npcSkills,$npcProfBonus,$npcSaveThrows,$npcAbilities,$npcActions,$npcBio,$camID, $userID);
            
            
                while($stmt->fetch())
                {
                    $npcStats = createStats($npcName,$npcLevel,$npcRace,$npcClass,$npcAlign,$npcAC,$npcHP,$npcSpeed,$npcSTR,$npcDEX,$npcCON,$npcINT,$npcWIS,$npcCHA,$npcLanguages,$npcCR,$npcSkills,$npcProfBonus,$npcSaveThrows,$npcAbilities,$npcActions,$npcBio);
                    $row = array("NPCID"=>$npcID, "NPCName"=>htmlspecialchars($npcName,ENT_QUOTES), "NPCLevel"=>htmlspecialchars($npcLevel,ENT_QUOTES), "NPCRace"=>htmlspecialchars($npcRace,ENT_QUOTES), "NPCClass"=>htmlspecialchars($npcClass,ENT_QUOTES), "NPCAlign"=>htmlspecialchars($npcAlign,ENT_QUOTES), "NPCAC"=>htmlspecialchars($npcAC,ENT_QUOTES), "NPCHP"=>htmlspecialchars($npcHP,ENT_QUOTES), "NPCSpeed"=>htmlspecialchars($npcSpeed,ENT_QUOTES), "NPCSTR"=>htmlspecialchars($npcSTR,ENT_QUOTES), "NPCDEX"=>htmlspecialchars($npcDEX,ENT_QUOTES), "NPCCON"=>htmlspecialchars($npcCON,ENT_QUOTES),"NPCINT"=>htmlspecialchars($npcINT,ENT_QUOTES), "NPCWIS"=>htmlspecialchars($npcWIS,ENT_QUOTES), "NPCCHA"=>htmlspecialchars($npcCHA,ENT_QUOTES), "NPCLanguages"=>htmlspecialchars($npcLanguages,ENT_QUOTES), "NPCCR"=>htmlspecialchars($npcCR,ENT_QUOTES), "NPCSkills"=>htmlspecialchars($npcSkills,ENT_QUOTES),"NPCProfBonus"=>htmlspecialchars($npcProfBonus,ENT_QUOTES), "NPCSaveThrows"=>htmlspecialchars($npcSaveThrows,ENT_QUOTES), "NPCAbilities"=>htmlspecialchars($npcAbilities,ENT_QUOTES), "NPCActions"=>htmlspecialchars($npcActions,ENT_QUOTES), "NPCBio"=>htmlspecialchars($npcBio,ENT_QUOTES),"CampaignID"=>$camID, "NPCStats" =>htmlspecialchars($npcStats,ENT_QUOTES));
                    $rows[] = $row;
                }
                $stmt->close();
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

function npcDropdown($conn)
{
    $camID = getValue("camID","");
    $userID = getSessionValue("user","")["userID"];
    $stmt = $conn->prepare("SELECT NPC_ID, NPC_NAME FROM NPC WHERE CAM_ID = ? && USER_ID = ? ORDER BY NPC_NAME");
    $stmt->bind_param("ii", $camID, $userID);
    $stmt->execute();
    $stmt->bind_result($npcID,$npcName);
    
    $rows = array();
    while($stmt->fetch())
    {
        $row = array("NPCID"=>$npcID, "NPCName"=>$npcName,"status"=>"OK");
        $rows[] = $row;
    }
    return $rows;
}
?>
