# Welcome to Aramis Rest API

----
## What's inside ?


> A REST API developed using Symfony 3.1 , FosRestBundle and JMSSerializerBundle.
The purpose is to handle a basic list of cars.

----
## Installation

*Make sure MySQL and PHP >=5.5.9 are installed.*

1. Choose your favorite way to [get composer](https://getcomposer.org/download/).

2. Install project : 

`php composer.phar create-project emmanuel-ba/aramis aramis -sdev`

> database credentials should be asked during installation

3. Create database:

 > cd aramis

 > php bin/console doctrine:database:create

 > php bin/console doctrine:schema:update --force


> you can alternatively use the mysql dump file provided (aramis.sql).


4. Load fixtures :

`php bin/console doctrine:fixtures:load`

5. Launch tests with phpunit: 

`phpunit`

6. Start PHP's built-in web server using Symfony Command :

`php bin/console server:run`

> Api should be available at http:localhost:8000

----
# Test API

## Quick tests using Postman

*You need to have postman installed. Have a look at the [Chrome extension](https://chrome.google.com/webstore/detail/postman/fhbjgbiflinjbdggehcddcbncdddomop)*

1. Load the provided environment and collection in postman :
 - environment : Aramis.postman_collection.json
 - collection : TEST.postman_environment.json

**Run the tests on the collection**

> There should be 22 tests passed  


## Manual tests using curl


- GET cars (response code 200 expected)

>
 curl -X GET -H "Cache-Control: no-cache" "http://localhost:8000/cars"

--- 
 - GET car (response code 200 expected)

>
 curl -X GET -H "Cache-Control: no-cache" "http://localhost:8000/car/1"
 
--- 
 - POST car (response code 201 expected)

> curl -X POST -H "Content-Type: application/json" -H "Cache-Control: no-cache" -d '{"car" : 
  {
      "maker" : "Seat",
      "model" : "Leon",
      "price" : 15000,
      "option" : [{"name" : "Spoiler"}, {"name" : "GPS"}],
      "equipment" : [{"name" : "ABS"}, {"name" : "Turbo"}]
  }
}' "http://localhost:8000/car"

--- 
- INVALID POST car (response code 400 expected)

>
 curl -X POST -H "Content-Type: application/json" -H "Cache-Control: no-cache" -d '{"car" : 
  {
      "model" : "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX",
      "price" : 15000,
      "option" : [{"name" : "Spoiler"}, {"name" : "GPS"}],
      "equipment" : [{"name" : "ABS"}, {"name" : "Turbo"}]
  }
}' "http://localhost:8000/car"

--- 
 - PUT car (response code 204 expected)

>
curl -X PUT -H "Content-Type: application/json" -H "Cache-Control: no-cache" -d '{"car" : 
  {
      "maker" : "Audi",
      "model" : "Q7",
      "price" : 75000,
      "option" : [{"name" : "Camera recul"}, {"name" : "Pack cuir"}],
      "equipment" : [{"name" : "Boite auto"}, {"name" : "Climatisation"}]
  }
}' "http://localhost:8000/car/3"

--- 
- INVALID put car (response code 400 expected) 

>
curl -X PUT -H "Content-Type: application/json" -H "Cache-Control: no-cache" -d '{"car" : 
  {
      "maker" : "Audi",
      "model" : "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX",
      "price" : 75000,
      "option" : [{"name" : "Camera recul"}, {"name" : "Pack cuir"}],
      "equipment" : [{"name" : "Boite auto"}, {"name" : "Climatisation"}]
  }
}' "http://localhost:8000/car/3"

---
- PATCH car (response code 204 expected) 

>
curl -X PATCH -H "Content-Type: application/json" -H "Cache-Control: no-cache" -d '{"car" : 
  {
      "model" : "Q5"
  }
}' "http://localhost:8000/car/3"


---
INVALID PATCH : (response code 400 expected) 

>
curl -X PATCH -H "Content-Type: application/json" -H "Cache-Control: no-cache" -d '{"car" : 
  {
      "model" : "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXx"
  }
}' "http://localhost:8000/car/3"
 
---
DELETE a car : (response code 204 expected) 

> 
curl -X DELETE -H "Cache-Control: no-cache" "http://localhost:8000/car/3"