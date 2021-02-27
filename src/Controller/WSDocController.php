<?php

namespace Parallalax\ApiClientBundle\Controller;


//use AppBundle\Form\Type\WsDocElementType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/apiclient", name="myvendor_apiclient_")
 * @Security ("user.getCompany().getParent() === null")
 *
 * Class WSDocController
 * @package AppBundle\Controller
 */
class WSDocController extends AbstractController {

    protected $restClient = null;

    public function __construct(\App\Utils\RestClientFacade $restClient) {
        $this->restClient = $restClient;
    }

    /**
     * @Route("/home", name="home")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response|null
     * @throws \AppBundle\Exception\CustomException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function homeAction() {

        $response = $this->restClient->send('GET', 'document/');
        return $this->render('AppBundle:WSDoc:home.html.twig', array('allDocuments' => json_decode($response->getBody())));
    }

    /**
     * @param $id
     * @param int $pageNum
     * @return Response
     * @throws \AppBundle\Exception\CustomException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function editAction($id, $pageNum = 1) {

        $wsResponse = $this->restClient->send('GET', 'document/'. $id);
        $documentResponse = json_decode($wsResponse->getBody());
        
        if($wsResponse->getStatusCode() == Response::HTTP_OK) {
            foreach($documentResponse->pages as $page) {
                if($page->num == $pageNum) {
                    $currentPage = $page;
                }
            }
        }
        else {
            throw new \Exception('error code '. $wsResponse->getStatusCode());
        }


        $form = $this->createForm(WsDocElementType::class);

        return $this->render('AppBundle:WSDoc:edit.html.twig', array('document' => $documentResponse,
                                                                                  'currentPage' => $currentPage,
                                                                                  'form' => $form->createView()));
    }

    public function pageEditAction(Request $request, $id, $pageNum) {
        $file = $request->files->get('page_background');
        print_r($file);
        die('--');
    }
}
