Command Bus
===========

The command bus exists to execute write-or-fail commands within the domain of the application.  

The command bus exists of 4 components.

* Command  
  The DTO containing the intent and data to execute the command.
* Command Translator  
  Takes a command, and translates to the command handler class name.
* Handler Resolver  
  Resolves (generates) the object that executes the given command
* Middleware  
  Sits between `CommandBus::execute()` and the execution of the command. Similar to HTTP middleware.
  
### Examples
```
<?php  
 
// Define as many middlewares as you like,
// the given one uses the simple translator and resolver to  
// generate the command handler
$middleware = [
    new SmoothPhp\CommandBus\CommandHandlerMiddleware(
        new SmoothPhp\CommandBus\SimpleCommandTranslator,
        new SmoothPhp\CommandBus\SimpleCommandHandlerResolver
    )
];  
  
// Create the bus with the middle ware
$bus = new SmoothPhp\CommandBus\CommandBus($middleware);  
  
// Create the command
$command = new SignUpToNewsletter($memberId, $newsletterId);  
  
// Send to command bus
$bus->execute($command);
```