<?php

/*
 *
 * (c) Vincent Amstoutz <vincent.amstoutz.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

use Castor\Attribute\AsTask;

use function Castor\io;
use function Castor\run;

#[AsTask(description: 'Install project & tools')]
function install(): void
{
    run(['composer', 'install']);

    $tools = ['infection', 'php-cs-fixer', 'phpstan', 'rector'];
    foreach ($tools as $tool) {
        run(['composer', 'install', '--working-dir=tools/'.$tool]);
    }

    io()->success('Project ready! ☑️');
}

#[AsTask(description: 'Run PHPCSFixer, PHPStan & Rector')]
function fix(): void
{
    $commands = [
        'tools/php-cs-fixer/vendor/bin/php-cs-fixer fix',
        'tools/phpstan/vendor/bin/phpstan',
        'tools/rector/vendor/bin/rector',
    ];

    foreach ($commands as $command) {
        run(explode(' ', $command));
    }

    io()->success('Code quality OK! 🚀');
}
