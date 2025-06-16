<?php

namespace Cipika\League\Plates;

use League\Plates\Engine;
use Cipika\League\Plates\Extension\CiCompatibility;
use Cipika\League\Plates\Extension\FrontendMemberExtension;
use Cipika\League\Plates\Extension\UriSegmentExtension;
use Cipika\League\Plates\Extension\CartExtension;
use Cipika\League\Plates\Extension\HtmlQueryExtension;
use Cipika\League\Plates\Extension\LibFacebook;
use Cipika\League\Plates\Extension\LibRecaptcha;
use Cipika\League\Plates\Extension\CategoryGenerator;
use Cipika\League\Plates\Extension\CategoryExtension;
use Cipika\League\Plates\Extension\LibLokasiExtension;
use Cipika\League\Plates\Extension\MemberAreaExtension;
use Cipika\League\Plates\Extension\ProductExtension;
use Cipika\League\Plates\Extension\SessionFlashdataExtension;
use Cipika\League\Plates\Extension\SessionExtension;
use Cipika\League\Plates\Extension\AuthExtension;
use Cipika\League\Plates\Extension\MegaMenuExtension;
use Cipika\League\Plates\Extension\MatrixExtension;
use Cipika\League\Plates\Extension\PartnerExtention;
use Cipika\League\Plates\Extension\FooterExtension;

class EngineFactory
{
    public function createEngine($path)
    {
        $engine = new Engine($path);
        $engine->loadExtension(new CiCompatibility());
        $engine->loadExtension(new FrontendMemberExtension());
        $engine->loadExtension(new UriSegmentExtension());
        $engine->loadExtension(new CartExtension());
        $engine->loadExtension(new HtmlQueryExtension());
        $engine->loadExtension(new LibFacebook());
        $engine->loadExtension(new LibRecaptcha());
        $engine->loadExtension(new CategoryGenerator());
        $engine->loadExtension(new CategoryExtension());
        $engine->loadExtension(new LibLokasiExtension());
        $engine->loadExtension(new MemberAreaExtension());
        $engine->loadExtension(new ProductExtension());
        $engine->loadExtension(new SessionFlashdataExtension());
        $engine->loadExtension(new SessionExtension());
        $engine->loadExtension(new AuthExtension());
        $engine->loadExtension(new MegaMenuExtension());
        $engine->loadExtension(new MatrixExtension());
        $engine->loadExtension(new PartnerExtention());
        $engine->loadExtension(new FooterExtension());

        return $engine;
    }
}
