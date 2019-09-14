<?php
include 'dbinfo.php';

$key = '514348269d6c4c2d88055f43d3198015';
$secret = 'YUwSdgf9848hAHSiN9qjIGKvNaI568gX';

$url = "https://us.battle.net/oauth/token?grant_type=client_credentials&client_id=$key&client_secret=$secret";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url );
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);

curl_close($ch);

$decode = json_decode( $result );
$access_token = $decode->access_token;

$header = [
  "Content-Type: application/json",
  "Authorization: Bearer $access_token",
];

$method = $_GET['m'];
$character = ucfirst( $_GET['ch'] );
$player  = $_GET['dun'];

class data {

};

$message = new data ();

header('Content-Type: application/json');

switch ( $method ) {
    case 'add' :
        $sql  = "SELECT * FROM `Wolf_sq` WHERE `name` = '$character'";
        
        if ( $result = mysqli_query( $mysqli, "$sql" ) ) {
            if ( mysqli_num_rows( $result ) > 0 ) {

                $url = "https://us.api.blizzard.com/wow/character/hyjal/$character?fields=titles";
                
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $url );
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $json = curl_exec($ch);

                curl_close($ch);

                $json = json_decode( $json );

                $json = $json->titles;

                foreach( $json as $k => $v ) {
                    if ( isset( $v->selected ) ) {
                        $title = $v->name;
                        $name = str_replace( "%s" , $character , $title );
                    }   
                }

                if ( isset( $title ) ) {
                    $name = str_replace( "%s" , $character , $title );
                } else {
                    $name = $character;
                }

                $message->status = 'error';
                $message->message = "$name is already a member of this team.";

                $message = json_encode( $message );
                echo $message;
                exit;
            
            } else {

                $url = "https://us.api.blizzard.com/wow/character/hyjal/$character";

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $url );
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $json = curl_exec($ch);

                curl_close($ch);

                $json = json_decode( $json );

                if ( $json->reason === 'Character not found.' ) {

                    $message->status = 'error';
                    $message->message = "$character not found on Hyjal Server.";

                    $message = json_encode( $message );
                    echo $message;
                    exit;

                } else {

                    $url = "https://us.api.blizzard.com/wow/character/hyjal/$character?fields=titles";
                
                    $ch = curl_init();
    
                    curl_setopt($ch, CURLOPT_URL, $url );
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
                    $json = curl_exec($ch);
    
                    curl_close($ch);

                    $json = json_decode( $json );
    
                    $json = $json->titles;
    
                    foreach( $json as $k => $v ) {
                        if ( isset( $v->selected ) ) {
                            $title = $v->name;
                        }   
                    }
    
                    $url = "https://raider.io/api/v1/characters/profile?region=us&realm=hyjal&name=$character&fields=mythic_plus_scores%2Cgear";
               
                    $ch = curl_init();
    
                    curl_setopt($ch, CURLOPT_URL, $url );
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
                    $json = curl_exec($ch);
    
                    curl_close($ch);

                    $json = json_decode( $json );

                    $race = $json->race;
                    if ( strpos( $race, "'" ) === false ) {
                        
                    } else {
                        $race = str_replace( "'" , "" , $race );
                    }

                    $class = $json->class;
                    $spec = $json->active_spec_name;
                    $role = $json->active_spec_role;
                    $score = $json->mythic_plus_scores->all;
                    $ilvl = $json->gear->item_level_total;
                    $date = date( 'Y-m-d' );

                    $sql  = "INSERT INTO `Wolf_sq`(`discord_alias`, `name`, `race`, `class`, `spec`, `title`, `ilvl`, `role`, `raider_score`, `last_updated` ) VALUES ( '$player', '$character', '$race', '$class', '$spec', '$title', '$ilvl', '$role', '$score', '$date')";

                    if ( mysqli_query( $mysqli, "$sql" ) ) {
                    }

                    
                    if ( isset( $title ) ) {
                        $name = str_replace( "%s" , $character , $title );
                    } else {
                        $name = $character;
                    }
                                        
                    $message->status = "success! $player";
                    $message->message = "$name a $race $spec $class has been added to the team.";

                    $message = json_encode( $message );
                    echo $message;
                    exit;

                }
            }
        }

    break;
    
    case 'remove' :
        $sql  = "SELECT * FROM `Wolf_sq` WHERE `name` = '$character'";
        
        if ( $result = mysqli_query( $mysqli, "$sql" ) ) {
            
            if ( mysqli_num_rows($result) > 0 ) {
                $row = $result->fetch_assoc();
                $title = $row['title'];
                $player = $row['discord_alias'];

                if ( strpos( $title, '%s' ) === false ) {
                    $name = $character;
                } else {
                    $name = str_replace( '%s' , $character , $title );
                }

                $sql = "DELETE FROM `Wolf_sq` WHERE `name` = '$character'";
               
                if ( mysqli_query( $mysqli, "$sql" ) ) {
                }
             
                $message->status = "success!";
                $message->message = "$name has been removed from the team. \n\n";
                $message->message .= "$player we are sad to see $character go :(.";

                $message = json_encode( $message );
                echo $message;
                exit;

            } else {

                $message->status = 'error';
                $message->message = "$character is not a member of this team.";

                $message = json_encode( $message );
                echo $message;
                exit;

            }
        }
    break;
    
    case 'list' :
        $sql  = "SELECT * FROM `Wolf_sq` ORDER BY `name` ASC";

        $message->status = "";
        $message->message = "\n\n";
        
        if ( $result = mysqli_query( $mysqli, "$sql" ) ) {
            while ( $row = mysqli_fetch_assoc( $result ) ) {
                $message->status .= $row['discord_alias'] . ' ';
                $character = $row['name'];

                $url = "https://us.api.blizzard.com/wow/character/hyjal/$character?fields=titles";
                
                $ch = curl_init();
    
                curl_setopt($ch, CURLOPT_URL, $url );
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
                $json = curl_exec($ch);
    
                curl_close($ch);

                $json = json_decode( $json );
    
                $json = $json->titles;
    
                foreach( $json as $k => $v ) {
                    if ( isset( $v->selected ) ) {
                        $title = $v->name;
                    }   
                }

                $url = "https://raider.io/api/v1/characters/profile?region=us&realm=hyjal&name=$character&fields=mythic_plus_scores%2Cgear";
               
                $ch = curl_init();
    
                curl_setopt($ch, CURLOPT_URL, $url );
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
                $json = curl_exec($ch);
    
                curl_close($ch);

                $json = json_decode( $json );

                $race = $json->race;
                $class = $json->class;
                $spec = $json->active_spec_name;
                $role = $json->active_spec_role;
                $score = $json->mythic_plus_scores->all;

                if ( strpos( $title, '%s' ) === false ) {
                    $name = $character;
                } else {
                    $name = str_replace( '%s' , $character , $title );
                }

                $url = "https://us.api.blizzard.com/wow/character/hyjal/$character?fields=items";

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $url );
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $json = curl_exec($ch);

                curl_close($ch);

                $json = json_decode( $json );
                
                $ilvl = $json->items->averageItemLevelEquipped;

                $message->message .= "__$name-__ \n";
                $message->message .= "`CLASS :  $spec $class`\n";
                
                if ( $role === 'DPS' ) {
                    
                } else {
                    $role = strtolower( $role );
                    $role = ucfirst( $role );
                }

                $message->message .= "`ROLE  :  $role`\n";
                $message->message .= "`SCORE :  $score`\n";
                $message->message .= "`ILVL  :  $ilvl`\n\n";
            }
            
            $message = json_encode( $message );
            echo $message;
            exit;
        }

    break;
   

}

?>
