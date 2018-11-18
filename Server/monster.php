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
else if ($cmd == "readEnc")
{
    $response = readEnc($conn);
    header('Content-type: application/json');
    echo json_encode($response);
}
else if ($cmd == "monDropdown")
{
    $response = monDropdown($conn);
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
    $monName = getValue("monName", "");
    $monSizeTypeAlign = getValue("monSizeTypeAlign", "");
    $monAC = getValue ("monAC","");
    $monHP = getValue ("monHP","");
    $monSpeed = getValue ("monSpeed","");
    $monSTR = getValue ("monSTR","");
    $monDEX = getValue ("monDEX","");
    $monCON = getValue ("monCON","");
    $monINT = getValue ("monINT","");
    $monWIS = getValue ("monWIS","");
    $monCHA = getValue ("monCHA","");
    $monVulnerabilities = getValue ("monVulnerabilities","");
    $monResistances = getValue ("monResistances","");
    $monImmunities = getValue("monImmunities", "");
    $monLanguages = getValue ("monLanguages","");
    $monCR = getValue ("monCR","");
    $monSkills = getValue ("monSkills","");
    $monProfBonus = getValue ("monProfBonus","");
    $monSaveThrows = getValue("monSaveThrows","");
    $monSenses = getValue ("monSenses","");
    $monAbilities = getValue ("monAbilities","");
    $monActions = getValue ("monActions","");
    $monLegendaryActions = getValue ("monLegendaryActions","");
    $camID = getValue("camID", "");
    //$user = getValue("UserID", "");
    
    if ($monName != "" && $monSizeTypeAlign != "" && $monAC != "" && $monHP != "" && $monSpeed != "" && $monSTR != ""  && $monDEX != "" && $monCON != "" && $monINT != "" && $monWIS != "" && $monCHA != "" && $monCR != "" && $monSenses != "" && $monActions != "" && $camID !="" /*&& $user != ""*/)
    { //Checks to make sure all essential values are not null
        
        $stmt = $conn->prepare("INSERT INTO MONSTER(MON_NAME, MON_SIZETYPEALIGN, MON_AC, MON_HP, MON_SPEED, MON_STR, MON_DEX, MON_CON, MON_INT, MON_WIS, MON_CHA, MON_VULNERABILITIES, MON_RESISTANCES, MON_IMMUNITIES, MON_LANGUAGES, MON_CR, MON_SKILLS, MON_PROFBONUS, MON_SAVETHROWS, MON_SENSES, MON_ABILITIES, MON_ACTIONS, MON_LEGENDARYACTIONS, CAM_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )");
        $stmt->bind_param("sssssssssssssssssssssssi", $monName, $monSizeTypeAlign, $monAC, $monHP, $monSpeed, $monSTR, $monDEX, $monCON, $monINT, $monWIS, $monCHA, $monVulnerabilities, $monResistances, $monImmunities, $monLanguages, $monCR, $monSkills, $monProfBonus, $monSaveThrows, $monSenses, $monAbilities, $monActions, $monLegendaryActions, $camID);
        $stmt->execute();
        return readAll($conn);
    }
    else 
    {
        return array("error"=>"Please enter all required fields");    
    }
}

function read($conn)
{
    $camID = getValue("camID", "");
    //$user = getValue("UserID", "");
    //if($user != "")
    //{
    if($camID != 0)
    {
        $stmt = $conn->prepare("SELECT * FROM MONSTER WHERE CAM_ID = ?");
        $stmt->bind_param("i", $camID);
        $stmt->execute();
        $stmt->bind_result($monID,$monName,$monSizeTypeAlign,$monAC,$monHP,$monSpeed,$monSTR,$monDEX,$monCON,$monINT,$monWIS,$monCHA,$monVulnerabilities,$monResistances,$monImmunities,$monLanguages,$monCR,$monSkills,$monProfBonus,$monSaveThrows,$monSenses,$monAbilities,$monActions,$monLegendaryActions,$camID);
        
        
        $rows = array();
        while($stmt->fetch())
        {
            $monStats = createStats($monName,$monSizeTypeAlign,$monAC,$monHP,$monSpeed,$monSTR,$monDEX,$monCON,$monINT,$monWIS,$monCHA,$monVulnerabilities,$monResistances,$monImmunities,$monLanguages,$monCR,$monSkills,$monProfBonus,$monSaveThrows,$monSenses,$monAbilities,$monActions,$monLegendaryActions);
            //$row = array("MonsterID"=>$monID, "MonsterName"=>$monName, "MonsterStats"=>$monStats ,"CampaignID"=>$camID);
            $row = array("MonsterID"=>$monID, "MonsterName"=>$monName, "MonsterSizeTypeAlign"=>$monSizeTypeAlign, "MonsterAC"=>$monAC, "MonsterHP"=>$monHP, "MonsterSpeed"=>$monSpeed, "MonsterSTR"=>$monSTR, "MonsterDEX"=>$monDEX, "MonsterCON"=>$monCON, "MonsterINT"=>$monINT, "MonsterWIS"=>$monWIS, "MonsterCHA"=>$monCHA,"MonsterVulnerabilities"=>$monVulnerabilities, "MonsterResistances"=>$monResistances, "MonsterImmunities"=>$monImmunities, "MonsterLanguages"=>$monLanguages, "MonsterCR"=>$monCR, "MonsterSkills"=>$monSkills, "MonsterProfBonus"=>$monProfBonus,"MonsterSaveThrows"=>$monSaveThrows, "MonsterSenses"=>$monSenses, "MonsterAbilities"=>$monAbilities, "MonsterActions"=>$monActions, "MonsterLegendaryActions"=>$monLegendaryActions,"CampaignID"=>$camID, "MonsterStats"=>$monStats);
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
        $stmt = $conn->prepare("SELECT * FROM MONSTER ORDER BY MON_NAME");
        $stmt->execute();
        $stmt->bind_result($monID,$monName,$monSizeTypeAlign,$monAC,$monHP,$monSpeed,$monSTR,$monDEX,$monCON,$monINT,$monWIS,$monCHA,$monVulnerabilities,$monResistances,$monImmunities,$monLanguages,$monCR,$monSkills,$monProfBonus,$monSaveThrows,$monSenses,$monAbilities,$monActions,$monLegendaryActions,$camID);
        
        
        $rows = array();
        while($stmt->fetch())
        {
            $monStats = createStats($monName,$monSizeTypeAlign,$monAC,$monHP,$monSpeed,$monSTR,$monDEX,$monCON,$monINT,$monWIS,$monCHA,$monVulnerabilities,$monResistances,$monImmunities,$monLanguages,$monCR,$monSkills,$monProfBonus,$monSaveThrows,$monSenses,$monAbilities,$monActions,$monLegendaryActions);
            //$row = array("MonsterID"=>$monID, "MonsterName"=>$monName, "MonsterStats"=>$monStats ,"CampaignID"=>$camID);
            $row = array("MonsterID"=>$monID, "MonsterName"=>$monName, "MonsterSizeTypeAlign"=>$monSizeTypeAlign, "MonsterAC"=>$monAC, "MonsterHP"=>$monHP, "MonsterSpeed"=>$monSpeed, "MonsterSTR"=>$monSTR, "MonsterDEX"=>$monDEX, "MonsterCON"=>$monCON, "MonsterINT"=>$monINT, "MonsterWIS"=>$monWIS, "MonsterCHA"=>$monCHA,"MonsterVulnerabilities"=>$monVulnerabilities, "MonsterResistances"=>$monResistances, "MonsterImmunities"=>$monImmunities, "MonsterLanguages"=>$monLanguages, "MonsterCR"=>$monCR, "MonsterSkills"=>$monSkills, "MonsterProfBonus"=>$monProfBonus,"MonsterSaveThrows"=>$monSaveThrows, "MonsterSenses"=>$monSenses, "MonsterAbilities"=>$monAbilities, "MonsterActions"=>$monActions, "MonsterLegendaryActions"=>$monLegendaryActions,"CampaignID"=>$camID, "MonsterStats"=>$monStats);
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
    $monID = getValue("monID","");
    $monName = getValue("monName", "");
    $monSizeTypeAlign = getValue("monSizeTypeAlign", "");
    $monAC = getValue ("monAC","");
    $monHP = getValue ("monHP","");
    $monSpeed = getValue ("monSpeed","");
    $monSTR = getValue ("monSTR","");
    $monDEX = getValue ("monDEX","");
    $monCON = getValue ("monCON","");
    $monINT = getValue ("monINT","");
    $monWIS = getValue ("monWIS","");
    $monCHA = getValue ("monCHA","");
    $monVulnerabilities = getValue ("monVulnerabilities","");
    $monResistances = getValue ("monResistances","");
    $monImmunities = getValue("monImmunities", "");
    $monLanguages = getValue ("monLanguages","");
    $monCR = getValue ("monCR","");
    $monSkills = getValue ("monSkills","");
    $monProfBonus = getValue ("monProfBonus","");
    $monSaveThrows = getValue("monSaveThrows","");
    $monSenses = getValue ("monSenses","");
    $monAbilities = getValue ("monAbilities","");
    $monActions = getValue ("monActions","");
    $monLegendaryActions = getValue ("monLegendaryActions","");
    $camID = getValue("camID", "");
    
    if ($monID != "")
    {
        /* This depends on what my model contains. If it holds all of the current monster values and the updated then I don't need to do this
        if($monName != "")
        {
            $stmt = $conn->prepare("UPDATE MONSTER SET MON_NAME = ? WHERE MON_ID = ?");
            $stmt->bind_param("si", $monName, $monID);
            $stmt->execute();
        }
        */
        
        $stmt = $conn->prepare("UPDATE MONSTER SET MON_NAME = ?, MON_SIZETYPEALIGN = ?, MON_AC = ?, MON_HP = ?, MON_SPEED = ?, MON_STR = ?, MON_DEX = ?, MON_CON = ?, MON_INT =?, MON_WIS = ? , MON_CHA = ?, MON_VULNERABILITIES = ?, MON_RESISTANCES = ?, MON_IMMUNITIES = ? , MON_LANGUAGES = ? , MON_CR = ?, MON_SKILLS = ?, MON_PROFBONUS = ?, MON_SAVETHROWS = ?, MON_SENSES = ?, MON_ABILITIES = ?, MON_ACTIONS = ?, MON_LEGENDARYACTIONS = ?, CAM_ID = ? WHERE MON_ID = ?");
        $stmt->bind_param("sssssssssssssssssssssssii", $monName, $monSizeTypeAlign, $monAC, $monHP, $monSpeed, $monSTR, $monDEX, $monCON, $monINT, $monWIS, $monCHA, $monVulnerabilities, $monResistances, $monImmunities, $monLanguages, $monCR, $monSkills, $monProfBonus, $monSaveThrows, $monSenses, $monAbilities, $monActions, $monLegendaryActions, $camID, $monID);
        $stmt->execute();
        return read($conn);
    }
    else 
    {
        return array("error"=>"MonsterID required");    
    }
}

function delete($conn)
{
    $monID = getValue("monID", "");

    if ($monID != "")
    {
        $stmt = $conn->prepare("DELETE FROM MONSTER WHERE MON_ID = ?");
        $stmt->bind_param("i", $monID);
        $stmt->execute();

        return readAll($conn);

    }
    else 
    {
        return array("error"=>"All fields are required");    
    }
}

function createStats($monName,$monSizeTypeAlign, $monAC, $monHP, $monSpeed, $monSTR, $monDEX, $monCON, $monINT, $monWIS, $monCHA, $monVulnerabilities, $monResistances, $monImmunities, $monLanguages, $monCR, $monSkills, $monProfBonus, $monSaveThrows, $monSenses, $monAbilities, $monActions, $monLegendaryActions)
{
    $stats = "Monster Name: " . $monName . "\n" .
             "Monster Size, Type, and Alignment: " . $monSizeTypeAlign . "\n" .
             "Monster AC: " . $monAC . "\n" . 
             "Monster HP: " . $monHP . "\n" .
             "Monster Speed: " . $monSpeed . "\n" .
             "Monster STR: " . $monSTR . "\n" . 
             "Monster DEX: " . $monDEX . "\n" .
             "Monster CON: " . $monCON . "\n" .
             "Monster INT: " . $monINT . "\n" .
             "Monster WIS: " . $monWIS . "\n" .
             "Monster CHA: " . $monCHA . "\n" .
             "Monster Vulnerabilities: " . $monVulnerabilities . "\n" .
             "Monster Resistances: " . $monResistances . "\n" .
             "Monster Immunities: " . $monImmunities . "\n" .
             "Monster Languages: " . $monLanguages . "\n" . 
             "Monster CR: " . $monCR . "\n" . 
             "Monster Skills: " . $monSkills . "\n" . 
             "Monster ProfBonus: " . $monProfBonus . "\n" . 
             "Monster SaveThrows: " . $monSaveThrows . "\n" . 
             "Monster Senses: " . $monSenses . "\n" . 
             "Monster Abilities: " . $monAbilities . "\n" . 
             "Monster Actions: " . $monActions . "\n" . 
             "Monster Legendary Actions: " . $monLegendaryActions . "\n";
    return $stats;
}

function readEnc($conn)
{
    $encID = getValue("encID","");
    //$user = getValue("UserID", "");
    //if($user != "")
    //{
    if($encID != "")
    {
        $stmt = $conn->prepare("SELECT * FROM ENCMON WHERE ENC_ID = ?");
        $stmt->bind_param("i", $encID);
        $stmt->execute();
        $stmt->bind_result($encMonID,$monID,$encID);
        
        
        $monIDs = array();
        $encMonIDs = array();
        while($stmt->fetch())
        {
            $monIDs[] = $monID;
            $encMonIDs[] = $encMonID;
        }
        $stmt->close();
        
        $rows = array();
        $encMonCount=0;
        foreach($monIDs as $id)
        {
            
            $stmt = $conn->prepare("SELECT * FROM MONSTER WHERE MON_ID = ? ORDER BY MON_NAME");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->bind_result($monID,$monName,$monSizeTypeAlign,$monAC,$monHP,$monSpeed,$monSTR,$monDEX,$monCON,$monINT,$monWIS,$monCHA,$monVulnerabilities,$monResistances,$monImmunities,$monLanguages,$monCR,$monSkills,$monProfBonus,$monSaveThrows,$monSenses,$monAbilities,$monActions,$monLegendaryActions,$camID);
            
            
            while($stmt->fetch())
            {
                $monStats = createStats($monName,$monSizeTypeAlign,$monAC,$monHP,$monSpeed,$monSTR,$monDEX,$monCON,$monINT,$monWIS,$monCHA,$monVulnerabilities,$monResistances,$monImmunities,$monLanguages,$monCR,$monSkills,$monProfBonus,$monSaveThrows,$monSenses,$monAbilities,$monActions,$monLegendaryActions);
                $row = array("MonsterID"=>$monID, "MonsterName"=>$monName, "MonsterSizeTypeAlign"=>$monSizeTypeAlign, "MonsterAC"=>$monAC, "MonsterHP"=>$monHP, "MonsterSpeed"=>$monSpeed, "MonsterSTR"=>$monSTR, "MonsterDEX"=>$monDEX, "MonsterCON"=>$monCON, "MonsterINT"=>$monINT, "MonsterWIS"=>$monWIS, "MonsterCHA"=>$monCHA,"MonsterVulnerabilities"=>$monVulnerabilities, "MonsterResistances"=>$monResistances, "MonsterImmunities"=>$monImmunities, "MonsterLanguages"=>$monLanguages, "MonsterCR"=>$monCR, "MonsterSkills"=>$monSkills, "MonsterProfBonus"=>$monProfBonus,"MonsterSaveThrows"=>$monSaveThrows, "MonsterSenses"=>$monSenses, "MonsterAbilities"=>$monAbilities, "MonsterActions"=>$monActions, "MonsterLegendaryActions"=>$monLegendaryActions,"CampaignID"=>$camID, "MonsterStats"=>$monStats,"EncMonID"=>$encMonIDs[$encMonCount]);
                $rows[] = $row;
            }
            $stmt->close();
            $encMonCount = $encMonCount + 1;
        }
        
    return $rows;
    
    }
    else{
        return array("error"=>"encID required");
    }
    //}
    //else {
    //    return array("error"=>"User does not exist");
    //}
    
}


function monDropdown($conn)
{
    $stmt = $conn->prepare("SELECT MON_ID, MON_NAME FROM MONSTER ORDER BY MON_NAME");
    //$stmt->bind_param("i", $camID);
    $stmt->execute();
    $stmt->bind_result($monID,$monName);
    
    $rows = array();
    while($stmt->fetch())
    {
        $row = array("MonID"=>$monID, "MonName"=>$monName,"status"=>"OK");
        $rows[] = $row;
    }
    return $rows;
}
?>
