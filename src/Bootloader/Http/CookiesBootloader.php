<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
declare(strict_types=1);

namespace Spiral\Bootloader\Http;

use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Boot\Bootloader\DependedInterface;
use Spiral\Http\Middleware\CookiesMiddleware;

final class CookiesBootloader extends Bootloader implements DependedInterface
{
    /**
     * @return array
     */
    public function defineDependencies(): array
    {
        return [HttpBootloader::class];
    }

    /**
     * @param HttpBootloader $http
     */
    public function boot(HttpBootloader $http)
    {
        $http->addMiddleware(CookiesMiddleware::class);
    }

    // todo: cookies!
}