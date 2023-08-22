<?php
$table->id();
$table->string('email')->unique();
$table->string('phone');
$table->string('full_name');
$table->string('password');


$table->id();
$table->string('name');


$table->id();
$table->string('name');
$table->string('description');
$table->foreignId('category_id')->references('id')->on('categories');
$table->decimal('price');
$table->string('image');

$table->id();
$table->foreignId('product_id')->references('id')->on('products');
$table->foreignId('user_id')->references('id')->on('users');
$table->unique(['product_id', 'user_id']);

$table->id();
$table->foreignId('product_id')->references('id')->on('products');
$table->foreignId('user_id')->references('id')->on('users');
$table->unique(['product_id', 'user_id']);


$table->id();
$table->foreignId('user_id')->references('id')->on('users');
$table->string('comment');
$table->string('contact_phone');


$table->id();
$table->foreignId('product_id')->references('id')->on('products');
$table->foreignId('order_id')->references('id')->on('orders');
$table->unique(['order_id', 'product_id']);
$table->integer('quantity');

$table->id();
$table->foreignId('user_id_from')->references('id')->on('users');
$table->foreignId('user_id_to')->references('id')->on('users');
$table->string('message');
