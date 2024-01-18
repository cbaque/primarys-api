<?php

function response_data($data, $status, $message,  $type=null)
{
    return response()->json([
        'data'      => $data,
        'message'   => $message,
        // 'type'     => $type,
    ], $status);
}
