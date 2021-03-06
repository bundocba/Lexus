<?php

if (!defined('_VALID_MOS') && !defined('_JEXEC')) die('Direct Access to ' . basename(__FILE__) . ' is not allowed.');

/**
 *
 * @package  VehicleManager
 * @copyright 2012 Andrey Kvasnevskiy-OrdaSoft(akbet@mail.ru); Rob de Cleen(rob@decleen.com); 
 * Homepage: http://www.ordasoft.com
 * @version: 3.0 Pro
 * @license GNU General Public license version 2 or later; see LICENSE.txt
 * */

class mosVehicleManagerOthers
{

    /**
     * Sets the parametes for connecting to a webservice via a
     * @param the array of parameters
     * @deprecated $Revision: 1.0 $ - December 2007
     */
    static function setParams()
    {
        global $vehiclemanager_configuration;

        // Prepare settings
        // Using single quotes is easier because you don't have to escape them. For every setting, add a line.
        $settings = "<?php\n";

        $settings .= "// Do not edit this file. Generated by admin script.\n";
        $settings .= "// VehicleManager Configuration file\n";
        $settings .= "// General Informations \n";
        $settings .= "\$vehiclemanager_configuration['release']['version']='" .
                $vehiclemanager_configuration['release']['version'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['release']['date']='" .
                $vehiclemanager_configuration['release']['date'] . "';\n";
        $settings .= "// edit vehicle \n";

        $settings .= "\$vehiclemanager_configuration['editvehicle']['default']['lang']='" .
                $vehiclemanager_configuration['editvehicle']['default']['lang'] . "';\n";
        $settings .= "// price settings\n";
        $settings .= "\$vehiclemanager_configuration['price']['show']='" .
                $vehiclemanager_configuration['price']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['price']['registrationlevel']='" .
                $vehiclemanager_configuration['price']['registrationlevel'] . "';\n"; // +17.01
        $settings .= "// auto increment for vehicleid, if 1 - can't add random vehicleid \n";
        $settings .= "\$vehiclemanager_configuration['vehicleid']['auto-increment']['boolean']='" .
                $vehiclemanager_configuration['vehicleid']['auto-increment']['boolean'] . "';\n";
        $settings .= "// review settings\n";
        $settings .= "\$vehiclemanager_configuration['reviews']['show']='" .
                $vehiclemanager_configuration['reviews']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['reviews']['registrationlevel']='" .
                $vehiclemanager_configuration['reviews']['registrationlevel'] . "';\n";


        $settings .= "// show contacts\n";
        $settings .= "\$vehiclemanager_configuration['Contacts']['show']='" .
                $vehiclemanager_configuration['Contacts']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration ['contacts']['registrationlevel']='" .
                $vehiclemanager_configuration ['contacts']['registrationlevel'] . "';\n";


// --------------------------community builder section------------------------

        $settings .= "// show cb_myvehicle\n";
        $settings .= "\$vehiclemanager_configuration['cb_myvehicle']['show']='" .
                $vehiclemanager_configuration['cb_myvehicle']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['cb_myvehicle']['registrationlevel']='" .
                $vehiclemanager_configuration['cb_myvehicle']['registrationlevel'] . "';\n";

        $settings .= "// show cb_edit\n";
        $settings .= "\$vehiclemanager_configuration['cb_edit']['show']='" .
                $vehiclemanager_configuration['cb_edit']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['cb_edit']['registrationlevel']='" .
                $vehiclemanager_configuration['cb_edit']['registrationlevel'] . "';\n";

        $settings .= "// show cb_rent\n";
        $settings .= "\$vehiclemanager_configuration['cb_rent']['show']='" .
                $vehiclemanager_configuration['cb_rent']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['cb_rent']['registrationlevel']='" .
                $vehiclemanager_configuration['cb_rent']['registrationlevel'] . "';\n";

        $settings .= "// show cb_buy\n";
        $settings .= "\$vehiclemanager_configuration['cb_buy']['show']='" .
                $vehiclemanager_configuration['cb_buy']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['cb_buy']['registrationlevel']='" .
                $vehiclemanager_configuration['cb_buy']['registrationlevel'] . "';\n";

        $settings .= "// show cb_history\n";
        $settings .= "\$vehiclemanager_configuration['cb_history']['show']='" .
                $vehiclemanager_configuration['cb_history']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['cb_history']['registrationlevel']='" .
                $vehiclemanager_configuration['cb_history']['registrationlevel'] . "';\n";

// --------------------------end community builder section---------------------    



        $settings .= "// show Location\n";

        $settings .= "\$vehiclemanager_configuration['Location_vehicle']['show']='" .
                $vehiclemanager_configuration['Location_vehicle']['show'] . "';\n";

        $settings .= "\$vehiclemanager_configuration ['Location_vehicle']['registrationlevel']='" .
                $vehiclemanager_configuration ['Location_vehicle']['registrationlevel'] . "';\n";



        $settings .= "\$vehiclemanager_configuration['Reviews_vehicle']['show']='" .
                $vehiclemanager_configuration['Reviews_vehicle']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration ['Reviews_vehicle']['registrationlevel'] ='" .
                $vehiclemanager_configuration ['Reviews_vehicle']['registrationlevel'] . "';\n";
        $settings .= "// rent settings\n";
        $settings .= "\$vehiclemanager_configuration['rentstatus']['show']='" .
                $vehiclemanager_configuration['rentstatus']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['rentrequest']['registrationlevel']='" .
                $vehiclemanager_configuration['rentrequest']['registrationlevel'] . "';\n";
        $settings .= "// buy settings\n";
        $settings .= "\$vehiclemanager_configuration['buystatus']['show']='" .
                $vehiclemanager_configuration['buystatus']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['buyrequest']['registrationlevel']='" .
                $vehiclemanager_configuration['buyrequest']['registrationlevel'] . "';\n";
        //PayPal
        $settings .= "// paypal buy settings\n";
        $settings .= "\$vehiclemanager_configuration['paypal_buy_status']['show']='" .
                $vehiclemanager_configuration['paypal_buy_status']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['paypal_buy']['registrationlevel']='" .
                $vehiclemanager_configuration['paypal_buy']['registrationlevel'] . "';\n";
               
        $settings .= "\$vehiclemanager_configuration['pay_pal_buy']['business']='" . $vehiclemanager_configuration['pay_pal_buy']['business'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['pay_pal_buy']['return']='" . $vehiclemanager_configuration['pay_pal_buy']['return'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['pay_pal_buy']['image_url']='" . $vehiclemanager_configuration['pay_pal_buy']['image_url'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['pay_pal_buy']['cancel_return']='" . $vehiclemanager_configuration['pay_pal_buy']['cancel_return'] . "';\n";
        
        $settings .= "//user manager\n";        
        $keys = array_keys( $vehiclemanager_configuration['user_manager_vm'] );
        // iterate through styles
        foreach( $keys as $key ){
            $settings .= "\$vehiclemanager_configuration['user_manager_vm']['$key']['count_car']='" . $vehiclemanager_configuration
            ['user_manager_vm'][$key]['count_car'] ."';\n";
            $settings .= "\$vehiclemanager_configuration['user_manager_vm']['$key']['count_foto']='" . $vehiclemanager_configuration
            ['user_manager_vm'][$key]['count_foto'] ."';\n";
        }
        $settings .= "// paypal rent settings\n";
        $settings .= "\$vehiclemanager_configuration['paypal_rent_status']['show']='" .
                $vehiclemanager_configuration['paypal_rent_status']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['paypal_rent']['registrationlevel']='" .
                $vehiclemanager_configuration['paypal_rent']['registrationlevel'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['pay_pal_rent']['business']='" . $vehiclemanager_configuration['pay_pal_rent']['business'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['pay_pal_rent']['return']='" . $vehiclemanager_configuration['pay_pal_rent']['return'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['pay_pal_rent']['image_url']='" . $vehiclemanager_configuration['pay_pal_rent']['image_url'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['pay_pal_rent']['cancel_return']='" . $vehiclemanager_configuration['pay_pal_rent']['cancel_return'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['paypal_real_or_test']['show']='" . $vehiclemanager_configuration['paypal_real_or_test']['show'] . "';\n";
        
        $settings .= "\$vehiclemanager_configuration['special_price']['show']='" . $vehiclemanager_configuration['special_price']['show'] . "';\n";
        
        $settings .= "// edoc settings\n";
        $settings .= "\$vehiclemanager_configuration['edocs']['allow']='" .
                $vehiclemanager_configuration['edocs']['allow'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['edocs']['show']='" .
                $vehiclemanager_configuration['edocs']['show'] . "';\n";

        $settings .= "\$vehiclemanager_configuration['edocs']['registrationlevel']='" .
                $vehiclemanager_configuration['edocs']['registrationlevel'] . "';\n";

        $settings .= "\$vehiclemanager_configuration['edocs']['location']='" .
                $vehiclemanager_configuration['edocs']['location'] . "';\n";
        $settings .= "// debuging\n";
        $settings .= "\$vehiclemanager_configuration['debug']='" .
                $vehiclemanager_configuration['debug'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['page']['items']='" .
                $vehiclemanager_configuration['page']['items'] . "';\n";
        $settings .= "// foto size\n";
        $settings .= "\$vehiclemanager_configuration['foto']['high']= '" .
                $vehiclemanager_configuration['foto']['high'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['foto']['width']= '" .
                $vehiclemanager_configuration['foto']['width'] . "';\n";

        $settings .= "\$vehiclemanager_configuration['fotomain']['high']= '" .
                $vehiclemanager_configuration['fotomain']['high'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['fotomain']['width']= '" .
                $vehiclemanager_configuration['fotomain']['width'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['fotogallery']['high']= '" .
                $vehiclemanager_configuration['fotogallery']['high'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['fotogallery']['width']= '" .
                $vehiclemanager_configuration['fotogallery']['width'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['fotogal']['high']= '" .
                $vehiclemanager_configuration['fotogal']['high'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['fotogal']['width']= '" .
                $vehiclemanager_configuration['fotogal']['width'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['fotoupload']['high']= '" .
                $vehiclemanager_configuration['fotoupload']['high'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['fotoupload']['width']= '" .
                $vehiclemanager_configuration['fotoupload']['width'] . "';\n";

        $settings .= "\$vehiclemanager_configuration['license']['show']='" .
                $vehiclemanager_configuration['license']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['license']['text']= '" .
                $vehiclemanager_configuration['license']['text'] . "';\n";

//*************************   begin add for Manager Suggestion: button 'Suggest a vehicle'   ******************************
        $settings .= "// button '[ Suggest a vehicle ]'\n";
        $settings .= "\$vehiclemanager_configuration['add_suggest']['show']='" .
                $vehiclemanager_configuration['add_suggest']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['add_suggest']['registrationlevel']='" .
                $vehiclemanager_configuration['add_suggest']['registrationlevel'] . "';\n";
//*****   end add for Manager Suggestion: button 'Suggest a vehicle'  ***********
//*************************   begin add for  Manager add_vehicle: button 'Add vehicle'    ******************************
        $settings .= "// button '[ Add vehicle ]'\n";
        $settings .= "\$vehiclemanager_configuration['add_vehicle']['show']='" .
                $vehiclemanager_configuration['add_vehicle']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['add_vehicle']['registrationlevel']='" .
                $vehiclemanager_configuration['add_vehicle']['registrationlevel'] . "';\n";
//*****    end add for  Manager add_vehicle: button 'Add vehicle'    ***********
//*************************   begin add for  Manager print_pdf: button 'print PDF'    ******************************
        $settings .= "// button '[ print PDF ]'\n";
        $settings .= "\$vehiclemanager_configuration['print_pdf']['show']='" .
                $vehiclemanager_configuration['print_pdf']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['print_pdf']['registrationlevel']='" .
                $vehiclemanager_configuration['print_pdf']['registrationlevel'] . "';\n";
//*****    end add for  Manager print_pdf: button 'print PDF'    ***********
//*************************   begin add for  Manager print_view: button 'print View'    ******************************
        $settings .= "// button '[ print View ]'\n";
        $settings .= "\$vehiclemanager_configuration['print_view']['show']='" .
                $vehiclemanager_configuration['print_view']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['print_view']['registrationlevel']='" .
                $vehiclemanager_configuration['print_view']['registrationlevel'] . "';\n";
//*****    end add for  Manager print_view: button 'print View'    ***********
//*************************   begin add for  Manager mail_to: button 'mail_to'    ******************************
        $settings .= "// button '[ mail_to ]'\n";
        $settings .= "\$vehiclemanager_configuration['mail_to']['show']='" .
                $vehiclemanager_configuration['mail_to']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['mail_to']['registrationlevel']='" .
                $vehiclemanager_configuration['mail_to']['registrationlevel'] . "';\n";
//*****    end add for  Manager mail_to: button 'mail_to'    ***********
//*************************   begin add send mail for admin  ************
        $settings .= "// send email for admin\n";

        $settings .= "\$vehiclemanager_configuration['addvehicle_email']['address']='" .
                $vehiclemanager_configuration['addvehicle_email']['address'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['addvehicle_email']['show']='" .
                $vehiclemanager_configuration['addvehicle_email']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['addvehicle_email']['registrationlevel']='" .
                $vehiclemanager_configuration['addvehicle_email']['registrationlevel'] . "';\n";

        $settings .= "\$vehiclemanager_configuration['review_email']['address']='" .
                $vehiclemanager_configuration['review_email']['address'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['review_added_email']['show']='" .
                $vehiclemanager_configuration['review_added_email']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['review_added_email']['registrationlevel']='" .
                $vehiclemanager_configuration['review_added_email']['registrationlevel'] . "';\n";

        $settings .= "\$vehiclemanager_configuration['suggest_email']['address']='" .
                $vehiclemanager_configuration['suggest_email']['address'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['suggest_added_email']['show']='" .
                $vehiclemanager_configuration['suggest_added_email']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['suggest_added_email']['registrationlevel']='" .
                $vehiclemanager_configuration['suggest_added_email']['registrationlevel'] . "';\n";

        $settings .= "\$vehiclemanager_configuration['rentrequest_email']['address']='" .
                $vehiclemanager_configuration['rentrequest_email']['address'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['rentrequest_email']['show']='" .
                $vehiclemanager_configuration['rentrequest_email']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['rentrequest_email']['registrationlevel']='" .
                $vehiclemanager_configuration['rentrequest_email']['registrationlevel'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['buyingrequest_email']['address']='" .
                $vehiclemanager_configuration['buyingrequest_email']['address'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['buyingrequest_email']['show']='" .
                $vehiclemanager_configuration['buyingrequest_email']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['buyingrequest_email']['registrationlevel']='" .
                $vehiclemanager_configuration['buyingrequest_email']['registrationlevel'] . "';\n";
//*************************   end add send mail for admin   *************
        //add for show in category picture
        $settings .= "// show in category picture\n";
        $settings .= "\$vehiclemanager_configuration['cat_pic']['show']='" .
                $vehiclemanager_configuration['cat_pic']['show'] . "';\n";

        
        
        // review approve
        $settings .= "\$vehiclemanager_configuration['approve_review']['show']='" . $vehiclemanager_configuration['approve_review']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['approve_review']['registrationlevel']='" . $vehiclemanager_configuration['approve_review']['registrationlevel'] . "';\n";
        
        
        
        
        //add for show subcategory
        $settings .= "// show subcategory\n";
        $settings .= "\$vehiclemanager_configuration['subcategory']['show']='" .
                $vehiclemanager_configuration['subcategory']['show'] . "';\n";

        $settings .= "\$vehiclemanager_configuration['approve_on_add']['show']='" . $vehiclemanager_configuration['approve_on_add']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['approve_on_add']['registrationlevel']='" . $vehiclemanager_configuration['approve_on_add']['registrationlevel'] . "';\n";

        $settings .= "\$vehiclemanager_configuration['publish_on_add']['show']='" . $vehiclemanager_configuration['publish_on_add']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['publish_on_add']['registrationlevel']='" . $vehiclemanager_configuration['publish_on_add']['registrationlevel'] . "';\n";

        //view type vehicles
        $settings .= "//all_categories\n";
        $settings .= "\$vehiclemanager_configuration['all_categories']='" .
                $vehiclemanager_configuration['all_categories'] . "';\n";

        $settings .= "//view type\n";
        $settings .= "\$vehiclemanager_configuration['view_type']='" .
                $vehiclemanager_configuration['view_type'] . "';\n";

        $settings .= "//view_vehicle\n";
        $settings .= "\$vehiclemanager_configuration['view_vehicle']='" .
                $vehiclemanager_configuration['view_vehicle'] . "';\n";
        
        // search layout select
        $settings .= "//show_search_vehicle\n";
        $settings .= "\$vehiclemanager_configuration['show_search_vehicle']='" .
                $vehiclemanager_configuration['show_search_vehicle'] . "';\n";
        
        // all_vechicle layout select
        $settings .= "//all_vehicle_layout\n";
        $settings .= "\$vehiclemanager_configuration['all_vehicle_layout']='" .
                $vehiclemanager_configuration['all_vehicle_layout'] . "';\n";

        //show location map
        $settings .= "//show location map\n";
        $settings .= "\$vehiclemanager_configuration['location_map']='" .
                $vehiclemanager_configuration['location_map'] . "';\n";
        //show manager_feature_image
        $settings .= "//manager_feature_image\n";
        $settings .= "\$vehiclemanager_configuration['manager_feature_image']='" .
                $vehiclemanager_configuration['manager_feature_image'] . "';\n";
        //manager_feature_category
        $settings .= "//manager_feature_category\n";
        $settings .= "\$vehiclemanager_configuration['manager_feature_category']='" .
                $vehiclemanager_configuration['manager_feature_category'] . "';\n";
        //sale_separator
        $settings .= "//sale_separator\n";
        $settings .= "\$vehiclemanager_configuration['sale_separator']='" .
                $vehiclemanager_configuration['sale_separator'] . "';\n";
        //show extra
        $settings .= "//extra1\n";
        $settings .= "\$vehiclemanager_configuration['extra1']='" .
                $vehiclemanager_configuration['extra1'] . "';\n";
        $settings .= "//extra2\n";
        $settings .= "\$vehiclemanager_configuration['extra2']='" .
                $vehiclemanager_configuration['extra2'] . "';\n";
        $settings .= "//extra3\n";
        $settings .= "\$vehiclemanager_configuration['extra3']='" .
                $vehiclemanager_configuration['extra3'] . "';\n";
        $settings .= "//extra4\n";
        $settings .= "\$vehiclemanager_configuration['extra4']='" .
                $vehiclemanager_configuration['extra4'] . "';\n";
        $settings .= "//extra5\n";
        $settings .= "\$vehiclemanager_configuration['extra5']='" .
                $vehiclemanager_configuration['extra5'] . "';\n";
        $settings .= "//extra6\n";
        $settings .= "\$vehiclemanager_configuration['extra6']='" .
                $vehiclemanager_configuration['extra6'] . "';\n";
        $settings .= "//extra7\n";
        $settings .= "\$vehiclemanager_configuration['extra7']='" .
                $vehiclemanager_configuration['extra7'] . "';\n";
        $settings .= "//extra8\n";
        $settings .= "\$vehiclemanager_configuration['extra8']='" .
                $vehiclemanager_configuration['extra8'] . "';\n";
        $settings .= "//extra9\n";
        $settings .= "\$vehiclemanager_configuration['extra9']='" .
                $vehiclemanager_configuration['extra9'] . "';\n";
        $settings .= "//extra10\n";
        $settings .= "\$vehiclemanager_configuration['extra10']='" .
                $vehiclemanager_configuration['extra10'] . "';\n";
        //update
        $settings .= "//update\n";
        $settings .= "\$vehiclemanager_configuration['update']='" .
                $vehiclemanager_configuration['update'] . "';\n";
        // *****  RSS *********
        $settings .= "\$vehiclemanager_configuration['rss']['show']='" . $vehiclemanager_configuration['rss']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['rss']['registrationlevel']='" . $vehiclemanager_configuration['rss']['registrationlevel'] . "';\n";
        // *****  RSS *********
        $settings .= "\$vehiclemanager_configuration['owner']['show']='" . $vehiclemanager_configuration['owner']['show'] . "';\n";
        // *****  Owners list *********
        $settings .= "\$vehiclemanager_configuration['ownerslist']['show']='" . $vehiclemanager_configuration['ownerslist']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['ownerslist']['registrationlevel']='" . $vehiclemanager_configuration['ownerslist']['registrationlevel'] . "';\n";
        // *****  END Owners list *********
        $settings .= "\$vehiclemanager_configuration['calendar']['show']='" . $vehiclemanager_configuration['calendar']['show'] . "';\n";
        // *****  Calendar list *********
        $settings .= "\$vehiclemanager_configuration['calendarlist']['show']='" . $vehiclemanager_configuration['calendarlist']['show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['calendarlist']['registrationlevel']='" . $vehiclemanager_configuration['calendarlist']['registrationlevel'] . "';\n";
        // *****  END Calendar list *********
        $settings .= "\$vehiclemanager_configuration['rent_answer']='" . $vehiclemanager_configuration['rent_answer'] . "';\n";
        //******* Rent Request form******
        //$settings .= "\$vehiclemanager_configuration['rent_form']='" . $vehiclemanager_configuration['rent_form'] . "';\n";
        //******* Buy Request form******
        $settings .= "\$vehiclemanager_configuration['buy_answer']='" . $vehiclemanager_configuration['buy_answer'] . "';\n";

        $settings .= "\$vehiclemanager_configuration['buy_form']='" . $vehiclemanager_configuration['buy_form'] . "';\n";

        $settings .= "//end rent notify\n";
        $settings .= "\$vehiclemanager_configuration['rent_before_end_notify']='" . $vehiclemanager_configuration['rent_before_end_notify'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['rent_before_end_notify_days']='" . $vehiclemanager_configuration['rent_before_end_notify_days'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['rent_before_end_notify_email']='" . $vehiclemanager_configuration['rent_before_end_notify_email'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['calendar']['placeholder']='" . $vehiclemanager_configuration['calendar']['placeholder'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['featuredmanager']['placeholder']='" . $vehiclemanager_configuration['featuredmanager']['placeholder'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['currency']='" . $vehiclemanager_configuration['currency'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['allowed_exts']='" . $vehiclemanager_configuration['allowed_exts'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['allowed_exts_img']='" . $vehiclemanager_configuration['allowed_exts_img'] . "';\n";
                
        $settings .= "\$vehiclemanager_configuration['price_format']='" . $vehiclemanager_configuration['price_format'] . "';\n";
        $settings .= "// 1 - affter 0 - beffore\n";
        $settings .= "\$vehiclemanager_configuration['price_unit_show']='" . $vehiclemanager_configuration['price_unit_show'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['date_format']='" . $vehiclemanager_configuration['date_format'] . "';\n";
        $settings .= "\$vehiclemanager_configuration['datetime_format']='" . $vehiclemanager_configuration['datetime_format'] . "';\n";

        $settings .= "?>";

        // Write out new initialization file
        $fd = fopen("./components/com_vehiclemanager/admin.vehiclemanager.class.conf.php", "w")
                or die("Cannot create configuration file.");
        fwrite($fd, $settings);
        fclose($fd);
    }

    /**
     * Rating Array
     * @return array an Array containing the information of all Rating
     * possibilities
     */
    static function getRatingArray()
    {
        $i = 0;
        $retVal = array();
        while ($i < 5) {
            //erster teil x,0
            $tmp = $i * 2;
            array_push($retVal, array($tmp, $i . ",0"));
            //zweiter teil x,5
            $tmp++;
            array_push($retVal, array($tmp, $i . ",5"));
            $i++;
        }
        array_push($retVal, array(10, "10,0"));
        return $retVal;
    }

    /**
     * Language Array - defined in the language files!
     * @return array an Array containing the information of all Language
     * possibilities
     */
    static function getLanguageArray()
    {
        $retVal = array();
        array_push($retVal, array("Not specified", _VEHICLE_MANAGER_LANGUAGE_NOT_USED));
        array_push($retVal, array("Arabic", _VEHICLE_MANAGER_LANGUAGE_AR));
        array_push($retVal, array("Brazilian Portuguese", _VEHICLE_MANAGER_LANGUAGE_PTBR));
        array_push($retVal, array("Danish", _VEHICLE_MANAGER_LANGUAGE_DK));
        array_push($retVal, array("Dutch", _VEHICLE_MANAGER_LANGUAGE_DUT));
        array_push($retVal, array("English", _VEHICLE_MANAGER_LANGUAGE_ENG));
        array_push($retVal, array("Farsi", _VEHICLE_MANAGER_LANGUAGE_FAR));
        array_push($retVal, array("French", _VEHICLE_MANAGER_LANGUAGE_FRE));
        array_push($retVal, array("German", _VEHICLE_MANAGER_LANGUAGE_GER));
        array_push($retVal, array("Hungarian", _VEHICLE_MANAGER_LANGUAGE_HUN));
        array_push($retVal, array("Italian", _VEHICLE_MANAGER_LANGUAGE_ITA));
        array_push($retVal, array("Lithuanian", _VEHICLE_MANAGER_LANGUAGE_LI));
        array_push($retVal, array("Norwegian", _VEHICLE_MANAGER_LANGUAGE_NR));
        array_push($retVal, array("Polish", _VEHICLE_MANAGER_LANGUAGE_POL));
        array_push($retVal, array("Portuguese", _VEHICLE_MANAGER_LANGUAGE_PR));
        array_push($retVal, array("Romanian", _VEHICLE_MANAGER_LANGUAGE_ROM));
        array_push($retVal, array("Russian", _VEHICLE_MANAGER_LANGUAGE_RUS));
        array_push($retVal, array("Spanish", _VEHICLE_MANAGER_LANGUAGE_SPA));
        array_push($retVal, array("Turkish", _VEHICLE_MANAGER_LANGUAGE_TUR));
        return $retVal;
    }

    static function getMakersArray()
    {
        global $mosConfig_absolute_path;
        $filename = $mosConfig_absolute_path . "/components/com_vehiclemanager/makers_and_models.txt";
        $handle = fopen($filename, "r");
        $makers_and_models = fread($handle, filesize($filename));
        fclose($handle);
        $cars = explode(';', $makers_and_models);
        $c = 0;
        foreach ($cars as $car) {
            if (trim($car) != '')
            {
                $mak = explode(':', $car);
                $makerslist[0][$c] = trim($mak[0]);
                $models = explode(',', $mak[1]);
                foreach ($models as $model) {
                    $makerslist[1][$c][] = trim($model);
                }
            }
            $c++;
        }
        return $makerslist;
    }

}
