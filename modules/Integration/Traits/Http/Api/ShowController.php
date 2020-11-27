<?php

namespace Modules\Integration\Traits\Http\Api;

use Modules\Integration\Exception\CustomException;

trait ShowController {
    
    protected abstract function resource();

    protected abstract function repository();

    public function show($id)
    {
        $objRepository = app($this->repository());
        $objResource = $this->resource();

        try{
            $obj = $objRepository->show($id);
        }catch(CustomException $e){
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
        
        return new $objResource($obj);
    }
}