<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Checkout page - no authentication required for program registration
Volt::route('checkout', 'checkout')->name('checkout');

Route::match(['get', 'post'], 'payment/webhook', function (\Illuminate\Http\Request $request) {
    Log::info('PayChangu webhook received', [
        'method' => $request->method(),
        'query' => $request->query(),
        'headers' => $request->headers->all(),
        'body' => $request->getContent(),
    ]);

    // Handle PayChangu webhook - for GET requests, get data from query params
    $paychangu = new \App\Services\PayChanguService();

    if ($request->isMethod('GET')) {
        // Handle GET redirect with query parameters
        $txRef = $request->query('tx_ref');
        $status = $request->query('status');

        if (!$txRef) {
            Log::warning('No tx_ref in GET webhook request');
            return response('Missing tx_ref', 400);
        }

        Log::info('Processing GET webhook', ['tx_ref' => $txRef, 'status' => $status]);

        // Always verify with PayChangu API regardless of status from redirect
        $verificationResult = $paychangu->verifyPayment($txRef);

        if ($verificationResult['success'] && $verificationResult['status'] === 'success') {
            $user = \App\Models\User::where('payment_reference', $txRef)->first();

            if ($user) {
                $expectedAmount = 7000; // MWK 7,000 registration fee
                $paidAmount = $verificationResult['data']['data']['amount'] ?? 0;

                if ($paidAmount >= $expectedAmount) {
                    // Use Verbs event sourcing to handle payment completion
                    Log::info('About to fire PaymentCompleted event for user ' . $user->id);
                    
                    \App\Events\PaymentCompleted::fire(
                        userId: $user->id,
                        paymentReference: $txRef,
                        amount: (float) $paidAmount,
                    );

                    // Commit the event immediately to trigger state updates and emails
                    \Thunk\Verbs\Facades\Verbs::commit();

                    Log::info('PaymentCompleted event fired and committed successfully for user ' . $user->id);
                    Log::info('Payment successfully processed via GET webhook for user ' . $user->id);

                    // Redirect to success page
                    return redirect()->route('home', ['payment' => 'success']);
                } else {
                    Log::warning('Payment amount mismatch in GET webhook', [
                        'expected' => $expectedAmount,
                        'received' => $paidAmount,
                        'user_id' => $user->id,
                    ]);
                    return redirect()->route('home', ['payment' => 'failed']);
                }
            } else {
                Log::warning('User not found for payment reference in GET webhook: ' . $txRef);
                return redirect()->route('home', ['payment' => 'failed']);
            }
        } else {
            Log::warning('Payment verification failed in GET webhook', $verificationResult);
            return redirect()->route('home', ['payment' => 'failed']);
        }
    } else {
        // Handle POST webhook with signature verification
        $payload = $request->getContent();
        $signature = $request->header('Signature');

        $result = $paychangu->handleWebhook($payload, $signature);

        if (!$result['success']) {
            Log::warning('PayChangu POST webhook validation failed', $result);
            return response()->json(['error' => $result['error']], 400);
        }

        // Always re-verify the payment with PayChangu API before processing
        $verificationResult = $paychangu->verifyPayment($result['tx_ref']);

        if ($verificationResult['success'] && $verificationResult['status'] === 'success') {
            $user = \App\Models\User::where('payment_reference', $result['tx_ref'])->first();

            if ($user) {
                $expectedAmount = 7000; // MWK 7,000 registration fee
                $paidAmount = $verificationResult['data']['data']['amount'] ?? 0;

                if ($paidAmount >= $expectedAmount) {
                    // Use Verbs event sourcing to handle payment completion
                    Log::info('About to fire PaymentCompleted event for user ' . $user->id . ' via POST webhook');
                    
                    \App\Events\PaymentCompleted::fire(
                        userId: $user->id,
                        paymentReference: $result['tx_ref'],
                        amount: (float) $paidAmount,
                    );

                    // Commit the event immediately to trigger state updates and emails
                    \Thunk\Verbs\Facades\Verbs::commit();

                    Log::info('PaymentCompleted event fired and committed successfully for user ' . $user->id . ' via POST webhook');
                    Log::info('Payment successfully processed via POST webhook for user ' . $user->id);
                } else {
                    Log::warning('Payment amount mismatch in POST webhook', [
                        'expected' => $expectedAmount,
                        'received' => $paidAmount,
                        'user_id' => $user->id,
                    ]);
                }
            } else {
                Log::warning('User not found for payment reference in POST webhook: ' . $result['tx_ref']);
            }
        }

        return response('', 200); // PayChangu expects 200 status code for POST webhooks
    }
})->name('payment.webhook');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
