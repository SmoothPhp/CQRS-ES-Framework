git subsplit init git@github.com:SmoothPhp/CQRS-ES-Framework.git

git subsplit publish --heads="master 1.0" --no-tags src/CommandBus:git@github.com:SmoothPhp/CommandBus.git
git subsplit publish --heads="master 1.0" --no-tags src/Contracts:git@github.com:SmoothPhp/Contracts.git
git subsplit publish --heads="master 1.0" --no-tags src/Domain:git@github.com:SmoothPhp/Domain.git
git subsplit publish --heads="master 1.0" --no-tags src/EventBus:git@github.com/SmoothPhp/EventBus
git subsplit publish --heads="master 1.0" --no-tags src/EventDispatcher:git@github.com:SmoothPhp/EventDispatcher.git
git subsplit publish --heads="master 1.0" --no-tags src/EventSourcing:git@github.com:SmoothPhp/EventSourcing.git
git subsplit publish --heads="master 1.0" --no-tags src/Serialization:git@github.com:SmoothPhp/Serialization.git
