<?php

namespace App\Http\Controllers;

use App\Jobs\ProductLiked;
use App\Models\Product;
use App\Models\ProductUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * call internal http request to admin api
     * POST http://0.0.0.0:8081/api/products/1/like call from admin app
     * return api/user call from admin app
     * @param $id
     * @param Request $request
     * @return array|mixed
     */
    public function like($id, Request $request) {
//        return Http::get('http://0.0.0.0/api/user')->json();

        $userID = Http::get('http://host.docker.internal/api/user')->json();

        try {
            $productUser = ProductUser::create([
                'user_id' => $userID,
                'product_id' => $id
            ]);

//            ProductLiked::dispatch($productUser->toArray());
            ProductLiked::dispatch($productUser->toArray())->onQueue('main_queue');
            return response(['message' => 'success'], Response::HTTP_CREATED);

        } catch (\Exception $exception){
            return response(['error' => 'you already liked'], Response::HTTP_BAD_REQUEST);
        }

    }
}
