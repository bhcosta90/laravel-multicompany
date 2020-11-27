<?php

namespace Modules\Integration\Traits\Http\Api;

use Illuminate\Http\Request;
use Modules\Integration\Exception\CustomException;

trait UpdateController {
    
    protected abstract function rulesPut();
    
    protected abstract function resource();

    protected abstract function repository();

    public function update(Request $request, $id)
    {
        $data = $request->validate($this->rulesPut());
        
        $objRepository = app($this->repository());
        $objResource = $this->resource();

        try {
            $obj = $objRepository->update($id, $data);
            $obj->refresh();
        } catch(CustomException $e){
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
        
        return new $objResource($obj);
    }
}