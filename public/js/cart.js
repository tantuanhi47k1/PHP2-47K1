const CART_KEY = 'techhub_cart';

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
        existingItem.quantity += parseInt(product.quantity);
    } else {
        cart.push(product);
    }

    saveCart(cart);
}

function updateCartBadge() {
    const cart = getCart();

    const totalQty = cart.length;

    const badges = document.querySelectorAll('.badge-cart');
    badges.forEach(el => {
        el.innerText = totalQty;

        if (totalQty > 0) {
            el.style.display = 'inline-block';
            el.innerText = totalQty;
        } else {
            el.style.display = 'none';
        }
    });
}

document.addEventListener('DOMContentLoaded', updateCartBadge);