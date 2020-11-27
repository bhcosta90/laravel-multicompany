<?php

namespace Modules\Central\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Central\Repository\Contracts\CompanyContract;
use Modules\Central\Transformers\CompanyResource;
use Modules\Integration\Traits\Http\Api\{
    DestroyController,
    ShowController,
    StoreController
};

class CompanyController extends Controller
{
    use StoreController, ShowController, DestroyController;

    private $rules = [];

    public function __construct(Request $request)
    {
        $id = null;

        $arrayPoints = collect(explode('.', $request->input('domain')));
        $validationDomain = $arrayPoints->count() > 1 ? "url" : "string";

        $this->rules = [
            'name' => ['required', 'max:191', 'min:5'],
            'document' => ['required', 'min:8', 'max:30'],
            'domain' => ['required', $validationDomain, 'min:3', "unique:companies,domain,{$id},id,deleted_at,NULL"],
            'user.name' => 'required|string|max:255',
            'user.email' => 'required|string|email|max:255',
            'user.password' => 'required|string|min:8',
        ];
    }

    protected function rulesPost()
    {
        return $this->rules;
    }

    protected function resource()
    {
        return CompanyResource::class;
    }

    protected function repository()
    {
        return CompanyContract::class;
    }
}
