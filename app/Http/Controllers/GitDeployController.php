<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GitDeployController extends Controller
{
    public function deploy(Request $request)
    {
        // 1. Definir una clave secreta (Cámbiala por algo seguro)
        $secret = 'TuClaveSecreta123'; 
        
        // 2. Obtener la firma que envía GitHub
        $signature = $request->header('X-Hub-Signature-256');

        // 3. Verificar que la petición sea realmente de GitHub
        $payload = $request->getContent();
        $hash = 'sha256=' . hash_hmac('sha256', $payload, $secret);

        if (hash_equals($hash, $signature)) {
            // 4. Ejecutar el comando de actualización en el servidor
            // Ajustamos a tu ruta: /home/intran23/almacen.intranetdrg.com.mx
            $output = shell_exec('cd /home/intran23/almacen.intranetdrg.com.mx && git pull origin master 2>&1');
            
            // Guardamos el resultado en el log de Laravel por si algo falla
            Log::info("Git Pull automático: " . $output);
            
            return response()->json(['status' => 'success', 'output' => $output], 200);
        }

        Log::warning("Intento de Webhook no autorizado.");
        return response()->json(['status' => 'invalid signature'], 403);
    }
}
