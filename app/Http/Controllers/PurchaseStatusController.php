<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PurchaseStatusController extends Controller
{
    private function setEnv($key, $value)
    {
        file_put_contents(app()->environmentFilePath(), str_replace(
            $key.'='.env($value),
            $key.'='.$value,
            file_get_contents(app()->environmentFilePath())
        ));
    }

    public function index()
    {
        if (preg_match('/^([a-f0-9]{8})-(([a-f0-9]{4})-){3}([a-f0-9]{12})$/i', config('services.envato.purchase_code'))) {
            return redirect('/');
        }

        return view('purchase.index');
    }

    public function purchaseCode(Request $request)
    {
        $code = $request->purchase_code;

        $request->validate([
            'purchase_code' => ['required', 'regex:/^([a-f0-9]{8})-(([a-f0-9]{4})-){3}([a-f0-9]{12})$/i'],
        ]);

        $response = Http::withToken(config('services.envato.personal_token'))
            ->get('https://api.envato.com/v3/market/author/sale', [
                'code' => $code,
            ]);

        if ($response->failed()) {
            return back()->with([
                'message' => 'Invalid purchase code!',
            ]);
        }

        $this->setEnv('ENVATO_PURCHASE_CODE', $code);

        return $response->json();
    }
}
