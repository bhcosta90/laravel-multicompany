<?php

namespace Modules\Integration\Traits\Http\Api;

use Illuminate\Http\Request;
use Modules\Integration\Exception\CustomException;

trait StoreController {
    
    protected abstract function rulesPost();
    
    protected abstract function resource();

    protected abstract function repository();

    public function store(Request $request)
    {
        $data = $request->validate($this->rulesPost());
        
        $objRepository = app($this->repository());
        $objResource = $this->resource();

        try{
            $obj = $objRepository->create($data);
            $obj->refresh();
        }catch(CustomException $e){
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
        
        return new $objResource($obj);
    }
}