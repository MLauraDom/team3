<?php
    function response($status, $message, $data = null){
        $response = new stdClass;
        $response->status = $status;
        $response->message = $message;
        $response->data = $data;
        echo json_encode($response);
    }

?>