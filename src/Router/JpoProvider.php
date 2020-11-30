<?php

namespace App\Router;

use Fw\LastBundle\Router\RouteProvider;
use Symfony\Component\HttpFoundation\Request;

class JpoProvider implements RouteProvider
{
    /**
     * {@inheritdoc}
     */
    public function getRoutes(): array
    {
        return [
            Request::create('/les-departements/tcsi'),
            Request::create('/les-departements/tc'),
            Request::create('/les-departements/gmp'),
            Request::create('/les-departements/geii'),
            Request::create('/les-departements/gim'),
            Request::create('/les-departements/gc'),
            Request::create('/les-departements/chimie'),
            Request::create('/les-departements/bio-d'),
            Request::create('/les-departements/gcgp'),
            Request::create('/les-departements/info-d'),
            Request::create('/les-departements/gea-d'),
            Request::create('/les-departements/gea-b'),
            Request::create('/les-departements/bio-b'),
            Request::create('/les-departements/gte'),
            Request::create('/les-departements/info-b'),
        ];
    }
}
