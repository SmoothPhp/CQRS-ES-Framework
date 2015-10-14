# Event Dispatcher #

Smoothphps event dispatcher is yet another php event dispatcher, what makes this package different to the others is its ability to detect when a Event listener should fire at run time.


In event sourcing you may which to rerun all of your events back though there handlers, which is great however some handlers you do not wish to run again.
This tends to be handlers which generate new events or talk to 3rd parties. Otherwise as you replay your events over and over, you will generate new duplicate events. 
This can be avoided by implementation a Projection interface.

```PHP

use SmoothPhp\Contracts\EventDispatcher\Projection;
use SmoothPhp\EventDispatcher\ProjectEnabledDispatcher;

class MemberRegistered implements Event
{
    ...
}


final class ProjectionOnlyMemberMysqlListener implements Projection
{
    public function handleEvent(MemberRegistered $e)
    {
        db()->insert($e)
    }
}
final class NoneProjectionOnlyMemberThirdPartListener
{
    /** Do not run on reply */
    public function handleEvent(MemberRegistered $e)
    {
        curl()->send($e)
    }
}

$dispatcher = new ProjectEnabledDispatcher(true);


$dispatcher->addListener('MemberRegistered', [new ProjectionOnlyMemberMysqlListener, 'handleEvent']);
$dispatcher->addListener('MemberRegistered',[new ProjectEnabledDispatcher,'handleEvent']);

$dispatcher->dispatch('MemberRegistered', []);


```

Due to the event dispatcher been set to projection only, the event dispatcher will not fire to any listener that does not implement Projection



 
 
 