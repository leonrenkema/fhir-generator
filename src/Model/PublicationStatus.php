<?php

namespace FhirGenerator\Model;

enum PublicationStatus: string {
    case draft = 'draft';
    case active = 'active';
    case retired = 'retired';
    case unknown = 'unknown';
}