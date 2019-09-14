<?php
$menu_options = array();

$nvp = [
  'Pro3' => 'Pro Legacy',
  'masspaynvp' => 'Payouts',
  'EC-NVP' => 'Express Checkout',
  'gettransactiondetails' => 'GetTransacationDetails',
  'transaction_search' => 'Transaction Search',
  'ec-para' => 'Express Checkout w/ Parallel',
  'getbal' => 'Get Balance',
  'ec-nvp-recurring' => 'Express Checkout Recurring',
  'docapture-nvp' => 'DoCapture',
  'createrecurringprofile'  => 'Create Recurring Profile',
];

asort( $nvp );

$menu_options['NVP'] = $nvp;

$pro = [
  'Pro2' => 'Payflow',
  'PFLink' => 'Payflow Link',
  'invis' => 'Transparent Redirect',
  'ec-pf' => 'Express Checkout',
  'pro2-recurring' => 'Recurring',
  'reporting' => 'Reporting',
  //'pflink-recurring' => 'Payflow Link Recurring',
  'pflink-v1' => 'Payflow Link v1',
  'ref_txn' => 'Reference Transactions',
  'magento2' => 'Magento 2 Simulator',
];

asort( $pro );

$menu_options['Pro'] = $pro;

$gen = [
  'HTML' => 'HTML Test Bed',
  'uncode_get' => "Decode: URL",
  'api_str' => "API String",
  'string_count' => 'Count String',
  'xclick_decode' => 'Decode: X-Click Params',
  'json_view' => 'JSON Viewer',
  'time_convert' => 'Time Converter',
  'lorax' => 'Lorax',
  'base_64_decode' => 'Decode: Base 64',
  //'fw-redirect' => 'Redirection',
];

asort( $gen );

$rest = [
  'rest_bpba' => 'Billing Plan / Billing Agreement',
  'rest_payouts' => 'Payouts',
  'rest_inv' => 'Invoicing API',
  'rest_inv_template' => 'Invoicing Template',
  'rest_inv_template_list' => 'Invoice Templates List',
  'rest_payments' => 'Payments',
  'rest_identity' => 'Identity',
  'rest_payments_list' => 'Payments - List',
  'rest_payments_details' => 'Payments - Details',
  'rest_reporting_sync' => 'Reporting - Sync',
  'rest_payments_sale' => 'Payments - Sale',
  'rest_auth_c_v' => 'Payments - Capture|Void',
  'webhooks_list' => 'Webhooks - List',
  //'webhooks_details' => 'Webhooks - Details',
  'v2-orders' => 'v2 Orders',
  'rest-payment-experience' => 'Payment Experience',
  'rest-sub-v1' => 'Subscriptions v1',
  'orders-app'  => 'Orders App',
  'v2-orders-patch' =>  'v2 Orders - Patch',
  'rest_disputes' =>  'Disputes',
];

asort( $rest );

$menu_options['REST'] = $rest;

$wps = [
  'buttongen'       =>  'Button Generator',
  'acct_test'       =>  'Buy Now Test',
  'donate'          =>  'Donation Test',
  'subscribe'       =>  'Subscription Test',
  'cart_upload'     =>  'Shopping Cart',
  'xclick-unhosted' =>  'X-Click to Unhosted',
];

asort( $wps );

$menu_options['WPS'] = $wps;

$jsv4 = [
  'jsv4-client'     =>  "Client Side",
  'jsv4-server'     =>  "Server Side",
  'jsv4-v2-client'  =>  "v2 Client",
  'jsv4-v2-server'  =>  "v2 Server",
  'ppcp-v2-spb'     =>  "PPCP v2 Server",
];

asort( $jsv4 );

$menu_options['JSv4'] = $jsv4;

$adaptive = [
  'adpt-chained'  =>  'Chained Payments',
];

asort( $adaptive );

$menu_options['Adaptive'] = $adaptive;

$bt = [
  //'bt_ec' => 'Express Checkout',
  'bt_dropin' => 'Drop-in',
];

$menu_options['Braintree'] = $bt;

$complete = [

];

//$menu_options['Complete'] = $complete;

ksort( $menu_options );

$help_options = [
  'https://apslb.paypalcorp.com/bpe/index.php' => 'BPE',
  'https://internal.paypalinc.com/splunkgp/en-US/app/search/search' => 'Splunk',
  'https://pandora.paypal.com/login/LoginScreen.do' => 'Pandora',
  'https://engineering.paypalcorp.com/cal/idsearch/' => 'Sherlock',
  'https://paypal.sharepoint.com/sites/51566/msfl/Business_Support/SitePages/Home.aspx' => 'Business Support Quicklinks',
  'http://10.176.3.187/decode' => 'WPS Decode',
  'https://apslb.paypalcorp.com/simulator/index.php' => 'APS Simulator',
  'https://go/cartref' => 'Cartref',
  'https://go/sisp' => 'SISP',
  'https://sre.paypalcorp.com/query/' => 'SRE Query Tool',
  'https://engineering.paypalcorp.com/confluence/display/MSI/Ticket+Handling+Process#TicketHandlingProcess-Prioritization' => 'Ticket Handling Process',
  'https://go/argus' => 'Argus',
  'http://pphmon/'=> 'PayPal Here: Monitoring',
  'https://goto.lightning.force.com/lightning/o/Case/list?filterName=Recent' => 'Salesforce',
  'https://tealeaf.paypalcorp.com/Portal/SessionSearch.aspx' => 'Tealeaf',
  'https://goto.lightning.force.com/lightning/n/hostedBtnTool' => 'Hosted Button Tool',
  'https://gtstools.glb.paypalcorp.com/ticket' => 'Ticket Viewer',
  'https://internal.paypalinc.com/cskb/infocenter/login' => 'Infocenter',
  'https://paypal.sharepoint.com/sites/51566/msfl/Lists/Orbit%20Ops/Teammate.aspx?viewpath=%2Fsites%2F51566%2Fmsfl%2FLists%2FOrbit%20Ops%2FTeammate%2Easpx&sortField=Created&isAscending=false&viewid=b3022016%2D1af2%2D4991%2D8db8%2D8f1a4c9e8b45' => 'Coaching Op Tool',
  'https://goto.lightning.force.com/lightning/r/Dashboard/01Z2E000001KCmWUAW/view' => 'Salesforce: Dashboard',
  'https://engineering.paypalcorp.com/ownership/home' => 'Ownership Platform',
  'http://apslb.paypalcorp.com/employeeLookup/' => 'Employee Lookup',
  'http://go/medallia' => 'Surveys',
  'http://www.getcreditcardnumbers.com/' => 'Test Credit Card - Generator',
  'https://apihistory.paypal.com/apihistorynodeweb/search' => 'REST API Logs - Live',
  'https://apihistory.sandbox.paypal.com/apihistorynodeweb/search' => 'REST API Logs - SB',
  'https://mtsapps/grepheaders/default.aspx' => 'Grep Headers',
  'https://admin.sandbox.paypal.com/authmanagement/application/search' => 'Scope Management Tool - SB',
  'https://developer.paypal.com/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables/#technical-variables' => 'HTML Variables',
  'https://admin.paypalinc.com/authmanagement/application/search' => 'Scope Management Tool - Live',
  'https://engineering.paypalcorp.com/unp/tracker' => 'UNP Tool',
  'https://engineering.paypalcorp.com/confluence/display/MSI/Feature+Request' => 'VOM Tool',
  'https://mtsapps/report_grabber/' => 'SFTP Report Grabber',
  'https://go/mtsqa' => 'QD Scores',
  'https://engineering.paypalcorp.com/cal/regexui/' => 'Cal-Regex',
  'https://internal.paypalinc.com/ppmeadmin/slugs'  => 'PayPal.me',
  'https://splunk.paypal.com:8000/en-US/app/search-gso-reporting/is_it_blocked' => 'IP Address Tool',
  'https://sjnitapp19.sjn.its.paypalcorp.com/ROM/CI/index.php/snapshot' => 'Snapshot: Risk Rules',
  'https://bridgeteamsite.paypalcorp.com/teamworks/sites/34255/mts/Lists/On%20Call%20MTS%20L2/AllItems.aspx' => 'Teamwork Site: On Call',
  'https://developer.paypal.com/docs/classic/payflow/payflow-pro/payflow-pro-testing/' => 'Test Credit Cards - Payflow',
  'https://go/sitenotebooks' => 'Orion - Site Notebooks',
];

asort( $help_options );

$menu_options['Helpful_Links'] = $help_options;

$menu_options = array( 'General_Testing' => $gen ) + $menu_options;

$help_options = [
  'ui_settings' =>  'UI Settings',
  'admin'       =>  'Admin Accts',
  'cal'         =>  'Sherlock',
  'splunk'      =>  'splunk',
  'tealeaf'     =>  'Tealeaf',
  'JIRA'        =>  'JIRA',
];

if ( $_SERVER[ 'HTTP_HOST' ] == 'localhost' ) {

} else {
  $help_options = [];
  unset ( $menu_options[ 'Helpful_Links' ] );
} 

?>
