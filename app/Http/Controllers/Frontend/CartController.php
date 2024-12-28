<?php

namespace App\Http\Controllers\Frontend;

use Log;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\ShippingMethod;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{

    public function addToCart(Request $request, $id)
    {
        try {
            // Find the product or fail
            $product = Product::findOrFail($id);
            $quantity = $request->input('quantity', 1); // Default to 1 if no quantity is provided

            if (!empty($product->box_price) || !empty($product->box_discount_price)) {
                Cart::instance('cart')->add([
                    'id' => $product->id,
                    'name' => $product->name,
                    'qty' => $quantity,
                    'price' => !empty($product->box_discount_price) ? $product->box_discount_price : $product->box_price,
                ])->associate('App\Models\Product');

                // Get the updated cart content
                $data = [
                    'cartItems' => Cart::instance('cart')->content(),
                    'total'     => Cart::instance('cart')->total(),
                    'cartCount' => Cart::instance('cart')->count(),
                    'subTotal'  => Cart::instance('cart')->subtotal(),
                ];

                // Return the JSON response with cart data
                return response()->json([
                    'success' => 'Successfully added to your cart.',
                    'cartCount' => $data['cartCount'],
                    'cartHeader' => view('frontend.pages.cart.partials.minicart', $data)->render(),
                ]);
            } else {
                return response()->json([
                    'error' => 'Failed to add this product to your cart. Contact our support team.'
                ], 500);
            }
        } catch (\Exception $e) {
            // Return an error response if something goes wrong
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }



    public function wishListStore(Request $request, $id)
    {
        try {
            // Check if user is authenticated
            if (!Auth::check()) {
                return response()->json([
                    'error' => 'Log in first to add product to your wishlist.'
                ]); // Use 401 Unauthorized status code for unauthenticated users
            }

            $user = Auth::user();
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'error' => 'Product not found.'
                ]); // Use 404 Not Found status code for non-existent products
            }

            // Check if the product is already in the user's wishlist
            $wishlistExists = Wishlist::where('product_id', $id)
                ->where('user_id', $user->id)
                ->exists();

            if ($wishlistExists) {
                return response()->json([
                    'error' => 'The Product is already in your wishlist.'
                ]); // Use 400 Bad Request status code for conflicts
            }

            // Add the product to the wishlist
            Wishlist::create([
                'product_id' => $id,
                'user_id' => $user->id,
            ]);

            $wishlistCount = Wishlist::where('user_id', $user->id)->count();

            return response()->json([
                'success' => 'Successfully added to your wishlist.',
                'wishlistCount' => $wishlistCount,
            ], 200); // Use 200 OK status code for successful operations

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage(),
            ], 500); // Use 500 Internal Server Error status code for unexpected errors
        }
    }


    public function removeFromCart(Request $request)
    {
        $rowId = $request->input('rowId');

        if ($rowId) {
            // Assuming you're using Hardevine Cart
            Cart::instance('cart')->remove($rowId);

            $data = [
                'cartItems' => Cart::instance('cart')->content(),
                'total'     => Cart::instance('cart')->total(),
                'cartCount' => Cart::instance('cart')->count(),
                'subTotal'  => Cart::instance('cart')->subtotal(),
            ];
            return response()->json([
                'success' => 'Cart Item removed Successfully.',
                'cartCount' => $data['cartCount'],
                'cartHeader' => view('frontend.pages.cart.partials.minicart', $data)->render(),
                'cartTable' => view('frontend.pages.cart.partials.cartTable', $data)->render(),
            ]);
        }

        return response()->json(['error' => 'Unable to remove item.'], 400);
    }
    public function checkoutStore(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'billing_email' => 'required|email',
            'billing_first_name' => 'required|string|max:255',
            'billing_last_name' => 'required|string|max:255',
            'billing_address_1' => 'required|string|max:255',
            'billing_state' => 'required|string|max:255',
            'billing_postcode' => 'required|string|max:20',
            'billing_phone' => 'required|string|max:20',
            'shipping_first_name' => 'nullable|string|max:255',
            'shipping_last_name' => 'nullable|string|max:255',
            'shipping_address_1' => 'nullable|string|max:255',
            'shipping_state' => 'nullable|string|max:255',
            'shipping_postcode' => 'nullable|string|max:20',
            'shipping_phone' => 'nullable|string|max:20',
            'order_note' => 'nullable|string',
            'payment_method' => 'required|in:cod,stripe,paypal',
            'sub_total' => 'required',
            'total_amount' => 'required|numeric|min:0',
            'shipping_id' => 'required|exists:shipping_methods,id'
        ], [
            'billing_email.required' => 'The billing email is required.',
            'billing_email.email' => 'The billing email must be a valid email address.',
            'billing_first_name.required' => 'The billing first name is required.',
            'billing_first_name.string' => 'The billing first name must be a string.',
            'billing_first_name.max' => 'The billing first name may not be greater than 255 characters.',
            'billing_last_name.required' => 'The billing last name is required.',
            'billing_last_name.string' => 'The billing last name must be a string.',
            'billing_last_name.max' => 'The billing last name may not be greater than 255 characters.',
            'billing_address_1.required' => 'The billing address is required.',
            'billing_address_1.string' => 'The billing address must be a string.',
            'billing_address_1.max' => 'The billing address may not be greater than 255 characters.',
            'billing_state.required' => 'The billing state is required.',
            'billing_state.string' => 'The billing state must be a string.',
            'billing_state.max' => 'The billing state may not be greater than 255 characters.',
            'billing_postcode.required' => 'The billing postcode is required.',
            'billing_postcode.string' => 'The billing postcode must be a string.',
            'billing_postcode.max' => 'The billing postcode may not be greater than 20 characters.',
            'billing_phone.required' => 'The billing phone number is required.',
            'billing_phone.string' => 'The billing phone number must be a string.',
            'billing_phone.max' => 'The billing phone number may not be greater than 20 characters.',
            'shipping_first_name.string' => 'The shipping first name must be a string.',
            'shipping_first_name.max' => 'The shipping first name may not be greater than 255 characters.',
            'shipping_last_name.string' => 'The shipping last name must be a string.',
            'shipping_last_name.max' => 'The shipping last name may not be greater than 255 characters.',
            'shipping_address_1.string' => 'The shipping address must be a string.',
            'shipping_address_1.max' => 'The shipping address may not be greater than 255 characters.',
            'shipping_state.string' => 'The shipping state must be a string.',
            'shipping_state.max' => 'The shipping state may not be greater than 255 characters.',
            'shipping_postcode.string' => 'The shipping postcode must be a string.',
            'shipping_postcode.max' => 'The shipping postcode may not be greater than 20 characters.',
            'shipping_phone.string' => 'The shipping phone number must be a string.',
            'shipping_phone.max' => 'The shipping phone number may not be greater than 20 characters.',
            'order_note.string' => 'The order note must be a string.',
            'payment_method.required' => 'The payment method is required.',
            'payment_method.in' => 'The selected payment method is invalid.',
            'total_amount.required' => 'The total amount is required.',
            'total_amount.numeric' => 'The total amount must be a number.',
            'total_amount.min' => 'The total amount must be at least 0.',
            'shipping_id.required' => 'The shipping method is required.',
            'shipping_id.exists' => 'The selected shipping method does not exist.',
        ]);


        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                // Session::flash('error', $message);
                flash()->error($message);
            }
            return redirect()->back()->withInput();
        }

        // Begin a database transaction
        DB::beginTransaction();

        try {
            $typePrefix = 'PQ';
            $year = date('Y'); // Get the last two digits of the year (e.g., '24' for 2024)

            // Find the most recent code for the given type and year
            $lastCode = Order::where('order_number', 'like', $typePrefix . '-' . $year . '%')
                ->orderBy('id', 'desc')
                ->first();

            // Extract and increment the last number or start at 1 if none exists
            $newNumber = $lastCode ? (int) substr($lastCode->order_number, strlen($typePrefix . '-' . $year)) + 1 : 1;

            // Construct the new code
            $code = $typePrefix . '-' . $year . $newNumber;
            // Create the order

            $billingAddress = $request->input('billing_address_1') . ', ' . $request->input('billing_address_2');
            $shippingAddress = !empty($request->input('shipping_address')) ? $request->input('shipping_address') : $billingAddress;


            $order = Order::create([
                'order_number'                 => $code, // Generate a unique order number
                'user_id'                      => auth()->id(), // Assuming user is logged in
                'shipping_method_id'           => $request->input('shipping_id'),
                'sub_total'                    => $request->input('sub_total'), // Use Cart instance
                'coupon'                       => $request->input('coupon', 0),
                'discount'                     => $request->input('discount', 0),
                'total_amount'                 => $request->input('total_amount'),
                'quantity'                     => Cart::instance('cart')->count(), // Total quantity of items in cart
                'shipping_charge'              => ShippingMethod::find($request->input('shipping_id'))->price,
                'payment_method'               => $request->input('payment_method'),
                'payment_status'               => 'unpaid',
                'status'                       => 'pending',
                'shipped_to_different_address' => $request->has('ship-address') ? 'yes' : 'no',
                'billing_first_name'           => $request->input('billing_first_name'),
                'billing_last_name'            => $request->input('billing_last_name'),
                'billing_email'                => $request->input('billing_email'),
                'billing_phone'                => $request->input('billing_phone'),
                'billing_address'              => $billingAddress,
                'billing_zipcode'              => $request->input('billing_postcode'),
                'billing_state'                => $request->input('billing_state'),
                'billing_country'              => $request->input('billing_country', 'UK'),
                'shipping_first_name'          => $request->input('shipping_first_name', $request->input('billing_first_name')),
                'shipping_last_name'           => $request->input('shipping_last_name', $request->input('billing_last_name')),
                'shipping_email'               => $request->input('shipping_email', $request->input('billing_email')),
                'shipping_phone'               => $request->input('shipping_phone', $request->input('billing_phone')),
                'shipping_address'             => $shippingAddress,
                'shipping_zipcode'             => $request->input('shipping_postcode', $request->input('billing_postcode')),
                'shipping_state'               => $request->input('shipping_state', $request->input('billing_state')),
                'shipping_country'             => $request->input('shipping_country', $request->input('billing_country')),
                'order_note'                   => $request->input('order_note'),
                'created_by'                   => auth()->id(),
                'order_created_at'             => Carbon::now(),
                'created_at'                   => Carbon::now(),
            ]);

            // Add items to order_items table
            foreach (Cart::instance('cart')->content() as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->id,
                    'user_id' => auth()->id(),
                    'product_name' => $item->name,
                    'product_color' => $item->model->color ?? null,
                    'product_sku' => $item->model->sku ?? null,
                    'price' => $item->price,
                    'tax' => $item->tax ?? 0,
                    'quantity' => $item->qty,
                    'subtotal' => $item->qty * $item->price,
                ]);

                // Update product stock
                $product = Product::find($item->id);
                $product->update([
                    'box_stock' => $product->box_stock - $item->qty,
                ]);
            }

            // Commit the transaction
            DB::commit();

            // Clear the cart after successful order
            Cart::instance('cart')->destroy();
            $data = [
                'order' => Order::with('orderItems')->where('id', $order->id)->first(),
                'user'  => Auth::user(),
            ];
            // dd($data['order']);
            // return view('pdf.invoice', $data);
            // Generate and save PDF
            $pdf = Pdf::loadView('pdf.invoice', $data);
            $pdfPath = storage_path('app/public/order/' . $order->order_number . '_invoice.pdf');

            // Ensure the directory exists
            $directory = dirname($pdfPath);
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            try {
                $pdf->save($pdfPath);
                $order->update([
                    'invoice' => 'order/' . $order->order_number . '_invoice.pdf',
                ]);
            } catch (\Exception $e) {
                // Handle PDF save exception
                flash()->error('Failed to generate PDF: ' . $e->getMessage());
                // Session::flash('error', 'Failed to generate PDF: ' . $e->getMessage());
            }
            // Redirect to a confirmation page or thank you page
            if ($order->payment_method == "stripe") {
                flash()->success('Order placed successfully!');
                return redirect()->route('stripe.payment', $order->order_number);
            } else if ($order->payment_method == "paypal") {
                return view('frontend.pages.cart.paypal', $data);
            } else {
                flash()->success('Order placed successfully!');
                return redirect()->route('checkout.success', $order->order_number);
            }
        } catch (\Exception $e) {
            DB::rollback();

            Session::flash('error', $e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function wishlistDestroy(string $id)
    {
        Wishlist::findOrFail($id)->delete();
    }

    public function cartDestroy(string $rowId)
    {
        Cart::instance('cart')->remove($rowId);
    }

    public function cartClear()
    {
        Cart::instance('cart')->destroy();
    }

    public function updateCart(Request $request)
    {
        try {
            $items = $request->input('items');
            if (!is_array($items)) {
                throw new \Exception('Invalid data format');
            }

            foreach ($items as $item) {
                $rowId = $item['rowId'];
                $quantity = $item['qty'];
                if (empty($rowId) || !is_numeric($quantity)) {
                    throw new \Exception('Invalid item data');
                }
                Cart::instance('cart')->update($rowId, $quantity);
            }

            return response()->json([
                'success' => 'Cart updated successfully.',
            ], 200);
        } catch (\Exception $e) {
            // \Log::error('Cart update error: ' . $e->getMessage());
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
