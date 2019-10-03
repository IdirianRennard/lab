<?php
include 'include.php';

$enviroment = $_POST['enviroment'];
unset ( $_POST['enviroment'] );

if( $enviroment == 'live') {
  $endpoint = 'https://payflowpro.paypal.com';
} else {
  $endpoint = 'https://pilot-payflowpro.paypal.com';
}

$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$request_id = 'INVNUM-';

for ($i = 0 ; $i < 36 ; $i++) {
  $request_id .= $characters[mt_rand(0, strlen($characters) - 1)];
}

if ( $_POST[ 'VPS' ] == '' ) {
  $vps = NULL;
} else {
  $vps = $_POST[ 'VPS' ];
}

$data = array();

switch ( $_POST['TRXTYPE'] ) {
  case 'C':
    $data = [
      'PARTNER'   =>  $_POST[ 'PARTNER'   ],
      'VENDOR'    =>  $_POST[ 'VENDOR'    ],
      'USER'      =>  $_POST[ 'USER'      ],
      'PWD'       =>  $_POST[ 'PWD'       ],
      'TRXTYPE'   =>  $_POST[ 'TRXTYPE'   ],
      'VERBOSITY' =>  $_POST[ 'VERBOSITY' ],
      'ORIGID'    =>  $_POST[ 'ORIGID'    ],
      'AMT'       =>  $_POST[ 'AMT'       ],
    ];
  break;

  case 'E':
  $data = [
    'PARTNER'     =>  $_POST[ 'PARTNER'   ],
    'VENDOR'      =>  $_POST[ 'VENDOR'    ],
    'USER'        =>  $_POST[ 'USER'      ],
    'PWD'         =>  $_POST[ 'PWD'       ],
    'TRXTYPE'     =>  $_POST[ 'TRXTYPE'   ],
    'VERBOSITY'   =>  $_POST[ 'VERBOSITY' ],
    'ACCT'        =>  $_POST[ 'ACCT'      ],
    'AMT'         =>  $_POST[ 'AMT'       ],
    'EXPDATE'     =>  $_POST[ 'EXPDATE'   ],
    'CURRENCY'    =>  $_POST[ 'CURRENCY'  ],
  ];

  $headers = TRUE;
  break;

  case 'I':
  $data = [
    'PARTNER'     =>  $_POST[ 'PARTNER'   ],
    'VENDOR'      =>  $_POST[ 'VENDOR'    ],
    'USER'        =>  $_POST[ 'USER'      ],
    'PWD'         =>  $_POST[ 'PWD'       ],
    'TRXTYPE'     =>  $_POST[ 'TRXTYPE'   ],
    'VERBOSITY'   =>  $_POST[ 'VERBOSITY' ],
    'ORIGID'      =>  $_POST[ 'ORIGID'    ],
  ];
  break;
  
  case 'NRC':
    $data = [
      'TRXTYPE'             =>  'C',
      'INVNUM'              =>  $request_id,
      'PARTNER'             =>  $_POST[ 'PARTNER'         ],
      'VENDOR'              =>  $_POST[ 'VENDOR'          ],
      'USER'                =>  $_POST[ 'USER'            ],
      'PWD'                 =>  $_POST[ 'PWD'             ],
      'ACCT'                =>  $_POST[ 'ACCT'            ],
      'CVV2'                =>  $_POST[ 'CVV2'            ],
      'EXPDATE'             =>  $_POST[ 'EXPDATE'         ],
      'VERBOSITY'           =>  $_POST[ 'VERBOSITY'       ],
      'AMT'                 =>  $_POST[ 'AMT'             ],
      'CURRENCY'            =>  $_POST[ 'CURRENCY'        ],
      'BILLTOFIRSTNAME'     =>  $_POST[ 'BILLTOFIRSTNAME' ],
      'BILLTOLASTNAME'      =>  $_POST[ 'BILLTOLASTNAME'  ],
      'BILLTOSTREET'        =>  $_POST[ 'BILLTOSTREET'    ],
      'BILLTOCITY'          =>  $_POST[ 'BILLTOCITY'      ],
      'BILLTOZIP'           =>  $_POST[ 'BILLTOZIP'       ],
      'TENDER'              =>  $_POST[ 'TENDER'          ],
    ];
    
    $vps = $request_id;
  break;

  case 'R':
      $data = [
        'ACTION'          =>  'I',
        'PAYMENTHISTORY'  =>  'Y',
        'PARTNER'         =>  $_POST[ 'PARTNER'       ],
        'VENDOR'          =>  $_POST[ 'VENDOR'        ],
        'USER'            =>  $_POST[ 'USER'          ],
        'PWD'             =>  $_POST[ 'PWD'           ],
        'TRXTYPE'         =>  $_POST[ 'TRXTYPE'       ],
        'VERBOSITY'       =>  $_POST[ 'VERBOSITY'     ],
        'ORIGPROFILEID'   =>  $_POST[ 'ORIGPROFILEID' ],
      ];
  break;

  default:
    foreach ($_POST as $k => $v) {
      $K = strtoupper( $k );
      
      $data["$K"] = $v;

      if ( substr( $K, 0, 6 ) == 'BILLTO' ) {
        $catch = substr( $K, 6 );
        $data["$catch"] = "$v";

        $ship_to = "SHIPTO" . substr( $K, 6 );
        $data["$ship_to"] = "$v";     
      }
    }

    $data['SHIPTOSTATE'] = $data['STATE'];
    $data['BILLTOSTATE'] = $data['STATE'];
  break;
}

ksort( $data );

$myvars = urldecode( http_build_query( $data ) );

$resp = nvp_api( $endpoint, $myvars, $vps );

$resp_str = $resp;

parse_str( $resp, $resp );
?>
  <table class='table'>
    <tr><td colspan="42" align='left'>ENDPOINT:</td></tr>
    <tr><td><br></td></tr>
    <tr><td colspan="42" align='left'><?php echo $endpoint; ?></td></tr>
    <tr><td><br></td></tr>
    <tr><td><br></td></tr>
    <tr><td colspan="42" align='left'>INPUT:</td></tr>
    <tr><td><br></td></tr>
    <tr><td colspan="42" align='left'><?php echo $myvars; ?></td></tr>
    <tr><td><br></td></tr>
    <?php
    foreach ($data as $k => $v) {
        echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>|$v|</td></tr>";
    }
    ?>
    <tr><td><br></td></tr>
    <tr><td><br></td></tr>
    <tr><td colspan="42" align='left'>RESPONSE:</td></tr>
    <tr><td><br></td></tr>
    <tr><td colspan="42" align='left'><?php echo $resp_str; ?></td></tr>
    <tr><td><br></td></tr>
    <?php
    if ( isset( $headers ) ) {
      $string = $resp_str;

      $string = urldecode( $string );
    
      $explode_1 = explode( '&', $string );
    
      $string = array();
    
      foreach ( $explode_1 as $k => $v ) {
        $explode_2 = explode( '=', $v );
        $string[ $explode_2[0] ] = $explode_2[1];
      };

      switch ( $string['AUTHENTICATION_STATUS[1]'] ) {

        case 'E': 
          $string[  'AUTHENTICATION_STATUS[1]'  ] .=  " - Card enrolled";
        break;

        case 'O': 
          $string[  'AUTHENTICATION_STATUS[1]'  ] .=  " - Card not enrolled";
        break;

        case 'X': 
          $string[  'AUTHENTICATION_STATUS[1]'  ] .=  " - Cannot be verified";
        break;
      
        case 'I': 
          $string[  'AUTHENTICATION_STATUS[1]'  ] .=  " - An error occurred or request failed";
        break;

      }

      foreach ( $string as $k => $v ) {
        echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>$v</td></tr>";
      };
    } else {
      foreach ($resp as $k => $v) {
        echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>$v</td></tr>";
      }
    }
    
    ?>
    </table>
</center>
