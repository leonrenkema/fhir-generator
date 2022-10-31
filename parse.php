<?php

use FhirGenerator\Model\Bundle;

function mapType($code): string {
    switch ($code) {
        case 'http://hl7.org/fhirpath/System.String':
            return 'string';
    }
    return $code;
}

require_once "vendor/autoload.php";

$dataElements = json_decode(file_get_contents("definitions/profiles-types.json"), true);

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader, [
    'cache' => 'cache',
    'debug' => true
]);

$template = $twig->load('class.php.twig');

$bundle = Bundle::fromJson($dataElements);


foreach ($dataElements['entry'] as $entry) {

    if ($entry['resource']['kind'] != 'complex-type') {
        continue;
    }

    $elements = $entry['resource']['snapshot']['element'];

    $attributes = [];
    $listsToMake = [];

    foreach ($elements as $element) {

        $idPieces = explode('.', $element['id']);

        if (isset($idPieces[1])) {

            // "type" : [{
            //    "code" : "CodeableConcept"
            //  }],
            $dataType = mapType($element['type'][0]['code']);

            if ($element['max'] === '*') {
                $multiple = true;
                $listsToMake[] = [
                    'name' => $dataType,
                ];
            } else {
                $multiple = false;
            }

            $attributes[] = [
                'id' => $idPieces[1],
                'dataType' => $dataType,
                'description' => $element['short'],
                'multiple' => $multiple,
                //'name' => $element['name']
            ];
        }
    }

    $renderedClass = $template->render([
        'namespace'     => 'App\Fhir\Model',
        'fullUrl'       => $entry['fullUrl'],
        'name'          => $entry['resource']['id'],
        'description'   => $entry['resource']['description'],
        // 'baseDefinition' => $entry['resource']['baseDefinition'],
        'attributes'    => $attributes,
    ]);

    $fileName = "output/" . $entry['resource']['id'] . ".php";
    file_put_contents($fileName, $renderedClass);


    foreach ($listsToMake as $listToMake) {
        //var_dump($listToMake);
    }
}
