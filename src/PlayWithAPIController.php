<?php

namespace GTran\Translate;

use Illuminate\Http\Request;

use GTran;

class PlayWithAPIController 
{

    public function translateText(Request $request){
        $result = GTran::translateText($request->text,$request->target,$request->source,$request->get('format'),$request->model);
        if (($request->ajax() && !$request->pjax()) || $request->wantsJson() || $request->js) {
            return response()->json($result,200);
        } else {
            return $result;
        }
    }

  public function detectText(Request $request){
        $result = GTran::detectTextInformation($request->text);
        if (($request->ajax() && !$request->pjax()) || $request->wantsJson() || $request->js) {
            return response()->json($result,200);
        } else {
            return $result;
        }
    }

    public function translationAvailable(Request $request){
        $result = GTran::translationsAvailable($request->model,$request->get('locale'));
        if (($request->ajax() && !$request->pjax()) || $request->wantsJson() || $request->js) {
            return response()->json($result,200);
        } else {
            return $result;
        }
    }
}
