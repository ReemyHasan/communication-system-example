<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // parent::report($e);
        });
    }

    public function render($request, Exception|Throwable $e)
    {
        if($e instanceof ValidationException){
            return response([
                'data'=>[
                    'message'=>'text',
                    'errors'=>$e->validator->getMessageBag()
                ]
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if ($e instanceof ModelNotFoundException) {
            return response()->json([
                'message' => explode('\\', $e->getModel())[4] . ' Not Found.',
            ], 404);
        }

        if ($e instanceof AuthorizationException) {
            return response()->json([
                'message' => 'This action is unauthorized.',
            ], 403);
        }

        if ($e instanceof UniqueConstraintViolationException) {
            return response()->json([
                'message' => 'This record already exists.',
            ]);
        }

        if ($e instanceof QueryException) {
            return response()->json([
                'message' => 'Unknown sql error.',
            ]);
        }

        return parent::render($request, $e);
    }
}
