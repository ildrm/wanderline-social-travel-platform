<?php

namespace App\Support\Health;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class CheckReadiness
{
    /** @return array{database: string, redis: string, storage: string} */
    public function handle(): array
    {
        return [
            'database' => $this->probe(fn () => DB::selectOne('select 1')),
            'redis' => $this->probe(function (): void {
                $connection = (string) config('queue.connections.redis.connection', 'queue');
                Redis::connection($connection)->command('ping');
            }),
            'storage' => $this->probe(function (): void {
                $disk = Storage::disk((string) config('filesystems.default'));
                $path = '.readiness/'.Str::uuid();

                try {
                    if (! $disk->put($path, 'ready') || $disk->get($path) !== 'ready') {
                        throw new \RuntimeException('Private storage readiness check failed.');
                    }
                } finally {
                    $disk->delete($path);
                }
            }),
        ];
    }

    private function probe(callable $probe): string
    {
        try {
            $probe();

            return 'up';
        } catch (Throwable $exception) {
            report($exception);

            return 'down';
        }
    }
}
