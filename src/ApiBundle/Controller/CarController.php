<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use ApiBundle\Entity\Car;
use ApiBundle\Form\CarType;

class CarController extends Controller
{
    /**
     * Get list of all cars (Code 200)
     * 
     * @param type $id
     * @return type
     */
    public function getCarsAction()
    {
        return $this->getDoctrine()->getManager()->getRepository('ApiBundle:Car')->findAll();
    }
    
    /**
     * Get one car by id
     * 
     * @param type $id
     * @return type
     * @throws NotFoundHttpException
     * 
     * (Code 200 if found else 404)
     * 
     */
    public function getCarAction($id)
    {
        $car = $this->getDoctrine()->getManager()->getRepository('ApiBundle:Car')->find($id);
        
        if (!$car instanceOf Car) {
            throw $this->createNotFoundException('Car not found');
        }
        
        return $car;
    }
    
    /**
     * Create a car
     * 
     * (Code 201 if created else 400)
     * 
     * @param Request $request
     */
    public function createCarAction(Request $request) 
    {
        $car = new Car();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($car);
            $em->flush();
            
            //Display just created car
            return View::create($car, Response::HTTP_CREATED);
            
        }
        
        //Display form errors
        return View::create($form, Response::HTTP_BAD_REQUEST);
    }
    
    
    /**
     * Replace a car
     * 
     * Code 204 if updated
     * Code 404 if not found
     * Code 400 if form contains errors
     * 
     * @param Request $request
     */
    public function replaceCarAction(Request $request) 
    {
        $em = $this->getDoctrine()->getManager();
        
        $car = $em->getRepository('ApiBundle:Car')->find($request->get('id'));
        if (!$car instanceOf Car) {
            throw $this->createNotFoundException('Car not found');
        }
        
        $form = $this->createForm(CarType::class, $car);
        
        $form->submit($request->get('car'));
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($car);
            $em->flush();
            //Display just updated car
            return View::create($car, Response::HTTP_NO_CONTENT);
        }
        //Display form errors
        return View::create($form, Response::HTTP_BAD_REQUEST);
    }
    
    
    /**
     * Update a car
     * 
     * Code 204 if updated correctly
     * Code 404 if not found
     * Code 400 if form contains errors
     * 
     * @param Request $request
     */
    public function updateCarAction(Request $request) 
    {
        $em = $this->getDoctrine()->getManager();
        
        $car = $em->getRepository('ApiBundle:Car')->find($request->get('id'));
        if (!$car instanceOf Car) {
            throw $this->createNotFoundException('Car not found');
        }
        
        $form = $this->createForm(CarType::class, $car);
        
        $form->submit($request->get('car'), false);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($car);
            $em->flush();
            //Display just updated car
            return View::create($car, Response::HTTP_NO_CONTENT);
        }
        //Display form errors
        return View::create($form, Response::HTTP_BAD_REQUEST);
    }
    
    
    /**
     * Delete a car by id
     * 
     * @param type $id
     * 
     * @Rest\View(statusCode=204)
     */
    public function deleteCarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $car = $em->getRepository('ApiBundle:Car')->find($id);
        
        if ($car instanceOf Car) {
            $em->remove($car);
            $em->flush();
        }
    }

}
