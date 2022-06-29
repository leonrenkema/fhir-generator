<?php

namespace FhirGenerator\Model;

class Resource {
    
    public string $resourceType;

    public string $id;

    public static function fromJson(array $inputJson) : Resource {

        $b = new Resource();
        
        $b->id = $inputJson['id'];
        $b->resourceType = $inputJson['resourceType'];

        return $b;
    }
}