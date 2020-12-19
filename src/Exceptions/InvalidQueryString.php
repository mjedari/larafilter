<?php

namespace Mjedari\Larafilter\Exceptions;

use Exception;
use Illuminate\Http\Request;

class InvalidQueryString extends Exception
{
    /**
     * Report the exception.
     *
     * @return bool|void
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception as an HTTP response.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function render($request)
    {
        return redirect()->to($request->path());
    }
}
