<?php

/* Admin Menu */



/*Add a Top-Level Menu */

add_action('admin_menu', 'mptracking_options_page');

function mptracking_options_page(){


    add_menu_page(

        'MPTracker',

        'MPTracker',

        'manage_options',

        'mptracking',

        'mptracking_options_page_html', /*Ruft Methode auf zum Darstellen der Seite*/

        'dashicons-visibility',

        21

    );

}



/*VIEW HTML*/

function mptracking_options_page_html(){

    // check user capabilities

    if (!current_user_can('manage_options')) {

        return;

    }

    ?>

    <div class="wrap">

        <h1><?= esc_html(get_admin_page_title());?></h1>

        <?php settings_errors(); ?>

        <form method="post" action="options.php">
            <?php

            // output security fields for the registered setting "wporg_options"

            settings_fields('mptracking-settings-group'); /*Einstellungsgruppe wird gebraucht, um Einstellungen zu speichern.*/

            // output setting sections and their fields

            // (sections are registered for "wporg", each field is registered to a specific section)

            do_settings_sections('MpTracking');

            // output save settings button

            submit_button();

            ?>

            

        </form>
        <div>© 2021 mpcoding   -   made by Maik Proba</div>
    </div>

    <?php

}
/************************************ */

/*Einstellungen*/
add_action('admin_menu', 'mpTracking_settings');
function mpTracking_settings(){
    /*Register*/
    register_inputfields();
    
    add_settings_section( 
        'mptracking-options', /*Wird für jedes Field benötigt*/
        'Allgemein', 
        'mpTracking_options', /*Funktion wird aufgerufen*/ 
        'MpTracking'
    );

    //Filter URL Funktion erstmal deaktiviert!
    /*add_settings_field( 
        "mpTrackingAllgemein", 
        '<span class="dashicons dashicons-filter"></span> Filter', 
        'filterUrl', //Funktion, die Aufgerufen wird
        'MpTracking',
        'mptracking-options'
    );*/

    //Cookie Zeiten
    add_settings_field ( 
        "mpTrackingTimer", 
        '<span class="dashicons dashicons-backup"></span> Aktualisierung der Cookies', 
        'cookieTimer', //Funktion, die Aufgerufen wird
        'MpTracking',
        'mptracking-options'
    );

    //Tracking Color
    add_settings_field ( 
        "mpTrackingColor", 
        '<span class="dashicons dashicons-color-picker"></span> Farbe der markierten URL', 
        'trackingColor', //Funktion, die Aufgerufen wird
        'MpTracking',
        'mptracking-options'
    );

    //Tracker Url
    add_settings_field ( 
        "mpTrackingURL", 
        '<span class="dashicons dashicons-welcome-view-site"></span> Webseite', 
        'trackingUrl', //Funktion, die Aufgerufen wird
        'MpTracking',
        'mptracking-options'
    );
}

function mpTracking_options(){
    echo '';
}

function register_inputfields(){
    register_setting( "mptracking-settings-group", "filterTextbox");
    register_setting( "mptracking-settings-group", "counter");

    /*Cookie Timer*/
    register_setting( "mptracking-settings-group", "cookieTimer" );

    /*Color Tracking*/
    register_setting( "mptracking-settings-group", "trackerColor" );

    /*Url Tracking*/
    register_setting( "mptracking-settings-group", "trackerUrl" );
    /*for ($i = 1; $i <= 10; $i++) {
        register_setting( "mptracking-settings-group", "newInputBox_" . $i);
    }*/
    
}

function cookieTimer(){
    $cookieTimer = esc_attr( get_option('cookieTimer') );

    echo "<input id='cookieTimer' name='cookieTimer' type='number' min='1' max='60' value='" . $cookieTimer . "'>"
    . "<p>(in Minuten)</p>";
}

function trackingColor(){
    $colorTracker = esc_attr( get_option('trackerColor') );
    
    echo "<input type='color' id='trackerColor' name='trackerColor' value='" . $colorTracker ."'>"
    . "<p>Farbe der URL, die unter Bestellung bei Referrer URL markiert wird.</p>";
}

function trackingUrl(){
    $urlTracker = esc_attr( get_option('trackerUrl') );
    
    echo "<input type='text' id='trackerUrl' name='trackerUrl' value='" . $urlTracker ."' placeholder='google.com'>"
    . "<p>Die getrackte Webseite</p>";
}



/*getracke URLs filtern nach Angaben*/
/*function filterUrl(){
    $filter = esc_attr( get_option('filterTextbox') );
    $counter = esc_attr( get_option('counter') );

    
    
    
    echo "<div class='mpTrackingFilter'>" 
    . "<input id='filterText' type='text'>"
    . "<button id='addFilter'><span class='dashicons dashicons-insert'></span></button>"
    . "<span id='filterAlert'></span>"
    . "<br><br> "
    . "<textarea style='width: 400px; height: 100px;' id='filterTextbox' name='filterTextbox' readonly>" . $filter ."</textarea>"
    . "<button id='clearTextbox'>Clear Textbox</button>"
    /* "<br><br> "
    . "<table id='filterTable' style='width:500px'><tr><th>URL:</th></tr></table>"
    . "<br><br>"
        . "<div id='filters'>";

        for ($i = 1; $i <= 10; $i++) {
            $inputFields = esc_attr( get_option('newInputBox_' . $i) );
            var_dump($inputFields);
            if(strlen($inputFields) > 0){
                echo "<div>" 
                . "<input type='text' name='newInputBox' id='newInputBox' value='" . $inputFields  . "' readonly>"
                //. "<button id='deleteButton'>Löschen</button>"
                . "</div>";
            }
        }
        echo "</div>"
    . "</div>"
    . "<div name='counter' id='counter'>". $counter ."</div>";



    /*echo '<Textarea id="Description" name="Description">'.$Description.'</Textarea>
    <label id="Result"></label>
    <p><em>The Description should have at least <span style="color: red">140</span> characters. Everything below is <span style="color: red;">bad</span>.</p> 
    <p>Anything between <span style="color: orange">140</span> and <span style="color: orange">150</span> characters is <span style="color: orange">OK</span>. 160 characters are <span style="color: green">perfect</span>. </em></p>
    ';
}*/


