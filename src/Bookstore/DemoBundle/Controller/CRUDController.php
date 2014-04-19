<?php

namespace Bookstore\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

abstract class CRUDController extends Controller {

    const EDIT = 1;
    const ADD = 0;

    protected $redirectUrl;

    protected function handleFormProcessing(Request $request, $entity) {
        $form = $this->buildForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl($this->redirectUrl));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView()
        );
    }

    protected function getRepository($entityName) {
        return $this->getDoctrine()->getManager()->getRepository($entityName);
    }

    protected function buildForm($entity) {
        
    }

}

