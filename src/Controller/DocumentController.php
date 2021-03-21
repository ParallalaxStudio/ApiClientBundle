<?php

namespace Parallalax\ApiClientBundle\Controller;


use Parallalax\ApiClientBundle\Core\MainController;
use Parallalax\ApiClientBundle\Form\DocumentElementType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/document", name="apiclient_document_")
 *
 * Security ("user.getCompany().getParent() === null")
 */
class DocumentController extends MainController {

    /*public function __construct(\App\Utils\RestClientFacade $restClient) {
        $this->restClient = $restClient;
    }*/

    /**
     * @Route("/home", name="home")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response|null
     * @throws \AppBundle\Exception\CustomException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function home() {

        $response = $this->restClient->send('GET', 'documents.json');
        return $this->render('@ParallalaxApiClient/document/list.html.twig', array('documents' => json_decode($response->getBody())));
    }

    /**
     * @Route("/edit/{id<\d+>?}/{pageNum<\d+>}", name="edit")
     *
     * @param $id
     * @param int $pageNum
     * @return Response
     * @throws \App\Exception\CustomException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function edit($id, $pageNum = 1): Response
    {

        $wsDocumentResponse = $this->restClient->send('GET', 'documents/'. $id .'.json');
        $documentResponse = json_decode($wsDocumentResponse->getBody());
        $currentPage = null;
        
        if($wsDocumentResponse->getStatusCode() === Response::HTTP_OK) {
            foreach($documentResponse->pages as $page) {
                if($page->num == $pageNum) {

                    $wsPageResponse = $this->restClient->send('GET', 'document_pages/'. $page->id .'.json');
                    $currentPage = json_decode($wsPageResponse->getBody());
                }
            }
        }
        else {
            throw new \Exception('error code '. $wsDocumentResponse->getStatusCode());
        }

        if($currentPage === null) {
            throw new \Exception('page non trouvable');
        }

        //echo '<pre>';
        //print_r($currentPage);
        //die;

        $form = $this->createForm(DocumentElementType::class);

        return $this->render('@ParallalaxApiClient/document/edit.html.twig', array('document' => $documentResponse,
                                                                                  'currentPage' => $currentPage,
                                                                                  'form' => $form->createView()));
    }

    public function pageEditAction(Request $request, $id, $pageNum) {
        $file = $request->files->get('page_background');
        print_r($file);
        die('--');
    }
}
