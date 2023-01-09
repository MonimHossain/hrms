<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
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
    public function render($request, Exception $exception)
    {
        if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
            toastr()->error('User have not permission for this page access. You logged out.', '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
            //return response()->json(['User have not permission for this page access.']);
            return redirect()->route('login');
        }

        if ($exception instanceof ModelNotFoundException) {
            $exception = new NotFoundHttpException($exception->getMessage(), $exception);
        }

        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
            toastr()->error('You page session expired. Please login again', '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
            return redirect()->route('login');
        }

        //if ($exception instanceof TokenMismatchException && $request->getRequestUri() === '/logout') {
        //    return redirect('/');
        //}

        return parent::render($request, $exception);
    }

    //protected function prepareException(Exception $e)
    //{
    //    if ($e instanceof ModelNotFoundException) {
    //        $e = new NotFoundHttpException($e->getMessage(), $e);
    //    } elseif ($e instanceof AuthorizationException) {
    //        $e = new AccessDeniedHttpException($e->getMessage(), $e);
    //    } elseif ($e instanceof TokenMismatchException) {
    //        return redirect()->route('login');
    //    }
    //
    //    return $e;
    //}
}
