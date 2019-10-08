<?php

namespace Acti\VersionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Kernel;

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
        if($request->getMethod() === Request::METHOD_GET){
            if ($request->headers->get('apikey') === $this->token) {
                return $this->json([
                    'php' => (explode('-', phpversion()))[0],
                    'cms' => 'symfony-' . Kernel::VERSION,
                ]);
            } else {
                return $this->json([
                    'message' => 'Token invalide',
                ], 401);
            }
        } else {
            return $this->json([
                'message' => '404 route non trouvée',
            ], 404);
        }
    }
}