<?php
namespace Bank\Validation;


class HeaderValidation extends Validator
{
    protected function validateCommandTag($command){
        $command = strtolower($command);

        if(!isset($this->params[$command]) || $this->params[$command] === 'footer' || $this->params[$command] === 'header'){
            return '30';
        }
    }
}