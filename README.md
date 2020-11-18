# common.exception

Adds Exception classes
* `AppException`
* `EntityException`
* `Entity\NotFoundException`
* `ServiceException`
* `Service\ApiException`

NOTES
* `Entity\NotFoundException`: `$code` is always 404

## Test

`phpunit` or `vendor/bin/phpunit`

coverage reports will be available in `var/coverage`

## Use

### Entity\NotFoundException
```php
use Jalismrs\Common\Exception\Entity\NotFoundException;

throw NotFoundException::create(
    SomeClass::class,
    'some identifier'
);
```
