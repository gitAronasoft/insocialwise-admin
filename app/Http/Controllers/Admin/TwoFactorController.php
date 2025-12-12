<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Writer;

class TwoFactorController extends Controller
{
    protected Google2FA $google2fa;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }

    public function show()
    {
        $user = Auth::guard('admin')->user();
        
        return view('admin.profile.two-factor', [
            'enabled' => $user->hasTwoFactorEnabled(),
            'recoveryCodes' => $user->hasTwoFactorEnabled() ? $user->getTwoFactorRecoveryCodes() : [],
        ]);
    }

    public function enable(Request $request)
    {
        $user = Auth::guard('admin')->user();
        
        if ($user->hasTwoFactorEnabled()) {
            return redirect()->route('admin.profile.two-factor')
                ->with('error', 'Two-factor authentication is already enabled.');
        }

        $secret = $this->google2fa->generateSecretKey();
        
        $user->two_factor_secret = encrypt($secret);
        $user->save();

        $qrCodeUrl = $this->google2fa->getQRCodeUrl(
            config('app.name', 'InSocialWise'),
            $user->email,
            $secret
        );

        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCodeSvg = $writer->writeString($qrCodeUrl);

        return view('admin.profile.two-factor-confirm', [
            'qrCodeSvg' => $qrCodeSvg,
            'secret' => $secret,
        ]);
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $user = Auth::guard('admin')->user();
        $secret = decrypt($user->two_factor_secret);

        if (!$this->google2fa->verifyKey($secret, $request->code)) {
            return back()->withErrors(['code' => 'The provided code is invalid.']);
        }

        $recoveryCodes = collect(range(1, 8))->map(fn () => Str::random(10).'-'.Str::random(10))->toArray();
        
        $user->two_factor_confirmed_at = now();
        $user->two_factor_recovery_codes = encrypt(json_encode($recoveryCodes));
        $user->save();

        return redirect()->route('admin.profile.two-factor')
            ->with('success', 'Two-factor authentication has been enabled.')
            ->with('recoveryCodes', $recoveryCodes);
    }

    public function disable(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $user = Auth::guard('admin')->user();

        if (!password_verify($request->password, $user->password)) {
            return back()->withErrors(['password' => 'The provided password is incorrect.']);
        }

        $user->two_factor_secret = null;
        $user->two_factor_recovery_codes = null;
        $user->two_factor_confirmed_at = null;
        $user->save();

        return redirect()->route('admin.profile.two-factor')
            ->with('success', 'Two-factor authentication has been disabled.');
    }

    public function regenerateRecoveryCodes(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $user = Auth::guard('admin')->user();

        if (!password_verify($request->password, $user->password)) {
            return back()->withErrors(['password' => 'The provided password is incorrect.']);
        }

        $recoveryCodes = collect(range(1, 8))->map(fn () => Str::random(10).'-'.Str::random(10))->toArray();
        
        $user->two_factor_recovery_codes = encrypt(json_encode($recoveryCodes));
        $user->save();

        return redirect()->route('admin.profile.two-factor')
            ->with('success', 'Recovery codes have been regenerated.')
            ->with('recoveryCodes', $recoveryCodes);
    }

    public function challenge()
    {
        return view('admin.auth.two-factor-challenge');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'nullable|string',
            'recovery_code' => 'nullable|string',
        ]);

        $userId = session('login.id');
        $user = \App\Models\AdminUser::find($userId);

        if (!$user) {
            return redirect()->route('admin.login')
                ->with('error', 'Session expired. Please login again.');
        }

        if ($request->filled('code')) {
            $secret = decrypt($user->two_factor_secret);
            
            if (!$this->google2fa->verifyKey($secret, $request->code)) {
                return back()->withErrors(['code' => 'The provided code is invalid.']);
            }
        } elseif ($request->filled('recovery_code')) {
            $recoveryCodes = $user->getTwoFactorRecoveryCodes();
            
            if (!in_array($request->recovery_code, $recoveryCodes)) {
                return back()->withErrors(['recovery_code' => 'The provided recovery code is invalid.']);
            }
            
            $user->replaceRecoveryCode($request->recovery_code);
        } else {
            return back()->withErrors(['code' => 'Please provide a code or recovery code.']);
        }

        Auth::guard('admin')->login($user);
        session()->forget('login.id');

        return redirect()->intended(route('admin.dashboard'));
    }
}
