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
    processDependencies('install');
    io()->success('Project ready! ☑️');
}

#[AsTask(description: 'Update project dependencies & tools dependencies')]
function update(): void
{
    processDependencies('update');
    io()->success('Project dependencies updated! ☑️');
}

function processDependencies(string $operation): void
{
    run(['composer', $operation]);

    $tools = ['infection', 'php-cs-fixer', 'phpstan', 'rector'];
    foreach ($tools as $tool) {
        run(['composer', $operation, '--working-dir=tools/'.$tool]);
        io()->success("$tool dependencies OK for `composer $operation` ! ☑️");
    }
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
