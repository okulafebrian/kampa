<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrganizationResource;
use App\Models\Contact;
use App\Models\Employment;
use App\Models\Interaction;
use App\Models\Organization;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $interactionsCount = Interaction::where('user_id', auth()->user()->id)->count();
        $answeredCount = Interaction::where('user_id', auth()->user()->id)->where('status', 'answered')->count();
        $callBackCount = Interaction::where('user_id', auth()->user()->id)->where('status', 'call back')->count();
        $notInterestedCount = Interaction::where('user_id', auth()->user()->id)->where('status', 'not interested')->count();
        $notHomeCount = Interaction::where('user_id', auth()->user()->id)->where('status', 'not home')->count();
        $inaccessibleCount = Interaction::where('user_id', auth()->user()->id)->where('status', 'inaccessbile')->count();

        $ratings = Interaction::where('user_id', auth()->user()->id)->average('support_level');

        $conversionRate = ($answeredCount / $interactionsCount) * 100;

        return inertia('Dashboard', [
            'interactionsCount' => $interactionsCount,
            'answeredCount' => $answeredCount,
            'callBackCount' => $callBackCount,
            'notInterestedCount' => $notInterestedCount,
            'notHomeCount' => $notHomeCount,
            'inaccessibleCount' => $inaccessibleCount,
            'avgRating' => round($ratings, 2),
            'conversionRate' => number_format($conversionRate, 2)
        ]);
    }
}
