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
    //$camID = getValue("camID", "");
    $userID = getSessionValue("user","")["userID"];
    
    if ($monName != "" && $monSizeTypeAlign != "" && $monAC != "" && $monHP != "" && $monSpeed != "" && $monSTR != ""  && $monDEX != "" && $monCON != "" && $monINT != "" && $monWIS != "" && $monCHA != "" && $monCR != "" && $monSenses != "" && $monActions != "" && /*$camID !="" &&*/ $userID != "")
    { //Checks to make sure all essential values are not null
        
        $stmt = $conn->prepare("INSERT INTO MONSTER(MON_NAME, MON_SIZETYPEALIGN, MON_AC, MON_HP, MON_SPEED, MON_STR, MON_DEX, MON_CON, MON_INT, MON_WIS, MON_CHA, MON_VULNERABILITIES, MON_RESISTANCES, MON_IMMUNITIES, MON_LANGUAGES, MON_CR, MON_SKILLS, MON_PROFBONUS, MON_SAVETHROWS, MON_SENSES, MON_ABILITIES, MON_ACTIONS, MON_LEGENDARYACTIONS, USER_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        //$stmt = mysqli_real_escape_string($stmt);
        $stmt->bind_param("sssssssssssssssssssssssi", $monName, $monSizeTypeAlign, $monAC, $monHP, $monSpeed, $monSTR, $monDEX, $monCON, $monINT, $monWIS, $monCHA, $monVulnerabilities, $monResistances, $monImmunities, $monLanguages, $monCR, $monSkills, $monProfBonus, $monSaveThrows, $monSenses, $monAbilities, $monActions, $monLegendaryActions, $userID);
        $stmt->execute();
        return readAll($conn);
    }
    else 
    {
        return array("error"=>"Please enter all required fields");    
    }
}

function read($conn)
{   //Not updated to include user id. Not needed currently
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
            $row = array("MonsterID"=>$monID, "MonsterName"=>htmlspecialchars($monName,ENT_QUOTES), "MonsterSizeTypeAlign"=>htmlspecialchars($monSizeTypeAlign,ENT_QUOTES), "MonsterAC"=>htmlspecialchars($monAC,ENT_QUOTES), "MonsterHP"=>htmlspecialchars($monHP,ENT_QUOTES), "MonsterSpeed"=>htmlspecialchars($monSpeed,ENT_QUOTES), "MonsterSTR"=>htmlspecialchars($monSTR,ENT_QUOTES), "MonsterDEX"=>htmlspecialchars($monDEX,ENT_QUOTES), "MonsterCON"=>htmlspecialchars($monCON,ENT_QUOTES), "MonsterINT"=>htmlspecialchars($monINT,ENT_QUOTES), "MonsterWIS"=>htmlspecialchars($monWIS,ENT_QUOTES), "MonsterCHA"=>htmlspecialchars($monCHA,ENT_QUOTES),"MonsterVulnerabilities"=>htmlspecialchars($monVulnerabilities,ENT_QUOTES), "MonsterResistances"=>htmlspecialchars($monResistances,ENT_QUOTES), "MonsterImmunities"=>htmlspecialchars($monImmunities,ENT_QUOTES), "MonsterLanguages"=>htmlspecialchars($monLanguages,ENT_QUOTES), "MonsterCR"=>htmlspecialchars($monCR,ENT_QUOTES), "MonsterSkills"=>htmlspecialchars($monSkills,ENT_QUOTES), "MonsterProfBonus"=>htmlspecialchars($monProfBonus,ENT_QUOTES),"MonsterSaveThrows"=>htmlspecialchars($monSaveThrows,ENT_QUOTES), "MonsterSenses"=>htmlspecialchars($monSenses,ENT_QUOTES), "MonsterAbilities"=>htmlspecialchars($monAbilities,ENT_QUOTES), "MonsterActions"=>htmlspecialchars($monActions,ENT_QUOTES), "MonsterLegendaryActions"=>htmlspecialchars($monLegendaryActions,ENT_QUOTES),"CampaignID"=>$camID, "MonsterStats"=>htmlspecialchars($monStats,ENT_QUOTES));
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
    $userID = getSessionValue("user","")["userID"];
    if($userID != "")
    {
        $stmt = $conn->prepare("SELECT * FROM MONSTER WHERE USER_ID = ? ORDER BY MON_NAME");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $stmt->bind_result($monID,$monName,$monSizeTypeAlign,$monAC,$monHP,$monSpeed,$monSTR,$monDEX,$monCON,$monINT,$monWIS,$monCHA,$monVulnerabilities,$monResistances,$monImmunities,$monLanguages,$monCR,$monSkills,$monProfBonus,$monSaveThrows,$monSenses,$monAbilities,$monActions,$monLegendaryActions,/*$camID,*/ $userID);
        
        
        $rows = array();
        while($stmt->fetch())
        {
            $monStats = createStats($monName,$monSizeTypeAlign,$monAC,$monHP,$monSpeed,$monSTR,$monDEX,$monCON,$monINT,$monWIS,$monCHA,$monVulnerabilities,$monResistances,$monImmunities,$monLanguages,$monCR,$monSkills,$monProfBonus,$monSaveThrows,$monSenses,$monAbilities,$monActions,$monLegendaryActions);
            //$row = array("MonsterID"=>$monID, "MonsterName"=>$monName, "MonsterStats"=>$monStats ,"CampaignID"=>$camID);
            $row = array("MonsterID"=>$monID, "MonsterName"=>htmlspecialchars($monName,ENT_QUOTES), "MonsterSizeTypeAlign"=>htmlspecialchars($monSizeTypeAlign,ENT_QUOTES), "MonsterAC"=>htmlspecialchars($monAC,ENT_QUOTES), "MonsterHP"=>htmlspecialchars($monHP,ENT_QUOTES), "MonsterSpeed"=>htmlspecialchars($monSpeed,ENT_QUOTES), "MonsterSTR"=>htmlspecialchars($monSTR,ENT_QUOTES), "MonsterDEX"=>htmlspecialchars($monDEX,ENT_QUOTES), "MonsterCON"=>htmlspecialchars($monCON,ENT_QUOTES), "MonsterINT"=>htmlspecialchars($monINT,ENT_QUOTES), "MonsterWIS"=>htmlspecialchars($monWIS,ENT_QUOTES), "MonsterCHA"=>htmlspecialchars($monCHA,ENT_QUOTES),"MonsterVulnerabilities"=>htmlspecialchars($monVulnerabilities,ENT_QUOTES), "MonsterResistances"=>htmlspecialchars($monResistances,ENT_QUOTES), "MonsterImmunities"=>htmlspecialchars($monImmunities,ENT_QUOTES), "MonsterLanguages"=>htmlspecialchars($monLanguages,ENT_QUOTES), "MonsterCR"=>htmlspecialchars($monCR,ENT_QUOTES), "MonsterSkills"=>htmlspecialchars($monSkills,ENT_QUOTES), "MonsterProfBonus"=>htmlspecialchars($monProfBonus,ENT_QUOTES),"MonsterSaveThrows"=>htmlspecialchars($monSaveThrows,ENT_QUOTES), "MonsterSenses"=>htmlspecialchars($monSenses,ENT_QUOTES), "MonsterAbilities"=>htmlspecialchars($monAbilities,ENT_QUOTES), "MonsterActions"=>htmlspecialchars($monActions,ENT_QUOTES), "MonsterLegendaryActions"=>htmlspecialchars($monLegendaryActions,ENT_QUOTES),/*"CampaignID"=>$camID,*/ "MonsterStats"=>htmlspecialchars($monStats,ENT_QUOTES));
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
    //$camID = getValue("camID", "");
    $userID = getSessionValue("user","")["userID"];
    
    if ($monID != "" && $userID !="")
    {
        $stmt = $conn->prepare("UPDATE MONSTER SET MON_NAME = ?, MON_SIZETYPEALIGN = ?, MON_AC = ?, MON_HP = ?, MON_SPEED = ?, MON_STR = ?, MON_DEX = ?, MON_CON = ?, MON_INT =?, MON_WIS = ? , MON_CHA = ?, MON_VULNERABILITIES = ?, MON_RESISTANCES = ?, MON_IMMUNITIES = ? , MON_LANGUAGES = ? , MON_CR = ?, MON_SKILLS = ?, MON_PROFBONUS = ?, MON_SAVETHROWS = ?, MON_SENSES = ?, MON_ABILITIES = ?, MON_ACTIONS = ?, MON_LEGENDARYACTIONS = ? WHERE MON_ID = ? && USER_ID = ?");
        //$stmt = mysqli_real_escape_string($stmt);
        $stmt->bind_param("sssssssssssssssssssssssii", $monName, $monSizeTypeAlign, $monAC, $monHP, $monSpeed, $monSTR, $monDEX, $monCON, $monINT, $monWIS, $monCHA, $monVulnerabilities, $monResistances, $monImmunities, $monLanguages, $monCR, $monSkills, $monProfBonus, $monSaveThrows, $monSenses, $monAbilities, $monActions, $monLegendaryActions, /*$camID,*/ $monID, $userID);
        $stmt->execute();
        return readAll($conn);
    }
    else 
    {
        return array("error"=>"MonsterID required");    
    }
}

function delete($conn)
{
    $monID = getValue("monID", "");
    $userID = getSessionValue("user","")["userID"];

    if ($monID != "" && $userID != "")
    {
        $stmt = $conn->prepare("DELETE FROM MONSTER WHERE MON_ID = ? AND USER_ID = ?");
        $stmt->bind_param("ii", $monID, $userID);
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
    $stats = "<strong><u>Monster Name:</strong></u> " . $monName . "\n" .
             "<strong><u>Monster Size, Type, and Alignment:</strong></u> " . $monSizeTypeAlign . "\n" .
             "<strong><u>Monster AC:</strong></u> " . $monAC . "\n" . 
             "<strong><u>Monster HP:</strong></u> " . $monHP . "\n" .
             "<strong><u>Monster Speed:</strong></u> " . $monSpeed . "\n" .
             "<strong><u>Monster STR:</strong></u> " . $monSTR . "\n" . 
             "<strong><u>Monster DEX:</strong></u> " . $monDEX . "\n" .
             "<strong><u>Monster CON:</strong></u> " . $monCON . "\n" .
             "<strong><u>Monster INT:</strong></u> " . $monINT . "\n" .
             "<strong><u>Monster WIS:</strong></u> " . $monWIS . "\n" .
             "<strong><u>Monster CHA:</strong></u> " . $monCHA . "\n" .
             "<strong><u>Monster Vulnerabilities:</strong></u> " . $monVulnerabilities . "\n" .
             "<strong><u>Monster Resistances:</strong></u> " . $monResistances . "\n" .
             "<strong><u>Monster Immunities:</strong></u> " . $monImmunities . "\n" .
             "<strong><u>Monster Languages:</strong></u> " . $monLanguages . "\n" . 
             "<strong><u>Monster CR:</strong></u> " . $monCR . "\n" . 
             "<strong><u>Monster Skills:</strong></u> " . $monSkills . "\n" . 
             "<strong><u>Monster ProfBonus:</strong></u> " . $monProfBonus . "\n" . 
             "<strong><u>Monster SaveThrows:</strong></u> " . $monSaveThrows . "\n" . 
             "<strong><u>Monster Senses:</strong></u> " . $monSenses . "\n" . 
             "<strong><u>Monster Abilities:</strong></u> " . $monAbilities . "\n\n" . 
             "<strong><u>Monster Actions:</strong></u> " . $monActions . "\n\n" . 
             "<strong><u>Monster Legendary Actions:</strong></u> " . $monLegendaryActions . "\n";
    return $stats;
}

function readEnc($conn)
{
    $encID = getValue("encID","");
    $userID = getSessionValue("user","")["userID"];
    if($userID != "")
    {
        if($encID != "")
        {
            $stmt = $conn->prepare("SELECT ENCMON_ID, MON_ID, ENC_ID FROM ENCMON WHERE ENC_ID = ? AND USER_ID = ?");
            $stmt->bind_param("ii", $encID, $userID);
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
            
                $stmt = $conn->prepare("SELECT * FROM MONSTER WHERE MON_ID = ? AND USER_ID = ? ORDER BY MON_NAME");
                $stmt->bind_param("ii", $id, $userID);
                $stmt->execute();
                $stmt->bind_result($monID,$monName,$monSizeTypeAlign,$monAC,$monHP,$monSpeed,$monSTR,$monDEX,$monCON,$monINT,$monWIS,$monCHA,$monVulnerabilities,$monResistances,$monImmunities,$monLanguages,$monCR,$monSkills,$monProfBonus,$monSaveThrows,$monSenses,$monAbilities,$monActions,$monLegendaryActions,/*$camID,*/ $userID);
            
                while($stmt->fetch())
                {
                    $monStats = createStats($monName,$monSizeTypeAlign,$monAC,$monHP,$monSpeed,$monSTR,$monDEX,$monCON,$monINT,$monWIS,$monCHA,$monVulnerabilities,$monResistances,$monImmunities,$monLanguages,$monCR,$monSkills,$monProfBonus,$monSaveThrows,$monSenses,$monAbilities,$monActions,$monLegendaryActions);
                    $row = array("MonsterID"=>$monID, "MonsterName"=>htmlspecialchars($monName,ENT_QUOTES), "MonsterSizeTypeAlign"=>htmlspecialchars($monSizeTypeAlign,ENT_QUOTES), "MonsterAC"=>htmlspecialchars($monAC,ENT_QUOTES), "MonsterHP"=>htmlspecialchars($monHP,ENT_QUOTES), "MonsterSpeed"=>htmlspecialchars($monSpeed,ENT_QUOTES), "MonsterSTR"=>htmlspecialchars($monSTR,ENT_QUOTES), "MonsterDEX"=>htmlspecialchars($monDEX,ENT_QUOTES), "MonsterCON"=>htmlspecialchars($monCON,ENT_QUOTES), "MonsterINT"=>htmlspecialchars($monINT,ENT_QUOTES), "MonsterWIS"=>htmlspecialchars($monWIS,ENT_QUOTES), "MonsterCHA"=>htmlspecialchars($monCHA,ENT_QUOTES),"MonsterVulnerabilities"=>htmlspecialchars($monVulnerabilities,ENT_QUOTES), "MonsterResistances"=>htmlspecialchars($monResistances,ENT_QUOTES), "MonsterImmunities"=>htmlspecialchars($monImmunities,ENT_QUOTES), "MonsterLanguages"=>htmlspecialchars($monLanguages,ENT_QUOTES), "MonsterCR"=>htmlspecialchars($monCR,ENT_QUOTES), "MonsterSkills"=>htmlspecialchars($monSkills,ENT_QUOTES), "MonsterProfBonus"=>htmlspecialchars($monProfBonus,ENT_QUOTES),"MonsterSaveThrows"=>htmlspecialchars($monSaveThrows,ENT_QUOTES), "MonsterSenses"=>htmlspecialchars($monSenses,ENT_QUOTES), "MonsterAbilities"=>htmlspecialchars($monAbilities,ENT_QUOTES), "MonsterActions"=>htmlspecialchars($monActions,ENT_QUOTES), "MonsterLegendaryActions"=>htmlspecialchars($monLegendaryActions,ENT_QUOTES),/*"CampaignID"=>$camID,*/ "MonsterStats"=>htmlspecialchars($monStats,ENT_QUOTES),"EncMonID"=>$encMonIDs[$encMonCount]);
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
    }
    else {
        return array("error"=>"User does not exist");
    }
    
}


function monDropdown($conn)
{
    $userID = getSessionValue("user","")["userID"];
    $stmt = $conn->prepare("SELECT MON_ID, MON_NAME FROM MONSTER WHERE USER_ID = ? ORDER BY MON_NAME");
    $stmt->bind_param("i", $userID);
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
