<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class CartRepository extends BaseRepository {
    /**
     * Constructor.
     *
     * @param Cart $cart
     */
    public function __construct(Cart $cart) {
        parent::__construct($cart);
        $this->model = $cart;
    }

    /**
     * @param array $data
     *
     * @return Cart
     */
    public function createCart(array $data = null): Cart {
        return $this->create($data);
    }

    /**
     * @param int $id
     *
     * @return Cart
     * @throws CartNotFoundErrorException
     */
    public function findCartById(int $id): Cart {
        return $this->findOneOrFail($id);
    }

    /**
     * @param array $data
     *
     * @return bool
     * @throws UpdateCartErrorException
     */
    public function updateCart(array $data): bool {
        return $this->update($data);
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteCart(): bool {
        return $this->model->delete();
    }

    /**
     * @param array  $columns
     * @param string $orderBy
     * @param string $sortBy
     *
     * @return Collection
     */
    public function listCarts($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'): Collection {
        return $this->all($columns, $orderBy, $sortBy);
    }

    /**
     * @return Collection
     */
    public function listProducts(): Collection {
        return $this->model->products()->get();
    }

    /**
     * @param Product $product
     */
    public function saveProduct(Product $product) {
        $this->model->products()->save($product);
    }

    /**
     * Dissociate the products
     */
    public function dissociateProducts() {
        $this->model->products()->each(function (Product $product) {
            $product->brand_id = null;
            $product->save();
        });
    }

    public function getSessionCart() {
        $cartId = Cookie::get('cart_id');
        //$cartId = Session::get('cart_id');
        if (!$cartId) {
            return null;
        }
        $cart = Cart::find($cartId);
        return $cart;
    }

    public function setSessionCart($id = null) {
        if($id) Cookie::queue('cart_id', $id, 1000000);
        else Cookie::queue('cart_id', $this->model->id, 1000000);
        //Session::put('cart_id', $cart->id);
    }

    public function getOrCreateSessionCart() {
        $cart = $this->getSessionCart();
        if (!$cart) {
            $cart = $this->createCart(['customer_id' => null]);
            $this->setSessionCart($cart->id);
        }
        return $cart;
    }

    public function getLoggedInUserCart() {
        $id = auth()->id();
        if(!$id) {
            return null;
        }
        $cart = Cart::where('customer_id', $id)->orderBy('updated_at', 'desc')->first();
        return $cart;
    }

    public function getOrCreateLoggedInUserCart() {
        $cart = $this->getLoggedInUserCart();
        if (!$cart) {
            $cart = $this->createCart([
                'customer_id' => auth()->id()
            ]);
        }
        return $cart;
    }

    public function getUserCart() {
        if (!auth()->check()) {
            $cart = $this->getOrCreateSessionCart();
        } else {
            $cart = $this->getOrCreateLoggedInUserCart();
        }
        return $cart;
    }

    public function updateProduct($product_id, $qty): bool {
        $product = Product::find($product_id);
        $item = $this->model->items
            ->where('product_id', '==', $product->id)
            ->first();
        if ($item) { // If item already present in the cart
            if ($qty == 0) return false;
            else $item->update([
                'product_name' => $product->name,
                'price' => $product->price,
                'qty' => $item->qty + $qty
            ]);
        } else { // If item not present in the cart
            if ($qty != 0) $this->model->items()->create([
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'qty' => $qty
            ]);
        }
        return true;
    }

    public function updateProducts($products): bool {
        foreach ($products as $product_id => $qty) {
            $product = Product::find($product_id);
            $item = $this->model->items->where('product_id', '==', $product->id)->first();
            if ($item) {
                if ($qty == 0) $item->delete();
                else $item->update([
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'qty' => $qty
                ]);
            } else {
                if ($qty != 0) $this->model->items()->create([
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'qty' => $qty
                ]);
            }
        }
        return true;
    }

    public function emptyCart($id = null) {
        if($id) {
            $cart = $this->findCartById($id);
        } else {
            $cart = $this->getUserCart();
        }
        $cart->items()->delete();
    }
}
