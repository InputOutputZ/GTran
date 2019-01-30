<?php

namespace GoogleTran\Translate;

use Illuminate\Http\Request;

use GoogleTran;

class PlayWithAPIController 
{

    public function translateText(Request $request){
        $result = GoogleTran::translateText($request->text,$request->target,$request->source,$request->format,$request->model);
        if (($request->ajax() && !$request->pjax()) || $request->wantsJson() || $request->js) {
            return response()->json($result,200);
        } else {
            return $result;
        }
    }

  public function detectText(Request $request){
        $result = GoogleTran::detectTextInformation($request->text);
        if (($request->ajax() && !$request->pjax()) || $request->wantsJson() || $request->js) {
            return response()->json($result,200);
        } else {
            return $result;
        }
    }

    public function translationAvailable(Request $request){
        $result = GoogleTran::translationsAvailable($request->model,$request->locale);
        if (($request->ajax() && !$request->pjax()) || $request->wantsJson() || $request->js) {
            return response()->json($result,200);
        } else {
            return $result;
        }
    }
}
