<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\reg_user;
use Illuminate\Http\Request;

class regUsercontroller extends Controller
{

public function index()
{
    #return response()->json(reg_user::all(), 200);
    return response()->json(reg_user::paginate(10), 200);
}


public function store(Request $request)
{
   $validatedData = $request->validate([
    'profile_pic' => 'mimes:jpeg,png,jpg,gif,svg|max:1000',
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users,email',
    'password' => ['required', 'string', 'min:4'],
    'designation' => 'required|string',
    'address' => 'required|string',
    'department_name' => 'required|string',
    'otithee_joining_date' => 'required|date',
    'blood_group' => 'required|string',
    'nationality_country' => 'required|string',
    'DOB' => 'required|date',
    'pay_frequency' => 'required|string',
    'bonus_information' => 'required|string',
    'extra_benefits' => 'required|string',
    'curriculum_vita_cv' => 'required|mimetypes:application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document|max:10240',
    'degree_information.*' => 'required|string',
    'degree.*' => 'required|string',
    'joining_year.*' => 'required|date',
    'passing_year.*' => 'required|date',
    'nid_Information' => 'required|string',
    'gender' => 'required|string',
    'phoneCountry' => 'required|string',
    'phone_number' => 'required|string|unique:users,phone_number',
]);


  $product = reg_user::create($validatedData);
  return response()->json($product, 201);
}



public function show(string $id)
{
    $product = Product::find($id);

    if ($product) {
        return response()->json($product, 200);
    } else {

   return response()->json(['message' => 'Product not found'], 404);
}
}



public function update(Request $request, Product $product)
{
    $validatedData = $request->validate([
      'name' => 'required|max:255',
      'description' => 'required',
      'price' => 'required|numeric',
]);

if ($product) {
$product->update($validatedData);
   return response()->json($product, 200);

} else {

  return response()->json(['message' => 'Product not found'], 404);
}
}




public function destroy(Product $product)
{
  
  if ($product) {
  $product->delete();

  return response()->json(null, 204);
} else {

  return response()->json(['message' => 'Product not found'], 404);
}
}
}