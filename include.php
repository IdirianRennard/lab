<?php
session_start();
include "include/credentials.php";
include "include/rest_functions.php";

//JS setup for initialization
echo "<script> \n\n";

// Broswer Detection
include "include/browser_detection.php";
  $browser = new Wolfcast\BrowserDetection();
  echo "console.log( 'BROWSER : " . $browser->getName() ."' )\n";

echo "\n";

// Set return URLs for any location in lab, made for local host
  $return_file_path = 'https://localhost' . rtrim(  $_SERVER['PHP_SELF'], basename( $_SERVER['PHP_SELF'] ) );
  echo "let rfp = '$return_file_path'; \n";
  echo "console.log( 'RETURN FILE PATH: ' + rfp ) \n";

echo "\n";

//End JS Initialization;
echo "</script>";

//Output _GET['dt'] to the console
if ( isset( $_GET['dt'] ) ) {
  $dt = $_GET['dt'];

  $dt = urldecode( base64_decode( $dt ) );
  
  parse_str( $dt, $dt );
  
  ksort( $dt );
  console( $dt );
}
?>

<title>Idirian's Lab</title>
<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/jquery-ui-git.css" >
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://momentjs.com/downloads/moment.js"></script>
<script src="js/scripts.js"></script>
<link rel="stylesheet" href="css/ui_mod.css">

<div id='tabs'></div>

<div class='right_nav' id='accordion'></div>

<div id='warning'></div>

<script>;
  $(document).ready( function () {
    let tabs = '';
    //Get Accordion data 
    $.getJSON ( 'ajax/accordion.php', function ( data ) {


      // Loop through data, create each fold;
      $.each( data , function( index , value )  {
        let fold = 
          "<h3>  " + value.name + "</h3>" + 
          "<div id='" + index + "'></div>";
        
        $( '#accordion' ).append( fold );


        //Fill each fold;
        $.each( value.p , function ( k , v ) {
          let p = '<p id="' + index + '-p' + k + '" align="' + v.align + '"></p>';

          $( '#' + index ).append( p );
          $( '#' + index + '-p' + k ).append( v.value );
        } );
      } );


      //Set spaces bewtten sandbox toggle and open button
      let spaces =  Number( $( '#admin-spaces' ).text() );
      $( '#admin-spaces' ).text( '' );
      let new_spaces = '';
      for ( let i = 0 ; i < spaces ; i++ ) {
        new_spaces += '\xa0';
      }
      $( '#admin-spaces' ).text( new_spaces );


      //Accodion view for Right Menu
      $( function() {
        var icons = {
          header: "ui-icon-circle-plus",
          activeHeader: "ui-icon-circle-minus"
        };

        $( "#accordion" ).accordion( {
          active : false,
          collapsible : true,
          heightStyle : "content",
          icons : icons
        } );
      } );
    } );


    //Accordion.Splunk set dropdown from splunk array menu
    $.getJSON ( 'ajax/splunk_drop.php', function ( data ) {
      $.each( data , function ( k , v ) {
        $( '#cave_app' ).append ( new Option( v , k ) );
      } )
    } );
    

    //Get tab data
    $.getJSON ( 'ajax/tabs.php', function ( data ) {
      tabs = data;
      
      let found = false ;
      let active = 0;

      let tab_names = "<ul class='tabs tabs_nav' id='myTabs'>";

      
      //Set tab names
      $.each( data , function ( key, value ) {
        if ( found ) {

        } else { 
          if ( key == 'pypl' ) {
            found = true; 
          } else {
            active++;
          }
        }
      
        tab_names += "<li><a href='#" + key + "'>" + value + "</li>";
      } )
      
      tab_names += "</ul>";


      //Set tab fill
      $.each( data , function ( key, value ) {
        tab_names += '<div id="' + key + '"><p id="' + key + '-inner"></p></div>';
      } )
      
      $( "#tabs" ).html( tab_names );
      
      //Tabs for titlebar
      $( function() {
        $( "#tabs" ).tabs( {
          active: active
        } );
      } );


      //Modify CSS for tab fill
      $( '#tabs' ).css( 'border-width', '0px' );

      $.each( data, function ( key, value ) {
        $( '#' + key ).css( 'padding' , '0' );
        $( '#' + key + '-inner' ).css( 'margin', '0' );
      } );
      
    } ).done( function() {

      //Get the PayPal Tab's menus
      $.getJSON ( 'ajax/pypl_menu.php', function ( data ) {

        let width = data.width;
        delete data.width; 

        //Write the PayPal Tab's Titlebar, Menus, and Listeners
        let titlebar =
        "<table class='titlebar'>" +
          "<tr>" +
            "<td colspan='42' align='center'><a href='./'><font color='#003D6B'>Idirian's Lab</font></a></td>" +
          "</tr>" +
          "<tr><td><font size='4em'><br></font></td></tr>" +
          "<tr>";


          //Write the PayPal Tab's menu names
          $.each( data , function ( key, value ) {
            let vis_k = key.replace( '_', ' ');

            titlebar += 
              "<td align='center' width='" + width + "'>" +
                "<table>" +
                  "<tr>" + 
                    "<td class='nav_menu' id='" + key + "'>" + vis_k + "  <i class='arrow down'></i></td>" + 
                  "</tr>" +
                  "<tr>" +
                    "<td>" + 
                      "<div id='" + key + "-drop' class='hover-content'>"; 
            
              
              //Write PayPal Tab's menu contents
              if ( key == 'Helpful_Links' ) {

                //If Helpful_Links menu, open in new tab
                $.each( value , function ( page, page_name ) {
                  titlebar += "<a class='menu_link' href='" + page + "' target='_blank'>" + page_name + "</a>";
                } )
              } else {

                //Links to each option
                $.each( value , function ( page, page_name ) {
                  titlebar += "<a class='menu_link' href='" + page + ".php#pypl'>" + page_name + "</a>";
                } )
              }

            titlebar += "</div></td></tr></table></td>";
          } );

        
          //Close PayPal Tab's menu row and table
          titlebar += "</tr></table>";

          
          //Execute writing of the PayPal Tab contents
          $( '#pypl-inner').html ( titlebar );


          //Write the listeners for PayPal menus
          $.each( data, function ( key, value ) {
            $( '#' + key ).on( 'mouseenter', function(e) {
            $( '#' + key + '-drop' ).slideDown( 'fast' );
          } ); 

          $( '#' + key + '-drop' ).on( 'mouseleave', function(e) {
            $( '#' + key + '-drop' ).slideUp( 'medium' );
          } );
        } );


        //Activate Date Pickers
        $( function() {
          $( "#cal_start_datepicker" ).datepicker( );
        } );

        $( function() {
          $( "#cal_end_datepicker" ).datepicker( );
        } );

        $( function() {
          $( "#cave_start_datepicker" ).datepicker( );
        } );

        $( function() {
          $( "#cave_end_datepicker" ).datepicker( );
        } );


        $( function() {
          $( "#tl_start_datepicker" ).datepicker( );
        } );

        $( function() {
          $( "#tl_end_datepicker" ).datepicker( );
        } );
      } );
    } );
  } );
</script>
