<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\RegencyResource;
use App\Http\Resources\UserResource;
use App\Models\Contact;
use App\Models\District;
use App\Models\Employment;
use App\Models\Interaction;
use App\Models\Organization;
use App\Models\Regency;
use App\Models\User;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function __invoke()
    {
        $genders = [
            'male' => Contact::where('organization_id', auth()->user()->organization_id)->where('gender', 'male')->count(),
            'female' => Contact::where('organization_id', auth()->user()->organization_id)->where('gender', 'female')->count(),
        ];

        $ages = [
            '17-23' => Contact::where('organization_id', auth()->user()->organization_id)->whereRaw('TIMESTAMPDIFF(YEAR, dob, CURDATE()) BETWEEN 17 AND 23')->count(),
            '24-34' => Contact::where('organization_id', auth()->user()->organization_id)->whereRaw('TIMESTAMPDIFF(YEAR, dob, CURDATE()) BETWEEN 24 AND 34')->count(),
            '35-44' => Contact::where('organization_id', auth()->user()->organization_id)->whereRaw('TIMESTAMPDIFF(YEAR, dob, CURDATE()) BETWEEN 24 AND 34')->count(),
            '>45' => Contact::where('organization_id', auth()->user()->organization_id)->whereRaw('TIMESTAMPDIFF(YEAR, dob, CURDATE()) > 45')->count(),
        ];

        $queries = Employment::withCount('contacts')
            ->orderByDesc('contacts_count')
            ->limit(5)
            ->get();

        $employments = [];

        foreach ($queries as $i => $query) {
            $employments[$i]['name'] = $query->name;
            $employments[$i]['count'] = $query->contacts_count;
        }

        $interactionsCount = Interaction::where('organization_id', auth()->user()->organization_id)->count();
        $answeredCount = Interaction::where('organization_id', auth()->user()->organization_id)->where('status', 'answered')->count();
        $callBackCount = Interaction::where('organization_id', auth()->user()->organization_id)->where('status', 'call back')->count();
        $notInterestedCount = Interaction::where('organization_id', auth()->user()->organization_id)->where('status', 'not interested')->count();
        $notHomeCount = Interaction::where('organization_id', auth()->user()->organization_id)->where('status', 'not home')->count();
        $inaccessibleCount = Interaction::where('organization_id', auth()->user()->organization_id)->where('status', 'inaccessbile')->count();

        $ratings = Interaction::where('organization_id', auth()->user()->organization_id)->average('support_level');

        $conversionRate = ($answeredCount / $interactionsCount) * 100;

        $bestUsers =
            User::withCount('interactions')
            ->orderBy('interactions_count', 'desc')
            ->take(5)
            ->get();

        return inertia('Statistic', [
            'genders' => $genders,
            'ages' => $ages,
            'employments' => $employments,
            'interactionsCount' => $interactionsCount,
            'answeredCount' => $answeredCount,
            'callBackCount' => $callBackCount,
            'notInterestedCount' => $notInterestedCount,
            'notHomeCount' => $notHomeCount,
            'inaccessibleCount' => $inaccessibleCount,
            'avgRating' => round($ratings, 2),
            'conversionRate' => number_format($conversionRate, 2),
            'bestUsers' => UserResource::collection($bestUsers)
        ]);
    }
}
