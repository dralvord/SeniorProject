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
    //$user = getValue("UserID", "");
    
    if ($npcName != "" && $npcLevel != "" && $npcRace != "" && $npcClass != "" && $npcAlign != "" && $npcAC != "" && $npcHP != "" && $npcSpeed != "" && $npcSTR != ""  && $npcDEX != "" && $npcCON != "" && $npcINT != "" && $npcWIS != "" && $npcCHA != "" && $npcLanguages != "" && $npcCR != "" && $npcSkills != "" && $npcProfBonus != "" && $npcSaveThrows != "" && $npcAbilities != "" && $npcActions != "" &&$npcBio != "" && $camID !="" /*&& $user != ""*/)
    { //Checks to make sure all essential values are not null
        
        $stmt = $conn->prepare("INSERT INTO NPC(NPC_NAME, NPC_LEVEL, NPC_RACE, NPC_CLASS, NPC_ALIGN, NPC_AC, NPC_HP, NPC_SPEED, NPC_STR, NPC_DEX, NPC_CON, NPC_INT, NPC_WIS, NPC_CHA, NPC_LANGUAGES, NPC_CR, NPC_SKILLS, NPC_PROFBONUS, NPC_SAVETHROWS, NPC_ABILITIES, NPC_ACTIONS, NPC_BIO, CAM_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sissssssssssssssssssssi", $npcName, $npcLevel, $npcRace, $npcClass, $npcAlign, $npcAC, $npcHP, $npcSpeed, $npcSTR, $npcDEX, $npcCON, $npcINT, $npcWIS, $npcCHA, $npcLanguages, $npcCR, $npcSkills, $npcProfBonus, $npcSaveThrows, $npcAbilities, $npcActions, $npcBio, $camID);
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
        $stmt = $conn->prepare("SELECT * FROM NPC WHERE CAM_ID = ? ORDER BY NPC_NAME");
        $stmt->bind_param("i", $camID);
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
        return array("error"=>"camID required");
    }
    //}
    //else {
    //    return array("error"=>"User does not exist");
    //}
    
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
    //$user = getValue("UserID", "");
    //if($user != "")
    //{
        $stmt = $conn->prepare("SELECT * FROM NPC ORDER BY NPC_NAME");
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
    //}
    //else {
    //    return array("error"=>"User does not exist");
    //}
    
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
    //$user = getValue("UserID", "");
    
    if ($npcID != "")
    {
        /* This depends on what my model contains. If it holds all of the current monster values and the updated then I don't need to do this
        if($monName != "")
        {
            $stmt = $conn->prepare("UPDATE MONSTER SET MON_NAME = ? WHERE MON_ID = ?");
            $stmt->bind_param("si", $monName, $monID);
            $stmt->execute();
        }
        */
        
        $stmt = $conn->prepare("UPDATE NPC SET NPC_NAME = ?, NPC_LEVEL = ?, NPC_RACE = ?, NPC_CLASS = ?, NPC_ALIGN = ?, NPC_AC = ?, NPC_HP = ?, NPC_SPEED = ?, NPC_STR = ?, NPC_DEX = ?, NPC_CON = ?, NPC_INT = ?, NPC_WIS = ?, NPC_CHA = ?, NPC_LANGUAGES = ?, NPC_CR = ?, NPC_SKILLS = ?, NPC_PROFBONUS = ?, NPC_SAVETHROWS = ?, NPC_ABILITIES = ?, NPC_ACTIONS = ?, NPC_BIO = ?, CAM_ID = ? WHERE NPC_ID = ?");
        $stmt->bind_param("sissssssssssssssssssssii", $npcName, $npcLevel, $npcRace, $npcClass, $npcAlign, $npcAC, $npcHP, $npcSpeed, $npcSTR, $npcDEX, $npcCON, $npcINT, $npcWIS, $npcCHA, $npcLanguages, $npcCR, $npcSkills, $npcProfBonus, $npcSaveThrows, $npcAbilities, $npcActions, $npcBio, $camID, $npcID);
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

    if ($npcID != "")
    {
        $stmt = $conn->prepare("DELETE FROM NPC WHERE NPC_ID = ?");
        $stmt->bind_param("i", $npcID);
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
    $stats = "NPC Name: " . $npcName . "\n" .
             "NPC Level: " . $npcLevel . "\n" .
             "NPC Race: " . $npcRace . "\n" . 
             "NPC Class: " . $npcClass . "\n" .
             "NPC Align: " . $npcAlign . "\n" .
             "NPC AC: " . $npcAC . "\n" . 
             "NPC HP: " . $npcHP . "\n" .
             "NPC Speed: " . $npcSpeed . "\n" .
             "NPC STR: " . $npcSTR . "\n" .
             "NPC DEX: " . $npcDEX . "\n" .
             "NPC CON: " . $npcCON . "\n" .
             "NPC INT: " . $npcINT . "\n" .
             "NPC WIS: " . $npcWIS . "\n" .
             "NPC CHA: " . $npcCHA . "\n" .
             "NPC Languages: " . $npcLanguages . "\n" . 
             "NPC CR: " . $npcCR . "\n" . 
             "NPC Skills: " . $npcSkills . "\n" . 
             "NPC ProfBonus: " . $npcProfBonus . "\n" . 
             "NPC SaveThrows: " . $npcSaveThrows . "\n" . 
             "NPC Abilities: " . $npcAbilities . "\n" . 
             "NPC Actions: " . $npcActions . "\n" . 
             "NPC Bio: " . $npcBio . "\n";
    return $stats;
}

function readAct($conn)
{
    $actID = getValue("actID","");
    //$user = getValue("UserID", "");
    //if($user != "")
    //{
    if($actID != "")
    {
        $stmt = $conn->prepare("SELECT NPC_ID FROM ACTNPC WHERE ACT_ID = ?");
        $stmt->bind_param("i", $actID);
        $stmt->execute();
        $stmt->bind_result($npcID);
        
        
        $IDs = array();
        while($stmt->fetch())
        {
            //$id = $npcID;
            $IDs[] = $npcID;
        }
        $stmt->close();
        
        $rows = array();
        foreach($IDs as $id)
        {
            $stmt = $conn->prepare("SELECT * FROM NPC WHERE NPC_ID = ? ORDER BY NPC_NAME");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->bind_result($npcID,$npcName,$npcLevel,$npcRace,$npcClass,$npcAlign,$npcAC,$npcHP,$npcSpeed,$npcSTR,$npcDEX,$npcCON,$npcINT,$npcWIS,$npcCHA,$npcLanguages,$npcCR,$npcSkills,$npcProfBonus,$npcSaveThrows,$npcAbilities,$npcActions,$npcBio,$camID);
            
            
            while($stmt->fetch())
            {
                $npcStats = createStats($npcName,$npcLevel,$npcRace,$npcClass,$npcAlign,$npcAC,$npcHP,$npcSpeed,$npcSTR,$npcDEX,$npcCON,$npcINT,$npcWIS,$npcCHA,$npcLanguages,$npcCR,$npcSkills,$npcProfBonus,$npcSaveThrows,$npcAbilities,$npcActions,$npcBio);
                $row = array("NPCID"=>$npcID, "NPCName"=>$npcName, "NPCLevel"=>$npcLevel, "NPCRace"=>$npcRace, "NPCClass"=>$npcClass, "NPCAlign"=>$npcAlign, "NPCAC"=>$npcAC, "NPCHP"=>$npcHP, "NPCSpeed"=>$npcSpeed, "NPCSTR"=>$npcSTR, "NPCDEX"=>$npcDEX, "NPCCON"=>$npcCON,"NPCINT"=>$npcINT, "NPCWIS"=>$npcWIS, "NPCCHA"=>$npcCHA, "NPCLanguages"=>$npcLanguages, "NPCCR"=>$npcCR, "NPCSkills"=>$npcSkills,"NPCProfBonus"=>$npcProfBonus, "NPCSaveThrows"=>$npcSaveThrows, "NPCAbilities"=>$npcAbilities, "NPCActions"=>$npcActions, "NPCBio"=>$npcBio,"CampaignID"=>$camID, "NPCStats" =>$npcStats);
                $rows[] = $row;
            }
            $stmt->close();
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

function npcDropdown($conn)
{
    $camID = getValue("camID","");
    $stmt = $conn->prepare("SELECT NPC_ID, NPC_NAME FROM NPC WHERE CAM_ID = ? ORDER BY NPC_NAME");
    $stmt->bind_param("i", $camID);
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
