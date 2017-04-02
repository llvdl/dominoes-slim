<?php

namespace Llvdl\Responder\Common;

class Form
{
    /** @var array */
    private $data;

    /** @var array */
    private $errors;

    /** @var string */
    private $id;

    /** @string */
    private $viewsFolder;

    public function __construct(?array $data, ?array $errors)
    {
        $this->data = $data ?: [];
        $this->errors = $errors;
        $this->id = null;

        $this->viewsFolder = __DIR__ . '/../../../app/views/Common/Form';
    }

    public function setId(?string $id)
    {
        $this->id = $id;
    }

    public function renderStart()
    {
        $this->renderTemplate('/bootstrap_form_start.phtml', ['id' => $this->id]);
    }

    public function renderEnd()
    {
        $this->renderTemplate('/bootstrap_form_end.phtml');
    }

    public function renderTextField(string $name, string $label, ?string $id = null)
    {
        $this->renderInputField('text', $name, $label, $id);
    }

    public function renderPasswordField(string $name, string $label, ?string $id = null)
    {
        $this->renderInputField('password', $name, $label, $id);
    }

    private function renderInputField(string $type, string $name, string $label, ?string $id = null)
    {
        $this->renderTemplate('/bootstrap_input_field.phtml', [
            'type' => $type,
            'name' => $name,
            'label' => $label,
            'id' => $id ?: 'id_' . bin2hex(random_bytes(8)),
            'data' => $this->data,
            'errors' => $this->errors
        ]);
    }

    private function renderTemplate(string $templateName, array $variables = [])
    {
        extract($variables);
        unset($variables);

        include $this->viewsFolder . '/' . $templateName;
    }
}
