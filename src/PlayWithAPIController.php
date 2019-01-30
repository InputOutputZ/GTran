<?php

namespace GoogleTran\Translate;

use Illuminate\Http\Request;

use GoogleTran;

class PlayWithAPIController 
{

    public function translateText(Request $request){
        $result = AzureTran::translateText($request->query,$request->target,$request->source,$request->format,$request->model);
        if (($request->ajax() && !$request->pjax()) || $request->wantsJson() || $request->js) {
            return response()->json($result,200);
        } else {
            return $result;
        }
    }

  public function detectText(Request $request){
        $result = AzureTran::detectTextInformation($request->query);
        if (($request->ajax() && !$request->pjax()) || $request->wantsJson() || $request->js) {
            return response()->json($result,200);
        } else {
            return $result;
        }
    }

    public function translationAvailable(Request $request){
        $result = AzureTran::translationsAvailable($request->model,$request->locale);
        if (($request->ajax() && !$request->pjax()) || $request->wantsJson() || $request->js) {
            return response()->json($result,200);
        } else {
            return $result;
        }
    }
}
