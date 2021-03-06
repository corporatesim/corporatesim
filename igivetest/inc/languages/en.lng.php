<?php

// Customizable (you can customize/override this data in custom.lng.php):
// ----------------------------------------------------------------------
// Branding:
$lngstr['branding']['top_logo'] = '<img src="images/logo.gif" width=200 height=40>';
$lngstr['branding']['btm_sign'] = 'Copyright &copy; 2004-2012 Iglearn, Subsidiary of Sight2k.<br />All Rights Reserved.';
// Sign in page:
$lngstr['page_signin_box_intro'] = '';

// Non-customizable (it is not recommended to customize this data):
// ----------------------------------------------------------------
$lngstr['branding']['powered_by'] = 'Powered by <a href="http://iGiveTest.com" target=_blank>iGiveTest v'.IGT_VERSION.'</a>';
// General:
$lngstr['meta_charset'] = 'iso-8859-1';
$lngstr['sql_charset'] = 'latin1';
$lngstr['meta_contentlanguage'] = 'en-us';
$lngstr['language']['date_only_format'] = '%m/%d/%Y'; // 'm/d/Y'
$lngstr['language']['date_format'] = '%m/%d/%y %I:%M %p'; // 'm/d/y g:i a'
$lngstr['language']['date_format_full'] = '%B %d, %Y %I:%M:%S %p'; // 'F j, Y g:i:s a'
$lngstr['language']['calendar']['date_format'] = '%Y-%m-%d %H:%M';
$lngstr['text_direction'] = 'ltr';
$lngstr['languages'] = array('en' => 'English', 'es' => 'Spanish', 'de' => 'German', 'fr' => 'French', 'nl' => 'Dutch', 'ru' => 'Russian', 'hr' => 'Croatian');
$lngstr['language_long'] = 'english';
$lngstr['language']['locale'] = array('en_US', 'enu', 'eng', 'en', 'english');
$lngstr['language']['currency'] = '$%.2f';
$lngstr['language']['currency_name'] = 'USD';
$lngstr['language']['list_separator'] = ',';

$lngstr['calendar_month'] = 'Month';
$lngstr['calendar_day'] = 'Day';
$lngstr['calendar_year'] = 'Year';
$lngstr['calendar_hour'] = 'Hour';
$lngstr['calendar_minute'] = 'Minute';
$lngstr['time_days'] = 'Days';
$lngstr['time_days_short'] = 'days';
$lngstr['time_hours'] = 'Hours';
$lngstr['time_hours_short'] = 'hr.';
$lngstr['time_minutes'] = 'Minutes';
$lngstr['time_minutes_short'] = 'min.';
$lngstr['time_seconds'] = 'Seconds';
$lngstr['time_seconds_short'] = 'sec.';
$lngstr['time_donotuse'] = 'Do not use';
$lngstr['calendar']['hint'] = 'Calendar...';

$lngstr['calendar_months'] = array(
	1 => 'January',
	2 => 'February',
	3 => 'March',
	4 => 'April',
	5 => 'May',
	6 => 'June',
	7 => 'July',
	8 => 'August',
	9 => 'September',
	10 => 'October',
	11 => 'November',
	12 => 'December',
	);

$lngstr['label_yes'] = 'Yes';
$lngstr['label_no'] = 'No';
$lngstr['label_undefined'] = 'Undefined';
$lngstr['label_partially'] = 'Partially';
$lngstr['label_notapplicable'] = 'n/a';
$lngstr['label_all'] = 'All';
$lngstr['label_noname'] = '[No name]';
$lngstr['label_none'] = '- None -';
$lngstr['label']['print_version'] = 'View printable version';
$lngstr['label']['KtoLofN'] = '%d - %d of %d';

$lngstr['label_navigate_show'] = 'Show:';
$lngstr['button_next'] = 'Next';
$lngstr['button_prev'] = 'Previous';
$lngstr['button_accept'] = 'Accept';
$lngstr['button_next_page'] = 'Go forward one page';
$lngstr['button_prev_page'] = 'Go back one page';
$lngstr['button_first_page'] = 'Go back to first page';
$lngstr['button_last_page'] = 'Go forward to last page';

$lngstr['label']['view_edit_user'] = 'View / edit this user profile';

$lngstr['label_atype_multiple_choice'] = 'Multiple choice';
$lngstr['label_atype_multiple_answer'] = 'Multiple answer';
$lngstr['label_atype_truefalse'] = 'True/false';
$lngstr['label_atype_truefalse_true'] = 'True';
$lngstr['label_atype_truefalse_false'] = 'False';
$lngstr['label_atype_fillintheblank'] = 'Short answer';
$lngstr['label_atype_essay'] = 'Essay';
$lngstr['label_atype_random'] = 'Random question';

$lngstr['page_all']['mnemonic_code'] = 'Mnemonic code:';

$lngstr['item_separator'] = ' - ';
$lngstr['page_title_signin'] = 'Sign In';
$lngstr['page_title_register'] = 'Registration';
$lngstr['page_title_lostpassword'] = 'Forgot Password';
$lngstr['page_title_panel'] = 'Take a Test';
$lngstr['page_header_panel'] = $lngstr['page_title_panel'];
$lngstr['page_title_test'] = 'Take a Test';
$lngstr['page_title_results'] = 'Reports Manager';
$lngstr['page_header_results'] = $lngstr['page_title_results'];
 $lngstr['page_title_results_questions'] = 'Question Details';
 $lngstr['page_header_results_questions'] = $lngstr['page_title_results_questions'];
 $lngstr['page_title_results_answers'] = 'Answer Details';
 $lngstr['page_header_results_answers'] = $lngstr['page_title_results_answers'];
 $lngstr['page_reportsmanager']['correct_answer'] = 'Question with Correct Answer';
 $lngstr['page_reportsmanager']['your_answer'] = 'Your Answer';
$lngstr['page_reportsratings']['title'] = 'Ratings';
$lngstr['page_reportsratings']['header'] = $lngstr['page_reportsratings']['title'];
$lngstr['page_statistics']['title'] = 'Statistics';
$lngstr['page_statistics']['header'] = $lngstr['page_statistics']['title'];
 $lngstr['page_statistics_resultid']['title'] = 'Detailed Test Report';
 $lngstr['page_statistics_resultid']['header'] = 'Detailed Test Report for: %s';
$lngstr['page_title_edittests'] = 'Test Manager';
$lngstr['page_header_edittests'] = $lngstr['page_title_edittests'];
 $lngstr['page_title_test_settings'] = 'Test Settings';
 $lngstr['page_header_test_settings'] = $lngstr['page_title_test_settings'];
 $lngstr['page_title_test_assignto'] = 'Assign To';
 $lngstr['page_header_test_assignto_tests'] = 'Tests';
 $lngstr['page_header_test_assignto_groups'] = 'Groups';
 $lngstr['page_title_test_questions'] = 'Test Questions';
 $lngstr['page_header_test_questions'] = $lngstr['page_title_test_questions'];
 $lngstr['page_title_test_sections'] = 'Test Sections';
 $lngstr['page_header_test_sections'] = $lngstr['page_title_test_sections'];
 $lngstr['page_title_import_questions'] = 'Import Questions';
 $lngstr['page_header_import_questions'] = $lngstr['page_title_import_questions'];
 $lngstr['page_testmanager_stats']['title'] = 'Test Statistics';
 $lngstr['page_testmanager_stats']['header'] = $lngstr['page_testmanager_stats']['title'];
$lngstr['page_title_questionbank'] = 'Question Bank';
$lngstr['page_header_questionbank'] = $lngstr['page_title_questionbank'];
 $lngstr['page_title_question_stats'] = 'Question Statistics';
 $lngstr['page_header_question_stats'] = $lngstr['page_title_question_stats'];
 $lngstr['page_title_edit_question'] = 'Edit Question';
 $lngstr['page_header_edit_question'] = $lngstr['page_title_edit_question'];
$lngstr['page_title_manageusers'] = 'Users';
$lngstr['page_header_manageusers'] = $lngstr['page_title_manageusers'];
 $lngstr['page_title_users_memberof'] = 'Member Of';
 $lngstr['page_title_users_memberof_users'] = 'Users';
 $lngstr['page_title_users_memberof_groups'] = 'Groups';
 $lngstr['page_title_users_settings'] = 'User Settings';
 $lngstr['page_header_users_settings'] = $lngstr['page_title_users_settings'];
$lngstr['page_title_managegroups'] = 'Groups';
$lngstr['page_header_managegroups'] = $lngstr['page_title_managegroups'];
 $lngstr['page_title_groups_settings'] = 'Group Settings';
 $lngstr['page_header_groups_settings'] = $lngstr['page_title_groups_settings'];
$lngstr['page_title_subjects'] = 'Subjects';
$lngstr['page_header_subjects'] = $lngstr['page_title_subjects'];
 $lngstr['page_title_subjects_settings'] = 'Subject Settings';
 $lngstr['page_header_subjects_settings'] = $lngstr['page_title_subjects_settings'];
$lngstr['page_title_emailtemplates'] = 'Email Templates';
$lngstr['page_header_emailtemplates'] = $lngstr['page_title_emailtemplates'];
 $lngstr['page_title_etemplates_edit'] = 'Edit Email Template';
 $lngstr['page_header_etemplates_edit'] = $lngstr['page_title_etemplates_edit'];
$lngstr['page_title_rtemplates'] = 'Report Templates';
$lngstr['page_header_rtemplates'] = $lngstr['page_title_rtemplates'];
 $lngstr['page_title_rtemplates_edit'] = 'Edit Report Template';
 $lngstr['page_header_rtemplates_edit'] = $lngstr['page_title_rtemplates_edit'];
$lngstr['page_title_grades'] = 'Grading Systems';
$lngstr['page_header_grades'] = $lngstr['page_title_grades'];
 $lngstr['page_title_grades_edit'] = 'Grading System Settings';
 $lngstr['page_header_grades_edit'] = $lngstr['page_title_grades_edit'];
$lngstr['page_title_gradescales'] = 'Grading Scale';
$lngstr['page_header_gradescales'] = $lngstr['page_title_gradescales'];
 $lngstr['page_title_grade_settings'] = 'Edit Grade';
 $lngstr['page_header_grade_settings'] = $lngstr['page_title_grade_settings'];
$lngstr['page_title_config'] = 'Configuration';
$lngstr['page_header_config'] = $lngstr['page_title_config'];
$lngstr['page_title_visitors'] = 'Web Statistics';
$lngstr['page_header_visitors'] = $lngstr['page_title_visitors'];
 $lngstr['page_title_visitordetails'] = 'Visitor Details';
 $lngstr['page_header_visitordetails'] = $lngstr['page_title_visitordetails'];
$lngstr['page_resourcemanager']['title'] = 'Resource Manager';
$lngstr['page_resourcemanager']['header'] = $lngstr['page_resourcemanager']['title'];
 $lngstr['page_resourcemanager_settings']['title'] = 'Resource Settings';
 $lngstr['page_resourcemanager_settings']['header'] = $lngstr['page_resourcemanager_settings']['title'];
$lngstr['page_resources']['title'] = 'Resources';
$lngstr['page_resources']['header'] = $lngstr['page_resources']['title'];
$lngstr['page_couponmanager']['title'] = 'Coupon Manager';
$lngstr['page_couponmanager']['header'] = $lngstr['page_couponmanager']['title'];
 $lngstr['page_couponmanager_settings']['title'] = 'Coupon Settings';
 $lngstr['page_couponmanager_settings']['header'] = $lngstr['page_couponmanager_settings']['title'];
$lngstr['page_buycheckout']['title'] = 'Buy a Test';
$lngstr['page_buycheckout']['header'] = $lngstr['page_buycheckout']['title'];
$lngstr['page_getfile_template_html']['title'] = 'HTML Report';

$lngstr['panel_home'] = $lngstr['page_title_panel'];
$lngstr['panel_results'] = $lngstr['page_title_results'];
$lngstr['panel_edittests'] = $lngstr['page_title_edittests'];
$lngstr['panel_questionbank'] = $lngstr['page_title_questionbank'];
$lngstr['panel_managegroups'] = $lngstr['page_title_managegroups'];
$lngstr['panel_signout'] = 'Sign Out';
$lngstr['panel_edit_subjects'] = 'Manage Subjects';
$lngstr['panel_usersandgroups'] = 'Administration';
$lngstr['panel_manage_groups'] = 'Manage Groups';
$lngstr['panel_manage_users'] = 'Manage Users';

$lngstr['label_choice_no'] = 'Choice %d:';
$lngstr['label_answer_text'] = 'Answer:';
$lngstr['label_answer_feedback_no'] = 'Feedback %d:';
$lngstr['label_accept_as_correct'] = 'Accept as correct';
$lngstr['label_answer_percents'] = '% correct';
$lngstr['label_mark_correct_answers'] = 'Please mark correct answer(s)';
$lngstr['label_mark_correct_fillintheblank'] = 'Please type correct answer here';

// Report Manager:
$lngstr['label_hdr_action'] = 'Action';
$lngstr['label_hdr_select_hint'] = 'Select or de-select all rows';
$lngstr['label_action_test_result_view'] = 'View this test results';
$lngstr['label_action_test_result_delete'] = 'Delete this record';
$lngstr['label_action_results_delete'] = 'Delete records (for selected records)';
$lngstr['label_action_view_question_result'] = 'View answer details';

// Test Manager:
$lngstr['label_action_test_settings'] = 'Test settings';
$lngstr['label_action_questions_edit'] = 'Edit questions';
$lngstr['label_action_test_delete'] = 'Delete this test';
$lngstr['label_action_tests_delete'] = 'Delete tests (for selected records)';
$lngstr['label_action_question_edit'] = 'Edit this question';
$lngstr['label_action_question_moveup'] = 'Move up';
$lngstr['label_action_question_movedown'] = 'Move down';
$lngstr['label_action_question_append'] = 'Add this question to the test';
$lngstr['label_action_questions_append'] = 'Add questions to the test (for selected records)';
$lngstr['label_action_question_delete'] = 'Delete this question';
$lngstr['label_action_questions_delete'] = 'Delete questions (for selected records)';
$lngstr['label_action_question_link_delete'] = 'Remove this question from the test';
$lngstr['label_action_question_links_delete'] = 'Remove questions from the test (for selected records)';
$lngstr['label_action_question_stats'] = 'Show statistics';
$lngstr['label_action_questions_stats'] = 'Show statistics (for selected records)';
$lngstr['label_action_manageusers_edit'] = 'User settings';
$lngstr['label_action_manageusers_groups'] = 'User groups';
$lngstr['label_action_groups'] = 'User groups (for selected records)';
$lngstr['label_action_manageusers_delete'] = 'Delete this user';
$lngstr['label_action_users_delete'] = 'Delete users (for selected records)';
$lngstr['label_action_create_user'] = 'Create a new user';
$lngstr['label_action_group_delete'] = 'Delete this group';
$lngstr['label_action_groups_delete'] = 'Delete groups (for selected records)';
$lngstr['label_action_create_group'] = 'Create a new group';
$lngstr['label_action_group_edit'] = 'Group settings';
$lngstr['label_action_test_groups_select'] = 'Assign to groups';
$lngstr['label_action_subject_edit'] = 'Subject settings';
$lngstr['label_action_subject_delete'] = 'Delete this subject';
$lngstr['label_action_subjects_delete'] = 'Delete subjects (for selected records)';
$lngstr['label_action_create_test'] = 'Create a new test';
$lngstr['label_action_import_questions'] = 'Import questions';
$lngstr['label_action_create_question'] = 'Create a new question';
$lngstr['label_action_create_and_add_question'] = 'Create / add a question to the test';
$lngstr['label_action_create_etemplate'] = 'Create a new email template';
$lngstr['label_action_etemplates_edit'] = 'Edit this email template';
$lngstr['label_action_etemplate_delete'] = 'Delete this email template';
$lngstr['label_action_etemplates_delete'] = 'Delete email templates (for selected records)';
$lngstr['label_action_grade_settings'] = 'Grading system settings';
$lngstr['label_action_grade_delete'] = 'Delete this grading system';
$lngstr['label_action_grades_delete'] = 'Delete grading systems (for selected records)';
$lngstr['label_action_gradescales_edit'] = 'Edit this grading scale';
$lngstr['label_action_gradescales_delete'] = 'Delete grades (for selected records)';
$lngstr['label_action_gradescale_edit'] = 'Edit this grade';
$lngstr['label_action_gradescale_delete'] = 'Delete this grade';
$lngstr['label_action_visitor_delete'] = 'Delete this record';
$lngstr['label_action_visitors_delete'] = 'Delete records (for selected records)';
$lngstr['page-sections']['action_section_create'] = 'Create a new section';
$lngstr['page-sections']['action_section_edit'] = 'Edit this section';
$lngstr['page-sections']['action_section_delete'] = 'Delete this section';
$lngstr['page-sections']['action_sections_delete'] = 'Delete sections (for selected records)';
$lngstr['page-rtemplates']['action_create_rtemplate'] = 'Create a new report template';
$lngstr['page-rtemplates']['action_rtemplate_delete'] = 'Delete this report template';
$lngstr['page-rtemplates']['action_rtemplates_delete'] = 'Delete report templates (for selected records)';
$lngstr['page-rtemplates']['action_rtemplates_edit'] = 'Edit this report template';

$lngstr['label_test_testinstructions'] = 'Test instructions';
$lngstr['page_test']['no_time_limit'] = 'No Timer';
$lngstr['page_test']['test_timer_hint'] = 'Test timer';
$lngstr['page_test']['questionindicator'] = '%d of %d';
$lngstr['page_test']['questionindicator_hint'] = 'Question %d of %d';
$lngstr['page_test']['testname_hint'] = 'Test name';
$lngstr['label_result_username'] = '<b>Participant name:</b> %s';
$lngstr['label_result_testname'] = '<b>Test name:</b> %s';
$lngstr['label_result_testdate'] = '<b>Date:</b> %s';
$lngstr['label_result_timespent'] = '<b>Time spent:</b> %s';
$lngstr['label_result_got_answers'] = '<b>Correct answers:</b> %d out of %d';
$lngstr['label_result_got_points'] = '<b>Score:</b> %d out of %d (%d%%)';
$lngstr['label_result_points_pending'] = '<b>Points pending:</b> %d';
$lngstr['label_result_got_grade'] = '<b>Grade:</b> %s';
$lngstr['label_result_got_gradefeedback'] = '<b>Grade comments:</b> %s';
$lngstr['label_result_do_not_show'] = 'Your test has been scored and recorded.';
$lngstr['label_result_showpdf'] = 'Click here to get printable PDF report';
$lngstr['page_test']['result']['showhtml'] = 'Click here to get HTML report';

$lngstr['page_test_instructions']['next_page'] = 'Next page';

$lngstr['label_report_hdr_resultid'] = 'ID';
$lngstr['label_report_hdr_resultid_hint'] = 'Result ID (click to sort by)';
$lngstr['label_report_hdr_result_datestart'] = 'Date';
$lngstr['label_report_hdr_result_datestart_hint'] = 'Date (click to sort by)';
$lngstr['label_report_hdr_user_name'] = 'Username';
$lngstr['label_report_hdr_user_name_hint'] = 'Username (click to sort by)';
$lngstr['label_report_hdr_test_name'] = 'Test Name';
$lngstr['label_report_hdr_test_name_hint'] = 'Test name (click to sort by)';
$lngstr['page_reportsmanager']['hdr_test_attempts'] = 'Attempts Exc.';
$lngstr['page_reportsmanager']['hdr_test_attempts_hint'] = 'Attempts exceeded';
$lngstr['label_report_hdr_result_timeexceeded'] = 'Time Exc.';
$lngstr['label_report_hdr_result_timeexceeded_hint'] = 'Time exceeded (click to sort by)';
$lngstr['label_report_hdr_result_points'] = 'Points Scored';
$lngstr['label_report_hdr_result_points_hint'] = 'Points scored (click to sort by)';
$lngstr['label_report_hdr_result_pointsmax'] = 'Points Possible';
$lngstr['label_report_hdr_result_pointsmax_hint'] = 'Points possible (click to sort by)';
$lngstr['label_report_hdr_result_score'] = 'Score';
$lngstr['label_report_hdr_result_score_hint'] = 'Score (click to sort by)';
$lngstr['label_report_hdr_gscale_gradeid'] = 'Grade';
$lngstr['label_report_hdr_gscale_gradeid_hint'] = 'Grade (click to sort by)';
$lngstr['label_report_hdr2_result_answerid'] = 'Seq';
$lngstr['label_report_hdr2_result_answerid_hint'] = 'Sequence (click to sort by)';
$lngstr['label_report_hdr2_test_questionid'] = '#';
$lngstr['label_report_hdr2_test_questionid_hint'] = 'Question number (click to sort by)';
$lngstr['label_report_hdr2_result_answer_timespent'] = 'Time';
$lngstr['label_report_hdr2_result_answer_timespent_hint'] = 'Time (click to sort by)';
$lngstr['label_report_hdr2_result_answer_text'] = 'Answer';
$lngstr['label_report_hdr2_result_answer_text_hint'] = 'Answer';
$lngstr['label_report_hdr2_result_answer_points'] = 'Points';
$lngstr['label_report_hdr2_result_answer_points_hint'] = 'Point value (click to sort by)';
$lngstr['label_report_hdr2_result_answer_iscorrect'] = 'Correct';
$lngstr['label_report_hdr2_result_answer_iscorrect_hint'] = 'Correct (click to sort by)';
$lngstr['label_report_hdr2_result_answer_timeexceeded'] = $lngstr['label_report_hdr_result_timeexceeded'];
$lngstr['label_report_hdr2_result_answer_timeexceeded_hint'] = $lngstr['label_report_hdr_result_timeexceeded_hint'];
$lngstr['label_edittests_hdr_testid'] = 'ID';
$lngstr['label_edittests_hdr_testid_hint'] = 'Test ID (click to sort by)';
$lngstr['label_edittests_hdr_test_name'] = 'Test Name';
$lngstr['label_edittests_hdr_test_name_hint'] = 'Test name (click to sort by)';
$lngstr['label_edittests_hdr_subjectid'] = 'Subject';
$lngstr['label_edittests_hdr_subjectid_hint'] = 'Subject (click to sort by)';
$lngstr['label_edittests_hdr_test_datestart'] = 'Start Date';
$lngstr['label_edittests_hdr_test_datestart_hint'] = 'Start date (click to sort by)';
$lngstr['label_edittests_hdr_test_dateend'] = 'End Date';
$lngstr['label_edittests_hdr_test_dateend_hint'] = 'End date (click to sort by)';
$lngstr['label_edittests_hdr_test_notes'] = 'N';
$lngstr['label_edittests_hdr_test_notes_hint'] = 'Notes';
$lngstr['label_edittests_hdr_test_enabled'] = 'Active';
$lngstr['label_edittests_hdr_test_enabled_hint'] = 'Active (click to sort by)';
$lngstr['label_editquestions_hdr_questionid'] = 'ID';
$lngstr['label_editquestions_hdr_questionid_hint'] = 'Question ID (click to sort by)';
$lngstr['label_editquestions_hdr_subjectid'] = 'Subject';
$lngstr['label_editquestions_hdr_subjectid_hint'] = 'Subject (click to sort by)';
$lngstr['label_editquestions_hdr_question_text'] = 'Question';
$lngstr['label_editquestions_hdr_question_text_hint'] = 'Question';
$lngstr['label_editquestions_hdr_question_type'] = 'Type';
$lngstr['label_editquestions_hdr_question_type_hint'] = 'Type (click to sort by)';
$lngstr['label_editquestions_hdr_question_points'] = 'Points';
$lngstr['label_editquestions_hdr_question_points_hint'] = 'Point value (click to sort by)';
$lngstr['label_editquestions_hdr_test_questionid'] = 'Seq';
$lngstr['label_editquestions_hdr_test_questionid_hint'] = 'Sequence (click to sort by)';
$lngstr['label_questionstats_hdr_questionid'] = 'ID';
$lngstr['label_questionstats_hdr_questionid_hint'] = 'Question ID';
$lngstr['label_questionstats_hdr_questiondata'] = 'Question Data';
$lngstr['label_questionstats_hdr_questiondata_hint'] = 'Question data';
$lngstr['label_questionstats_hdr_answerclicks'] = 'Clicks';
$lngstr['label_questionstats_hdr_answerclicks_hint'] = 'Answer clicks';
$lngstr['label_questionstats_hdr_answerpercent'] = '%';
$lngstr['label_questionstats_hdr_answerpercent_hint'] = 'Percents';
$lngstr['label_manageusers_hdr_userid'] = 'ID';
$lngstr['label_manageusers_hdr_userid_hint'] = 'User ID (click to sort by)';
$lngstr['label_manageusers_hdr_user_notes'] = 'N';
$lngstr['label_manageusers_hdr_user_notes_hint'] = 'Notes';
$lngstr['label_manageusers_hdr_user_name'] = 'Username';
$lngstr['label_manageusers_hdr_user_name_hint'] = 'Username (click to sort by)';
$lngstr['label_manageusers_hdr_user_email'] = 'Email';
$lngstr['label_manageusers_hdr_user_email_hint'] = 'Email (click to sort by)';
$lngstr['label_manageusers_hdr_user_firstname'] = 'First Name';
$lngstr['label_manageusers_hdr_user_firstname_hint'] = 'First name (click to sort by)';
$lngstr['label_manageusers_hdr_user_lastname'] = 'Last Name';
$lngstr['label_manageusers_hdr_user_lastname_hint'] = 'Last name (click to sort by)';
$lngstr['label_manageusers_hdr_user_enabled'] = 'Active';
$lngstr['label_manageusers_hdr_user_enabled_hint'] = 'Active (click to sort by)';
$lngstr['label_managegroups_hdr_groupid'] = 'ID';
$lngstr['label_managegroups_hdr_groupid_hint'] = 'Group ID (click to sort by)';
$lngstr['label_managegroups_hdr_group_name'] = 'Name';
$lngstr['label_managegroups_hdr_group_name_hint'] = 'Group name (click to sort by)';
$lngstr['label_managegroups_hdr_group_description'] = 'Description';
$lngstr['label_managegroups_hdr_group_description_hint'] = 'Group description (click to sort by)';
$lngstr['label_managegroups_hdr_member_of'] = 'Member';
$lngstr['label_managegroups_hdr_member_of_hint'] = 'Member of (click to sort by)';
$lngstr['label_subjects_hdr_subjectid'] = 'ID';
$lngstr['label_subjects_hdr_subjectid_hint'] = 'Subject ID (click to sort by)';
$lngstr['label_subjects_hdr_subject_name'] = 'Name';
$lngstr['label_subjects_hdr_subject_name_hint'] = 'Subject name (click to sort by)';
$lngstr['label_subjects_hdr_subject_description'] = 'Description';
$lngstr['label_subjects_hdr_subject_description_hint'] = 'Subject description (click to sort by)';
$lngstr['label_etemplates_hdr_etemplateid'] = 'ID';
$lngstr['label_etemplates_hdr_etemplateid_hint'] = 'Email template ID (click to sort by)';
$lngstr['label_etemplates_hdr_etemplate_name'] = 'Name';
$lngstr['label_etemplates_hdr_etemplate_name_hint'] = 'Email template name (click to sort by)';
$lngstr['label_etemplates_hdr_etemplate_description'] = 'Description';
$lngstr['label_etemplates_hdr_etemplate_description_hint'] = 'Email template description (click to sort by)';

$lngstr['page-rtemplates']['hdr_rtemplateid'] = 'ID';
$lngstr['page-rtemplates']['hdr_rtemplateid_hint'] = 'Report template ID (click to sort by)';
$lngstr['page-rtemplates']['hdr_rtemplate_name'] = 'Name';
$lngstr['page-rtemplates']['hdr_rtemplate_name_hint'] = 'Report template name (click to sort by)';
$lngstr['page-rtemplates']['hdr_rtemplate_description'] = 'Description';
$lngstr['page-rtemplates']['hdr_rtemplate_description_hint'] = 'Report template description (click to sort by)';

$lngstr['label_grades_hdr_gscaleid'] = 'ID';
$lngstr['label_grades_hdr_gscaleid_hint'] = 'Grading system ID (click to sort by)';
$lngstr['label_grades_hdr_gscale_name'] = 'Name';
$lngstr['label_grades_hdr_gscale_name_hint'] = 'Grading system name (click to sort by)';
$lngstr['label_grades_hdr_gscale_description'] = 'Description';
$lngstr['label_grades_hdr_gscale_description_hint'] = 'Grading system description (click to sort by)';
$lngstr['label_gradescales_hdr_gscale_gradeid'] = 'ID';
$lngstr['label_gradescales_hdr_gscale_gradeid_hint'] = 'Grade ID (click to sort by)';
$lngstr['label_gradescales_hdr_grade_from'] = 'Min';
$lngstr['label_gradescales_hdr_grade_from_hint'] = 'Minimum (click to sort by)';
$lngstr['label_gradescales_hdr_grade_to'] = 'Max';
$lngstr['label_gradescales_hdr_grade_to_hint'] = 'Maximum (click to sort by)';
$lngstr['label_gradescales_hdr_grade_name'] = 'Name';
$lngstr['label_gradescales_hdr_grade_name_hint'] = 'Grade name (click to sort by)';
$lngstr['label_gradescales_hdr_grade_description'] = 'Description';
$lngstr['label_gradescales_hdr_grade_description_hint'] = 'Grade description (click to sort by)';
$lngstr['label_visitors_hdr_visitorid'] = 'ID';
$lngstr['label_visitors_hdr_visitorid_hint'] = 'Visitor ID (click to sort by)';
$lngstr['label_visitors_hdr_startdate'] = 'Date';
$lngstr['label_visitors_hdr_startdate_hint'] = 'Date (click to sort by)';
$lngstr['label_visitors_hdr_username'] = 'Username';
$lngstr['label_visitors_hdr_username_hint'] = 'Username (click to sort by)';
$lngstr['label_visitors_hdr_hits'] = 'Hits';
$lngstr['label_visitors_hdr_hits_hint'] = 'Hits (click to sort by)';
$lngstr['label_visitors_hdr_ip'] = 'IP-Address';
$lngstr['label_visitors_hdr_ip_hint'] = 'IP-address';
$lngstr['label_visitors_hdr_host'] = 'Host Name';
$lngstr['label_visitors_hdr_host_hint'] = 'Host name (click to sort by)';
$lngstr['label_visitors_hdr_referer'] = 'Referrer';
$lngstr['label_visitors_hdr_referer_hint'] = 'Referrer (click to sort by)';
$lngstr['page-sections']['hdr_sectionid'] = 'Seq';
$lngstr['page-sections']['hdr_sectionid_hint'] = 'Sequence (click to sort by)';
$lngstr['page-sections']['hdr_section_name'] = 'Name';
$lngstr['page-sections']['hdr_section_name_hint'] = 'Section name (click to sort by)';
$lngstr['page-sections']['hdr_section_description'] = 'Description';
$lngstr['page-sections']['hdr_section_description_hint'] = 'Section description (click to sort by)';


$lngstr['button_signin'] = 'Sign in';
$lngstr['button_signin_as_guest'] = 'Sign in as guest';
$lngstr['button_register'] = 'Register';
$lngstr['button_starttest'] = 'Start test';
$lngstr['button_continue'] = 'Continue';
$lngstr['button_showresults'] = 'Continue';
$lngstr['button_answer'] = 'Answer';
$lngstr['button_submit'] = 'Submit';
$lngstr['button_update'] = 'Update';
$lngstr['button_update_and_edit_questions'] = 'Update / switch to questions';
$lngstr['button_update_and_create_new_question'] = 'Update / create new question';
$lngstr['button_back'] = 'Back';
$lngstr['button_cancel'] = 'Cancel';
$lngstr['button_set'] = 'Set';
$lngstr['button_import'] = 'Import';
$lngstr['button_browse'] = 'Browse';

$lngstr['label_pleasespecify'] = '- Please specify -';

$lngstr['label_username'] = 'Username:';
$lngstr['label_password'] = 'Password:';
$lngstr['label_confirmpassword'] = 'Confirm password:';
$lngstr['label_newpassword'] = 'New password:';
$lngstr['label_email'] = 'Email:';
$lngstr['label_title'] = 'Title:';
$lngstr['label_firstname'] = 'First name:';
$lngstr['label_lastname'] = 'Last name:';
$lngstr['label_middlename'] = 'Middle name:';

$lngstr['label_address'] = 'Address:';
$lngstr['label_city'] = 'City:';
$lngstr['label_state'] = 'State/province:';
$lngstr['label_zip'] = 'Zip/postal code:';
$lngstr['label_country'] = 'Country:';
$lngstr['label_phone'] = 'Phone:';
$lngstr['label_fax'] = 'Fax:';
$lngstr['label_mobile'] = 'Mobile:';
$lngstr['label_pager'] = 'Pager:';
$lngstr['label_ipphone'] = 'IP phone:';
$lngstr['label_webpage'] = 'Web page:';
$lngstr['label_icq'] = 'ICQ:';
$lngstr['label_msn'] = 'MSN messenger:';
$lngstr['label_aol'] = 'AOL messenger:';
$lngstr['label_gender'] = 'Gender:';
$lngstr['label_gender_items'] = array(0 => $lngstr['label_pleasespecify'], 1 => 'Male', 2 => 'Female');
$lngstr['label_birthday'] = 'Birthday:';
$lngstr['label_husbandwife'] = 'Husband (wife):';
$lngstr['label_children'] = 'Children:';
$lngstr['label_trainer'] = 'Trainer:';
$lngstr['label_photo'] = 'Photo:';

$lngstr['label_company'] = 'Company:';
$lngstr['label_cposition'] = 'Position:';
$lngstr['label_department'] = 'Department:';
$lngstr['label_coffice'] = 'Office:';
$lngstr['label_caddress'] = $lngstr['label_address'];
$lngstr['label_ccity'] = $lngstr['label_city'];
$lngstr['label_cstate'] = $lngstr['label_state'];
$lngstr['label_czip'] = $lngstr['label_zip'];
$lngstr['label_ccountry'] = $lngstr['label_country'];
$lngstr['label_cphone'] = $lngstr['label_phone'];
$lngstr['label_cfax'] = $lngstr['label_fax'];
$lngstr['label_cmobile'] = $lngstr['label_mobile'];
$lngstr['label_cpager'] = $lngstr['label_pager'];
$lngstr['label_cipphone'] = $lngstr['label_ipphone'];
$lngstr['label_cwebpage'] = $lngstr['label_webpage'];
$lngstr['label_cphoto'] = 'Logo:';

$lngstr['label_userfield'] = 'Custom field %d:';
$lngstr['label_userfield_caption'] = 'Custom field %d caption:';
$lngstr['label_userfield_type'] = 'Custom field %d type:';
$lngstr['label_userfield_type_items'] = array(CONFIG_CONST_type_singlelinetext => 'Single-line text', CONFIG_CONST_type_multilinetext => 'Multiline text', CONFIG_CONST_type_dropdownlist => 'Drop-down list');
$lngstr['label_userfield_values_hint'] = '(comma-separated list items)';

$lngstr['label_filter_header'] = 'Set a filter (click to show/hide)';
$lngstr['button_set_filter'] = 'Set filter';
$lngstr['button_remove_filter'] = 'Remove filter';
$lngstr['page_reportsmanager']['filter_dates_years_items'] = array(0 => '', 'd0' => '0 days', 'd1' => '1 day', 'd2' => '2 days', 'd3' => '3 days', 'd4' => '4 days', 'd5' => '5 days', 'd6' => '6 days', 'd7' => '1 week', 'd14' => '2 weeks', 'd21' => '3 weeks', 'd29' => '4 weeks', 'm1' => '1 month', 'm2' => '2 months', 'm3' => '3 months', 'm4' => '4 months', 'm5' => '5 months', 'm6' => '6 months', 'm7' => '7 months', 'm8' => '8 months', 'm9' => '9 months', 'm10' => '10 months', 'm11' => '11 months', 'y1' => '1 year', 'y2' => '2 years', 'y3' => '3 years', 'y4' => '4 years', 'y5' => '5 years', 'y6' => '6 years');
$lngstr['page_reportsmanager']['filter_dates_years'] = 'Date:';
$lngstr['page_reportsmanager']['div_report_header'] = 'Select a report (click to show/hide)';
$lngstr['page_reportsmanager']['report_list'] = 'Report template:';
$lngstr['page_reportsmanager']['report_export_to_csv'] = 'Export to CSV';
$lngstr['page_reportsmanager']['report_preview'] = 'Preview this report';
$lngstr['page_reportsmanager']['report_print'] = 'Print this report';
$lngstr['page_reportsmanager']['fields']['name']['resultid'] = $lngstr['label_report_hdr_resultid'];
$lngstr['page_reportsmanager']['fields']['name']['result_datestart'] = $lngstr['label_report_hdr_result_datestart'];
$lngstr['page_reportsmanager']['fields']['name']['result_datestart_formatted'] = $lngstr['label_report_hdr_result_datestart'];
$lngstr['page_reportsmanager']['fields']['name']['userid'] = 'User ID';
$lngstr['page_reportsmanager']['fields']['name']['user_name'] = $lngstr['label_report_hdr_user_name'];
$lngstr['page_reportsmanager']['fields']['name']['user_firstname'] = 'First Name';
$lngstr['page_reportsmanager']['fields']['name']['user_lastname'] = 'Last Name';
$lngstr['page_reportsmanager']['fields']['name']['testid'] = 'Test ID';
$lngstr['page_reportsmanager']['fields']['name']['test_name'] = $lngstr['label_report_hdr_test_name'];
$lngstr['page_reportsmanager']['fields']['name']['test_attempts'] = $lngstr['page_reportsmanager']['hdr_test_attempts'];
$lngstr['page_reportsmanager']['fields']['name']['result_timeexceeded'] = $lngstr['label_report_hdr_result_timeexceeded'];
$lngstr['page_reportsmanager']['fields']['name']['result_points'] = $lngstr['label_report_hdr_result_points'];
$lngstr['page_reportsmanager']['fields']['name']['result_pointsmax'] = $lngstr['label_report_hdr_result_pointsmax'];
$lngstr['page_reportsmanager']['fields']['name']['result_score'] = $lngstr['label_report_hdr_result_score'];
$lngstr['page_reportsmanager']['fields']['name']['grade_name'] = $lngstr['label_report_hdr_gscale_gradeid'];

$lngstr['page_register']['no_username'] = 'No correct username specified.<br>';
$lngstr['page_register']['no_email'] = 'No correct email specified.<br>';
$lngstr['page_register']['no_password'] = 'Password and repeated password do not match.<br>';
$lngstr['page_register']['no_title'] = 'No correct title specified.<br>';
$lngstr['page_register']['no_firstname'] = 'No correct first name specified.<br>';
$lngstr['page_register']['no_lastname'] = 'No correct last name specified.<br>';
$lngstr['page_register']['no_middlename'] = 'No correct middle name specified.<br>';

$lngstr['page_register']['no_address'] = 'No correct address specified.<br>';
$lngstr['page_register']['no_city'] = 'No correct city specified.<br>';
$lngstr['page_register']['no_state'] = 'No correct state/province specified.<br>';
$lngstr['page_register']['no_zip'] = 'No correct zip/postal code specified.<br>';
$lngstr['page_register']['no_country'] = 'No correct country specified.<br>';
$lngstr['page_register']['no_phone'] = 'No correct phone specified.<br>';
$lngstr['page_register']['no_fax'] = 'No correct fax specified.<br>';
$lngstr['page_register']['no_mobile'] = 'No correct mobile specified.<br>';
$lngstr['page_register']['no_pager'] = 'No correct pager specified.<br>';
$lngstr['page_register']['no_ipphone'] = 'No correct IP phone specified.<br>';
$lngstr['page_register']['no_webpage'] = 'No correct web page specified.<br>';
$lngstr['page_register']['no_icq'] = 'No correct ICQ messenger identifier specified.<br>';
$lngstr['page_register']['no_msn'] = 'No correct MSN messenger identifier specified.<br>';
$lngstr['page_register']['no_aol'] = 'No correct AOL messenger identifier specified.<br>';
$lngstr['page_register']['no_gender'] = 'No correct gender specified.<br>';
$lngstr['page_register']['no_birthday'] = 'No correct birthday specified.<br>';
$lngstr['page_register']['no_husbandwife'] = 'No correct husband (wife) name specified.<br>';
$lngstr['page_register']['no_children'] = 'No correct children specified.<br>';
$lngstr['page_register']['no_trainer'] = 'No correct trainer name specified.<br>';
$lngstr['page_register']['no_photo'] = 'No correct photo specified.<br>';

$lngstr['page_register']['no_company'] = 'No correct company specified.<br>';
$lngstr['page_register']['no_cposition'] = 'No correct company position specified.<br>';
$lngstr['page_register']['no_department'] = 'No correct company department specified.<br>';
$lngstr['page_register']['no_coffice'] = 'No correct company office specified.<br>';
$lngstr['page_register']['no_caddress'] = 'No correct company address specified.<br>';
$lngstr['page_register']['no_ccity'] = 'No correct company city specified.<br>';
$lngstr['page_register']['no_cstate'] = 'No correct company state/province specified.<br>';
$lngstr['page_register']['no_czip'] = 'No correct company zip/postal code specified.<br>';
$lngstr['page_register']['no_ccountry'] = 'No correct company country specified.<br>';
$lngstr['page_register']['no_cphone'] = 'No correct company phone specified.<br>';
$lngstr['page_register']['no_cfax'] = 'No correct company fax specified.<br>';
$lngstr['page_register']['no_cmobile'] = 'No correct company mobile specified.<br>';
$lngstr['page_register']['no_cpager'] = 'No correct company pager specified.<br>';
$lngstr['page_register']['no_cipphone'] = 'No correct company IP phone specified.<br>';
$lngstr['page_register']['no_cwebpage'] = 'No correct company web page specified.<br>';
$lngstr['page_register']['no_cphoto'] = 'No correct company logo specified.<br>';

$lngstr['page_register']['no_userfield'] = 'No correct "%s" field specified.<br>';
$lngstr['page_register']['no_userfield1'] = $lngstr['page_register']['no_userfield'];
$lngstr['page_register']['no_userfield2'] = $lngstr['page_register']['no_userfield'];
$lngstr['page_register']['no_userfield3'] = $lngstr['page_register']['no_userfield'];
$lngstr['page_register']['no_userfield4'] = $lngstr['page_register']['no_userfield'];
$lngstr['page_register']['no_userfield5'] = $lngstr['page_register']['no_userfield'];
$lngstr['page_register']['no_userfield6'] = $lngstr['page_register']['no_userfield'];
$lngstr['page_register']['no_userfield7'] = $lngstr['page_register']['no_userfield'];
$lngstr['page_register']['no_userfield8'] = $lngstr['page_register']['no_userfield'];
$lngstr['page_register']['no_userfield9'] = $lngstr['page_register']['no_userfield'];
$lngstr['page_register']['no_userfield10'] = $lngstr['page_register']['no_userfield'];
$lngstr['err_username_duplicate'] = 'This username is already taken. Please choose another username.<br>';
$lngstr['err_groupname_duplicate'] = 'This group name is already taken. Please choose another group name.<br>';
$lngstr['err_subjectname_duplicate'] = 'This subject name is already taken. Please choose another subject name.<br>';
$lngstr['err_signin_incorrect']  = 'Could not sign in. The username or password is incorrect.<br>';

// Register page:
$lngstr['page-register']['intro'] = 'You can use this form to add an account.';
$lngstr['page-register']['successful'] = 'The user "%s" is successfully added.';
$lngstr['page-register']['check_activation_email'] = 'An email have been sent to your address. It contains instructions to complete your registration.';
$lngstr['page-register']['wait_for_approval'] = 'Your account is successfully created and has to be activated by an administrator, please be patient.';
$lngstr['page-register']['account_activated'] = 'Your account has been successfully activated.';
$lngstr['page-register']['title_items'] = array('' => $lngstr['label_none'], 'Dr.' => 'Dr.', 'Miss' => 'Miss', 'Mr.' => 'Mr.', 'Mrs.' => 'Mrs.', 'Ms.' => 'Ms.', 'Prof.' => 'Prof.', 'Rev.' => 'Rev.');
$lngstr['page_register']['required_mark'] = REQUIRED_FIELD_MARK.' = Indicates a required field';

// Sign in page:
$lngstr['page_signin_box_signin_intro'] = '<b>Please sign in</b>';
$lngstr['page_signin_box_signin'] = $lngstr['label_username'];
$lngstr['page_signin_box_password'] = $lngstr['label_password'];
$lngstr['page_signin_box_register_intro'] = '<b>Do not have an account?</b> You can register yourself by <a href="register.php">clicking on this link</a>.';
$lngstr['page_signin_box_lostpassword_intro'] = '<b>Forgot your Password?</b> If you have <a href="lostpassword.php">forgotten your password</a>, we can email you a new one.';
$lngstr['page_signin']['test_code'] = 'Test code:';

// Forgot password page:
$lngstr['page_lostpassword_enter_username'] = '<b>Please enter your username</b>';
$lngstr['button_send_new_password'] = 'Send a new password';
$lngstr['err_username_not_found'] = 'Username not found! Please try again.';
$lngstr['inf_password_reset'] = 'Your password was reset! Please check your email box.';

// Take a test page:
$lngstr['page_takeatest']['hdr_testid'] = $lngstr['label_edittests_hdr_testid'];
$lngstr['page_takeatest']['hdr_testid_hint'] = $lngstr['label_edittests_hdr_testid_hint'];
$lngstr['page_panel_hdr_test'] = 'Test Name';
$lngstr['page_panel_hdr_test_hint'] = 'Test name and description (click to sort by)';
$lngstr['page_panel_hdr_teststatus'] = 'Status';
$lngstr['page_panel_hdr_teststatus_hint'] = 'Test status';
$lngstr['page_panel_hdr_gettest'] = 'Get Test';
$lngstr['page_panel_hdr_gettest_hint'] = 'Get test';
$lngstr['page_panel_status_available'] = 'Available';
$lngstr['page_panel_status_will_be_available_on'] = 'Will be available on<br>%s';
$lngstr['page_panel_status_inprogress'] = 'In progress';
$lngstr['page_panel_get_test_link'] = 'Test';
$lngstr['page_takeatest']['buy_test'] = 'Buy';
$lngstr['page-takeatest']['attempts_left'] = 'Available<br>(attempts allowed: %d)';
$lngstr['page-takeatest']['attempts_limit_reached'] = 'Not available<br>(attempts allowed: 0)';
$lngstr['page-takeatest']['passed'] = 'Passed';
$lngstr['page_takeatest']['score'] = 'Score';
$lngstr['page_takeatest']['score_total'] = 'Your total score: %d out of %d (%.2f%%)';
$lngstr['page_takeatest']['hdr_score'] = 'Points'; // 'Score'
$lngstr['page_takeatest']['hdr_score_hint'] = 'Points'; // 'Score (click to sort by)'
$lngstr['page_test_results'] = 'Test results';
$lngstr['page_test_results_homepage'] = 'Return to Take a Test page';
$lngstr['page_test_results_viewresults'] = 'Review this test results';
$lngstr['page_test']['results_nexttest'] = 'Continue';
$lngstr['page_test']['finish_test'] = 'Cancel this test';
$lngstr['page_test']['qst_finish_test_header'] = 'Cancel a Test';
$lngstr['page_test']['qst_finish_test'] = 'Are you sure want to cancel this test?';
$lngstr['page_test']['review_question'] = 'Review';
$lngstr['page_test']['close_this_window'] = 'Close this window';

$lngstr['page_results_delete_record'] = 'Delete a Record';
$lngstr['page_edittests_delete_test'] = 'Delete a Test';
$lngstr['page_edittests_delete_question'] = 'Delete a Question';
$lngstr['page_edittests_delete_question_link'] = 'Delete a Question';
$lngstr['page_managegroups_delete_group'] = 'Delete a Group';
$lngstr['page_subjects_delete_subject'] = 'Delete a Subject';
$lngstr['page_manageusers_delete_user'] = 'Delete a User';
$lngstr['page_etemplates_delete_etemplate'] = 'Delete an Email Template';
$lngstr['page-rtemplates']['delete_rtemplate'] = 'Delete a Report Template';
$lngstr['page_grades_delete_grade'] = 'Delete a Grading System';
$lngstr['page_gradescales_delete_grade'] = 'Delete a Grade';
$lngstr['page_visitors_delete_visitor'] = 'Delete a Record';
$lngstr['page_visitors']['ipwhois'] = 'Lookup this IP address in the WhoIs service';

//[CUSTOM] $lngstr['page_testsettings']['test_type'] = 'Test type:';
//[CUSTOM] $lngstr['page_testsettings']['test_type_items'] = array(0 => 'Default', 1 => 'Survey');
$lngstr['page_edittests_subjectid'] = 'Test subject:';
$lngstr['page_edittests_testname'] = 'Test name:';
$lngstr['page_testmanager']['test_code'] = 'Test code:'; // $lngstr['page_all']['mnemonic_code']
$lngstr['page_edittests_testenabled'] = 'This test is active';
$lngstr['page_edittests_teststart'] = 'Test start date:';
$lngstr['page_edittests_testend'] = 'Test end date:';
$lngstr['page_edittests_testtime'] = 'Test time:';
$lngstr['page_edittests_testtimeforceout'] = 'End this test when the time limit is reached';
$lngstr['page-testmanager']['attempts_allowed'] = 'Attempts allowed:';
$lngstr['page-testmanager']['attempts_allowed_list'] = array(0 => 'Unlimited attempts', 1 => '1 attempt', 2 => '2 attempts', 3 => '3 attempts', 4 => '4 attempts', 5 => '5 attempts', 6 => '6 attempts', 7 => '7 attempts', 8 => '8 attempts', 9 => '9 attempts', 10 => '10 attempts', 11 => '11 attempts', 12 => '12 attempts', 13 => '13 attempts', 14 => '14 attempts', 15 => '15 attempts', 16 => '16 attempts', 17 => '17 attempts', 18 => '18 attempts', 19 => '19 attempts', 20 => '20 attempts');
$lngstr['page_testmanager']['content_protection'] = 'Content protection:';
$lngstr['page_testmanager']['content_protection_list'] = array(0 => $lngstr['label_none'], 1 => 'Protect (JavaScript)');
$lngstr['page_edittests_showquestions'] = 'Show questions:';
$lngstr['page_testmanager']['showquestions_items'] = array(1 => 'One by one', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '6', 7 => '7', 8 => '8', 9 => '9', 10 => '10', 0 => 'All questions');
$lngstr['page_edittests_shuffle'] = 'Shuffle options:';
$lngstr['page_edittests_shuffleq'] = 'Shuffle order of questions';
$lngstr['page_edittests_shufflea'] = 'Shuffle order of answers';
$lngstr['page_testmanager']['review_options'] = 'Review options:';
$lngstr['page_testmanager']['review_list'] = array(IGT_TEST_REVIEW_NOTALLOWED => 'Forbid any review', IGT_TEST_REVIEW_ALLOWED => 'Allow the questions review');
$lngstr['page_edittests_gradingsystem'] = 'Grading system:';
// $lngstr['label_no_gradingsystem'] = 'Do not use';
$lngstr['page_edittests_resultsettings'] = 'Test results report:';
$lngstr['page_edittests_result_showqfeedback'] = 'Show feedback';
$lngstr['page_edittests_result_showgrade'] = 'Show grade';
$lngstr['page_testmanager']['result_showgradefeedback'] = 'Show grade feedback';
$lngstr['page_edittests_result_showanswers'] = 'Show answers';
$lngstr['page_edittests_result_showpoints'] = 'Show points';
$lngstr['page_testsettings']['custom_report'] = 'Use custom template:';
$lngstr['page_edittests_testdescription'] = 'Short description:';
$lngstr['page_edittests_testinstructions'] = 'Overall test instructions:';
$lngstr['page_edittests_testnotes'] = 'Test notes (for internal use):';
$lngstr['page_edittests_assignedto'] = 'Assigned to:';
// $lngstr['page_edittests_assignedto_everybody'] = 'Everybody';
// $lngstr['page_edittests_assignedto_nobody'] = 'Nobody';
$lngstr['page_edittests_assignto_everybody'] = 'Assign to everybody (overrides any settings)';
$lngstr['page_edittests_advancedreport'] = 'Advanced report:';
// $lngstr['page-testsettings']['no_report'] = 'No report';
$lngstr['page-testsettings']['report_template'] = 'Template:';
$lngstr['page-testsettings']['report_grade_condition'] = 'Grade condition:';
$lngstr['page-testsettings']['no_condition'] = 'No condition';
// $lngstr['label_no_advanced_report'] = 'No advanced report';
$lngstr['page_edittests_advancedreport_showhtml'] = 'Show HTML report';
$lngstr['page_edittests_advancedreport_showpdf'] = 'Show printable PDF report';
$lngstr['page_edittests_sendresultsbyemail'] = 'Send results by email:';
$lngstr['page_edittests_sendresultsbyemail_template'] = 'Template:';
$lngstr['page_edittests_sendresultsbyemail_to'] = 'To:';
$lngstr['page_edittests_result_emailtouser'] = 'send results to users';
$lngstr['label_do_not_send_email'] = 'Do not send';
$lngstr['page-testmanager']['prevtest'] = 'Previous test:';
$lngstr['page-testmanager']['nexttest'] = 'Next test:';
$lngstr['page_testmanager']['testprice'] = 'Test price ('.$lngstr['language']['currency_name'].'):';
$lngstr['page_testmanager']['settings']['section_groups'] = 'Groups (click to show/hide)'; // $lngstr['page_users']['section_groups']
$lngstr['page_testmanager']['settings']['section_advanced'] = 'Advanced (click to show/hide)'; // $lngstr['page_grade']['section_advanced']
$lngstr['page_testmanager']['other_options'] = 'Other options:';
$lngstr['page_testmanager']['repeat_until_answered_correctly'] = 'Repeat the test until all questions are answered correctly';
$lngstr['page_testmanager']['settings']['section_notes'] = 'Notes (click to show/hide)'; // $lngstr['page_users']['section_notes']

$lngstr['page_testmanager']['view_test_stats'] = 'View test statistics';

$lngstr['page_assignto_hdr_assignto'] = 'Assigned';
$lngstr['page_assignto_hdr_assignto_hint'] = 'Assigned To';

$lngstr['page_testmanager_import']['document_label'] = 'Import this document:';
$lngstr['page_testmanager_import']['document_howto'] = '';
$lngstr['page_importtest_ut_import_document'] = 'UniTest System Import Document:';
$lngstr['page_importtest_ut_import_document_hint'] = 'Paste UniTest System\'s Import Document here';
$lngstr['page_importtest_ut_import_document_howto'] = '1. Run Editor module of UniTest System;<br>2. Select Import Document from the File -> Export menu;<br>3. Copy (using a clipboard) and paste it to this text box.';
$lngstr['page_testmanager_import']['section_delimiters'] = 'Prefixes (click to show/hide)';
$lngstr['page_testmanager_import']['question_delimiter'] = 'Question prefix:';
$lngstr['page_testmanager_import']['answer_delimiter'] = 'Choice prefix:';
$lngstr['page_testmanager_import']['answer2_delimiter'] = 'Choice prefix (for column 2):';
$lngstr['page_testmanager_import']['preq_delimiter'] = 'Question instructions prefix:';
$lngstr['page_testmanager_import']['postq_delimiter'] = 'Question explanation prefix:';
$lngstr['page_testmanager_import']['correct_delimiter'] = 'Correct answer value prefix:';
$lngstr['page_testmanager_import']['points_delimiter'] = 'Point value prefix:';
$lngstr['page_testmanager_import']['type_delimiter'] = 'Question type prefix:';
$lngstr['page_testmanager_import']['subject_delimiter'] = 'Question subject prefix:';
$lngstr['page_testmanager_import']['question_type_multiple_choice'] = 'multiple choice';
$lngstr['page_testmanager_import']['question_type_true_false'] = 'true/false';
$lngstr['page_testmanager_import']['question_type_multiple_answer'] = 'multiple answer';
$lngstr['page_testmanager_import']['question_type_short_answer'] = 'short answer';
$lngstr['page_testmanager_import']['question_type_essay'] = 'essay';

$lngstr['page_testmanager_stats']['all_participants'] = 'Statistics: all participants';
$lngstr['page_testmanager_stats']['hdr_testid'] = $lngstr['label_edittests_hdr_testid'];
$lngstr['page_testmanager_stats']['hdr_testid_hint'] = $lngstr['label_edittests_hdr_testid_hint'];
$lngstr['page_testmanager_stats']['hdr_test_data'] = 'Test data';
$lngstr['page_testmanager_stats']['hdr_test_data_hint'] = 'Test data';
$lngstr['page_testmanager_stats']['hdr_points'] = 'Points';
$lngstr['page_testmanager_stats']['hdr_points_hint'] = 'Points';
$lngstr['page_testmanager_stats']['hdr_percents'] = $lngstr['label_questionstats_hdr_answerpercent'];
$lngstr['page_testmanager_stats']['hdr_percents_hint'] = $lngstr['label_questionstats_hdr_answerpercent_hint'];
$lngstr['page_testmanager_stats']['test_high_score'] = 'Test high score:';
$lngstr['page_testmanager_stats']['test_average_score'] = 'Test average:';
$lngstr['page_testmanager_stats']['test_low_score'] = 'Test low score:';
$lngstr['page_testmanager_stats']['test_std_deviation'] = 'Standard deviation:';
$lngstr['page_testmanager_stats']['test_variance'] = 'Variance:';
$lngstr['page_testmanager_stats']['hdr_grade_data'] = 'Grade data';
$lngstr['page_testmanager_stats']['hdr_grade_data_hint'] = 'Grade data';
$lngstr['page_testmanager_stats']['hdr_grade_responses'] = 'Responses';
$lngstr['page_testmanager_stats']['hdr_grade_responses_hint'] = 'Responses';
$lngstr['page_testmanager_stats']['total_responses'] = 'Total responses:';
$lngstr['page_testmanager_stats']['this_participant'] = 'Statistics: this participant';
$lngstr['page_testmanager_stats']['hdr_subject_name'] = 'Pool name';
$lngstr['page_testmanager_stats']['hdr_subject_name_hint'] = 'Pool name';
$lngstr['page_testmanager_stats']['hdr_subject_questions'] = 'Size';
$lngstr['page_testmanager_stats']['hdr_subject_questions_hint'] = 'Pool size';
$lngstr['page_testmanager_stats']['hdr_subject_questions_got'] = 'Received';
$lngstr['page_testmanager_stats']['hdr_subject_questions_got_hint'] = 'Questions received from this pool';
$lngstr['page_testmanager_stats']['hdr_subject_correct'] = 'Correct';
$lngstr['page_testmanager_stats']['hdr_subject_correct_hint'] = 'Correct answers';
$lngstr['page_testmanager_stats']['view_results_stats'] = 'View statistics';

$lngstr['label_subjects_edit'] = 'Manage subjects';
// Subjects page:
$lngstr['label_action_create_subject'] = 'Create a new subject';
$lngstr['page_subjects']['parent_subjectid'] = 'Parent subject:';
$lngstr['page_subjects_subjectid'] = 'Subject ID:';
$lngstr['page_subjects_subjectname'] = 'Subject name:';
$lngstr['page_subjects_subjectdescription'] = 'Subject description:';

// Grades page:
$lngstr['label_action_create_grade'] = 'Create a new grading system';
$lngstr['label_action_create_gradescale'] = 'Create a new grade';
$lngstr['page_grades_gscaleid'] = 'Grading system ID:';
$lngstr['page_grades_gradename'] = 'Grading system name:';
$lngstr['page_grades_gradedescription'] = 'Grading system description:';
$lngstr['page_grades_gradescale'] = 'Grading scale:';
$lngstr['page_grades_gradescale_text'] = 'Edit the grading scale';
$lngstr['page_grades']['edit_grade'] = 'edit this grade';
$lngstr['label_action_grade_moveup'] = 'Move up';
$lngstr['label_action_grade_movedown'] = 'Move down';
$lngstr['page_grade_gscaleid'] = 'Grade ID:';
$lngstr['page_grade_gradename'] = 'Grade name:';
$lngstr['page_grade_gradedescription'] = 'Grade description:';
$lngstr['page_grade']['feedback'] = 'Grade feedback:';
$lngstr['page_grade']['section_advanced'] = 'Advanced (click to show/hide)';
$lngstr['page_grade_gradefrom'] = 'Minimum (%):';
$lngstr['page_grade_gradeto'] = 'Maximum (%):';

// Question statistics page:
$lngstr['page_questionstats_correct_count'] = 'Correct answers:';
$lngstr['page_questionstats_partially_count'] = 'Partially correct answers:';
$lngstr['page_questionstats_incorrect_count'] = 'Incorrect answers:';
$lngstr['page_questionstats_undefined_count'] = 'Undefined answers:';
$lngstr['page_questionstats_fillintheblank_others'] = 'Others (%d)';
$lngstr['page_editquestion_subjectid'] = 'Question subject:';
$lngstr['page_editquestion_type'] = 'Question type:';
$lngstr['page_editquestion_question_text'] = 'Question:';
$lngstr['page_editquestion_question_name'] = 'Question name:';
$lngstr['page_editquestion_answer_count'] = 'Number of answers:';
$lngstr['page_editquestion_answers'] = 'Answers:';
$lngstr['page_editquestion_time'] = 'Time:';
$lngstr['page_editquestion_points'] = 'Point value:';
$lngstr['page_editquestion']['shuffle_answers'] = 'Shuffle answers:';
$lngstr['page_editquestion']['shuffle_answers_items'] = array(0 => 'Default (inherit)', 1 => 'Do not shuffle', 2 => 'Shuffle', 3 => 'Shuffle (except the first one)', 4 => 'Shuffle (except the last one)');
$lngstr['page_editquestion']['advanced_settings'] = 'Advanced options:';
$lngstr['page_editquestion']['allow_partial_answers'] = 'Allow partially correct answers';
$lngstr['page_editquestion_emptyquestion'] = '<p><strong>Please enter your question here...</strong></p>';
// $lngstr['page_editquestion']['used_question'] = 'Note (grayed item): this question is already used in the test';

$lngstr['label_action_visitors_view'] = 'View this record details';
$lngstr['page_visitordetails_visitorid'] = 'Visitor ID:';
$lngstr['page_visitordetails_startdate'] = 'Start date:';
$lngstr['page_visitordetails_enddate'] = 'End date:';
$lngstr['page_visitordetails_timespent'] = 'Time spent:';
$lngstr['page_visitordetails_username'] = $lngstr['label_username'];
$lngstr['page_visitordetails_ipaddress'] = 'IP-address:';
$lngstr['page_visitordetails_host'] = 'Host:';
$lngstr['page_visitordetails_referer'] = 'Referrer:';
$lngstr['page_visitordetails_inurl'] = 'Entry page:';
$lngstr['page_visitordetails_outurl'] = 'Exit page:';
$lngstr['page_visitordetails_hits'] = 'Hits:';
$lngstr['page_visitordetails_useragent'] = 'User agent:';

$lngstr['page_config']['section_site'] = 'Web site (click to show/hide)';
$lngstr['page_config']['text_editor'] = 'WYSIWYG editor:';
$lngstr['page_config']['text_editorlist'] = array(CONFIG_CONST_iseditor2 => 'Default editor', CONFIG_CONST_iseditor => 'Default editor (old)', CONFIG_CONST_htmlareaeditor => 'HTMLArea editor');
$lngstr['page_config']['list_length'] = 'List length:';
$lngstr['page_config']['store_logs'] = 'Web statistics:';
$lngstr['page_config']['section_registration'] = 'Registration (click to show/hide)';
$lngstr['page_config']['can_register'] = 'Allow user registration:';
$lngstr['page_config']['upon_registration'] = 'Upon registration:';
$lngstr['page_config']['upon_registration_select'] = array(0 => 'Activate, do nothing', 1 => 'Activate, sign in automatically', 2 => 'Do not activate, send activation email to the user', 4 => 'Do not activate, send activation email to the administrator', 3 => 'Do not activate, use custom scheme (e.g. payment processing)');
$lngstr['page_config']['reg_intro'] = 'Introduction:';
$lngstr['page_config']['donotshow'] = 'Do not show';
$lngstr['page_config']['donotshow_autogenerate'] = 'Do not show, auto generate';
$lngstr['page_config']['show_donotrequire'] = 'Show, do not require';
$lngstr['page_config']['show_autogenerate'] = 'Show, auto generate';
$lngstr['page_config']['show_require'] = 'Show, require';

$lngstr['page_users']['username'] = $lngstr['label_username'];
$lngstr['page_users']['password'] = $lngstr['label_password'];
$lngstr['page_users']['email'] = $lngstr['label_email'];
$lngstr['page_users']['title'] = $lngstr['label_title'];
$lngstr['page_users']['firstname'] = $lngstr['label_firstname'];
$lngstr['page_users']['lastname'] = $lngstr['label_lastname'];
$lngstr['page_users']['middlename'] = $lngstr['label_middlename'];

$lngstr['page_users']['member_of'] = 'Member of:';

$lngstr['page_users']['address'] = $lngstr['label_address'];
$lngstr['page_users']['city'] = $lngstr['label_city'];
$lngstr['page_users']['state'] = $lngstr['label_state'];
$lngstr['page_users']['zip'] = $lngstr['label_zip'];
$lngstr['page_users']['country'] = $lngstr['label_country'];
$lngstr['page_users']['phone'] = $lngstr['label_phone'];
$lngstr['page_users']['fax'] = $lngstr['label_fax'];
$lngstr['page_users']['mobile'] = $lngstr['label_mobile'];
$lngstr['page_users']['pager'] = $lngstr['label_pager'];
$lngstr['page_users']['ipphone'] = $lngstr['label_ipphone'];
$lngstr['page_users']['webpage'] = $lngstr['label_webpage'];
$lngstr['page_users']['icq'] = $lngstr['label_icq'];
$lngstr['page_users']['msn'] = $lngstr['label_msn'];
$lngstr['page_users']['aol'] = $lngstr['label_aol'];
$lngstr['page_users']['gender'] = $lngstr['label_gender'];
$lngstr['page_users']['birthday'] = $lngstr['label_birthday'];
$lngstr['page_users']['husbandwife'] = $lngstr['label_husbandwife'];
$lngstr['page_users']['children'] = $lngstr['label_children'];
$lngstr['page_users']['trainer'] = $lngstr['label_trainer'];
$lngstr['page_users']['photo'] = $lngstr['label_photo'];

$lngstr['page_users']['company'] = $lngstr['label_company'];
$lngstr['page_users']['cposition'] = $lngstr['label_cposition'];
$lngstr['page_users']['department'] = $lngstr['label_department'];
$lngstr['page_users']['coffice'] = $lngstr['label_coffice'];
$lngstr['page_users']['caddress'] = $lngstr['label_caddress'];
$lngstr['page_users']['ccity'] = $lngstr['label_ccity'];
$lngstr['page_users']['cstate'] = $lngstr['label_cstate'];
$lngstr['page_users']['czip'] = $lngstr['label_czip'];
$lngstr['page_users']['ccountry'] = $lngstr['label_ccountry'];
$lngstr['page_users']['cphone'] = $lngstr['label_cphone'];
$lngstr['page_users']['cfax'] = $lngstr['label_cfax'];
$lngstr['page_users']['cmobile'] = $lngstr['label_cmobile'];
$lngstr['page_users']['cpager'] = $lngstr['label_cpager'];
$lngstr['page_users']['cipphone'] = $lngstr['label_cipphone'];
$lngstr['page_users']['cwebpage'] = $lngstr['label_cwebpage'];
$lngstr['page_users']['cphoto'] = $lngstr['label_cphoto'];

$lngstr['page_users']['section_groups'] = 'Groups (click to show/hide)';
$lngstr['page_users']['section_personal'] = 'Personal information (click to show/hide)';
$lngstr['page_users']['section_work'] = 'Work information (click to show/hide)';
$lngstr['page_users']['section_additional'] = 'Additional information (click to show/hide)';

$lngstr['page_users']['userenabled'] = 'This user is active';
$lngstr['page_users']['joindate'] = 'Join date:';
$lngstr['page_users']['logindate'] = 'Last sign in date:';
$lngstr['page_users']['expiredate'] = 'Expire date:';
$lngstr['page_users']['password_confirm'] = $lngstr['label_confirmpassword'];
$lngstr['page_users']['password_new'] = $lngstr['label_newpassword'];
$lngstr['page_users']['section_notes'] = 'Notes (click to show/hide)';
$lngstr['page_users']['notes'] = 'User notes (for internal use):';

$lngstr['page_reportsmanager']['answerfeedback'] = 'Feedback:';
$lngstr['page_reportsmanager']['view_pdf'] = 'View printable PDF report';
$lngstr['page_reportsmanager']['view_html'] = 'View HTML report';
$lngstr['page_reportsmanager']['view_none'] = 'No report is available';

$lngstr['page_managegroups_groupid'] = 'Group ID:';
$lngstr['page_managegroups_groupname'] = 'Group name:';
$lngstr['page_managegroups_groupdescription'] = 'Group description:';
$lngstr['page_groups_access_rights'] = 'Access rights:';
$lngstr['page_groups_access_tests'] = 'Tests:';
$lngstr['page_groups_access_tests_select'] = array(0 => 'Access denied', 1 => 'View test list', 2 => 'Take');
$lngstr['page_groups_access_testmanager'] = 'Test manager:';
$lngstr['page_groups_access_testmanager_select'] = array(0 => 'Access denied', 1 => 'Read', 2 => 'Write');
$lngstr['page_groups_access_gradingsystems'] = 'Grading systems:';
$lngstr['page_groups_access_gradingsystems_select'] = $lngstr['page_groups_access_testmanager_select'];
$lngstr['page_groups_access_emailtemplates'] = 'Email templates:';
$lngstr['page_groups_access_emailtemplates_select'] = $lngstr['page_groups_access_testmanager_select'];
$lngstr['page_groups_access_reporttemplates'] = 'Report templates:';
$lngstr['page_groups_access_reporttemplates_select'] = $lngstr['page_groups_access_testmanager_select'];
$lngstr['page_groups_access_reportsmanager'] = 'Reports manager:';
$lngstr['page_groups_access_reportsmanager_select'] = array(0 => 'Access denied', 1 => 'Read (own results)', 2 => 'Read (all results)', 3 => 'Write');
$lngstr['page_groups_access_questionbank'] = 'Question bank:';
$lngstr['page_groups_access_questionbank_select'] = $lngstr['page_groups_access_testmanager_select'];
$lngstr['page_groups_access_subjects'] = 'Subjects:';
$lngstr['page_groups_access_subjects_select'] = $lngstr['page_groups_access_testmanager_select'];
$lngstr['page_groups_access_groups'] = 'Groups:';
$lngstr['page_groups_access_groups_select'] = $lngstr['page_groups_access_testmanager_select'];
$lngstr['page_groups_access_users'] = 'Users:';
$lngstr['page_groups_access_users_select'] = array(0 => 'Access denied', 1 => 'Read (own account)', 2 => 'Read (all accounts)', 3 => 'Write (own account)', 4 => 'Write (all accounts)');
$lngstr['page_groups_access_visitors'] = 'Web statistics:';
$lngstr['page_groups_access_visitors_select'] = $lngstr['page_groups_access_testmanager_select'];
$lngstr['page_groups_access_config'] = 'Configuration:';
$lngstr['page_groups_access_config_select'] = $lngstr['page_groups_access_testmanager_select'];

$lngstr['page_etemplates_etemplateid'] = 'Template ID:';
$lngstr['page_etemplates_etemplatename'] = 'Template name:';
$lngstr['page_etemplates_etemplatedescription'] = 'Template description:';
$lngstr['page_etemplates_etemplatefrom'] = 'From (email):';
$lngstr['page_etemplates_etemplatesubject'] = 'Email subject:';
$lngstr['page_etemplates_etemplatebody'] = 'Email body:';
$lngstr['page_etemplates_template_tags'] = 'Template tags';

$lngstr['page-rtemplates']['rtemplateid'] = 'Template ID:';
$lngstr['page-rtemplates']['rtemplatename'] = 'Template name:';
$lngstr['page-rtemplates']['rtemplatedescription'] = 'Template description:';
$lngstr['page-rtemplates']['rtemplatebody'] = 'Report body:';

$lngstr['page_resourcemanager']['hdr_resourceid'] = 'ID';
$lngstr['page_resourcemanager']['hdr_resourceid_hint'] = 'Resource ID (click to sort by)';
$lngstr['page_resourcemanager']['hdr_resource_name'] = 'Resource Name';
$lngstr['page_resourcemanager']['hdr_resource_name_hint'] = 'Resource name (click to sort by)';
$lngstr['page_resourcemanager']['hdr_resource_description'] = 'Description';
$lngstr['page_resourcemanager']['hdr_resource_description_hint'] = 'Resource description (click to sort by)';
$lngstr['page_resourcemanager']['action_create_resource'] = 'Create a new resource';
$lngstr['page_resourcemanager']['action_edit_resource'] = 'Resource settings';
$lngstr['page_resourcemanager']['qst_delete_resource'] = 'Are you sure want to delete this resource?';
$lngstr['page_resourcemanager']['qst_delete_resources'] = 'Are you sure want to delete selected resources?';
$lngstr['page_resourcemanager']['action_delete_resource'] = 'Delete this resource';
$lngstr['page_resourcemanager']['action_delete_resources'] = 'Delete resources (for selected records)';
$lngstr['page_resourcemanager']['delete_resource'] = 'Delete a Resource';
$lngstr['inf_cant_access_resourcemanager'] = 'You have not enough rights to access resources.<br>';
$lngstr['page_resourcemanager_settings']['is_active'] = 'This resource is active';
$lngstr['page_resourcemanager_settings']['resourceid'] = 'Resource ID:';
$lngstr['page_resourcemanager_settings']['resource_name'] = 'Resource name:';
$lngstr['page_resourcemanager_settings']['resource_description'] = 'Resource description:';
$lngstr['page_resourcemanager_settings']['start_date'] = 'Start date:';
$lngstr['page_resourcemanager_settings']['end_date'] = 'End date:';
$lngstr['page_resourcemanager_settings']['resource_url'] = 'Resource URL:';
$lngstr['page_resourcemanager_settings']['related_to'] = 'Related to (test name):';
$lngstr['page_resourcemanager_settings']['assigned_to'] = $lngstr['page_edittests_assignedto'];
$lngstr['page_resourcemanager_settings']['assign_to_everybody'] = $lngstr['page_edittests_assignto_everybody'];

$lngstr['page_resources']['hdr_resource'] = 'Resource';
$lngstr['page_resources']['hdr_resource_hint'] = 'Resource name and description';
$lngstr['page_resources']['hdr_get_resource'] = 'Get Resource';
$lngstr['page_resources']['hdr_get_resource_hint'] = 'Get resource';
$lngstr['page_resources']['get_resource_link'] = 'Resource';

$lngstr['page_couponmanager']['hdr_couponid'] = 'ID';
$lngstr['page_couponmanager']['hdr_couponid_hint'] = 'Coupon ID (click to sort by)';
$lngstr['page_couponmanager']['hdr_coupon_name'] = 'Coupon Name';
$lngstr['page_couponmanager']['hdr_coupon_name_hint'] = 'Coupon name (click to sort by)';
$lngstr['page_couponmanager']['hdr_coupon_description'] = 'Description';
$lngstr['page_couponmanager']['hdr_coupon_description_hint'] = 'Coupon description (click to sort by)';
$lngstr['page_couponmanager']['hdr_coupon_code'] = 'Code';
$lngstr['page_couponmanager']['hdr_coupon_code_hint'] = 'Coupon code (click to sort by)';
$lngstr['page_couponmanager']['hdr_coupon_enabled'] = 'Active';
$lngstr['page_couponmanager']['hdr_coupon_enabled_hint'] = 'Active (click to sort by)';
$lngstr['page_couponmanager']['action_create_coupon'] = 'Create a new coupon';
$lngstr['page_couponmanager']['action_edit_coupon'] = 'Coupon settings';
$lngstr['page_couponmanager']['qst_delete_coupon'] = 'Are you sure want to delete this coupon?';
$lngstr['page_couponmanager']['qst_delete_coupons'] = 'Are you sure want to delete selected coupons?';
$lngstr['page_couponmanager']['action_delete_coupon'] = 'Delete this coupon';
$lngstr['page_couponmanager']['action_delete_coupons'] = 'Delete coupons (for selected records)';
$lngstr['page_couponmanager']['delete_coupon'] = 'Delete a Coupon';
$lngstr['inf_cant_access_couponmanager'] = 'You have not enough rights to access coupons.<br>';
$lngstr['page_couponmanager_settings']['is_active'] = 'This coupon is active';
$lngstr['page_couponmanager_settings']['couponid'] = 'Coupon ID:';
$lngstr['page_couponmanager_settings']['coupon_name'] = 'Coupon name:';
$lngstr['page_couponmanager_settings']['coupon_description'] = 'Coupon description:';
$lngstr['page_couponmanager_settings']['coupon_code'] = 'Coupon code:';
$lngstr['page_couponmanager_settings']['coupon_value'] = 'Coupon value ('.$lngstr['language']['currency_name'].'):';

$lngstr['page_buycheckout']['hdr_test'] = $lngstr['page_panel_hdr_test'];
$lngstr['page_buycheckout']['hdr_test_hint'] = $lngstr['page_panel_hdr_test_hint'];
$lngstr['page_buycheckout']['hdr_test_price'] = 'Price';
$lngstr['page_buycheckout']['hdr_test_price_hint'] = 'Test price';
$lngstr['page_buycheckout']['hdr_test_buy'] = 'Buy';
$lngstr['page_buycheckout']['hdr_test_buy_hint'] = 'Buy a test';
$lngstr['page_buycheckout']['err_no_coupon'] = 'Please check your coupon code and re-enter it.<br />';
$lngstr['page_buycheckout']['err_no_handler'] = 'No payment processing handler is assigned.<br />';

$lngstr['page_buystate']['success'] = 'Thank you for your order.<br>';
$lngstr['page_buystate']['fail'] = 'There is a problem processing your order.<br>';

$lngstr['email_answer_iscorrect'] = 'Correct: ';
$lngstr['email_answer_points'] = 'Score: ';

$lngstr['err_subject_doesnotexist'] = 'This subject does not exist.<br>';

$lngstr['err_no_questions'] = 'No questions found in the test.<br>';
$lngstr['err_no_questions_left_in_bank'] = 'The number of random questions required is more than this subject contains.<br>';
$lngstr['err_no_tests'] = 'There are currently no tests available to be taken.<br>';
$lngstr['err_no_resources'] = 'There are currently no resources available.<br>';
$lngstr['inf_cant_passtest'] = 'You have not enough rights to take this test.<br>';
$lngstr['inf_cant_view_results'] = 'You have not enough rights to view test results.<br>';
$lngstr['inf_cant_view_reportsmanager_reportsratings'] = 'You have not enough rights to view the ratings page.<br>';
$lngstr['inf_cant_view_this_test_details'] = 'You have not enough rights to view this test results.<br>';
$lngstr['inf_cant_edit_tests'] = 'You have not enough rights to edit tests.<br>';
$lngstr['inf_cant_edit_questions'] = 'You have not enough rights to edit questions.<br>';
$lngstr['inf_cant_access_groups'] = 'You have not enough rights to access groups.<br>';
$lngstr['inf_cant_access_users'] = 'You have not enough rights to access users.<br>';
$lngstr['inf_cant_access_subjects'] = 'You have not enough rights to access subjects.<br>';
$lngstr['inf_cant_access_emailtemplates'] = 'You have not enough rights to access email templates.<br>';
$lngstr['inf_cant_access_reporttemplates'] = 'You have not enough rights to access report templates.<br>';
$lngstr['inf_cant_access_grades'] = 'You have not enough rights to access grading systems.<br>';
$lngstr['inf_cant_access_visitors'] = 'You have not enough rights to access the web statistics section.<br>';
$lngstr['inf_cant_access_config'] = 'You have not enough rights to access the configuration section.<br>';
$lngstr['err_no_test_selected'] = 'Please select a test first.<br>';
$lngstr['err_no_question_n_in_db'] = 'Question %d cannot be found.<br>';
$lngstr['err_no_question_id_in_db'] = 'Question ID %d cannot be found.<br>';
$lngstr['err_no_answers_in_question'] = '<b><a href="question-bank.php?action=editq&questionid=%1$d">Question ID %1$d</a></b> has no answers. Please fix it.<br>';
$lngstr['err_no_answer_given'] = 'No answer is given.<br>';
$lngstr['err_answer_every_question'] = 'Please answer every question.<br>';

$lngstr['err_no_permissions_to_register'] = 'You have no permissions to register a new user';

$lngstr['qst_delete_test'] = 'Are you sure want to delete this test?';
$lngstr['qst_delete_tests'] = 'Are you sure want to delete selected tests?';
$lngstr['qst_delete_question'] = 'Are you sure want to delete this question?';
$lngstr['qst_delete_questions'] = 'Are you sure want to delete selected questions?';
$lngstr['qst_delete_question_link'] = 'Are you sure want to remove this question from the test?';
$lngstr['qst_delete_question_links'] = 'Are you sure want to remove selected questions from the test?';
$lngstr['qst_delete_record'] = 'Are you sure want to delete this record?';
$lngstr['qst_delete_records'] = 'Are you sure want to delete selected records?';
$lngstr['qst_delete_user'] = 'Are you sure want to delete this user?';
$lngstr['qst_delete_users'] = 'Are you sure want to delete selected users?';
$lngstr['qst_delete_group'] = 'Are you sure want to delete this group?';
$lngstr['qst_delete_groups'] = 'Are you sure want to delete selected groups?';
$lngstr['qst_delete_subject'] = 'Are you sure want to delete this subject?';
$lngstr['qst_delete_subjects'] = 'Are you sure want to delete selected subjects?';
$lngstr['qst_delete_etemplate'] = 'Are you sure want to delete this email template?';
$lngstr['qst_delete_etemplates'] = 'Are you sure want to delete selected email templates?';
$lngstr['qst_delete_grade'] = 'Are you sure want to delete this grading system?';
$lngstr['qst_delete_grades'] = 'Are you sure want to delete selected grading systems?';
$lngstr['qst_delete_gradescale'] = 'Are you sure want to delete this grade?';
$lngstr['qst_delete_gradescales'] = 'Are you sure want to delete selected grades?';
$lngstr['qst_delete_visitor'] = $lngstr['qst_delete_record'];
$lngstr['qst_delete_visitors'] = $lngstr['qst_delete_records'];
$lngstr['page-sections']['qst_section_delete'] = 'Are you sure want to delete this section?';
$lngstr['page-sections']['qst_sections_delete'] = 'Are you sure want to delete selected sections?';
$lngstr['page-rtemplates']['qst_rtemplate_delete'] = 'Are you sure want to delete this report template?';
$lngstr['page-rtemplates']['qst_rtemplates_delete'] = 'Are you sure want to delete selected report templates?';

// Install:
$lngstr['install_title'] = 'Install - iGiveTest';
$lngstr['install_page1'] = 'Step 1 - Language Settings';
$lngstr['install_page1_description'] = '<p><b>Language:</b> Please choose a language.';
$lngstr['install_language'] = 'Language:';
$lngstr['install_page2'] = 'Step 2 - General Settings';
$lngstr['install_page2_description'] = '<p><b>Web site title:</b> Please specify the web site title.
<p><b>Default email:</b> Please specify the default "From" address for email messages.
<p><b>License key:</b> Please specify your iGiveTest license key.
<p><b>iGiveTest URL:</b> Please specify the web address where iGiveTest will be accessed.
<p><b>iGiveTest directory:</b> Please specify the full directory path to this installation.
<p><b>iGiveTest files URL:</b> Please specify the web address where uploaded files will be accessed.
<p><b>iGiveTest files directory:</b> Please specify a full directory path where iGiveTest can save uploaded files. This directory should be readable and writeable by the web server user (usually "nobody" or "apache").';
$lngstr['install_titlepostfix'] = 'Web site title:';
$lngstr['install_defaultemail'] = 'Default email:';
$lngstr['install_urlroot'] = 'iGiveTest URL:';
$lngstr['install_dirrootfull'] = 'iGiveTest directory:';
$lngstr['install_dirrootfull_doesnotexists'] = 'The "iGiveTest directory" setting seems to be incorrect. The value below has been reset.<br>';
$lngstr['install_urlfiles'] = 'iGiveTest files URL:';
$lngstr['install_dirfilesfull'] = 'iGiveTest files directory:';
$lngstr['install_page3'] = 'Step 3 - Database Settings';
$lngstr['install_page3_description'] = '<p>Please configure the database where iGiveTest data will be stored. This database must already have been created and a username and password created to access it.';
$lngstr['install_dbdriver'] = 'Database type:';
$lngstr['install_dbhost'] = 'Database host:';
$lngstr['install_dbdb'] = 'Database name:';
$lngstr['install_dbtableprefix'] = 'Tables prefix:';
$lngstr['install_dbuser'] = 'Database user:';
$lngstr['install_dbpassword'] = 'Database password:';
$lngstr['install']['license_key'] = 'License key:';
$lngstr['install_dbdriver_cannotconnect'] = 'Could not connect to the database you specified. Please check your database settings.<br>';
$lngstr['install_cannotwritetoconfig'] = 'Could not write to inc/config.inc.php';
$lngstr['install_downloadconfig'] = '<p>Please save <b><a href="install.php?download=1" target=_blank>this file</a></b>, name it config.inc.php and put it in you inc/ directory.';
$lngstr['install_canwritetoconfig'] = '<p>The config.inc.php file has been successfully created.';
$lngstr['install_page4'] = 'Installation Completed';
$lngstr['install_page4_description'] = '<p>Please press "Next" button to set up iGiveTest database.';
$lngstr['install_db_title'] = 'Initialize Database - iGiveTest';
$lngstr['install_db_page1'] = 'Initialize iGiveTest Database';
$lngstr['install_db_createtablex'] = 'Create "%s" table:';
$lngstr['install_db']['create_or_modify_tablex'] = 'Create or modify the "%s" table:';
$lngstr['install_db']['no_init_needed'] = 'No initialization needed.';

$lngstr['install_adminfirstname'] = 'Admin';
$lngstr['install_adminlastname'] = 'User';
$lngstr['install_guestfirstname'] = 'Guest';
$lngstr['install_guestlastname'] = 'User';

$lngstr['install_phpversion'] = 'PHP Version:';
$lngstr['label_okay'] = 'OK';
$lngstr['label_warning'] = 'Warning';

$m_db_drivers = array(
	DB_DRIVER_MYSQL => 'MySQL',
	DB_DRIVER_POSTGRESQL => 'PostgreSQL',
	DB_DRIVER_MSSQL_ODBC => 'Microsoft SQL Server (ODBC)',
	DB_DRIVER_MSSQL => 'Microsoft SQL Server (PHP driver)',
	DB_DRIVER_ORACLE => 'Oracle',
	);

$lngstr['initdb_etemplates_1_name'] = 'Test Results (Default)';
$lngstr['initdb_etemplates_1_description'] = 'Test results email template (default)';
$lngstr['initdb_etemplates_1_subject'] = 'iGiveTest - Sample Report';
$lngstr['initdb_etemplates_1_body'] = 'Dear [USER_FIRST_NAME],

Here are the results from your test:

Test name: [TEST_NAME]
Date: [RESULT_DATE]
Time spent: [RESULT_TIME_SPENT]
Time exceeded: [RESULT_TIME_EXCEEDED]

[RESULT_DETAILED_1]

Total score: [RESULT_POINTS_SCORED] / [RESULT_POINTS_POSSIBLE] ([RESULT_PERCENTS]%)
Grade: [RESULT_GRADE]

Regards,
iGiveTest Team';

$lngstr['initdb_etemplates_2_name'] = 'Account Sign Up';
$lngstr['initdb_etemplates_2_description'] = 'Account sign up email template';
$lngstr['initdb_etemplates_2_subject'] = 'iGiveTest.com - Registration Details';
$lngstr['initdb_etemplates_2_body'] = 'Dear [USER_FIRST_NAME],

Thank you for registering with iGiveTest.

Username: [USERNAME]
Password: [USER_PASSWORD]

You can sign in to your account any time by visiting:

[IGIVETEST_URL]

Regards,
iGiveTest Team';

$lngstr['initdb_etemplates_3_name'] = 'Account Sign Up (Email Activation)';
$lngstr['initdb_etemplates_3_description'] = 'Account sign up email template';
$lngstr['initdb_etemplates_3_subject'] = 'iGiveTest.com - Account Activation';
$lngstr['initdb_etemplates_3_body'] = 'Dear [USER_FIRST_NAME],

Thank you for registering with iGiveTest.

Username: [USERNAME]
Password: [USER_PASSWORD]

Just one more step to go:

To complete your account activation, please click on the following link:

[IGIVETEST_URL]/account.php?action=activate&userid=[USER_ID]&checkword=[USER_CHECKWORD]

Regards,
iGiveTest Team';

$lngstr['initdb_etemplates_4_name'] = 'Account Activated';
$lngstr['initdb_etemplates_4_description'] = 'Account activated email template';
$lngstr['initdb_etemplates_4_subject'] = 'iGiveTest.com - Account Activated';
$lngstr['initdb_etemplates_4_body'] = 'Dear [USER_FIRST_NAME],

Your account has been successfully activated.

You can sign in to your account any time by visiting:

[IGIVETEST_URL]

Regards,
iGiveTest Team';

$lngstr['initdb_etemplates_5_name'] = 'Account Sign Up (For Administrator)';
$lngstr['initdb_etemplates_5_description'] = 'Account sign up email template';
$lngstr['initdb_etemplates_5_subject'] = 'iGiveTest.com - New User Registration Details';
$lngstr['initdb_etemplates_5_body'] = 'Dear Administrator,

New user registration details:

First name: [USER_FIRST_NAME]
Last name: [USER_LAST_NAME]
Email: [USER_EMAIL]
Username: [USERNAME]
Password: [USER_PASSWORD]

Regards,
iGiveTest Team';

$lngstr['initdb_etemplates_50_name'] = 'Password Recovery';
$lngstr['initdb_etemplates_50_description'] = 'Password recovery email template';
$lngstr['initdb_etemplates_50_subject'] = 'iGiveTest - Password Recovery';
$lngstr['initdb_etemplates_50_body'] = 'Dear [USER_FIRST_NAME],

We have reset your password.

Username: [USERNAME]
New password: [USER_PASSWORD]

Regards,
iGiveTest Team';

$lngstr['initdb_gscales_1_id'] = 1;
$lngstr['initdb_gscales_2_id'] = 2;
$lngstr['initdb_gscales_3_id'] = 3;
$lngstr['initdb_gscales_4_id'] = 4;
$lngstr['initdb_gscales_5_id'] = 5;
$lngstr['initdb_gscales_6_id'] = 6;
$lngstr['initdb_gscales_1_name'] = 'A-F Grading Scale (60% passing-grade)';
$lngstr['initdb_gscales_2_name'] = 'Passed/Not Passed Grading Scale';
$lngstr['initdb_gscales_3_name'] = 'ECTS Grading Scale';
$lngstr['initdb_gscales_4_name'] = 'GPA Grading Scale';
$lngstr['initdb_gscales_5_name'] = '6-Point Grading Scale (Germany)';
$lngstr['initdb_gscales_6_name'] = '5-Point Grading Scale (Central and Eastern Europe)';
$lngstr['initdb_gscales_1_description'] = 'A-F grading scale';
$lngstr['initdb_gscales_2_description'] = 'Passed/not passed grading scale';
$lngstr['initdb_gscales_3_description'] = 'ECTS (European Credit Transfer System) grading scale';
$lngstr['initdb_gscales_4_description'] = 'GPA (Grade Point Average) grading scale';
$lngstr['initdb_gscales_5_description'] = '6-point grading scale in Germany';
$lngstr['initdb_gscales_6_description'] = '5-point grading scale in Central and Eastern Europe';
$lngstr['initdb_gscales_1_1_description'] = 'Excellent';
$lngstr['initdb_gscales_1_2_description'] = 'Good';
$lngstr['initdb_gscales_1_3_description'] = 'Fair';
$lngstr['initdb_gscales_1_4_description'] = 'Poor';
$lngstr['initdb_gscales_1_5_description'] = 'Fail';
$lngstr['initdb_gscales_2_1_name'] = 'Passed';
$lngstr['initdb_gscales_2_2_name'] = 'Not Passed';
$lngstr['initdb_gscales_2_1_description'] = 'Passed';
$lngstr['initdb_gscales_2_2_description'] = 'Not passed';
$lngstr['initdb_gscales_3_1_description'] = 'Excellent (outstanding performance with only minor errors)';
$lngstr['initdb_gscales_3_2_description'] = 'Very good (above the average standard but with some errors)';
$lngstr['initdb_gscales_3_3_description'] = 'Good (generally sound work with a number of notable errors)';
$lngstr['initdb_gscales_3_4_description'] = 'Satisfactory (fair but with significant shortcomings)';
$lngstr['initdb_gscales_3_5_description'] = 'Sufficient (performance meets the minimum criteria)';
$lngstr['initdb_gscales_3_6_description'] = 'Fail (some more work required before the credit can be awarded)';
$lngstr['initdb_gscales_3_7_description'] = 'Fail (considerable further work is required)';
$lngstr['initdb_gscales_4_1_description'] = 'Excellent';
$lngstr['initdb_gscales_4_2_description'] = 'Good';
$lngstr['initdb_gscales_4_3_description'] = 'Fair';
$lngstr['initdb_gscales_4_4_description'] = 'Poor';
$lngstr['initdb_gscales_4_5_description'] = 'Fail';
$lngstr['initdb_gscales_5_1_description'] = 'Excellent';
$lngstr['initdb_gscales_5_2_description'] = 'Good';
$lngstr['initdb_gscales_5_3_description'] = 'Satisfactory';
$lngstr['initdb_gscales_5_4_description'] = 'Sufficient';
$lngstr['initdb_gscales_5_5_description'] = 'Unsatisfactory';
$lngstr['initdb_gscales_5_6_description'] = 'Poor';
$lngstr['initdb_gscales_6_1_description'] = 'Excellent';
$lngstr['initdb_gscales_6_2_description'] = 'Good';
$lngstr['initdb_gscales_6_3_description'] = 'Satisfactory';
$lngstr['initdb_gscales_6_4_description'] = 'Unsatisfactory';
$lngstr['initdb_gscales_6_5_description'] = 'Poor';
$lngstr['initdb_groups_1_name'] = 'Administrators';
$lngstr['initdb_groups_2_name'] = 'Instructors';
$lngstr['initdb_groups_3_name'] = 'Operators';
$lngstr['initdb_groups_19_name'] = 'Users';
$lngstr['initdb_groups_20_name'] = 'Guests';
$lngstr['initdb_groups_1_description'] = 'Administrators have complete and unrestricted access (system group)';
$lngstr['initdb_groups_2_description'] = 'Instructors possess most administrative powers with some restrictions (system group)';
$lngstr['initdb_groups_3_description'] = 'Members in this group are granted the right to create / edit questions (system group)';
$lngstr['initdb_groups_19_description'] = 'Users are prevented from making any accidental or intentional changes (system group)';
$lngstr['initdb_groups_20_description'] = 'Guests have the same access as members of the Users group by default (system group)';
$lngstr['initdb_rtemplates_1_name'] = 'Report Template #1';
$lngstr['initdb_rtemplates_1_description'] = 'Report template #1';
$lngstr['initdb_rtemplates_1_body'] = '<h1>[TEST_NAME]</h1>
<p><strong>Date:</strong> [RESULT_DATE]</p>
<p><strong>Last name:</strong> [USER_LAST_NAME]<br>
<strong>First name:</strong> [USER_FIRST_NAME]<br>
<strong>Time spent:</strong> [RESULT_TIME_SPENT]<br>
<strong>Score:</strong> [RESULT_POINTS_SCORED] / [RESULT_POINTS_POSSIBLE] ([RESULT_PERCENTS]%)<br>
<strong>Grade:</strong> [RESULT_GRADE]</p>
<p><strong>Details:</strong><br>[RESULT_DETAILED_1]</p>';
$lngstr['initdb_subjects_1_name'] = '[No subject]';
$lngstr['initdb_subjects_1_description'] = 'No subject';
$lngstr['initdb_users_1_firstname'] = 'Admin';
$lngstr['initdb_users_2_firstname'] = 'Guest';
$lngstr['initdb_users_1_lastname'] = 'User';
$lngstr['initdb_users_2_lastname'] = 'User';
$lngstr['initdb_instructions'] = 'Please use username "<strong>admin</strong>" and password "<strong>admin</strong>" to sign in.<br><strong>Please remember:</strong> it is strongly recommended to change your password.';
$lngstr['initdb_gotohomepage'] = 'Go to home page';

// Tooltips:
$lngstr['tooltip_button'] = 'Show/hide hints bar';
$lngstr['help_button'] = 'Help';
$lngstr['tooltip_showbar'] = 'Show hints bar';
$lngstr['tooltip_closebar'] = 'Hide hints bar';
$lngstr['tooltip_tests'] = '<p>This page is designed for creating and editing tests.</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-new.gif" title="'.$lngstr['label_action_create_test'].'"></td><td class=rowone width="100%" colspan=4>To create a new test, press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-gear.gif" title="'.$lngstr['label_action_test_settings'].'"></td><td class=rowone width="100%" colspan=4>To change test settings, press this button to the right of the applicable test.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-groups.gif" title="'.$lngstr['label_action_test_groups_select'].'"></td><td class=rowone width="100%" colspan=4>To assign test(s) to certain groups of users, press a button to the right of the test or select all necessary tests using the flag marks on the left and press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-edit.gif" title="'.$lngstr['label_action_questions_edit'].'"></td><td class=rowone width="100%" colspan=4>To edit test questions, press a button to the right of the test.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['label_action_test_delete'].'"></td><td class=rowone width="100%" colspan=4>To delete test(s), press a button to the right of the test or select all necessary tests using the flag marks on the left and press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Use these buttons to transfer between pages.</td></tr>
</table></p>';
$lngstr['tooltip_gscales'] = '<p>This page is designed for creating and editing grading systems.</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-new.gif" title="'.$lngstr['label_action_create_grade'].'"></td><td class=rowone width="100%" colspan=4>To create a new grading system, press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-gear.gif" title="'.$lngstr['label_action_grade_settings'].'"></td><td class=rowone width="100%" colspan=4>To change grading system settings, press this button to the right of the applicable grading system.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-edit.gif" title="'.$lngstr['label_action_gradescales_edit'].'"></td><td class=rowone width="100%" colspan=4>To edit a grading system, press a button to the right of the grading system.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['label_action_grade_delete'].'"></td><td class=rowone width="100%" colspan=4>To delete grading system(s), press a button to the right of the grading system or select all necessary grading systems using the flag marks on the left and press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Use these buttons to transfer between pages.</td></tr>
</table></p>';
$lngstr['tooltip_gscales_grades'] = '<p>This page is designed for creating and editing grading scales.</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-new.gif" title="'.$lngstr['label_action_create_gradescale'].'"></td><td class=rowone width="100%" colspan=4>To create a new grade, press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-edit.gif" title="'.$lngstr['label_action_gradescale_edit'].'"></td><td class=rowone width="100%" colspan=4>To edit a grade, press a button to the right of the grade.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=10 border=0 src="images/button-up.gif" title="'.$lngstr['label_action_grade_moveup'].'"><br><img width=20 height=10 border=0 src="images/button-down.gif" title="'.$lngstr['label_action_grade_movedown'].'"></td><td class=rowone width="100%" colspan=4>To move a grade up (down) the list, press the top (bottom) part of the button to the right of the grade.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['label_action_gradescale_delete'].'"></td><td class=rowone width="100%" colspan=4>To delete grade(s), press a button to the right of the grade or select all necessary grades using the flag marks on the left and press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Use these buttons to transfer between pages.</td></tr>
</table></p>';
$lngstr['tooltip_etemplates'] = '<p>This page is designed for creating and editing email templates.</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-new.gif" title="'.$lngstr['label_action_create_etemplate'].'"></td><td class=rowone width="100%" colspan=4>To create a new email template, press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-edit.gif" title="'.$lngstr['label_action_etemplates_edit'].'"></td><td class=rowone width="100%" colspan=4>To edit an email template, press a button to the right of the email template.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['label_action_etemplate_delete'].'"></td><td class=rowone width="100%" colspan=4>To delete email template(s), press a button to the right of the email template or select all necessary email templates using the flag marks on the left and press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Use these buttons to transfer between pages.</td></tr>
</table></p>';
$lngstr['tooltip_rtemplates'] = '<p>This page is designed for creating and editing report templates.</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-new.gif" title="'.$lngstr['page-rtemplates']['action_create_rtemplate'].'"></td><td class=rowone width="100%" colspan=4>To create a new report template, press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-edit.gif" title="'.$lngstr['page-rtemplates']['action_rtemplates_edit'].'"></td><td class=rowone width="100%" colspan=4>To edit a report template, press a button to the right of the report template.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['page-rtemplates']['action_rtemplate_delete'].'"></td><td class=rowone width="100%" colspan=4>To delete report template(s), press a button to the right of the report template or select all necessary report templates using the flag marks on the left and press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Use these buttons to transfer between pages.</td></tr>
</table></p>';
$lngstr['tooltip_tests_questions'] = '<p>This page is designed for creating and editing test questions.</p>
<p>Test questions table:</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-add.gif" title="'.$lngstr['label_action_create_and_add_question'].'"></td><td class=rowone width="100%" colspan=4>To create a new question and to add it to a test, press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-import.gif" title="'.$lngstr['label_action_import_questions'].'"></td><td class=rowone width="100%" colspan=4>To import questions into a test, press the following button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-edit.gif" title="'.$lngstr['label_action_questions_edit'].'"></td><td class=rowone width="100%" colspan=4>To edit a question, press a button to the right of the question.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=10 border=0 src="images/button-up.gif" title="'.$lngstr['label_action_question_moveup'].'"><br><img width=20 height=10 border=0 src="images/button-down.gif" title="'.$lngstr['label_action_grade_movedown'].'"></td><td class=rowone width="100%" colspan=4>To move a question up (down) the list, press the top (bottom) part of the button to the right of the question.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['label_action_question_link_delete'].'"></td><td class=rowone width="100%" colspan=4>To delete question(s), press a button to the right of the question or select all necessary questions using the flag marks on the left and press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Use these buttons to transfer between pages.</td></tr>
</table></p>
<p>Question bank table:</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-new.gif" title="'.$lngstr['label_action_create_question'].'"></td><td class=rowone width="100%" colspan=4>To create a new question, press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-plus.gif" title="'.$lngstr['label_action_questions_append'].'"></td><td class=rowone width="100%" colspan=4>To add a question to a test, press the button to the right of the question or select all necessary questions using the flag marks on the left and press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-edit.gif" title="'.$lngstr['label_action_question_edit'].'"></td><td class=rowone width="100%" colspan=4>To edit a question, press a button to the right of the question.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['label_action_question_delete'].'"></td><td class=rowone width="100%" colspan=4>To delete question(s), press a button to the right of the question or select all necessary questions using the flag marks on the left and press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Use these buttons to transfer between pages.</td></tr>
</table></p>';
$lngstr['tooltip_tests_sections'] = '<p>This page is designed for creating and editing test sections.</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-new.gif" title="'.$lngstr['page-sections']['action_section_create'].'"></td><td class=rowone width="100%" colspan=4>To create a new section, press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-edit.gif" title="'.$lngstr['page-sections']['action_section_edit'].'"></td><td class=rowone width="100%" colspan=4>To edit a section, press a button to the right of the section.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['page-sections']['action_section_delete'].'"></td><td class=rowone width="100%" colspan=4>To delete section(s), press a button to the right of the section or select all necessary sections using the flag marks on the left and press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Use these buttons to transfer between pages.</td></tr>
</table></p>';
$lngstr['tooltip_tests_groups'] = '<p>This page is designed for assigning tests to certain groups of users.</p>
<p>Tests table:</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-new.gif" title="'.$lngstr['label_action_create_test'].'"></td><td class=rowone width="100%" colspan=4>To create a new test, press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-gear.gif" title="'.$lngstr['label_action_test_settings'].'"></td><td class=rowone width="100%" colspan=4>To change test settings, press this button to the right of the applicable test.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-groups.gif" title="'.$lngstr['label_action_test_groups_select'].'"></td><td class=rowone width="100%" colspan=4>To assign test(s) to certain groups of users, press a button to the right of the test or select all necessary tests using the flag marks on the left and press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-edit.gif" title="'.$lngstr['label_action_questions_edit'].'"></td><td class=rowone width="100%" colspan=4>To edit test questions, press a button to the right of the test.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['label_action_test_delete'].'"></td><td class=rowone width="100%" colspan=4>To delete test(s), press a button to the right of the test or select all necessary tests using the flag marks on the left and press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Use these buttons to transfer between pages.</td></tr>
</table></p>
<p>Groups table:</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-new.gif" title="'.$lngstr['label_action_create_group'].'"></td><td class=rowone width="100%" colspan=4>To create a new group, press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-edit.gif" title="'.$lngstr['label_action_group_edit'].'"></td><td class=rowone width="100%" colspan=4>To edit a group, press a button to the right of the group.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['label_action_group_delete'].'"></td><td class=rowone width="100%" colspan=4>To delete group(s), press a button to the right of the group or select all necessary groups using the flag marks on the left and press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Use these buttons to transfer between pages.</td></tr>
</table></p>';
$lngstr['tooltip_questionbank'] = '<p>This page is designed for creating and editing a bank of questions.</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-new.gif" title="'.$lngstr['label_action_create_question'].'"></td><td class=rowone width="100%" colspan=4>To create a new question, press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-stats.gif" title="'.$lngstr['label_action_questions_stats'].'"></td><td class=rowone width="100%" colspan=4>To view statistics for a particular question(s), press a button to the right of the question or select all necessary questions using the flag marks on the left and press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-edit.gif" title="'.$lngstr['label_action_question_edit'].'"></td><td class=rowone width="100%" colspan=4>To edit a question, press a button to the right of the question.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['label_action_question_delete'].'"></td><td class=rowone width="100%" colspan=4>To delete question(s), press a button to the right of the question or select all necessary questions using the flag marks on the left and press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Use these buttons to transfer between pages.</td></tr>
</table></p>';
$lngstr['tooltip_subjects'] = '<p>This page is designed for creating and editing subjects.</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-new.gif" title="'.$lngstr['label_action_create_subject'].'"></td><td class=rowone width="100%" colspan=4>To create a new subject, press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-edit.gif" title="'.$lngstr['label_action_subject_edit'].'"></td><td class=rowone width="100%" colspan=4>To edit a subject, press a button to the right of the subject.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['label_action_subject_delete'].'"></td><td class=rowone width="100%" colspan=4>To delete subject(s), press a button to the right of the subject or select all necessary subjects using the flag marks on the left and press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Use these buttons to transfer between pages.</td></tr>
</table></p>';
$lngstr['tooltip_reportsmanager'] = '<p>This page is designed for analyzing test results.</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-view.gif" title="'.$lngstr['label_action_test_result_view'].'"></td><td class=rowone width="100%" colspan=4>To view detailed test results, press a button to the right of the record.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['label_action_test_result_delete'].'"></td><td class=rowone width="100%" colspan=4>To delete record(s), press a button to the right of the record or select all necessary records using the flag marks on the left and press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Use these buttons to transfer between pages.</td></tr>
</table></p>';
$lngstr['tooltip_reportsmanager_reportsratings'] = '';
$lngstr['tooltip_users'] = '<p>This page is designed for creating and editing user accounts.</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-new.gif" title="'.$lngstr['label_action_create_user'].'"></td><td class=rowone width="100%" colspan=4>To create a new user account, press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-groups.gif" title="'.$lngstr['label_action_manageusers_groups'].'"></td><td class=rowone width="100%" colspan=4>To assign user(s) to a particular group, press a button to the right of the user or select all necessary users using the flag marks and press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-edit.gif" title="'.$lngstr['label_action_manageusers_edit'].'"></td><td class=rowone width="100%" colspan=4>To edit a user account, press a button to the right of the user account.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['label_action_manageusers_delete'].'"></td><td class=rowone width="100%" colspan=4>To delete user account(s), press a button to the right of the user account or select all necessary user accounts using the flag marks on the left and press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Use these buttons to transfer between pages.</td></tr>
</table></p>';
$lngstr['tooltip_users_groups'] = '';
$lngstr['tooltip_groups'] = '<p>This page is designed for creating and editing groups.</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-new.gif" title="'.$lngstr['label_action_create_group'].'"></td><td class=rowone width="100%" colspan=4>To create a new group, press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-edit.gif" title="'.$lngstr['label_action_group_edit'].'"></td><td class=rowone width="100%" colspan=4>To edit a group, press a button to the right of the group.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['label_action_group_delete'].'"></td><td class=rowone width="100%" colspan=4>To delete group(s), press a button to the right of the group or select all necessary groups using the flag marks on the left and press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Use these buttons to transfer between pages.</td></tr>
</table></p>';
$lngstr['tooltip_visitors'] = '<p>This page is designed for analyzing web statistics.</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-view.gif" title="'.$lngstr['label_action_visitors_view'].'"></td><td class=rowone width="100%" colspan=4>To view detailed statistics, press a button to the right of the record.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['label_action_visitor_delete'].'"></td><td class=rowone width="100%" colspan=4>To delete record(s), press a button to the right of the record or select all necessary records using the flag marks on the left and press this button on the tools panel at the top.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Use these buttons to transfer between pages.</td></tr>
</table></p>';
$lngstr['tooltip_resources'] = '';
$lngstr['tooltip_coupons'] = '';

$lngstr['label_country_items'] = array(
	'US' => 'United States',
	'AF' => 'Afghanistan',
	'AL' => 'Albania',
	'DZ' => 'Algeria',
	'AS' => 'American Samoa',
	'AD' => 'Andorra',
	'AO' => 'Angola',
	'AI' => 'Anguilla',
	'AQ' => 'Antarctica',
	'AG' => 'Antigua and Barbuda',
	'AR' => 'Argentina',
	'AM' => 'Armenia',
	'AW' => 'Aruba',
	'AU' => 'Australia',
	'AT' => 'Austria',
	'AZ' => 'Azerbaijan',
	'BS' => 'Bahamas',
	'BH' => 'Bahrain',
	'BD' => 'Bangladesh',
	'BB' => 'Barbados',
	'BY' => 'Belarus',
	'BE' => 'Belgium',
	'BZ' => 'Belize',
	'BJ' => 'Benin',
	'BM' => 'Bermuda',
	'BT' => 'Bhutan',
	'BO' => 'Bolivia',
	'BA' => 'Bosnia And Herzegowina',
	'BW' => 'Botswana',
	'BV' => 'Bouvet Island',
	'BR' => 'Brazil',
	'IO' => 'British Indian Ocean Territory',
	'BN' => 'Brunei Darussalam',
	'BG' => 'Bulgaria',
	'BF' => 'Burkina Faso',
	'BI' => 'Burundi',
	'KH' => 'Cambodia',
	'CM' => 'Cameroon',
	'CA' => 'Canada',
	'CV' => 'Cape Verde',
	'KY' => 'Cayman Islands',
	'CF' => 'Central African Republic',
	'TD' => 'Chad',
	'CL' => 'Chile',
	'CN' => 'China',
	'CX' => 'Christmas Island',
	'CC' => 'Cocos (Keeling) Islands',
	'CO' => 'Colombia',
	'KM' => 'Comoros',
	'CG' => 'Congo',
	'CD' => 'Congo, The Democratic Republic Of The',
	'CK' => 'Cook Islands',
	'CR' => 'Costa Rica',
	'CI' => 'Cote D\'ivoire',
	'HR' => 'Croatia (Local Name: Hrvatska)',
	'CU' => 'Cuba',
	'CY' => 'Cyprus',
	'CZ' => 'Czech Republic',
	'DK' => 'Denmark',
	'DJ' => 'Djibouti',
	'DM' => 'Dominica',
	'DO' => 'Dominican Republic',
	'TL' => 'East Timor',
	'EC' => 'Ecuador',
	'EG' => 'Egypt',
	'SV' => 'El Salvador',
	'GQ' => 'Equatorial Guinea',
	'ER' => 'Eritrea',
	'EE' => 'Estonia',
	'ET' => 'Ethiopia',
	'FK' => 'Falkland Islands (Malvinas)',
	'FO' => 'Faroe Islands',
	'FJ' => 'Fiji',
	'FI' => 'Finland',
	'FR' => 'France',
	'FX' => 'France, Metropolitan',
	'GF' => 'French Guiana',
	'PF' => 'French Polynesia',
	'TF' => 'French Southern Territories',
	'GA' => 'Gabon',
	'GM' => 'Gambia',
	'GE' => 'Georgia',
	'DE' => 'Germany',
	'GH' => 'Ghana',
	'GI' => 'Gibraltar',
	'GR' => 'Greece',
	'GL' => 'Greenland',
	'GD' => 'Grenada',
	'GP' => 'Guadeloupe',
	'GU' => 'Guam',
	'GT' => 'Guatemala',
	'GN' => 'Guinea',
	'GW' => 'Guinea-Bissau',
	'GY' => 'Guyana',
	'HT' => 'Haiti',
	'HM' => 'Heard and McDonald Islands',
	'VA' => 'Holy See (Vatican City State)',
	'HN' => 'Honduras',
	'HK' => 'Hong Kong',
	'HU' => 'Hungary',
	'IS' => 'Iceland',
	'IN' => 'India',
	'ID' => 'Indonesia',
	'IR' => 'Iran (Islamic Republic Of)',
	'IQ' => 'Iraq',
	'IE' => 'Ireland',
	'IL' => 'Israel',
	'IT' => 'Italy',
	'JM' => 'Jamaica',
	'JP' => 'Japan',
	'JO' => 'Jordan',
	'KZ' => 'Kazakhstan',
	'KE' => 'Kenya',
	'KI' => 'Kiribati',
	'KR' => 'Korea',
	'KP' => 'Korea, Democratic People\'s Republic Of',
	'KW' => 'Kuwait',
	'KG' => 'Kyrgyzstan',
	'LA' => 'Lao People\'s Democratic Republic',
	'LV' => 'Latvia',
	'LB' => 'Lebanon',
	'LS' => 'Lesotho',
	'LR' => 'Liberia',
	'LY' => 'Libyan Arab Jamahiriya',
	'LI' => 'Liechtenstein',
	'LT' => 'Lithuania',
	'LU' => 'Luxembourg',
	'MO' => 'Macau',
	'MK' => 'Macedonia, The Former Yugo-slav Republic Of',
	'MG' => 'Madagascar',
	'MW' => 'Malawi',
	'MY' => 'Malaysia',
	'MV' => 'Maldives',
	'ML' => 'Mali',
	'MT' => 'Malta',
	'MH' => 'Marshall Islands',
	'MQ' => 'Martinique',
	'MR' => 'Mauritania',
	'MU' => 'Mauritius',
	'YT' => 'Mayotte',
	'MX' => 'Mexico',
	'FM' => 'Micronesia, Federated States Of',
	'MD' => 'Moldova, Republic Of',
	'MC' => 'Monaco',
	'MN' => 'Mongolia',
	'MS' => 'Montserrat',
	'MA' => 'Morocco',
	'MZ' => 'Mozambique',
	'MM' => 'Myanmar',
	'NA' => 'Namibia',
	'NR' => 'Nauru',
	'NP' => 'Nepal',
	'NL' => 'Netherlands',
	'AN' => 'Netherlands Antilles',
	'NC' => 'New Caledonia',
	'NZ' => 'New Zealand',
	'NI' => 'Nicaragua',
	'NE' => 'Niger',
	'NG' => 'Nigeria',
	'NU' => 'Niue',
	'NF' => 'Norfolk Island',
	'MP' => 'Northern Mariana Islands',
	'NO' => 'Norway',
	'OM' => 'Oman',
	'PK' => 'Pakistan',
	'PW' => 'Palau',
	'PS' => 'Palestinian Territory, Occupied',
	'PA' => 'Panama',
	'PG' => 'Papua New Guinea',
	'PY' => 'Paraguay',
	'PE' => 'Peru',
	'PH' => 'Philippines',
	'PN' => 'Pitcairn',
	'PL' => 'Poland',
	'PT' => 'Portugal',
	'PR' => 'Puerto Rico',
	'QA' => 'Qatar',
	'RE' => 'Reunion',
	'RO' => 'Romania',
	'RU' => 'Russian Federation',
	'RW' => 'Rwanda',
	'KN' => 'Saint Kitts And Nevis',
	'LC' => 'Saint Lucia',
	'VC' => 'Saint Vincent And The Grena-dines',
	'WS' => 'Samoa',
	'SM' => 'San Marino',
	'ST' => 'Sao Tome And Principe',
	'SA' => 'Saudi Arabia',
	'SN' => 'Senegal',
	'SC' => 'Seychelles',
	'SL' => 'Sierra Leone',
	'SG' => 'Singapore',
	'SK' => 'Slovakia (Slovak Republic)',
	'SI' => 'Slovenia',
	'SB' => 'Solomon Islands',
	'SO' => 'Somalia',
	'ZA' => 'South Africa',
	'GS' => 'South Georgia And The South Sandwich Islands',
	'ES' => 'Spain',
	'LK' => 'Sri Lanka',
	'SH' => 'St. Helena',
	'PM' => 'St. Pierre and Miquelon',
	'SD' => 'Sudan',
	'SR' => 'Suriname',
	'SJ' => 'Svalbard And Jan Mayen Islands',
	'SZ' => 'Swaziland',
	'SE' => 'Sweden',
	'CH' => 'Switzerland',
	'SY' => 'Syrian Arab Republic',
	'TW' => 'Taiwan',
	'TJ' => 'Tajikistan',
	'TZ' => 'Tanzania, United Republic Of',
	'TH' => 'Thailand',
	'TG' => 'Togo',
	'TK' => 'Tokelau',
	'TO' => 'Tonga',
	'TT' => 'Trinidad And Tobago',
	'TN' => 'Tunisia',
	'TR' => 'Turkey',
	'TM' => 'Turkmenistan',
	'TC' => 'Turks And Caicos Islands',
	'TV' => 'Tuvalu',
	'UG' => 'Uganda',
	'UA' => 'Ukraine',
	'AE' => 'United Arab Emirates',
	'GB' => 'United Kingdom',
	'UM' => 'United States Minor Outlying Islands',
	'UY' => 'Uruguay',
	'USCA' => 'US and Canada',
	'UZ' => 'Uzbekistan',
	'VU' => 'Vanuatu',
	'VE' => 'Venezuela',
	'VN' => 'Viet Nam',
	'VG' => 'Virgin Islands (British)',
	'VI' => 'Virgin Islands (U.S.)',
	'WF' => 'Wallis And Futuna Islands',
	'EH' => 'Western Sahara',
	'YE' => 'Yemen',
	'ZM' => 'Zambia',
	'ZW' => 'Zimbabwe',
);

/*
$lngstr['custom']['user_state_items'] = array(
	'' => $lngstr['label_pleasespecify'],
	'AA' => 'AA',
	'AE' => 'AE',
	'AL' => 'Alabama',
	'AK' => 'Alaska',
	'AB' => 'Alberta',
	'AP' => 'AP',
	'AZ' => 'Arizona',
	'AR' => 'Arkansas',
	'BC' => 'British Columbia',
	'CA' => 'California',
	'CO' => 'Colorado',
	'CT' => 'Connecticut',
	'DE' => 'Delaware',
	'DC' => 'Dist. of Columbia',
	'FL' => 'Florida',
	'FP' => 'FP',
	'GA' => 'Georgia',
	'HI' => 'Hawaii',
	'ID' => 'Idaho',
	'IL' => 'Illinois',
	'IN' => 'Indiana',
	'IA' => 'Iowa',
	'KS' => 'Kansas',
	'KY' => 'Kentucky',
	'LA' => 'Louisiana',
	'ME' => 'Maine',
	'MB' => 'Manitoba',
	'MD' => 'Maryland',
	'MA' => 'Massachusetts',
	'MI' => 'Michigan',
	'MN' => 'Minnesota',
	'MS' => 'Mississippi',
	'MO' => 'Missouri',
	'MT' => 'Montana',
	'NE' => 'Nebraska',
	'NV' => 'Nevada',
	'NB' => 'New Brunswick',
	'NH' => 'New Hampshire',
	'NJ' => 'New Jersey',
	'NM' => 'New Mexico',
	'NY' => 'New York',
	'NF' => 'Newfoundland',
	'NC' => 'North Carolina',
	'ND' => 'North Dakota',
	'NT' => 'Northwest Territories',
	'NS' => 'Nova Scotia',
	'NU' => 'Nunavut',
	'OH' => 'Ohio',
	'OK' => 'Oklahoma',
	'ON' => 'Ontario',
	'OR' => 'Oregon',
	'PA' => 'Pennsylvania',
	'PE' => 'Prince Edward Island',
	'QC' => 'Quebec',
	'RI' => 'Rhode Island',
	'SK' => 'Saskatchewan',
	'SC' => 'South Carolina',
	'SD' => 'South Dakota',
	'TN' => 'Tennessee',
	'TX' => 'Texas',
	'VI' => 'US Virgin Islands',
	'UT' => 'Utah',
	'VT' => 'Vermont',
	'VA' => 'Virginia',
	'WA' => 'Washington',
	'WV' => 'West Virginia',
	'WI' => 'Wisconsin',
	'WY' => 'Wyoming',
	'YT' => 'Yukon',
);
$lngstr['custom']['user_cstate_items'] = $lngstr['custom']['user_state_items'];
$lngstr['custom']['user_userfield1_items'] = array();
*/

$m_question_types = array(
	QUESTION_TYPE_MULTIPLECHOICE => $lngstr['label_atype_multiple_choice'],
	QUESTION_TYPE_MULTIPLEANSWER => $lngstr['label_atype_multiple_answer'],
	QUESTION_TYPE_TRUEFALSE => $lngstr['label_atype_truefalse'],
	QUESTION_TYPE_FILLINTHEBLANK => $lngstr['label_atype_fillintheblank'],
	QUESTION_TYPE_ESSAY => $lngstr['label_atype_essay'],
	QUESTION_TYPE_RANDOM => $lngstr['label_atype_random'],
	);

?>