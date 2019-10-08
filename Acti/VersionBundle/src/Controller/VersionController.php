<?php

namespace Acti\VersionBundle\Controller;

use App\Kernel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class VersionController extends AbstractController
{
    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function renderVersion(Request $request)
    {
        dump($request);

//        die();

//        if($request->getMethod() === 'GET'){
            if ($request->query->get('token_version') === $this->token) {
                return $this->json([
                    'php' => (explode('-', phpversion()))[0],
                    'cms' => 'symfony-' . Kernel::VERSION,
                ]);
            } else {
                throw $this->createAccessDeniedException();
            }
//        }

    }
}