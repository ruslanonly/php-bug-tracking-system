<?php
    function error($message) {
        return array(
            "status" => "error",
            "messages" => $message
        );
    }

    function success($message) {
        return array(
            "status" => "success",
            "message" => $message
        );
    }
?>