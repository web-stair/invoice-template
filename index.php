<!DOCTYPE html>
<html lang="ar" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice Demo</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <div class="card my-3 shadow-lg">
        <div class="card-header">
          <h4 class="card-title fw-bold">
            Create new Invoice
          </h4>
        </div>
        <div class="card-body">
            <form action="process.php" method="POST">
                <div class="row">
                    <div class="col-6 form-group">
                        <label class="form-label" for="invoiceDate">Date</label>
                        <input type="text" class="form-control datepicker" name="invoice[date]" id="invoiceDate" required>
                    </div>
                    <div class="col-6 form-group">
                        <label class="form-label" for="invoiceCustomer">Customer</label>
                        <select class="form-select" name="invoice[customer_id]" id="invoiceCustomer" required>
                            <option value="">Select Customer</option>
                            <option value="1">Customer 1</option>
                            <option value="2">Customer 2</option>
                            <option value="3">Customer 3</option>
                        </select>
                    </div>
                </div>
                <div class="container my-3">
                    <div class="repeater">
                        <div class="repeater-header">
                            <div class="row">
                                <div class="col py-1 border">Item</div>
                                <div class="col py-1 border">Price</div>
                                <div class="col py-1 border">Qty</div>
                                <div class="col py-1 border">Total</div>
                                <div class="col-md-1 py-1 border">Delete</div>
                            </div>
                        </div>
                        <div class="repeater-items"></div>
                        <button type="button" class="btn btn-sm btn-secondary my-3" onclick="addItem(this)">
                            <i class="fas fa-plus"></i> Add Item
                        </button>
                        <div class="repeater-template d-none">
                            <div class="row item" data-number="__number__">
                                <div class="col py-2 border">
                                    <select class="form-select form-select-sm" __name__="items[__number__][item_id]" __required__>
                                        <option value="">Select item</option>
                                        <option value="1">Item 01</option>
                                        <option value="2">Item 02</option>
                                        <option value="3">Item 03</option>
                                    </select>
                                </div>
                                <div class="col py-2 border">
                                    <input type="number" class="form-control form-control-sm price" __name__="items[__number__][price]" onkeyup="calculateItem(this)" __required__>
                                </div>
                                <div class="col py-2 border">
                                    <input type="number" class="form-control form-control-sm qty" __name__="items[__number__][qty]" onkeyup="calculateItem(this)" __required__>
                                </div>
                                <div class="col py-2 border">
                                    <input type="number" class="form-control form-control-sm total" __name__="items[__number__][total]" value="0" readonly tabindex="-1" __required__>
                                </div>
                                <div class="col-md-1 py-2 border">
                                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteItem(this)"><i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <td valign="middle">Subtotal</td>
                                    <td valign="middle">
                                        <input type="number" class="form-control" name="invoice[subtotal]" id="subtotal" value="0" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle">VAT</td>
                                    <td valign="middle">
                                        <div class="input-group">
                                            <span class="input-group-text">%</span>
                                            <input type="number" class="form-control" id="vat" name="invoice[vat]" value="0" onkeyup="calculateTotals()">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle">Discount</td>
                                    <td valign="middle">
                                        <div class="input-group input-group-sm">
                                            <input type="number" class="form-control" id="discount" name="invoice[discount]" onkeyup="calculateTotals()" value="0">
                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="collapse" data-bs-target="#discountNotes"><i class="fas fa-edit"></i></button>
                                        </div>
                                        <div class="collapse form-group" id="discountNotes">
                                            <label class="form-label">Note</label>
                                            <input type="text" class="form-control form-control-sm" name="invoice[discount_note]">
                                        </div>
                                    </td>
                                </tr>
                                <tr class="bg-success">
                                    <td class="text-white" valign="middle">Paied</td>
                                    <td valign="middle">
                                        <input type="number" class="form-control" name="invoice[paied]" id="paied" value="0" onkeyup="calculateTotals()" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle">Total</td>
                                    <td valign="middle">
                                        <input type="number" class="form-control" name="invoice[total]" id="total" value="0" required>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-success mt-3">Save</button>
                </div>
            </form>
        </div>
      </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script type="text/javascript">
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd'
        }).datepicker('setDate', 'now');
        
        
        function addItem(button) {
            var $repeater   = $(button).parents('.repeater'),
                $itemsWrap  = $('.repeater-items', $repeater),
                $itemTmp    = $('.repeater-template', $repeater).html(),
                $lastItem   = $('.item:last', $itemsWrap),
                number      = $lastItem.data('number'),
                isValid     = $('[required]', $lastItem).filter(function() { return !this.value });

            number = number === undefined ? 0 : number+1;
            
            if( ! isValid.length ) {
                
                $itemTmp = $itemTmp.replace(/__number__/gi, number);
                $itemTmp = $itemTmp.replace(/__required__/gi, 'required');
                $itemTmp = $itemTmp.replace(/__name__/gi, 'name');
                
                $itemsWrap.append( $itemTmp );
                
                $('.item:last :input:first', $itemsWrap).focus();
            } else {
                $(':input:first', $lastItem).focus();
            }
        }
        
        function deleteItem(button) {
            var $row = $(button).parents('.item');
            
            if( confirm('Are you sure?') ) {
                $row.remove();
            }
        }
        
        function calculateItem(element) {
            var $row    = $(element).parents('.item'),
                $input  = $('.total', $row),
                price   = parseFloat( $('.price', $row).val() ) || 0,
                qty     = parseFloat( $('.qty', $row).val() ) || 0,
                total   = price * qty;
            
            $input.val( total );
            calculateSub();
        }
        
        function calculateSub() {
            var $items = $('.item .total'),
                $input = $('#subtotal'),
                subtotal = 0;
                
            $items.each(function() {
                subtotal += parseFloat( $(this).val() );
            });
            
            $input.val( subtotal );
            calculateTotals();
        }
        
        function calculateTotals() {
            var $input      = $('#total'),
                subtotal    = parseFloat( $('#subtotal').val() ) || 0,
                vat         = parseFloat( $('#vat').val() ) || 0,
                discount    = parseFloat( $('#discount').val() ) || 0,
                paied       = parseFloat( $('#paied').val() ) || 0,
                vatAmount   = (vat / 100) * subtotal,
                total       = subtotal + vatAmount - discount - paied;

            $input.val( total );

        }
        
    </script>

  </body>
</html>