<?php

namespace Construct\AppBundle\Controller;

use Construct\AppBundle\Entity\Service;
use Construct\AppBundle\Form\ServiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Service controller.
 *
 * @Route("/service")
 */
class ServiceController extends Controller
{

    /**
     * Lists all Service entities.
     *
     * @Route("/", name="service")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $services = $em->getRepository('AppBundle:Service')->findAll();

        return array(
            'services' => $services,
        );
    }

    /**
     * Creates a new Service entity.
     *
     * @Route("/", name="service_create")
     * @Method("POST")
     * @Template("AppBundle:Service:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $service = new Service();
        $form = $this->createCreateForm($service);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $service->upload();
            $em->persist($service);
            $em->flush();

            return $this->redirect($this->generateUrl('service_show', array('id' => $service->getId())));
        }

        return array(
            'service' => $service,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Service entity.
     *
     * @param Service $service The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Service $service)
    {
        $form = $this->createForm(new ServiceType(), $service, array(
            'action' => $this->generateUrl('service_create'),
            'method' => 'POST',
        ));

        $form->add('file', 'file');
        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Service entity.
     *
     * @Route("/new", name="service_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $service = new Service();
        $form = $this->createCreateForm($service);

        return array(
            'service' => $service,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Service entity.
     *
     * @Route("/{id}", name="service_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $service = $em->getRepository('AppBundle:Service')->find($id);

        if (!$service) {
            throw $this->createNotFoundException('Unable to find Service entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'service' => $service,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to delete a Service entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('service_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * Displays a form to edit an existing Service entity.
     *
     * @Route("/{id}/edit", name="service_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $service = $em->getRepository('AppBundle:Service')->find($id);

        if (!$service) {
            throw $this->createNotFoundException('Unable to find Service entity.');
        }

        $editForm = $this->createEditForm($service);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'service' => $service,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Service entity.
     *
     * @param Service $service The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Service $service)
    {
        $form = $this->createForm(new ServiceType(), $service, array(
            'action' => $this->generateUrl('service_update', array('id' => $service->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Service entity.
     *
     * @Route("/{id}", name="service_update")
     * @Method("PUT")
     * @Template("AppBundle:Service:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $service = $em->getRepository('AppBundle:Service')->find($id);

        if (!$service) {
            throw $this->createNotFoundException('Unable to find Service entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($service);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('service_edit', array('id' => $id)));
        }

        return array(
            'service' => $service,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Service entity.
     *
     * @Route("/{id}", name="service_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $service = $em->getRepository('AppBundle:Service')->find($id);

            if (!$service) {
                throw $this->createNotFoundException('Unable to find Service entity.');
            }

            $em->remove($service);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('service'));
    }
}
