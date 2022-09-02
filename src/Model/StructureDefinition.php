<?php

namespace FhirGenerator\Model;

use DateTime;
use DateTimeImmutable;

class StructureDefinition extends Resource {

    public string $url;
    
    public string $version;

    public string $name;

    public PublicationStatus $status;

    public DateTimeImmutable $date;

    public string $publisher;

    public string $kind;

    public bool $abstract;

    public static function fromJson($j): self 
    {
    
        $b = new self();
    //    $b->fullUrl = $j['fullUrl'];
        $b->id = $j['id'];
        $b->url = $j['url'];
        $b->url = $j['version'];
        $b->status = PublicationStatus::from($j['status']);

        var_dump($j['snapshot']['element']);

        return $b;
    }
}