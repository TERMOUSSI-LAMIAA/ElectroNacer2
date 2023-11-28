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

//categorie
function openForm_add_cat() {
    document.querySelector('.dark').style.display = 'block';
    document.querySelector('.popup-form-add-cat').style.display = 'block';
}

function closeForm_add_cat() {
    document.querySelector('.dark').style.display = 'none';
    document.querySelector('.popup-form-add-cat').style.display = 'none';
}
// produit
function openForm_add_prd() {
    document.querySelector('.dark').style.display = 'block';
    document.querySelector('.popup-form-add-prod').style.display = 'block';
}

function closeForm_add_prd() {
    document.querySelector('.dark').style.display = 'none';
    document.querySelector('.popup-form-add-prod').style.display = 'none';
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