<?php
namespace Bank\Controllers;
use Bank\Response\Response;
use Bank\Validation\FooterValidation;
use Bank\Validation\HeaderValidation;
use Bank\Validation\Validator;


class MainController extends Controller
{
    public function start(){
        if(isset($_POST["request"])) {
            $request = json_decode($_POST["request"], true);

            $responseGenerator = new Response();

            if(json_last_error()){
                $responseGenerator->generateResponse('30');
            }

            $validateStructure = new Validator();
            $structureError = $validateStructure->structureValidation($request);
            if ($structureError) {
                echo $responseGenerator->generateResponse($structureError);
                exit;
            }

            $requestBody = $request["request"];
            $header = $requestBody["header"];
            $footer = $requestBody["footer"];
            $objects = $requestBody["objects"];


            $headerOrFooterError = $this->headerAndFooterValidation($header, $footer);
            if ($headerOrFooterError) {
                echo $responseGenerator->generateResponse($headerOrFooterError);
                exit;
            }

            //Получаем имя объекта-контейнера, пример AuthValidation
            $typePackage = strtolower($header["command"]);
            $className = 'Bank\\Validation\\' . ucfirst($typePackage) . 'Validation';

            $objectsValidation = new $className;
            $objectsError = $objectsValidation->checkParametrs($typePackage, $objects, $requestBody);

            if ($objectsError) {
                echo $responseGenerator->generateResponse($objectsError, $header["version"], $header["command"]);
                exit;
            } else {
                echo $responseGenerator->generateResponse($objectsError, $header["version"], $header["command"]);
                exit;
            }
        }
        $this->twigRender("main/main.html.twig");
    }

    private function headerAndFooterValidation($header, $footer){
        $headerObjects = new HeaderValidation();
        $footerObjects = new FooterValidation();

        $headerError = $headerObjects->checkParametrs("header", $header);
        $footerError = $footerObjects->checkParametrs("footer", $footer);

        if(!empty($headerError) || !empty($footerError)){
            return '30';
        }
    }

}