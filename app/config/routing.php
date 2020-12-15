<?php

use Controller\MainController;
use Controller\OrderCheckoutController;
use Controller\OrderInfoController;
use Controller\ProductDescriptionController;
use Controller\ProductInfoController;
use Controller\ProductListController;
use Controller\ProductSNController;
use Controller\UserAccountController;
use Controller\UserASController;
use Controller\UserAuthenticationController;
use Controller\UserListController;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$routes = new RouteCollection();

$routes->add(
    'index',
    new Route('/', ['_controller' => [MainController::class, 'indexAction']])
);

$routes->add(
    'product_list',
    new Route('/product/list', ['_controller' => [ProductListController::class, 'listAction']])
);

$routes->add(
    'description',
    new Route('/product/description', ['_controller' => [ProductDescriptionController::class, 'listDescription']])
);

$routes->add(
    'product_info',
    new Route('/product/info/{id}', ['_controller' => [ProductInfoController::class, 'infoAction']])
);
$routes->add(
    'product_into_social_network',
    new Route('/product/social/{network}', ['_controller' => [ProductSNController::class, 'postAction']])
);

$routes->add(
    'order_info',
    new Route('/order/info', ['_controller' => [OrderInfoController::class, 'infoAction']])
);
$routes->add(
    'order_checkout',
    new Route('/order/checkout', ['_controller' => [OrderCheckoutController::class, 'checkoutAction']])
);
$routes->add(
    'users_list',
    new Route('/user/list', ['_controller' => [UserListController::class, 'usersList']])
);
$routes->add(
    'user_authentication',
    new Route('/user/authentication', ['_controller' => [UserAuthenticationController::class, 'authenticationAction']])
);
$routes->add(
    'logout',
    new Route('/user/logout', ['_controller' => [UserASController::class, 'logoutAction']])
);
$routes->add(
    'account',
    new Route('/user/account', ['_controller' => [UserAccountController::class, 'userAccount']])
);
$routes->add(
    'product_into_social_network',
    new Route('/product/social', ['_controller' => [ProductSNController::class, 'publish']])
);
return $routes;
