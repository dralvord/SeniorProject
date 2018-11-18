USE CampaignManager;

INSERT INTO CAMPAIGN(CAM_NAME, CAM_DESC) VALUES('Test Campaign', 'This is a test campaign for test purposes');
INSERT INTO CAMPAIGN(CAM_NAME, CAM_DESC) VALUES('Orc Fall', 'This is a campaign about the fall of the orcs. They start out controlling the entire world but by the end they control only a small part because of our heroes.');

INSERT INTO ADVENTURE(ADV_NAME, ADV_DESC,CAM_ID) VALUES ('My first adventure', 'This is my first adventure in the test campaign', 1);
INSERT INTO ADVENTURE(ADV_NAME, ADV_DESC,CAM_ID) VALUES ('The Quest for Orc Bane', 'This adventure sends the adventurers out on a quest to retrieve Orc Bane a legendary axe that slays orcs.', 2);

INSERT INTO ACT(ACT_NAME, ACT_STORY, ADV_ID) VALUES ('Act 1 - A Tavern Meeting', 'Our adventurers enter a tavern and sit at the bar. The bartender asks what they would like to drink...', 1);
INSERT INTO ACT(ACT_NAME, ACT_STORY, ADV_ID) VALUES ('Act 1 - A Nocturnal Ambush', 'Our adventurers are ambushed by orcs in the woods on their way to a meeting with the town elder...', 2);

INSERT INTO ENCOUNTER(ENC_NAME, ENC_DESC, ACT_ID) VALUES ('Bar fight', '2 Bandits', 1);
INSERT INTO ENCOUNTER(ENC_NAME, ENC_DESC, ACT_ID) VALUES ('Nocturnal Ambush', '3 Orcs', 2);

INSERT INTO MONSTER(MON_NAME, MON_SIZETYPEALIGN, MON_AC, MON_HP, MON_SPEED, MON_STR, MON_DEX, MON_CON, MON_INT, MON_WIS, MON_CHA, MON_LANGUAGES, MON_CR, MON_SENSES, MON_ACTIONS, CAM_ID)
        VALUES ('Bandit', 'Medium Humanoid Chaotic Neutral', '12 Leather Armor', '11(2d8+2)','30ft', '11(+0)', '12(+1)', '12(+1)', '10(+0)', '10(+0)', '10(+0)', 'Common', '1/8 (25XP)', 'Passive Perception 10', 'Scimitar: Melee Weapon Attack: +3 to hit, reach 5 ft., one target. Hit: 4(1d6+1) slashing damage\nLight Crossbow: Ranged Weapon Attack: +3 to hit, range 80 ft./320 ft., one target. Hit: 5(1d8+1) piercing damage.', 1);
INSERT INTO MONSTER(MON_NAME, MON_SIZETYPEALIGN, MON_AC, MON_HP, MON_SPEED, MON_STR, MON_DEX, MON_CON, MON_INT, MON_WIS, MON_CHA, MON_LANGUAGES, MON_CR, MON_SENSES, MON_ACTIONS, CAM_ID)
        VALUES ('Orc', 'Medium Humanoid Chaotic Evil', '15 Scale Armor', '15(3d8+2)','30ft', '16(+3)', '12(+1)', '16(+3)', '6(-2)', '10(+0)', '10(+0)', 'Common, Orcish', '1 (100XP)', 'Passive Perception 10', 'Club: Melee Weapon Attack: +3 to hit, reach 5 ft., one target. Hit: 5(1d8+1) bludgeoning damage\nLight Crossbow: Ranged Weapon Attack: +3 to hit, range 80 ft./320 ft., one target. Hit: 5(1d8+1) piercing damage.', 1);


INSERT INTO ENCMON(MON_ID, ENC_ID) VALUES ('1', '1');
INSERT INTO ENCMON(MON_ID, ENC_ID) VALUES ('1', '1');
INSERT INTO ENCMON(MON_ID, ENC_ID) VALUES ('2', '2');
INSERT INTO ENCMON(MON_ID, ENC_ID) VALUES ('2', '2');
INSERT INTO ENCMON(MON_ID, ENC_ID) VALUES ('2', '2');

INSERT INTO NPC(NPC_NAME, NPC_LEVEL, NPC_RACE, NPC_CLASS, NPC_ALIGN, NPC_AC, NPC_HP, NPC_SPEED, NPC_STR, NPC_DEX, NPC_CON, NPC_INT, NPC_WIS, NPC_CHA, NPC_LANGUAGES, NPC_CR, NPC_SKILLS, NPC_PROFBONUS, NPC_SAVETHROWS,NPC_ABILITIES, NPC_ACTIONS, NPC_BIO, CAM_ID)
        VALUES ('Elrond', 1, 'Elf', 'Ranger', 'Lawful Evil', '12 Leather Armor', '10', '30ft', '10(+0)', '13(+1)', '11(+0)', '8(-1)', '6(-2)', '16(+3)', 'Common, Elvish', '1', 'Sneak, Perception, Intimidation', "+2", "Dex, Str", "Healing Word Heal 1d4", "Shortsword 1d6 Slashing", "Elrond is a high elf from the mystical forest. He is 150 years old.", 1);
INSERT INTO NPC(NPC_NAME, NPC_LEVEL, NPC_RACE, NPC_CLASS, NPC_ALIGN, NPC_AC, NPC_HP, NPC_SPEED, NPC_STR, NPC_DEX, NPC_CON, NPC_INT, NPC_WIS, NPC_CHA, NPC_LANGUAGES, NPC_CR, NPC_SKILLS, NPC_PROFBONUS, NPC_SAVETHROWS,NPC_ABILITIES, NPC_ACTIONS, NPC_BIO, CAM_ID)
        VALUES ('Tiny', 3, 'Orc', 'Barbarian', 'Lawful Evil', '16 Thick Armor', '30', '30ft', '18(+4)', '13(+1)', '16(+3)', '4(-3)', '6(-2)', '16(+3)', 'Common, Orcish', '1', 'Intimidation, Athletics', "+2", "Con, Str","Rage - Take half damage from slashing, bludgeoning, and piercing damage",  "Great Axe 1d12 Slashing", "Big Fuck is an orc from the highlands. He fucks shit up", 2);


INSERT INTO ACTNPC(ACT_ID, NPC_ID) VALUES ('1', '1');
INSERT INTO ACTNPC(ACT_ID, NPC_ID) VALUES ('2', '2');


INSERT INTO PC(PC_NAME, PC_LEVEL, PC_RACE, PC_CLASS, PC_ALIGN, PC_AC, PC_HP, PC_SPEED, PC_STR, PC_DEX, PC_CON, PC_INT, PC_WIS, PC_CHA, PC_LANGUAGES, PC_BIO, CAM_ID)
        VALUES ('Gimli', 1, 'Dwarf', 'Fighter', 'Lawful Neutral', '18 Scale Mail', '12', '30ft', '16(+3)', '11(+0)', '15(+2)', '11(+0)', '13(+1)', '8(-1)', 'Common, Dwarvish', 'Best friends with Legolas', 1);