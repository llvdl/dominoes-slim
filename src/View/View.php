<?php

namespace Llvdl\View;

class View implements ViewInterface
{
    /** @var string */
    private $templateFolder;

    /** @var array */
    private $globalData;

    public function __construct(string $templateFolder, array $globalData = [])
    {
        $this->templateFolder = $templateFolder;
        $this->globalData = $globalData;
    }

    public function render(string $template, array $data = []): string
    {
        $path = sprintf('%s/%s', $this->templateFolder, $template);

        if (!is_file($path)) {
            throw new \RuntimeException(sprintf('Cannot find template "%s"', $path));
        }

        ob_start();
        $this->invokeTemplate($path, array_merge($this->globalData, $data));

        return ob_get_clean();
    }

    private function invokeTemplate(string $path, array $data): void
    {
        // instantiate a helper, so the Escaper static methods can be used in the template
        $factory = new \Aura\Html\HelperLocatorFactory;
        $factory->newInstance();

        $this->doInvokeTemplate($path, $data);
    }

    private function doInvokeTemplate(string $path, array $data): void
    {
        $_private_data = [
            'path' => $path,
            'data' => $data
        ];
        unset($path);
        unset($data);

        extract($_private_data['data']);
        include($_private_data['path']);
    }
}
