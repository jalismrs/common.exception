# Symfony Bundle Exception

Adds several Exception classes
* `AppException`
* `EntityException`
* `Entity\NotFoundException`
* `ServiceException`
* `Service\ApiException`

NOTES
* namespace is `Jalismrs\Exceptions`
* `Entity\NotFoundException`: `$code` is always 404

## Test

`phpunit` OU `vendor/bin/phpunit`

coverage reports will be available in `var/coverage`

## Use

```php
use Jalismrs\Exceptions\Entity\NotFoundException;

throw NotFoundException::create(
    SomeEntity::class,
    'some identifier'
);
```
