#CQRS Framework Changelog

## Unreleased

#5.1.0
* [EventStore] Allow deletion of event streams

#5.0.0
* [EventStore] Change eventstore signurture to allow better rebuilds

#4.0.0
* Upgraded to php7
* Don't use constructors to build classes in repositories
* Add option to ignore playheads

#3.1.0
* Deprecated Projection interface. Will remove in next major release

#3.0.1
* Added exception for duplicate aggregate play head

#3.0.0
* Change event store to allow better production rebuilding

# 2.0.0
* Middleware on command bus
# 1.1.2

* Event Dispatcher how has priority

# 1.1.1

* Remove the need for the BaseCommand constructor been called

## 1.1.0

* Event Dispatcher changed interface (run time swapping to projections only)

## 1.0.0

* First release
