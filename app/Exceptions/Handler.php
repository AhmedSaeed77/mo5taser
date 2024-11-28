<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use App\Traits\ApiResponser;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        //
    ];
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
       
        if ($exception instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($exception, $request);
        }

        if ($exception instanceof ModelNotFoundException) {

            if($this->isFrontEnd($request))
            {
                return $request->ajax() ? response()->json($errors , 422) : redirect()->back()->with('failed' , __('lang.not_found'));
            }
            $modelName = strtolower(class_basename($exception->getModel()));
            return response()->json(['data' => __('lang.Does not exist Any'). $modelName . __('lang.with this Identifier'),'status' => 404]);
        }

        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        }

        if ($exception instanceof AuthorizationException) {
            return $this->errorResponse($exception->getMessage(), 403);
        }

        if ($exception instanceof NotFoundHttpException) {
            return response()->json(['data' => __('lang.The URL you Entered Does not Exist'),'status' => 405]);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json(['data' => __('lang.Wrong Method With URL'),'status' => 405]);
        }

        if ($exception instanceof HttpException) {
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }
        if ($exception instanceof QueryException) {
            $errorCode = $exception->errorInfo[1];

            if ($errorCode == 1451) {
                return response()->json(['data' => __('lang.can not remove this it is related with othre resouces'),'status' => 409]);
            }

        }
        if ($exception instanceof TokenMismatchException) {
            return response()->json(['data' => __('lang.Csrf token mis match'),'status' => 403]);
        }

        if (config('app.debug')) {
            return parent::render($request, $exception);
        }
        return response()->json(['data' => __('lang.Un Excepected'),'status' => 500]);

    }

    /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();
        if($this->isFrontEnd($request))
        {
            return $request->ajax() ? response()->json($errors , 422) : redirect()->back()->withInput($request->input())->withErrors($errors);
        }
        return response()->json(['data' => implode(" , ",$e->validator->errors()->all()),'status' => 422]);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if($this->isFrontEnd($request))
        {
            return redirect()->guest('login');
        }
        return response()->json(['data' => __('lang.Unauthenticated'),'status' => 401]);
    }

    private function isFrontEnd($request)
    {
        return $request->acceptsHtml() && collect($request->route()->middleware())->contains('web');
    }
}
