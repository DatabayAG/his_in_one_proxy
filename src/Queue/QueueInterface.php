<?php

namespace HisInOneProxy\Queue;

interface QueueInterface
{

    public function pop(string $queue_name): array;
    public function queueExists(string $queue_name): bool;
    public function getSize(string $queue_name): int;
    public function cleanUpStaleJobs(): void;
    public function push(string $queue_name, string $data, string $function = '', string $receiver = '', int $unix_time = 0): void;
    public function removeMessage(string $queue_name, string $id): void;
    public function reAddMessageToQueue(string $queue_name, string $id): void;

}
