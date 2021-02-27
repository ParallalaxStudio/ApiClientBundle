<?php

namespace Parallalax\ApiClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

//use AppBundle\Form\Type\WsDocElementConfigurationType;


class WSDocElementController extends WSDocController {
    
    /**
     * create a new element in the current page from a field
     * 
     * @param Request $request
     * @param $page
     * @param $group
     * @param $field
     * @return JsonResponse
     * @throws \AppBundle\Exception\CustomException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function newAction(Request $request, $page, $group, $field) {
        if($request->isXmlHttpRequest()) {
            $wsResponse = $this->restClient->send('PUT', 'element/'. $page .'/'. $group .'/'. $field);
            $response = new JsonResponse();
            $response->setData(json_decode($wsResponse->getBody()));
            return $response;
        }
        else {
            throw new \Exception('Ajax is not an option, get to work !');
        }
    }

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
            $wsResponse = $this->restClient->send('GET', 'element/'. $id);
            $response = new JsonResponse();
            $response->setData(json_decode($wsResponse->getBody()));
            return $response;
        }
        else {
            throw new \Exception('Ajax is not an option, get to work !');
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \AppBundle\Exception\CustomException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function configureAction(Request $request, $id) {
        if($request->isXmlHttpRequest()) {
            $wsResponse = $this->restClient->send('GET', 'element/'. $id);

            $formParams = ['action' => $this->generateUrl('client_wsfd_element_update', ['id' => $id])];
            $form = $this->createForm(WsDocElementConfigurationType::class, json_decode($wsResponse->getBody()), $formParams);

            return $this->render('AppBundle:WSDoc:modal.html.twig', array('form' => $form->createView()));
        }
        else {
            throw new \Exception('Ajax is not an option, get to work !');
        }
    }

    /**
     * update any information on the element
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws \AppBundle\Exception\CustomException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postAction(Request $request, $id) {

        if($request->isXmlHttpRequest()) {
            $dataToSend = $request->request->all();
            if(isset($dataToSend['ws_doc_element_configuration'])) {
                $dataToSend['before'] = $dataToSend['ws_doc_element_configuration']['before'];
                $dataToSend['after'] = $dataToSend['ws_doc_element_configuration']['after'];
                $dataToSend['default_text'] = $dataToSend['ws_doc_element_configuration']['default_text'];
            }


            $wsResponse = $this->restClient->send('POST', 'element/'. $id, $dataToSend);
            $response = new JsonResponse();
            $response->setData(json_decode($wsResponse->getBody()));
            return $response;
        }
        else {
            throw new \Exception('Ajax is not an option, get to work !');
        }
    }

    public function putAction(Request $request) {

    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws \AppBundle\Exception\CustomException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteAction(Request $request, $id) {
        if($request->isXmlHttpRequest()) {

            $wsResponse = $this->restClient->send('DELETE', 'element/'. $id);
            $response = new JsonResponse();
            $response->setData(json_decode($wsResponse->getBody()));
            return $response;
        }
        else {
            throw new \Exception('Ajax is not an option, get to work !');
        }
    }
}
