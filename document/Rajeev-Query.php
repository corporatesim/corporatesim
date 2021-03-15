//==24-02-2020==//
==================
ALTER TABLE `GAME_LINKAGE_SUB` ADD `SubLink_Competence_Performance` TINYINT NOT NULL DEFAULT '0' COMMENT '0-Simulated Performance, 1-Competence' AFTER `SubLink_Type`;

//==27-02-2020==//
==================
/ALTER TABLE `GAME_LINKAGE_SUB` CHANGE `SubLink_Competence_Performance` `SubLink_Competence_Performance` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '0-None, 1-(Input)Competence, 2-Application, 3-Simulated Performance, 4-(Output)Competence';

//==07-03-2020==//
==================
ALTER TABLE `GAME_LINKAGE_SUB` CHANGE `SubLink_Competence_Performance` `SubLink_Competence_Performance` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '0-(Input)None, 1-(Input)Competence, 2-(Input)Application, 3-(Output)Simulated Performance, 4-(Output)Competence, 5-(Output)Application';

UPDATE GAME_LINKAGE_SUB SET SubLink_Competence_Performance = 3 WHERE SubLink_Type = 1


//==12-03-2020==//
==================
ALTER TABLE `GAME_ITEMS` ADD `Compt_Enterprise_ID` INT(11) NULL DEFAULT NULL AFTER `Compt_Description`;

ALTER TABLE `GAME_ITEMS_MAPPING` ADD `Cmap_Enterprise_ID` INT(11) NULL DEFAULT NULL AFTER `Cmap_Id`;

//==14-03-2020==//
==================
ALTER TABLE `GAME_LINKAGE_SUB` CHANGE `SubLink_Competence_Performance` `SubLink_Competence_Performance` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '0-(Input)None, 1-(Input)Competence, 2-(Input)Application, 3-(Output)Simulated Performance, 4-(Output)Competence, 5-(Output)Application';

ALTER TABLE `GAME_ITEMS_MAPPING` CHANGE `Cmap_ComptId` `Cmap_ComptId` INT(11) NULL DEFAULT NULL COMMENT 'This is Competence ID';

ALTER TABLE `GAME_ITEMS_MAPPING` CHANGE `Cmap_PerformanceType` `Cmap_PerformanceType` INT(11) NULL DEFAULT NULL COMMENT '3=simulatedPerformance, 4=Competence, 5=Application';

//==19-03-2020==//
==================
ALTER TABLE `GAME_ITEMS` ADD `Compt_PerformanceType` TINYINT(3) NULL DEFAULT NULL COMMENT '3=simulated Performance, 4=Competence, 5=Application' AFTER `Compt_Description`;

//==29-03-2020==//
==================
CREATE TABLE GAME_ITEMS_FORMULA( Items_Formula_Id int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (Items_Formula_Id) );

ALTER TABLE `GAME_ITEMS_FORMULA` ADD `Items_Formula_Title` VARCHAR(200) NOT NULL  AFTER `Items_Formula_Id`,  ADD `Items_Formula_String` MEDIUMTEXT NOT NULL COMMENT 'holds the string verson of the expression'  AFTER `Items_Formula_Title`,  ADD `Items_Formula_Expression` MEDIUMTEXT NOT NULL COMMENT 'holds the main expression of the formula'  AFTER `Items_Formula_String`,  ADD `Items_Formula_Enterprise_Id` INT NOT NULL COMMENT 'enterprise id for which formula is created'  AFTER `Items_Formula_Expression`,  ADD `Items_Formula_Items_Id` TINYTEXT NOT NULL COMMENT 'all the item ids which is used in this formula'  AFTER `Items_Formula_Enterprise_Id`,  ADD `Items_Formula_Sublink_Id` TINYTEXT NOT NULL COMMENT 'all the sublink ids which is used in all the items for this formula '  AFTER `Items_Formula_Items_Id`,  ADD `Items_Formula_CreatedBy` INT(11) NOT NULL  AFTER `Items_Formula_Sublink_Id`,  ADD `Items_Formula_CreatedOn` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP  AFTER `Items_Formula_CreatedBy`,  ADD `Items_Formula_UpdatedBy` INT(11) NOT NULL  AFTER `Items_Formula_CreatedOn`,  ADD `Items_Formula_UpdatedOn` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP  AFTER `Items_Formula_UpdatedBy`,  ADD `Items_Formula_Status` TINYINT(3) NOT NULL COMMENT '0-Active, 1-Deleted'  AFTER `Items_Formula_UpdatedOn`;

ALTER TABLE `GAME_ITEMS_FORMULA` ADD `Items_Formula_game_Id` VARCHAR(200) NOT NULL COMMENT 'game id used in this formula' AFTER `Items_Formula_Items_Id`;

ALTER TABLE `GAME_ITEMS_FORMULA` CHANGE `Items_Formula_Items_Id` `Items_Formula_Items_Id` VARCHAR(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'all the item ids which is used in this formula';

ALTER TABLE `GAME_ITEMS_FORMULA` CHANGE `Items_Formula_Sublink_Id` `Items_Formula_Sublink_Id` VARCHAR(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'all the sublink ids which is used in all the items for this formula ';

ALTER TABLE `GAME_ITEMS_FORMULA` CHANGE `Items_Formula_UpdatedOn` `Items_Formula_UpdatedOn` DATETIME NULL DEFAULT NULL;

ALTER TABLE `GAME_ITEMS_FORMULA` CHANGE `Items_Formula_UpdatedBy` `Items_Formula_UpdatedBy` INT(11) NULL DEFAULT NULL;

ALTER TABLE `GAME_ITEMS_FORMULA` CHANGE `Items_Formula_CreatedOn` `Items_Formula_CreatedOn` DATETIME NULL DEFAULT NULL;

ALTER TABLE `GAME_ITEMS_FORMULA` CHANGE `Items_Formula_String` `Items_Formula_String` MEDIUMTEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'holds the string of the formula';

ALTER TABLE `GAME_ITEMS_FORMULA` DROP `Items_Formula_Items_Id`, DROP `Items_Formula_game_Id`, DROP `Items_Formula_Sublink_Id`, DROP `Items_Formula_Status`;

ALTER TABLE `GAME_ITEMS_FORMULA` ADD `Items_Formula_Json` MEDIUMTEXT NULL DEFAULT NULL COMMENT '[item_id][sublink_id]' AFTER `Items_Formula_Expression`;

//==02-04-2020==//
==================
CREATE TABLE GAME_OPERATORS( Game_Operators_Id int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (Game_Operators_Id) );

ALTER TABLE `GAME_OPERATORS` ADD `Game_Operators_Value` VARCHAR(5) NOT NULL AFTER `Game_Operators_Id`;

ALTER TABLE `GAME_OPERATORS` ADD `Game_Operators_String` VARCHAR(20) NOT NULL AFTER `Game_Operators_Value`, ADD `Game_Operators_Status` TINYINT(2) NOT NULL DEFAULT '0' COMMENT '0->Active, 1->Deactive' AFTER `Game_Operators_String`;

INSERT INTO `GAME_OPERATORS` (`Game_Operators_Id`, `Game_Operators_Value`, `Game_Operators_String`, `Game_Operators_Status`) VALUES (NULL, '+', '+', '0');
INSERT INTO `GAME_OPERATORS` (`Game_Operators_Id`, `Game_Operators_Value`, `Game_Operators_String`, `Game_Operators_Status`) VALUES (NULL, '-', '-', '0');
INSERT INTO `GAME_OPERATORS` (`Game_Operators_Id`, `Game_Operators_Value`, `Game_Operators_String`, `Game_Operators_Status`) VALUES (NULL, '*', '*', '0');
INSERT INTO `GAME_OPERATORS` (`Game_Operators_Id`, `Game_Operators_Value`, `Game_Operators_String`, `Game_Operators_Status`) VALUES (NULL, '/', '/', '0');
INSERT INTO `GAME_OPERATORS` (`Game_Operators_Id`, `Game_Operators_Value`, `Game_Operators_String`, `Game_Operators_Status`) VALUES (NULL, '(', '(', '0');
INSERT INTO `GAME_OPERATORS` (`Game_Operators_Id`, `Game_Operators_Value`, `Game_Operators_String`, `Game_Operators_Status`) VALUES (NULL, ')', ')', '0');
INSERT INTO `GAME_OPERATORS` (`Game_Operators_Id`, `Game_Operators_Value`, `Game_Operators_String`, `Game_Operators_Status`) VALUES (NULL, '.1', '.1', '0');
INSERT INTO `GAME_OPERATORS` (`Game_Operators_Id`, `Game_Operators_Value`, `Game_Operators_String`, `Game_Operators_Status`) VALUES (NULL, '.2', '.2', '0');
INSERT INTO `GAME_OPERATORS` (`Game_Operators_Id`, `Game_Operators_Value`, `Game_Operators_String`, `Game_Operators_Status`) VALUES (NULL, '.3', '.3', '0');
INSERT INTO `GAME_OPERATORS` (`Game_Operators_Id`, `Game_Operators_Value`, `Game_Operators_String`, `Game_Operators_Status`) VALUES (NULL, '.4', '.4', '0');
INSERT INTO `GAME_OPERATORS` (`Game_Operators_Id`, `Game_Operators_Value`, `Game_Operators_String`, `Game_Operators_Status`) VALUES (NULL, '.5', '.5', '0');
INSERT INTO `GAME_OPERATORS` (`Game_Operators_Id`, `Game_Operators_Value`, `Game_Operators_String`, `Game_Operators_Status`) VALUES (NULL, '.6', '.6', '0');
INSERT INTO `GAME_OPERATORS` (`Game_Operators_Id`, `Game_Operators_Value`, `Game_Operators_String`, `Game_Operators_Status`) VALUES (NULL, '.7', '.7', '0');
INSERT INTO `GAME_OPERATORS` (`Game_Operators_Id`, `Game_Operators_Value`, `Game_Operators_String`, `Game_Operators_Status`) VALUES (NULL, '.8', '.8', '0');
INSERT INTO `GAME_OPERATORS` (`Game_Operators_Id`, `Game_Operators_Value`, `Game_Operators_String`, `Game_Operators_Status`) VALUES (NULL, '.9', '.9', '0');
INSERT INTO `GAME_OPERATORS` (`Game_Operators_Id`, `Game_Operators_Value`, `Game_Operators_String`, `Game_Operators_Status`) VALUES (NULL, '0', '0', '0');
INSERT INTO `GAME_OPERATORS` (`Game_Operators_Id`, `Game_Operators_Value`, `Game_Operators_String`, `Game_Operators_Status`) VALUES (NULL, '1', '1', '0');
INSERT INTO `GAME_OPERATORS` (`Game_Operators_Id`, `Game_Operators_Value`, `Game_Operators_String`, `Game_Operators_Status`) VALUES (NULL, '2', '2', '0');
INSERT INTO `GAME_OPERATORS` (`Game_Operators_Id`, `Game_Operators_Value`, `Game_Operators_String`, `Game_Operators_Status`) VALUES (NULL, '3', '3', '0');
INSERT INTO `GAME_OPERATORS` (`Game_Operators_Id`, `Game_Operators_Value`, `Game_Operators_String`, `Game_Operators_Status`) VALUES (NULL, '4', '4', '0');
INSERT INTO `GAME_OPERATORS` (`Game_Operators_Id`, `Game_Operators_Value`, `Game_Operators_String`, `Game_Operators_Status`) VALUES (NULL, '5', '5', '0');
INSERT INTO `GAME_OPERATORS` (`Game_Operators_Id`, `Game_Operators_Value`, `Game_Operators_String`, `Game_Operators_Status`) VALUES (NULL, '6', '6', '0');
INSERT INTO `GAME_OPERATORS` (`Game_Operators_Id`, `Game_Operators_Value`, `Game_Operators_String`, `Game_Operators_Status`) VALUES (NULL, '7', '7', '0');
INSERT INTO `GAME_OPERATORS` (`Game_Operators_Id`, `Game_Operators_Value`, `Game_Operators_String`, `Game_Operators_Status`) VALUES (NULL, '8', '8', '0');
INSERT INTO `GAME_OPERATORS` (`Game_Operators_Id`, `Game_Operators_Value`, `Game_Operators_String`, `Game_Operators_Status`) VALUES (NULL, '9', '9', '0');

//==22-04-2020==//
==================
CREATE TABLE GAME_ENTERPRISE_CARD ( EC_ID int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (EC_ID) );

ALTER TABLE `GAME_ENTERPRISE_CARD` ADD `EC_EnterpriseID` INT(11) NULL DEFAULT NULL AFTER `EC_ID`, ADD `EC_GameID` INT(11) NULL DEFAULT NULL AFTER `EC_EnterpriseID`, ADD `EC_CreatedOn` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `EC_GameID`, ADD `EC_CreatedBy` INT(11) NULL DEFAULT NULL AFTER `EC_CreatedOn`;

ALTER TABLE `GAME_ENTERPRISE_CARD` ADD `EC_Enterprise_Selected` INT(11) NOT NULL DEFAULT '0' COMMENT '0->not selected by enterprise, 1->selected by enterprise' AFTER `EC_CreatedBy`;

//==24-04-2020==//
==================
CREATE TABLE GAME_USER_SPECIALIZATION ( US_ID int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (US_ID) );

ALTER TABLE `GAME_USER_SPECIALIZATION` ADD `US_Name` VARCHAR(200) NOT NULL AFTER `US_ID`, ADD `US_CreatedOn` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `US_Name`, ADD `US_CreatedBy` INT(11) NOT NULL AFTER `US_CreatedOn`, ADD `US_Upload_CSV_ID` INT(10) NOT NULL COMMENT 'CSV ID is nothing but time when uploaded CSV' AFTER `US_CreatedBy`;

ALTER TABLE `GAME_USER_SPECIALIZATION` CHANGE `US_Upload_CSV_ID` `US_Upload_CSV_ID` INT(10) NULL DEFAULT NULL COMMENT 'CSV ID is nothing but time when uploaded CSV';

//==27-04-2020==//
==================
CREATE TABLE GAME_USER_CAMPUS ( UC_ID int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (UC_ID) );

ALTER TABLE `GAME_USER_CAMPUS` ADD `UC_Name` VARCHAR(200) NOT NULL AFTER `UC_ID`, ADD `UC_CreatedOn` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `UC_Name`, ADD `UC_CreatedBy` INT(11) NOT NULL AFTER `UC_CreatedOn`, ADD `UC_Upload_CSV_ID` INT(10) NOT NULL COMMENT 'CSV ID is nothing but time when uploaded CSV' AFTER `UC_CreatedBy`;

ALTER TABLE `GAME_USER_CAMPUS` CHANGE `UC_Upload_CSV_ID` `UC_Upload_CSV_ID` INT(10) NULL DEFAULT NULL COMMENT 'CSV ID is nothing but time when uploaded CSV';

ALTER TABLE `GAME_USER_CAMPUS` ADD `UC_Address` VARCHAR(300) NULL DEFAULT NULL AFTER `UC_Name`, ADD `UC_Email` VARCHAR(100) NULL DEFAULT NULL AFTER `UC_Address`, ADD `UC_Contact` INT(10) NULL DEFAULT NULL AFTER `UC_Email`;

//===

ALTER TABLE `GAME_SITE_USERS` ADD `User_Specialization` INT(11) NULL DEFAULT NULL AFTER `User_GameEndDate`, ADD `User_Campus` INT(11) NULL DEFAULT NULL AFTER `User_Specialization`;

//==29-04-2020==//
==================
CREATE TABLE GAME_ENTERPRISE_CAMPUS ( ECampus_ID int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (ECampus_ID) );

ALTER TABLE `GAME_ENTERPRISE_CAMPUS` ADD `ECampus_EnterpriseID` INT(11) NULL DEFAULT NULL AFTER `ECAMPUS_ID`, ADD `ECampus_CampusID` INT(11) NULL DEFAULT NULL AFTER `ECampus_EnterpriseID`, ADD `ECampus_CreatedOn` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `ECampus_CampusID`, ADD `ECampus_CreatedBy` INT(11) NULL DEFAULT NULL AFTER `ECampus_CreatedOn`;

//==30-04-2020==//
==================
ALTER TABLE `GAME_ENTERPRISE_CAMPUS` ADD `ECampus_UpdatedOn` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `ECampus_CreatedOn`;

ALTER TABLE `GAME_ENTERPRISE_CAMPUS` CHANGE `ECampus_CreatedOn` `ECampus_CreatedOn` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '*Campus Selected Date';

ALTER TABLE `GAME_ENTERPRISE_CAMPUS` ADD `ECampus_Selected` INT NOT NULL DEFAULT '1' COMMENT '0 -> currently not selected, 1 -> selected' AFTER `ECampus_CreatedBy`;

//=============
ALTER TABLE `GAME_USER_CAMPUS` CHANGE `UC_Contact` `UC_Contact` VARCHAR(100) NULL DEFAULT NULL;

ALTER TABLE `GAME_USER_CAMPUS` CHANGE `UC_Email` `UC_Email` VARCHAR(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;

ALTER TABLE `GAME_USER_CAMPUS` CHANGE `UC_Address` `UC_Address` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;

ALTER TABLE `GAME_USER_CAMPUS` CHANGE `UC_Name` `UC_Name` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

ALTER TABLE `GAME_USER_SPECIALIZATION` CHANGE `US_Name` `US_Name` VARCHAR(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

//==02-05-2020==//
==================
CREATE TABLE GAME_ITEM_CONDITIONS ( IC_ID int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (IC_ID) );

ALTER TABLE `GAME_ITEM_CONDITIONS` ADD `IC_Min_Value` INT(11) NULL DEFAULT NULL AFTER `IC_ID`, ADD `IC_Max_Value` INT(11) NULL DEFAULT NULL AFTER `IC_Min_Value`, ADD `IC_Text` LONGTEXT NULL DEFAULT NULL AFTER `IC_Max_Value`, ADD `IC_Created_On` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `IC_Text`, ADD `IC_Created_By` INT(11) NULL DEFAULT NULL AFTER `IC_Created_On`;
Other
ALTER TABLE `GAME_ITEM_CONDITIONS` ADD `IC_Item_ID` INT(11) NOT NULL COMMENT 'Compt_Id of table game_items' AFTER `IC_Text`;

//==11-05-2020==//
==================
ALTER TABLE `GAME_GAME` ADD `Game_ProcessOwner_Details` TEXT NULL DEFAULT NULL AFTER `Game_longDescription`;

//==13-05-2020==//
==================
ALTER TABLE `GAME_USER_CAMPUS` ADD `UC_Type` INT(11) NOT NULL DEFAULT '3' COMMENT 'Campus Type, 1->Management, 2-> Engineering, 3-> Other ' AFTER `UC_Name`;

// hide subEnterprize on lines
navigation //103, 127
collaboration //145, 187
offlineReports //50, 96 
onlineReports //52, 95
viewGroupReport //62, 105
footer //800-809, 820-827

//==19-05-2020==//
==================
ALTER TABLE `GAME_ITEMS_FORMULA` ADD `Items_Formula_Report_Name_Definition` TEXT NULL DEFAULT NULL AFTER `Items_Formula_UpdatedOn`;

CREATE TABLE GAME_ITEM_REPORT ( IR_ID int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (IR_ID) );

ALTER TABLE `GAME_ITEM_REPORT` ADD `IR_Items_Formula_Id` INT(11) NULL DEFAULT NULL COMMENT 'Formula ID' AFTER `IR_ID`, ADD `IR_Type_Choice` TINYINT(1) NULL DEFAULT NULL COMMENT '1->EXECUTIVE SUMMARY, 2->CONCLUSION SECTION' AFTER `IR_Items_Formula_Id`, ADD `IR_Min_Value` INT(11) NULL DEFAULT NULL AFTER `IR_Type_Choice`, ADD `IR_Max_Value` INT(11) NULL DEFAULT NULL AFTER `IR_Min_Value`, ADD `IR_Text` LONGTEXT NULL DEFAULT NULL COMMENT 'Description' AFTER `IR_Max_Value`, ADD `IR_Created_On` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `IR_Text`, ADD `IR_Created_By` INT(11) NULL DEFAULT NULL AFTER `IR_Created_On`;

ALTER TABLE `GAME_ITEM_REPORT` ADD `IR_Formula_Enterprize_ID` INT(11) NOT NULL COMMENT 'Enterprize Id for wich this description is created' AFTER `IR_ID`;

//==20-05-2020==//
==================
INSERT INTO `GAME_ITEM_REPORT` (`IR_ID`, `IR_Formula_Enterprize_ID`, `IR_Items_Formula_Id`, `IR_Type_Choice`, `IR_Min_Value`, `IR_Max_Value`, `IR_Text`, `IR_Created_On`, `IR_Created_By`) VALUES ('1', '0', NULL, NULL, NULL, NULL, 'Header of Report', CURRENT_TIMESTAMP, '1'), ('2', '0', NULL, NULL, NULL, NULL, 'Disclaimer of Report', CURRENT_TIMESTAMP, '1');

ALTER TABLE `GAME_ITEM_REPORT` CHANGE `IR_Text` `IR_Text` LONGTEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Description, IR_ID 1 is used for Header of Report and 2 is used for Disclaimer';

//==21-05-2020==//
==================
ALTER TABLE `GAME_ITEMS_FORMULA` ADD `Items_Formula_Detailed_Report` TEXT NULL DEFAULT NULL AFTER `Items_Formula_Report_Name_Definition`;

//==25-05-2020==//
==================
ALTER TABLE `GAME_ITEM_REPORT` ADD `IR_CR_Min_Average_Value` INT(11) NULL AFTER `IR_Max_Value`, ADD `IR_CR_Max_Average_Value` INT(11) NULL AFTER `IR_CR_Min_Average_Value`, ADD `IR_CA_Min_Average_Value` INT(11) NULL AFTER `IR_CR_Max_Average_Value`, ADD `IR_CA_Max_Average_Value` INT(11) NULL AFTER `IR_CA_Min_Average_Value`, ADD `IR_SP_Min_Average_Value` INT(11) NULL AFTER `IR_CA_Max_Average_Value`, ADD `IR_SP_Max_Average_Value` INT(1) NULL AFTER `IR_SP_Min_Average_Value`;

//== Query By Mohit Sir ==//
======================
ALTER TABLE `GAME_LINKAGE_SUB` ADD `Sublink_Json` LONGTEXT NULL DEFAULT NULL COMMENT 'This field can contain multiple col data in json format' AFTER `SubLink_InputFieldOrder`;

//== Query By Rajeev ==//
======================
ALTER TABLE `GAME_ITEMS` CHANGE `Compt_PerformanceType` `Compt_PerformanceType` TINYINT(1) NULL DEFAULT NULL COMMENT '4=Competence Readiness, 5=Competence Application, 3=Simulated Performance';

ALTER TABLE `GAME_ITEM_CONDITIONS` ADD `IC_Score_Status` TINYINT(1) NULL COMMENT '0=Show, 1=Hide (Score Value)' AFTER `IC_Text`;

UPDATE GAME_ITEM_CONDITIONS SET IC_Score_Status = 0;

//==30-05-2020==//
==================
ALTER TABLE `GAME_ITEM_REPORT` ADD `IR_Condition_Type` TINYINT(2) NULL COMMENT '1-> Average, 2->Individual' AFTER `IR_Type_Choice`;

<!-- XXX-> ALTER TABLE `GAME_ITEM_REPORT` CHANGE `IR_Condition_Type` `IR_Condition_Type` TINYINT(2) NULL COMMENT '1-> Average, 2->Individual'; -->

<!-- XXX-> ALTER TABLE `GAME_ITEM_REPORT` ADD `IR_Item_Id` INT(11) NULL COMMENT 'this is Compt_Id of table GAME_ITEMS (present when 2-> Individual of Condition type selected)' AFTER `IR_Condition_Type` -->;

//=============
<!-- UPDATE `GAME_ITEM_REPORT` SET `IR_Condition_Type` = NULL WHERE `GAME_ITEM_REPORT`.`IR_ID` = 1; -->
<!-- UPDATE `GAME_ITEM_REPORT` SET `IR_Condition_Type` = NULL WHERE `GAME_ITEM_REPORT`.`IR_ID` = 2; -->

UPDATE `GAME_ITEM_REPORT` SET `IR_Condition_Type` = '1' WHERE `GAME_ITEM_REPORT`.`IR_ID` IN (3, 4, 5, 6, 7, 8);
//=============

// hide download option from
ux-admin/view/Linkage/addeditlink.php -> Line No - 270

//==03-06-2020==//
==================
CREATE TABLE GAME_ITEM_REPORT_INDIVIDUAL ( IRI_ID int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (IRI_ID) );

ALTER TABLE `GAME_ITEM_REPORT_INDIVIDUAL`  ADD `IRI_Formula_Enterprize_ID` INT(11) NOT NULL COMMENT 'Enterprize Id for wich this description is created'  AFTER `IRI_ID`,  ADD `IRI_Items_Formula_Id` INT(11) NOT NULL COMMENT 'Formula ID'  AFTER `IRI_Formula_Enterprize_ID`,  ADD `IRI_Type_Choice` TINYINT(2) NOT NULL COMMENT '1->EXECUTIVE SUMMARY, 2->CONCLUSION SECTION'  AFTER `IRI_Items_Formula_Id`,  ADD `IRI_xAxis_Item_Id` INT(11) NOT NULL COMMENT 'this is Compt_Id of table GAME_ITEMS used in graph for x axis'  AFTER `IRI_Type_Choice`,  ADD `IRI_xAxis_Min_Value` INT(11) NOT NULL  AFTER `IRI_xAxis_Item_Id`,  ADD `IRI_xAxis_Max_Value` INT(11) NOT NULL  AFTER `IRI_xAxis_Min_Value`,  ADD `IRI_yAxis_Item_Id` INT(11) NOT NULL COMMENT 'this is Compt_Id of table GAME_ITEMS used in graph for y axis'  AFTER `IRI_xAxis_Max_Value`,  ADD `IRI_yAxis_Min_Value` INT(11) NOT NULL  AFTER `IRI_yAxis_Item_Id`,  ADD `IRI_yAxis_Max_Value` INT(11) NOT NULL  AFTER `IRI_yAxis_Min_Value`,  ADD `IRI_Created_On` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP  AFTER `IRI_yAxis_Max_Value`,  ADD `IRI_Created_By` INT(11) NOT NULL  AFTER `IRI_Created_On`;

ALTER TABLE `GAME_ITEM_REPORT_INDIVIDUAL` ADD `IRI_Text` LONGTEXT NULL COMMENT 'Description with conditions match' AFTER `IRI_yAxis_Max_Value`;

ALTER TABLE `GAME_ITEM_REPORT_INDIVIDUAL` ADD `IRI_Condition_Type` INT(11) NOT NULL COMMENT '1-> Average, 2->Individual' AFTER `IRI_Type_Choice`;

//==10-06-2020==//
==================
ALTER TABLE `GAME_ITEM_REPORT_INDIVIDUAL` ADD `IRI_Score_Status` TINYINT(1) NOT NULL DEFAULT '3' COMMENT 'Score Value => 0=Hide, 1=Show Both, 2=Show x-axis(Readiness), 3=Show y-axis(Application)' AFTER `IRI_Text`;

//==18-07-2020==//
==================
CREATE TABLE GAME_EMAIL_SEND_DETAILS ( ESD_ID int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (ESD_ID) );

ALTER TABLE `GAME_EMAIL_SEND_DETAILS` ADD `ESD_From` VARCHAR(100) NOT NULL AFTER `ESD_ID`, ADD `ESD_To` TEXT NOT NULL AFTER `ESD_From`, ADD `ESD_Content` TEXT NOT NULL COMMENT 'body of email' AFTER `ESD_To`, ADD `ESD_EnterprizeID` INT(11) NOT NULL AFTER `ESD_Content`, ADD `ESD_SubEnterprizeID` INT(11) NOT NULL AFTER `ESD_EnterprizeID`, ADD `ESD_DateTime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `ESD_SubEnterprizeID`, ADD `ESD_Comment` TEXT NOT NULL COMMENT 'if email not send then error message' AFTER `ESD_DateTime`, ADD `ESD_Status` TINYINT(1) NOT NULL COMMENT '0->Not Sent, 1-> Sent' AFTER `ESD_Comment`;

ALTER TABLE `GAME_EMAIL_SEND_DETAILS` ADD `ESD_Email_Count` INT(11) NOT NULL COMMENT 'no of email sends' AFTER `ESD_To`;

//==27-08-2020==//
==================
ALTER TABLE `GAME_LINKAGE_SUB` CHANGE `SubLink_Competence_Performance` `SubLink_Competence_Performance` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0-(Input)None, 1-(Input)Competence Readiness, 2-(Input)Competence Application, 3-(Output)Simulated Performance, 4-(Output)Competence Readiness, 5-(Output)Competence Application, 6-(Output)None';

//==12-11-2020==//
==================
//======= below this query not executed on live    =======//

CREATE TABLE GAME_REPORT_FIVE ( RF_ID int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (RF_ID) );

ALTER TABLE `GAME_REPORT_FIVE` ADD `RF_Enterprize_ID` INT(11) NOT NULL AFTER `RF_ID`, ADD `RF_Formula_ID` INT(11) NOT NULL AFTER `RF_Enterprize_ID`, ADD `RF_Action_ID` TINYINT(1) NOT NULL COMMENT '1-> Shortlist, 2-> IDP, 3-> ehire' AFTER `RF_Formula_ID`, ADD `RF_User_ID` INT(11) NOT NULL AFTER `RF_Action_ID`, ADD `RF_DateTime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `RF_User_ID`, ADD `RF_Status` TINYINT(1) NOT NULL COMMENT '0-> Not Selected, 1-> Selected' AFTER `RF_DateTime`;

ALTER TABLE `GAME_REPORT_FIVE` ADD `RF_Update_DateTime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `RF_DateTime`;

//======= above this query not executed on live    =======//

//==02-12-2020==// 
=> these query are for making where to show continue buttons on bottom or on right side in input and output page
==================
ALTER TABLE `GAME_LINKAGE` ADD `Link_buttonAction` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1-Remove Side Button, 2-Remove Bottom Button, 3-Remove Both Buttons' AFTER `Link_ButtonTextOutput`;

ALTER TABLE `GAME_LINKAGE` ADD `Link_buttonActionOutput` TINYINT(1) NOT NULL DEFAULT '2' COMMENT '1->Show Side Button, 2->Show Bottom Button' AFTER `Link_buttonAction`;

ALTER TABLE `GAME_LINKAGE` CHANGE `Link_buttonAction` `Link_buttonAction` TINYINT(1) NOT NULL DEFAULT '2' COMMENT '1-Show Side Button, 2-Show Bottom Button, 3-Remove Both Buttons';

UPDATE GAME_LINKAGE SET Link_buttonAction=2;

//======= till this query executed in live    =======//
//==12-11-2020==// => query not executed in live

//==02-12-2020==// 
=> these query are for making Report Viewer
==================
CREATE TABLE GAME_REPORT_VIEWER ( RV_ID int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (RV_ID) );

ALTER TABLE `GAME_REPORT_VIEWER` ADD `RV_Name` TEXT NOT NULL AFTER `RV_ID`, ADD `RV_Email_ID` TEXT NOT NULL AFTER `RV_Name`, ADD `RV_Password` TEXT NOT NULL AFTER `RV_Email_ID`, ADD `RV_Created_On` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `RV_Password`, ADD `RV_Status` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0->Active, 1->Deactive' AFTER `RV_Created_On`;

ALTER TABLE `GAME_REPORT_VIEWER` ADD `RV_EnterpriseID` INT(11) NOT NULL COMMENT 'Enterprize for which report viewer is created' AFTER `RV_Created_On`;

//======= till this query executed in Develop =======//














//==================================================
for JS game 
//==04-11-2020==// => query not executed in Develop and live
==================
CREATE TABLE GAME_JS_IMAGES ( JS_IMG_ID int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (JS_IMG_ID) );

ALTER TABLE `GAME_JS_IMAGES` ADD `JS_IMG_Folder` VARCHAR(200) NOT NULL COMMENT 'in which folder image is uploaded' AFTER `JS_IMG_ID`, ADD `JS_IMG_FileName` TEXT NOT NULL COMMENT 'image name' AFTER `JS_IMG_Folder`, ADD `JS_IMG_FileSize` VARCHAR(100) NOT NULL COMMENT 'file size in kb' AFTER `JS_IMG_FileName`, ADD `JS_IMG_Uploaded_On` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `JS_IMG_FileSize`;


CREATE TABLE GAME_JS_FILES ( JS_F_ID int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (JS_F_ID) );

ALTER TABLE `GAME_JS_FILES` ADD `JS_F_File_Name` TEXT NOT NULL AFTER `JS_F_ID`, ADD `JS_F_Uploaded_On` DATETIME NOT NULL AFTER `JS_F_File_Name`, ADD `JS_F_Updated_On` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `JS_F_Uploaded_On`;


CREATE TABLE GAME_JS_FOLDER ( JS_FD_ID int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (JS_FD_ID) );

ALTER TABLE `GAME_JS_FOLDER` ADD `JS_FD_Name` TEXT NOT NULL COMMENT 'Folder(Directory) Name' AFTER `JS_FD_ID`, ADD `JS_FD_Created_On` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `JS_FD_Name`;









//==================================================
//==================================================
//==================================================
//==07-04-2020==//
For removing llpl from db
==================
UPDATE GAME_DOMAIN SET Domain_Name = '', Domain_EnterpriseId = 1 WHERE Domain_Id = 34

//==08-04-2020==//
For live
==================
UPDATE GAME_ITEMS SET Compt_PerformanceType = 3 WHERE Compt_Enterprise_ID = 28


//==================================================
//ux-admin Files
ux-admin/Controller/linkage.php  Line-1386-1442




//==================================================
//==================================================
//==================================================
For Dev and local => B2C
//==22-09-2020==//
==================

CREATE TABLE GAME_USER_BILLING ( GUB_ID BIGINT(20) NOT NULL AUTO_INCREMENT, PRIMARY KEY (GUB_ID) );

ALTER TABLE `GAME_USER_BILLING` ADD `GUB_User_ID` BIGINT(20) NOT NULL AFTER `GUB_ID`, ADD `GUB_Game_ID` BIGINT(20) NOT NULL AFTER `GUB_User_ID`, ADD `GUB_Purchase_Date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `GUB_Game_ID`, ADD `GUB_Amount` INT(11) NOT NULL AFTER `GUB_Purchase_Date`, ADD `GUB_Currency` VARCHAR(8) NOT NULL AFTER `GUB_Amount`;

ALTER TABLE `GAME_USER_BILLING` ADD `GUB_Expiry_Date` DATETIME NOT NULL AFTER `GUB_Currency`, ADD `GUB_Payment_Channel` VARCHAR(16) NOT NULL AFTER `GUB_Expiry_Date`, ADD `GUB_PG_Charge` INT(11) NOT NULL AFTER `GUB_Payment_Channel`, ADD `GUB_PG_Charge_Percent` INT(11) NOT NULL AFTER `GUB_PG_Charge`, ADD `GUB_Payment_Status` VARCHAR(16) NOT NULL AFTER `GUB_PG_Charge_Percent`, ADD `GUB_Payment_Ref` VARCHAR(128) NOT NULL AFTER `GUB_Payment_Status`;

CREATE TABLE GAME_PAYMENT_CHANNEL ( GPC_ID BIGINT(20) NOT NULL AUTO_INCREMENT, PRIMARY KEY (GPC_ID) );

ALTER TABLE `GAME_PAYMENT_CHANNEL` ADD `GPC_Channel_Name` VARCHAR(16) NOT NULL AFTER `GPC_ID`, ADD `GPC_Status` INT(11) NOT NULL AFTER `GPC_Channel_Name`;

CREATE TABLE GAME_USER_CART ( GUC_ID BIGINT(20) NOT NULL AUTO_INCREMENT, PRIMARY KEY (GUC_ID) );

ALTER TABLE `GAME_USER_CART` ADD `GUC_User_ID` BIGINT(20) NOT NULL AFTER `GUC_ID`, ADD `GUC_Game_ID` BIGINT(20) NOT NULL AFTER `GUC_User_ID`, ADD `GUC_Cart_Date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `GUC_Game_ID`, ADD `GUC_Game_Info` VARCHAR(5000) NOT NULL AFTER `GUC_Cart_Date`;

CREATE TABLE GAME_USER_SUBSCRIPTION ( GUS_ID BIGINT(20) NOT NULL AUTO_INCREMENT, PRIMARY KEY (GUS_ID) );

ALTER TABLE `GAME_USER_SUBSCRIPTION` ADD `GUS_User_ID` BIGINT(20) NOT NULL AFTER `GUS_ID`, ADD `GUS_Game_ID` BIGINT(20) NOT NULL AFTER `GUS_User_ID`, ADD `GUS_Subscribed_Date` DATETIME NOT NULL AFTER `GUS_Game_ID`, ADD `GUS_Payment_ID` BIGINT(20) NOT NULL AFTER `GUS_Subscribed_Date`, ADD `GUS_Game_Status` VARCHAR(16) NOT NULL AFTER `GUS_Payment_ID`, ADD `GUS_Expire_Date` DATETIME NOT NULL AFTER `GUS_Game_Status`;

//==30-09-2020==//
==================
ALTER TABLE `GAME_SITE_USERS` ADD `User_Country_Id` INT(11) NOT NULL AFTER `User_email`, ADD `User_State_Id` INT(11) NOT NULL AFTER `User_Country_Id`, ADD `User_City` VARCHAR(255) NOT NULL AFTER `User_State_Id`, ADD `User_ZIP` VARCHAR(255) NOT NULL AFTER `User_City`, ADD `User_Address` VARCHAR(255) NOT NULL AFTER `User_ZIP`;

ALTER TABLE `GAME_SITE_USERS` CHANGE `User_ZIP` `User_ZIP` INT(11) NOT NULL;

//==07-10-2020==//
==================
UPDATE GAME_GAME SET Game_Status = 1

//==09-10-2020==//
==================
CREATE TABLE GAME_ORDER_DETAILS ( GOD_ID BIGINT(20) NOT NULL AUTO_INCREMENT, PRIMARY KEY (GOD_ID) );

ALTER TABLE `GAME_ORDER_DETAILS` ADD `GOD_Order_ID` BIGINT NOT NULL AFTER `GOD_ID`, ADD `GOD_Game_ID` BIGINT NOT NULL AFTER `GOD_Order_ID`, ADD `GOD_Valid_From` DATE NOT NULL AFTER `GOD_Game_ID`, ADD `GOD_Valid_To` DATE NOT NULL AFTER `GOD_Valid_From`, ADD `GOD_User_ID` BIGINT NOT NULL AFTER `GOD_Valid_To`;


ALTER TABLE `GAME_USER_BILLING` DROP `GUB_Game_ID`, DROP `GUB_Purchase_Date`, DROP `GUB_Amount`, DROP `GUB_Currency`, DROP `GUB_Expiry_Date`, DROP `GUB_Payment_Channel`, DROP `GUB_PG_Charge`, DROP `GUB_PG_Charge_Percent`, DROP `GUB_Payment_Status`, DROP `GUB_Payment_Ref`;

ALTER TABLE `GAME_USER_BILLING` ADD `GUB_Order_ID` BIGINT NOT NULL AFTER `GUB_User_ID`, ADD `GUB_Purchase_Date` DATETIME NOT NULL AFTER `GUB_Order_ID`, ADD `GUB_Amount` VARCHAR(30) NOT NULL AFTER `GUB_Purchase_Date`, ADD `GUB_Ref_ID` VARCHAR(128) NOT NULL AFTER `GUB_Amount`, ADD `GUB_Valid_From` DATE NOT NULL AFTER `GUB_Ref_ID`, ADD `GUB_Valid_To` DATE NOT NULL AFTER `GUB_Valid_From`, ADD `GUB_TAX_Amount` VARCHAR(30) NOT NULL AFTER `GUB_Valid_To`, ADD `GUB_Payment_Gateway` VARCHAR(64) NOT NULL AFTER `GUB_TAX_Amount`, ADD `GUB_IP_Address` VARCHAR(64) NOT NULL AFTER `GUB_Payment_Gateway`;

//==10-10-2020==//
==================
CREATE TABLE GAME_EMAIL_BTOC_DETAILS ( GED_ID BIGINT(20) NOT NULL AUTO_INCREMENT, PRIMARY KEY (GED_ID) );

ALTER TABLE `GAME_EMAIL_BTOC_DETAILS` ADD `GED_Send_To` TEXT NULL COMMENT 'user email ID' AFTER `GED_ID`, ADD `GED_Content` TEXT NULL COMMENT 'body of email' AFTER `GED_Send_To`, ADD `GED_DateTime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `GED_Content`, ADD `GED_Comment` TEXT NULL COMMENT 'if email not send then error message ' AFTER `GED_DateTime`, ADD `GED_Status` TINYINT(1) NOT NULL COMMENT '0->Not Sent, 1-> Sent' AFTER `GED_Comment`;

//======= till this query executed on Dev =======//
