**Домашняя работа 3. Теоретическая часть**
1. Какие принципы нарушены в проекте? Укажите конкретные файлы и объясните почему 
2. Где в проекте уместно избавиться от магических чисел и нарушен «Закон Деметры»? Напишите почему  

**Ответы:** 
1. Routing.php - название всех методов  add нарушает принцип Pola
Basket.php - есть магические числа в методе checkoutProcess

2. В проекте много мест где нарушается принцип Деметры (объект вызывает метод своего класса, а методы discount и search уже не пренадлежат своему классу).  
  Например, 
  Класс VipDiscount
  Метод getDiscount
  $discount = $this->find($this->user)->discount();

  Класс Basket
  Метод getProductsInfo
  $this->getProductRepository()->search($productIds);

  Класс Product
  Метод getInfo
  $product = $this->getProductRepository()->search([$id]);

  Класс Security,
  Методе authentication
  $user = $this->getUserRepository()->getByLogin($login);

  В классе Basket 
  Метод checkout() используется корректно
  $billing = new Card();
  $discount = new NullObject();
  $communication = new Email();
  $security = new Security($this->session);
  $this->checkoutProcess($discount, $billing, $security, $communication); - правильно передаются параметры в другой метод(метод checkoutProcess).

