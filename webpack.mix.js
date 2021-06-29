const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');

//UNIT
mix.js('resources/js/project_scripts/unit/index.js', 'public/js/unit');

//CUSTOMER
mix.js('resources/js/project_scripts/customer/index.js', 'public/js/customer');

//EXPENSE
mix.js('resources/js/project_scripts/expense/index.js', 'public/js/expense');

//PRODUCT
mix.js('resources/js/project_scripts/product/index.js', 'public/js/product');

//SUPPLIER
mix.js('resources/js/project_scripts/supplier/index.js', 'public/js/supplier');

//PURCHASE
mix.js('resources/js/project_scripts/purchase/index.js', 'public/js/purchase');

//SALE
mix.js('resources/js/project_scripts/sale/index.js', 'public/js/sale');

//CATEGORY
mix.js('resources/js/project_scripts/category/index.js', 'public/js/category');
