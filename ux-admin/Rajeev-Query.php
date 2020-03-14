//==24-02-2020==//
==================
ALTER TABLE `game_linkage_sub` ADD `SubLink_Competency_Performance` TINYINT NOT NULL DEFAULT '0' COMMENT '0-Simulated Performance, 1-Competency' AFTER `SubLink_Type`;

//==27-02-2020==//
==================
/ALTER TABLE `game_linkage_sub` CHANGE `SubLink_Competency_Performance` `SubLink_Competency_Performance` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '0-None, 1-(Input)Competence, 2-Application, 3-Simulated Performance, 4-(Output)Competence';

//==07-03-2020==//
==================
ALTER TABLE `game_linkage_sub` CHANGE `SubLink_Competency_Performance` `SubLink_Competency_Performance` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '0-(Input)None, 1-(Input)Competence, 2-(Input)Application, 3-(Output)Simulated Performance, 4-(Output)Competence, 5-(Output)Application';

UPDATE game_linkage_sub SET SubLink_Competency_Performance = 3 WHERE SubLink_Type = 1


//==12-03-2020==//
==================
ALTER TABLE `game_items` ADD `Compt_Enterprise_ID` INT(11) NULL DEFAULT NULL AFTER `Compt_Description`;

ALTER TABLE `game_items_mapping` ADD `Cmap_Enterprise_ID` INT(11) NULL DEFAULT NULL AFTER `Cmap_Id`;
