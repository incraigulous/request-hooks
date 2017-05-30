<?php
namespace Incraigulous\RequestHooks\Contracts;

interface RequestHook
{
    public function handle();
    public function shouldHandle();
}