function filterProducts() {
    // Add your filtering logic here
    var price = document.getElementById("priceRange").value;
    alert("Filtering products with price less than or equal to $" + price);
    // You can update this alert with your actual filtering logic.
}

document.getElementById("priceRange").addEventListener("input", function() {
    document.getElementById("priceValue").innerHTML = "$" + this.value;
});