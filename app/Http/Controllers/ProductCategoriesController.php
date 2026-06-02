<?php

namespace App\Http\Controllers;

use App\Models\ProductCategories;
use Exception;
use Illuminate\Http\Request;
use Validator;

class ProductCategoriesController extends Controller
{
    public function index()
    {
        try {
            $categories = ProductCategories::getCategories();
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
            $category = ProductCategories::getCategoryById($category_id);
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
