<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

/**
 * Base class for every business-rule violation thrown by a service.
 *
 * Subclasses live in App\Exceptions\<Module>\ and pass a translation key as
 * their message. The exception renders itself, so controllers never catch it.
 */
abstract class DomainException extends Exception
{
    /**
     * The HTTP status used for JSON responses.
     */
    protected int $status = 422;

    /**
     * Render the exception as a translated error response.
     */
    public function render(Request $request): JsonResponse|RedirectResponse
    {
        $message = __($this->getMessage());

        if ($request->expectsJson()) {
            return response()->json(['message' => $message], $this->status);
        }

        Inertia::flash('toast', ['type' => 'error', 'message' => $message]);

        return back();
    }
}
