<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seriniha - Peripherals</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Link to your CSS file -->
    <link rel="stylesheet" href="css/peripherals"> <!-- Update the CSS file path -->

    <script>
    $(document).ready(function() {
        // Enable tooltips
        $('[data-toggle="tooltip"]').tooltip();

        // Handle click event on peripheral images (similar to appliances)
        $('.pic_option div').click(function() {
            var peripheralName = $(this).find('p').eq(0).text().split(': ')[1];
            var peripheralPrice = parseFloat($(this).find('p').eq(1).text().split(': ')[1].replace('$', ''));
            var peripheralQuantityInput = $(this).find('input[name="quantity"]');
            var peripheralQuantity = parseInt(peripheralQuantityInput.val());

            // Check if the peripheral is already in the selected list
            var listItem = $('#selected_peripheral_list').find('li[data-name="' + peripheralName + '"]');
            if (listItem.length > 0) {
                // Peripheral is already in the list, update quantity and price
                var listItemQuantity = parseInt(listItem.attr('data-quantity'));
                listItemQuantity += peripheralQuantity;
                if (listItemQuantity > 0) {
                    listItem.attr('data-quantity', listItemQuantity);
                    listItem.find('.selected-quantity').text('Quantity: ' + listItemQuantity);
                    var listItemPrice = parseFloat(listItem.attr('data-price'));
                    listItemPrice += peripheralPrice * peripheralQuantity;
                    listItem.attr('data-price', listItemPrice);
                    listItem.find('.selected-price').text('Price: $' + listItemPrice.toFixed(2));
                } else {
                    // If quantity becomes 0, remove the item from the list
                    listItem.remove();
                }
            } else {
                // Peripheral is not in the list, add it
                var listItem = $('<li class="selected-item" data-name="' + peripheralName + '" data-quantity="' + peripheralQuantity + '" data-price="' + peripheralPrice * peripheralQuantity + '">' +
                    '<p>Name: ' + peripheralName + '</p>' +
                    '<p class="selected-price">Price: $' + (peripheralPrice * peripheralQuantity).toFixed(2) + '</p>' +
                    '<p class="selected-quantity">Quantity: ' + peripheralQuantity + '</p>' +
                    '</li>');
                $('#selected_peripheral_list').append(listItem);
            }
        });

        // Handle change event on peripheral quantity input fields (similar to appliances)
        $('.pic_option input[name="quantity"]').on('change', function() {
            var peripheralName = $(this).closest('div').find('p').eq(0).text().split(': ')[1];
            var peripheralQuantity = parseInt($(this).val());

            // Find the corresponding item in the selected list and update it
            var listItem = $('#selected_peripheral_list').find('li[data-name="' + peripheralName + '"]');
            if (listItem.length > 0) {
                if (peripheralQuantity > 0) {
                    // Update quantity and price
                    listItem.attr('data-quantity', peripheralQuantity);
                    listItem.find('.selected-quantity').text('Quantity: ' + peripheralQuantity);
                    var peripheralPrice = parseFloat($(this).closest('div').find('p').eq(1).text().split(': ')[1].replace('$', ''));
                    var listItemPrice = peripheralPrice * peripheralQuantity;
                    listItem.attr('data-price', listItemPrice);
                    listItem.find('.selected-price').text('Price: $' + listItemPrice.toFixed(2));
                } else {
                    // If quantity becomes 0, remove the item from the list
                    listItem.remove();
                }
            }
        });

        // Calculate bill (similar to appliances)
        $('#calculate_bill').click(function() {
            var totalPrice = 0;
            var totalQuantity = 0;

            // Calculate total price and quantity (similar to appliances)
            $('.selected-item').each(function() {
                var priceText = $(this).find('.selected-price').text().split(': ')[1];
                var quantityText = $(this).find('.selected-quantity').text().split(': ')[1];

                var price = parseFloat(priceText.replace('$', ''));
                var quantity = parseInt(quantityText);

                totalPrice += price;
                totalQuantity += quantity;
            });

            // Update input fields (similar to appliances)
            $('#price').val('$' + totalPrice.toFixed(2));
            $('#quantity').val(totalQuantity);
            $('#amount_to_pay').val('$' + totalPrice.toFixed(2));

            var customerCash = parseFloat($('#customer_cash').val());
            var changeAmount = customerCash - totalPrice;

            // Update change amount field (similar to appliances)
            if (!isNaN(changeAmount) && changeAmount >= 0) {
                $('#change_amount').val('$' + changeAmount.toFixed(2));
            } else {
                $('#change_amount').val('');
            }
        });

        // Clear order details and selected peripheral list (similar to appliances)
        $('#new_order').click(function() {
            $('#price').val('');
            $('#quantity').val('');
            $('#amount_to_pay').val('');
            $('#customer_cash').val('');
            $('#change_amount').val('');
            $('#selected_peripheral_list').empty();
            $('.pic_option input[name="quantity"]').val('0');
        });
    });
    </script>
</head>
<body>
    <div class="container page_border"> 
        <h1 style="text-align:center; margin-top:10px; font-size:70px; font-family:Algerian; color:black">
            Seriniha`s Point of Sale
        </h1>
        <h1>Welcome to Seriniha</h1>
    
        <form action="category.php" method="GET" class="mt-3">
            <div class="form-group">
                <label for="category">Select a category:</label>
                <select name="category" id="category" class="form-control">
                    <option value="burgers">Burgers</option>
                    <option value="pastries">Pastries</option>
                    <option value="peripherals" selected>Peripherals</option>
                    <option value="soda">Soda</option>
                    <option value="appliances">Appliances</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Go</button>
        </form>
        
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="pic_option d-flex flex-wrap justify-content-around">
                <div class="text-center mb-3"> 
                        <img src="peripheral_images/camera1.png" data-toggle="tooltip" data-placement="bottom" 
                        title="camera1" width="200" height="210" alt="camera1">
                        <p>Name: camera1</p>
                        <p>Price: $50</p>
                        <input type="number" name="quantity" value="0" min="0">
                    </div>
                    
                <div class="text-center mb-3"> 
                        <img src="peripheral_images/keyboard1.png" data-toggle="tooltip" data-placement="bottom" 
                        title="keyboard1" width="200" height="210" alt="keyboard1">
                        <p>Name: keyboard1</p>
                        <p>Price: $30</p>
                        <input type="number" name="quantity" value="0" min="0">
                        </div>
                <div class="text-center mb-3"> 
                        <img src="peripheral_images/keyboard2.png" data-toggle="tooltip" data-placement="bottom" 
                        title="keyboard2" width="200" height="210" alt="keyboard2">
                        <p>Name: keyboard2</p>
                        <p>Price: $40</p>
                        <input type="number" name="quantity" value="0" min="0">
                    </div>
                <div class="text-center mb-3"> 
                        <img src="peripheral_images/keyboard3.png" data-toggle="tooltip" data-placement="bottom" 
                        title="keyboard3" width="200" height="210" alt="keyboard3">
                        <p>Name: keyboard3</p>
                        <p>Price: $45</p>
                        <input type="number" name="quantity" value="0" min="0">
                </div>
                <div class="text-center mb-3"> 
                        <img src="peripheral_images/keyboard4.png" data-toggle="tooltip" data-placement="bottom" 
                        title="keyboard4" width="200" height="210" alt="keyboard4">
                        <p>Name: keyboard4</p>
                        <p>Price: $35</p>
                        <input type="number" name="quantity" value="0" min="0">
                </div>
                <div class="text-center mb-3"> 
                        <img src="peripheral_images/keyboard5.png" data-toggle="tooltip" data-placement="bottom" 
                        title="keyboard5" width="200" height="210" alt="keyboard5">
                        <p>Name: keyboard5</p>
                        <p>Price: $25</p>
                        <input type="number" name="quantity" value="0" min="0">
                </div>
                <div class="text-center mb-3"> 
                        <img src="peripheral_images/keyboard6.png" data-toggle="tooltip" data-placement="bottom" 
                        title="keyboard6" width="200" height="210" alt="keyboard6">
                        <p>Name: keyboard6</p>
                        <p>Price: $55</p>
                        <input type="number" name="quantity" value="0" min="0">
                </div>
                    <div class="text-center mb-3"> 
                        <img src="peripheral_images/monitor1.png" data-toggle="tooltip" data-placement="bottom" 
                        title="monitor1" width="200" height="210" alt="monitor1">
                        <p>Name: monitor1</p>
                        <p>Price: $150</p>
                        <input type="number" name="quantity" value="0" min="0">
                    </div>
                    <div class="text-center mb-3"> 
                        <img src="peripheral_images/monitor2.png" data-toggle="tooltip" data-placement="bottom" 
                        title="monitor2" width="200" height="210" alt="monitor2">
                        <p>Name: monitor2</p>
                        <p>Price: $200</p>
                        <input type="number" name="quantity" value="0" min="0">
                    </div>
                    <div class="text-center mb-3"> 
                        <img src="peripheral_images/monitor3.png" data-toggle="tooltip" data-placement="bottom" 
                        title="monitor3" width="200" height="210" alt="monitor3">
                        <p>Name: monitor3</p>
                        <p>Price: $180</p>
                        <input type="number" name="quantity" value="0" min="0">
                    </div>
                    <div class="text-center mb-3"> 
                        <img src="peripheral_images/monitor4.png" data-toggle="tooltip" data-placement="bottom" 
                        title="monitor4" width="200" height="210" alt="monitor4">
                        <p>Name: monitor4</p>
                        <p>Price: $250</p>
                        <input type="number" name="quantity" value="0" min="0">
                    </div>
                    <div class="text-center mb-3"> 
                        <img src="peripheral_images/mouse1.png" data-toggle="tooltip" data-placement="bottom" 
                        title="mouse1" width="200" height="210" alt="mouse1">
                        <p>Name: mouse1</p>
                        <p>Price: $20</p>
                        <input type="number" name="quantity" value="0" min="0">
                    </div>
                    <div class="text-center mb-3"> 
                        <img src="peripheral_images/mouse2.png" data-toggle="tooltip" data-placement="bottom" 
                        title="mouse2" width="200" height="210" alt="mouse2">
                        <p>Name: mouse2</p>
                        <p>Price: $25</p>
                        <input type="number" name="quantity" value="0" min="0">
                    </div>
                    <div class="text-center mb-3"> 
                        <img src="peripheral_images/mouse3.png" data-toggle="tooltip" data-placement="bottom" 
                        title="mouse3" width="200" height="210" alt="mouse3">
                        <p>Name: mouse3</p>
                        <p>Price: $15</p>
                        <input type="number" name="quantity" value="0" min="0">
                    </div>
                    <div class="text-center mb-3"> 
                        <img src="peripheral_images/mouse4.png" data-toggle="tooltip" data-placement="bottom" 
                        title="mouse4" width="200" height="210" alt="mouse4">
                        <p>Name: mouse4</p>
                        <p>Price: $30</p>
                        <input type="number" name="quantity" value="0" min="0">
                    </div>
                    <div class="text-center mb-3"> 
                        <img src="peripheral_images/mouse5.png" data-toggle="tooltip" data-placement="bottom" 
                        title="mouse5" width="200" height="210" alt="mouse5">
                        <p>Name: mouse5</p>
                        <p>Price: $18</p>
                        <input type="number" name="quantity" value="0" min="0">
                    </div>
                    <div class="text-center mb-3"> 
                        <img src="peripheral_images/mouse6.png" data-toggle="tooltip" data-placement="bottom" 
                        title="mouse6" width="200" height="210" alt="mouse6">
                        <p>Name: mouse6</p>
                        <p>Price: $22</p>
                        <input type="number" name="quantity" value="0" min="0">
                    </div>
                    <div class="text-center mb-3"> 
                        <img src="peripheral_images/printer1.png" data-toggle="tooltip" data-placement="bottom" 
                        title="printer1" width="200" height="210" alt="printer1">
                        <p>Name: printer1</p>
                        <p>Price: $120</p>
                        <input type="number" name="quantity" value="0" min="0">
                    </div>
                    <div class="text-center mb-3"> 
                        <img src="peripheral_images/printer2.png" data-toggle="tooltip" data-placement="bottom" 
                        title="printer2" width="200" height="210" alt="printer2">
                        <p>Name: printer2</p>
                        <p>Price: $150</p>
                        <input type="number" name="quantity" value="0" min="0">
                    </div>
                    <div class="text-center mb-3"> 
                        <img src="peripheral_images/printer3.png" data-toggle="tooltip" data-placement="bottom" 
                        title="printer3" width="200" height="210" alt="printer3">
                        <p>Name: printer3</p>
                        <p>Price: $100</p>
                        <input type="number" name="quantity" value="0" min="0">
                    </div>



                </div>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="selected-peripheral-tab">
                <h4>Selected Peripherals:</h4>
                <ul id="selected_peripheral_list"></ul>
            </div>
            <div class="order-details-tab">
                <h4>Order Details:</h4>
                <div>
                    <label for="price">Price:</label>
                    <input type="text" id="price" name="price" readonly>
                </div>
                <div>
                    <label for="quantity">Quantity:</label>
                    <input type="text" id="quantity" name="quantity" readonly>
                </div>
                <div>
                    <label for="amount_to_pay">Amount to Pay:</label>
                    <input type="text" id="amount_to_pay" name="amount_to_pay" readonly>
                </div>
                <div>
                    <label for="customer_cash">Customer Cash:</label>
                    <input type="text" id="customer_cash" name="customer_cash">
                </div>
                <div>
                    <label for="change_amount">Change Amount:</label>
                    <input type="text" id="change_amount" name="change_amount" readonly>
                </div>
                <button type="button" id="calculate_bill" class="btn btn-primary">Calculate Bill</button>
                <button type="button" id="new_order" class="btn btn-secondary">New Order</button>
            </div>
        </div>
    </div>
</body>
</html>
