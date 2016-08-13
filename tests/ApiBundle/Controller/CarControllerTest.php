<?php

namespace Tests\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CarControllerTest extends WebTestCase
{
    
    /**
     * Get all cars
     * GET
     */
    public function testGetCars()
    {
        $client = static::createClient();

        $client->request('GET', '/cars');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('[{"id":1,"maker":"Seat","model":"Ibiza","price":20000,"option":[{"name":"Spoiler"},{"name":"GPS"}],"equipment":[{"name":"DSG"},{"name":"Xenon"}]},{"id":2,"maker":"Renault","model":"Clio","price":12000,"option":[{"name":"R-LINK"},{"name":"GPS"}],"equipment":[{"name":"ABS"},{"name":"Climatisation"}]}]',$client->getResponse()->getContent());
    }
    
    
    /**
     * Get one car
     * GET
     */
    public function testGetCar()
    {
        $client = static::createClient();

        $client->request('GET', '/car/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('{"id":1,"maker":"Seat","model":"Ibiza","price":20000,"option":[{"name":"Spoiler"},{"name":"GPS"}],"equipment":[{"name":"DSG"},{"name":"Xenon"}]}',$client->getResponse()->getContent());

    }
    
    
    /**
     * Create a car
     * POST
     */
    public function testCreateCar()
    {
        $client = static::createClient();
        
        //Check required fields
        $data = array(
            "car" => array(
            )
        );

        $client->request('POST', '/car', $data);        
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertRegExp("/Maker is required/", $client->getResponse()->getContent());
        $this->assertRegExp("/Model is required/", $client->getResponse()->getContent());
        $this->assertRegExp("/Price is required/", $client->getResponse()->getContent());
        
        //check length
        $data = array(
            "car" => array(
                "maker" => "Seat",
                "model" => "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX",
                "price" => 15000,
                "option" => array( array('name' => "DSG"), array('name' => 'GPS') ),
                "equipment" => array( array('name' => "ABS"), array('name' => 'Turbo') ),
            )
        );

        $client->request('POST', '/car', $data);        
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertRegExp("/Model has max length 50/", $client->getResponse()->getContent());
        
        
        //Check when it's ok
        $data = array(
            "car" => array(
                "maker" => "Seat",
                "model" => "Leon",
                "price" => 15000,
                "option" => array( array('name' => "Spoiler"), array('name' => 'GPS') ),
                "equipment" => array( array('name' => "ABS"), array('name' => 'Turbo') ),
            )
        );

        $client->request('POST', '/car', $data);        
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        
    }
    
    /**
     * Replace a car
     * PUT
     */
    public function testReplaceCar()
    {
        $client = static::createClient();
        
        //check length
        $data = array(
            "car" => array(
                "maker" => "Audi",
                "model" => "Q77777777777777777777777777777777777777777777777777777777777777777777777",
                "price" => 75000,
                "option" => array( array('name' => "Cameras"), array('name' => 'GPS') ),
                "equipment" => array( array('name' => "DSG"), array('name' => 'Pack cuir') ),
            )
        );

        $client->request('PUT', '/car/3', $data);        
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertRegExp("/Model has max length 50/", $client->getResponse()->getContent());
        
        
        //Check when it's ok
        $data = array(
            "car" => array(
                "maker" => "Audi",
                "model" => "Q7",
                "price" => 75000,
                "option" => array( array('name' => "Cameras"), array('name' => 'GPS') ),
                "equipment" => array( array('name' => "DSG"), array('name' => 'Pack cuir') ),
            )
        );

        $client->request('PUT', '/car/3', $data);      
        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }
    
    
    /**
     * Modify a car
     * PATCH
     */
    public function testUpdateCar()
    {
        
        $client = static::createClient();
        
        //check length
        $data = array(
            "car" => array(
                "model" => "Q55555555555555555555555555555555555555555555555555555555555555",
            )
        );

        $client->request('PATCH', '/car/3', $data);        
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertRegExp("/Model has max length 50/", $client->getResponse()->getContent());
        
        
        //Check when it's ok
        $data = array(
            "car" => array(
                "model" => "Q5",
            )
        );

        $client->request('PATCH', '/car/3', $data);      
        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }
    
    
    public function testDelete()
    {
        $client = static::createClient();

        $client->request('DELETE', '/car/3');        
        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }
    
    /**
     * Transactions are rollbacked but need to fix AUTO_INCREMENT.
     */
    public function tearDown()
    {
        //reset auto increment
        $em = static::$kernel->getContainer()->get('doctrine')->getManager();
        $query = $em->getConnection()->prepare('ALTER TABLE `car` AUTO_INCREMENT=3;');
        $query->execute();
    }
}
