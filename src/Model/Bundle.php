<?php

namespace FhirGenerator\Model;

class Bundle {
    public string $id;

    public string $type;

    public array $entry = [];

    public static function fromJson(array $inputJson) : Bundle {

        $b = new Bundle();
        $b->id = $inputJson['id'];
        $b->type = $inputJson['type'];
        
        foreach($inputJson['entry'] as $entry) {
            $b->entry[] = BundleEntry::fromJson($entry);
        }

        return $b;
    }
}