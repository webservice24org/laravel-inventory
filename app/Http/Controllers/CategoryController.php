<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\TryCatch;

class CategoryController extends Controller
{
    public function categoryList(Request $request)
    {
        try {
            $user_id = Auth::id(); // Using Auth::id() to get the authenticated user's ID
            $rows = Category::where("user_id", $user_id)->get();

            return response()->json(['status' => 'Success', 'rows' => $rows], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'Fail', 'message' => $e->getMessage()], 200);
        }
    }

    function createCategory(Request $request){
        try {
            $request->validate([
                'name' => 'required|string|min:2|max:50'
            ]);
            $user_id = Auth::id();
            
                Category::create([
                    'name'=>$request->input('name'),
                    'user_id'=>$user_id
                ]);
            return response()->json(['status'=>'Success', 'message'=>'Category Name Created Successfully!'],200);
        } catch (Exception $e) {
            return response()->json(['status'=>'Fail', 'message'=>$e->getMessage()],200);
        }
    }

    function updateCategory(Request $request){
        try {
            
            $request->validate([
                'id'=>'required',
                'name' => 'required|string|min:2|max:50'
            ]);
            $category_id = $request->id;
            $user_id = Auth::id();
            Category::where('id',$category_id)
            ->where('user_id',$user_id)
            ->update([
                'name'=>$request->input('name')
            ]);

            return response()->json(['status'=>'Success', 'message'=>'Category Name Updated Successfully']);
        } catch (Exception $e) {
            return response()->json(['status'=>'Fail', 'message'=>$e->getMessage()]);
        }
    }

    function deleteCategory(Request $request){
        try { 
            $request->validate([
                'id'=> 'required|min:1'
            ]);
            $category_id = $request->input('id');
            $user_id = Auth::id();
            Category::where('id',$category_id)->where('user_id',$user_id)->delete();
            return response()->json(['status'=> 'Success', 'message'=> 'Category Deleted Successfully'],200);
         } 
        catch (Exception $e) {
            return response()->json(['status'=> 'Fail', 'message'=>$e->getMessage()],200);
        }
    }

    public function CategoryById(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|min:1',
            ]);

            $category_id = $request->input('id');
            $user_id = Auth::id();

            $category = Category::where('id', $category_id)
                ->where('user_id', $user_id)
                ->first();

            if (!$category) {
                return response()->json(['status' => 'fail', 'message' => 'Category not found or unauthorized'], 404);
            }

            return response()->json(['status' => 'success', 'category' => $category]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 200);
        }
    }
}
