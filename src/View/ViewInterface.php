<?php

namespace Llvdl\View;

interface ViewInterface
{
    public function render(string $template, array $data = []): string;
}
