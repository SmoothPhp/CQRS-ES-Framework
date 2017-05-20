git subsplit init git@github.com:SmoothPhp/CQRS-ES-Framework.git

git subsplit publish --heads="master" src/CommandBus:git@github.com:SmoothPhp/CommandBus.git
git subsplit publish --heads="master" src/Contracts:git@github.com:SmoothPhp/Contracts.git
git subsplit publish --heads="master" src/Domain:git@github.com:SmoothPhp/Domain.git
git subsplit publish --heads="master" src/EventBus:git@github.com:SmoothPhp/EventBus.git
git subsplit publish --heads="master" src/EventDispatcher:git@github.com:SmoothPhp/EventDispatcher.git
git subsplit publish --heads="master" src/EventSourcing:git@github.com:SmoothPhp/EventSourcing.git
git subsplit publish --heads="master" src/Serialization:git@github.com:SmoothPhp/Serialization.git
git subsplit publish --heads="master" src/EventStore:git@github.com:SmoothPhp/EventStore.git
