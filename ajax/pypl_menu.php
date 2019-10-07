<?php
$menu = array ();

$nvp = [
  'Pro3' => 'Pro Legacy',
  'masspaynvp' => 'Payouts',
  'EC-NVP' => 'Express Checkout',
  'gettransactiondetails' => 'GetTransacationDetails',
  'transaction_search' => 'Transaction Search',
  'ec-para' => 'Express Checkout w Parallel',
  'getbal' => 'Get Balance',
  'ec-nvp-recurring' => 'Express Checkout Recurring',
  'docapture-nvp' => 'DoCapture',
  'createrecurringprofile'  => 'Create Recurring Profile',
];

asort( $nvp );

$menu['NVP'] = $nvp ;

$pro = [
  'Pro2' => 'Payflow',
  'PFLink' => 'Payflow Link',
  'invis' => 'Transparent Redirect',
  'ec-pf' => 'Express Checkout',
  'pro2-recurring' => 'Recurring',
  'reporting' => 'Reporting',
  'pflink-recurring' => 'Payflow Link Recurring',
  'pflink-v1' => 'Payflow Link v1',
  'ref_txn' => 'Reference Transactions',
  'magento2' => 'Magento 2 Simulator',
];

asort( $pro );

$menu['Pro'] = $pro;

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
  'ipn_wh_call_sim' => 'IPNWebhook Call Simulator',
];

asort( $gen );

$rest = [
  'rest_bpba' => 'Billing Plan  Billing Agreement',
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
  'webhooks_details' => 'Webhooks - Details',
  'v2-orders' => 'v2 Orders',
  'rest-payment-experience' => 'Payment Experience',
  'rest-sub-v1' => 'Subscriptions v1',
  'orders-app'  => 'Orders App',
  'v2-orders-patch' =>  'v2 Orders - Patch',
  'rest_disputes' =>  'Disputes',
];

asort( $rest );

$menu['REST'] = $rest;

$wps = [
  'buttongen'       =>  'Button Generator',
  'acct_test'       =>  'Buy Now Test',
  'donate'          =>  'Donation Test',
  'subscribe'       =>  'Subscription Test',
  'cart_upload'     =>  'Shopping Cart',
  'xclick-unhosted' =>  'X-Click to Unhosted',
];

asort( $wps );

$menu['WPS'] = $wps;

$jsv4 = [
  'jsv4-client'         =>  "Client Side",
  'jsv4-server'         =>  "Server Side",
  'jsv4-v2-client'      =>  "v2 Client",
  'jsv4-v2-server'      =>  "v2 Server",
  'ppcp-v2-spb'         =>  "PPCP v2 Server",
  'jsv4-v2-server-nvp'  =>  "v2 Server w NVP",
];

asort( $jsv4 );

$menu['JSv4'] = $jsv4;

$adaptive = [
  'adpt-chained'  =>  'Chained Payments',
];

asort( $adaptive );

$menu['Adaptive'] = $adaptive;

$bt = [
  'bt_ec' => 'Express Checkout',
  'bt_dropin' => 'Drop-in',
];

$menu['Braintree'] = $bt;

asort( $menu );

$menu = array( 'General_Testing' => $gen ) + $menu;

if ( $_SERVER[ 'HTTP_HOST' ] == 'localhost' ) {
    $help_options = [
        'https:apslb.paypalcorp.combpeindex.php' => 'BPE',
        'https:internal.paypalinc.comsplunkgpen-USappsearchsearch' => 'Splunk',
        'https:pandora.paypal.comloginLoginScreen.do' => 'Pandora',
        'https:engineering.paypalcorp.comcalidsearch' => 'Sherlock',
        'https:paypal.sharepoint.comsites51566msflBusiness_SupportSitePagesHome.aspx' => 'Business Support Quicklinks',
        'http:10.176.3.187decode' => 'WPS Decode',
        'https:apslb.paypalcorp.comsimulatorindex.php' => 'APS Simulator',
        'https:gocartref' => 'Cartref',
        'https:gosisp' => 'SISP',
        'https:sre.paypalcorp.comquery' => 'SRE Query Tool',
        'https:engineering.paypalcorp.comconfluencedisplayMSITicket+Handling+Process#TicketHandlingProcess-Prioritization' => 'Ticket Handling Process',
        'https:goargus' => 'Argus',
        'http:pphmon'=> 'PayPal Here: Monitoring',
        'https:goto.lightning.force.comlightningoCaselist?filterName=Recent' => 'Salesforce',
        'https:tealeaf.paypalcorp.comPortalSessionSearch.aspx' => 'Tealeaf',
        'https:goto.lightning.force.comlightningnhostedBtnTool' => 'Hosted Button Tool',
        'https:gtstools.glb.paypalcorp.comticket' => 'Ticket Viewer',
        'https:internal.paypalinc.comcskbinfocenterlogin' => 'Infocenter',
        'https:paypal.sharepoint.comsites51566msflListsOrbit%20OpsTeammate.aspx?viewpath=%2Fsites%2F51566%2Fmsfl%2FLists%2FOrbit%20Ops%2FTeammate%2Easpx&sortField=Created&isAscending=false&viewid=b3022016%2D1af2%2D4991%2D8db8%2D8f1a4c9e8b45' => 'Coaching Op Tool',
        'https:goto.lightning.force.comlightningrDashboard01Z2E000001KCmWUAWview' => 'Salesforce: Dashboard',
        'https:engineering.paypalcorp.comownershiphome' => 'Ownership Platform',
        'http:apslb.paypalcorp.comemployeeLookup' => 'Employee Lookup',
        'http:gomedallia' => 'Surveys',
        'http:www.getcreditcardnumbers.com' => 'Test Credit Card - Generator',
        'https:apihistory.paypal.comapihistorynodewebsearch' => 'REST API Logs - Live',
        'https:apihistory.sandbox.paypal.comapihistorynodewebsearch' => 'REST API Logs - SB',
        'https:mtsappsgrepheadersdefault.aspx' => 'Grep Headers',
        'https:admin.sandbox.paypal.comauthmanagementapplicationsearch' => 'Scope Management Tool - SB',
        'https:developer.paypal.comdocsclassicpaypal-payments-standardintegration-guideAppx_websitestandard_htmlvariables#technical-variables' => 'HTML Variables',
        'https:admin.paypalinc.comauthmanagementapplicationsearch' => 'Scope Management Tool - Live',
        'https:engineering.paypalcorp.comunptracker' => 'UNP Tool',
        'https:engineering.paypalcorp.comconfluencedisplayMSIFeature+Request' => 'VOM Tool',
        'https:mtsappsreport_grabber' => 'SFTP Report Grabber',
        'https:gomtsqa' => 'QD Scores',
        'https:engineering.paypalcorp.comcalregexui' => 'Cal-Regex',
        'https:internal.paypalinc.comppmeadminslugs'  => 'PayPal.me',
        'https:splunk.paypal.com:8000en-USappsearch-gso-reportingis_it_blocked' => 'IP Address Tool',
        'https:sjnitapp19.sjn.its.paypalcorp.comROMCIindex.phpsnapshot' => 'Snapshot: Risk Rules',
        'https:bridgeteamsite.paypalcorp.comteamworkssites34255mtsListsOn%20Call%20MTS%20L2AllItems.aspx' => 'Teamwork Site: On Call',
        'https:developer.paypal.comdocsclassicpayflowpayflow-propayflow-pro-testing' => 'Test Credit Cards - Payflow',
        'https:gositenotebooks' => 'Orion - Site Notebooks',
        'https:pphsdk.loggly.com'  => 'Loggly',
    ];
      
    asort( $help_options );
      
    $menu['Helpful_Links'] = $help_options;
}

$menu['width'] = 100 / ( count ( $menu ) );

header('Content-Type: application/json');

echo json_encode( $menu );

?>
