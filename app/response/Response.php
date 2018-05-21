<?php
namespace Bank\Response;


class Response
{
    public function generateResponse($answerNum, $versionTag=1, $commandTag="ERROR"){
        $errorsArray = ["30"=> "Format error", "31" =>"Unable to perform operation", "40" => "Internal error"];

        $response = [
            "response" => [
                "header" => [
                    "version" => $versionTag,
                    "command" => $commandTag
                ],
                "objects" => [],
                "footer" => [
                    "timestamp" => time(),
                ]
            ]
        ];

        if(isset($errorsArray[$answerNum])){
            $errormsg = $errorsArray[$answerNum];

            $response["response"]["footer"]["errormsg"] =  $errormsg;
        }

        if($answerNum == 50){
            echo json_encode("Ошибка 50, ответа нет");
            exit;
        }

        return json_encode($response);

    }
}