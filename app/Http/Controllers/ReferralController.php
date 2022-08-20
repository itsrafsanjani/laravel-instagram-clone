<?php

namespace App\Http\Controllers;

use App\Constants\ReferralConstants;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $user = auth()->user();

        // get all referralAccounts for the current authenticated user
        $defaultReferralAccount = $user->referralAccounts()->where('name', ReferralConstants::ACCOUNT_NAME)->first();

        // if no default referral account found, create one
        if (!$defaultReferralAccount) {
            $user->makeReferralAccount('default');

            return redirect()->route('referrals.index');
        }

        // get the referral link for the default referral account
        $referralLink = $defaultReferralAccount->getReferralLink();

        // get all referrals for a referral account
        $referrals = $defaultReferralAccount->referrals()->with('referralable:id,username,name')->paginate(ReferralConstants::PAGINATE_COUNT);

        return view('referrals.index', compact('referrals', 'referralLink'));
    }
}
