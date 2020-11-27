<?php

namespace Modules\Integration\Traits\Http\Api;

use Modules\Integration\Exception\CustomException;

trait DestroyController {
    
    protected abstract function repository();

    public function destroy($id)
    {
        $objRepository = app($this->repository());
        try{
            $objRepository->delete($id);
            return response()->noContent();
        }catch(CustomException $e){
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}