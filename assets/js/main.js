// function filterProducts() {
//     var category = document.getElementById("categories").value;

//     // Make an AJAX request
//     var xhr = new XMLHttpRequest();
//     xhr.onreadystatechange = function () {
//         if (xhr.readyState == 4 && xhr.status == 200) {
//             document.getElementById("filteredProducts").innerHTML = xhr.responseText;
//         }
//     };

//     // Send the request to your PHP script with the selected category
//     xhr.open("GET", "filter_products.php?category=" + category, true);
//     xhr.send();
// }

// add categorie
// function openForm_add_cat() {
//     document.querySelector('.dark').style.display = 'block';
//     document.querySelector('.popup-form-add-cat').style.display = 'block';
// }

// function closeForm_add_cat() {
//     document.querySelector('.dark').style.display = 'none';
//     document.querySelector('.popup-form-add-cat').style.display = 'none';
// }
//add updt categorie
function openForm_updt_cat() {
    document.querySelector('.popup-form-cat h2').textContent = 'Modifier le produit';
    document.querySelector('.popup-form-cat input[type="submit"]').value = 'Modifier';
    document.querySelector('.dark').style.display = 'block';
    document.querySelector('.popup-form-cat').style.display = 'block';
}
function openForm_add_cat() {
    document.querySelector('.popup-form-cat h2').textContent = 'Ajouter un produit';
    document.querySelector('.popup-form-cat input[type="submit"]').value = 'Ajouter';
    document.querySelector('.dark').style.display = 'block';
    document.querySelector('.popup-form-cat').style.display = 'block';
}
function closeForm_cat() {

    document.querySelector('.dark').style.display = 'none';
    document.querySelector('.popup-form-cat').style.display = 'none';
}
// add/updt produit
function openForm_updt_prd() {
    document.querySelector('.popup-form-prod h2').textContent = 'Modifier le produit';
    document.querySelector('.popup-form-prod input[type="submit"]').value = 'Modifier';
    document.querySelector('.dark').style.display = 'block';
    document.querySelector('.popup-form-prod').style.display = 'block';
}
function openForm_add_prd() {
    document.querySelector('.popup-form-prod h2').textContent = 'Ajouter un produit';
    document.querySelector('.popup-form-prod input[type="submit"]').value = 'Ajouter';
    document.querySelector('.dark').style.display = 'block';
    document.querySelector('.popup-form-prod').style.display = 'block';
}
function closeForm_prd() {

    document.querySelector('.dark').style.display = 'none';
    document.querySelector('.popup-form-prod').style.display = 'none';
}

//filter by cat and price
function filterProducts() {
    var selectedCategory = document.getElementById("categories").value;
    var minPrice = parseFloat(document.getElementById("minPrice").value) || 0;
    var maxPrice = parseFloat(document.getElementById("maxPrice").value) || Infinity;
    var tableRows = document.querySelectorAll("#productTableBody tr");

    tableRows.forEach(function(row) {
        var category = row.getAttribute("data-category");
        var price = parseFloat(row.getAttribute("data-price")) || 0;

        var categoryMatch = selectedCategory === "tout" || category === selectedCategory;
        var priceMatch = price >= minPrice && price <= maxPrice;

        if (categoryMatch && priceMatch) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}