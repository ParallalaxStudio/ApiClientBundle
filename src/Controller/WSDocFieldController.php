<?php

namespace Parallalax\ApiClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class WSDocFieldController extends WSDocController {

    /**
     * get th parameters of the element : call the ws
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws \AppBundle\Exception\CustomException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAction(Request $request, $id) {
        
        if($request->isXmlHttpRequest()) {
            $wsResponse= $this->restClient->send('GET', 'field/'. $id);
            $response = new JsonResponse();
            $response->setData(json_decode($wsResponse->getBody()));
            return $response;
        }
        else {
            throw new \Exception('Ajax is not an option, get to work !');
        }
    }
}
