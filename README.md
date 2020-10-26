# Edfa3ly-Task

This repository is sloves backend chanllenge using laravel-zero framework

## Challenge Description

***Write a program that can price a cart of products, accept multiple products, combine offers, and display a total detailed bill in different currencies (based on user selection).***

Available catalog products and their price in USD:

* T-shirt $10.99
* Pants $14.99
* Jacket $19.99
* Shoes $24.99

The program can handle some special offers, which affect the pricing.

Available offers:

* Shoes are on 10% off.
* Buy two t-shirts and get a jacket half its price.

The program accepts a list of products, outputs the detailed bill of the subtotal, tax, and discounts if applicable, bill can be displayed in various currencies.

*There is a 14% tax (before discounts) applied to all products.*

E.g.:

Adding the following products:

```
T-shirt
T-shirt
Shoes
Jacket
```

Outputs the following bill, the user selected the USD bill:

```
Subtotal: $66.96
Taxes: $9.37
Discounts:
	10% off shoes: -$2.499
	50% off jacket: -$9.995
Total: $63.8404
```

Another, e.g., If none of the offers are eligible, the user selected the EGP bill:

```
T-shirt
Pants
```

Outputs the following bill:

```
Subtotal: 409 e£
Taxes: 57 e£
Total: 467 e£
```

## Problem Solution

Solution based on MVP (Model, View, Presenter) architecture as in cli user interact with cli as a view then send data to presenter and processed with models then result go back to presenter to be viewed.
I tried to keep my code clear ,commented and professional as i can.

### Solution steps

* load data from config file inital products,currencies,offers,tax precentage
* parse user input to set cart and selected currency
* looping in list of cart products calculating subtotal
* calculate taxes from subtotal
* applying offer to the cart to get discounts
* calculate total by sum subtotal and taxes and subtract discounts if exist

## Why using Laravel-Zero
* i used laravel-zero only as a base to not start from scratch and handle cli arguments
* loading data from config
* other wise all writen in pure php

## Offers solution

i created structure of offers that make application scalable and do diffrenet types of offers

### offer structure

```
[
    'on'=>'Jacket',
    'value'=>50,
    'percentage'=>true,
    'rules'=>[
        'T-shirt'=>2,
    ]   
]
```
* on: on which offer affect
* value: precentage or value discounted
* percentage: is value discount percentage or only value
* rules: some rule offer checking to apply offer after that
        
## Currency Structure

```
[
    'currency'=>'USD',
    'symbol'=>'$',
    'position'=>'left',
    'value'=>1,
],
```
* currency: currency name as user input and working in model  as primary key for search query
* symbol: currency symbol to format prices
* position: currency format prices symbol position
* value: value of currency vs dollar example for EGP value=15.74

## Product Structure

```
[
    'name'=>'T-shirt',
    'price'=>'10.99'
]
```
* name: product name as user input and working in model  as primary key for search query
* price: price in default currency where value = 1 (shown above)

## Requirments

* php >= 7.3
* composer

## Run

run these command in project directory to run

``` composer install ```

``` php createbill --bill-currency=USD T-shirt T-shirt ```

## Build

run these command in project directory to build as exectable php file

``` composer install ```

``` php createbill app:build ```

``` cd build ```

``` php createbill --bill-currency=USD T-shirt T-shirt ```

## Tests

i faced problems with framework tests and i don't have enough experience with it

## Logging & Error Handling

application have well error handling and logging errors if it happend

## Screen Shot
![Screen Shot](https://i.imgur.com/kK2sDH1.png "Proof of work")
