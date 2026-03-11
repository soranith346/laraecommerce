document.addEventListener('DOMContentLoaded', function () {

    const productContainer = document.getElementById("productContainer");
    const paginationContainer = document.getElementById("pagination");
    const spinner = document.getElementById("spinner");
    const section = document.getElementById("latestProductsSection");

    const productDetailUrlTemplate = window.productDetailUrlTemplate;
    const productsUrl = window.productsUrl;

    // Create Product Card
    function productCard(product) {

        const detailUrl = productDetailUrlTemplate.replace(':id', product.id);

        return `
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="product-card">
                <div class="img-box">
                    <img src="${product.image 
                        ? '/uploads/' + product.image 
                        : '/noimage/noimage.png'}" 
                         class="img-fluid">

                    <div class="overlay">
                        <a href="${detailUrl}" class="btn btn-dark">
                            View Details
                        </a>
                    </div>
                </div>

                <div class="detail-box">
                    <h6>${product.product_name}</h6>
                    <p>$${parseFloat(product.price).toFixed(2)}</p>
                </div>
            </div>
        </div>
        `;
    }

    // Build Pagination
    function buildPagination(data) {

        if (data.last_page <= 1) {
            paginationContainer.innerHTML = '';
            return;
        }

        let html = '';

        // Previous
        if (data.current_page > 1) {
            html += `
            <button class="btn btn-outline-dark m-1"
                onclick="loadProducts(${data.current_page - 1})">
                Prev
            </button>`;
        }

        // Page Numbers
        for (let i = 1; i <= data.last_page; i++) {
            html += `
            <button class="btn btn-outline-dark m-1 
                ${i === data.current_page ? 'active' : ''}"
                onclick="loadProducts(${i})">
                ${i}
            </button>`;
        }

        // Next
        if (data.current_page < data.last_page) {
            html += `
            <button class="btn btn-outline-dark m-1"
                onclick="loadProducts(${data.current_page + 1})">
                Next
            </button>`;
        }

        paginationContainer.innerHTML = html;
    }

    // Load Products
    window.loadProducts = function (page = 1, scroll = true) {

        spinner.style.display = "block";

        fetch(`${productsUrl}?page=${page}`)
            .then(response => response.json())
            .then(data => {

                productContainer.innerHTML =
                    data.data.map(product => productCard(product)).join('');

                buildPagination(data);

                spinner.style.display = "none";

                if (scroll) {
                    window.scrollTo({
                        top: section.offsetTop - 80,
                        behavior: "smooth"
                    });
                }
            })
            .catch(error => {
                console.error("Error:", error);
                spinner.style.display = "none";
            });
    };

    // First Load
    loadProducts(1, false);
});