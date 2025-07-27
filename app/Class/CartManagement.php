<?php

namespace App\Class;

use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use function collect;

class CartManagement
{
    /**
     * Add item to cart
     * @param int $product_id
     * @param int $quantity
     * @return int
     */
    public static function addItemToCart(int $product_id, int $quantity = 1): int
    {
        Log::info("Product_id #{$product_id}, Quantity #{$quantity} added");
        $cart_items = self::getCartItemsFromCookie();
        $product_key = (new CartManagement)->getItemIndex($cart_items, $product_id);
        if ($product_key !== false) {
            $cart_items[$product_key]['quantity'] = $quantity;
            $cart_items[$product_key]['total_price'] = $cart_items[$product_key]['quantity'] * $cart_items[$product_key]['unite_price'];
        } else {
            $product = Product::active()->where('id', $product_id)->first(['id', 'name', 'price', 'images']);
            if ($product) {
                $cart_items[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'image' => $product->images[0] ?? null,
                    'unite_price' => $product->price,
                    'quantity' => $quantity,
                    'total_price' => $product->price,
                ];
            }
        }

        self::addItemsToCookies($cart_items);
        return count($cart_items);
    }

    /**
     * Remove item from cart
     * @param int $product_id
     * @return array
     */
    public static function removeItemFromCart(int $product_id): array
    {
        $cart_items = self::getCartItemsFromCookie();
        $product_key = (new CartManagement)->getItemIndex($cart_items, $product_id);
        if ($product_key !== false) {
            $cart_items = Arr::except($cart_items, $product_key);
        }
        self::addItemsToCookies($cart_items);
        return $cart_items;
    }


    /**
     * Add cart items to cookies
     * @param array $cart_items
     * @return void
     */
    public static function addItemsToCookies(array $cart_items): void
    {
        Cookie::queue('cart_items', json_encode($cart_items), 60 * 24 * 30);
    }

    /**
     * Clear cart items from cookies
     * @return void
     */
    public static function clearItemsFromCookies(): void
    {
        Cookie::queue(Cookie::forget('cart_items'));
    }

    /**
     * Get cart items from cookie
     * @return array
     */
    public static function getCartItemsFromCookie(): array
    {
        $cart_items = json_decode(Cookie::get('cart_items'), true);
        if (!$cart_items) return [];
        return $cart_items;
    }

    /**
     * Increase cart item quantity
     * @param int $product_id
     * @return array
     */
    public static function incrementQuantityToCartItem(int $product_id): array
    {
        $cart_items = self::getCartItemsFromCookie();
        $product_key = (new CartManagement)->getItemIndex($cart_items, $product_id);
        if ($product_key !== false) {
            $cart_items[$product_key]['quantity']++;
            $cart_items[$product_key]['total_price'] = $cart_items[$product_key]['quantity'] * $cart_items[$product_key]['unite_price'];
        }
        self::addItemsToCookies($cart_items);
        return $cart_items;
    }

    /**
     * Decrease cart item quantity
     * @param int $product_id
     * @return array
     */
    public static function decrementQuantityToCartItem(int $product_id): array
    {
        $cart_items = self::getCartItemsFromCookie();
        $product_key = (new CartManagement)->getItemIndex($cart_items, $product_id);
        if ($product_key !== false) {
            if ($cart_items[$product_key]['quantity'] > 1) {
                $cart_items[$product_key]['quantity']--;
                $cart_items[$product_key]['total_price'] = $cart_items[$product_key]['quantity'] * $cart_items[$product_key]['unite_price'];
            } else {
                $cart_items = Arr::except($cart_items, $product_key);
            }
        }
        self::addItemsToCookies($cart_items);
        return $cart_items;
    }

    /**
     * Grand total for cart items
     * @param array $cart_items
     * @return int
     */
    public static function cartItemGrandTotal(array $cart_items): int
    {
        return collect($cart_items)->sum('total_price');
    }

    /**
     * Get index of product_id
     * @param array $cart_items
     * @param int $product_id
     * @return int|false
     */
    private function getItemIndex(array $cart_items, int $product_id): int|false
    {
        return collect($cart_items)->search(fn($item) => $item['product_id'] == $product_id);
    }

    /**
     * Get item from cart
     * @param int $product_id
     * @return array
     */
    public static function getCartItem(int $product_id): array
    {
        $cart_items = self::getCartItemsFromCookie();
        $product_key = (new CartManagement)->getItemIndex($cart_items, $product_id);
        return $product_key !== false ? $cart_items[$product_key] : [];
    }

    /**
     * Check if item exist or not
     * @param int $product_id
     * @return bool
     */
    public static function checkItemExists(int $product_id): bool
    {
        $cart_items = self::getCartItemsFromCookie();
        $product_key = (new CartManagement)->getItemIndex($cart_items, $product_id);
        return $product_key !== false;
    }
}
