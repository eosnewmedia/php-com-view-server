eos/com-view-server
=======================

PHP server implementation for ComView-API standard.

# Installation

Install this library via composer:

    composer require eos/com-view-server
    
 # Usage
 
 Create a new instance of `Eos\ComView\Server\ComViewServer`. This will be the entry point for the application.
 
 You can define single handlers for `Eos\ComView\Server\View\ViewInterface` and `Eos\ComView\Server\Command\CommandProcessorInterface` 
 or use the registries `Eos\ComView\Server\View\ViewRegistry` and `Eos\ComView\Server\Command\CommandProcessorRegistry` for usage with multiple views and commands.
 
 ```php
 
 $view = new Eos\ComView\Server\View\ViewRegistry();
 $view->add('test', new Your\View());

 $commandProcessor = new Eos\ComView\Server\Command\CommandProcessorRegistry();
 $commandProcessor->add('test', new Your\Command());
 
 $healthProvider = new Eos\ComView\Server\Health\HealthProviderChain();
 
 $server = new Eos\ComView\Server\ComViewServer($commandProcessor, $view, $healthProvider, $healthProvider);
 
```

The `ComViewServer` class offers three methods, `view` and `execute` and `health`.


## view(string $viewName, array $queryParameters)

The `view` method expects a string with the name of the view and an array containing the query parameters from the uri.

 ```php

 $response = $server->view('viewName', $headers, $queryParameters);
 
```

## execute(array $requestBody)

The `execute` method expects an array of commands (the ComView request body) with their IDs as keys.

 ```php

 $response = $server->execute($headers, $requestBody);

```

## health()

The `health` method creates an api health response determined by the health providers.

 ```php

 $response = $server->health();

```
