git subsplit init git@github.com:SmoothPhp/CQRS-ES-Framework.git

git subsplit publish --heads="master 1.0" src/CommandBus:git@github.com:SmoothPhp/CommandBus.git
git subsplit publish --heads="master 1.0" src/Contracts:git@github.com:SmoothPhp/Contracts.git
git subsplit publish --heads="master 1.0" src/Domain:git@github.com:SmoothPhp/Domain.git
git subsplit publish --heads="master 1.0" src/EventBus:git@github.com:SmoothPhp/EventBus.git
git subsplit publish --heads="master 1.0" src/EventDispatcher:git@github.com:SmoothPhp/EventDispatcher.git
git subsplit publish --heads="master 1.0" src/EventSourcing:git@github.com:SmoothPhp/EventSourcing.git
git subsplit publish --heads="master 1.0" src/Serialization:git@github.com:SmoothPhp/Serialization.git
