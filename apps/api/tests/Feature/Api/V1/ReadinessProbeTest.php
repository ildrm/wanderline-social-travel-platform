<?php

namespace Tests\Feature\Api\V1;

use App\Support\Health\CheckReadiness;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Redis\Connections\Connection;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Mockery;
use RuntimeException;
use Tests\TestCase;

class ReadinessProbeTest extends TestCase
{
    public function test_probe_checks_database_configured_queue_redis_and_private_storage(): void
    {
        $this->app['config']->set('filesystems.default', 'private-assets');
        $redis = Mockery::mock(Connection::class);
        $redis->shouldReceive('command')->once()->with('ping')->andReturn('PONG');
        Redis::shouldReceive('connection')->once()->with('queue')->andReturn($redis);
        $storage = Mockery::mock(Filesystem::class);
        $storage->shouldReceive('put')->once()->with(Mockery::pattern('/^\.readiness\/[0-9a-f-]+$/'), 'ready')->andReturnTrue();
        $storage->shouldReceive('get')->once()->with(Mockery::pattern('/^\.readiness\/[0-9a-f-]+$/'))->andReturn('ready');
        $storage->shouldReceive('delete')->once()->with(Mockery::pattern('/^\.readiness\/[0-9a-f-]+$/'))->andReturnTrue();
        Storage::shouldReceive('disk')->once()->with('private-assets')->andReturn($storage);

        $result = app(CheckReadiness::class)->handle();

        $this->assertSame([
            'database' => 'up',
            'redis' => 'up',
            'storage' => 'up',
        ], $result);
    }

    public function test_probe_marks_each_failed_dependency_down_without_throwing(): void
    {
        $this->app['db']->purge();
        $this->app['config']->set('database.default', 'missing');
        $this->app['config']->set('filesystems.default', 'private-s3');
        Redis::shouldReceive('connection')->once()->with('queue')->andThrow(new RuntimeException('redis-host-secret'));
        Storage::shouldReceive('disk')->once()->with('private-s3')->andThrow(new RuntimeException('storage-path-secret'));

        $result = app(CheckReadiness::class)->handle();

        $this->assertSame([
            'database' => 'down',
            'redis' => 'down',
            'storage' => 'down',
        ], $result);
    }
}
