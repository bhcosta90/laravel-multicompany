<?php

namespace Modules\Integration\Traits\Http\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Integration\Exception\CustomException;
use ReflectionClass;

trait IndexController {
    
    protected abstract function resource();

    protected abstract function repository();

    public function index(Request $request)
    {
        $objRepository = app($this->repository());

        try{
            $obj = $objRepository->index($request->all());
        }catch(CustomException $e){
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
        
        // return new $objResource($obj);
        
        $resource = $this->resource();
        $resourceCollection = $this->resource();
        if(method_exists($this, 'resourceCollection')) {
            $resourceCollection = $this->resourceCollection();
        }

        $refClass = new ReflectionClass($resourceCollection);

        return $refClass->isSubclassOf(ResourceCollection::class) 
            ? new $resource($obj)
            : $resourceCollection::collection($obj);
    }
}