<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\GetDatesAction;
use Illuminate\View\View;

final class IndexController extends Controller
{
    public function index(GetDatesAction $action): View
    {
        $dates = $action->getAllDates();

        return view('dates.index', ['dates' => $dates]);
    }
}
