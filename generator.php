<?php

require_once "vendor/autoload.php";

$dataElements = json_decode(file_get_contents("definitions/profiles-types.json"), true);


$fhirAll = simplexml_load_file("definitions/fhir-all.xsd");

foreach ($fhirAll->children("http://www.w3.org/2001/XMLSchema") as $type) {

    $name = $type->getName();

    if ($name === "complexType") {
        $complexTypeName = (string)$type->attributes()['name'];
        if ($complexTypeName === 'Coding') {

            $class = new Nette\PhpGenerator\ClassType($complexTypeName);

            if ($type->annotation->documentation) {
                $class->addComment((string)$type->annotation->documentation);    
            }

            foreach ($type->complexContent->extension->sequence->element as $element) {
                $propertyType = (string)$element->attributes()['type'];
                $propertyMinOccurs = (int)$element->attributes()['minOccurs'];
                $propertyMaxOccurs = (int)$element->attributes()['maxOccurs'];

                $class->addProperty((string)$element->attributes()['name'])
                    ->addComment((string)$element->annotation->documentation)
                    ->setPrivate()
                    ->setType($propertyType);
            }
        
            // generate code simply by typecasting to string or using echo:
            echo $class;
            
        }
    }

}