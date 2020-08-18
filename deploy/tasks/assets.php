<?php

declare(strict_types=1);

namespace Deployer;

desc('Install npm packages');
task('assets:install', function () {
    if (test('[ -d node_modules ]')) {
        return;
    }

    run('{{bin/npm}} install');
})->local();

desc('Build frontend assets locally');
task('assets:build', function () {
    if (test('[ -d public/assets ]')) {
        return;
    }

    if (get['stage'] === 'production') {
        run('{{bin/npm}} run production');
    } else {
        run('{{bin/npm}} run development');
    }
})->local();

desc('Upload assets to your hosts');
task('assets:upload', function () {
    upload('public/assets/', '{{release_path}}/public/assets/');
});