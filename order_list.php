<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mmarcus
 * Date: 8/5/13
 * Time: 8:44 PM
 * To change this template use File | Settings | File Templates.
 */

function stepSort( $a, $b ) {
    $aOrder = (int)$a->attributes()['order'];
    $bOrder = (int)$b->attributes()['order'];
    return $aOrder == $bOrder ? 0 :( $aOrder < $bOrder ) ? -1 : 1;
}

$xml=simplexml_load_file("pasta.xml");
$steps = $xml->instructions->children();
$stepsArray = array();

//Put into array so we can use usort.
foreach ($steps as $step){
    $stepsArray[] = $step;
}

usort($stepsArray, 'stepSort');

foreach($stepsArray as $step){
    echo 'Step #' . $step->attributes()['order'] . ': ' . $step . PHP_EOL;
}