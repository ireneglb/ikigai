"use strict";

document.addEventListener('DOMContentLoaded', function() {
    const showAddProductButton = document.getElementById("showAddProduct");
    const productForm = document.getElementById("productForm");

    showAddProductButton.addEventListener("click", function(event) {
        event.preventDefault();

        if (productForm.style.display === "none" || productForm.style.display === "") {
            productForm.style.display = "block";
            showAddProductButton.textContent = "Annuler";
        } else {
            productForm.style.display = "none";
            showAddProductButton.textContent = "Ajouter un produit";
        }
    }); 
});

