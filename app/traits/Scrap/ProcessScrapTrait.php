<?php

namespace App\Traits\Scrap;

trait ProcessScrapTrait
{
    /**
     * Get request output and returns json object
     * Scrap code from: https://github.com/luannsr12/correios-rastreio
     */
    public function processOutput($output)
    {
        $out = explode("table class=\"listEvent sro\">", $output);

        if (!isset($out[1])) {
            $this->data->erro = true;
            $this->data->msg = "Objeto não encontrado";
            echo json_encode($this->data);
            exit();
        }

        $output = explode("<table class=\"listEvent sro\">", $output);
        $output = explode("</table>", $output[1]);
        $output = str_replace("</td>", "", $output[0]);
        $output = str_replace("</tr>", "", $output);
        $output = str_replace("<strong>", "", $output);
        $output = str_replace("</strong>", "", $output);
        $output = str_replace("<tbody>", "", $output);
        $output = str_replace("</tbody>", "", $output);
        $output = str_replace("<label style=\"text-transform:capitalize;\">", "", $output);
        $output = str_replace("</label>", "", $output);
        $output = str_replace("&nbsp;", "", $output);
        $output = str_replace("<td class=\"sroDtEvent\" valign=\"top\">", "", $output);
        $output = explode("<tr>", $output);

        $objArray = [];
        foreach ($output as $texto) {
            $info   = explode("<td class=\"sroLbEvent\">", $texto);
            $dados  = explode("<br />", $info[0]);

            $dia   = trim($dados[0]);
            $hora  = trim(@$dados[1]);
            $local = trim(@$dados[2]);

            $dados = explode("<br />", @$info[1]);
            $acao  = trim($dados[0]);

            $actionComplement = @explode('<br />', substr(@$info[1], strpos(@$info[1], '<br />')))[1];

            $exAction   = '<b>' . $acao . '</b><br>' . $actionComplement;

            //$actionMsg  = strip_tags(trim(preg_replace('/\s\s+/', ' ', $exAction)));
            $actionMsg  = trim(preg_replace('/\s\s+/', ' ', $exAction));

            if ("" != $dia) {
                $exploDate = explode('/', $dia);
                $dia1 = $exploDate[2] . '-' . $exploDate[1] . '-' . $exploDate[0];
                $dia2 = date('Y-m-d');

                $diferenca = strtotime($dia2) - strtotime($dia1);
                $dias = floor($diferenca / (60 * 60 * 24));

                $change = utf8_encode("há {$dias} dias");

                $objArray[] = array("date" => $dia, "hour" => $hora, "location" => $local, "action" => utf8_encode($acao), "message" => utf8_encode($actionMsg), "change" => utf8_decode($change));
            }
        }
        $this->data = (object)$objArray;
        return json_encode($this->data);
    }
}
