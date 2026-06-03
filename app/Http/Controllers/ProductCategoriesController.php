<?php

namespace App\Http\Controllers;

use App\Models\ProductCategories;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Validator;

class ProductCategoriesController extends Controller
{
    public function index()
    {
        try {
            $categories = Cache::remember('product_categories', 60 * 5, function () {
                return ProductCategories::getCategories();
            });

            $response = [
                'success' => true,
                'message' => 'Successfully get categories data.',
                'data' => $categories,
            ];

            return response()->json($response, 200);
        } catch (Exception $error) {
            $response = [
                'success' => false,
                'message' => 'Sorry, there error in internal server',
                'data' => null,
                'errors' => $error->getMessage(),
            ];

            return response()->json($response, 500);
        }
    }

    public function show(int $category_id)
    {
        try {
            $category = Cache::remember("product_categories.{$category_id}", 60 * 5, function () use ($category_id) {
                return ProductCategories::getCategoryById($category_id);
            });

            $response = [
                'success' => true,
                'message' => 'Successfully get category data.',
                'data' => $category,
            ];

            return response()->json($response, 200);
        } catch (Exception $error) {
            $response = [
                'success' => false,
                'message' => 'Sorry, there error in internal server',
                'data' => null,
                'errors' => $error->getMessage(),
            ];

            return response()->json($response, 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'category_name' => 'required|string|max:100',
                'category_desc' => 'required|string',
            ]);

            if ($validator->fails()) {
                $response = [
                    'success' => false,
                    'message' => 'Failed to create category data. Data not completed, please check your data.',
                    'data' => null,
                    'errors' => $validator->errors(),
                ];

                return response()->json($response, 400);
            }

            $category = ProductCategories::createCategory($validator->validated());

            Cache::forget('product_categories');
            Cache::put('product_categories', ProductCategories::getCategories(), 60 * 5);

            $response = [
                'success' => true,
                'message' => 'Successfully create category data',
                'data' => $category,
            ];

            return response()->json($response, 201);
        } catch (Exception $error) {
            $response = [
                'success' => false,
                'message' => 'Sorry, there error in internal server',
                'data' => null,
                'errors' => $error->getMessage(),
            ];

            return response()->json($response, 500);
        }
    }

    public function update(Request $request, int $category_id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'category_name' => 'required|string|max:100',
                'category_desc' => 'required|string',
            ]);

            if ($validator->fails()) {
                $response = [
                    'success' => false,
                    'message' => 'Failed to update category data. Data not completed, please check your data.',
                    'data' => null,
                    'errors' => $validator->errors(),
                ];

                return response()->json($response, 400);
            }

            $category = ProductCategories::updateCategory($category_id, $validator->validated());

            Cache::forget('product_categories');
            Cache::forget("product_categories.{$category_id}");
            Cache::put('product_categories', ProductCategories::getCategories(), 60 * 5);
            Cache::put("product_categories.{$category_id}", $category, 60 * 5);

            $response = [
                'success' => true,
                'message' => 'Successfully update category data',
                'data' => $category,
            ];

            return response()->json($response, 200);
        } catch (Exception $error) {
            $response = [
                'success' => false,
                'message' => 'Sorry, there error in internal server',
                'data' => null,
                'errors' => $error->getMessage(),
            ];

            return response()->json($response, 500);
        }
    }

    public function destroy(int $category_id)
    {
        try {
            $category = ProductCategories::deleteCategory($category_id);

            Cache::forget('product_categories');
            Cache::forget("product_categories.{$category_id}");
            Cache::put('product_categories', ProductCategories::getCategories(), 60 * 5);

            $response = [
                'success' => true,
                'message' => 'Successfully delete category data',
                'data' => $category,
            ];

            return response()->json($response, 200);
        } catch (Exception $error) {
            $response = [
                'success' => false,
                'message' => 'Sorry, there error in internal server',
                'data' => null,
                'errors' => $error->getMessage(),
            ];

            return response()->json($response, 500);
        }
    }
}
