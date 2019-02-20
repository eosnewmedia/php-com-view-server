# eos/php-com-view-server

PHP server implementation for ComView-API. Designed as server used with [eos/php-com-view-client](https://github.com/eosnewmedia/php-com-view-client).

# Installation

Install this library via composer:

    composer require eos/php-com-view-server
    
 # Configuration
 
 This assumes you have implemented the [PSR 17](https://www.php-fig.org/psr/psr-17) Interfaces that are passed as dependencies:
 
    Psr\Http\Message\ResponseFactoryInterface;
    Psr\Http\Message\StreamFactoryInterface;
    
 Create a new instance of `Eos\ComView\Server\ComViewServer`. This will be the entrypoint for the application.
 
 You can define single handlers for `Eos\ComView\Server\ViewInterface` and `Eos\ComView\Server\CommandInterface` or use the Registries `Eos\ComView\Server\ViewRegistry` or `Eos\ComView\Server\CommandRegistry` that implement those interfaces but can be used for multiple types.
 
 ```php

 $commandRegistry = new Eos\ComView\Server\CommandRegistry();
 $commandRegistry
    ->addCommand('commandName', $command1 /*instance of Eos\ComView\Server\CommandInterface*/)
    ->addCommand('anotherName', $command2 /*instance of Eos\ComView\Server\CommandInterface*/);
$server = new Eos\ComView\Server\ComViewServer(
                $view,                  // instance of Eos\ComView\Server\ViewInterface
                $commandRegistry,       
                $psrResponseFactory, 
                $psrStreamFactory
            );
```

# Usage

This library provides 2 methods to handle view- and command-requests. They will receive the request data and will pass it to

### Eos\ComView\Server\ComViewServer::view($viewName, $queryParameters)

`Eos\ComView\Server\ComViewServer::view($viewName, $queryParameters)` expects a string with the name of the view and an array containing the query paramaters.

This method will call the Class implementing `Eos\ComView\Server\ViewInterface` that was passed in the constructor and return an instance of `Eos\ComView\Server\Value\Response` containing the status code and the result parsed as JSON.

 ```php

 $response = $server->view('viewName', $queryParameters);
```


### Eos\ComView\Server\ComViewServer::execute($requestBody)

`Eos\ComView\Server\ComViewServer::execute($requestBody)` expects an array of commands with the ID as keys.

This method will call the Class implementing `Eos\ComView\Server\CommandInterface` that was passed in the constructor and return an instance of `Eos\ComView\Server\Value\Response` containing the status code and the result parsed as JSON.

 ```php

 $response = $server->execute($requestBody);
```

