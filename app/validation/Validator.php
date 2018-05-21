<?php
namespace Bank\Validation;


class Validator
{
    protected $params;
    protected $errors=[];

    public function checkParametrs($cellName, $cell, $requestBody=false){
        $json = file_get_contents('../parametrs.json');
        $this->params = json_decode($json, true);
        $cellParams = $this->params[$cellName];

        $countParams = isset($cellParams["trigger"]) ? count($cellParams)-1 : count($cellParams);
        if(count($cell) !== $countParams){
            return '30';
        }

        foreach ($cellParams as $paramName => $funcName){
            if($paramName === 'trigger'){
                $trigger = $cellParams["trigger"];
                //если тригер не находится в ячейки objects получаем нужную ячейку
                if($trigger["cell"] !== "objects"){
                    $cell = $requestBody[$trigger["cell"]];
                }

                $tagName =  $trigger["tag"];
                $tag = $cell[$tagName];

                foreach ($trigger["options"] as $key => $numError){
                    //ишем значения-триггеры($key), если находим вызываем соответствующую ошибку
                    if($tag === $key){
                        return $numError;
                    }
                }
            }elseif (isset($cell[$paramName])){
                $func = "validate".ucfirst($funcName);
                $this->errors[] = $this->$func($cell[$paramName]);
            }else{
                return '30';
            }

        }
        //убираем все пустые значения массива
        $errors = array_diff($this->errors, ['']);
        if(!empty($errors)){
            return array_shift($errors);
        }
    }


    protected function validateNum($num){
        if(!preg_match('/^[0-9]+$/', $num)){
            return '30';
        }
    }

    protected  function validateCardNum($cardNum){
        if(!preg_match('/^[0-9]{16}$/',$cardNum)){
            return '30';
        }
    }

    protected function validateName($name){
        if (!preg_match("/^[A-Z][a-zA-Z]{1,40}$/u", $name)) {
            return '30';
        }
    }

    protected function validateSurname($surname){
        if (!preg_match("/^[A-Z][-a-zA-Z]{1,60}$/u", $surname)) {
            return "30";
        }
    }

    protected function validatePin($pin){
        if(!preg_match('/^[0-9]{4}$/',$pin)){
            return "30";
        }
    }

    public function structureValidation($request){
        if(isset($request["request"])){
            $body = $request["request"];

            if(!isset($body["header"]) || !isset($body["footer"]) || !isset($body["objects"])){
                return '30';
            }
            if(count($body) !==3){
                return '30';
            }
            if(count($request) !== 1){
                return '30';
            }
        }else{
            return '30';
        }
    }




}