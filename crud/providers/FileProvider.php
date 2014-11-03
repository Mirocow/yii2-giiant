<?php

namespace schmunk42\giiant\crud\providers;

class FileProvider extends \schmunk42\giiant\base\Provider
{
    private function isFileType($attribute, $model)
    {
        //Filter the model->rules to get the file type and current attribute name
        $model_rules_attribute =  array_filter($model->rules()
            , function($var) use ($attribute) {
                if (in_array($var[1], array("file","image")) && in_array($attribute->name, $var[0]))
                    return true;
                else 
                    return false;
            });
        
        return !empty($model_rules_attribute);
    }
    
    public function activeField($column)
    {
        //Get the $model from arguments passed to the function
        if (func_num_args()>=2) $model = func_get_args()[1];
        
        //The current column is not a file
        if (!$this->isFileType($column, $model))
            return null;
        
        return <<<EOS
\$form->field(\$model, '{$column->name}')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*'],
    'pluginOptions' => [
        'initialPreview'=> (\$model->isNewRecord) ? '' : Html::img(\$model->{$column->name}, ['class'=>'file-preview-image', 'alt'=>\$model->name, 'title'=>\$model->name]),
        'layoutTemplates' => [
            'preview' => "<div class=\"file-preview\">\\n"
                . "   <div class=\"file-preview-thumbnails\"></div>\\n"
                . "   <div class=\"clearfix\"></div>"
                . "</div>" 
        ],
        'showPreview' => true,
        'showCaption' => true,
        'showRemove' => false,
        'showUpload' => false
    ]
]);
EOS;
    }
    
    public function attributeFormat($column)
    {
        if (func_num_args()>=2) { 
            $model = func_get_args()[1]; //Return a string
            $model = new $model; //Get the model object
        }
        
        if (!$this->isFileType($column, $model))
            return null;
        else
            return <<<EOS
            [
                'format'=>'image',
                'attribute'=>'$column->name',
            ]
EOS;
    }
} 