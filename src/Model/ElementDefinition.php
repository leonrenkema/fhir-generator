<?php

namespace FhirGenerator\Model;

class ElementDefinition {

    public string $path;
    
    public string $label;

    public static function fromJson($j): self {
        $o = new self();
        $o->path = $j['path'];
        $o->label = $j['label'];

        return $o;
    }
}