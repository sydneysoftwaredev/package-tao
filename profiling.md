# Enable profiling

## Clockwork

Add class to `tao/models/classes/mvc/ClockworkService.php`

This adds a singleton instance of the Clockwork class to the service container for use by other
parts of the app. This could be added by an extension, but this doesn't achieve too much as the core code must also be modified.

By setting the private property `enabled` to `true` the Clockwork instance will be returned by the `getClockwork` method. This allows the Clockwork instance to be disabled in production environments by setting the property to `false`.

Each location that uses the Clockwork instance checks for null before using it.

```php
<?php

namespace oat\tao\model\mvc;

use oat\oatbox\service\ConfigurableService;

class ClockworkService extends ConfigurableService
{

    private $clockwork;

    private $enabled = false;

    public const SERVICE_ID = 'mvc/clockwork';

    public function __construct()
    {
        $this->header = 'Clockwork service';

        $this->clockwork = \Clockwork\Support\Vanilla\Clockwork::init(
            [
                'api' => '/clockwork-api.php?request=',
                'requests.except' => [
                    '/clockwork*.php'
                ]
            ]
        );
    }

    public function getClockwork()
    {
        return $this->enabled ? $this->clockwork : null;
    }
}


```

In `tao/models/classes/mvc/Bootstrap.php` add the import:

```php
use oat\tao\model\mvc\ClockworkService;
```

Add the following code to the `start` method:

```php
$this->registerService(ClockworkService::SERVICE_ID, new ClockworkService());
```

e.g.

```php
    use oat\tao\model\mvc\ClockworkService;

    # ...

    public function start()
    {
        if (!self::$isStarted) {
            $this->session();
            $this->setDefaultTimezone();
            $this->registerErrorhandler();
            self::$isStarted = true;

            $this->registerService(ClockworkService::SERVICE_ID, new ClockworkService());
        }
    }
```

This initialises the Clockwork service and adds it to the service container.

In `tao/models/classes/routing/TaoFrontController.php` add the following code to the `__invoke` method, before the `ActionEnforcer` is run

```php
    $clockwork = $this->getServiceLocator()->get(ClockworkService::SERVICE_ID)->getClockwork();
    if ($clockwork) {
        $clockwork->requestProcessed();
    }

    // existing code:
    $enforcer($request, $response);
```

This will tell Clockwork that the request has been processed and it can now collect data.

Add clockwork-web.php in the same location with contents:

```php
<?php

require_once 'vendor/autoload.php';

$clockwork = Clockwork\Support\Vanilla\Clockwork::init(
    [
        'api' => '/clockwork-api.php?request=',
        'web' => [
            'enable' => true,
            'path' => __DIR__ . '/clockwork-web',
            'uri' => '/clockwork-web'
        ]
    ]
);

$clockwork->returnWeb();
```
