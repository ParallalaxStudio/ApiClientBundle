<?php

namespace Parallalax\ApiClientBundle\Controller;


use GuzzleHttp\Psr7\Response;
use Parallalax\ApiClientBundle\Core\MainController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/element", name="apiclient_element_")
 *
 * Security ("user.getCompany().getParent() === null")
 */
class DocumentElementController extends MainController {
    
    /**
     * create a new element in the current page from a field
     *
     * @Route("/new/{page<\d+>}/{group<\d+>}/{field<\d+>}", name="new")
     * 
     * @param Request $request
     * @param $page
     * @param $group
     * @param $field
     * @return JsonResponse
     * @throws \AppBundle\Exception\CustomException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function new(Request $request, $page, $group, $field) {
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
     * get the parameters of the element : call the ws
     *
     * @Route("/edit/{id<\d+?>}", name="edit", methods={"GET"})
     *
     * @param $id
     * @return object
     * @throws \App\Exception\CustomException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function edit($id=null): object
    {
        $wsResponse = $this->restClient->send('GET', 'document_elements/'. $id .'.json');
        $response = new JsonResponse();
        $response->setData(json_decode($wsResponse->getBody()));
        return $response;
    }


    /**
     * update any information on the element
     *
     * @Route("/edit/{id<\d+>}", name="put", methods={"PUT"})
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws \AppBundle\Exception\CustomException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function put(Request $request, $id): JsonResponse
    {

        if($request->isXmlHttpRequest()) {
            $dataToSend = $request->request->all();
            if(isset($dataToSend['document_element_configuration'])) {
                $dataToSend['before'] = $dataToSend['document_element_configuration']['before'];
                $dataToSend['after'] = $dataToSend['document_element_configuration']['after'];
                $dataToSend['default_text'] = $dataToSend['document_element_configuration']['default_text'];
            }

            $dataToSend['positionX'] = (float)$dataToSend['positionX'];
            $dataToSend['positionY'] = (float)$dataToSend['positionY'];


            $wsResponse = $this->restClient->send('PUT', 'document_elements/'. $id .'.json', $dataToSend);

            $response = new JsonResponse();

            if($wsResponse->getStatusCode() === \Symfony\Component\HttpFoundation\Response::HTTP_OK) {

                $response->setData(json_decode($wsResponse->getBody()));
            }
            else {
                $response->setData(['error : '. $wsResponse->getBody()]);
            }

            return $response;
        }
        else {
            throw new \Exception('Ajax is not an option, get to work !');
        }
    }


    /**
     * @Route("/configure/{id<\d+>}", name="configure")
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \AppBundle\Exception\CustomException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function configure(Request $request, $id) {
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
