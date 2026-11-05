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
 * their message. The exception renders itself, so controllers never catch it:
 * as an error on `$field` when the screen shows it under an input, as an error
 * toast otherwise.
 */
abstract class DomainException extends Exception
{
    /**
     * The HTTP status used for JSON responses.
     */
    protected int $status = 422;

    /**
     * The form field the error belongs to, or null for a toast.
     */
    protected ?string $field = null;

    /**
     * The replacements for the translated message.
     *
     * @var array<string, string|int>
     */
    protected array $replace = [];

    /**
     * The translated message shown to the user.
     */
    public function translatedMessage(): string
    {
        return __($this->getMessage(), $this->replace);
    }

    /**
     * Render the exception as a translated error response.
     */
    public function render(Request $request): JsonResponse|RedirectResponse
    {
        $message = $this->translatedMessage();

        if ($request->expectsJson()) {
            return response()->json(array_filter([
                'message' => $message,
                'errors' => $this->field !== null ? [$this->field => [$message]] : null,
            ]), $this->status);
        }

        if ($this->field !== null) {
            return back()->withErrors([$this->field => $message])->withInput($request->except('password', 'code'));
        }

        Inertia::flash('toast', ['type' => 'error', 'message' => $message]);

        return back();
    }
}
