const CART_KEY = 'cart';

function getCart() {
    const cart = localStorage.getItem(CART_KEY);
    return cart ? JSON.parse(cart) : [];
}

function saveCart(cart) {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
    updateCartBadge();
}

function addToCart(product) {
    let cart = getCart();

    let existingItem = cart.find(item => 
        item.id == product.id && item.variant_id == product.variant_id
    );

    if (existingItem) {
        existingItem.quantity = parseInt(existingItem.quantity) + parseInt(product.quantity);
    } else {
        product.quantity = parseInt(product.quantity);
        cart.push(product);
    }

    saveCart(cart);
}

function updateCartBadge() {
    const cart = getCart();

    const totalItems = cart.length; 

    const badges = document.querySelectorAll('.badge-cart');
    badges.forEach(el => {
        el.innerText = totalItems;

        if (totalItems > 0) {
            el.style.display = 'inline-block';
            el.classList.remove('d-none'); 
        } else {
            el.style.display = 'none';
        }
    });
}

document.addEventListener('DOMContentLoaded', updateCartBadge);