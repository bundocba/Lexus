<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

?>
<div id="last_added" style="overflow:hidden;">
    <div class="vehiclemanager_<?php echo "$moduleclass_sfx"; ?>" >           

<?php
foreach ($rows as $row) {
    $comment = $row->description;
    $prevwords = count(explode(" ", $comment));
    if (trim($g_words == ""))
        $words = $prevwords;
    else
        $words = intval($g_words);
    $text = implode(" ", array_slice(explode(" ", $comment), 0, $words));
    if (count(explode(" ", $text)) < $prevwords) {
        $text .= "";
    }
    $link1 = "index.php?option=com_vehiclemanager&amp;task=view_vehicle&amp;id="
            . $row->id . "&amp;catid=" . $row->catid . "&amp;Itemid=" . $ItemId_tmp;
    $imageURL = $row->image_link;
        if ($imageURL != '') {
            // quality of img from module   
            $image_source_type = $params->get('image_source_type');
            switch ($image_source_type) {
                case "0": $img_height = $vehiclemanager_configuration['fotoupload']['high'];
                    $img_width = $vehiclemanager_configuration['fotoupload']['width'];
                    break;
                case "1": $img_height = $vehiclemanager_configuration['fotomain']['high'];
                    $img_width = $vehiclemanager_configuration['fotomain']['width'];
                    break;
                case "2": $img_height = $vehiclemanager_configuration['fotogal']['high'];
                    $img_width = $vehiclemanager_configuration['fotogal']['width'];
                    break;
                default:$img_height = $vehiclemanager_configuration['fotoupload']['high'];
                    $img_width = $vehiclemanager_configuration['fotoupload']['width'];
                    break;
            }
            
            $imageURL1 = picture_thumbnail($imageURL, $img_height, $img_width);
            $imageURL = "./components/com_vehiclemanager/photos/" . $imageURL1;
        }
        else {
            $imageURL = "./components/com_vehiclemanager/images/no-img_eng.gif";
            
        }
    ?>

            <div class="new_all" style="background:<?php echo $background; ?>; float:<?php if ($displaytype == 1) {
        echo "left";
    } else {
        echo "none";
    } ?>;">
    <?php if ($showcover == 1) { ?>
                    <div class="new_image">
                        <a href="<?php echo sefRelToAbs($link1); ?>" target="_self">
                            <img src="<?php echo $imageURL; ?>" style="height: <?php echo $coversize; ?>px" />
                        </a>
                    </div>	
    <?php } ?>

                <div class="new_title">
                    <p><?php if ($showtitle == "1") {
        echo $row->vtitle;
    } ?></p>
                </div>
                <div class="new_text">
                    <p><?php if ($showdescription == "1") {
        echo $text;
    } ?></p>
                </div>
            </div>
<?php } ?>
    </div>
</div>
<div style="text-align: center;"><a href="http://ordasoft.com" style="font-size: 10px;">Powered by OrdaSoft!</a></div>
