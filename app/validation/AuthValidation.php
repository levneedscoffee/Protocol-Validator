<?php
namespace Bank\Validation;


class AuthValidation extends Validator
{
    protected function validateMonth($month){
        if(!preg_match('/^[0-9]{2}$/', $month) || $month < 1 || $month > 12 ){
            return '30';
        }
    }

    protected function validateYear($year){
        if(!preg_match('/^[0-9]{2}$/', $year) || $year < 1 || $year > 99 ){
            return '30';
        }
    }
}