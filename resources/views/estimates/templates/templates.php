<script id="invoiceItemTemplate" type="text/x-jsrender">
    <tr>
        <th><input type="text" name="item[]" class="form-control item-name" required></th>
        <td><textarea name="description[]" class="form-control item-description"></textarea></td>
        <td><input type="text" name="quantity[]" class="form-control qty" min="0" required></td>
        <td><input type="text" name="rate[]" class="form-control rate" required></td>
        <td class="">
        <select name="tax[]" class="form-control tax-rates" multiple placeholder="Select Taxes">
                        </select>
                        </td>
        <td><i data-set-currency-class="true"></i> <span class="item-amount">0</span></td>
        <td><a href="#" class="remove-invoice-item text-danger"><i class="far fa-trash-alt"></i></a></td>
    </tr>

</script>

<script id="taxOptionsTemplate" type="text/x-jsrender">
    <option value="{{:value}}">{{:label}}</option>


</script>

<script id="taxesList" type="text/x-jsrender">
    <tr>
        <td colspan="2" class="font-weight-bold tax-value">{{:tax_name}}%</td>
        <td class="footer-numbers footer-tax-numbers">{{:tax_rate}}</td>
    </tr>


</script>

<script id="createAddressTemplate" type="text/x-jsrender">
    <span>{{:street}},<br>
    <span>{{:city}}, {{:state}},<br>
    <span>{{:country}} -</span>
    <span>{{:zip_code}}</span>




</script>

<script id="addressTemplate" type="text/x-jsrender">
    <span>{{:street}},<br>
    <span>{{:city}}, {{:state}},<br>
    <span>{{:country}} -</span>
    <span>{{:zip_code}}</span>


</script>
