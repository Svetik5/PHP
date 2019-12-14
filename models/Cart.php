<?php


class Cart
{
    public static function addProduct($id)
    {
        $id = intval($id);

        //Пустой массив для товаров в корзине
        $productsInCart = array();

        //Если в корзине уже ест такой товар (они хранятся в сессии)
        if(isset($_SESSION['products'])){
            //то заполним наш массив товарами
            $productsInCart = $_SESSION['products'];
        }

        //Если товар есть в корзине, но был добавлен езе раз, увеличим количество

        if(array_key_exists($id, $productsInCart)){
            $productsInCart[$id]++;
        }else{
            //добавляем новый товар в корзину
            $productsInCart[$id] = 1;
        }
        $_SESSION['products'] = $productsInCart;

        return self::countItems();

    }
    /**
     * Подсчет количества товаров в корзине (в сессии)
     * @return int
     */
    public static function countItems()
    {
        if(isset($_SESSION['products']))
        {
            $count = 0;
            foreach ($_SESSION['products'] as $id=> $quantity){
                $count = $count + $quantity;
            }
            return $count;
        } else {
            return 0;
        }
    }
    public static function getProducts()
    {
        if(isset($_SESSION['products'])){
            return $_SESSION['products'];
        }
        return false;
    }
    public static function getTotalPrice($products)
    {
        $productsInCart = self::getProducts();

        if($productsInCart){
            $total = 0;
            foreach ($products as $item) {
                $total += $item['price'] * $productsInCart[$item['id']];
            }
        }
        return $total;
    }
    public static function clear(){
        if(isset($_SESSION['products'])){
            unset($_SESSION['products']);
        }
    }

}