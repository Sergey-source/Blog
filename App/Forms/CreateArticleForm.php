<?php
namespace App\Forms;

use App\Forms\BaseForm;
use App\Forms\Fields\InputField;
use App\Forms\Fields\TextareaField;

class CreateArticleForm extends BaseForm
{
    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->fields['title'] = new InputField([
            'type' => 'text',
            'name' => 'title',
            'placeholder' => 'Заголовок',
            'class' => 'form_field'
        ]);

        $this->fields['body'] = new TextareaField([
            'name' => 'body',
            'placeholder' => 'Содержание статьи',
            'class' => 'form_field'
        ]);
    }

    public function clean_title($title)
    {
        if (strlen($title) > 50) {
            return $this->fields['title']->addError('Заголовок должен быть меньше 50 символов');
        }

        return $title;
    }

}
