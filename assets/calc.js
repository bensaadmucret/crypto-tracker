window.addEventListener('load', () => {
    //alert('Hello World!');
    const quantity = document.getElementById('form_quantity');
    const price = document.getElementById('form_price');
    const crypto = document.getElementById('form_name');
    
   if (quantity && crypto) {
         quantity.addEventListener('input', () => {
            const quantityValue = quantity.value;
            const priceValue = price.value;
            const cryptoValue = crypto.value;
            const total = quantityValue * cryptoValue;
            price.value = total;
        crypto.addEventListener('change', () => {
            const quantityValue = quantity.value;
            const priceValue = price.value;
            const cryptoValue = crypto.value;
            const total = quantityValue / cryptoValue;
            price.value = total;
        });
    });
}

    

});