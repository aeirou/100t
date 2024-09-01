setTimeout(function () {
    let alert = bootstrap.Alert.getOrCreateInstance(document.querySelector(".alert"));
    if (alert) {
        alert.close();
    }
}, 10000);

// update cart item quantity in real time using ajax
if (window.location.pathname.endsWith("cart.php")) {
    $("input[name='qty']").change(function () {
    let newQuantity = $(this).val();
    let productId = $(this).data("product-id");

    $.ajax({
        url: "updatecart.php",
        type: "post",
        data: { quantity: newQuantity, product_id: productId },
        success: function () {
        location.reload(); // reloads the page
        },
    });
});
}

// for increment and decrement for quantity input for cart
// took out the limit for under 1 so user can take away items
$(document).ready(function () {
    $(".minus").click(function () {
      var $input = $(this).parent().find("input");
      var count = parseInt($input.val()) - 1;       
      $input.val(count);
      $input.change();
      return false;
    });
    $(".plus").click(function () {
      var $input = $(this).parent().find("input");
      $input.val(parseInt($input.val()) + 1);
      $input.change();
      return false;
    });
  });


