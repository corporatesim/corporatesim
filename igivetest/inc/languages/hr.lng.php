<?php

// Customizable (you can customize/override this data in custom.lng.php):
// ----------------------------------------------------------------------
// Branding:
$lngstr['branding']['top_logo'] = '<img src="images/logo.gif" width=200 height=40>';
$lngstr['branding']['btm_sign'] = 'Copyright &copy; 2004-2012 IGLearn, Sight2k.<br />All Rights Reserved.';
// Sign in page:
$lngstr['page_signin_box_intro'] = '';

// Non-customizable (it is not recommended to customize this data):
// ----------------------------------------------------------------
$lngstr['branding']['powered_by'] = 'Powered by <a href="http://iGiveTest.com" target=_blank>iGiveTest v'.IGT_VERSION.'</a>';
// General:
$lngstr['meta_charset'] = 'windows-1250';
$lngstr['sql_charset'] = 'latin2';
$lngstr['meta_contentlanguage'] = 'hr';
$lngstr['language']['date_only_format'] = '%d.%m.%Y'; // 'd.m.Y'
$lngstr['language']['date_format'] = '%d.%m.%Y %H:%M';
$lngstr['language']['date_format_full'] = '%d. %B %Y, %H:%M:%S';
$lngstr['language']['calendar']['date_format'] = '%Y-%m-%d %H:%M';
$lngstr['text_direction'] = 'ltr';
$lngstr['languages'] = array('en' => 'English', 'es' => 'Spanish', 'de' => 'German', 'fr' => 'French', 'nl' => 'Dutch', 'hr' => 'Croatian');
$lngstr['language_long'] = 'ñroatian';
$lngstr['language']['locale'] = array('hr');

$lngstr['calendar_month'] = 'Mjesec';
$lngstr['calendar_day'] = 'Dan';
$lngstr['calendar_year'] = 'Godina';
$lngstr['calendar_hour'] = 'Sat';
$lngstr['calendar_minute'] = 'Minuta';
$lngstr['time_days'] = 'Dana';
$lngstr['time_days_short'] = 'dana';
$lngstr['time_hours'] = 'Sati';
$lngstr['time_hours_short'] = 'h';
$lngstr['time_minutes'] = 'Minuta';
$lngstr['time_minutes_short'] = 'min';
$lngstr['time_seconds'] = 'Sekundi';
$lngstr['time_seconds_short'] = 'sec';
$lngstr['time_donotuse'] = 'Ne koristi';

$lngstr['calendar_months'] = array(
	1 => 'Sijeèanj',
	2 => 'Veljaèa',
	3 => 'Ožujak',
	4 => 'Travanj',
	5 => 'Svibanj',
	6 => 'Lipanj',
	7 => 'Srpanj',
	8 => 'Kolovoz',
	9 => 'Rujan',
	10 => 'Listopad',
	11 => 'Studeni',
	12 => 'Prosinac',
	);

$lngstr['label_yes'] = 'Da';
$lngstr['label_no'] = 'Ne';
$lngstr['label_undefined'] = 'nedefiniran';
$lngstr['label_partially'] = 'Djelomièno';
$lngstr['label_notapplicable'] = 'n/a';
$lngstr['label_all'] = 'All';
$lngstr['label_noname'] = '[Bez imena]';
$lngstr['label_none'] = '- Nijedan -';
$lngstr['label']['print_version'] = 'Vidi verziju za printanje';

$lngstr['label_navigate_show'] = 'Prikaži:';
$lngstr['button_next'] = 'Poslije';
$lngstr['button_prev'] = 'Prije';
$lngstr['button_accept'] = 'Prihvati';
$lngstr['button_next_page'] = 'Stranica naprijed';
$lngstr['button_prev_page'] = 'Stranica nazad';
$lngstr['button_first_page'] = 'Poèetna stranica';
$lngstr['button_last_page'] = 'Zadnja stranica';

$lngstr['label']['view_edit_user'] = 'Vidi / editiraj ovaj korisnièki profil';

$lngstr['label_atype_multiple_choice'] = 'Višestruki izbor';
$lngstr['label_atype_multiple_answer'] = 'Više odgovora';
$lngstr['label_atype_truefalse'] = 'Toèno/Netoèno';
$lngstr['label_atype_truefalse_true'] = 'Toèno';
$lngstr['label_atype_truefalse_false'] = 'Netoèno';
$lngstr['label_atype_fillintheblank'] = 'Kratki odgovor';
$lngstr['label_atype_essay'] = 'Pisani odgovor';
$lngstr['label_atype_random'] = 'Sluèajno pitanje';

$lngstr['item_separator'] = ' - ';
$lngstr['page_title_signin'] = 'Ulaz';
$lngstr['page_title_register'] = 'Registracija';
$lngstr['page_title_lostpassword'] = 'Zaboravio sam lozinku';
$lngstr['page_title_panel'] = 'Riješi test';
$lngstr['page_header_panel'] = $lngstr['page_title_panel'];
$lngstr['page_title_test'] = 'Riješi test';
$lngstr['page_title_results'] = 'Upravljanje izvještajima';
$lngstr['page_header_results'] = $lngstr['page_title_results'];
 $lngstr['page_title_results_questions'] = 'Detalji o pitanju';
 $lngstr['page_header_results_questions'] = $lngstr['page_title_results_questions'];
 $lngstr['page_title_results_answers'] = 'Detalji o odgvoru';
 $lngstr['page_header_results_answers'] = $lngstr['page_title_results_answers'];
 $lngstr['page_reportsmanager']['correct_answer'] = 'Pitanje s toènim odgovorom';
 $lngstr['page_reportsmanager']['your_answer'] = 'Vaš odgovor';
$lngstr['page_statistics']['title'] = 'Statistike';
$lngstr['page_statistics']['header'] = $lngstr['page_statistics']['title'];
 $lngstr['page_statistics_resultid']['title'] = 'Detaljni izvještaj o testu';
 $lngstr['page_statistics_resultid']['header'] = 'Detaljni izvještaj testa za: %s';
$lngstr['page_title_edittests'] = 'Test administracija';
$lngstr['page_header_edittests'] = $lngstr['page_title_edittests'];
 $lngstr['page_title_test_settings'] = 'Test postavke';
 $lngstr['page_header_test_settings'] = $lngstr['page_title_test_settings'];
 $lngstr['page_title_test_assignto'] = 'Pridruži';
 $lngstr['page_header_test_assignto_tests'] = 'Testovi';
 $lngstr['page_header_test_assignto_groups'] = 'Grupe';
 $lngstr['page_title_test_questions'] = 'Pitanja testa';
 $lngstr['page_header_test_questions'] = $lngstr['page_title_test_questions'];
 $lngstr['page_title_test_sections'] = 'Podjela testova';
 $lngstr['page_header_test_sections'] = $lngstr['page_title_test_sections'];
 $lngstr['page_title_import_questions'] = 'Importiraj pitanja';
 $lngstr['page_header_import_questions'] = $lngstr['page_title_import_questions'];
 $lngstr['page_testmanager_stats']['title'] = 'Statistike testova';
 $lngstr['page_testmanager_stats']['header'] = $lngstr['page_testmanager_stats']['title'];
$lngstr['page_title_questionbank'] = 'Baza pitanja';
$lngstr['page_header_questionbank'] = $lngstr['page_title_questionbank'];
 $lngstr['page_title_question_stats'] = 'Statistike pitanja';
 $lngstr['page_header_question_stats'] = $lngstr['page_title_question_stats'];
 $lngstr['page_title_edit_question'] = 'Editiraj pitanje';
 $lngstr['page_header_edit_question'] = $lngstr['page_title_edit_question'];
$lngstr['page_title_manageusers'] = 'Korisnici';
$lngstr['page_header_manageusers'] = $lngstr['page_title_manageusers'];
 $lngstr['page_title_users_memberof'] = 'Korisnici od';
 $lngstr['page_title_users_memberof_users'] = 'Korisnici';
 $lngstr['page_title_users_memberof_groups'] = 'Grupe';
 $lngstr['page_title_users_settings'] = 'Postavke korisnika';
 $lngstr['page_header_users_settings'] = $lngstr['page_title_users_settings'];
$lngstr['page_title_managegroups'] = 'Grupe';
$lngstr['page_header_managegroups'] = $lngstr['page_title_managegroups'];
 $lngstr['page_title_groups_settings'] = 'Postavke grupe';
 $lngstr['page_header_groups_settings'] = $lngstr['page_title_groups_settings'];
$lngstr['page_title_subjects'] = 'Nazivi';
$lngstr['page_header_subjects'] = $lngstr['page_title_subjects'];
 $lngstr['page_title_subjects_settings'] = 'Postavke naziva';
 $lngstr['page_header_subjects_settings'] = $lngstr['page_title_subjects_settings'];
$lngstr['page_title_emailtemplates'] = 'Email predlošci';
$lngstr['page_header_emailtemplates'] = $lngstr['page_title_emailtemplates'];
 $lngstr['page_title_etemplates_edit'] = 'Editiraj email predložak';
 $lngstr['page_header_etemplates_edit'] = $lngstr['page_title_etemplates_edit'];
$lngstr['page_title_rtemplates'] = 'Predlošci izvještaja';
$lngstr['page_header_rtemplates'] = $lngstr['page_title_rtemplates'];
 $lngstr['page_title_rtemplates_edit'] = 'Editiraj predložak izvještaja';
 $lngstr['page_header_rtemplates_edit'] = $lngstr['page_title_rtemplates_edit'];
$lngstr['page_title_grades'] = 'Sistem ocjenjivanja';
$lngstr['page_header_grades'] = $lngstr['page_title_grades'];
 $lngstr['page_title_grades_edit'] = 'Postavke sistema ocjenjivanja';
 $lngstr['page_header_grades_edit'] = $lngstr['page_title_grades_edit'];
$lngstr['page_title_gradescales'] = 'Raspon ocjenjivanja';
$lngstr['page_header_gradescales'] = $lngstr['page_title_gradescales'];
 $lngstr['page_title_grade_settings'] = 'Editiraj ocjenu';
 $lngstr['page_header_grade_settings'] = $lngstr['page_title_grade_settings'];
$lngstr['page_title_config'] = 'Konfiguracija';
$lngstr['page_header_config'] = $lngstr['page_title_config'];
$lngstr['page_title_visitors'] = 'Web statistike';
$lngstr['page_header_visitors'] = $lngstr['page_title_visitors'];
 $lngstr['page_title_visitordetails'] = 'Detalji posjetitelja';
 $lngstr['page_header_visitordetails'] = $lngstr['page_title_visitordetails'];

$lngstr['panel_home'] = $lngstr['page_title_panel'];
$lngstr['panel_results'] = $lngstr['page_title_results'];
$lngstr['panel_edittests'] = $lngstr['page_title_edittests'];
$lngstr['panel_questionbank'] = $lngstr['page_title_questionbank'];
$lngstr['panel_managegroups'] = $lngstr['page_title_managegroups'];
$lngstr['panel_signout'] = 'Izlaz';
$lngstr['panel_edit_subjects'] = 'Upravljaj nazivima';
$lngstr['panel_usersandgroups'] = 'Administracija';
$lngstr['panel_manage_groups'] = 'Upravljaj grupama';
$lngstr['panel_manage_users'] = 'Upravljaj korisnicima';

$lngstr['label_choice_no'] = 'Izbor %d:';
$lngstr['label_answer_text'] = 'Odgovor:';
$lngstr['label_answer_feedback_no'] = 'Povratna informacija %d:';
$lngstr['label_accept_as_correct'] = 'Prihvati kao otoèan';
$lngstr['label_answer_percents'] = '% toèan';
$lngstr['label_mark_correct_answers'] = 'Oznaèite toèan(e) odgovor(e)';
$lngstr['label_mark_correct_fillintheblank'] = 'Upišite toèan odgovor ovdje';

// Report Manager:
$lngstr['label_hdr_action'] = 'Moguænosti';
$lngstr['label_hdr_select_hint'] = 'Selektirajte ili de-selektirajte sve redove';
$lngstr['label_action_test_result_view'] = 'Vidi rezulatate testa';
$lngstr['label_action_test_result_delete'] = 'Izbriši ovaj upis';
$lngstr['label_action_results_delete'] = 'Izbriši rezultate (odabrane)';
$lngstr['label_action_view_question_result'] = 'Vidi detalje odgovora';

// Test Manager:
$lngstr['label_action_test_settings'] = 'Test postavke';
$lngstr['label_action_questions_edit'] = 'Editiraj pitanja';
$lngstr['label_action_test_delete'] = 'Izbriši ovaj test';
$lngstr['label_action_tests_delete'] = 'Izbriši testove (oznaèene)';
$lngstr['label_action_question_edit'] = 'Editiraj ovo pitanje';
$lngstr['label_action_question_moveup'] = 'Pomakni gore';
$lngstr['label_action_question_movedown'] = 'Pomakni dolje';
$lngstr['label_action_question_append'] = 'Dodaj ovo pitanje testu';
$lngstr['label_action_questions_append'] = 'Dodaj pitanja testu (oznaèena)';
$lngstr['label_action_question_delete'] = 'Izbriši ovo pitanje';
$lngstr['label_action_questions_delete'] = 'Izbriši pitanja (oznaèena)';
$lngstr['label_action_question_link_delete'] = 'Izbaci ovo pitanej iz testa';
$lngstr['label_action_question_links_delete'] = 'Izbaci pitanja iz testa (oznaèena)';
$lngstr['label_action_question_stats'] = 'Prikaži statistike';
$lngstr['label_action_questions_stats'] = 'Prikaži statistike (za oznaèene podatke)';
$lngstr['label_action_manageusers_edit'] = 'Postavke korisnika';
$lngstr['label_action_manageusers_groups'] = 'Grupe korisnika';
$lngstr['label_action_groups'] = 'Grupe korisnika (za oznaèene grupe)';
$lngstr['label_action_manageusers_delete'] = 'Izbriši ovog korisnika';
$lngstr['label_action_users_delete'] = 'Izbriši korisnike (oznaèene)';
$lngstr['label_action_create_user'] = 'Kreiraj novog korisnika';
$lngstr['label_action_group_delete'] = 'Izbriši ovu grupu';
$lngstr['label_action_groups_delete'] = 'Izbriši grupe (oznaèene)';
$lngstr['label_action_create_group'] = 'Kreiraj novu grupu';
$lngstr['label_action_group_edit'] = 'Postavke grupa';
$lngstr['label_action_test_groups_select'] = 'Pridruži grupi';
$lngstr['label_action_subject_edit'] = 'Postavke naziva';
$lngstr['label_action_subject_delete'] = 'Izbriši ovaj naziv';
$lngstr['label_action_subjects_delete'] = 'Izbriši nazive (oznaèene)';
$lngstr['label_action_create_test'] = 'Kreiraj novi test';
$lngstr['label_action_import_questions'] = 'Import pitanja';
$lngstr['label_action_create_question'] = 'Kreiraj novo pitanje';
$lngstr['label_action_create_and_add_question'] = 'Kreiraj / dodaj pitanje testu';
$lngstr['label_action_create_etemplate'] = 'Kreiraj novi email predložak';
$lngstr['label_action_etemplates_edit'] = 'Edititiraj ovaj email predložak';
$lngstr['label_action_etemplate_delete'] = 'Izbriši ovaj email predložak';
$lngstr['label_action_etemplates_delete'] = 'Izbriši email predloške (oznaèene)';
$lngstr['label_action_grade_settings'] = 'Postavke sistema ocjenjivanja';
$lngstr['label_action_grade_delete'] = 'Izbriši ovaj sistem ocjenjivanja';
$lngstr['label_action_grades_delete'] = 'Izbriši sisteme ocjenjivanja (oznaèene)';
$lngstr['label_action_gradescales_edit'] = 'Editiraj ovaj Raspon ocjena';
$lngstr['label_action_gradescales_delete'] = 'Izbriši ocjene (oznaèene)';
$lngstr['label_action_gradescale_edit'] = 'Editiraj ovu ocjenu';
$lngstr['label_action_gradescale_delete'] = 'Izbriši ovu ocjenu';
$lngstr['label_action_visitor_delete'] = 'Izbriši ovaj podatak';
$lngstr['label_action_visitors_delete'] = 'Izbriši podatke (oznaèene)';
$lngstr['page-sections']['action_section_create'] = 'Kreiraj';
$lngstr['page-sections']['action_section_edit'] = 'Editiraj ovu sekciju';
$lngstr['page-sections']['action_section_delete'] = 'Izbriši ovu sekciju';
$lngstr['page-sections']['action_sections_delete'] = 'Izbriši sekcije (oznaèene)';
$lngstr['page-rtemplates']['action_create_rtemplate'] = 'Kreiraj novi predložak izvještaja';
$lngstr['page-rtemplates']['action_rtemplate_delete'] = 'Izbriši ovaj predložak izvještaja';
$lngstr['page-rtemplates']['action_rtemplates_delete'] = 'Izbriši predloške izveštaja (oznaèene)';
$lngstr['page-rtemplates']['action_rtemplates_edit'] = 'Editiraj ovaj predložak izvještaja';

$lngstr['label_test_testinstructions'] = 'Upute za test';
$lngstr['page_test']['no_time_limit'] = 'Bez tajmera';
$lngstr['page_test']['test_timer_hint'] = 'Test tajmer';
$lngstr['page_test']['questionindicator'] = '%d of %d';
$lngstr['page_test']['questionindicator_hint'] = ' %d of %d';
$lngstr['page_test']['testname_hint'] = 'Naziv testa';
$lngstr['label_result_username'] = '<b>Ime:</b> %s';
$lngstr['label_result_testname'] = '<b>Naziv testa:</b> %s';
$lngstr['label_result_testdate'] = '<b>Datum:</b> %s';
$lngstr['label_result_timespent'] = '<b>Utrošeno vrijeme:</b> %s';
$lngstr['label_result_got_answers'] = '<b>Toènih odgvora:</b> %d out of %d';
$lngstr['label_result_got_points'] = '<b>Rezultat:</b> %d out of %d (%d%%)';
$lngstr['label_result_points_pending'] = '<b>Moguæih bodova:</b> %d';
$lngstr['label_result_got_grade'] = '<b>Ocjena:</b> %s';
$lngstr['label_result_do_not_show'] = 'Vaš test je ocjenjen i upisan u bazu.';
$lngstr['label_result_showpdf'] = 'Kliknite ovdje za PDF izvještaj';

$lngstr['page_test_instructions']['next_page'] = 'Stranica poslije';

$lngstr['label_report_hdr_resultid'] = 'ID';
$lngstr['label_report_hdr_resultid_hint'] = 'ID Rezultata (kliknite za sortiranje po)';
$lngstr['label_report_hdr_result_datestart'] = 'Datum';
$lngstr['label_report_hdr_result_datestart_hint'] = 'Datum (kliknite za sortiranje po)';
$lngstr['label_report_hdr_user_name'] = 'Korisnik';
$lngstr['label_report_hdr_user_name_hint'] = 'Korisnik (kliknite za sortiranje po)';
$lngstr['label_report_hdr_test_name'] = 'Naziv testa';
$lngstr['label_report_hdr_test_name_hint'] = 'Naziv testa (kliknite za sortiranje po)';
$lngstr['page_reportsmanager']['hdr_test_pokušaja'] = 'Utrošenih pokušaja';
$lngstr['page_reportsmanager']['hdr_test_pokušaja_hint'] = 'Utrošenih pokušaja';
$lngstr['label_report_hdr_result_timeexceeded'] = 'Utrošeno vremena';
$lngstr['label_report_hdr_result_timeexceeded_hint'] = 'Utrošeno vremena (kliknite za sortiranje po)';
$lngstr['label_report_hdr_result_points'] = 'Ostaverno bodova';
$lngstr['label_report_hdr_result_points_hint'] = 'Ostvareno bodova (kliknite za sortiranje po)';
$lngstr['label_report_hdr_result_pointsmax'] = 'Moguæih bodova';
$lngstr['label_report_hdr_result_pointsmax_hint'] = 'Moguæih bodova(kliknite za sortiranje po)';
$lngstr['label_report_hdr_result_score'] = 'Rezultat';
$lngstr['label_report_hdr_result_score_hint'] = 'Rezultat (kliknite za sortiranje po)';
$lngstr['label_report_hdr_gscale_gradeid'] = 'Ocjena';
$lngstr['label_report_hdr_gscale_gradeid_hint'] = 'Ocjena (kliknite za sortiranje po)';
$lngstr['label_report_hdr2_result_answerid'] = 'Niz';
$lngstr['label_report_hdr2_result_answerid_hint'] = 'Redoslijed (kliknite za sortiranje po)';
$lngstr['label_report_hdr2_test_questionid'] = '#';
$lngstr['label_report_hdr2_test_questionid_hint'] = 'Broj pitanja (kliknite za sortiranje po)';
$lngstr['label_report_hdr2_result_answer_timespent'] = 'Vrijeme';
$lngstr['label_report_hdr2_result_answer_timespent_hint'] = 'Vrijeme (kliknite za sortiranje po)';
$lngstr['label_report_hdr2_result_answer_text'] = 'Odgovor';
$lngstr['label_report_hdr2_result_answer_text_hint'] = 'Odgovor';
$lngstr['label_report_hdr2_result_answer_points'] = 'Bodova';
$lngstr['label_report_hdr2_result_answer_points_hint'] = 'Vrijednost boda (kliknite za sortiranje po)';
$lngstr['label_report_hdr2_result_answer_iscorrect'] = 'Ispravno';
$lngstr['label_report_hdr2_result_answer_iscorrect_hint'] = 'Ispravno (kliknite za sortiranje po)';
$lngstr['label_report_hdr2_result_answer_timeexceeded'] = $lngstr['label_report_hdr_result_timeexceeded'];
$lngstr['label_report_hdr2_result_answer_timeexceeded_hint'] = $lngstr['label_report_hdr_result_timeexceeded_hint'];
$lngstr['label_edittests_hdr_testid'] = 'ID';
$lngstr['label_edittests_hdr_testid_hint'] = 'Test ID (kliknite za sortiranje po)';
$lngstr['label_edittests_hdr_test_name'] = 'Nziv testa';
$lngstr['label_edittests_hdr_test_name_hint'] = 'Naziv testa (kliknite za sortiranje po)';
$lngstr['label_edittests_hdr_subjectid'] = 'Tema';
$lngstr['label_edittests_hdr_subjectid_hint'] = 'Tema (kliknite za sortiranje po)';
$lngstr['label_edittests_hdr_test_datestart'] = 'Datum poèetka';
$lngstr['label_edittests_hdr_test_datestart_hint'] = 'Datum poèetka (kliknite za sortiranje po)';
$lngstr['label_edittests_hdr_test_dateend'] = 'Datum završetka';
$lngstr['label_edittests_hdr_test_dateend_hint'] = 'Datum završetka (kliknite za sortiranje po)';
$lngstr['label_edittests_hdr_test_notes'] = 'B';
$lngstr['label_edittests_hdr_test_notes_hint'] = 'Bilješke';
$lngstr['label_edittests_hdr_test_enabled'] = 'Aktivan';
$lngstr['label_edittests_hdr_test_enabled_hint'] = 'Aktivan(kliknite za sortiranje po)';
$lngstr['label_editquestions_hdr_questionid'] = 'ID';
$lngstr['label_editquestions_hdr_questionid_hint'] = 'ID pitanja (kliknite za sortiranje po)';
$lngstr['label_editquestions_hdr_subjectid'] = 'Tema';
$lngstr['label_editquestions_hdr_subjectid_hint'] = 'Tema (kliknite za sortiranje po)';
$lngstr['label_editquestions_hdr_question_text'] = 'Pitanje';
$lngstr['label_editquestions_hdr_question_text_hint'] = 'Pitanje';
$lngstr['label_editquestions_hdr_question_type'] = 'Tip';
$lngstr['label_editquestions_hdr_question_type_hint'] = 'Tip (kliknite za sortiranje po)';
$lngstr['label_editquestions_hdr_question_points'] = 'Bodova';
$lngstr['label_editquestions_hdr_question_points_hint'] = 'Vrijednost boda (kliknite za sortiranje po)';
$lngstr['label_editquestions_hdr_test_questionid'] = 'Seq';
$lngstr['label_editquestions_hdr_test_questionid_hint'] = 'Niz (kliknite za sortiranje po)';
$lngstr['label_questionstats_hdr_questionid'] = 'ID';
$lngstr['label_questionstats_hdr_questionid_hint'] = 'ID pitanja';
$lngstr['label_questionstats_hdr_questiondata'] = 'Podaci o pitanju';
$lngstr['label_questionstats_hdr_questiondata_hint'] = 'Podaci o pitanju';
$lngstr['label_questionstats_hdr_answerclicks'] = 'Klikovi';
$lngstr['label_questionstats_hdr_answerclicks_hint'] = 'Klikovi odgvora';
$lngstr['label_questionstats_hdr_answerpercent'] = '%';
$lngstr['label_questionstats_hdr_answerpercent_hint'] = 'Postotak';
$lngstr['label_manageusers_hdr_userid'] = 'ID';
$lngstr['label_manageusers_hdr_userid_hint'] = 'ID korisnika (kliknite za sortiranje po)';
$lngstr['label_manageusers_hdr_user_notes'] = 'B';
$lngstr['label_manageusers_hdr_user_notes_hint'] = 'Bilješke';
$lngstr['label_manageusers_hdr_user_name'] = 'Korisnik';
$lngstr['label_manageusers_hdr_user_name_hint'] = 'Korisnik (kliknite za sortiranje po)';
$lngstr['label_manageusers_hdr_user_email'] = 'Email';
$lngstr['label_manageusers_hdr_user_email_hint'] = 'Email (kliknite za sortiranje po)';
$lngstr['label_manageusers_hdr_user_firstname'] = 'Ime';
$lngstr['label_manageusers_hdr_user_firstname_hint'] = 'Ime (kliknite za sortiranje po)';
$lngstr['label_manageusers_hdr_user_lastname'] = 'Prezime';
$lngstr['label_manageusers_hdr_user_lastname_hint'] = 'Prezime (kliknite za sortiranje po)';
$lngstr['label_manageusers_hdr_user_enabled'] = 'Aktivan';
$lngstr['label_manageusers_hdr_user_enabled_hint'] = 'Aktivan (kliknite za sortiranje po)';
$lngstr['label_managegroups_hdr_groupid'] = 'ID';
$lngstr['label_managegroups_hdr_groupid_hint'] = 'ID Grupe (kliknite za sortiranje po)';
$lngstr['label_managegroups_hdr_group_name'] = 'Ime';
$lngstr['label_managegroups_hdr_group_name_hint'] = 'Naziv grupe (kliknite za sortiranje po)';
$lngstr['label_managegroups_hdr_group_description'] = 'Opis';
$lngstr['label_managegroups_hdr_group_description_hint'] = 'Opis grupe (kliknite za sortiranje po)';
$lngstr['label_managegroups_hdr_member_of'] = 'Èlan';
$lngstr['label_managegroups_hdr_member_of_hint'] = 'Èlan od (kliknite za sortiranje po)';
$lngstr['label_subjects_hdr_subjectid'] = 'ID';
$lngstr['label_subjects_hdr_subjectid_hint'] = 'ID Teme (kliknite za sortiranje po)';
$lngstr['label_subjects_hdr_subject_name'] = 'Naziv';
$lngstr['label_subjects_hdr_subject_name_hint'] = 'Naziv teme (kliknite za sortiranje po)';
$lngstr['label_subjects_hdr_subject_description'] = 'Opis';
$lngstr['label_subjects_hdr_subject_description_hint'] = 'Opis teme (kliknite za sortiranje po)';
$lngstr['label_etemplates_hdr_etemplateid'] = 'ID';
$lngstr['label_etemplates_hdr_etemplateid_hint'] = 'ID email predloška (kliknite za sortiranje po)';
$lngstr['label_etemplates_hdr_etemplate_name'] = 'Naziv';
$lngstr['label_etemplates_hdr_etemplate_name_hint'] = 'Nasziv email predloška (kliknite za sortiranje po)';
$lngstr['label_etemplates_hdr_etemplate_description'] = 'Opis';
$lngstr['label_etemplates_hdr_etemplate_description_hint'] = 'Opis email predloška (kliknite za sortiranje po)';

$lngstr['page-rtemplates']['hdr_rtemplateid'] = 'ID';
$lngstr['page-rtemplates']['hdr_rtemplateid_hint'] = 'ID predloška izvještaja (kliknite za sortiranje po)';
$lngstr['page-rtemplates']['hdr_rtemplate_name'] = 'Naziv';
$lngstr['page-rtemplates']['hdr_rtemplate_name_hint'] = 'Naziv predloška izvještaja (kliknite za sortiranje po)';
$lngstr['page-rtemplates']['hdr_rtemplate_description'] = 'Opis';
$lngstr['page-rtemplates']['hdr_rtemplate_description_hint'] = 'Opis predloška izvještaja (kliknite za sortiranje po)';

$lngstr['label_grades_hdr_gscaleid'] = 'ID';
$lngstr['label_grades_hdr_gscaleid_hint'] = 'ID sistema ocjenjivanja (kliknite za sortiranje po)';
$lngstr['label_grades_hdr_gscale_name'] = 'Naziv';
$lngstr['label_grades_hdr_gscale_name_hint'] = 'Naziv sistema ocjenjivanja (kliknite za sortiranje po)';
$lngstr['label_grades_hdr_gscale_description'] = 'Opis';
$lngstr['label_grades_hdr_gscale_description_hint'] = 'Opis sistema ocjenjivanja (kliknite za sortiranje po)';
$lngstr['label_gradescales_hdr_gscale_gradeid'] = 'ID';
$lngstr['label_gradescales_hdr_gscale_gradeid_hint'] = 'ID Ocjene (kliknite za sortiranje po)';
$lngstr['label_gradescales_hdr_grade_from'] = 'Min';
$lngstr['label_gradescales_hdr_grade_from_hint'] = 'Minimalno (kliknite za sortiranje po)';
$lngstr['label_gradescales_hdr_grade_to'] = 'Max';
$lngstr['label_gradescales_hdr_grade_to_hint'] = 'Maximalno(kliknite za sortiranje po)';
$lngstr['label_gradescales_hdr_grade_name'] = 'Naziv';
$lngstr['label_gradescales_hdr_grade_name_hint'] = 'Naziv ocjene (kliknite za sortiranje po)';
$lngstr['label_gradescales_hdr_grade_description'] = 'Opis';
$lngstr['label_gradescales_hdr_grade_description_hint'] = 'Opis ocjene (kliknite za sortiranje po)';
$lngstr['label_visitors_hdr_visitorid'] = 'ID';
$lngstr['label_visitors_hdr_visitorid_hint'] = 'ID Posjetitelja (kliknite za sortiranje po)';
$lngstr['label_visitors_hdr_startdate'] = 'Datum';
$lngstr['label_visitors_hdr_startdate_hint'] = 'Datum (kliknite za sortiranje po)';
$lngstr['label_visitors_hdr_username'] = 'Korisnik';
$lngstr['label_visitors_hdr_username_hint'] = 'Korisnik (kliknite za sortiranje po)';
$lngstr['label_visitors_hdr_hits'] = 'Hitova';
$lngstr['label_visitors_hdr_hits_hint'] = 'Hitova (kliknite za sortiranje po)';
$lngstr['label_visitors_hdr_ip'] = 'IP-Adresa';
$lngstr['label_visitors_hdr_ip_hint'] = 'IP-adresa';
$lngstr['label_visitors_hdr_host'] = 'Naziv hosta';
$lngstr['label_visitors_hdr_host_hint'] = 'Naziv hosta (kliknite za sortiranje po)';
$lngstr['label_visitors_hdr_referer'] = 'Referer';
$lngstr['label_visitors_hdr_referer_hint'] = 'Referer (kliknite za sortiranje po)';
$lngstr['page-sections']['hdr_sectionid'] = 'Niz';
$lngstr['page-sections']['hdr_sectionid_hint'] = 'Redoslijed (kliknite za sortiranje po)';
$lngstr['page-sections']['hdr_section_name'] = 'Naziv';
$lngstr['page-sections']['hdr_section_name_hint'] = 'Naziv sekcije (kliknite za sortiranje po)';
$lngstr['page-sections']['hdr_section_description'] = 'Opis';
$lngstr['page-sections']['hdr_section_description_hint'] = 'Opis sekcije (kliknite za sortiranje po)';


$lngstr['button_signin'] = 'Ulaz';
$lngstr['button_signin_as_guest'] = 'Uði kao gost';
$lngstr['button_register'] = 'Registracija';
$lngstr['button_starttest'] = 'Start test';
$lngstr['button_continue'] = 'Nastavi';
$lngstr['button_showresults'] = 'Nastavi';
$lngstr['button_answer'] = 'Odgovor';
$lngstr['button_submit'] = 'Pošalji';
$lngstr['button_update'] = 'Osvježi';
$lngstr['button_update_and_edit_questions'] = 'Osvježi / Idi na listu pitanja';
$lngstr['button_update_and_create_new_question'] = 'Osvježi / kreiraj novo pitanje';
$lngstr['button_back'] = 'Natrag';
$lngstr['button_cancel'] = 'Odustani';
$lngstr['button_set'] = 'Odredi';
$lngstr['button_import'] = 'Importiraj';

$lngstr['label_pleasespecify'] = '- Odredite -';

$lngstr['label_username'] = 'Korisnik:';
$lngstr['label_password'] = 'Lozinka:';
$lngstr['label_confirmpassword'] = 'Potvrdi lozinku:';
$lngstr['label_newpassword'] = 'Nova lozinka:';
$lngstr['label_email'] = 'Email:';
$lngstr['label_title'] = 'Titula:';
$lngstr['label_firstname'] = 'Ime:';
$lngstr['label_lastname'] = 'Prezime:';
$lngstr['label_middlename'] = 'Nadimak:';

$lngstr['label_address'] = 'Adresa:';
$lngstr['label_city'] = 'Grad:';
$lngstr['label_state'] = 'Država:';
$lngstr['label_zip'] = 'Poštanski broj:';
$lngstr['label_country'] = 'Država:';
$lngstr['label_phone'] = 'Tel:';
$lngstr['label_fax'] = 'Fax:';
$lngstr['label_mobile'] = 'Mobitel:';
$lngstr['label_pager'] = 'Pager:';
$lngstr['label_ipphone'] = 'IP telefon:';
$lngstr['label_webpage'] = 'Web stranica:';
$lngstr['label_icq'] = 'ICQ:';
$lngstr['label_msn'] = 'MSN messenger:';
$lngstr['label_aol'] = 'AOL messenger:';
$lngstr['label_gender'] = 'Spol:';
$lngstr['label_gender_items'] = array(0 => $lngstr['label_pleasespecify'], 1 => 'Muško', 2 => 'Žensko');
$lngstr['label_birthday'] = 'Roðendan:';
$lngstr['label_husbandwife'] = 'Suprug (Supruga):';
$lngstr['label_children'] = 'Djece:';
$lngstr['label_trainer'] = 'Trener:';
$lngstr['label_photo'] = 'Slika:';

$lngstr['label_company'] = 'Tvrtka:';
$lngstr['label_cposition'] = 'Pozicija:';
$lngstr['label_department'] = 'Odjel:';
$lngstr['label_coffice'] = 'Ured:';
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

$lngstr['page_register']['no_username'] = 'Neispravano polje korisnièko ime.<br>';
$lngstr['page_register']['no_email'] = 'Neispravano polje email.<br>';
$lngstr['page_register']['no_password'] = 'Lozinke ne odgovaraju.<br>';
$lngstr['page_register']['no_title'] = 'Neispravano polje titula.<br>';
$lngstr['page_register']['no_firstname'] = 'Neispravano polje ime.<br>';
$lngstr['page_register']['no_lastname'] = 'Neispravano polje prezime.<br>';
$lngstr['page_register']['no_middlename'] = 'Neispravano polje nadimak.<br>';

$lngstr['page_register']['no_address'] = 'Neispravano polje adresa.<br>';
$lngstr['page_register']['no_city'] = 'Neispravano polje grad.<br>';
$lngstr['page_register']['no_state'] = 'Neispravano polje država.<br>';
$lngstr['page_register']['no_zip'] = 'Neispravano polje poštanski broj.<br>';
$lngstr['page_register']['no_country'] = 'Neispravano polje država.<br>';
$lngstr['page_register']['no_phone'] = 'Neispravano polje telefon.<br>';
$lngstr['page_register']['no_fax'] = 'Neispravano polje fax.<br>';
$lngstr['page_register']['no_mobile'] = 'Neispravano polje mobitel.<br>';
$lngstr['page_register']['no_pager'] = 'Neispravano polje pager.<br>';
$lngstr['page_register']['no_ipphone'] = 'Neispravano polje IP telefon.<br>';
$lngstr['page_register']['no_webpage'] = 'Neispravano polje web stranica.<br>';
$lngstr['page_register']['no_icq'] = 'Neispravano polje ICQ messenger.<br>';
$lngstr['page_register']['no_msn'] = 'Neispravano polje MSN messenger.<br>';
$lngstr['page_register']['no_aol'] = 'Neispravano polje AOL messenger.<br>';
$lngstr['page_register']['no_gender'] = 'Neispravano polje Spol.<br>';
$lngstr['page_register']['no_birthday'] = 'Neispravano polje roðendan.<br>';
$lngstr['page_register']['no_husbandwife'] = 'Neispravano polje Suprug (supruga).<br>';
$lngstr['page_register']['no_children'] = 'Neispravano polje djeca.<br>';
$lngstr['page_register']['no_trainer'] = 'Neispravano polje trener.<br>';
$lngstr['page_register']['no_photo'] = 'Neispravano polje Slika.<br>';

$lngstr['page_register']['no_company'] = 'Neispravano polje tvrtka.<br>';
$lngstr['page_register']['no_cposition'] = 'Neispravano polje pozicija.<br>';
$lngstr['page_register']['no_department'] = 'Neispravano polje odjel.<br>';
$lngstr['page_register']['no_coffice'] = 'Neispravano polje ured.<br>';
$lngstr['page_register']['no_caddress'] = 'Neispravano polje adresa tvrtke.<br>';
$lngstr['page_register']['no_ccity'] = 'Neispravano polje grad tvrtke.<br>';
$lngstr['page_register']['no_cstate'] = 'Neispravano polje Država tvrtke.<br>';
$lngstr['page_register']['no_czip'] = 'Neispravano polje poštanski broj.<br>';
$lngstr['page_register']['no_ccountry'] = 'Neispravano polje države tvrtke.<br>';
$lngstr['page_register']['no_cphone'] = 'Neispravano polje telefon tvtke.<br>';
$lngstr['page_register']['no_cfax'] = 'Neispravano polje fax tvrtke.<br>';
$lngstr['page_register']['no_cmobile'] = 'Neispravano polje mobitel tvrtke.<br>';
$lngstr['page_register']['no_cpager'] = 'Neispravano polje pager tvrtke.<br>';
$lngstr['page_register']['no_cipphone'] = 'Neispravano polje IP telefon tvrtke.<br>';
$lngstr['page_register']['no_cwebpage'] = 'Neispravano polje web stranic etvrtke.<br>';
$lngstr['page_register']['no_cphoto'] = 'Neispravano polje logo tvrtke.<br>';

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
$lngstr['err_username_duplicate'] = 'Ovo korisnièko ime se veæ koristi. Izaberite neko drugo.<br>';
$lngstr['err_groupname_duplicate'] = 'Ovaj naziv za grupu se veæ koristi. Izaberite neki drugi.<br>';
$lngstr['err_subjectname_duplicate'] = 'Naziv teme se veæ koristi. Izaberite neki drugi.<br>';
$lngstr['err_signin_incorrect']  = 'Nemožete se ulogirati. Korisnièko ime i lozinka su neispravni.<br>';

// Register page:
$lngstr['page-register']['intro'] = 'Možete korsititi ovu formu za dodavanje korisnièkog raèuna.';
$lngstr['page-register']['successful'] = 'Korisnik "%s" je uspješno dodan.';
$lngstr['page-register']['check_activation_email'] = 'Email je sposlan na vašu adresu. Sadži upute za završetak registracije.';
$lngstr['page-register']['account_activated'] = 'Vaš korisnièki raèun je aktiviran.';
$lngstr['page-register']['title_items'] = array('' => $lngstr['label_none'], 'Dr.' => 'Dr.', 'Miss' => 'Miss', 'Mr.' => 'Mr.', 'Mrs.' => 'Mrs.', 'Ms.' => 'Ms.', 'Prof.' => 'Prof.', 'Rev.' => 'Rev.');
$lngstr['page_register']['required_mark'] = REQUIRED_FIELD_MARK.' = Oznaèava obavezna polja';

// Sign in page:
$lngstr['page_signin_box_signin_intro'] = '<b>Login</b>';
$lngstr['page_signin_box_signin'] = $lngstr['label_username'];
$lngstr['page_signin_box_password'] = $lngstr['label_password'];
$lngstr['page_signin_box_register_intro'] = '<b>Nema korisnièki raèun?</b> Možete se registrirati <a href="register.php">klikom na ovaj link</a>.';
$lngstr['page_signin_box_lostpassword_intro'] = '<b>Zaboravili ste lozinku?</b> Ako ste <a href="lostpassword.php">zaboravili lozinku</a>, poslat æemo vam novu.';

// Forgot password page:
$lngstr['page_lostpassword_enter_username'] = '<b>Unesite vaše korisnièko ime</b>';
$lngstr['button_send_new_password'] = 'Pošaljite novu lozinku';
$lngstr['err_username_not_found'] = 'Korisnièko ime nije pronaðeno! Pokušajte ponovo.';
$lngstr['inf_password_reset'] = 'Vaša lozinka je resetirana! Provjerite email.';

// Take a test page:
$lngstr['page_panel_hdr_test'] = 'Test';
$lngstr['page_panel_hdr_test_hint'] = 'Natziv testa i opis';
$lngstr['page_panel_hdr_teststatus'] = 'Status';
$lngstr['page_panel_hdr_teststatus_hint'] = 'Status testa';
$lngstr['page_panel_hdr_gettest'] = 'Riješi Test';
$lngstr['page_panel_hdr_gettest_hint'] = 'Riješi test';
$lngstr['page_panel_status_available'] = 'Dostupan';
$lngstr['page_panel_status_will_be_available_on'] = 'Bit æe dostupan za <br>%s';
$lngstr['page_panel_get_test_link'] = 'Test';
$lngstr['page-takeatest']['attempts_left'] = 'Dostšan<br>(dopušteno pokušaja: %d)';
$lngstr['page-takeatest']['attempts_limit_reached'] = 'Nije dostupan<br>(pokušaja allowed: 0)';
$lngstr['page-takeatest']['passed'] = 'Zavšen';
$lngstr['page_test_results'] = 'Rezultati testa';
$lngstr['page_test_results_homepage'] = 'Povratak na RIJEŠI TEST stranicu';
$lngstr['page_test_results_viewresults'] = 'Pregledajte rezultate testa';
$lngstr['page_test']['results_nexttest'] = 'Nastavi';

$lngstr['page_results_delete_record'] = 'Izbriši podatak';
$lngstr['page_edittests_delete_test'] = 'Izbriši test';
$lngstr['page_edittests_delete_question'] = 'Izbriši pitanje';
$lngstr['page_edittests_delete_question_link'] = 'Izbriši pitanje';
$lngstr['page_managegroups_delete_group'] = 'Izbriši grupu';
$lngstr['page_subjects_delete_subject'] = 'Izbriši temu';
$lngstr['page_manageusers_delete_user'] = 'Izbriši korisnika';
$lngstr['page_etemplates_delete_etemplate'] = 'Izbriši email predložak';
$lngstr['page-rtemplates']['delete_rtemplate'] = 'Izbriši predložak izvještaja';
$lngstr['page_grades_delete_grade'] = 'Izbriši sistem ocjena';
$lngstr['page_gradescales_delete_grade'] = 'Izbriši ocjenu';
$lngstr['page_visitors_delete_visitor'] = 'Izbriši podatak';
$lngstr['page_visitors']['ipwhois'] = 'Pogledaj ovu IP adresu u WhoIs servisu';

//[CUSTOM] $lngstr['page_testsettings']['test_type'] = 'Tip testa:';
//[CUSTOM] $lngstr['page_testsettings']['test_type_items'] = array(0 => 'Zadani', 1 => 'Anketa');
$lngstr['page_edittests_subjectid'] = 'Tema testa:';
$lngstr['page_edittests_testname'] = 'Naziv testa:';
$lngstr['page_edittests_testenabled'] = 'Ovaj test je aktivan';
$lngstr['page_edittests_teststart'] = 'Datum poèetka testa:';
$lngstr['page_edittests_testend'] = 'Datum završetka testa:';
$lngstr['page_edittests_testtime'] = 'Vrijeme testa:';
$lngstr['page_edittests_testtimeforceout'] = 'Završi ovaj test kad je limit testa prekoraèen';
$lngstr['page-testmanager']['attempts_allowed'] = 'Dopušteno pokušaja:';
$lngstr['page-testmanager']['attempts_allowed_list'] = array(0 => 'Neogranièeno', 1 => '1 attempt', 2 => '2 pokušaja', 3 => '3 pokušaja', 4 => '4 pokušaja', 5 => '5 pokušaja', 6 => '6 pokušaja', 7 => '7 pokušaja', 8 => '8 pokušaja', 9 => '9 pokušaja', 10 => '10 pokušaja', 11 => '11 pokušaja', 12 => '12 pokušaja', 13 => '13 pokušaja', 14 => '14 pokušaja', 15 => '15 pokušaja', 16 => '16 pokušaja', 17 => '17 pokušaja', 18 => '18 pokušaja', 19 => '19 pokušaja', 20 => '20 pokušaja');
$lngstr['page_edittests_showquestions'] = 'Prikaži pitanja:';
$lngstr['page_testmanager']['showquestions_items'] = array(1 => 'Jedan po jedan', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '6', 7 => '7', 8 => '8', 9 => '9', 10 => '10', 0 => 'Sva pitanja');
$lngstr['page_edittests_shuffle'] = 'Opcije redoslijeda:';
$lngstr['page_edittests_shuffleq'] = 'Mjenjaj redoslijed pitanja';
$lngstr['page_edittests_shufflea'] = 'Mjenja redolsijed odgvora';
$lngstr['page_edittests_gradingsystem'] = 'Sistem ocjenjivanja:';
// $lngstr['label_no_gradingsystem'] = 'ne koristi';
$lngstr['page_edittests_resultsettings'] = 'Izvještaj rezultata testa:';
$lngstr['page_edittests_result_showqfeedback'] = 'Prikaži povratnu informaciju';
$lngstr['page_edittests_result_showgrade'] = 'Prikaži ocjenu';
$lngstr['page_edittests_result_showanswers'] = 'Prikaži odgvore';
$lngstr['page_edittests_result_showpoints'] = 'Prikaži bodove';
$lngstr['page_testsettings']['custom_report'] = 'Koristi prilagoðene predloške:';
$lngstr['page_edittests_testdescription'] = 'Kratki opis:';
$lngstr['page_edittests_testinstructions'] = 'Upute za test:';
$lngstr['page_edittests_testnotes'] = 'Bilješke za test (interne bilješke):';
$lngstr['page_edittests_assignedto'] = 'Pridruženo:';
// $lngstr['page_edittests_assignedto_everybody'] = 'Svi';
// $lngstr['page_edittests_assignedto_nobody'] = 'Nitko';
$lngstr['page_edittests_assignto_everybody'] = 'Pridruženo svima (nadilazi sve postavke)';
$lngstr['page_edittests_advancedreport'] = 'Napredni izvještaj:';
// $lngstr['page-testsettings']['no_report'] = 'Nema izvještaja';
$lngstr['page-testsettings']['report_template'] = 'Predložak:';
$lngstr['page-testsettings']['report_grade_condition'] = 'Uvijeti ocjena:';
$lngstr['page-testsettings']['no_condition'] = 'Nema uvijeta';
// $lngstr['label_no_advanced_report'] = 'Nema naprednih izvještaja';
$lngstr['page_edittests_advancedreport_showpdf'] = 'Prikaži PDF izvještaj za printanje';
$lngstr['page_edittests_sendresultsbyemail'] = 'Pošalji rezultate na email:';
$lngstr['page_edittests_sendresultsbyemail_template'] = 'Predložak:';
$lngstr['page_edittests_sendresultsbyemail_to'] = 'Email:';
$lngstr['page_edittests_result_emailtouser'] = 'pošalji rezultate korisnicima';
$lngstr['label_do_not_send_email'] = 'Ne šalji';
$lngstr['page-testmanager']['prevtest'] = 'Test prije:';
$lngstr['page-testmanager']['nexttest'] = 'test poslije:';

$lngstr['page_testmanager']['view_test_stats'] = 'Vidi statistike testa';

$lngstr['page_assignto_hdr_assignto'] = 'Pridružen';
$lngstr['page_assignto_hdr_assignto_hint'] = 'Pridružen';

$lngstr['page_testmanager_import']['document_label'] = 'Importiraj ovaj dokument:';
$lngstr['page_testmanager_import']['document_howto'] = '';
$lngstr['page_importtest_ut_import_document'] = 'Import dokumenta iz UniTest Systema:';
$lngstr['page_importtest_ut_import_document_hint'] = 'Zalijepi UniTest System\'s Import dokument ovdje';
$lngstr['page_importtest_ut_import_document_howto'] = '1. Pokrenite Editor module  UniTest Systema;<br>2. Oznaèite Import Dokument iz File -> Export menu;<br>3. Kopiraj (koristeæi clipboard) i zalijepi u ovaj text box.';
$lngstr['page_testmanager_import']['section_delimiters'] = 'Prefixes (klikni prikaži/sakri)';
$lngstr['page_testmanager_import']['question_delimiter'] = 'Pitanje prefix:';
$lngstr['page_testmanager_import']['answer_delimiter'] = 'Izbor prefix:';
$lngstr['page_testmanager_import']['answer2_delimiter'] = 'Izbor prefix (za kolonu 2):';
$lngstr['page_testmanager_import']['preq_delimiter'] = 'Upute za pitanje prefix:';
$lngstr['page_testmanager_import']['postq_delimiter'] = 'Obajašnjenje pitanja prefix:';
$lngstr['page_testmanager_import']['correct_delimiter'] = 'Ispravan odgvor prefix:';
$lngstr['page_testmanager_import']['points_delimiter'] = 'Bod prefix:';
$lngstr['page_testmanager_import']['type_delimiter'] = 'Tip pitanja prefix:';
$lngstr['page_testmanager_import']['subject_delimiter'] = 'Tema pitanja prefix:';

$lngstr['page_testmanager_stats']['all_participants'] = 'Statistike: svi korisnici';
$lngstr['page_testmanager_stats']['hdr_test_data'] = 'Podatci testa';
$lngstr['page_testmanager_stats']['hdr_test_data_hint'] = 'Podatci testa';
$lngstr['page_testmanager_stats']['hdr_points'] = 'Bodova';
$lngstr['page_testmanager_stats']['hdr_points_hint'] = 'Bodova';
$lngstr['page_testmanager_stats']['hdr_percents'] = $lngstr['label_questionstats_hdr_answerpercent'];
$lngstr['page_testmanager_stats']['hdr_percents_hint'] = $lngstr['label_questionstats_hdr_answerpercent_hint'];
$lngstr['page_testmanager_stats']['test_high_score'] = 'Najveæi rezultat testa:';
$lngstr['page_testmanager_stats']['test_average_score'] = 'Prosjek testa:';
$lngstr['page_testmanager_stats']['test_low_score'] = 'Najmanj rezultat:';
$lngstr['page_testmanager_stats']['test_std_deviation'] = 'Standardna odstupanja:';
$lngstr['page_testmanager_stats']['test_variance'] = 'Odstupanje:';
$lngstr['page_testmanager_stats']['hdr_grade_data'] = 'Ocjene';
$lngstr['page_testmanager_stats']['hdr_grade_data_hint'] = 'Ocjene';
$lngstr['page_testmanager_stats']['hdr_grade_responses'] = 'Odgovori';
$lngstr['page_testmanager_stats']['hdr_grade_responses_hint'] = 'Odgovori';
$lngstr['page_testmanager_stats']['total_responses'] = 'Ukupno odgovora:';
$lngstr['page_testmanager_stats']['this_participant'] = 'Statistike: ovaj korisnik';
$lngstr['page_testmanager_stats']['hdr_subject_name'] = 'Naziv skupine';
$lngstr['page_testmanager_stats']['hdr_subject_name_hint'] = 'Naziv skupine';
$lngstr['page_testmanager_stats']['hdr_subject_questions'] = 'Velièina';
$lngstr['page_testmanager_stats']['hdr_subject_questions_hint'] = 'Velièina skupe';
$lngstr['page_testmanager_stats']['hdr_subject_questions_got'] = 'Pitanja';
$lngstr['page_testmanager_stats']['hdr_subject_questions_got_hint'] = 'Pitanja iz ove skupine';
$lngstr['page_testmanager_stats']['hdr_subject_correct'] = 'Ispravno';
$lngstr['page_testmanager_stats']['hdr_subject_correct_hint'] = 'Ipravni odgovori';
$lngstr['page_testmanager_stats']['view_results_stats'] = 'Vidi statistike';

$lngstr['label_subjects_edit'] = 'Upravljaj temama';
// Subjects page:
$lngstr['label_action_create_subject'] = 'Kreiraj novu temu';
$lngstr['page_subjects_subjectid'] = 'ID Teme:';
$lngstr['page_subjects_subjectname'] = 'Naziv teme:';
$lngstr['page_subjects_subjectdescription'] = 'Opis teme:';

// Grades page:
$lngstr['label_action_create_grade'] = 'Kreiraj noci sistem ocjena';
$lngstr['label_action_create_gradescale'] = 'Kreiraj novu ocjenu';
$lngstr['page_grades_gscaleid'] = 'ID Sistema ocjena:';
$lngstr['page_grades_gradename'] = 'Naziv sistema ocjena:';
$lngstr['page_grades_gradedescription'] = 'Opis sistema ocjena:';
$lngstr['page_grades_gradescale'] = 'Raspon ocjena:';
$lngstr['page_grades_gradescale_text'] = 'Editiraj Raspon ocjena';
$lngstr['page_grades']['edit_grade'] = 'Editiraj ovu Ocjenu';
$lngstr['label_action_grade_moveup'] = 'Pomakni gore';
$lngstr['label_action_grade_movedown'] = 'Pomakni dolje';
$lngstr['page_grade_gscaleid'] = 'ID Ocjene:';
$lngstr['page_grade_gradename'] = 'Naziv ocjene:';
$lngstr['page_grade_gradedescription'] = 'Opis ocjene:';
$lngstr['page_grade']['feedback'] = 'Povratna informacija ocjene:';
$lngstr['page_grade']['section_advanced'] = 'napredno (klikni za  prikaži/sakri)';
$lngstr['page_grade_gradefrom'] = 'Minimum (%):';
$lngstr['page_grade_gradeto'] = 'Maximum (%):';

// Question statistics page:
$lngstr['page_questionstats_correct_count'] = 'Ispravnih odgovora:';
$lngstr['page_questionstats_partially_count'] = 'Djelomièno ispravnih odgovora:';
$lngstr['page_questionstats_incorrect_count'] = 'Neispravnih odgvora:';
$lngstr['page_questionstats_undefined_count'] = 'Nedefiniranih odgovora:';
$lngstr['page_questionstats_fillintheblank_others'] = 'Ostalo (%d)';
$lngstr['page_editquestion_subjectid'] = 'Tema pitanja:';
$lngstr['page_editquestion_type'] = 'Tip pitanja:';
$lngstr['page_editquestion_question_text'] = 'Pitanje:';
$lngstr['page_editquestion_question_name'] = 'Naziv pitanja:';
$lngstr['page_editquestion_answer_count'] = 'Broj odgovora:';
$lngstr['page_editquestion_answers'] = 'Odgovori:';
$lngstr['page_editquestion_time'] = 'Vrijeme:';
$lngstr['page_editquestion_points'] = 'Vrijednost boda:';
$lngstr['page_editquestion']['shuffle_answers'] = 'Mjenjaj redoslijed odgvora:';
$lngstr['page_editquestion']['shuffle_answers_items'] = array(0 => 'Zadani (naslijedi)', 1 => 'Ne mjenjaj', 2 => 'Mjenjaj', 3 => 'Mjenjaj (osim prvoga)', 4 => 'Mjenjaj (osim zadnjeg)');
$lngstr['page_editquestion_emptyquestion'] = '<p><strong>Upišite vaše pitanje ovdje...</strong></p>';

$lngstr['label_action_visitors_view'] = 'Vidi detalje za ovaj podatak';
$lngstr['page_visitordetails_visitorid'] = 'ID posjetitelja:';
$lngstr['page_visitordetails_startdate'] = 'Datum poèetka:';
$lngstr['page_visitordetails_enddate'] = 'Datum završetka:';
$lngstr['page_visitordetails_timespent'] = 'Utrošeno vrijeme:';
$lngstr['page_visitordetails_username'] = $lngstr['label_username'];
$lngstr['page_visitordetails_ipaddress'] = 'IP-adresa:';
$lngstr['page_visitordetails_host'] = 'Host:';
$lngstr['page_visitordetails_referer'] = 'Referer:';
$lngstr['page_visitordetails_inurl'] = 'Ulazna stranica:';
$lngstr['page_visitordetails_outurl'] = 'Izlazna stranica:';
$lngstr['page_visitordetails_hits'] = 'Hitova:';
$lngstr['page_visitordetails_useragent'] = 'Korisnièki preglednik:';

$lngstr['page_config']['section_site'] = 'Web stranice (klikni za prikaži/sakri)';
$lngstr['page_config']['text_editor'] = 'WYSIWYG editor:';
$lngstr['page_config']['text_editorlist'] = array(CONFIG_CONST_iseditor2 => 'Zadani editor', CONFIG_CONST_iseditor => 'Zadani editor (stari)', CONFIG_CONST_htmlareaeditor => 'HTMLArea editor');
$lngstr['page_config']['list_length'] = 'Dužina liste:';
$lngstr['page_config']['store_logs'] = 'Web statistike:';
$lngstr['page_config']['section_registration'] = 'Registracija (klikni za prikaži/sakri)';
$lngstr['page_config']['can_register'] = 'Dopusti registraciju korisnika:';
$lngstr['page_config']['upon_registration'] = 'Kod registracije:';
$lngstr['page_config']['upon_registration_select'] = array(0 => 'Aktiviraj', 1 => 'Aktiviraj, logiraj automatski', 2 => 'Nemoj aktivirat, pošalji aktivacijski link emailom', 3 => 'Ne aktiviraj, koristi prilagoðenu shemu (pr. naplata)');
$lngstr['page_config']['reg_intro'] = 'Uvod:';
$lngstr['page_config']['donotshow'] = 'Ne prikazuj';
$lngstr['page_config']['donotshow_autogenerate'] = 'ne prikazuj, auto generiraj';
$lngstr['page_config']['show_donotrequire'] = 'Prikaži, ne obavezuj';
$lngstr['page_config']['show_autogenerate'] = 'Prikaži, auto generiraj';
$lngstr['page_config']['show_require'] = 'Prikaži, obaveži';

$lngstr['page_users']['username'] = $lngstr['label_username'];
$lngstr['page_users']['password'] = $lngstr['label_password'];
$lngstr['page_users']['email'] = $lngstr['label_email'];
$lngstr['page_users']['title'] = $lngstr['label_title'];
$lngstr['page_users']['firstname'] = $lngstr['label_firstname'];
$lngstr['page_users']['lastname'] = $lngstr['label_lastname'];
$lngstr['page_users']['middlename'] = $lngstr['label_middlename'];

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

$lngstr['page_users']['section_personal'] = 'Osobne informacije (klikni za prikaži/sakrij)';
$lngstr['page_users']['section_work'] = 'Poslovne informacije (klikni za prikaži/sakrij)';
$lngstr['page_users']['section_additional'] = 'Dodatne informacije (klikni za prikaži/sakrij)';

$lngstr['page_users']['userenabled'] = 'Ovaj korisnik je aktivan';
$lngstr['page_users']['joindate'] = 'Datum upisa:';
$lngstr['page_users']['logindate'] = 'Datum zadnjeg pristupa:';
$lngstr['page_users']['expiredate'] = 'Datum isteka:';
$lngstr['page_users']['password_confirm'] = $lngstr['label_confirmpassword'];
$lngstr['page_users']['password_new'] = $lngstr['label_newpassword'];
$lngstr['page_users']['section_notes'] = 'Bilješke (click to show/hide)';
$lngstr['page_users']['notes'] = 'Korisnièke biljške (za internu upotrebu):';

$lngstr['page_reportsmanager']['answerfeedback'] = 'Povratna informacija:';
$lngstr['page_reportsmanager']['view_pdf'] = 'Vidi PDF za printanje';

$lngstr['page_managegroups_groupid'] = 'ID Grupe:';
$lngstr['page_managegroups_groupname'] = 'Naziv grupe:';
$lngstr['page_managegroups_groupdescription'] = 'Opis grupe:';
$lngstr['page_groups_access_rights'] = 'Prava pristupa:';
$lngstr['page_groups_access_tests'] = 'Testovi:';
$lngstr['page_groups_access_tests_select'] = array(0 => "Pristup zabranjen", 1 => "Vidi listu testova", 2 => "Riješava");
$lngstr['page_groups_access_testmanager'] = 'Upravljaè testovima:';
$lngstr['page_groups_access_testmanager_select'] = array(0 => "Pristup zabranjen", 1 => "Èita", 2 => "Piše");
$lngstr['page_groups_access_gradingsystems'] = 'Sistem ocjena:';
$lngstr['page_groups_access_gradingsystems_select'] = $lngstr['page_groups_access_testmanager_select'];
$lngstr['page_groups_access_emailtemplates'] = 'Email predlošci:';
$lngstr['page_groups_access_emailtemplates_select'] = $lngstr['page_groups_access_testmanager_select'];
$lngstr['page_groups_access_reporttemplates'] = 'Predlošci izvještaja:';
$lngstr['page_groups_access_reporttemplates_select'] = $lngstr['page_groups_access_testmanager_select'];
$lngstr['page_groups_access_reportsmanager'] = 'Upravljanje izvještajima:';
$lngstr['page_groups_access_reportsmanager_select'] = array(0 => "Access denied", 1 => "Read (own results)", 2 => "Read (all results)", 3 => "Write");
$lngstr['page_groups_access_questionbank'] = 'Baz apitanja:';
$lngstr['page_groups_access_questionbank_select'] = $lngstr['page_groups_access_testmanager_select'];
$lngstr['page_groups_access_subjects'] = 'Teme:';
$lngstr['page_groups_access_subjects_select'] = $lngstr['page_groups_access_testmanager_select'];
$lngstr['page_groups_access_groups'] = 'Grupe:';
$lngstr['page_groups_access_groups_select'] = $lngstr['page_groups_access_testmanager_select'];
$lngstr['page_groups_access_users'] = 'Korisnici:';
$lngstr['page_groups_access_users_select'] = $lngstr['page_groups_access_testmanager_select'];
$lngstr['page_groups_access_visitors'] = 'Web statistike:';
$lngstr['page_groups_access_visitors_select'] = $lngstr['page_groups_access_testmanager_select'];
$lngstr['page_groups_access_config'] = 'Konfiguracija:';
$lngstr['page_groups_access_config_select'] = $lngstr['page_groups_access_testmanager_select'];

$lngstr['page_etemplates_etemplateid'] = 'ID Predloška:';
$lngstr['page_etemplates_etemplatename'] = 'Naziv predloška:';
$lngstr['page_etemplates_etemplatedescription'] = 'Opis predloška:';
$lngstr['page_etemplates_etemplatefrom'] = 'Od(email):';
$lngstr['page_etemplates_etemplatesubject'] = 'Email naslov:';
$lngstr['page_etemplates_etemplatebody'] = 'Email poruka:';
$lngstr['page_etemplates_template_tags'] = 'Tagovi predloška';

$lngstr['page-rtemplates']['rtemplateid'] = 'ID Predloška:';
$lngstr['page-rtemplates']['rtemplatename'] = 'Naziv predloška:';
$lngstr['page-rtemplates']['rtemplatedescription'] = 'Opis predloška:';
$lngstr['page-rtemplates']['rtemplatebody'] = 'Tijelo izvještaja:';

$lngstr['email_answer_iscorrect'] = 'Ispravno: ';
$lngstr['email_answer_points'] = 'Bodova: ';

$lngstr['err_subject_doesnotexist'] = 'Ova tema ne postoji.<br>';

$lngstr['err_no_questions'] = 'Nema pitanja u testu.<br>';
$lngstr['err_no_questions_left_in_bank'] = 'Broj razlièitih pitanja potrebnih je veæi nego ova tema sadržava.<br>';
$lngstr['err_no_tests'] = 'Trenutno nema testova dostupnih za riješavanje.<br>';
$lngstr['inf_cant_passtest'] = 'Nemate dovoljna prava da bi riješavali ovaj test.<br>';
$lngstr['inf_cant_view_results'] = 'Nemate dovoljna prava d bi vidjeli rezultate testa.<br>';
$lngstr['inf_cant_view_this_test_details'] = 'Nemate dovoljna prava d bi vidjeli rezultate testa.<br>';
$lngstr['inf_cant_edit_tests'] = 'Nemate dovoljno prava da bi editirali testove.<br>';
$lngstr['inf_cant_edit_questions'] = 'Nemate dovoljno prava da bi editirali pitanja.<br>';
$lngstr['inf_cant_access_groups'] = 'Nemate dovoljno prava da bi pristupili grupama.<br>';
$lngstr['inf_cant_access_users'] = 'Nemate dovoljno prava da bi pristupili korisnicima.<br>';
$lngstr['inf_cant_access_subjects'] = 'Nemate dovoljno prava da bi to pristupili temama.<br>';
$lngstr['inf_cant_access_emailtemplates'] = 'Nemate dovoljno prava da bi pristupili email predlošcima.<br>';
$lngstr['inf_cant_access_reporttemplates'] = 'Nemate dovoljno prava da bi pristupili predlošcima izvještaja.<br>';
$lngstr['inf_cant_access_grades'] = 'Nemate dovoljno prava da bi pristupili sistemu ocjena.<br>';
$lngstr['inf_cant_access_visitors'] = 'Nemate dovoljno prava da bi pristupili web statistikama.<br>';
$lngstr['inf_cant_access_config'] = 'Nemate dovoljno prava da bi pristupili konfiguraciji sistema.<br>';
$lngstr['err_no_test_selected'] = 'Molimo oznaèite test prvo.<br>';
$lngstr['err_no_question_n_in_db'] = 'Pitanje %d nemožemo pronaæi.<br>';
$lngstr['err_no_question_id_in_db'] = 'ID pitanja %d nemožemo pronaæi.<br>';
$lngstr['err_no_answers_in_question'] = '<b><a href="question-bank.php?action=editq&questionid=%1$d">ID Pitanja %1$d</a></b> nema odgovora. Poravite ga.<br>';
$lngstr['err_no_answer_given'] = 'nema datog odgovora.<br>';
$lngstr['err_answer_every_question'] = 'Molimo odgovorite sva pitanja.<br>';

$lngstr['err_no_permissions_to_register'] = 'Nemate moguænosti registrirati nove korisnike';

$lngstr['qst_delete_test'] = 'Jeste li sigurni da želite izbrisati ovaj test?';
$lngstr['qst_delete_tests'] = 'Jeste li sigurni da želite izbrisati oznaèene testove?';
$lngstr['qst_delete_question'] = 'Jeste li sigurni da želite izbrisati ovo pitanje?';
$lngstr['qst_delete_questions'] = 'Jeste li sigurni da želite izbrisati oznaèena pitanja?';
$lngstr['qst_delete_question_link'] = 'Jeste li sigurni da želite izbaciti ovo pitanje iz testa?';
$lngstr['qst_delete_question_links'] = 'Jeste li sigurni da želite izbaciti ova pitanja iz testa?';
$lngstr['qst_delete_record'] = 'Jeste li sigurni da želite izbrisati ovaj podatak?';
$lngstr['qst_delete_records'] = 'Jeste li sigurni da želite izbrisati oznaèene podatke?';
$lngstr['qst_delete_user'] = 'Jeste li sigurni da želite izbrisati ovog korisnika?';
$lngstr['qst_delete_users'] = 'Jeste li sigurni da želite izbrisati oznaèene korisnike?';
$lngstr['qst_delete_group'] = 'Jeste li sigurni da želite izbrisati ovu grupu?';
$lngstr['qst_delete_groups'] = 'Jeste li sigurni da želite izbrisati oznaèene grupe?';
$lngstr['qst_delete_subject'] = 'Jeste li sigurni da želite izbrisati ovu temu?';
$lngstr['qst_delete_subjects'] = 'Jeste li sigurni da želite izbrisati oznaèene teme?';
$lngstr['qst_delete_etemplate'] = 'Jeste li sigurni da želite izbrisati ovaj email predložak?';
$lngstr['qst_delete_etemplates'] = 'Jeste li sigurni da želite izbrisati oznaèene email predloške?';
$lngstr['qst_delete_grade'] = 'Jeste li sigurni da želite izbrisati ovaj sistem ocjenjivanja?';
$lngstr['qst_delete_grades'] = 'Jeste li sigurni da želite izbrisati oznaèene sisteme ocjenjivanja?';
$lngstr['qst_delete_gradescale'] = 'Jeste li sigurni da želite izbrisati ovu ocjenu?';
$lngstr['qst_delete_gradescales'] = 'Jeste li sigurni da želite izbrisati oznaèene ocjene?';
$lngstr['qst_delete_visitor'] = $lngstr['qst_delete_record'];
$lngstr['qst_delete_visitors'] = $lngstr['qst_delete_records'];
$lngstr['page-sections']['qst_section_delete'] = 'Jeste li sigurni da želite izbrisati ovu sekciju?';
$lngstr['page-sections']['qst_sections_delete'] = 'Jeste li sigurni da želite izbrisati oznaèene sekcije?';
$lngstr['page-rtemplates']['qst_rtemplate_delete'] = 'Jeste li sigurni da želite izbrisati ovaj predložak izvještaja?';
$lngstr['page-rtemplates']['qst_rtemplates_delete'] = 'Jeste li sigurni da želite izbrisati oznaèene predloške izvještaja?';

// Install:
$lngstr['install_title'] = 'Instaliraj - iGiveTest';
$lngstr['install_page1'] = 'Korak 1 - Postavke jezika';
$lngstr['install_page1_description'] = '<p><b>Jezik:</b> Izaberite jezik.';
$lngstr['install_language'] = 'jezik:';
$lngstr['install_page2'] = 'Korak 2 - Generalne postavke';
$lngstr['install_page2_description'] = '<p><b>Naziv web stranica:</b> Upišite nazvi web stranica.
<p><b>Glavni email:</b> Oznaèite zadanu email adresu "From" za email poruke.
<p><b>iGiveTest URL:</b> Upišite web adresu za iGiveTest.
<p><b>iGiveTest direktorij:</b> Upišite punu stazu direktorija za ovu instalaciju.
<p><b>iGiveTest URL dokumenata:</b> Upišite web adresu gdje æe biti omoguæen prsstup transferiranim dokumentima.
<p><b>iGiveTest direktorij dokumenata:</b> Upišite punu stazu direktorija  gdje iGiveTest može snimiti transferirane dokumente. Ovaj direktorij mora biti sa  read i write permisijama za korisnika web servera (inaèe "nobody" ili "apache").';
$lngstr['install_titlepostfix'] = 'Naziv web stranica:';
$lngstr['install_defaultemail'] = 'Glavni email:';
$lngstr['install_urlroot'] = 'iGiveTest URL:';
$lngstr['install_dirrootfull'] = 'iGiveTest direktorij:';
$lngstr['install_dirrootfull_doesnotexists'] = '"iGiveTest dirketorij" su neispravne. Vrijednost ispod je resetirana.<br>';
$lngstr['install_urlfiles'] = 'iGiveTest URL dokumenata:';
$lngstr['install_dirfilesfull'] = 'iGiveTest direktorij dokumenata:';
$lngstr['install_page3'] = 'Korak 3 - Postavke baze podataka';
$lngstr['install_page3_description'] = '<p>Konfigurirajte bazu podataka gdje iGiveTest æe biti spremljeni. Baza podataka mora biti unaprijed kreirana i korisnièko ime i lozinka za pristup istoj.';
$lngstr['install_dbdriver'] = 'Tip baz epodataka:';
$lngstr['install_dbhost'] = 'Poslužitelj baze podataka:';
$lngstr['install_dbdb'] = 'Naziv baze podataka:';
$lngstr['install_dbtableprefix'] = 'Prefix tablica:';
$lngstr['install_dbuser'] = 'Korisnik baze podataka:';
$lngstr['install_dbpassword'] = 'lozinak baze podataka:';
$lngstr['install_dbdriver_cannotconnect'] = 'Ne mogu se posjiti na bazu koju ste zadali. Provjerite postavke baze podataka.<br>';
$lngstr['install_cannotwritetoconfig'] = 'Ne mogu pisatu u inc/confic.inc.php';
$lngstr['install_downloadconfig'] = '<p>Snimite <b><a href="install.php?download=1" target=_blank>ovaj dokument</a></b>, nazovite ga config.inc.php i transferirajte u  inc/ direktorij.';
$lngstr['install_canwritetoconfig'] = '<p>config.inc.php je uspješno kreiran.';
$lngstr['install_page4'] = 'Instalacija je završena';
$lngstr['install_page4_description'] = '<p>Kliknite "Nastavi" gumb za setup iGiveTest baze podataka.';
$lngstr['install_db_title'] = 'Inicijaliziraj bazu podataka - iGiveTest';
$lngstr['install_db_page1'] = 'Inicijaliziraj iGiveTest bazu podataka';
$lngstr['install_db_createtablex'] = 'Kreiraj "%s" tablice:';
$lngstr['install_db']['no_init_needed'] = 'Inicijalizacija nije potrebna.';

$lngstr['install_adminfirstname'] = 'Admin';
$lngstr['install_adminlastname'] = 'Korisnik';
$lngstr['install_guestfirstname'] = 'Gost';
$lngstr['install_guestlastname'] = 'Korisnik';

$lngstr['install_phpversion'] = 'PHP Verzija:';
$lngstr['label_okay'] = 'OK';
$lngstr['label_warning'] = 'Upozorenje';

$m_db_drivers = array(
	DB_DRIVER_MYSQL => 'MySQL',
	DB_DRIVER_POSTGRESQL => 'PostgreSQL',
	DB_DRIVER_MSSQL_ODBC => 'Microsoft SQL Server (ODBC)',
	DB_DRIVER_MSSQL => 'Microsoft SQL Server (PHP)',
	DB_DRIVER_ORACLE => 'Oracle',
	);

$lngstr['initdb_etemplates_1_name'] = 'rezultati testa (Zadano)';
$lngstr['initdb_etemplates_1_description'] = 'Email predložak rezultata testa (zadano)';
$lngstr['initdb_etemplates_1_subject'] = 'iGiveTest - Primjer izvještaja';
$lngstr['initdb_etemplates_1_body'] = 'Poštovanje [USER_FIRST_NAME],

Ovdje su rezultati vašeg testa:

Naziv testa: [TEST_NAME]
Datum: [RESULT_DATE]
Vrijeme utrošeno: [RESULT_TIME_SPENT]
Vrijeme prekoraèeno: [RESULT_TIME_EXCEEDED]

[RESULT_DETAILED_1]

Ukupni rezultat: [RESULT_POINTS_SCORED] / [RESULT_POINTS_POSSIBLE] ([RESULT_PERCENTS]%)
Ocjena: [RESULT_GRADE]

Pozdrav,
iGiveTest Team';

$lngstr['initdb_etemplates_2_name'] = 'Registracija korisnika (Bez email aktivacije)';
$lngstr['initdb_etemplates_2_description'] = 'Email predložak registracije korisnika';
$lngstr['initdb_etemplates_2_subject'] = 'iGiveTest.com - Detalji registracije';
$lngstr['initdb_etemplates_2_body'] = 'Poštovanje [USER_FIRST_NAME],

Hvala vam za registraciju sa iGiveTest.

Korisnièko ime: [USERNAME]
Lozinka: [USER_PASSWORD]

Možete se logirati kad god želite ako posjetite:

[IGIVETEST_URL]

Pozdrav,
iGiveTest Team';

$lngstr['initdb_etemplates_3_name'] = 'Registracija korisnika (Bez email aktivacije)';
$lngstr['initdb_etemplates_3_description'] = 'Email predložak registracije korisnika';
$lngstr['initdb_etemplates_3_subject'] = 'iGiveTest.com - Detalji registracije';
$lngstr['initdb_etemplates_3_body'] = 'Poštovanje [USER_FIRST_NAME],

Hvala vam za registraciju sa iGiveTest.

Korisnièko ime: [USERNAME]
Lozinka: [USER_PASSWORD]

Još samo jedan korak:

Da bi završili aktivaciju vašeg raèuna, kliknite slijedeæi link:

[IGIVETEST_URL]/account.php?action=activate&userid=[USER_ID]&checkword=[USER_CHECKWORD]

Pozdrav,
iGiveTest Team';

$lngstr['initdb_etemplates_4_name'] = 'Raèun aktiviran';
$lngstr['initdb_etemplates_4_description'] = 'Email predložak aktivacije raèuna';
$lngstr['initdb_etemplates_4_subject'] = 'iGiveTest.com - Raèun aktiviran';
$lngstr['initdb_etemplates_4_body'] = 'Poštovanje [USER_FIRST_NAME],

Vaš raèun je uspješno aktiviran.

Možete se logirati kad god želite ako posjetite:

[IGIVETEST_URL]

Pozdrav,
iGiveTest Team';

$lngstr['initdb_etemplates_50_name'] = 'Obnavljanje lozinke';
$lngstr['initdb_etemplates_50_description'] = 'Email predložak obnavljanja lozinke';
$lngstr['initdb_etemplates_50_subject'] = 'iGiveTest - Obnavljanje lozinke';
$lngstr['initdb_etemplates_50_body'] = 'Poštovanje [USER_FIRST_NAME],

Resetirali smo vašu lozinku.

Korisnièko ime: [USERNAME]
Nova lozinka: [USER_PASSWORD]

Pozdrav,
iGiveTest Team';

$lngstr['initdb_gscales_1_id'] = 1;
$lngstr['initdb_gscales_2_id'] = 2;
$lngstr['initdb_gscales_3_id'] = 3;
$lngstr['initdb_gscales_4_id'] = 4;
$lngstr['initdb_gscales_5_id'] = 5;
$lngstr['initdb_gscales_6_id'] = 6;
$lngstr['initdb_gscales_1_name'] = 'A-F Raspon ocjena (60% prolazna-ocjena)';
$lngstr['initdb_gscales_2_name'] = 'Prošao/Nije prošao Raspon ocjena';
$lngstr['initdb_gscales_3_name'] = 'ECTS Raspon ocjena';
$lngstr['initdb_gscales_4_name'] = 'GPA Raspon ocjena';
$lngstr['initdb_gscales_5_name'] = '6-bodova Raspon ocjena (Njemaèka)';
$lngstr['initdb_gscales_6_name'] = '5-bodova Raspon ocjena (Centralna i istoèna europa)';
$lngstr['initdb_gscales_1_description'] = 'A-F Raspon ocjena';
$lngstr['initdb_gscales_2_description'] = 'Prošao/Nije prošao Raspon ocjena';
$lngstr['initdb_gscales_3_description'] = 'ECTS (European Credit Transfer System) Raspon ocjena';
$lngstr['initdb_gscales_4_description'] = 'GPA (Grade Point Average) raspon ocjnea';
$lngstr['initdb_gscales_5_description'] = '6-bodova Raspon ocjena u Njemaèkoj';
$lngstr['initdb_gscales_6_description'] = '5-bodova Raspon ocjena u centralnoj i istoènoj europi';
$lngstr['initdb_gscales_1_1_description'] = 'Izvrsno';
$lngstr['initdb_gscales_1_2_description'] = 'Dobro';
$lngstr['initdb_gscales_1_3_description'] = 'Pošetno';
$lngstr['initdb_gscales_1_4_description'] = 'Loše';
$lngstr['initdb_gscales_1_5_description'] = 'Nedovoljno';
$lngstr['initdb_gscales_2_1_name'] = 'Prošao';
$lngstr['initdb_gscales_2_2_name'] = 'Nije prošao';
$lngstr['initdb_gscales_2_1_description'] = 'Prošao';
$lngstr['initdb_gscales_2_2_description'] = 'Niej prošao';
$lngstr['initdb_gscales_3_1_description'] = 'Izvrsno (samo manje pogreške)';
$lngstr['initdb_gscales_3_2_description'] = 'Vrlo dobro (iznad prosjeènog sa nekim greškama)';
$lngstr['initdb_gscales_3_3_description'] = 'Dobro (OK sa malo veæih grešaka)';
$lngstr['initdb_gscales_3_4_description'] = 'Zadovoljavajuæe (dobro sa nekoliko veæih propusta )';
$lngstr['initdb_gscales_3_5_description'] = 'Dovoljno (minimum kriterija)';
$lngstr['initdb_gscales_3_6_description'] = 'Nedovoljno (još malo rada je potrebno za prolaznu ocjenu)';
$lngstr['initdb_gscales_3_7_description'] = 'Nedovljno (poprilièno rada je još potrebno)';
$lngstr['initdb_gscales_4_1_description'] = 'Izvrsno';
$lngstr['initdb_gscales_4_2_description'] = 'Dobro';
$lngstr['initdb_gscales_4_3_description'] = 'Pošteno';
$lngstr['initdb_gscales_4_4_description'] = 'Loše';
$lngstr['initdb_gscales_4_5_description'] = 'Nedovoljno';
$lngstr['initdb_gscales_5_1_description'] = 'Izvrsno';
$lngstr['initdb_gscales_5_2_description'] = 'Dobro';
$lngstr['initdb_gscales_5_3_description'] = 'Zadovoljavajuæe';
$lngstr['initdb_gscales_5_4_description'] = 'Dovoljno';
$lngstr['initdb_gscales_5_5_description'] = 'Nezadovoljavajuæe';
$lngstr['initdb_gscales_5_6_description'] = 'Loše';
$lngstr['initdb_gscales_6_1_description'] = 'Izvrsno';
$lngstr['initdb_gscales_6_2_description'] = 'Dobro';
$lngstr['initdb_gscales_6_3_description'] = 'Zadovoljavajuæe';
$lngstr['initdb_gscales_6_4_description'] = 'Nezadovoljavajuæe';
$lngstr['initdb_gscales_6_5_description'] = 'Lože';
$lngstr['initdb_groups_1_name'] = 'Administratori';
$lngstr['initdb_groups_2_name'] = 'Instruktori';
$lngstr['initdb_groups_3_name'] = 'Operatori';
$lngstr['initdb_groups_19_name'] = 'Korisnici';
$lngstr['initdb_groups_20_name'] = 'Gosti';
$lngstr['initdb_groups_1_description'] = 'Aministratori imaju potpun i neogranièen pristup';
$lngstr['initdb_groups_2_description'] = 'Instruktori imaju veæinu administratorski postavki sa nekim limitima';
$lngstr['initdb_groups_3_description'] = 'Èlanovi u ovoj grupu imaju moguænost kreiranja / Editiranja pitanja';
$lngstr['initdb_groups_19_description'] = 'Korisnici nemogu sluèajno ili namjerno napraviti neke promjene)';
$lngstr['initdb_groups_20_description'] = 'Gosti imaju ista prava kao i korisnici';
$lngstr['initdb_rtemplates_1_name'] = 'Predložak izvještaja #1';
$lngstr['initdb_rtemplates_1_description'] = 'Predložak izvještaja #1';
$lngstr['initdb_rtemplates_1_body'] = '<h1>[TEST_NAME]</h1>
<p><strong>Datum:</strong> [RESULT_DATE]</p>
<p><strong>Prezime:</strong> [USER_FIRST_NAME]<br>
<strong>Ime:</strong> [USER_LAST_NAME]<br>
<strong>Utrošno vrijeme:</strong> [RESULT_TIME_SPENT]<br>
<strong>Bodovi:</strong> [RESULT_POINTS_SCORED] / [RESULT_POINTS_POSSIBLE] ([RESULT_PERCENTS]%)<br>
<strong>Ocjena:</strong> [RESULT_GRADE]</p>
<p><strong>Detalji:</strong><br>[RESULT_DETAILED_1]</p>';
$lngstr['initdb_subjects_1_name'] = '[No subject]';
$lngstr['initdb_subjects_1_description'] = 'Nema naslova';
$lngstr['initdb_users_1_firstname'] = 'Admin';
$lngstr['initdb_users_2_firstname'] = 'Gost';
$lngstr['initdb_users_1_lastname'] = 'Korisnik';
$lngstr['initdb_users_2_lastname'] = 'Korisnik';
$lngstr['initdb_instructions'] = 'Koristite korisnièko ime "<strong>admin</strong>" i lozinku "<strong>admin</strong>" za ulaz.<br><strong>Zapamtite:</strong> preporuèamo mjenjanje lozinke.';
$lngstr['initdb_gotohomepage'] = 'Idi na poèetnu stranicu';

// Tooltips:
$lngstr['tooltip_button'] = 'Prikaži/sakri traku za pomoæ';
$lngstr['tooltip_showbar'] = 'Prikaži traku za pomoæ';
$lngstr['tooltip_closebar'] = 'Sakri traku za pomoæ';
$lngstr['tooltip_tests'] = '<p>Ova stranica namjenjena je za kreiranje i editiranje testova.</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-new.gif" title="'.$lngstr['label_action_create_test'].'"></td><td class=rowone width="100%" colspan=4>Za kreiranje novog testa, kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-gear.gif" title="'.$lngstr['label_action_test_settings'].'"></td><td class=rowone width="100%" colspan=4>Za promjenu postavki testa, kliknite gumb desno od testa.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-groups.gif" title="'.$lngstr['label_action_test_groups_select'].'"></td><td class=rowone width="100%" colspan=4>Za pridruživanje testova odreðenoj grupi korisnika, kliknite gumb desno od  testa ili oznaèite sve potrebne testove koriteæi zastavice lijevo i kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-edit.gif" title="'.$lngstr['label_action_questions_edit'].'"></td><td class=rowone width="100%" colspan=4>Za editiranje pitanja testa, kliknite gumb desno od testa.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['label_action_test_delete'].'"></td><td class=rowone width="100%" colspan=4>Za brisanje testova, kliknite gumb desno od testa ili oznaèite sve potrebne testove koriteæi zastavice lijevo i kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Koristite ove gumbove za navigaciju izmeðu stranica.</td></tr>
</table></p>';
$lngstr['tooltip_gscales'] = '<p>Ova stranica namjenjena je za kreiranje i editiranje sistema ocjena.</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-new.gif" title="'.$lngstr['label_action_create_grade'].'"></td><td class=rowone width="100%" colspan=4>Za kreiranje novog sistema ocjena, kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-gear.gif" title="'.$lngstr['label_action_grade_settings'].'"></td><td class=rowone width="100%" colspan=4>Za promjenu postavki sistema ocjenjivanja, kliknite gumb desno od of the applicable grading system.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-edit.gif" title="'.$lngstr['label_action_gradescales_edit'].'"></td><td class=rowone width="100%" colspan=4>Za editiranje sistema ocjena, kliknite gumb desno od of the grading system.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['label_action_grade_delete'].'"></td><td class=rowone width="100%" colspan=4>Za brisanje sistema ocjena, kliknite gumb desno od sistema ocjena ili oznaèite sistem ocjena koriteæi zastavice lijevo i kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Koristite ove gumbove za navigaciju izmeðu stranica.</td></tr>
</table></p>';
$lngstr['tooltip_gscales_grades'] = '<p>Ova stranica namjenjena je za kreiranje i editiranje raspona ocjena.</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-new.gif" title="'.$lngstr['label_action_create_gradescale'].'"></td><td class=rowone width="100%" colspan=4>Za kreiranje novog grade, kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-edit.gif" title="'.$lngstr['label_action_gradescale_edit'].'"></td><td class=rowone width="100%" colspan=4>Za editiranje a grade, kliknite gumb desno od of the grade.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=10 border=0 src="images/button-up.gif" title="'.$lngstr['label_action_grade_moveup'].'"><br><img width=20 height=10 border=0 src="images/button-down.gif" title="'.$lngstr['label_action_grade_movedown'].'"></td><td class=rowone width="100%" colspan=4>To move a grade up (down) the list, press the top (bottom) part of the button to the right of the grade.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['label_action_gradescale_delete'].'"></td><td class=rowone width="100%" colspan=4>Za brisanje ocjena, kliknite gumb desno od ocjena ili oznaèite ocjene koristeæi zastavice na lijevo i kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Koristite ove gumbove za navigaciju izmeðu stranica.</td></tr>
</table></p>';
$lngstr['tooltip_etemplates'] = '<p>Ova stranica namjenjena je za kreiranje i editiranje email predložaka.</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-new.gif" title="'.$lngstr['label_action_create_etemplate'].'"></td><td class=rowone width="100%" colspan=4>Za kreiranje novog email predloška, kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-edit.gif" title="'.$lngstr['label_action_etemplates_edit'].'"></td><td class=rowone width="100%" colspan=4>Za editiranje email predloška, kliknite gumb desno od of the email template.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['label_action_etemplate_delete'].'"></td><td class=rowone width="100%" colspan=4>Za brisanje email preedložaka, kliknite gumb desno od email predložka ili oznaèi sve email poruke koristeæi zastavice na lijevo kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Koristite ove gumbove za navigaciju izmeðu stranica.</td></tr>
</table></p>';
$lngstr['tooltip_rtemplates'] = '<p>Ova stranica namjenjena je za kreiranje i editiranje predložaka izvještaja.</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-new.gif" title="'.$lngstr['page-rtemplates']['action_create_rtemplate'].'"></td><td class=rowone width="100%" colspan=4>Za kreiranje novog predloška izvješta, kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-edit.gif" title="'.$lngstr['page-rtemplates']['action_rtemplates_edit'].'"></td><td class=rowone width="100%" colspan=4>Za editiranje predloška izvještaja, kliknite gumb desno od of the report template.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['page-rtemplates']['action_rtemplate_delete'].'"></td><td class=rowone width="100%" colspan=4>Za brisanje predložaka izvještaja, kliknite gumb desno od predložaka izvještaja ili oznaèite predloške izvještaja koristeæi zastavice na lijevo i kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Koristite ove gumbove za navigaciju izmeðu stranica.</td></tr>
</table></p>';
$lngstr['tooltip_tests_questions'] = '<p>Ova stranica namjenjena je za kreiranje i editiranje test pitanja.</p>
<p>Tablica pitanja testa:</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-add.gif" title="'.$lngstr['label_action_create_and_add_question'].'"></td><td class=rowone width="100%" colspan=4>Za kreiranje novog question and to add it to a test, kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-import.gif" title="'.$lngstr['label_action_import_questions'].'"></td><td class=rowone width="100%" colspan=4>Za importiranje pitanaj u test, kliknite slijedeæi gumb nha alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-edit.gif" title="'.$lngstr['label_action_questions_edit'].'"></td><td class=rowone width="100%" colspan=4>Za editiranje pitanja, kliknite gumb desno od of the question.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=10 border=0 src="images/button-up.gif" title="'.$lngstr['label_action_question_moveup'].'"><br><img width=20 height=10 border=0 src="images/button-down.gif" title="'.$lngstr['label_action_grade_movedown'].'"></td><td class=rowone width="100%" colspan=4>Za premještanje pitanja gore dolej na listi, kliknite na godni (donji) dio gumba desno od pitanja.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['label_action_question_link_delete'].'"></td><td class=rowone width="100%" colspan=4>Za brisanje pitanja, kliknite gumb desno od pitanja ili oznaèite potrebna pitanja koristeæi zastave na lijevo i kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Koristite ove gumbove za navigaciju izmeðu stranica.</td></tr>
</table></p>
<p>Tablica baze pitanja:</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-new.gif" title="'.$lngstr['label_action_create_question'].'"></td><td class=rowone width="100%" colspan=4>Za kreiranje novog pitanja, kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-plus.gif" title="'.$lngstr['label_action_questions_append'].'"></td><td class=rowone width="100%" colspan=4>Za dodavanje pitanja u test, kliknite gumb desno od pitanja ili oznaèite sva potreban pitanja koristeæi zastavice na lijevo i kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-edit.gif" title="'.$lngstr['label_action_question_edit'].'"></td><td class=rowone width="100%" colspan=4>Za editiranje pitanja, kliknite gumb desno od pitanja.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['label_action_question_delete'].'"></td><td class=rowone width="100%" colspan=4>Za brisanje pitanja, kliknite gumb desno od pitanja ili oznaèite sva pitanja koristeæi zastavice na lijevo i kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Koristite ove gumbove za navigaciju izmeðu stranica.</td></tr>
</table></p>';
$lngstr['tooltip_tests_sections'] = '<p>Ova stranica namjenjena je za kreiranje i editiranje test sekcija.</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-new.gif" title="'.$lngstr['page-sections']['action_section_create'].'"></td><td class=rowone width="100%" colspan=4>Za kreiranje nove sekcije, kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-edit.gif" title="'.$lngstr['page-sections']['action_section_edit'].'"></td><td class=rowone width="100%" colspan=4>Za editiranje sekcije, kliknite gumb desno od of the section.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['page-sections']['action_section_delete'].'"></td><td class=rowone width="100%" colspan=4>Za brisanje sekcija, kliknite gumb desno os sekcije ili oznaèite sekcije koristeæi zastavice na lijevo i kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Koristite ove gumbove za navigaciju izmeðu stranica.</td></tr>
</table></p>';
$lngstr['tooltip_tests_groups'] = '<p>Ova stranica namjenjena je za pridruživanje testova odreðenoj grupi korisnika.</p>
<p>Tablica testova:</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-new.gif" title="'.$lngstr['label_action_create_test'].'"></td><td class=rowone width="100%" colspan=4>Za kreiranje novog test, kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-gear.gif" title="'.$lngstr['label_action_test_settings'].'"></td><td class=rowone width="100%" colspan=4>Za promjenu postavki testa, kliknite gumb desno od testa.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-groups.gif" title="'.$lngstr['label_action_test_groups_select'].'"></td><td class=rowone width="100%" colspan=4>Za pridruživanje test(s) to certain groups of users, kliknite gumb desno od of the test or select all necessary tests using the flag marks on the left and kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-edit.gif" title="'.$lngstr['label_action_questions_edit'].'"></td><td class=rowone width="100%" colspan=4>Za editiranje pitanja testa, kliknite gumb desno od testa.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['label_action_test_delete'].'"></td><td class=rowone width="100%" colspan=4>Za brisanje testova, kliknite gumb desno od testa ili oznaèite potrebne testove koristeæi zastavice na lijevo i kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Koristite ove gumbove za navigaciju izmeðu stranica.</td></tr>
</table></p>
<p>Tablica grupa:</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-new.gif" title="'.$lngstr['label_action_create_group'].'"></td><td class=rowone width="100%" colspan=4>Za kreiranje nove grupe, kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-edit.gif" title="'.$lngstr['label_action_group_edit'].'"></td><td class=rowone width="100%" colspan=4>Za editiranje grupe, kliknite gumb desno od grupe.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['label_action_group_delete'].'"></td><td class=rowone width="100%" colspan=4>Za brisanje grupa, kliknite gumb desno od grupe ili oznaèite grupe koristeæi zastavice na lijevo i kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Koristite ove gumbove za navigaciju izmeðu stranica.</td></tr>
</table></p>';
$lngstr['tooltip_questionbank'] = '<p>Ova stranica namjenjena je za kreiranje i editiranje baze pitanja.</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-new.gif" title="'.$lngstr['label_action_create_question'].'"></td><td class=rowone width="100%" colspan=4>Za kreiranje novog pitanja, kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-stats.gif" title="'.$lngstr['label_action_questions_stats'].'"></td><td class=rowone width="100%" colspan=4>Da bi vidjeli statistike za pojedino pitanje ili pitanja, kliknite gumb desno od pitanja ili oznaèite pitanja koristeæi zastavice na lijevo i kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-edit.gif" title="'.$lngstr['label_action_question_edit'].'"></td><td class=rowone width="100%" colspan=4>Za editiranje pitanja, kliknite gumb desno od pitanja.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['label_action_question_delete'].'"></td><td class=rowone width="100%" colspan=4>Za brisanje pitanja, kliknite gumb desno od pitanja ili oznaèite pitanja koristeæi zastavice na lijevo i kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Koristite ove gumbove za navigaciju izmeðu stranica.</td></tr>
</table></p>';
$lngstr['tooltip_subjects'] = '<p>Ova stranica namjenjena je za kreiranje i editiranje tema.</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-new.gif" title="'.$lngstr['label_action_create_subject'].'"></td><td class=rowone width="100%" colspan=4>Za kreiranje nove teme, kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-edit.gif" title="'.$lngstr['label_action_subject_edit'].'"></td><td class=rowone width="100%" colspan=4>Za editiranje teme, kliknite gumb desno od teme.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['label_action_subject_delete'].'"></td><td class=rowone width="100%" colspan=4>Za brisanje Tema, kliknite gumb desno od teme ili oznaèite teme koristeæi zastavice na lijevo i kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Koristite ove gumbove za navigaciju izmeðu stranica.</td></tr>
</table></p>';
$lngstr['tooltip_reportsmanager'] = '<p>Ova stranica namjenjena je za analaziranje rezultata testova.</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-view.gif" title="'.$lngstr['label_action_test_result_view'].'"></td><td class=rowone width="100%" colspan=4>Da bi vidjeli detaljne rezultate testova, kliknite gumb desno od podataka.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['label_action_test_result_delete'].'"></td><td class=rowone width="100%" colspan=4>Za brisanje podataka, kliknite gumb desno od podatka ili oznaèite podatke koristeæi zastavic ena lijevo i kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Koristite ove gumbove za navigaciju izmeðu stranica.</td></tr>
</table></p>';
$lngstr['tooltip_users'] = '<p>Ova stranica namjenjena je za kreiranje i editiranje korisnièkih raèuna.</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-new.gif" title="'.$lngstr['label_action_create_user'].'"></td><td class=rowone width="100%" colspan=4>Za kreiranje novog korisnièkog raèuna, kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-groups.gif" title="'.$lngstr['label_action_manageusers_groups'].'"></td><td class=rowone width="100%" colspan=4>Za pridruživanje korisnika odreðenoj grupi, kliknite gumb desno od korisnika ili oznaèite korisnike koristeæi zastavice i kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-edit.gif" title="'.$lngstr['label_action_manageusers_edit'].'"></td><td class=rowone width="100%" colspan=4>Za editiranje korisnièkog raèuna, kliknite gumb desno od korisnièkog raèuna.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['label_action_manageusers_delete'].'"></td><td class=rowone width="100%" colspan=4>Za brisanje korisnièkih raèuna, kliknite gumb desno od raèuna korisnika ili oznaèite korisnike koristeæi zastavice na lijevo i kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Koristite ove gumbove za navigaciju izmeðu stranica.</td></tr>
</table></p>';
$lngstr['tooltip_users_groups'] = '';
$lngstr['tooltip_groups'] = '<p>Ova stranica namjenjena je za kreiranje i editiranje grupa.</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-new.gif" title="'.$lngstr['label_action_create_group'].'"></td><td class=rowone width="100%" colspan=4>Za kreiranje nove grupe, kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-edit.gif" title="'.$lngstr['label_action_group_edit'].'"></td><td class=rowone width="100%" colspan=4>Za editiranje grupe, kliknite gumb desno od grupe.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['label_action_group_delete'].'"></td><td class=rowone width="100%" colspan=4>Za brisanje grupa, kliknite gumb desno od grupe ili oznaèite grupe koriteæi zastavice i kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Koristite ove gumbove za navigaciju izmeðu stranica.</td></tr>
</table></p>';
$lngstr['tooltip_visitors'] = '<p>Ova stranica namjenjena je za analiziranje web statistika.</p>
<p><table class=rowtable2 cellpadding=5 cellspacing=1 border=0 width="100%">
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-view.gif" title="'.$lngstr['label_action_visitors_view'].'"></td><td class=rowone width="100%" colspan=4>Za detaljne statistike, kliknite gumb desno od podatka.</td></tr>
<tr><td class=rowtwo width=20><img width=20 height=20 border=0 src="images/button-cross.gif" title="'.$lngstr['label_action_visitor_delete'].'"></td><td class=rowone width="100%" colspan=4>Za brisanje podataka, kliknite gumb desno od podatka ili oznaèite podatke koristeæi zastavic ena lijevo i kliknite gumb na alatnoj traci pri vrhu.</td></tr>
<tr><td class=rowtwo width=20><img src="images/button-first.gif" border=0 title="'.$lngstr['button_first_page'].'"></td><td class=rowtwo width=20><img src="images/button-prev.gif" border=0 title="'.$lngstr['button_prev_page'].'"></td><td class=rowtwo width=20><img src="images/button-next.gif" border=0 title="'.$lngstr['button_next_page'].'"></td><td class=rowtwo width=20><img src="images/button-last.gif" border=0 title="'.$lngstr['button_last_page'].'"></td><td class=rowone width="100%">Koristite ove gumbove za navigaciju izmeðu stranica.</td></tr>
</table></p>';

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