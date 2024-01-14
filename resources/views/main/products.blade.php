<div class="product-card" id="product-card">
    @foreach($products as $product)
        <div class="product-item" id="product-item">
            <img src="{{ $product->image }}">
            <div class="product-list">
                <h3>{{ $product->name }}</h3>
                <h4>{{ $product->description }}</h4>
                <span class="price">{{ number_format($product->price , 2, ',', ' ') }} руб.</span>
                <button type="submit" class="add-button" name="button" data-id="{{ $product->id }}">В корзину</button>
            </div>
        </div>
    @endforeach
    <div id="notification-area"></div>
</div>
