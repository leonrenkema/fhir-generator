<?php

use FhirGenerator\Model\Bundle;

function mapType($code): string {
    switch ($code) {
        case 'http://hl7.org/fhirpath/System.String':
            return 'string';
    }
    return $code;
}

function formatEnumCase(string $value) : string {
    return ucfirst($value);
}

require_once "vendor/autoload.php";

$dataElements = json_decode(file_get_contents("definitions/valuesets.json"), true);

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader, [
    'cache' => 'cache',
    'debug' => true
]);

$template = $twig->load('enum.twig');

//var_dump($dataElements);

foreach ($dataElements['entry'] as $entry) {

    $resource = $entry['resource'];

    echo $resource['name'] . "\n";

    if (isset($resource["status"]) && $resource["status"] != "active") {
        continue;
    }

    if (!isset($resource['concept'])) {
        continue;
    }

    $concepts = $resource['concept'];
    
    $enumValues = [];
    if ($concepts) {
        foreach ($concepts as $concept) {
            $enumValues[] = [
                'name' => formatEnumCase($concept["code"]),
                'value' => $concept["code"],
            ];
        }    
    }
    
    $renderedClass = $template->render([
        'namespace'     => 'App\Fhir\Model\Enum',
        'name'          => $resource['name'],
        'description'   => $resource['description'],
        'enumValues'    => $enumValues,
    ]);

    $fileName = "output/Enum/" . $resource['name'] . ".php";
    file_put_contents($fileName, $renderedClass);
}
