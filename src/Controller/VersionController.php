<?php

namespace Acti\VersionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Kernel;

class VersionController extends AbstractController
{
    private $token;

    private $path;

    public function __construct($token, $path)
    {
        $this->token = $token;
        $this->path = $path;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function renderVersion(Request $request)
    {
        if($request->getMethod() === Request::METHOD_GET){
            if ($request->headers->get('apikey') === $this->token) {

                $composerLock = null;
                $plugins = [];

                try {
                    $composerLock = json_decode(file_get_contents($this->path.'/composer.lock'));
                } catch (\Exception $e){
                    // on ne fait rien
                }

                if(!empty($composerLock->packages)) {
                    foreach ($composerLock->packages as $package){
                        if(substr($package->version, 0, 1) === 'v'){
                            $plugins[$package->name] = substr($package->version, 1);
                        } else {
                            $plugins[$package->name] = $package->version;
                        }
                    }
                }

                return $this->json([
                    'php' => (explode('-', phpversion()))[0],
                    'cms' => 'symfony-' . Kernel::VERSION,
                    'plugins' => $plugins,
                ], 200);
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