<?php

namespace App\Http\Controllers;

use App\Models\LinhaLog;
use App\Models\Log;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function store(Request $request)
    {
        $log = Log::where('data', date('Y-m-d'))->first();
        if (empty($log)) {
            $log = Log::create(['data' => date('Y-m-d')]);
        }

        $linhasErro = $request->input('errors');
        foreach ($linhasErro as $linha) {
            if (!empty($linha)) {
                LinhaLog::create(['log_id' => $log->id, 'error_text' => $linha]);
            }
        }

        return response()->json(['message' => 'Linhas de erro armazenadas com sucesso.'], 200);
    }

    public function destroy(Request $request)
    {

        $data = $request->route('data');
        $log = Log::where('data', $data)->first();

        if (!empty($log)) {
            $log->delete();
        }

        return response()->json(['message' => 'Linhas Removidas com sucesso.'], 200);
    }

    public function removeLinhaLogs(Request $request)
    {

        $data = $request->route('data');
        $log = Log::where('data', $data)->first();

        if (!empty($log)) {
            LinhaLog::where('log_id', $log->id)->delete();
        }

        return response()->json(['message' => 'Linhas Removidas com sucesso.'], 200);
    }
}
