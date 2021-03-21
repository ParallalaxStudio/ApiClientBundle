<?php

namespace Parallalax\ApiClientBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/field", name="apiclient_field_")
 *
 * Security ("user.getCompany().getParent() === null")
 */
class DocumentFieldController extends DocumentController {

    /**
     * get the parameters of the element : call the ws
     *
     * @Route("/get/{id<\d+>?}", name="edit")
     *
     * @throws \App\Exception\CustomException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($id): object
    {
        $wsResponse= $this->restClient->send('GET', 'field/'. $id);
        $response = new JsonResponse();
        $response->setData(json_decode($wsResponse->getBody()));
        return $response;
    }
}
