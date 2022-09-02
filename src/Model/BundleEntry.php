<?php

namespace FhirGenerator\Model;

class BundleEntry {
    public string $fullUrl;

    public Resource $resource;

    public static function fromJson(array $inputJson) : BundleEntry {

        $b = new BundleEntry();
        
        $b->fullUrl = $inputJson['fullUrl'];

        $resourceType = 'FhirGenerator\\Model\\' . $inputJson['resource']['resourceType'];
        $b->resource = $resourceType::fromJson($inputJson['resource']);
        //$b->resource = Resource::fromJson($inputJson['resource']);

        return $b;
    }
}