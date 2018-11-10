<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'ico';
$route['404_override'] = '';


$route['admin/settings']="ico/settings";

/********* FRONT END ROUTES ***************/
$route['login']					   	= "ico/login_page";



$route['buy-tokens']				= "ico/buy_tokens_0";
$route['buy-tokens/crypto']			= "ico/buy_tokens_1";
$route['buy-tokens/fiat']			= "ico/buy_tokens_1";
$route['buy-tokens/enter-amount']	= "ico/buy_tokens_enter_amount";
$route['buy-tokens/general-terms']	= "ico/buy_tokens_general_terms";
$route['buy-tokens/(:any)']			= "ico/buy_tokens_step_2";
$route['buy-tokens/(:any)/hash']    = "ico/buy_tokens_step_3";



$route['bounties']					= "ico/bounties";
$route['referrals']			= "ico/referral_program";
$route['notifications']				= "ico/notification_page";
$route['signup/step']				= "ico/signup_step";
$route['signup']					= "ico/signup_page";
$route['do/login']					= "ico/do_login_account";
$route['do/signup']				   	= "ico/do_register";
$route['do/admin/user/signup']				   	= "ico/do_register_admin";
$route['do/admin/add/campaign']				   	= "ico/do_add_campaign";
$route['do/admin/add/slide']				   	= "ico/do_add_slide";



$route['do/admin/token/add']				   	= "ico/add_token_new_price";
$route['admin/token/pricing']		= "ico/admin_token_pricing";
// $route['admin/add/token/pricing']		= "ico/add_token_pricing";
$route['admin/add/token/pricing/type']		= "ico/add_token_pricing_type";
$route['admin/add/token/pricing/bonus']		= "ico/add_token_pricing_bonus";
$route['admin/add/token/pricing/bonus-level']		= "ico/add_token_pricing_bonus_level";

$route['admin/add/token/pricing/individual']		= "ico/add_token_pricing/individual";
$route['admin/add/token/pricing/multiple']		= "ico/add_token_pricing/multiple";
$route['admin/add/token/pricing/multiple/2']		= "ico/add_token_pricing/multiple/2";
$route['password/protect']			= "ico/password_protected";
$route['admin/add/user']			= "ico/add_admin_user";
$route['admin/add-admin']			= "ico/add_admin_admin";
$route['admin/add/campaign']		= "ico/add_campaign";
$route['admin/add/slide/(:num)']		= "ico/add_slide/$1";
$route['do/signup/final']			= "ico/do_register_final";
$route['signup/marketing']			= "ico/signup_page_marketing";
$route['do/signup/marketing']		= "ico/do_register_marketing";
$route['fb/login']					= "ico/do_fb_login";
$route['twitter/login']			   	= "ico/do_twitter_login";
$route['google/login']				= "ico/do_google_login";
$route['oathgoogle/login']			= "ico/do_google_login_validate";
$route['oathtwitter/login']		  	= "ico/do_twitter_login_validate";
$route['oathlinkedin/login']		= "ico/do_linkedin_login_validate";

$route['signup/step/2']				= "ico/singup_step_two";
$route['skip-signup']				= "ico/singup_skip";
$route['signup/cv/upload']			= "ico/signup_cv_upload";
// $route['do/login']					= "ico/do_login_account";
$route['dashboard']					= "ico/dashboard";
$route['admin/tranasctions']		= "ico/a_trans";
// $route['admin/tranasctions']		= "ico/dashboard";
$route['admin/do/action/tranasctions/(:any)/(:any)']		= "ico/admin_tranaction_actions/$1/$2";
$route['admin/do/action/user/(:any)/(:any)']		= "ico/admin_user_actions/$1/$2";
$route['admin/user/reports']		= "ico/user_reports";
$route['admin/user/reports/whitelist']		= "ico/user_reports";


$route['admin/referral-settings']			= "ico/admin_affiliates";
$route['admin/affiliates']			= "ico/admin_affiliates";
$route['account/details']			= "ico/profile_dashboard";
$route['account/delete']			= "ico/account_deletion_page";
$route['do/update/profile']			= "ico/profile_dashboard_update";
$route['do/wallet']					= "ico/do_update_wallet";
$route['job-application']			  = "ico/applied_jobs";
$route['remove-applied/(:any)']	    = "ico/remove_applied/$1";

$route['jobs/(:any)']				= "ico/jobs_list/$1";
$route['jobs/(:any)/(:any)']		= "ico/jobs_list/$1/$2";
$route['jobs/(:any)/(:any)/(:any)']		= "ico/jobs_list/$1/$2/$3";
$route['country/(:any)']				= "ico/jobs_list/$1";
$route['country/(:any)/(:any)']		= "ico/jobs_list/$1/$2";
$route['savejob/(:any)']			= "ico/save_job/$1";
$route['removesaved/(:any)']		= "ico/remove_save_job/$1";
$route['city/(:any)']				= "ico/cities_job_list/$1";
#$route['country/(:any)']			= "ico/countries_job_list/$1";
$route['job/(:any)']				= "ico/job_details/$1";
$route['do/job/applied']				 = "ico/job_Applied_submit";

$route['saved-jobs']				   = "ico/saved_job_user";
$route['cover-letters']				= "ico/cover_letters";
$route['cover-letters/edit/(:any)']	= "ico/cover_letters_edit/$1";
$route['do/cover']					 = "ico/cover_letter_submit";
$route['do/editcover']				 = "ico/cover_letter_edit";
$route['cover/remove/(:any)']		  = "ico/cover_letter_remove";

$route['advance/search']		  = "ico/refine_search_advance";


$route['job-alerts']					= "ico/manage_job_alerts";

$route['cv-management']				= "ico/resume_management";
$route['create-cv']					= "ico/resume_create_management";
$route['do/create/cv']				 = "ico/do_create_cv_submit";
$route['recruiter-signup']		   = "ico/recruiter_signup";
$route['do/login/recruiter']		   = "ico/do_login_recruiter";
$route['post-job']					 = "ico/post_job_advert";
$route['recruiter-login']			  = "ico/recruiter_login_page";
$route['do/post/job']					 = "ico/job_post_form_submit";
$route['do/edit/job']					 = "ico/edit_job_post_form_submit";

$route['job-post-agent']				= "ico/post_job_advert_agent";

$route['company-profile']			= "ico/company_profile_page";
$route['company']					= "ico/company_profile_user_null";
$route['company/(:any)']			= "ico/company_profile_user/$1";
$route['advance-job-search']			= "ico/advance_job_search";

$route['cv-viewed']					= "ico/recruiter_viewed_cv";

$route['candidate-search']			= "ico/candidate_search_recruiter";
$route['candidate-search-action']			= "ico/search_canidate_action";
$route['download-cv']					= "ico/cv_download_action_redirect";
$route['download-cv/(:any)']					= "ico/cv_download_action/$1";

$route['do/confirm/account/(:any)']	= "ico/confirm_account/$1";
$route['forgot-password']			  = "ico/forgot_password";
$route['do/forgot']					= "ico/forgot_password_email";

$route['recruiter-posted-jobs']		= "ico/recruiter_posted_jobs";
$route['job-applicants/(:any)']		= "ico/jobs_applicants/$1";
$route['checkout']					 = "ico/checkout_page";
$route['messages']					 = "ico/messages_page";
$route['view-message/(:any)']		  = "ico/messages_details/$1";
$route['change-password'] = "ico/change_password";
$route['do/password']				= "ico/do_change_password";
$route['do/referrel/setting']				= "ico/do_referrel_settings";

$route['about-us']					= "ico/pages_cms";
$route['terms']						= "ico/pages_cms";
$route['faq']						= "ico/faq_page";
$route['faq-security']						= "ico/faq_page_secruity";
$route['privacy']					= "ico/pages_cms";
$route['contact-us']				= "ico/pages_cms";
$route['do/contact']				= "ico/contact_email";

$route['categories']				= "ico/categories_all";

$route['logout']					= "ico/logout";
$route['thank-you']					= "ico/thank_you";

// custom backend routes
$route['backend/dashboard']						= "admin/dashboard";
$route['backend/configuration'] 				= "admin/configuration";
$route['backend/categories'] 					= "admin/categories";
$route['backend/categories/actions'] 			= "admin/categories_actions";
// USERS URLS
$route['backend/add/user'] 						= "admin/add_new_user";
$route['backend/manage/users'] 					= "admin/manage_users";
$route['backend/manage/jobseeker'] 				= "admin/manage_users";
$route['backend/manage/employer'] 				= "admin/manage_users";

$route['backend/manage/users/(:any)'] 					= "admin/manage_users/$1";
$route['backend/manage/jobseeker/(:any)'] 				= "admin/manage_users/$1";
$route['backend/manage/employer/(:any)'] 				= "admin/manage_users/$1";

$route['backend/users/actions'] 				= "admin/users_action";
$route['backend/user/details/(:any)']			= "admin/view_users_details/$1";

// JOB MANAGEMEN
$route['backend/new-job'] 						= "admin/add_new_job";
$route['backend/manage/jobs'] 					= "admin/manage_jobs";
$route['backend/manage/jobs/archived'] 			= "admin/manage_jobs";
$route['backend/manage/applicants/(:any)'] 		= "admin/manage_applicants/$1";
// JOB DEPARTMENTS
$route['backend/new-department'] 				= "admin/add_new_department";
$route['backend/manage/department'] 			= "admin/manage_departments";
// COMPANY BENEFITS
$route['backend/new-benefits'] 					= "admin/add_new_benefits";
$route['backend/manage/benefits'] 				= "admin/manage_benefits";

// MANAGE PAGE
$route['backend/pages'] 						= "admin/manage_pages";
$route['backend/edit/page'] 					= "admin/edit_page";
$route['backend/detail/page/(:any)'] 			= "admin/page_detail/$1";
$route['backend/banned'] 							= "admin/manage_bannedIp";
$route['backend/faq'] 							= "admin/manage_faq";
$route['backend/subscribers'] 					= "admin/manage_subscribers";

$route['backend/login'] 		= "admin/login";
$route['backend/logout'] 		= "admin/logout";
$route['admin/logout'] 		= "ico/logout";

$route['admin/sponsored-predictions'] = "ico/sponsored_predictions";
$route['admin/user-onboarding-compaigns']='ico/user_onboarding_compaigns';


$route['admin/payment/options'] = "ico/payment_options";
$route['admin/payment-settings'] = "ico/payment_options";

$route['transaction-details/(:any)']="ico/transaction_details/$1";

// $route['buy-tokens'] = "ico/buy_tokens";


$route['admin/edit-campaign/(:num)']  = "ico/edit_campaign/$1";
$route['admin/campaign-slides/(:num)']  = "ico/campaign_slides/$1";

$route['admin/questions']="ico/questions";
$route['admin/add-question']="ico/add_question";
$route['admin/edit-question/(:num)']="ico/edit_question/$1";


$route['admin/links']="ico/links";
$route['admin/add-link']="ico/add_link";
$route['admin/edit-link/(:num)']="ico/edit_link/$1";

$route['admin/edit-campaign-slide/(:num)']="ico/edit_slide/$1";

$route['admin/ico-settings']="ico/ico_settings";
$route['admin/add-ico-setting']="ico/add_ico_setting";
$route['admin/edit-ico-setting/(:num)']="ico/edit_ico_setting/$1";


$route['admin/bounty-campaigns']="ico/airdrop_campaigns";
$route['admin/add-bounty-campaign']="ico/add_airdrop_campaign";
$route['admin/edit-bounty-campaign/(:num)']="ico/edit_airdrop_campaign/$1";
$route['admin/bounty-submissions']="ico/airdrop_submissions";
$route['admin/view-bounty-submission/(:num)']="ico/view_airdrop_submission/$1";

$route['user-bounty-submissions']="ico/airdrop_submissions_user";
$route['view-user-bounty-submission/(:num)']="ico/view_airdrop_submission_user/$1";

$route['admin/bounty-landing-page']="ico/airdrop_landing_page";
$route['admin/add-bounty-cat']="ico/add_airdrop_cat";
$route['admin/edit-bounty-cat/(:num)']="ico/edit_airdrop_cat/$1";


$route['admin/support']="ico/support";

$route['bounties']="ico/bounties";
$route['bounties/(:any)']="ico/bounties_list/$1";
$route['submit-airdrop-campaign/(:num)']="ico/submit_airdrop_campaign/$1";;
$route['view-airdrop-campaign/(:num)']="ico/view_airdrop_campaign/$1";;

$route['marketing-suite']="ico/marketing_suites";
$route['KYC/AML']="ico/kyc_aml";

$route['admin/authy-settings']="ico/two_factor_settings";

$route['admin/create-smart-contract']="ico/create_smart_contract";
$route['admin/create-smart-contract/step-2']="ico/create_smart_contract_step_2";
$route['admin/create-smart-contract/step-3']="ico/create_smart_contract_step_3";

$route['admin/submitted-smart-contracts']="ico/submitted_smart_contracts";
$route['admin/view-smart-contract/(:num)']="ico/view_smart_contract/$1";

$route['admin/bounty-missions']="ico/bounty_missions";
$route['resend-otp']="ico/resend_otp";
$route['submit-otp']="ico/submit_otp";
$route['verify-otp']="ico/verify_top";
$route['translate_uri_dashes'] = FALSE;
$route['tranasctions']="ico/tranasctions";
 

$route['admin/edit-terms']="ico/edit_terms";
$route['accept-terms']="ico/accept_terms";
$route['accept-terms/(:any)']="ico/accept_terms/$1";

$route['admin/user/(:num)']="ico/user_details/$1";
$route['admin/banned-countries']="ico/banned_countries";
$route['admin/registration-form']="ico/registration_form";
$route['admin/user-registration']="ico/registration_form";

$route['resend-verification-email']="ico/resend_vf";
$route['admin/paid-content-placement']="ico/paid_content_placement_admin";

$route['view-paid-content/(:num)']="ico/view_paid_content/$1";
$route['paid-content-placement']="ico/paid_content_placement";
$route['paid-content-placement/step-2']="ico/paid_content_placement_step_2";
$route['my-paid-contents']="ico/my_paid_contents";

// $route['admin/manage-content-promotions']="ico/manage_content_promotions";
$route['admin/add-publication']="ico/add_publication";
$route['admin/edit-publication/(:num)']="ico/edit_publication/$1";
$route['admin/download-paid-content/(:num)']="ico/download_paid_content/$1";
$route['download-paid-content/(:num)']="ico/download_paid_content/$1/user";

$route['my-placements']="ico/my_paid_contents";

$route['admin/ico-directory-submission']="ico/ico_directory";
$route['admin/admin-users']="ico/admin_users";
$route['admin/edit-admin/(:num)']="ico/edit_admin/$1";

// $route['admin/add-admin-admin']="ico/add_admin_admin";

$route['privacy-policy']="ico/privacy_policy";

$route['admin/create-smart-contract']="ico/create_smart_contract_page";
$route['admin/banned-countries']="ico/banned_countries";
$route['admin/gdpr-settings']="ico/gdpr_settings";
$route['admin/add_kyc_aml']="ico/add_kyc_aml";

$route['admin/edit-reg-form/(:any)']="ico/admin_edit_reg_form/$1";
$route['admin/new-reg-form']="ico/new_reg_form";

$route['admin/privacy-pages']="ico/edit_pages/privacy";
$route['admin/terms-pages']="ico/edit_pages/terms";
$route['admin/new-page/(:any)']="ico/new_page/$1";
$route['admin/edit-page/(:any)']="ico/edit_page/$1";
$route['admin/export/users/csv/(:any)']="ico/export_users/csv/$1";

$route['admin/export/users/(:any)']="ico/export_users/$1";
$route['admin/export/emails/(:any)']="ico/export_emails/$1";

$route['admin/export/tranasctions/(:any)']="ico/export_transactions/$1";

$route['admin/ico-milestones']="ico/ico_milestones";
$route['admin/edit-ico-milestone/(:any)']="ico/edit_ico_milestone/$1";
$route['admin/add-ico-milestone/step-1']="ico/add_ico_milestone_step_1";
$route['admin/add-ico-milestone/step-2']="ico/add_ico_milestone_step_2";
$route['admin/delete-ico-milestone/(:num)']="ico/delete_ico_milestone/$1";

$route['admin/manage-payment-option-countries/(:num)']="ico/manage_payment_option_countries/$1";

$route['admin/wallet-addresses/(:num)']="ico/wallet_addresses/$1";
$route['admin/email-settings']="ico/email_settings";
$route['admin/edit-email/(:any)']="ico/edit_email/$1";
$route['admin/edit-token-pricing/(:any)']="ico/edit_token_pricing/$1";

$route['verify']="ico/verify_yourself";
$route['verify/accepted']="ico/verify_yourself/accepted";
$route['verify/review']="ico/verify_yourself/review";
$route['verify/rejected']="ico/verify_yourself/rejected";
$route['admin/user/verifications']="ico/verification_reports";
$route['admin/view-user-verification/(:num)']="ico/view_user_verification/$1";
$route['admin/edit-user-verification-text']="ico/edit_user_verification_text";
$route['admin/edit-user-verification-popup']="ico/edit_user_verification_popup";
$route['kyc-verification']="ico/kyc_verification";
$route['my-referral-url']="ico/my_referral_code";

$route['admin/arrange-slides/(:num)']="ico/arrange_slides/$1";
$route['spring-role']="ico/spring_role";
$route['admin/manage-bonuses/(:num)']="ico/manage_bonuses/$1";

$route['admin/add-bonus/(:num)']="ico/add_bonus/$1";
$route['admin/add-bonus-step-2/(:num)']="ico/add_bonus_step_2/$1";
$route['admin/edit-bonus/(:num)']="ico/edit_bonus/$1";
$route['admin/whitelist']="ico/whitelist";

$route['please-wait']="ico/please_wait";

$route['kyc-rejected']='ico/kyc_rejected';
$route['admin/receipts/(:num)']='ico/receipts/$1';

$route['admin/language-settings']="ico/language_settings";

$route['admin/edit-payment-option/(:num)']="ico/edit_payment_option/$1";
$route['admin/add-payment-option']="ico/add_payment_option";

$route['kyc-verify-email/(:any)']="ico/kyc_verify_email/$1";

$route['verify-kyc/step-2']="ico/verify_kyc_2";
$route['verify-kyc/step-3']="ico/verify_kyc_3";
$route['verify-kyc/step-4']="ico/verify_kyc_4";
$route['kyc-recorded']="ico/kyc_recorded";
$route['kyc-enter-verification-code']="ico/kyc_enter_verification_code";
$route['better-luck-next-time']="ico/kyc_better_luck_next_time";
$route['set-kyc-lang/(:any)']="ico/set_kyc_lang/$1";
$route['buy-tokens/enter-amount']="ico/buy_tokens_enter_amount";
$route['view-transaction/(:any)']="ico/view_transaction/$1";

$route['admin/edit-sale-bar']="ico/edit_sale_bar";
$route['thank-you-for-your-purchase']="ico/thank_you_for_your_purchase";


