<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\Product;
  
class ProductController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */

     public function productAddForm(){
         return view('productsForm');
     }

     public function product_add_db(Request $request){

        $Img=$request->file('image');
        if($Img){
            $currentTimeinSeconds = time();  
            $imageName =  $currentTimeinSeconds.'.'.$Img->getClientOriginalName();
            $directory = 'images/';
            $imageUrl = $directory.$imageName;
            $Img->move($directory, $imageName);
        }else{
            $imageUrl="null";
        }
       $product=new Product();
       $product->name=$request->name;
       $product->description=$request->description;
       $product->image=$imageUrl;
       $product->price=$request->price;
       $product->save();
       return Product::all();
     }


    public function index()
    {
        $products = Product::all();
        return view('products', compact('products'));
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function cart()
    {
        return view('cart');
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
          
        $cart = session()->get('cart', []);
  
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }
          
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }
}