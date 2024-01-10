var nextPage = 2; // Следующая страница для загрузки

document.getElementById('showmore-button').addEventListener('click', function() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/loadmoreproducts?page=' + nextPage, true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            var products = JSON.parse(xhr.responseText);
            var productContainer = document.getElementById('product-card');

            products.data.forEach(function(product) {
                var productItems = document.createElement('div');
                productItems.classList.add('product-item');
                // Код для отображения каждого продукта
                productItems.innerHTML = `
                                           <img src="${product.image}">
                                              <div class="product-list">
                                                 <h3>${product.name}</h3>
                                                 <h4>${product.description}</h4>
                                                  <span class="price">${new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB' }).format(product.price)}</span>
                                                 <button type="submit" class="add-button" name="button" data-id="${product.id}">В корзину</button>
                                              </div>
                                         `;

                productContainer.appendChild(productItems);
            });

            // Увеличить счетчик следующей страницы
            nextPage = products.current_page + 1;

            // Показать/скрыть кнопку "Показать еще" в зависимости от существования следующих страниц
            if (nextPage > products.last_page) {
                document.getElementById('showmore-bottom').style.display = 'none';
            }
        }
    };

    xhr.send();
});
