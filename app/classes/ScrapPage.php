<?php

namespace App\Classes;

use App\Core\View;
use App\Traits\ApiMethods;
use App\Traits\Email\EmailTrait;
use App\Traits\Scrap\ProcessScrapTrait;
use App\Traits\Scrap\TemplateScrapTrait;
use stdClass;

class ScrapPage
{
    use ApiMethods;
    use EmailTrait;
    use TemplateScrapTrait;
    use ProcessScrapTrait;

    private $data;

    public function __construct()
    {
        if (!$this->isGetParam('key')) {
            // Header to return json
            header('Content-type: application/json');
        }
        $this->data = new stdClass;
    }

    public function getRequestObj($key = 'obj')
    {
        return $this->getJsonRequestKey($key);
    }

    public function fetchObj()
    {
        $isGetParam = $this->isGetParam('key');
        // $arrayObj = $this->getContents();

        // if (isset($arrayObj['objects'])) {
        //     foreach ($arrayObj['objects'] as $object) {
        //         $this->sendToOutput($object);
        //     }
        // }

        if (!$isGetParam && !$this->getRequestObj()) {
            $this->data->error = true;
            $this->data->message = "Parâmetro vazio";
            echo json_encode($this->data);
            exit();
        }

        if ($isGetParam) {
            $arrayObj['obj'] = $isGetParam;
            $arrayObj['email'] = ["recipient_name" => "Marcos","recipient_email" => "marcos_sco@outlook.com"]; 
            $this->sendToOutput($arrayObj);
        }

        $this->sendToOutput($arrayObj);
    }

    /**
     * Receive data from other functions and return a sendObject 
     */
    protected function sendToOutput($object)
    {
        $sendData = ['objetos' => $object['obj']];
        $output = $this->curlPostForm($sendData);
        $jsonData = $this->processOutput($output);
        $tracks = $this->getTracks($jsonData);
        $status = $this->getStatus($tracks);

        $timeLineInfo = $this->getTimelineInfo($tracks);
        return $this->sendObject($object, $tracks, $status, $timeLineInfo);
    }

    /**
     * Get data for timeline 
     * @return Array
     */
    public function getTimelineInfo($tracks)
    {
        // New track array
        $newTrack = [];
        $first = $tracks[0];
        $newTrack[] = $first;
        if (count($tracks) > 1) {
            $last = $tracks[sizeof($tracks) - 1];
            if ($first != $last) {
                $second = $tracks[1];
                if (($second != $first) && ($second != $last)) {
                    $newTrack[] = $second;
                }

                $newTrack[] = $last;
            }
        }

        return array_reverse($newTrack);
    }

    /**
     * Receive json data for decoding
     */
    public function getTracks($jsonData)
    {
        return json_decode($jsonData, true);
    }

    /**
     * Get status last status from a track
     */
    public function getStatus($tracks)
    {
        return $this->getStatusInfo(trim(strip_tags($tracks[0]['message'])));
    }

    /**
     * Send data to render object without or with email
     */
    public function sendObject($object, $tracks, $objStatus, $timeLineInfo)
    {
        $jsonKey = $object['obj'];
        $emailObJson = $object['email'] ?? null;

        if ($emailObJson) {
            $this->sendEmail($tracks, $objStatus, $jsonKey, $emailObJson, $timeLineInfo);
        }
        
        $this->renderTrackTemplate($tracks, $jsonKey, $objStatus, $timeLineInfo);
    }

    /**
     * Get Status and class color
     */
    public function getStatusInfo($objStatus)
    {
        if (str_contains($objStatus, "Objeto entregue ao destinatário")) {
            $status = ['message' => 'Encomenda entregue!', 'color' => '#76aacf'];
        } else if (str_contains($objStatus, 'Objeto saiu para entrega ao destinatário')) {
            $status = ['message' => 'Sua encomenda já está chegando', 'color' => '#f7a936'];
        } else if (str_contains($objStatus, 'Objeto em trânsito - por favor aguarde')) {
            $status = ['message' => 'Sua encomenda está a caminho', 'color' => '#f7a936'];
        } else if (str_contains($objStatus, 'Objeto postado após o horário limite da unidade')) {
            $status = ['message' => 'Sua encomenda vai chegar', 'color' => '#f7a936'];
        } else {
            $status = ['message' => 'Status não informado', 'color' => 'red'];
        }
        return $status;
    }
}
