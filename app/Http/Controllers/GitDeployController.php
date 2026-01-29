<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GitDeployController extends Controller
{
    public function deploy(Request $request)
    {
        $secret = 'I22r01i20s24'; 
        
        $signature = $request->header('X-Hub-Signature-256');

        $payload = $request->getContent();
        $hash = 'sha256=' . hash_hmac('sha256', $payload, $secret);

        if (hash_equals($hash, $signature)) {
            $output = shell_exec('cd /home4/intran23/almacen.intranetdrg.com.mx && git pull origin master 2>&1');
            
            Log::info("Git Pull automático: " . $output);
            
            return response()->json(['status' => 'success', 'output' => $output], 200);
        }

        Log::warning("Intento de Webhook no autorizado.");
        return response()->json(['status' => 'invalid signature'], 403);
    }
}
