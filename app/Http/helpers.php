<?php

function successMessage($message,$code=200)
{
    return response()->json([
        'success'=>true,
        'message'=>$message,
        'code'=>$code
    ]);
}

function errorMessage($error,$code=500)
{
    return response()->json([
        'success'=>false,
        'error'=>$error,
        'code'=>$code
    ]);
}

function successResponse($data,$code=200)
{
    return response()->json([
        'success'=>true,
        'data'=>$data,
        'code'=>$code
    ]);
}
