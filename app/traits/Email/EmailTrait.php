<?php

namespace App\Traits\Email;

use App\Classes\Email;
use App\Classes\Pdf;

trait EmailTrait
{
    public function sendTrackEmail($body, $emailObJson, $isTrackSubject = false, $pdfFile = null)
    {
        $email = new Email();
        // $emailObJson = (object) $this->getJsonRequestKey('email');
        $emailObJson = (object) $emailObJson;

        $subject = $isTrackSubject ?? $emailObJson->subject;

        $email->add($subject, $body, $emailObJson->recipient_name, $emailObJson->recipient_email);

        if ($pdfFile) {
            // ob_start();
            // $pdf = new Pdf();
            // $pdf->loadHTML($pdfFile);
            // $pdfFile = ob_get_clean();

            // $email->attach($pdfFile, 'file.pdf');
        }

        $email->send();

        if (!$email->error()) {
            var_dump(true);
            die();
        }
        echo $email->error()->getMessage();
    }

    public function sendEmail($tracks, $objStatus, $jsonKey, $emailObJson, $timeLineInfo = null)
    {
        ob_start();
        $this->renderTrackTemplate($tracks, $jsonKey, $objStatus, $timeLineInfo);
        $body = ob_get_clean();

        $this->sendTrackEmail($body, $emailObJson, $objStatus['message'], $body);
    }
}
