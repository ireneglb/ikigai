"use strict";

document.addEventListener('DOMContentLoaded', function() {
    const showAddProductButton = document.getElementById("showAddProduct");
    const productForm = document.getElementById("productForm");
    
    const showAddImgButton = document.getElementById ("showAddImg");
    const uploadImg = document.getElementById("uploadImg");

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

    showAddImgButton.addEventListener("click", function(event) {
        event.preventDefault();
    
        if (uploadImg.style.display === "none" || uploadImg.style.display === "") {
            uploadImg.style.display = "block";
            showAddImgButton.textContent = "Annuler";
        } else {
            uploadImg.style.display = "none"; 
            showAddImgButton.textContent = "Ajouter une image";
        }
    });
});


