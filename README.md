eos/com-view-server
=======================

PHP server implementation for ComView-API standard.

# Installation

Install this library via composer:

    composer require eos/com-view-server
    
 # Usage
 
 Create a new instance of `Eos\ComView\Server\ComViewServer`. This will be the entry point for the application.
 
 You can define single handlers for `Eos\ComView\Server\ViewInterface` and `Eos\ComView\Server\CommandProcessorInterface` 
 or use the registries `Eos\ComView\Server\ViewRegistry` and `Eos\ComView\Server\CommandProcessorRegistry` for usage with multiple views and commands.
 
 ```php
 
 $view = new Eos\ComView\Server\ViewRegistry();
 $view->add('test', new Your\View());

 $commandProcessor = new Eos\ComView\Server\CommandProcessorRegistry();
 $commandProcessor->add('test', new Your\Command());
 
 $server = new Eos\ComView\Server\ComViewServer($view, $commandProcessor);
 
```

The `ComViewServer` class offers two methods, `view` and `execute`.


## view(string $viewName, array $queryParameters)

The `view` method expects a string with the name of the view and an array containing the query parameters from the uri.

 ```php

 $response = $server->view('viewName', $queryParameters);
 
```


## execute(array $requestBody)

The `execute` method expects an array of commands with their IDs as keys.

 ```php

 $response = $server->execute($requestBody);

```
