<?php

namespace App\Http\Actions;

use App\Mail\Contract\SendMailToClientSign;
use App\Models\Signatures;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use function response;

class SignatureAction
{
    public function resendEmail($request): JsonResponse
    {
        if (Auth::user()) {
            $signatureId = $request->signature;
            $signature = Signatures::findOrFail($signatureId);
            $contract = $signature->contract;
            if (!$signature->signatured_at) {
                $data = [
                    'token' => $signature->token,
                    'contract_id' => $contract->id,
                    'contract' => $contract,
                    'user' => $contract->user
                ];
                Mail::to($signature->email)->send(new SendMailToClientSign ($data));

                return response()->json(true);

            } else {
                return response()->json(false);
            }

        } else {
            return response()->json(false);
        }
    }
}
