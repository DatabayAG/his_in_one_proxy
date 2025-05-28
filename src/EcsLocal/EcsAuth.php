<?php

namespace HisInOneProxy\EcsLocal;

class EcsAuth
{
    private ?int $pid = null;
    private ?int $cid = null;
    private ?int $mid = null;
    private bool $valid = false;

    public function __construct(?int $pid, ?int $mid, ?int $cid)
    {
            $this->pid = $pid;
            $this->mid = $mid;
            $this->cid = $cid;
    }

    public function getPid(): ?int
    {
        return $this->pid;
    }

    public function getCid(): ?int
    {
        return $this->cid;
    }

    public function getMid(): ?int
    {
        return $this->mid;
    }

    public function isValid(): bool
    {
        if($this->getPid() !== null && $this->getMid() !== null && $this->getCid() !== null) {
            return true;
        }
        return false;
    }

    public function isInvalidAuth(): bool
    {
        return !$this->isValid();
    }

}
