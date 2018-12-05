 
<?php
require_once "functions.php";
require_once 'dblogin.php';

session_start();
header("Access-Control-Allow-Origin: *");

// Create connection
$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database, $db_port);

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
else if ($cmd == "login")
{
    $response = login($conn);
    header('Content-type: application/json');
    echo json_encode($response);
}
else if ($cmd == "logout")
{
    $response = logout();
    header('Content-type: application/json');
    echo json_encode($response);
}
else if ($cmd == "isLoggedIn")
{
    $response = isLoggedIn();
    header('Content-type: application/json');
    echo json_encode($response);
}
else if ($cmd == "changePassword")
{
    $response = changePassword($conn);
    header('Content-type: application/json');
    echo json_encode($response);
}
else if ($cmd == "getSecurityQuestions")
{
    $response = getSecurityQuestions($conn);
    header('Content-type: application/json');
    echo json_encode($response);
}

else // list all supported commands
{
  echo
  "
    <pre>
        Command: 
      
            Description: 
            
            Parameters: 

            Example:
                Query string: 
                Returns: 
  ";
}

function create($conn)
{
    // initialize status...
    $response["error"] = "";

    // validate inputs...
    $userName = getValue("userName", "");
    if ($userName == "")
    {
        $response["error"] = "Username is required.";
        return $response;
    }
    $userPass = getValue("userPass", "");
    if (strlen($userPass) < 8 || strlen($userPass) > 20)
    {
        $response["error"] = "Password is required and must be at least 8 and no more than 20 characters.";
        return $response;
    }
    $question1 = getValue("question1", "");
    if ($question1 == "")
    {
        $response["error"] = "Question1 is required.";
        return $response;
    }
    $answer1 = getValue("answer1", "");
    if ($answer1 == "")
    {
        $response["error"] = "Answer1 is required.";
        return $response;
    }
    $question2 = getValue("question2", "");
    if ($question2 == "")
    {
        $response["error"] = "Question2 is required.";
        return $response;
    }
    $answer2 = getValue("answer2", "");
    if ($answer2 == "")
    {
        $response["error"] = "Answer2 is required.";
        return $response;
    }
    
    
    // hash the password...
    $userPass = password_hash($userPass, PASSWORD_DEFAULT);
    $answer1 = password_hash($answer1, PASSWORD_DEFAULT);
    $answer2 = password_hash($answer2, PASSWORD_DEFAULT);
      
    // check to see if user exists...  
    $stmt = $conn->prepare("SELECT USER_ID FROM USER WHERE USER_NAME = ?");
    $stmt->bind_param("s", $userName);
    $stmt->execute();
    
    // if user does not exist, insert the user...
    if (!$stmt->fetch()) 
    {
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO USER(USER_NAME, USER_PASSWORD, USER_QUESTION1, USER_ANSWER1, USER_QUESTION2, USER_ANSWER2) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $userName, $userPass, $question1, $answer1, $question2, $answer2);
        $stmt->execute();
        
        $stmt->close();
        $stmt = $conn->prepare("SELECT USER_ID FROM USER WHERE USER_NAME = ?");
        $stmt->bind_param("s", $userName);
        $stmt->execute();
        $stmt->bind_result($userID);
        $stmt->fetch();
    }
    else // user does exist...
    {
        $response["error"] = sprintf("User %s already exists.", $userName);
        return $response;
    }
    
    // return response...
    $user["userID"] = $userID;
    $user["userName"] = $userName;
    $user["question1"] = $question1;
    $user["question2"] = $question2;
    $response["user"] = $user;
    setSessionValue("user", $user);
    $response["loggedIn"] = true;
    return $response;
}

function read($conn)
{
    // make sure the user is logged in...
    $response["loggedIn"] = getSessionValue("user", "") != "";
    if (!$response["loggedIn"])
    {
        $response["error"] = "You must login to view your user account.";
        return $response;
    }  
    
    // return the user...
    $response["user"] = getSessionValue("user", "");
    $response["loggedIn"] = getSessionValue("user", "") != "";
    return $response;
}

function update($conn)
{
    // make sure the user is logged in...
    $response["loggedIn"] = getSessionValue("user", "") != "";
    if (!$response["loggedIn"])
    {
        $response["error"] = "You must login to edit your user account.";
        return $response;
    }  
    
    // get the logged in user...
    $userID = getSessionValue("user", "")["userID"];
    
    // validate input values...
    $userName = getValue("userName", "");
    if ($userName == "")
    {
        $response["error"] = "Username is required.";
        return $response;
    }
    $userPass = getValue("userPass", "");
    if (strlen($userPass) < 8 || strlen($userPass) > 20)
    {
        $response["error"] = "Password is required and must be at least 8 and no more than 20 characters.";
        return $response;
    }
    
    // make sure the user exists...
    $stmt = $conn->prepare("SELECT USER_ID FROM USER WHERE USER_ID = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    if (!$stmt->fetch()) 
    {
        $response["error"] = sprintf("User %d does not exist.", $userID);
        return $response;
    }
    $stmt->close();

    // hash the password...
    $userPass = password_hash($userPass, PASSWORD_DEFAULT);

    // update the user...
    $stmt = $conn->prepare("UPDATE USER SET USER_NAME = ?, USER_PASSWORD = ? WHERE USER_ID = ?");
    $stmt->bind_param("ssi", $userName, $userPass, $userID);
    $stmt->execute();

    // return response...
    $user["userID"] = $userID;
    $user["userName"] = $userName;

    setSessionValue("user", $user);
    $response["user"] = $user;

    return $response;
}

function delete($conn)
{
    // make sure the user is logged in...
    $response["loggedIn"] = getSessionValue("user", "") != "";
    if (!$response["loggedIn"])
    {
        $response["error"] = "You must login to delete your user account.";
        return $response;
    }  
    
    // make sure the user exists...
    $userID = getSessionValue("user", "")["userID"];
    $stmt = $conn->prepare("SELECT USER_ID FROM USER WHERE USER_ID = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    if (!$stmt->fetch()) 
    {
        $response["error"] = sprintf("User %d does not exist.", $userID);
        return $response;
    }
    $stmt->close();
    
    // delete the user...
    $stmt = $conn->prepare("DELETE FROM USER WHERE USER_ID = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
 
    // log the user out...
    setSessionValue("user", "");
    $response["loggedIn"] = false;
    return $response;
}

function login($conn)
{
    // log the current user out...
    setSessionValue("user", "");

    // validate the input...
    $userName = getValue("userName", "");
    if ($userName == "")
    {
        $response["error"] = "Username is required when logging in user.";
        return $response;
    }
    $userPass = getValue("userPass", "");
    if ($userPass == "")
    {
        $response["error"] = "Password is required when logging in user.";
        return $response;
    }

    // select the user that is tyring to login...
    $stmt = $conn->prepare("SELECT USER_ID, USER_PASSWORD FROM USER WHERE USER_NAME Like ?");
    $stmt->bind_param("s", $userName);
    $stmt->execute();
    $stmt->bind_result($userID, $hashPassword);
    
    $user = array();
    if ($stmt->fetch()) 
    {
        if (password_verify($userPass , $hashPassword))
        {
            $user["userID"] = $userID;
            $user["userName"] = $userName;
            setSessionValue("user", $user);
        }
    }
    
    // if the user is empty, then the username/password is invalid...
    if (count($user) == 0)
    {
        $response["error"] = "Invalid username or password.";
        return $response;
    }

    // login successful, return the user...
    $response["user"] = $user;
    $response["loggedIn"] = getSessionValue("user", "") != "";
    return $response;
}

function logout()
{
    setSessionValue("user", "");
    $response["loggedIn"] = false;
    return $response;
}

function isLoggedIn()
{
    $user = getSessionValue("user", "");
    $response["loggedIn"] = getSessionValue("user", "") != "";
    $response["user"] = $user;
    return $response;
}

function getSecurityQuestions($conn)
{
    $isEmpty = true;
    $userName = getValue("userName", "");
    
    $stmt = $conn->prepare("SELECT USER_QUESTION1, USER_QUESTION2 From USER WHERE USER_NAME = ?");
    $stmt->bind_param("s", $userName);   
    $stmt->execute();
    $stmt->bind_result($q1,$q2);
    $rows = array();
    
    while($stmt->fetch())
    {
        $isEmpty = false;
        $row = array("status"=>"true","UserMsg"=>"User found.", "Question1"=>$q1,"Question2"=>$q2);
        $rows[] = $row;
    }
    if ($isEmpty == true)
    {
        return array(array("status"=>"false","UserMsg"=>"User not found, please try again!"));
    }
    else
    {
        return $rows;
    }
}

function changePassword($conn)
{
    $userName = getValue("userName", "");
    $newPass1 = getValue("userPass","");
    $newPass2 = getValue("userPass2","");
    $q1AnsInput = getValue("answer1","");
    $q2AnsInput = getValue("answer2","");
    
    $stmt = $conn->prepare("SELECT USER_ANSWER1, USER_ANSWER2 FROM USER WHERE USER_NAME = ?");
    $stmt->bind_param("s", $userName);
    $stmt->execute();
    $stmt->bind_result($q1Ans,$q2Ans);
    $stmt->fetch();
    $stmt->close();
    
    if(password_verify($q1AnsInput,$q1Ans) && password_verify($q2AnsInput,$q2Ans))
    {
        if (trim($newPass1) != trim($newPass2))
        {
            return array("answers"=>"false","Msg"=>"Passwords do not match");
        }
        else
        {
            if (strlen($newPass1) < 8 || strlen($newPass1) > 20)
            {
                $response["error"] = "Password is required and must be at least 8 and no more than 20 characters.";
                return $response;
            }
            else
            {
                $newPass1 = password_hash($newPass1,PASSWORD_DEFAULT);
                $stmt2 = $conn->prepare("UPDATE USER SET USER_PASSWORD = ? WHERE USER_NAME = ?");
                $stmt2->bind_param("ss",$newPass1,$userName);
               
                if(!$stmt2->execute()) 
                {
                    return array("answers"=>"false","Msg"=>"There is an issue, Please try again");
                }
                else
                {
                    return login($conn);
                    //return array("answers"=>"true","Msg"=>"Success!");
                }
            }
        }
    }
    else
    {
        return array("answers"=>"false","Msg"=>"Security answers do not match");
    }
}

?>
