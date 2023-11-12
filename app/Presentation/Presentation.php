<?php

namespace App\Presentation;

class Presentation
{
    public static function paginateRequest($page, $perPage, $orderBy, $orderMehtod) {
        $paginate = [
            'page'          => $page,
            'per_page'      => $perPage,
            'order_by'      => $orderBy,
            'order_method'  => $orderMehtod
        ];

        return $paginate;
    }

    public static function serviceResponse($code, $message = null, $primaryData = null, $secondaryData = null) {
        $res = [];
        if ($primaryData !== null && $secondaryData !== null) {
            $res['code']            = $code;
            $res['message']         = $message;
            $res['primary_data']    = $primaryData;
            $res['secondary_data']  = $secondaryData;
        } elseif ($primaryData !== null && $secondaryData == null) {
            $res['code']            = $code;
            $res['message']         = $message;
            $res['primary_data']    = $primaryData;
        } elseif ($secondaryData == null && $secondaryData !== null) {
            $res['code']            = $code;
            $res['message']         = $message;
            $res['secondary_data']  = $secondaryData;
        } else {
            $res['code']            = $code;
            $res['message']         = $message;
        }

        return $res;
    }

    public static function presentResponse($code, $message, $data = null) {
        switch ($data) {
            case null:
                $resp = response()->json([
                    'status_code'   => $code,
                    'message'       => $message
                ], $code);
            default:
                $resp = response()->json([
                    'status_code'   => $code,
                    'message'       => $message,
                    'data'          => $data
                ], $code);
        }

        return $resp;
    }
}
