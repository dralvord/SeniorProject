//**************************************************************************************************//
//                                                                                                  //
//							               Model                                                    //
//                                                                                                  //
//**************************************************************************************************//

var model = [];

//Starting values to show which tables
/*-----------Table Show--------------*/
model.camShow = true;
model.advShow = false;
model.actShow = false;
model.encShow = false;
model.monShow = false;
model.npcShow = false;
model.pcShow = false;
model.encToMon = false;
model.actToNPC = false;
/*-----------Return Show--------------*/
model.returnCamShow = false;
model.returnAdvShow = false;
model.returnActShow = false;
model.returnEncShow = false;
/*-----------Create Form Show--------------*/
model.createCamFormShow = false;
model.createCamButtonShow = true;
model.createAdvFormShow = false;
model.createAdvButtonShow = false;
model.createActFormShow = false;
model.createActButtonShow = false;
model.createEncFormShow = false;
model.createEncButtonShow = false;
model.createMonFormShow = false;
model.createMonButtonShow = false;
model.createNPCFormShow = false;
model.createNPCButtonShow = false;
model.createPCFormShow = false;
model.createPCButtonShow = false;
/*----------Add Dropdown Show--------------*/
model.npcDropdownShow = false;
model.npcDropdown =[];
model.monDropdownShow = false;
model.monDropdown = [];
/*-----------Edit Form Show--------------*/
model.editCamFormShow = false;
model.editAdvFormShow = false;
model.editActFormShow = false;
model.editEncFormShow = false;
model.editMonFormShow = false;
model.editNPCFormShow = false;
model.editPCFormShow = false;

/*-----------Data Arrays--------------*/
model.adventureData = [];
model.actData = [];
model.encounterData = [];
model.monsterData = [];
model.npcData = [];
model.pcData = [];

			
//**************************************************************************************************//
//                                                                                                  //
//							               View                                                     //
//                                                                                                  //
//**************************************************************************************************//
function updateView()
{
    $("#message").html("<div style = color:red>" + "");
    $("#CampaignTableBody").empty();
    $("#AdventureTableBody").empty();
    $("#ActTableBody").empty();
    $("#EncounterTableBody").empty();
    $("#MonsterTableBody").empty();
    $("#NPCTableBody").empty();
    $("#PCTableBody").empty();
    $("#PCTableBody").empty();
    
    if (model.error != undefined)
    {
        $("#message").html("<div style = color:red>" + model.error);
    }
    else 
    {
        /*------------------------------------------------------*/
        /*               Fill Tables with data                  */
        /*------------------------------------------------------*/
        if(model.campaignData.length > 0)
        {
            displayCampaignData();
        }
        
        if(model.adventureData.length > 0)
        {
            displayAdventureData();
        }
        
        if(model.actData.length > 0)
        {
            displayActData();
        }
        
        if(model.encounterData.length > 0)
        {
            displayEncounterData();
        }
        
        if(model.monsterData.length > 0)
        {
            displayMonsterData();
        }
        
        if(model.npcData.length > 0)
        {
            displayNPCData();
        }
        
        if(model.pcData.length > 0)
        {
            displayPCData();
        }
    }
    
    /*------------------------------------------------------*/
    /*                      Show Tables                     */
    /*------------------------------------------------------*/
    if(model.camShow == true)
    {
        $("div#campaignDiv").show();
    }
    else
    {
        $("div#campaignDiv").hide();
    }
    
    if(model.advShow == true)
    {
        $("div#adventureDiv").show();
    }
    else
    {
        $("div#adventureDiv").hide();
    }
    
    if(model.actShow == true)
    {
        $("div#actDiv").show();
    }
    else
    {
        $("div#actDiv").hide();
    }
    
    if(model.encShow == true)
    {
        $("div#encounterDiv").show();
    }
    else
    {
        $("div#encounterDiv").hide();
    }
    
    if(model.monShow == true)
    {
        $("div#monsterDiv").show();
    }
    else
    {
        $("div#monsterDiv").hide();
    }
    
    if(model.npcShow == true)
    {
        $("div#npcDiv").show();
    }
    else
    {
        $("div#npcDiv").hide();
    }
    
    if(model.pcShow == true)
    {
        $("div#pcDiv").show();
    }
    else
    {
        $("div#pcDiv").hide();
    }
    
    /*------------------------------------------------------*/
    /*                  Show Return Buttons                 */
    /*------------------------------------------------------*/
    if(model.returnCamShow == true)
    {
        $("div#returnToCamDiv").show();
    }
    else
    {
        $("div#returnToCamDiv").hide();
    }
    if(model.returnAdvShow == true)
    {
        $("div#returnToAdvDiv").show();
    }
    else
    {
        $("div#returnToAdvDiv").hide();
    }
    if(model.returnActShow == true)
    {
        $("div#returnToActDiv").show();
    }
    else
    {
        $("div#returnToActDiv").hide();
    }
    if(model.returnEncShow == true)
    {
        $("div#returnToEncDiv").show();
    }
    else
    {
        $("div#returnToEncDiv").hide();
    }
    
    /*------------------------------------------------------*/
    /*          Create Form and Create Show Buttons         */
    /*------------------------------------------------------*/
    /*---------Create Campaign Form and Button------------*/
    if(model.createCamFormShow == true)
    {
        $("div#createCamFormDiv").show();
    }
    else
    {
        $("div#createCamFormDiv").hide();
    }
    
    if(model.createCamButtonShow == true)
    {
        $("div#createCamShowDiv").show();
    }
    else
    {
        $("div#createCamShowDiv").hide();
    }
    
    /*---------Create Adventure Form and Button------------*/
    if(model.createAdvFormShow == true)
    {
        $("div#createAdvFormDiv").show();
    }
    else
    {
        $("div#createAdvFormDiv").hide();
    }
    
    if(model.createAdvButtonShow == true)
    {
        $("div#createAdvShowDiv").show();
    }
    else
    {
        $("div#createAdvShowDiv").hide();
    }
    
    /*-----------Create Act Form and Button--------------*/
    if(model.createActFormShow == true)
    {
        $("div#createActFormDiv").show();
    }
    else
    {
        $("div#createActFormDiv").hide();
    }
    
    if(model.createActButtonShow == true)
    {
        $("div#createActShowDiv").show();
    }
    else
    {
        $("div#createActShowDiv").hide();
    }
    
    /*-------Create Encounter Form and Button----------*/
    if(model.createEncFormShow == true)
    {
        $("div#createEncFormDiv").show();
    }
    else
    {
        $("div#createEncFormDiv").hide();
    }
    
    if(model.createEncButtonShow == true)
    {
        $("div#createEncShowDiv").show();
    }
    else
    {
        $("div#createEncShowDiv").hide();
    }
    
    /*-------Create Monster Form and Button----------*/
    if(model.createMonFormShow == true)
    {
        $("div#createMonFormDiv").show();
    }
    else
    {
        $("div#createMonFormDiv").hide();
    }
    
    if(model.createMonButtonShow == true)
    {
        $("div#createMonShowDiv").show();
    }
    else
    {
        $("div#createMonShowDiv").hide();
    }
    
    /*-------Create NPC Form and Button----------*/
    if(model.createNPCFormShow == true)
    {
        $("div#createNPCFormDiv").show();
    }
    else
    {
        $("div#createNPCFormDiv").hide();
    }
    
    if(model.createNPCButtonShow == true)
    {
        $("div#createNPCShowDiv").show();
    }
    else
    {
        $("div#createNPCShowDiv").hide();
    }
    
    /*-------Create PC Form and Button----------*/
    if(model.createPCFormShow == true)
    {
        $("div#createPCFormDiv").show();
    }
    else
    {
        $("div#createPCFormDiv").hide();
    }
    
    if(model.createPCButtonShow == true)
    {
        $("div#createPCShowDiv").show();
    }
    else
    {
        $("div#createPCShowDiv").hide();
    }
    
    
    /*------------------------------------------------------*/
    /*               Dropdown Hide and Show                 */
    /*------------------------------------------------------*/
    /*---------------NPC DropDown----------------*/
    if(model.npcDropdownShow == true)
    {
        $("div#npcDropdownDiv").show();
    }
    else
    {
        $("div#npcDropdownDiv").hide();
    }
    
    /*-------------Monster DropDown--------------*/
    if(model.monDropdownShow == true)
    {
        $("div#monDropdownDiv").show();
    }
    else
    {
        $("div#monDropdownDiv").hide();
    }
    
    /*------------------------------------------------------*/
    /*                  Edit Form Display                  */
    /*------------------------------------------------------*/
    /*---------------Edit Campaign Form----------------*/
    if(model.editCamFormShow == true)
    {
        $("div#editCamFormDiv").show();
    }
    else
    {
        $("div#editCamFormDiv").hide();
    }
    /*---------------Edit Adventure Form----------------*/
    if(model.editAdvFormShow == true)
    {
        $("div#editAdvFormDiv").show();
    }
    else
    {
        $("div#editAdvFormDiv").hide();
    }
    
    /*---------------Edit Act Form----------------*/
    if(model.editActFormShow == true)
    {
        $("div#editActFormDiv").show();
    }
    else
    {
        $("div#editActFormDiv").hide();
    }
    
    /*---------------Edit Encounter Form----------------*/
    if(model.editEncFormShow == true)
    {
        $("div#editEncFormDiv").show();
    }
    else
    {
        $("div#editEncFormDiv").hide();
    }
    
    /*---------------Edit Monster Form----------------*/
    if(model.editMonFormShow == true)
    {
        $("div#editMonFormDiv").show();
    }
    else
    {
        $("div#editMonFormDiv").hide();
    }
    
    /*------------------Edit NPC Form-------------------*/
    if(model.editNPCFormShow == true)
    {
        $("div#editNPCFormDiv").show();
    }
    else
    {
        $("div#editNPCFormDiv").hide();
    }
    
    /*------------------Edit PC Form-------------------*/
    if(model.editPCFormShow == true)
    {
        $("div#editPCFormDiv").show();
    }
    else
    {
        $("div#editPCFormDiv").hide();
    }
    
    /*------------------------------------------------------*/
    /*                      Show Modals                     */
    /*------------------------------------------------------*/
    if(model.camDescDialog == true)
    {
        ViewCamDescDialog();
    }
    else if(model.advDescDialog == true)
    {
        ViewAdvDescDialog();
    }
    else if(model.actStoryDialog == true)
    {
        ViewActStoryDialog();
    }
    else if(model.monStatsDialog == true)
    {
        ViewMonStatsDialog();
    }
    else if(model.npcStatsDialog == true)
    {
        ViewNPCStatsDialog();
    }
    else if(model.pcStatsDialog == true)
    {
        ViewPCStatsDialog();
    }
}


//**************************************************************************************************//
//                                                                                                  //
//							             Controller                                                 //
//                                                                                                  //
//**************************************************************************************************//
$(document).ready(function ()
{
	sendCommandCampaign("read");
});

//==================================================================================//
//							    View Buttons                                        //
//==================================================================================//

/*------------------------------------------------------*/
/*          Campaign Description View Button            */
/*------------------------------------------------------*/
$(document).on("click", ".camDescBtn", function()
{
	model.camDescBody = $(this).attr("cd");
	model.camDescHeader = $(this).attr("desc");
    model.camDescDialog = true;
    updateView();
});

/*------------------------------------------------------*/
/*          Adventure Description View Button           */
/*------------------------------------------------------*/
$(document).on("click", ".advDescBtn", function()
{
	model.advDescBody = $(this).attr("cd");
	model.advDescHeader = $(this).attr("desc");
    model.advDescDialog = true;
    updateView();
});

/*------------------------------------------------------*/
/*               Act Story View Button                  */
/*------------------------------------------------------*/
$(document).on("click", ".actStoryBtn", function()
{
	model.actStoryBody = $(this).attr("cd");
	model.actStoryHeader = $(this).attr("desc");
    model.actStoryDialog = true;
    updateView();
});


/*------------------------------------------------------*/
/*             Monster Stats View Button                */
/*------------------------------------------------------*/
$(document).on("click", ".monStatsBtn", function()
{
	model.monStatsBody = $(this).attr("cd");
	model.monStatsHeader = $(this).attr("desc");
    model.monStatsDialog = true;
    updateView();
});


/*------------------------------------------------------*/
/*               NPC Stats View Button                  */
/*------------------------------------------------------*/
$(document).on("click", ".npcStatsBtn", function()
{
	model.npcStatsBody = $(this).attr("cd");
	model.npcStatsHeader = $(this).attr("desc");
    model.npcStatsDialog = true;
    updateView();
});

/*------------------------------------------------------*/
/*               PC Stats View Button                  */
/*------------------------------------------------------*/
$(document).on("click", ".pcStatsBtn", function()
{
	model.pcStatsBody = $(this).attr("cd");
	model.pcStatsHeader = $(this).attr("desc");
    model.pcStatsDialog = true;
    updateView();
});

//==================================================================================//
//							    Show Buttons                                        //
//==================================================================================//

/*------------------------------------------------------*/
/*               Show Adventures Button                 */
/*------------------------------------------------------*/
$(document).on("click", ".showAdvBtn", function()
{
	model.camShow = false;
	model.advShow = true;
	model.returnCamShow = true;
	model.createCamButtonShow = false;
	model.createAdvButtonShow = true;
	model.currentCamID = "&camID=" + $(this).attr("cd");
	model.adventureInput = model.currentCamID;
	model.npcInput = model.currentCamID;
	sendCommandNPC("npcDropdown");
	sendCommandMonster("monDropdown");
	sendCommandAdventure("read");
    updateView();
});

/*------------------------------------------------------*/
/*                   Show Acts Button                   */
/*------------------------------------------------------*/
$(document).on("click", ".showActBtn", function()
{
	model.advShow = false;
	model.actShow = true;
	model.returnAdvShow = true;
	model.returnCamShow = false;
	model.createAdvButtonShow = false;
	model.createActButtonShow = true;
	model.currentAdvID = "&advID=" + $(this).attr("cd");
	model.actInput = model.currentAdvID;
	sendCommandAct("read");
    updateView();
});

/*------------------------------------------------------*/
/*                Show Encounters Button                */
/*------------------------------------------------------*/
$(document).on("click", ".showEncBtn", function()
{
	model.actShow = false;
	model.encShow = true;
	model.returnActShow = true;
	model.returnAdvShow = false;
	model.createActButtonShow = false;
	model.createEncButtonShow = true;
	model.currentActID = "&actID=" + $(this).attr("cd");
	model.encounterInput = model.currentActID;
	sendCommandEncounter("read");
    updateView();
});

/*------------------------------------------------------*/
/*                   Show ActNPCs Button                   */
/*------------------------------------------------------*/
$(document).on("click", ".showActNPCBtn", function()
{
	model.actShow = false;
	model.npcShow = true;
	model.returnActShow = true;
	model.returnAdvShow = false;
	model.createActButtonShow = false;
	model.npcDropdownShow = true;
	model.currentActID = "&actID=" + $(this).attr("cd");
	model.npcInput = model.currentActID + model.currentCamID;
	sendCommandNPC("readAct");
	loadNPCDropdown();
	model.actToNPC = true;
    updateView();
});

/*------------------------------------------------------*/
/*          Show Encounter Monsters Button              */
/*------------------------------------------------------*/
$(document).on("click", ".showEncMonBtn", function()
{
	model.encShow = false;
	model.monShow = true;
	model.returnEncShow = true;
	model.returnActShow = false;
	model.monDropdownShow = true;
	model.createEncButtonShow = false;
	model.currentEncID = "&encID=" + $(this).attr("cd");
	model.monsterInput = model.currentEncID;
	sendCommandMonster("readEnc");
	loadMonDropdown();
	model.encToMon = true;
	
    updateView();
});

/*------------------------------------------------------*/                  /**************************************************************************************************************************************************/
/*                 Show Monsters Button                 */                  /*I need to figure out what i want to do with monsters. I currently have them linked to campaign Id but i think thats wrong. Maybe no id is better*/
/*------------------------------------------------------*/                  /**************************************************************************************************************************************************/
$(document).on("click", ".showMonBtn", function()
{
	model.camShow = false;
	model.monShow = true;
	model.returnCamShow = true;
	model.createCamButtonShow = false;
	model.createMonButtonShow = true;
	model.currentCamID = "&camID=" + $(this).attr("cd");
	//model.monsterInput = "&camID=" + $(this).attr("cd");
	sendCommandMonster("readAll");
    updateView();
});

/*------------------------------------------------------*/
/*                  Show NPCs Button                    */
/*------------------------------------------------------*/
$(document).on("click", ".showNPCBtn", function()
{
	model.camShow = false;
	model.npcShow = true;
	model.returnCamShow = true;
	model.createCamButtonShow = false;
	model.createNPCButtonShow = true;
	model.currentCamID = "&camID=" + $(this).attr("cd");
	model.npcInput = model.currentCamID;
	sendCommandNPC("read");
    updateView();
});

/*------------------------------------------------------*/
/*                  Show PCs Button                    */
/*------------------------------------------------------*/
$(document).on("click", ".showPCBtn", function()
{
	model.camShow = false;
	model.pcShow = true;
	model.returnCamShow = true;
	model.createCamButtonShow = false;
	model.createPCButtonShow = true;
	model.currentCamID = "&camID=" + $(this).attr("cd");
	model.pcInput = model. currentCamID;
	sendCommandPC("read");
    updateView();
});



//==================================================================================//
//							   Return Buttons                                       //
//==================================================================================//
/*------------------------------------------------------*/
/*              Return to Campaigns Button              */
/*------------------------------------------------------*/
$(document).on("click", ".returnToCamBtn", function()
{
	model.camShow = true;
	model.advShow = false;
	model.monShow = false;
	model.npcShow = false;
	model.pcShow = false;
	model.returnCamShow = false;
	model.createCamButtonShow = true;
	model.createAdvButtonShow = false;
	model.createMonButtonShow = false;
	model.createNPCButtonShow = false;
	model.createPCButtonShow = false;
    updateView();
});

/*------------------------------------------------------*/
/*             Return to Adventures Button              */
/*------------------------------------------------------*/
$(document).on("click", ".returnToAdvBtn", function()
{
	model.advShow = true;
	model.actShow = false;
	model.returnAdvShow = false;
	model.returnCamShow = true;
	model.createAdvButtonShow = true;
	model.createActButtonShow = false;
    updateView();
});

/*------------------------------------------------------*/
/*             Return to Acts Button              */
/*------------------------------------------------------*/
$(document).on("click", ".returnToActBtn", function()
{
	model.actShow = true;
	model.encShow = false;
	model.npcShow = false;
	model.returnActShow = false;
	model.returnAdvShow = true;
	model.createEncButtonShow = false;
	model.npcDropdownShow = false;
	model.createActButtonShow = true;
	model.actToNPC = false;
    updateView();
});

/*------------------------------------------------------*/
/*             Return to Encounters Button              */
/*------------------------------------------------------*/
$(document).on("click", ".returnToEncBtn", function()
{
	model.encShow = true;
	model.monShow = false;
	model.returnEncShow = false;
	model.returnActShow = true;
	model.createEncButtonShow = true;
	model.monDropdownShow = false;
	model.encToMon = false;
    updateView();
});

//==================================================================================//
//							   Delete Buttons                                       //
//==================================================================================//

/*------------------------------------------------------*/
/*                  Delete Campaign Button              */
/*------------------------------------------------------*/
$(document).on("click", ".deleteCamBtn", function()
{
	model.campaignInput = "&camID=" + $(this).attr("cd");
	sendCommandCampaign("delete");
    updateView();
});

/*------------------------------------------------------*/
/*                  Delete Adventure Button             */
/*------------------------------------------------------*/
$(document).on("click", ".deleteAdvBtn", function()
{
	model.adventureInput = model.currentCamID + "&advID=" + $(this).attr("cd");
	sendCommandAdventure("delete");
    updateView();
});

/*------------------------------------------------------*/
/*                  Delete Act Button                   */
/*------------------------------------------------------*/
$(document).on("click", ".deleteActBtn", function()
{
	model.actInput = model.currentAdvID + "&actID=" + $(this).attr("cd");
	sendCommandAct("delete");
    updateView();
});

/*------------------------------------------------------*/
/*              Delete Encounter Button                 */
/*------------------------------------------------------*/
$(document).on("click", ".deleteEncBtn", function()
{
	model.encounterInput = model.currentActID +"&encID=" + $(this).attr("cd");
	sendCommandEncounter("delete");
    updateView();
});

/*------------------------------------------------------*/
/*              Delete Monster Button                 */
/*------------------------------------------------------*/
$(document).on("click", ".deleteMonBtn", function()
{
	if(model.returnEncShow)
	{
	    model.encMonInput += "&encMonID=" + $(this).attr("id")
	    sendCommandEncMon("delete");
	    sendCommandMonster("readEnc");
	}
	else
	{
	    model.monsterInput += "&monID=" + $(this).attr("cd");
	    sendCommandMonster("delete");
	}
    updateView();
});

/*------------------------------------------------------*/
/*                  Delete NPC Button                   */
/*------------------------------------------------------*/
$(document).on("click", ".deleteNPCBtn", function()
{
    if(model.actToNPC)
    {
        model.actNPCInput = model.currentActID + "&npcID=" + $(this).attr("cd");
        sendCommandActNPC("delete");
        sendCommandNPC("readAct");
    }
    else
    {
	    model.npcInput += "&npcID=" + $(this).attr("cd");
	    sendCommandNPC("delete");
	    //sendCommandNPC("npcDropdown");
	    //loadNPCDropdown();
    }
    updateView();
});

/*------------------------------------------------------*/
/*                  Delete PC Button                    */
/*------------------------------------------------------*/
$(document).on("click", ".deletePCBtn", function()
{
	model.pcInput = model.currentCamID +"&pcID=" + $(this).attr("cd");
	sendCommandPC("delete");
    updateView();
});

//==================================================================================//
//							   Create Buttons                                       //
//==================================================================================//

/*------------------------------------------------------*/
/*                  Create Campaign                     */
/*------------------------------------------------------*/
$("#createCamBtn").click(function()
{
    model.campaignInput = $("#createCamForm").serialize();
    sendCommandCampaign("create");
    model.createCamFormShow = false;
    model.createCamButtonShow = true;
    model.camShow = true;
    clearCreateCamForm();
    updateView();
});

$(document).on("click", ".createCamShowBtn", function()
{
    model.createCamFormShow = true;
    model.createCamButtonShow = false;
    model.camShow = false;
    updateView();
});

$("#createCamCancelBtn").click(function()
{
    model.createCamFormShow = false;
    model.createCamButtonShow = true;
    model.camShow = true;
    clearCreateCamForm();
    updateView();
});


/*------------------------------------------------------*/
/*                  Create Adventure                    */
/*------------------------------------------------------*/
$("#createAdvBtn").click(function()
{
    model.adventureInput = model.currentCamID + "&" + $("#createAdvForm").serialize();
    sendCommandAdventure("create");
    model.createAdvFormShow = false;
    model.createAdvButtonShow = true;
    model.advShow = true;
    model.returnCamShow = true;
    clearCreateAdvForm();
    updateView();
});

$(document).on("click", ".createAdvShowBtn", function()
{
    model.createAdvFormShow = true;
    model.createAdvButtonShow = false;
    model.advShow = false;
    model.returnCamShow = false;
    updateView();
});

$("#createAdvCancelBtn").click(function()
{
    model.createAdvFormShow = false;
    model.createAdvButtonShow = true;
    model.advShow = true;
    model.returnCamShow = true;
    clearCreateAdvForm();
    updateView();
});


/*------------------------------------------------------*/
/*                      Create Act                      */
/*------------------------------------------------------*/
$("#createActBtn").click(function()
{
    model.actInput = model.currentAdvID + "&" + $("#createActForm").serialize();
    sendCommandAct("create");
    model.createActFormShow = false;
    model.createActButtonShow = true;
    model.actShow = true;
    model.returnAdvShow = true;
    clearCreateActForm();
    updateView();
});

$(document).on("click", ".createActShowBtn", function()
{
    model.createActFormShow = true;
    model.createActButtonShow = false;
    model.actShow = false;
    model.returnAdvShow = false;
    updateView();
});

$("#createActCancelBtn").click(function()
{
    model.createActFormShow = false;
    model.createActButtonShow = true;
    model.actShow = true;
    model.returnAdvShow = true;
    clearCreateActForm();
    updateView();
});

/*------------------------------------------------------*/
/*                    Create Encounter                  */
/*------------------------------------------------------*/
$("#createEncBtn").click(function()
{
    model.encounterInput = model.currentActID + "&" + $("#createEncForm").serialize();
    sendCommandEncounter("create");
    model.createEncFormShow = false;
    model.createEncButtonShow = true;
    model.encShow = true;
    model.returnActShow = true;
    clearCreateEncForm();
    updateView();
});

$(document).on("click", ".createEncShowBtn", function()
{
    model.createEncFormShow = true;
    model.createEncButtonShow = false;
    model.encShow = false;
    model.returnActShow = false;
    updateView();
});

$("#createEncCancelBtn").click(function()
{
    model.createEncFormShow = false;
    model.createEncButtonShow = true;
    model.encShow = true;
    model.returnActShow = true;
    clearCreateEncForm();
    updateView();
});

/*------------------------------------------------------*/
/*                    Create Monster                   */
/*------------------------------------------------------*/
$("#createMonBtn").click(function()
{
    model.monsterInput = model.currentCamID + "&" + $("#createMonForm").serialize();
    sendCommandMonster("create");
    model.createMonFormShow = false;
    model.createMonButtonShow = true;
    model.monShow = true;
    model.returnCamShow = true;
    clearCreateMonForm();
    updateView();
});

$(document).on("click", ".createMonShowBtn", function()
{
    model.createMonFormShow = true;
    model.createMonButtonShow = false;
    model.monShow = false;
    model.returnCamShow = false;
    updateView();
});

$("#createMonCancelBtn").click(function()
{
    model.createMonFormShow = false;
    model.createMonButtonShow = true;
    model.monShow = true;
    model.returnCamShow = true;
    clearCreateMonForm();
    updateView();
});

/*------------------------------------------------------*/
/*                       Create NPC                     */
/*------------------------------------------------------*/
$("#createNPCBtn").click(function()
{
    model.npcInput = model.currentCamID + "&" + $("#createNPCForm").serialize();
    sendCommandNPC("create");
    //sendCommandNPC("npcDropdown");
    model.returnCamShow = true;
    model.npcShow = true;
    model.createNPCFormShow = false;
    model.createNPCButtonShow = true;
    //loadNPCDropdown();
    clearCreateNPCForm();
    updateView();
});

$(document).on("click", ".createNPCShowBtn", function()
{
    model.createNPCFormShow = true;
    model.createNPCButtonShow = false;
    model.npcShow = false;
    model.returnCamShow = false;
    model.returnActShow = false;
    updateView();
});

$("#createNPCCancelBtn").click(function()
{
    model.createNPCFormShow = false;
    model.createNPCButtonShow = true;
    model.npcShow = true;
    if(model.actToNPC)
    {
        model.returnActShow = true;
    }
    else
    {
        model.returnCamShow = true;
    }
    clearCreateNPCForm();
    updateView();
});

/*------------------------------------------------------*/
/*                       Create PC                     */
/*------------------------------------------------------*/
$("#createPCBtn").click(function()
{
    model.pcInput = model.currentCamID + "&" + $("#createPCForm").serialize();
    sendCommandPC("create");
    model.returnCamShow = true;
    model.pcShow = true;
    model.createPCFormShow = false;
    model.createPCButtonShow = true;
    clearCreatePCForm();
    updateView();
});

$(document).on("click", ".createPCShowBtn", function()
{
    model.createPCFormShow = true;
    model.createPCButtonShow = false;
    model.pcShow = false;
    model.returnCamShow = false;
    updateView();
});

$("#createPCCancelBtn").click(function()
{
    model.createPCFormShow = false;
    model.createPCButtonShow = true;
    model.pcShow = true;
    model.returnCamShow = true;
    clearCreatePCForm();
    updateView();
});

/*------------------------------------------------------*/
/*                     NPC Dropdown                     */
/*------------------------------------------------------*/
$(document).on("click", ".addNPCBtn", function()
{
    model.actNPCInput = $("#npcDropdownForm" ).serialize() + model.currentActID;
    sendCommandActNPC("create");
    sendCommandNPC("readAct");
    updateView();
});


$('#npcDropdown').change(function()
{
    var t = $('#npcDropdown :selected').val();
    $("#npcDropdownOutput").val(t);
});

/*------------------------------------------------------*/
/*                   Monster Dropdown                   */
/*------------------------------------------------------*/
$(document).on("click", ".addMonBtn", function()
{
    model.encMonInput = $("#monDropdownForm" ).serialize() + model.currentEncID;
    sendCommandEncMon("create");
    sendCommandMonster("readEnc");
    updateView();
});


$('#monDropdown').change(function()
{
    var t = $('#monDropdown :selected').val();
    $("#monDropdownOutput").val(t);
});

//==================================================================================//
//							     Edit Buttons                                       //
//==================================================================================//

/*------------------------------------------------------*/
/*                  Edit Campaign                     */
/*------------------------------------------------------*/
$("#editCamBtn").click(function()
{
    model.campaignInput = model.currentCamID + "&" + $("#editCamForm").serialize();
    sendCommandCampaign("update");
    model.editCamFormShow = false;
    model.createCamButtonShow = true;
    model.camShow = true;
    updateView();
});


$(document).on("click", ".editCamShowBtn", function()
{
    model.camShow = false;
    model.createCamButtonShow = false;
    model.editCamFormShow = true;
    model.returnCamShow = false;
    
    model.currentCamID = "camID=" + $(this).attr("id");
    $("#editCamName").val($(this).attr("name"));
    $("#editCamDesc").val($(this).attr("desc"));
    
    updateView();
});

$("#editCamCancelBtn").click(function()
{
    model.editCamFormShow = false;
    model.createCamButtonShow = true;
    model.camShow = true;
    updateView();
});

/*------------------------------------------------------*/
/*                  Edit Adventure                     */
/*------------------------------------------------------*/
$("#editAdvBtn").click(function()
{
    model.adventureInput = model.currentAdvID + "&" + $("#editAdvForm").serialize() + "&" + model.currentCamID;
    sendCommandAdventure("update");
    model.editAdvFormShow = false;
    model.advShow = true;
    model.returnCamShow = true;
    model.createAdvButtonShow = true;
    updateView();
});


$(document).on("click", ".editAdvShowBtn", function()
{
    model.advShow = false;
    model.createAdvButtonShow = false;
    model.editAdvFormShow = true;
    model.returnAdvShow = false;
    model.returnCamShow = false;
    
    model.currentAdvID = "advID=" + $(this).attr("id");
    $("#editAdvName").val($(this).attr("name"));
    $("#editAdvDesc").val($(this).attr("desc"));
    
    updateView();
});

$("#editAdvCancelBtn").click(function()
{
    model.returnCamShow = true;
    model.editAdvFormShow = false;
    model.createAdvButtonShow = true;
    model.advShow = true;
    updateView();
});

/*------------------------------------------------------*/
/*                  Edit Act                     */
/*------------------------------------------------------*/
$("#editActBtn").click(function()
{
    model.actInput = model.currentActID + "&" + $("#editActForm").serialize() + "&" + model.currentAdvID;
    sendCommandAct("update");
    model.editActFormShow = false;
    model.actShow = true;
    model.returnAdvShow = true;
    model.createActButtonShow = true;
    updateView();
});


$(document).on("click", ".editActShowBtn", function()
{
    model.actShow = false;
    model.createActButtonShow = false;
    model.editActFormShow = true;
    model.returnActShow = false;
    model.returnAdvShow = false;
    
    model.currentActID = "actID=" + $(this).attr("id");
    $("#editActName").val($(this).attr("name"));
    $("#editActStory").val($(this).attr("story"));
    
    updateView();
});

$("#editActCancelBtn").click(function()
{
    model.createActButtonShow = true;
    model.returnAdvShow = true;
    model.editActFormShow = false;
    model.actShow = true;
    updateView();
});

/*------------------------------------------------------*/
/*                   Edit Encounter                     */
/*------------------------------------------------------*/
$("#editEncBtn").click(function()
{
    model.encounterInput = model.currentEncID + "&" + $("#editEncForm").serialize() + "&" + model.currentActID;
    sendCommandEncounter("update");
    model.editEncFormShow = false;
    model.encShow = true;
    model.returnActShow = true;
    model.createEncButtonShow = true;
    updateView();
});


$(document).on("click", ".editEncShowBtn", function()
{
    model.encShow = false;
    model.createEncButtonShow = false;
    model.editEncFormShow = true;
    model.returnEncShow = false;
    model.returnActShow = false;
    
    model.currentEncID = "encID=" + $(this).attr("id");
    $("#editEncName").val($(this).attr("name"));
    $("#editEncDesc").val($(this).attr("desc"));
    
    updateView();
});

$("#editEncCancelBtn").click(function()
{
    model.createEncButtonShow = true;
    model.returnActShow = true;
    model.editEncFormShow = false;
    model.encShow = true;
    updateView();
});

/*------------------------------------------------------*/
/*                   Edit Monster                     */
/*------------------------------------------------------*/
$("#editMonBtn").click(function()
{
    model.monsterInput = model.currentMonID + "&" + $("#editMonForm").serialize() + model.currentCamID + model.currentEncID;
    sendCommandMonster("update");
    model.editMonFormShow = false;
    model.monShow = true;
    if(model.encToMon)
    {
        model.returnEncShow = true;
        model.monDropdownShow = true;
        sendCommandMonster("monDropdown");
        sendCommandMonster("readEnc");
        loadMonDropdown();
    }
    else
    {
        model.createMonButtonShow = true;
        model.returnCamShow = true;
    }
    updateView();
});


$(document).on("click", ".editMonShowBtn", function()
{
    model.monShow = false;
    model.createMonButtonShow = false;
    model.editMonFormShow = true;
    model.returnCamShow = false;
    model.returnEncShow = false;
    model.monDropdownShow = false;
    
    model.currentMonID = "monID=" + $(this).attr("id");
    $("#editMonName").val($(this).attr("name"));
    $("#editMonSizeTypeAlign").val($(this).attr("align"));
    $("#editMonAC").val($(this).attr("ac"));
    $("#editMonHP").val($(this).attr("hp"));
    $("#editMonSpeed").val($(this).attr("speed"));
    $("#editMonSTR").val($(this).attr("str"));
    $("#editMonDEX").val($(this).attr("dex"));
    $("#editMonCON").val($(this).attr("con"));
    $("#editMonINT").val($(this).attr("int"));
    $("#editMonWIS").val($(this).attr("wis"));
    $("#editMonCHA").val($(this).attr("cha"));
    $("#editMonVulnerabilities").val($(this).attr("vulnerabilities"));
    $("#editMonResistances").val($(this).attr("resistances"));
    $("#editMonImmunities").val($(this).attr("immunities"));
    $("#editMonLanguages").val($(this).attr("languages"));
    $("#editMonCR").val($(this).attr("cr"));
    $("#editMonSkills").val($(this).attr("skills"));
    $("#editMonProfBonus").val($(this).attr("profbonus"));
    $("#editMonSaveThrows").val($(this).attr("savethrows"));
    $("#editMonSenses").val($(this).attr("senses"));
    $("#editMonAbilities").val($(this).attr("abilities"));
    $("#editMonActions").val($(this).attr("actions"));
    $("#editMonLegendaryActions").val($(this).attr("legendaryactions"));
    
    
    updateView();
});

$("#editMonCancelBtn").click(function()
{
    if(model.encToMon)
    {
        model.returnEncShow = true;
        model.monDropdownShow = true;
    }
    else
    {
        model.createMonButtonShow = true;
        model.returnCamShow = true;
    }
    
    model.editMonFormShow = false;
    model.monShow = true;
    updateView();
});


/*------------------------------------------------------*/
/*                      Edit NPC                        */
/*------------------------------------------------------*/
$("#editNPCBtn").click(function()
{
    model.npcInput = model.currentNPCID + "&" + $("#editNPCForm").serialize() + model.currentCamID + model.currentActID;
    sendCommandNPC("update");
    model.editNPCFormShow = false;
    model.npcShow = true;
    
    if(model.actToNPC)
    {
        model.returnActShow = true;
        model.npcDropdownShow = true;
        sendCommandNPC("npcDropdown");
        sendCommandNPC("readAct");
        loadNPCDropdown();
    }
    else
    {
        model.createNPCButtonShow =true;
        model.returnCamShow = true;
    }
    updateView();
});


$(document).on("click", ".editNPCShowBtn", function()
{
    model.npcShow = false;
    model.createNPCButtonShow = false;
    model.editNPCFormShow = true;
    model.returnCamShow = false;
    model.returnActShow = false;
    model.npcDropdownShow = false;
    
    model.currentNPCID = "npcID=" + $(this).attr("id");
    $("#editNPCName").val($(this).attr("name"));
    $("#editNPCLevel").val($(this).attr("level"));
    $("#editNPCRace").val($(this).attr("race"));
    $("#editNPCClass").val($(this).attr("npcClass"));
    $("#editNPCAlign").val($(this).attr("align"));
    $("#editNPCAC").val($(this).attr("ac"));
    $("#editNPCHP").val($(this).attr("hp"));
    $("#editNPCSpeed").val($(this).attr("speed"));
    $("#editNPCSTR").val($(this).attr("str"));
    $("#editNPCDEX").val($(this).attr("dex"));
    $("#editNPCCON").val($(this).attr("con"));
    $("#editNPCINT").val($(this).attr("int"));
    $("#editNPCWIS").val($(this).attr("wis"));
    $("#editNPCCHA").val($(this).attr("cha"));
    $("#editNPCLanguages").val($(this).attr("languages"));
    $("#editNPCCR").val($(this).attr("cr"));
    $("#editNPCSkills").val($(this).attr("skills"));
    $("#editNPCProfBonus").val($(this).attr("profbonus"));
    $("#editNPCSaveThrows").val($(this).attr("savethrows"));
    $("#editNPCAbilities").val($(this).attr("abilities"));
    $("#editNPCActions").val($(this).attr("actions"));
    $("#editNPCBio").val($(this).attr("bio"));
    
    
    updateView();
});

$("#editNPCCancelBtn").click(function()
{
    if(model.actToNPC)
    {
        model.returnActShow = true;
        model.npcDropdownShow = true;
    }
    else
    {
        model.createNPCButtonShow = true;
        model.returnCamShow = true;
    }
    
    model.editNPCFormShow = false;
    model.npcShow = true;
    updateView();
});

/*------------------------------------------------------*/
/*                      Edit PC                        */
/*------------------------------------------------------*/
$("#editPCBtn").click(function()
{
    model.pcInput = model.currentPCID + "&" + $("#editPCForm").serialize() + model.currentCamID
    sendCommandPC("update");
    model.editPCFormShow = false;
    model.pcShow = true;
    model.returnCamShow = true;
    model.createPCButtonShow = true;
    updateView();
});


$(document).on("click", ".editPCShowBtn", function()
{
    model.pcShow = false;
    model.createPCButtonShow = false;
    model.editPCFormShow = true;
    model.returnCamShow = false;
    
    model.currentPCID = "pcID=" + $(this).attr("id");
    $("#editPCName").val($(this).attr("name"));
    $("#editPCLevel").val($(this).attr("level"));
    $("#editPCRace").val($(this).attr("race"));
    $("#editPCClass").val($(this).attr("pcClass"));
    $("#editPCAlign").val($(this).attr("align"));
    $("#editPCAC").val($(this).attr("ac"));
    $("#editPCHP").val($(this).attr("hp"));
    $("#editPCSpeed").val($(this).attr("speed"));
    $("#editPCSTR").val($(this).attr("str"));
    $("#editPCDEX").val($(this).attr("dex"));
    $("#editPCCON").val($(this).attr("con"));
    $("#editPCINT").val($(this).attr("int"));
    $("#editPCWIS").val($(this).attr("wis"));
    $("#editPCCHA").val($(this).attr("cha"));
    $("#editPCLanguages").val($(this).attr("languages"));
    $("#editPCSkills").val($(this).attr("skills"));
    $("#editPCProfBonus").val($(this).attr("profbonus"));
    $("#editPCSaveThrows").val($(this).attr("savethrows"));
    $("#editPCAbilities").val($(this).attr("abilities"));
    $("#editPCActions").val($(this).attr("actions"));
    $("#editPCBio").val($(this).attr("bio"));
    
    
    updateView();
});

$("#editPCCancelBtn").click(function()
{
    model.createPCButtonShow = true;
    model.returnCamShow = true;
    model.editPCFormShow = false;
    model.pcShow = true;
    updateView();
});
//#############################################################################################//
//                                                                                             //  
//                                  Connect to php Functions                                   //
//                                                                                             //
//#############################################################################################//

/*------------------------------------------------------*/
/*              Connect to campaign.php                 */
/*------------------------------------------------------*/
function sendCommandCampaign(cmd)
{
    var url = "../Server/campaign.php?cmd="+cmd;
    var request = $.post(url,model.campaignInput);
    request.done(function(json)
    {
        model.campaignData = json;
        updateView();
    });
    request.fail(function(jqXHR, textStatus, errorThrown)
    {
        $("#message").text(textStatus);
        console.log("fail object ", jqXHR);
        console.log("error thrown ", errorThrown);
        updateView();
    });
}

/*------------------------------------------------------*/
/*              Connect to adventure.php                */
/*------------------------------------------------------*/
function sendCommandAdventure(cmd)
{
    var url = "../Server/adventure.php?cmd="+cmd;
    //var data = "";
    var request = $.post(url,model.adventureInput);
    request.done(function(json)
    {
        model.adventureData = json;
        updateView();
    });
    request.fail(function(jqXHR, textStatus, errorThrown)
    {
        $("#message").text(textStatus);
        console.log("fail object ", jqXHR);
        console.log("error thrown ", errorThrown);
        updateView();
    });
}

/*------------------------------------------------------*/
/*              Connect to act.php                      */
/*------------------------------------------------------*/
function sendCommandAct(cmd)
{
    var url = "../Server/act.php?cmd="+cmd;
    //var data = "";
    var request = $.post(url,model.actInput);
    request.done(function(json)
    {
        model.actData = json;
        updateView();
    });
    request.fail(function(jqXHR, textStatus, errorThrown)
    {
        $("#message").text(textStatus);
        console.log("fail object ", jqXHR);
        console.log("error thrown ", errorThrown);
        updateView();
    });
}

/*------------------------------------------------------*/
/*              Connect to encounter.php                */
/*------------------------------------------------------*/
function sendCommandEncounter(cmd)
{
    var url = "../Server/encounter.php?cmd="+cmd;
    //var data = "";
    var request = $.post(url,model.encounterInput);
    request.done(function(json)
    {
        model.encounterData = json;
        updateView();
    });
    request.fail(function(jqXHR, textStatus, errorThrown)
    {
        $("#message").text(textStatus);
        console.log("fail object ", jqXHR);
        console.log("error thrown ", errorThrown);
        updateView();
    });
}

/*------------------------------------------------------*/
/*              Connect to monster.php                  */
/*------------------------------------------------------*/
function sendCommandMonster(cmd)
{
    var url = "../Server/monster.php?cmd="+cmd;
    var request = $.post(url,model.monsterInput);
    request.done(function(json)
    {
        if(cmd == "monDropdown")
        {
            model.monDropdown = json;   
        }
        else
        {
            model.monsterData = json;
        }
        updateView();
    });
    request.fail(function(jqXHR, textStatus, errorThrown)
    {
        $("#message").text(textStatus);
        console.log("fail object ", jqXHR);
        console.log("error thrown ", errorThrown);
        updateView();
    });
}

/*------------------------------------------------------*/
/*              Connect to npc.php                      */
/*------------------------------------------------------*/
function sendCommandNPC(cmd)
{
    var url = "../Server/npc.php?cmd="+cmd;
    //var data = "";
    var request = $.post(url,model.npcInput);
    request.done(function(json)
    {
        if(cmd == "npcDropdown")
        {
            model.npcDropdown = json;
        }
        else
        {
            model.npcData = json;
        }
        updateView();
    });
    request.fail(function(jqXHR, textStatus, errorThrown)
    {
        $("#message").text(textStatus);
        console.log("fail object ", jqXHR);
        console.log("error thrown ", errorThrown);
        updateView();
    });
}

/*------------------------------------------------------*/
/*              Connect to pc.php                       */
/*------------------------------------------------------*/
function sendCommandPC(cmd)
{
    var url = "../Server/pc.php?cmd="+cmd;
    var request = $.post(url,model.pcInput);
    request.done(function(json)
    {
        model.pcData = json;
        updateView();
    });
    request.fail(function(jqXHR, textStatus, errorThrown)
    {
        $("#message").text(textStatus);
        console.log("fail object ", jqXHR);
        console.log("error thrown ", errorThrown);
        updateView();
    });
}

/*------------------------------------------------------*/
/*              Connect to actnpc.php                   */
/*------------------------------------------------------*/
function sendCommandActNPC(cmd)
{
    var url = "../Server/actnpc.php?cmd="+cmd;
    //var data = "";
    var request = $.post(url,model.actNPCInput);
    request.done(function(json)
    {
        model.actNPCData = json;
        updateView();
    });
    request.fail(function(jqXHR, textStatus, errorThrown)
    {
        $("#message").text(textStatus);
        console.log("fail object ", jqXHR);
        console.log("error thrown ", errorThrown);
        updateView();
    });
}

/*------------------------------------------------------*/
/*              Connect to encmon.php                   */
/*------------------------------------------------------*/
function sendCommandEncMon(cmd)
{
    var url = "../Server/encmon.php?cmd="+cmd;
    //var data = "";
    var request = $.post(url,model.encMonInput);
    request.done(function(json)
    {
        model.encMonData = json;
        updateView();
    });
    request.fail(function(jqXHR, textStatus, errorThrown)
    {
        $("#message").text(textStatus);
        console.log("fail object ", jqXHR);
        console.log("error thrown ", errorThrown);
        updateView();
    });
}

//**************************************************************************************************//
//                                                                                                  //
//							             Helper Functions                                           //
//                                                                                                  //
//**************************************************************************************************//

//==================================================================================//
//							Display Functions                                       //
//==================================================================================//


/*------------------------------------------------------*/
/*          Display Campaign data                       */
/*------------------------------------------------------*/
function displayCampaignData()
{
    for (var i in model.campaignData)
    {
        var row = model.campaignData[i];
		$("#CampaignTableBody").append("<tr>"+
		//"<td>"+row.CampaignID+"</td>"+
		"<td>"+row.CampaignName+"</td>"+
		"<td><a cd='"+row.CampaignDescription + 
		    " ' desc='Story' href='#' class='camDescBtn btn-default btn-info btn-sm'>View</a></td>"+
		"<td><a cd ='"+row.CampaignID+"'href='#' class='showAdvBtn btn-default btn-info btn-sm'>Show</a></td>"+
		"<td><a cd ='"+row.CampaignID+"'href='#' class='showMonBtn btn-default btn-info btn-sm'>Show</a></td>"+
		"<td><a cd ='"+row.CampaignID+"'href='#' class='showNPCBtn btn-default btn-info btn-sm'>Show</a></td>"+
		"<td><a cd ='"+row.CampaignID+"'href='#' class='showPCBtn btn-default btn-info btn-sm'>Show</a></td>"+
		"<td><a id='"+ row.CampaignID + "'name ='"+row.CampaignName+"'desc ='"+row.CampaignDescription+"'href='#' class='editCamShowBtn btn-default btn-info btn-sm' aria-label='edit'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a></td>"+
		"<td><a cd ='"+row.CampaignID+"'href='#' class='deleteCamBtn btn-default btn-info btn-sm' aria-label='Delete'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></td>"+
		"</tr>");
    }
}

/*------------------------------------------------------*/
/*          Display Adventure data                      */
/*------------------------------------------------------*/
function displayAdventureData()
{
    for (var i in model.adventureData)
    {
        var row = model.adventureData[i];
		$("#AdventureTableBody").append("<tr>"+
		//"<td>"+row.AdventureID+"</td>"+
		"<td>"+row.AdventureName+"</td>"+
		"<td><a cd='"+row.AdventureDescription + 
		    " ' desc='Story' href='#' class='advDescBtn btn-default btn-info btn-sm'>View</a></td>"+
		"<td><a cd ='"+row.AdventureID+"'href='#' class='showActBtn btn-default btn-info btn-sm'>Show</a></td>"+
		"<td><a id='"+ row.AdventureID + "'name ='"+row.AdventureName+"'desc ='"+row.AdventureDescription+"'href='#' class='editAdvShowBtn btn-default btn-info btn-sm' aria-label='edit'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a></td>"+
		"<td><a cd ='"+row.AdventureID+"'href='#' class='deleteAdvBtn btn-default btn-info btn-sm' aria-label='Delete'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></td>"+
		//"<td>"+row.CampaignID+"</td>"+
		"</tr>");
    }
}

/*------------------------------------------------------*/
/*          Display Act data                            */
/*------------------------------------------------------*/
function displayActData()
{
    for (var i in model.actData)
    {
        var row = model.actData[i];
		$("#ActTableBody").append("<tr>"+
		//"<td>"+row.ActID+"</td>"+
		"<td>"+row.ActName+"</td>"+
	    "<td><a cd='"+row.ActStory + 
		    " ' desc='Story' href='#' class='actStoryBtn btn-default btn-info btn-sm'>View</a></td>"+
		"<td><a cd ='"+row.ActID+"'href='#' class='showEncBtn btn-default btn-info btn-sm'>Show</a></td>"+
		"<td><a cd ='"+row.ActID+"'href='#' class='showActNPCBtn btn-default btn-info btn-sm'>Show</a></td>"+
		"<td><a id='"+ row.ActID + "'name ='"+row.ActName+"'story ='"+row.ActStory+"'href='#' class='editActShowBtn btn-default btn-info btn-sm' aria-label='edit'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a></td>"+
		"<td><a cd ='"+row.ActID+"'href='#' class='deleteActBtn btn-default btn-info btn-sm' aria-label='Delete'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></td>"+
		//"<td>"+row.AdventureID+"</td>"+
		"</tr>");
    }
}

/*------------------------------------------------------*/
/*          Display Encounter data                            */
/*------------------------------------------------------*/
function displayEncounterData()
{
    for (var i in model.encounterData)
    {
        var row = model.encounterData[i];
		$("#EncounterTableBody").append("<tr>"+
		//"<td>"+row.EncID+"</td>"+
		"<td>"+row.EncName+"</td>"+
		"<td>"+row.EncDesc+"</td>"+
		"<td><a cd ='"+row.EncID+"'href='#' class='showEncMonBtn btn-default btn-info btn-sm'>Show</a></td>"+
		"<td><a id='"+ row.EncID + "'name ='"+row.EncName+"'desc ='"+row.EncDesc+"'href='#' class='editEncShowBtn btn-default btn-info btn-sm' aria-label='edit'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a></td>"+
		"<td><a cd ='"+row.EncID+"'href='#' class='deleteEncBtn btn-default btn-info btn-sm' aria-label='Delete'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></td>"+
		//"<td>"+row.ActID+"</td>"+
		"</tr>");
    }
}

/*------------------------------------------------------*/
/*          Display Monster data                        */
/*------------------------------------------------------*/
function displayMonsterData()
{
    for (var i in model.monsterData)
    {
        var row = model.monsterData[i];
	    $("#MonsterTableBody").append("<tr>"+
	    //"<td>"+row.MonsterID+"</td>"+
	    "<td>"+row.MonsterName+"</td>"+
	    "<td><a cd='"+row.MonsterStats +" ' desc='"+row.MonsterName
		     + " Stats' href='#' class='monStatsBtn btn-default btn-info btn-sm'>View</a></td>"+
		//Edit Button-------------
		"<td><a id='"+ row.MonsterID + "'name ='"+row.MonsterName+"'align ='"+row.MonsterSizeTypeAlign+"'ac ='"+row.MonsterAC+"'hp ='"+row.MonsterHP+
		    "'speed ='"+row.MonsterSpeed+"'str ='"+row.MonsterSTR+"'dex ='"+row.MonsterDEX+"'con ='"+row.MonsterCON+"'int ='"+row.MonsterINT+"'wis ='"+row.MonsterWIS+
		    "'cha ='"+row.MonsterCHA+"'vulnerabilities ='"+row.MonsterVulnerabilities+"'resistances ='"+row.MonsterResistances+"'languages ='"+row.MonsterLanguages+"'immunities ='"+row.MonsterImmunities+
		    "'cr ='"+row.MonsterCR+"'skills ='"+row.MonsterSkills+"'profbonus ='"+row.MonsterProfBonus+"'savethrows ='"+row.MonsterSaveThrows+"'senses ='"+row.MonsterSenses+
		    "'abilities ='"+row.MonsterAbilities+"'actions ='"+row.MonsterActions+"'legendaryactions ='"+row.MonsterLegendaryActions+
		"'href='#' class='editMonShowBtn btn-default btn-info btn-sm' aria-label='edit'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a></td>"+
		//------------------
		"<td><a id='"+ row.EncMonID + "'cd ='"+row.MonsterID+"'href='#' class='deleteMonBtn btn-default btn-info btn-sm' aria-label='Delete'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></td>"+
	    "</tr>");
    }
}

/*------------------------------------------------------*/
/*              Display NPC data                        */
/*------------------------------------------------------*/
function displayNPCData()
{
    for (var i in model.npcData)
    {
        var row = model.npcData[i];
	    $("#NPCTableBody").append("<tr>"+
	    //"<td>"+row.NPCID+"</td>"+
	    "<td>"+row.NPCName+"</td>"+
	    "<td><a cd='"+row.NPCStats +" ' desc='"+row.NPCName
		     + " Stats' href='#' class='npcStatsBtn btn-default btn-info btn-sm'>View</a></td>"+
		     //Edit Button-------------
		"<td><a id='"+ row.NPCID + "'name ='"+row.NPCName+"'level ='"+row.NPCLevel+"'race ='"+row.NPCRace+"'npcClass ='"+row.NPCClass+
		    "'align ='"+row.NPCAlign+"'ac ='"+row.NPCAC+"'hp ='"+row.NPCHP+"'speed ='"+row.NPCSpeed+"'str ='"+row.NPCSTR+"'dex ='"+row.NPCDEX+"'con ='"+row.NPCCON+
		    "'int ='"+row.NPCINT+"'wis ='"+row.NPCWIS+"'cha ='"+row.NPCCHA+"'languages ='"+row.NPCLanguages+"'cr ='"+row.NPCCR+"'skills ='"+row.NPCSkills+
		    "'profbonus ='"+row.NPCProfBonus+"'savethrows ='"+row.NPCSaveThrows+ "'abilities ='"+row.NPCAbilities+"'actions ='"+row.NPCActions+"'bio ='"+row.NPCBio+
		"'href='#' class='editNPCShowBtn btn-default btn-info btn-sm' aria-label='edit'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a></td>"+
	
		"<td><a cd ='"+row.NPCID+"'href='#' class='deleteNPCBtn btn-default btn-info btn-sm' aria-label='Delete'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></td>"+
	    "</tr>");
    }
}

/*------------------------------------------------------*/
/*              Display PC data                        */
/*------------------------------------------------------*/
function displayPCData()
{
    for (var i in model.pcData)
    {
        var row = model.pcData[i];
	    $("#PCTableBody").append("<tr>"+
	    //"<td>"+row.PCID+"</td>"+
	    "<td>"+row.PCName+"</td>"+
	    "<td><a cd='"+row.PCStats +" ' desc='"+row.PCName
		     + " Stats' href='#' class='pcStatsBtn btn-default btn-info btn-sm'>View</a></td>"+
		//Edit Button-----------------------
		"<td><a id='"+ row.PCID + "'name ='"+row.PCName+"'level ='"+row.PCLevel+"'race ='"+row.PCRace+"'pcClass ='"+row.PCClass+
		    "'align ='"+row.PCAlign+"'ac ='"+row.PCAC+"'hp ='"+row.PCHP+"'speed ='"+row.PCSpeed+"'str ='"+row.PCSTR+"'dex ='"+row.PCDEX+"'con ='"+row.PCCON+
		    "'int ='"+row.PCINT+"'wis ='"+row.PCWIS+"'cha ='"+row.PCCHA+"'languages ='"+row.PCLanguages+"'skills ='"+row.PCSkills+
		    "'profbonus ='"+row.PCProfBonus+"'savethrows ='"+row.PCSaveThrows+ "'abilities ='"+row.PCAbilities+"'actions ='"+row.PCActions+"'bio ='"+row.PCBio+
		"'href='#' class='editPCShowBtn btn-default btn-info btn-sm' aria-label='edit'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a></td>"+
		
		"<td><a cd ='"+row.PCID+"'href='#' class='deletePCBtn btn-default btn-info btn-sm' aria-label='Delete'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></td>"+
	    "</tr>");
    }
}

//==================================================================================//
//				    		Modal Display Functions                                 //
//==================================================================================//

/*------------------------------------------------------*/
/*          Display Campaign Description Modal          */
/*------------------------------------------------------*/
function ViewCamDescDialog()
{
    $("#camDescModalBody").html("<pre><code>" + model.camDescBody + "</code></pre>");
    $("#camDescModalHeader").html("<h4>" + model.camDescHeader + "</h4>");
    $("#camDescModal").modal("show");
    model.camDescDialog = false;
}

/*------------------------------------------------------*/
/*         Display Adventure Description Modal          */
/*------------------------------------------------------*/
function ViewAdvDescDialog()
{
    $("#advDescModalBody").html("<pre><code>" + model.advDescBody + "</code></pre>");
    $("#advDescModalHeader").html("<h4>" + model.advDescHeader + "</h4>");
    $("#advDescModal").modal("show");
    model.advDescDialog = false;
}

/*------------------------------------------------------*/
/*                Display Act Story Modal               */
/*------------------------------------------------------*/
function ViewActStoryDialog()
{
    $("#actStoryModalBody").html("<pre><code>" + model.actStoryBody + "</code></pre>");
    $("#actStoryModalHeader").html("<h4>" + model.actStoryHeader + "</h4>");
    $("#actStoryModal").modal("show");
    model.actStoryDialog = false;
}

/*------------------------------------------------------*/
/*              Display Monster Stats Modal             */
/*------------------------------------------------------*/
function ViewMonStatsDialog()
{
    $("#monStatsModalBody").html("<pre><code>" + model.monStatsBody + "</code></pre>");
    $("#monStatsModalHeader").html("<h4>" + model.monStatsHeader + "</h4>");
    $("#monStatsModal").modal("show");
    model.monStatsDialog = false;
}

/*------------------------------------------------------*/
/*              Display NPC Stats Modal                 */
/*------------------------------------------------------*/
function ViewNPCStatsDialog()
{
    $("#npcStatsModalBody").html("<pre><code>" + model.npcStatsBody + "</code></pre>");
    $("#npcStatsModalHeader").html("<h4>" + model.npcStatsHeader + "</h4>");
    $("#npcStatsModal").modal("show");
    model.npcStatsDialog = false;
}

/*------------------------------------------------------*/
/*              Display PC Stats Modal                  */
/*------------------------------------------------------*/
function ViewPCStatsDialog()
{
    $("#pcStatsModalBody").html("<pre><code>" + model.pcStatsBody + "</code></pre>");
    $("#pcStatsModalHeader").html("<h4>" + model.pcStatsHeader + "</h4>");
    $("#pcStatsModal").modal("show");
    model.pcStatsDialog = false;
}

//==================================================================================//
//				    	    Create Form Clear Functions                             //
//==================================================================================//

/*------------------------------------------------------*/
/*              Clear Create Campaign Form              */
/*------------------------------------------------------*/
function clearCreateCamForm()
{
	$("#createCamName").val("");
    $("#createCamDesc").val("");
}

/*------------------------------------------------------*/
/*             Clear Create Adventure Form              */
/*------------------------------------------------------*/
function clearCreateAdvForm()
{
	$("#createAdvName").val("");
    $("#createAdvDesc").val("");
}

/*------------------------------------------------------*/
/*                Clear Create Act Form                 */
/*------------------------------------------------------*/
function clearCreateActForm()
{
	$("#createActName").val("");
    $("#createActStory").val("");
}

/*------------------------------------------------------*/
/*            Clear Create Encounter Form               */
/*------------------------------------------------------*/
function clearCreateEncForm()
{
	$("#createEncName").val("");
    $("#createEncDesc").val("");
}


/*------------------------------------------------------*/
/*            Clear Create Monster Form               */
/*------------------------------------------------------*/
function clearCreateMonForm()
{
	$("#createMonName").val("");
    $("#createMonSizeTypeAlign").val("");
    $("#createMonAC").val("");
    $("#createMonHP").val("");
    $("#createMonSpeed").val("");
    $("#createMonSTR").val("");
    $("#createMonDEX").val("");
    $("#createMonCON").val("");
    $("#createMonINT").val("");
    $("#createMonWIS").val("");
    $("#createMonCHA").val("");
    $("#createMonVulnerabilities").val("");
    $("#createMonResistances").val("");
    $("#createMonImmunities").val("");
    $("#createMonLanguages").val("");
    $("#createMonCR").val("");
    $("#createMonSkills").val("");
    $("#createMonProfBonus").val("");
    $("#createMonSaveThrows").val("");
    $("#createMonSenses").val("");
    $("#createMonAbilities").val("");
    $("#createMonActions").val("");
    $("#createMonLegendaryActions").val("");
    
}

/*------------------------------------------------------*/
/*            Clear Create NPC Form               */
/*------------------------------------------------------*/
function clearCreateNPCForm()
{
	$("#createNPCName").val("");
    $("#createNPCLevel").val("");
    $("#createNPCRace").val("");
    $("#createNPCClass").val("");
    $("#createNPCAlign").val("");
    $("#createNPCAC").val("");
    $("#createNPCHP").val("");
    $("#createNPCSpeed").val("");
    $("#createNPCSTR").val("");
    $("#createNPCDEX").val("");
    $("#createNPCCON").val("");
    $("#createNPCINT").val("");
    $("#createNPCWIS").val("");
    $("#createNPCCHA").val("");
    $("#createNPCLanguages").val("");
    $("#createNPCCR").val("");
    $("#createNPCSkills").val("");
    $("#createNPCProfBonus").val("");
    $("#createNPCSaveThrows").val("");
    $("#createNPCAbilities").val("");
    $("#createNPCActions").val("");
    $("#createNPCBio").val("");
    
}

/*------------------------------------------------------*/
/*            Clear Create PC Form               */
/*------------------------------------------------------*/
function clearCreatePCForm()
{
	$("#createPCName").val("");
    $("#createPCLevel").val("");
    $("#createPCRace").val("");
    $("#createPCClass").val("");
    $("#createPCAlign").val("");
    $("#createPCAC").val("");
    $("#createPCHP").val("");
    $("#createPCSpeed").val("");
    $("#createPCSTR").val("");
    $("#createPCDEX").val("");
    $("#createPCCON").val("");
    $("#createPCINT").val("");
    $("#createPCWIS").val("");
    $("#createPCCHA").val("");
    $("#createPCLanguages").val("");
    $("#createPCCR").val("");
    $("#createPCSkills").val("");
    $("#createPCProfBonus").val("");
    $("#createPCSaveThrows").val("");
    $("#createPCAbilities").val("");
    $("#createPCActions").val("");
    $("#createPCBio").val("");
    
}


//==================================================================================//
//				    	    Fill dropdowns Functions                             //
//==================================================================================//

function loadNPCDropdown()
{
    $('#npcDropdownSelect').empty();
    for(var i in model.npcDropdown)
    {
        var row = model.npcDropdown[i];
        $('<option />', {value: row.NPCID, text: row.NPCName}).appendTo('#npcDropdownSelect');
    }
    $("#npcDropdownOutput").val(model.npcDropdown[0].NPCID);
}

function loadMonDropdown()
{
    $('#monDropdownSelect').empty();
    for(var i in model.monDropdown)
    {
        var row = model.monDropdown[i];
        $('<option />', {value: row.MonID, text: row.MonName}).appendTo('#monDropdownSelect');
    }
    $("#monDropdownOutput").val(model.monDropdown[0].MonID);
}

